
<?php
$return = array();
$return['ErrorStatus'] = "0";
$return['html'] = "";
$return['html2'] = "";
$test123="";
$jobid = $_POST['jobid'];
$fk_user_id = $_SESSION['user']['id'];

//add new job to the DB. Check for duplicates here and return error if necessary
$sql = "SELECT job_name FROM qc_pr_job_names WHERE fk_user_id = ? AND id = ?";
$args = array("ii", $fk_user_id, $jobid);
$conn = new database();

$job_credits = getCredits($fk_user_id);

$filename = $file['input_file'];
$path = "/imgs/quotecheck/uploads/";


if ($conn->connect_error) {
    $return = "Connection failed: " . $conn->connect_error;
} else if ($conn->query($sql, $args)) {

    $jobResults = $conn->all();
    if (count($jobResults) >0) {

        $job_name = $jobResults[0]['job_name'];

        $arrayOfFiles = array();
        $arrayOfFiles['quotes'] = listFilesTable("q", $fk_user_id, $jobid);
        $arrayOfFiles['invoices'] = listFilesTable("i", $fk_user_id, $jobid);


        $tableHTML = "
        <h4>File Details</h4>
        <table class='table'>
        <thead><tr>
        <th>Date/time of Upload</th>
        <th>Filetype</th>
        <th>Filename</th>
        <th>Uploaded By </th>
        <th>Wholesaler Name</th>
        <th>Template Name</th>
        <th>Preview</th>
        </tr></thead>
        <tbody>";

        if (count($arrayOfFiles['quotes'])>0 || count($arrayOfFiles['invoices'])>0){

            $path = "/imgs/quotecheck/uploads/";








            foreach ($arrayOfFiles['quotes'] as $file) {
              $sql2 = "SELECT wholesaler_name FROM qc_pr_wholesaler WHERE id = ?";
              $args2 = array("i", $file['fk_wholesaler_id']);
              $conn2 = new database();
              if ($conn2->connect_error) {
                  $return = "Connection failed: " . $conn2->connect_error;
              } else if ($conn2->query($sql2, $args2)) {
                  $wh_name = $conn2->all();
                  $wh_name2 = json_encode($wh_name);
                //$wh_name['wholesaler_name']

              }
              $sql3 = "SELECT username FROM qc_users WHERE id = ?";
              $args3 = array("i", $file['fk_user_id']);
              $conn3 = new database();
              if ($conn3->connect_error) {
                  $return = "Connection failed: " . $conn3->connect_error;
              } else if ($conn3->query($sql3, $args3)) {
                  $user_name = $conn3->all();
                  $user_name2 = json_encode($user_name);
                //$wh_name['wholesaler_name']

              }
              $sql4 = "SELECT name FROM qc_pr_wholesaler_doc WHERE id = ?";
              $args4 = array("i", $file['fk_doc_id']);
              $conn4 = new database();
              if ($conn4->connect_error) {
                  $return = "Connection failed: " . $conn4->connect_error;
              } else if ($conn4->query($sql4, $args4)) {
                  $template_name = $conn4->all();
                  $template_name2 = json_encode($user_name);
                //$wh_name['wholesaler_name']

              }

                ////////
                $path_file = $path.$file['input_file'];
                $modalID = "#modalPreview_".$path_file;
                $rowHTML = "<tr>".
                "<td>".$file['upload_time']."</td>".
                "<td>Quote</td>".
                "<td>".$file['old_name']."</td>".
                "<td>".$user_name[0]["username"]."</td>".
                "<td>".$wh_name[0]["wholesaler_name"]."</td>".
                "<td>".$template_name[0]["name"]."</td>".
                "<td><button type='button' class='btn btn-success previewbutton' data-src='".$path_file."' data-toggle='modal' data-target='#mymodalID'>Preview</button></td>".

                //"<a href='".$modalID."' data-lightbox='inline' class='btn btn-default btn-lg'>Preview</a>".
                "</tr>";
                $tableHTML .= $rowHTML;
                $test123 .= $file;

            }

            $rowHTML = "";
            foreach ($arrayOfFiles['invoices'] as $file) {
              $sql2 = "SELECT wholesaler_name FROM qc_pr_wholesaler WHERE id = ?";
              $args2 = array("i", $file['fk_wholesaler_id']);
              $conn2 = new database();
              if ($conn2->connect_error) {
                  $return = "Connection failed: " . $conn2->connect_error;
              } else if ($conn2->query($sql2, $args2)) {
                  $wh_name = $conn2->all();
                  $wh_name2 = json_encode($wh_name);

                //$wh_name['wholesaler_name']

              }

              $sql3 = "SELECT username FROM qc_users WHERE id = ?";
              $args3 = array("i", $file['fk_user_id']);
              $conn3 = new database();
              if ($conn3->connect_error) {
                  $return = "Connection failed: " . $conn3->connect_error;
              } else if ($conn3->query($sql3, $args3)) {
                  $user_name = $conn3->all();
                  $user_name2 = json_encode($user_name);
                //$wh_name['wholesaler_name']

              }

              $sql4 = "SELECT name FROM qc_pr_wholesaler_doc WHERE id = ?";
              $args4 = array("i", $file['fk_doc_id']);
              $conn4 = new database();
              if ($conn4->connect_error) {
                  $return = "Connection failed: " . $conn4->connect_error;
              } else if ($conn4->query($sql4, $args4)) {
                  $template_name = $conn4->all();
                  $template_name2 = json_encode($user_name);
                //$wh_name['wholesaler_name']

              }




//$doc_id=<%=$file['id']
              ////
                $path_file = $path.$file['input_file'];
                $modalID = "#modalPreview_".$path_file;

                $rowHTML = "<tr>".
                "<td>".$file['upload_time']."</td>".
                "<td>Invoice</td>".
                "<td>".$file['old_name']."</td>".
                "<td>".$user_name[0]["username"]."</td>".
                "<td>".$wh_name[0]["wholesaler_name"]."</td>".
                "<td>".$template_name[0]["name"]."</td>".
                "<td><button type='button' class='btn btn-success previewbutton' data-src='".$path_file."' data-toggle='modal' data-target='#mymodalID'>Preview</button></td>".

                "<td><a class='btn btn-success previewbutton' href ='/output_example?output_inv_id=".$file['id']."'>Results</a></td>".
                "</tr>";
                $tableHTML .= $rowHTML;
            }

            $tableHTML .= "</tbody></table>";


        }
        else {
            $tableHTML = "
            <h4>File Details</h4>
            <table class='table'>
            <thead><tr>
            <th>Date/time of Upload</th>
            <th>Filetype</th>
            <th>Filename</th>
            <th>Uploaded By </th>
            <th>Wholesaler Name</th>
            <th>Template Name</th>
            <th>Preview</th>
            </tr></thead>
            <tbody>";
            $tableHTML .= "<tr class='text-danger'><td style='border-bottom:initial!important;' colspan='7'>No Files Uploaded</td></tr></tbody></table>";
        }
    } else {
        $tableHTML = "<h3>No Job Details Found</h3>";
    }

    $return['html'] = $tableHTML;
    $return['html2'] = $test123;
} else {
    $return['ErrorStatus'] = "Error: " . $sql . "<br>" . $conn->error;
}
die(json_encode($return));
?>



