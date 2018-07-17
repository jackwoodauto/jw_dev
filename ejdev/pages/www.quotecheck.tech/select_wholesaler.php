
<?php
    $return = array();
    $return['ErrorStatus'] = "0";
    $return['html'] = "";

    $wholesalerid = $_POST['wholesalerid'];
    $fk_user_id = $_SESSION['user']['id'];

    //add new wholesaler to the DB. Check for duplicates here and return error if necessary
    $sql = "SELECT wholesaler_name FROM qc_pr_wholesaler";  // WHERE fk_user_id = ? AND id = ?
  //  $args = array("ii", $fk_user_id, $wholesalerid);
    $conn = new database();

    if ($conn->connect_error) {
        $return = "Connection failed: " . $conn->connect_error;
    } else if ($conn->query($sql, $args)) {

        $wholesalerResults = $conn->all();
        if (count($wholesalerResults) >0) {
            $wholesaler_name = $wholesalerResults[0]['wholesaler_name'];

            ob_start();
            ?>

            <section id="content <?php echo"$wholesaler_name"?>" style="margin-bottom: 0px;">
                <div class="container-fluid center clearfix">
                    <div class="row">
                        <div class="col-sm-12">
                            <h2>Wholesaler Status</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <h3>Wholesaler Name:
                                <?php echo "$wholesaler_name"?>
                            </h3>
                        </div>
                        <div class="col-sm-6">
                            <h3>Wholesaler ID:
                                <?php echo "$wholesalerid"?>
                            </h3>
                        </div>
                    </div>
                </div>
            </section>
            <?php
            $mainHTML = ob_get_contents();
            ob_end_clean();
            $return['html'] = $mainHTML;

            $conn = null;







        } else {


            $mainHTML = "<h3>No Files Uploaded </h3>";
            $return['html'] = $mainHTML;
        }
    } else {
        $return['ErrorStatus'] = "Error: " . $sql . "<br>" . $conn->error;
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




    $sql = "SELECT fk_wholesaler_id , name , id FROM qc_pr_wholesaler_doc WHERE fk_wholesaler_id= ?";
    $args = array("i", $wholesalerid);
    $conn2 = new database();

    if ($conn2->connect_error) {

    } else if ($conn2->query($sql, $args)) {



    $wholesalerResults2 = $conn2->all();

    $row_count_for_foreach = 1;
    if (count($wholesalerResults2) >0) {

      //  $fk_job_id = $wholesalerResults2[0]['fk_doc_id'];
      //  $idcheck = $wholesalerResults2[0]['id'];


              // output data of each row
    //          while($row = $result->fetch_assoc()) {

  //               $fk_job_id = $row["fk_doc_id"];
  //               $idcheck = $row["id"];

               ///echo"blog_title: " . $row["blog_title"]. "picture_id:" . $row["picture_id"]. "blog_text:" . $row["blog_text"]. "author:" . $row["author"]. "<br>";
      ob_start();

      foreach ($wholesalerResults2 as $row) {
                  $nameabc = $row["name"];
                  $idcheck = $row["id"];
                  $fk_wholesaler_id = $row["fk_wholesaler_id"];
                  $row_count_for_foreach++;
      ?>
    <option value="<?php echo $idcheck ?>"><?php echo "$nameabc"?></option>
      <?php
    }

      $mainHTML = ob_get_contents();
      ob_end_clean();


      $return['html2'] = $mainHTML;
      $conn2 = null;
  //  }

    } else {


        $mainHTML = "<h3>No Files Uploaded abc </h3>";
        $return['html2'] = $mainHTML;
    }
    } else {
    $return['ErrorStatus'] = "Error: " . $sql . "<br>" . $conn->error;
    }









    die(json_encode($return));

?>
