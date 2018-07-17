<?php
function GetAllColumns($symbol_array,$Fix_array){

    $exit_col_array = array();

    foreach($Fix_array as $col_key => $col_value){

        foreach ($symbol_array as $symbol_key => $sym_value) {

            if ($symbol_key  === "fulltext"){

                $Sym_L = "-999";
                $Sym_R = "-999";

            } else{
                $Sym_L = $sym_value['symb_left_x'];
                $Sym_R = $sym_value['symb_right_x'];
                $Sym_T = $sym_value['symb_bottom_y']; //sym top is sym bottom
                $Sym_B = $sym_value['symb_top_y'];
            }

            $Col_T = $col_value['Col_TopY'];
            $Col_B = $col_value['Col_BottomY'];
            $Col_L = $col_value['Col_LeftX'];
            $Col_R = $col_value['Col_RightX'];

            if(($Sym_L >= $Col_L && $Sym_R <= $Col_R) || ($Sym_L <= $Col_L && $Sym_R >= $Col_l) && ($symbol_key  != "fulltext")){
                if ($Sym_T >= $Col_T && $Col_B >= $Sym_B ) {
                    // echo "<pre>";
                    // print_r($Sym_T ." > ". $Col_T ." && ". $Col_B ." > ". $Sym_B. "<br />");
                    // echo "</pre>";
                    $exit_col = $exit_col . $sym_value['symb_text'];
                    unset($symbol_array[$symbol_key]);
                }
            } else {

            }
        }

        $exit_col_array[$col_key] = $exit_col;
        $exit_col = "";

    }

    return $exit_col_array;

}




function GetAllSymbols($decoded_json_data){


    $text_str = "";
    $results = array();

    foreach($decoded_json_data['responses'][0]['fullTextAnnotation']['pages'] as $symb_for_each_1){

        foreach($symb_for_each_1['blocks']  as $symb_for_each_2){

            foreach ($symb_for_each_2['paragraphs'] as $symb_for_each_3){

                foreach ($symb_for_each_3['words'] as $symb_for_each_4){

                    foreach ($symb_for_each_4['symbols'] as $symb_for_each_5){
                        $symb_space = "";
                        $symb_space = $symb_for_each_5['property']['detectedBreak'];
                        if ($symb_space != "" ){
                            $symb_space = " ";
                        }


                        $symbol_text =  $symb_for_each_5['text'];
                        $symbol_text = $symbol_text . $symb_space;
                        $symb_left_x =  $symb_for_each_5['boundingBox']['vertices'][0][x];
                        $symb_right_x =  $symb_for_each_5['boundingBox']['vertices'][1][x];
                        $symb_bottom_y = $symb_for_each_5['boundingBox']['vertices'][0][y];
                        $symb_top_y = $symb_for_each_5['boundingBox']['vertices'][2][y];
                        $symb_info['symb_text'] = $symbol_text;
                        $symb_info['symb_left_x'] = $symb_left_x;
                        $symb_info['symb_right_x'] = $symb_right_x;
                        $symb_info['symb_bottom_y'] = $symb_bottom_y;
                        $symb_info['symb_top_y'] =  $symb_top_y;
                        array_push($results, $symb_info);
                        $text_str = $text_str . $symbol_text;

                    }
                }
            }
        }
    }

    $symb_for_each_1 = null;
    $symb_for_each_2 = null;
    $symb_for_each_3 = null;
    $symb_for_each_4 = null;
    $symb_for_each_5 = null;
    $results['fulltext'] = $text_str;
    return $results;
    $results = null;

}