<?php
// function listFiles($filetype, $fk_user_id, $jobid) {
//     if ($filetype=="q") {
//         $tableName = "qc_pr_quotes";
//     } else {
//         $tableName = "qc_pr_invoices";
//     }
//
//     $sql = "SELECT * FROM $tableName WHERE fk_user_id = ? AND fk_job_id = ?";
//     $args = array("ii", $fk_user_id, $jobid);
//     $conn = new database();
//     if ($conn->query($sql,$args)){
//         $files = $conn->all();
//         $filecounter = count($files);
//         echo "<h4> $filecounter file(s) uploaded:</h4>";
//         foreach ($files as $file) {
//             showFileInfo($file);
//         }
//     }
// }

function listFilesTable($filetype, $fk_user_id, $jobid) {
    $returnArray = array();
    if ($filetype=="q") {
        $tableName = "qc_pr_quotes";
    } else {
        $tableName = "qc_pr_invoices";
    }
    $sql = "SELECT * FROM $tableName WHERE fk_user_id = ? AND fk_job_id = ?";
    $args = array("ii", $fk_user_id, $jobid);
    $conn = new database();
    if ($conn->query($sql,$args)){
        $files = $conn->all();
        // $filecounter = count($files);
        // echo "<h4> $filecounter file(s) uploaded:</h4>";
        foreach ($files as $file) {

          array_push($returnArray, $file);
        }

    }
/*
    $sql = "SELECT wholesaler_name FROM qc_pr_wholesaler WHERE id = ?";
    $args = array("i", $wholesaler_id);
    $conn = new database();
    if ($conn->query($sql,$args)){
        $files = $conn->all();
        // $filecounter = count($files);
        // echo "<h4> $filecounter file(s) uploaded:</h4>";
        foreach ($files as $file) {
            array_push($returnArray, $file);
        }
    }
    $sql = "SELECT name FROM qc_pr_wholesaler_doc WHERE id = ?";
    $args = array("i", $template_id);
    $conn = new database();
    if ($conn->query($sql,$args)){
        $files = $conn->all();
        // $filecounter = count($files);
        // echo "<h4> $filecounter file(s) uploaded:</h4>";
        foreach ($files as $file) {
            array_push($returnArray, $file);
        }
    }
    */
    return $returnArray;
}
// function showFileInfo($file) {
//     $fileid = $file['id'];
//     $filename = $file['input_file'];
//     echo "<row>";
//     echo "<p>$fileid : $filename</p>";
//     $path = "/imgs/quotecheck/uploads/";
//     echo '<img style="width: 20%"" src="'.$path.$filename.'">';
//     echo "</row>";
// }

// function showFileInfoTable($file) {
    // $fileid = $file['id'];
    // $filename = $file['input_file'];
    // $upload_date = $file['date'];
    //
    // echo "<tr>";
    // echo "<td>$date</td>";
    // echo "<td>$filetype</td>";
    // echo "<td>$filename</td>";
    // echo "<td>$username</td>";
    // echo "<td>Wholesaler</td>";
    // echo "<td>Template Name</td>";
    // echo "<td><a href='$path.$filename'</td>"; // needs to be in a pop-out box
    // echo "</tr>";

    // $path = "/imgs/quotecheck/uploads/";
    // echo '<img style="width: 20%"" src="'.$path.$filename.'">';
    // echo "</row>";
// }

function getCredits($user_id) {
    $tablename = "qc_users";
    $sql = "SELECT credits FROM $tablename WHERE id = ?";
    $args = array("i", $user_id);
    $conn = new database();

    if ($conn->query($sql,$args)) {
        $data = $conn->all();
        $credits = $data[0]['credits'];
        return $credits;
    }else {
        return 0;
    }
    $conn=null;
}

?>
