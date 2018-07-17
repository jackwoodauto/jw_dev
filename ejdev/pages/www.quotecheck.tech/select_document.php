
<?php
$docid = $_POST['docid'];
$db_get_pic_results = "no_img";

$sql = "SELECT drag_map_picture, height, width FROM qc_pr_wholesaler_doc WHERE id = ?";
$args = array("i", $docid);
$db_get_pic = new database();
$db_get_pic->query($sql, $args);
$get_pic_array = $db_get_pic->all();


$db_get_pic_results = $get_pic_array[0]['drag_map_picture'];
$height_of_background = $get_pic_array[0]['height'];
$width_of_background = $get_pic_array[0]['width'];

if ($db_get_pic_results != 0){
$db_get_pic_results = "/imgs/quotecheck/uploads/upload_image_below.jpg";
} else {
$db_get_pic_results = "/imgs/quotecheck/uploads/".$db_get_pic_results;
}










$sql = "SELECT col_text , x_right, x_left , y_top, y_bottom, id, width, height, position FROM qc_pr_wholesaler_doc_col WHERE fk_doc_id = ?";
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
        <style>
            .margin_class {float: left; opacity: 0.9;  padding:0px; margin: 0 0 0 0;}
        </style>
        <div id="2413" style="background-image:url(<?php echo $db_get_pic_results ?>); background-repeat:no-repeat; background-size: 100%; width:<?php echo $width_of_background?>px;  height:<?php echo $height_of_background?>px; !important" class=" containment-wrapper">


            <?php
            $col_count = 0;
            $left_margin_right = 0;
            foreach ($wholesalerResults3 as $row) {
                if ($left_margin_right_x == 0) {
                    $left_margin_right_x   = min(array_column($wholesalerResults3 , 'x_left'));;

                    $height = $row["height"];
                    $top_margin_bottom_y = $row["y_top"];
                    ?>
                    <div id ="ID_Top_Margin" name="ID_Top_Margin_name" style="height:<?php echo $top_margin_bottom_y?>px; width:<?php echo $width_of_background?>px;" class="resizable_top ui-widget-content ui-resizable margin_class"></div>
                    <div id ="row_of_cols">
                    <div id ="ID_Left_Margin" name="ID_Left_Margin_name" style="height:<?php echo $height?>px; width:<?php echo $left_margin_right_x?>px;" class="resizable ui-widget-content ui-resizable also margin_class"></div>
                    <?php
                }
                $position = $row['position'];
                $col_text = $row["col_text"];
                $x_left = $row["x_left"];
                $x_right = $row["x_right"];

                $id = $row["id"];
                $width = $row["width"];
                ?>
                <div id ="ID_<?php echo $id ?>" name="POS_<?php echo $position?> X_left:<?php echo  $x_left?> X_right:<?php echo  $x_right?>" style="float: left; opacity: 0.5; height:<?php echo $height?>px; padding:0px; width:<?php echo $width ?>px; margin: 0 0 0 0;" class="resizable ui-widget-content ui-resizable also">
                    <?php echo "$col_text"?>
                </div>
                <?php


                $right_margin_left_x = $row["x_right"];
                $y_bottom =  $row["y_bottom"];


                $position = $position + 1;
                $bottom_margin_height = $height_of_background - $y_bottom;
            }