function get_rows_y($symb_array, $template_column_array){
    $final_row_array = array();

    $keys = array_keys($template_column_array);
    $Col_top = $template_column_array[$keys[0]]['Col_TopY'];
    $Col_bottom = $template_column_array[$keys[0]]['Col_BottomY'];
    //
    // echo "<pre>";
    // print_r($Col_top);
    // echo "</pre>";
    // echo "<pre>";
    // print_r( $Col_bottom );
    // echo "</pre>";



    foreach($symb_array as $key => $sym_value) {
        if ( !isset($sym_value['symb_bottom_y'])){
            continue;
        }
        $y_bottom =  $sym_value['symb_top_y'];// top / bottom fix (other way round)
        $y_top = $sym_value['symb_bottom_y'];
        $y_max = $y_top + 12;
        $y_min = $y_top - 12;
        if (empty($final_row_array)){
            $final_row_array[] = array(
                'Y_bottom' => $y_bottom,
                'Y_top' => $y_top
            );
        } else {
            $add_to_final = 1;
            foreach ($final_row_array as $final_value){
                if ($y_min <= $final_value['Y_top'] && $y_max >= $final_value['Y_top']){
                    $add_to_final = 0;
                    continue 2;
                } else {
                }
            }
            if ($add_to_final) {
                $final_row_array[] = array('Y_bottom' => $y_bottom, 'Y_top' => $y_top);
            }
        }
    }
    $final_row_array_with_height_rec = array();
    foreach ($final_row_array as $key => $value) {

        $row_in_db_B = $value['Y_bottom'];
        $row_in_db_T = $value['Y_top'];

        if ($row_in_db_T  >= $Col_top && $Col_bottom >= $row_in_db_B ) {
            $final_row_array_with_height_rec[$key]['Y_bottom'] = $row_in_db_B;
            $final_row_array_with_height_rec[$key]['Y_top'] = $row_in_db_T;
        }


    };

    $symb_array = null;
    return $final_row_array_with_height_rec;
}

function GetAllRows($symbol_array, $output_row_ys) {

    $exit_col_array = array();

    foreach ($output_row_ys as $row => $row_var) {

        foreach ($symbol_array as $symbol_key => $sym_value) {

            $Row_T = $row_var['Y_top'];
            $Row_B = $row_var['Y_bottom'];

            if ($symbol_key  === "fulltext"){

                $Sym_T = "-999";
                $Sym_B = "-999";

            } else{

                $Sym_T = $sym_value['symb_bottom_y'];
                $Sym_B = $sym_value['symb_top_y'];

            }

            if(($Sym_B <= $Row_B && $Sym_T >= $Row_T) || ($Sym_B >= $Row_B && $Sym_T <= $Row_B) || ($Sym_T <= $Row_T && $Sym_B >= $Row_T) && ($symbol_key  != "fulltext")){

                $exit_col = $exit_col . $sym_value['symb_text'];
                unset($symbol_array[$symbol_key]);

            } else {

            }
        }

        $exit_col_array[$row] = $exit_col;
        $exit_col = "";

    }

    return $exit_col_array;

};




