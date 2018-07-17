<?php
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//                                 QUOTE CHECK                                      //
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//get_upload_time_from_id("37", "quotes");

function get_upload_time_from_id($id, $quote_or_invoice) {
  $quote_or_invoice = "qc_pr_".$quote_or_invoice;
  $sql = "select upload_time from ".$quote_or_invoice." where id = ?";
	$args = array("s", $id);
	$db = new database();
	$db->query($sql, $args);
	$data = $db->all();
          ?>
          <div value=<?php echo"$id"?>><?php echo $data[0][upload_time];?></div>
          <?php
}

cycle_through_wholesalers();
function cycle_through_wholesalers(){
  $sql = "SELECT id FROM qc_pr_wholesaler";
  $args = array();
  $db = new database();
  $db->query($sql, $args);

  $Results = $db->all();

  if (count($Results) >0) {

    foreach ($Results as $value) {
      $id = $value["id"];

      $resultsArray = get_wholesaler_info($id);

      echo "<pre>";
      print_r($resultsArray);
      echo "</pre>";
    }
  }else {
    echo "no wholesalers";
    $db = null;
  }
  $db = null;
}
function get_wholesaler_info($wholesaler_id){
  $sql = "SELECT * FROM qc_pr_wholesaler WHERE id = ?";
  $args = array("s",$wholesaler_id);
  $db = new database();
  $db->query($sql, $args);

  $resultsArray = array();
  $Results = $db->all();


  $resultsArray["wholesaler_name"] = $Results[0]["wholesaler_name"];
  $resultsArray["wholesaler_id"] = $wholesaler_id;
  $resultsArray["documents"] = get_wholesaler_info_doc($wholesaler_id);


  return($resultsArray);



}
function get_wholesaler_info_doc($wholesaler_id){
  $sql = "SELECT * FROM qc_pr_wholesaler_doc WHERE fk_wholesaler_id = ?";
  $args = array("s",$wholesaler_id);
  $db = new database();
  $db->query($sql, $args);

  $resultsArray = array();
  $documentArray = array();

  $Results = $db->all();
  if (count($Results) >0) {
    foreach ($Results as $value) {
      $documentArray["id"] = $value["id"];
      $documentArray["name"] = $value["name"];
      array_push($resultsArray, $documentArray);
    }
  }
return($resultsArray);
}


/*
get_all_wholesaler_infomation();
function get_all_wholesaler_infomation() {
  $sql = "SELECT * FROM qc_pr_wholesaler";
  $args = array("");
  $conn1 = new database();

  if ($conn1->connect_error) {
  } else if ($conn1->query($sql, $args)) {
    $Results = $conn1->query($sql, $args);
    while (count($Results) <= 10){

      $mainHTML = $conn1;
      $return['html1'] = $mainHTML;
      $conn1 = null;
    }
    } else {
      $mainHTML = "<h4>Error A1</h4>";
      $return['html1'] = $mainHTML;
    }



  $sql = "SELECT * FROM qc_pr_wholesaler_doc";
  $args = array("");
  $conn2 = new database();
  if ($conn2->connect_error) {
  } else if ($conn2->query($sql, $args)) {
    $wholesalerResults2 = $conn2->all();
    $row_count_for_foreach = 1;
    if (count($wholesalerResults2) >0) {
      $mainHTML = $conn2;
      $return['html2'] = $mainHTML;
      $conn2 = null;
    } else {
      $mainHTML = "<h4>Error A1</h4>";
      $return['html2'] = $mainHTML;
    }
  } else {
    $return['ErrorStatus'] = "Error: " . $sql . "<br>" . $conn->error;
  }


  $sql = "SELECT * FROM qc_pr_wholesaler_doc_col";
  $args = array("");
  $conn3 = new database();

  if ($conn3->connect_error) {
  } else if ($conn3->query($sql, $args)) {
    $wholesalerResults3 = $conn3->all();
    $row_count_for_foreach = 1;
    if (count($wholesalerResults3) >0) {
      $mainHTML = $conn3;
      $return['html3'] = $mainHTML;
      $conn3 = null;
    } else {
      $mainHTML = "<h4>Error A1</h4>";
      $return['html3'] = $mainHTML;
    }
  } else {
    $return['ErrorStatus'] = "Error: " . $sql . "<br>" . $conn->error;
  }
  json_encode($return);
  json_decode($return);
  echo "<pre>";
  print_r($return);
  echo "</pre>";

}
*/
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//                                 ONELAW                                           //
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//                                 OTHER                                            //
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////

?>