$right_margin_left_x  = max(array_column($wholesalerResults3 , 'x_right'));;
$right_margin_left_x = $width_of_background -  $right_margin_left_x;


            ?>


            </div>
            <div id ="ID_Right_Margin" name="ID_Right_Margin_name" style="height:<?php echo $height?>px; width:<?php echo $right_margin_left_x; ?>px;" class="resizable ui-widget-content ui-resizable also margin_class"></div>

            <div id ="ID_Bottom_Margin" name="ID_Bottom_Margin_name" style="height:<?php echo $bottom_margin_height ?>px; width:<?php echo $width_of_background?>px;" class="resizable_top ui-widget-content ui-resizable margin_class"></div>

        </div>
        <?php
        ?>



            <title>jQuery UI Resizable - Default functionality</title>
            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <link rel="stylesheet" href="/resources/demos/style.css">
            <style>
            .resizable { width: 150px; height: 150px; padding: 0.5em; }
            .resizable h3 { text-align: center; margin: 0; }
            .margin_class {float: left; opacity: 0.9;  padding:0px; margin: 0 0 0 0;}

            </style>
            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
            <script src="/resources/jquery-ui-1.12.1/jquery-ui.js"></script>
            <script>

            var main = document.getElementById( 'row_of_cols' );
            [].map.call( main.children, Object ).sort( function ( a, b ) {
                return +a.id.match( /\d+/ ) - +b.id.match( /\d+/ );
            }).forEach( function ( elem ) {
                main.appendChild( elem );
            });


            $( function() {
                $( ".resizable" ).resizable({
                    alsoResize: "also",
                    alsoResize: "#also",
                    alsoResize: ".also",
                    // maxHeight: 250,
                    //   maxWidth: 350,
                    //   minHeight: 150,
                    //   minWidth: 200
                });
                $( ".resizable_top" ).resizable({
                    minWidth: 750,
                    maxWidth: 750,

                });

            } );

            </script>


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

            <div class="contact-page-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <div class="contact-form-area">
                                <h4>Please upload the template photo</h4>
                                <form method="post" name="contact_form" action="pr_template_photo_upload" enctype="multipart/form-data">
                                    <fieldset>
                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                            <label>Image</label>
                                            <input  type="file" name="input_template_image" id="fileToUpload">
                                            <input type="hidden" id="doc_select" name="doc_select" value="<?php echo ($docid); ?>">
                                            <input type="hidden" id="error" name="error" value="none">
                                        </div>

                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                            <div class="form-group">
                                                <button style="width: 100%; min-width:45px; ; padding: 0px 0px 0px 0px !important; display:inline; margin-left: 0px;" class="btn-send btn-primary" type="submit">upload template photo</button>
                                            </div>
                                        </div>

                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
                var hig_arr = [];
                var test_arr =[];
                var top_marg_arr = [];
                $( ".resizable" ).each(function(index) {
                    var col_id =($( this ).attr('id'));
                    var col_width =($( this ).width());
                    var col_height=($( this ).height());
                    col_width += 2;
                    var test =  col_id + col_width;
                    var top_margin_height =($("#ID_Top_Margin").height());

                    top_margin_height += 2;
                    id_arr.push(col_id);
                    hig_arr.push(col_height);
                    wid_arr.push(col_width);
                    top_marg_arr.push(top_margin_height);

                });



                var info = [id_arr,wid_arr,hig_arr,top_marg_arr];

                $.ajax({
                    type: "POST",
                    url: "qc_upload_template_cords",
                    data: {info,info,info,info},
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

        ob_start();
        ?>

         <div id="2413" style="background-image:url(<?php echo $db_get_pic_results ?>); background-repeat:no-repeat; background-size: 100%; width:<?php echo $width_of_background?>px;  height:<?php echo $height_of_background?>px; !important" class=" containment-wrapper"></div>
        <div class="contact-page-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <div class="contact-form-area">
                            <h4>Please upload the template photo</h4>
                            <form method="post" name="contact_form" action="pr_template_photo_upload" enctype="multipart/form-data">
                                <fieldset>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                        <label>Image</label>
                                        <input type="file" name="input_template_image" id="fileToUpload">
                                        <input type="hidden" id="doc_select" name="doc_select" value="<?php echo ($docid); ?>">
                                        <input type="hidden" id="error" name="error" value="none">
                                    </div>

                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <button class="btn-send submit-buttom" type="submit">upload template photo</button>
                                        </div>
                                    </div>

                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $mainHTML = ob_get_contents();
        ob_end_clean();

        $return['html3'] = $mainHTML;
        $return['html4'] = "";
    }
} else {
    $return['ErrorStatus'] = "Error: " . $sql . "<br>" . $conn->error;
}









die(json_encode($return));

?>