function final_value($symb_array, $col_array, $row_array){
    $final_output_table = array();
    unset($symb_array['fulltext']);



    foreach ($col_array as $column => $column_value) {
        $col_array[$column]['cells'] = $row_array;
    }
    $final_output_table = $col_array;
    foreach ($col_array as $column => $column_value) {
        $cell_left = $column_value['Col_LeftX'];
        $cell_right = $column_value['Col_RightX'];

        foreach ($column_value['cells'] as $cell => $cell_value) {
            $cell_bottom = $cell_value['Y_bottom'];
            $cell_top = $cell_value['Y_top'];

            foreach ($symb_array as $symb => $symb_var) {
                $symb_left = $symb_var['symb_left_x'];
                $symb_right = $symb_var['symb_right_x'];
                $symb_top = $symb_var['symb_bottom_y']; // bottom and top switch here as more = down so the origonal code is the wrong way round
                $symb_bottom = $symb_var['symb_top_y'];
                $symb_text = $symb_var['symb_text'];


                //if (($symb_bottom >= $cell_bottom) && ($symb_top <= $cell_top) && ($symb_left <= $cell_left) && ($symb_right >= $cell_right)) {
                if ((($symb_bottom <= $cell_bottom && $symb_top >= $cell_top) || ( $symb_bottom >= $cell_bottom && $symb_top <= $cell_bottom) || ($symb_top <= $cell_top &&  $symb_bottom >= $cell_top)) &&
                (($symb_right <= $cell_right && $symb_left >= $cell_left) /*|| ( $symb_right >= $cell_right && $symb_left <= $cell_right)*/ || ($symb_left <= $cell_left &&  $symb_right >= $cell_left))) {

                    $final_output_table[$column]['cells'][$cell]['Cell_text']  .= $symb_text;

                } else {
                }

            }

        }

    }
    $exit_col = $exit_col . $sym_value['symb_text'];



    return $final_output_table;

    //mark22
}
function UploadLineItems($final_table, $job_id, $invoice_or_quote, $file_type, $file_id){



    $line_item_array = array();
    foreach ($final_table as $col => $col_items) {

        foreach ($col_items as $key => $value) {
            if ($key == 'cells') {
                foreach ($value as $key2 => $value2) {
                    foreach ($final_table as $col => $col_items) {
                        $line_item_array[$key2][$col] =$final_table[$col][$key][$key2]['Cell_text'];


                    }

                }

            }
        }

    }



    foreach ($line_item_array as $key => $value) {
        // echo "<pre>
        $return_true_false_or_array = "true_false";

        $fk_job_id = $job_id;
        $file_type = $invoice_or_quote;
        if ($file_type == 'qc_pr_quotes'){
            $file_type = 'Quote';

        } else {
            $file_type = 'Invoice';
        }

        $Quantity = $value['Quantity'];
        $Unit = $value['Unit'];
        $Description = $value['Description'];
        $Price = $value['Price'];
        $Per = $value['Per'];
        $Disc =  $value['Discount'];
        $Total = $value['Total'];
        $field_you_want_to_check = "Description";
        if ($Quantity == "") {
            $Quantity = " ";
        }
        if ($Unit == "") {
            $Unit = " ";
        }
        if ($Price == "") {
            $Price = " ";
        }
        if ($Per == "") {
            $Per = " ";
        }
        if ($Disc == "") {
            $Disc = " ";
        }
        if ($Total == "") {
            $Total = " ";
        }
        if ($file_type == 'Quote'){
            $table_name = 'qc_quote_line_items';
        } else {
            $table_name = 'qc_invoice_line_items';
        }
        // probably want to do $db_check for every thing but at the moment it is not needed


        $return_quote_desc = "FALSE";

        // $Db_check  = CheckIfInDatabase($Description, $field_you_want_to_check, $table_name, $return_true_false_or_array, $job_id, $file_type, $return_quote_desc);
        // if ($Db_check == "TRUE") { //&& $file_type != 'Quote'
        //     // echo "continue";
        //
        //
        //     continue;
        //     // code...function test if in database
        // }

        $Highlight = "true";


        $sql = "insert into $table_name (fk_job_id, file_type, Quantity, Unit, Description, Price, Per, Discount, Total, fk_file_id, Highlight) values (?,?,?,?,?,?,?,?,?,?,?)";



        $args = array("sssssssssss", $fk_job_id, $file_type, $Quantity, $Unit, $Description, $Price, $Per, $Disc, $Total, $file_id, $Highlight);

        $db = new database();
        $db->query($sql,$args);
        // echo $db->error();
        $insert_id = $db->get_insert_id();

$line_item_array[$key]["line_item_id"] = $insert_id ;






        $db = null;
    }
    return $line_item_array;
}



function FindClosestMatch($input_value, $field_you_want_to_check, $table_name, $job_id, $file_type) {
    $closest = null;

    $maxdate = "0";
    $sql = "select * from $table_name Where fk_job_id = $job_id";
    $db = new database();
    $db->query($sql);
    $results = $db->all();
    $db = null;
    $maxperc = 0;
    foreach ($results as $value)
    {

        similar_text($input_value, $value[$field_you_want_to_check], $perc);
        if($perc > 50){
            echo "<pre>";
            print_r($value['insertiontime']);
            echo "</pre>";


            if ($perc > $maxperc)
            {
                $maxperc = $perc;
                $closest = $value;
            }



            else if ($perc == $maxperc)
            {

                //closest must be set to the latest version
                if ($value['insertiontime'] > $maxdate)
                {
                    $value['insertiontime'] =  $maxdate;
                    $closest = $value;
                }
            }

        }

    }

    return $closest;
}





