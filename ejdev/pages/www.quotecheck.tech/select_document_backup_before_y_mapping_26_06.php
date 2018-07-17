
<?php
$docid = $_POST['docid'];
$sql = "SELECT col_text , x_right, x_left , y , id, width FROM qc_pr_wholesaler_doc_col WHERE fk_doc_id = ?";
$args = array("i", $docid);
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
        ?>

        <table style="width: 100%; background:#ededed;"> <!-- jack - can we show this background colour to fade in the lower td tags? -->
            <thead>
                <tr>
                <?php
                $col_count = 0;
                foreach ($wholesalerResults3 as $row) {
                    $col_count++;
                    $col_text = $row["col_text"];
                    $x_left = $row["x_left"];
                    $x_right = $row["x_right"];
                    $width = $row["width"];
                    $y = $row["y"];
                    $id = $row["id"];
                    $row_count_for_foreach++;
                    ?>
                    <th id="ID-<?php echo $id?> X:<?php echo  $x?> Y:<?php echo $y?>">
                        <?php echo "$col_text"?>
                    </th>
                    <?php
                }
                ?>
            </tr>
        </thead>

        <?php
        echo "<tr style='background: linear-gradient(#ededed, #fff);'> ";
//        for ($x = $col_count; $x >= 1; $x--) {
        for ($blankCellIdx = 0; $blankCellIdx < $col_count; $blankCellIdx++) {
            echo "<td style='border-bottom: 0px; height: 40px;'></td>";
        };
        echo "</tr>";
        ?>

        <tr>
        </tr>
    </table>
    <style>
    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }
</style>
<?php

$mainHTML = ob_get_contents();
ob_end_clean();


$return['html3'] = $mainHTML;

ob_start();
?>

<div id="2413" style="background-image:url(/imgs/quotecheck/uploads/Test_table2.jpg); background-repeat:no-repeat; background-size: 100%; width:750px;  height:495px; !important" class=" containment-wrapper">
    <div id ="ID_Top_Margin" name="ID_Top_Margin_name" style="opacity: 0.5; height:100px; padding:0px; width:750px; margin: 0 0 0 0;" class="draggable resizable ui-widget-content ui-resizable"></div>
    <div id ="ID_Left_Margin" name="ID_Left_Margin_name" style="opacity: 0.5; height:295px; padding:0px; width:10px; margin: 0 0 0 0;" class="draggable resizable ui-widget-content ui-resizable"></div>
        <?php
        $col_count = 0;
        foreach ($wholesalerResults3 as $row) {
            $col_count++;
            $col_text = $row["col_text"];
            $x_left = $row["x_left"];
            $x_right = $row["x_right"];
            $y = $row["y"];
            $id = $row["id"];
            $width = $row["width"];
            $row_count_for_foreach++;
            ?>
            <div id ="ID_<?php echo $id?>" name=" ID_<?php echo $id?> X_left:<?php echo  $x_left?> X_right:<?php echo  $x_right?> Y:<?php echo $y?>" style="opacity: 0.5; height:295px; padding:0px; width:<?php echo $width ?>px; margin: 0 0 0 0;" class="draggable resizable ui-widget-content ui-resizable">
                <?php echo "$col_text"?>
            </div>
            <?php
        }
        ?>
        <div id ="ID_Right_Margin" name="ID_Right_Margin_name" style="opacity: 0.5; height:295px; padding:0px; width:10px; margin: 0 0 0 0;" class="draggable resizable ui-widget-content ui-resizable"></div>
        <div id ="ID_Bottom_Margin" name="ID_Bottom_Margin_name" style="opacity: 0.5; height:100px; padding:0px; width:750px; margin: 0 0 0 0;" class="draggable resizable ui-widget-content ui-resizable"></div>

</div>
<?php
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Resizable - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style>
  .resizable { width: 150px; height: 150px; padding: 0.5em; }
  .resizable h3 { text-align: center; margin: 0; }
  </style>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( ".resizable" ).resizable();
  } );

  </script>
</head>
<body>

  <!-- <form id="qc_upload_template_cords" method="post" action="qc_upload_template_cords" enctype="multipart/form-data"> -->
      <div class="container">
          <div class="row">

          </div>
          <div class="row">
              <div class="col-xs-12">
                  <div class="col-xs-12">
                      <div class= "input_group">

                          <div class="col-sm-12 col-xs-2"  style="margin-left: 0px !important;width:40%; padding: 0px 0px 0px 0px;">
                              <button id="update_col" class="input-group-btn btn btn-primary btn-file update_col" style="width: 100%; min-width:45px; ; padding: 0px 0px 0px 0px !important; display:inline; margin-left: 0px;" type="update_col">Save Layout</button>
                          </div>
                      </div>
                  </div>
              </div>
          </div> <!--row -->
      </div> <!--container -->
  <!-- </form> -->
<script>

        $("#update_col").click(function(){
        update_col();
        });

        function get_width(){
        var id_arr = [];
        var wid_arr = [];
        $( ".resizable" ).each(function(index) {
        var col_id =( index + ": " + $( this ).attr('id'));
        var col_width =( index + ": " + $( this ).width());
        id_arr.push(col_id,);


        wid_arr.push(col_width);
      });
        return [id_arr, wid_arr];
      };

                function update_col(){
                  /*var id_width_array = get_width();
                  var col_id = id_width_array[0];
                  var col_width = id_width_array[1];
                  alert(col_id);
                  alert(col_width);*/

                  var id_arr = [];
                  var wid_arr = [];
                  var test_arr =[];
                  $( ".resizable" ).each(function(index) {
                  var col_id =($( this ).attr('id'));
                  var col_width =($( this ).width());
                  col_width += 2;
                  var test =  col_id + col_width;

                  id_arr.push(col_id);

                  wid_arr.push(col_width);
                });



                    var info = [id_arr,wid_arr];

                      $.ajax({
                          type: "POST",
                          url: " qc_upload_template_cords",
                          data: {info,info},
                          cache: false,
                          success: function(html) {
                            alert("template saved");
                          }

                      });
                };

</script>

</body>
</html>
<?php
$mainHTML2 = ob_get_contents();
ob_end_clean();


$return['html4'] = $mainHTML2;







$conn3 = null;
//
} else {


    $mainHTML = "<h4>No Column Headers Defined - Add a new Column Header</h4>";
    $return['html3'] = $mainHTML;
    $return['html4'] = $mainHTML;
}
} else {
    $return['ErrorStatus'] = "Error: " . $sql . "<br>" . $conn->error;
}









die(json_encode($return));

?>
