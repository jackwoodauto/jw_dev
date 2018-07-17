
<?php
    $wholesalerid = $_POST['wholesalerid'];
    $sql = "SELECT col_text , x , y , id FROM qc_pr_col_headers WHERE fk_doc_id = ?";
    $args = array("i", $wholesalerid);
    $conn3 = new database();

    if ($conn3->connect_error) {
    } else if ($conn3->query($sql, $args)) {
    $wholesalerResults3 = $conn3->all();

    $row_count_for_foreach = 1;
    if (count($wholesalerResults3) >0) {

      //  $fk_job_id = $wholesalerResults2[0]['fk_doc_id'];
      //  $idcheck = $wholesalerResults2[0]['id'];


              // output data of each row
    //          while($row = $result->fetch_assoc()) {

  //               $fk_job_id = $row["fk_doc_id"];
  //               $idcheck = $row["id"];

               ///echo"blog_title: " . $row["blog_title"]. "picture_id:" . $row["picture_id"]. "blog_text:" . $row["blog_text"]. "author:" . $row["author"]. "<br>";
      ob_start();

      foreach ($wholesalerResults3 as $row) {
                  $col_text = $row["col_text"];
                  $x = $row["x"];
                  $y = $row["y"];
                  $id = $row["id="];
                  $row_count_for_foreach++;
      ?>

    <div class="container-fluid center clearfix">
        <div class="row">
            <div class="col-sm-12">
                <h2>  Wholesaler col info: <?php echo "$id"?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <h3>Wholesaler id:
                    <?php echo "$id"?>
                </h3>
            </div>
            <div class="col-sm-6">
                <h3>Wholesaler X,Y,Text:
                    <?php echo " $x"?> <?php echo "$y"?> <?php echo "$col_text"?>
                </h3>
            </div>
        </div>
    </div>
      <?php
    }







      $mainHTML = ob_get_contents();
      ob_end_clean();


      $return['html3'] = $mainHTML;
      $conn3 = null;
  //
    } else {


        $mainHTML = "<h3>No col Uploaded def </h3>";
        $return['html3'] = $mainHTML;
    }
    } else {
    $return['ErrorStatus'] = "Error: " . $sql . "<br>" . $conn->error;
    }









    die(json_encode($return));

?>