function SimilarityCheck($input_value, $field_you_want_to_check, $table_name, $job_id, $file_type) {
    $similarityarray = array();



    $sql = "select $field_you_want_to_check from $table_name Where fk_job_id = $job_id";
    $db = new database();
    $db->query($sql);
    $result = $db->all();
    $db = null;
    foreach ($result as $key => $value) {

        $sim = similar_text($input_value, $value['Description'], $perc);


        // echo "similarity: $sim ($perc %)\n";
        if ($perc > 90){
            $similarityarray[$input_value][$perc] = $value['Description'];
        }


    }
    $maxValue = "$input_value";
    if (count($similarityarray) > 0 ){
        $maxValue=max($similarityarray);
    }
    // echo "<hr>";
    // echo "<pre>";
    // print_r($maxValue);
    // echo "</pre>";
    // echo "<hr>";
    // echo "<pre>";
    // print_r($similarityarray[$input_value][$maxValue]);
    // echo "</pre>";
    return $maxValue;
}
function CheckIfInDatabase($input_value, $field_you_want_to_check, $table_name, $return_true_false_or_array, $job_id, $file_type, $return_quote_desc) {


    if ($table_name == "qc_invoice_line_items") {
    } else {

        $valueToFindInDB = $input_value;
        $closestDescription = FindClosestMatch($valueToFindInDB, $field_you_want_to_check,  $table_name, $job_id, $file_type, $return_quote_desc);
        // echo "<br>closest:";
        // echo "<pre>";
        // print_r($closestDescription);
        // echo "</pre>";
        $result[0] = $closestDescription;


        // $similarityarray = SimilarityCheck($input_value, $field_you_want_to_check, $table_name, $job_id, $file_type, $return_quote_desc);


        // if ($similarityarray != ""){
        //
        //
        //
        // //     if ($input_value != $similarityarray) {
        // //     foreach ($similarityarray as $percentage => $field_name_fixed) {
        // //         if ($percentage  != 100){
        // //             $input_value = $field_name_fixed;
        // //
        // //
        // //         }
        // //     }
        // // }
        //
        // }

        // }
        // echo "<pre>";
        // print_r($input_value);
        // echo "</pre>";








        // $sql = "select * from $table_name Where $field_you_want_to_check = ? AND fk_job_id = ?";
        //
        // $args = array("si", $input_value, $job_id);
        //
        // $db = new database();
        //
        // $db->query($sql,$args);
        // //echo $db->error();
        // $result = $db->all();
        //
        // $db = null;
        // if ($return_quote_desc == "TRUE") {
        //     $result["old_name"] = $input_value
        // }
        // echo "<pre>";
        // print_r($result );
        // echo "</pre>";

        if ($return_true_false_or_array == 'true_false') {
            if(count($result)>0){
                return "TRUE";

            } else {
                return "FALSE";
            }
        }
        if ($return_true_false_or_array == 'array') {
            // echo "<pre>";
            // print_r($result);
            // echo "</pre>";

            return $result;

        }

    }
}
function CompareNewInvoiceInfoAgainstQuote($upload_line_items, $job_id, $file_type) {
    //
    // if ($table_name == "qc_invoice_line_items") {
    //     // code...
    // } else {
    //     $similarityarray = SimilarityCheck($input_value, $field_you_want_to_check, $table_name);
    //     if ($similarityarray != ""){
    //
    //         foreach ($similarityarray as $percentage => $field_name_fixed) {
    //             if ($percentage  != 100){
    //             $input_value = $field_name_fixed;
    //             echo "<pre>";
    //             print_r($input_value);
    //             echo "</pre>";
    //             echo "<pre>";
    //             print_r("new_name <hr>");
    //             echo "</pre>";
    //         }
    //         }
    //
    //     }
    //
    // }

    $table_name = 'qc_quote_line_items';
    $field_you_want_to_check = 'Description';
    $return_true_false_or_array = 'array';
    $comparison_table = array();
    $return_quote_desc = "TRUE";

    foreach ($upload_line_items as $key => $value) {
        $input_value = $value['Description'];
        $check =  CheckIfInDatabase($input_value, $field_you_want_to_check, $table_name, $return_true_false_or_array, $job_id, $file_type, $return_quote_desc);
        if ($check == FALSE) {
            $check = "false";
        }
        $comparison_table[$key]['invoice'] = [$value];
        $comparison_table[$key]['quote'] = [$check]['0'];
        // $comparison_table[$key]['quote']['description_in_database'] = $check;
        // echo "<hr>";
        //  echo "invoice input";
        //  echo "<pre>";
        //  print_r($value);
        //  echo "</pre>";
        //  echo "<hr>";
        //  echo "Quote Found";
        // echo "<pre>";
        //  print_r($check);
        //  echo "</pre>";
        // echo "<hr>";

    }


    return $comparison_table;
}


function ResetTables() {
    $Sql = "TRUNCATE TABLE qc_quote_line_items;";
    $db = new database();
    $db->query($sql);
    $db = null;
    $Sql = "TRUNCATE TABLE qc_invoice_line_items;";
    $db = new database();
    $db->query($sql);
    $db = null;
    $Sql = "TRUNCATE TABLE qc_pr_quotes;";
    $db = new database();
    $db->query($sql);
    $db = null;
    $Sql = "TRUNCATE TABLE  qc_pr_invoices;";
    $db = new database();
    $db->query($sql);
    $db = null;
}
?>
