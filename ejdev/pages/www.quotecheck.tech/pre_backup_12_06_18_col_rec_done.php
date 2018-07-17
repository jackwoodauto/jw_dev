<?php
$mykey = "";
$found = false;

$job_id = $_POST['job_selected'];
$user_id  = $_SESSION['user']['id'];
$invoice_or_quote = $_POST['Quote_or_invoice']; //name of table eg qc_pr_quotes
$servername = "localhost";
$dbname = "ejdev_db";
$username = "ejdev_db";
$password = "autoSquared01_db";
$wholesaler_id = $_POST['wholesaler_selected'];
$doc_id =  $_POST['doc_select'];
$relative_path = "imgs/quotecheck/uploads/";

$original_name = $_FILES['input_quote']['name'][0];
$tmp_name = $_FILES['input_quote']['tmp_name'][0];

if ($tmp_name == "")
{
  // echo "no file found to upload<br>";
  sleep(3);
  return null;
}

if($_FILES['input_quote']['type'][0]=="application/pdf"){
  // echo "PDF files cannot be uploaded (yet!)";
  sleep(3);
} else {

  $arr['dest_file_folder'] = "/quotecheck/uploads/";
  $arr['dest_file_name_string'] = "quote";////////////// make sure this is either invoice or quote
  if (strpos("invoice", $invoice_or_quote)!==false)
  $arr['dest_file_name_string'] = "invoice";
  $arr['create_thumb_nail'] = false;
  $arr['valid_image_types'] = array(IMAGETYPE_GIF => '.gif', IMAGETYPE_JPEG => '.jpg', IMAGETYPE_PNG => '.png', IMAGETYPE_BMP => '.bmp', IMAGETYPE_PDF => '.pdf');
  $arr['dest_max_width'] = 750;
  $arr['dest_max_height'] = 5000;

  $result = upload_file($arr, $_FILES['input_quote']);
  $quote_image = $result[0]['main']['filename'];

  // echo "resulting file is <pre>";
  // print_r($quote_image);
  // echo "</pre>";
}
//JACK JACK JACK
//JACK JACK JACK - file has uploaded - now we need to analyse the information using google vision and store it
//extracted data should be stored in the DB

$imagefile = $result[0]['main']['filename'];
$ch = curl_init();
$api_key = "AIzaSyAlCaFZcnwXOLepsXNFAh14i3YC9sFru8Y";
$cvurl = "https://vision.googleapis.com/v1/images:annotate?key=" . $api_key;

// work out how much text is there by doing the post images to vision function by sending the infomation as
$results = post_image_to_vision($ch, $imagefile, $cvurl);

//decode json
$decoded_json_data = json_decode($results,true);
//// echo "<pre>";
//// print_r($decoded_json_data);
//// echo "</pre>";
//read the results and output every individual word which matches a column header
$text_only = $decoded_json_data['responses'][0]['textAnnotations']['0']['description'];
$destination_folder = DOC_ROOT . $relative_path;
$unique_id = get_unique_id();

$destination_filename_prefix = $quote_or_invoice.'-'.$unique_id; //quote or invoice
$destinationPDFname = $destination_filename_prefix.'.pdf' ;
$destinationJPGname = $destination_filename_prefix.'.jpg' ;

if(move_uploaded_file($tmp_name, $destination_folder.$destinationPDFname )) {

  $imagick = new Imagick();
  $imagick->readImage($destination_folder.$destinationPDFname);
  $imagick->writeImages($destination_folder.$destinationJPGname , false);

  $returns['unique_id'] = $unique_id;
  $returns['jpg_count'] = 1;
  $returns['destination_filename_prefix'] = $destination_filename_prefix;

  $returns['upload_folder'] = "www.quotecheck.tech/". $relative_path;

}
else {
  // echo "Problem uploading file";
  sleep(3);
}

$input_file = $destination_filename_prefix.'.jpg';;


$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$upload_time = date('m/d/Y h:i:s a', time());;
$old_name = $original_name;
$sql = "INSERT INTO $invoice_or_quote (fk_user_id, fk_job_id, input_file, old_name, upload_time, fk_wholesaler_id, fk_doc_id)
VALUES ('$user_id','$job_id','$input_file','$old_name','$upload_time','$wholesaler_id','$doc_id')";

//$sql = "INSERT INTO $invoice_or_quote (fk_user_id, fk_job_id, input_file, old_name, upload_time ) VALUES( ?,?,?,?,?);
//$args = array("iisss", $user_id,$job_id,$input_file,$old_name,$upload_time);

if ($conn->query($sql) === TRUE) {
  // echo "New record created successfully";
} else {
  // echo "Error: " . $sql . "<br>" . $conn->error;
  sleep(3);
}
$conn->close();
$conn = null;

$Fix_array = array();
$array_of_col_names = array();
$sql = "SELECT * FROM qc_pr_wholesaler_doc_col where fk_doc_id = ?";
$args = array("i",$doc_id);
$db = new database();
$db->query($sql,$args);
$results = $db->all();
$db = null;
if(count($results)>0){
  // echo "<pre>";
  // print_r($results);
  // echo "</pre>";
  foreach($results as $result) {
    // echo $result['col_text'], '<br>';
    array_push($array_of_col_names, $result['col_text']);
    $placeholder_for_array_push = $result['col_text'];
    $placeholder_for_array_push_x_left = $result['x_left'] ;
    $placeholder_for_array_push_x_right = $result['x_right'] ;
    $Fix_array[$placeholder_for_array_push]['Col_LeftX'] = $placeholder_for_array_push_x_left;
    $Fix_array[$placeholder_for_array_push]['Col_RightX'] = $placeholder_for_array_push_x_right;

  }

}


//GetColHeaderInfo($decoded_json_data, $array_of_col_names);


//
// $abc = GetColHeaderInfo($decoded_json_data, $array_of_col_names);
// // echo "abc";
// // echo "<pre>";
// // print_r($abc);
// // echo "</pre>";

// function GetColHeaderInfo($decoded_json_data, $array_of_col_names, $Fix_array){
//   $col_headers = array();
//   foreach($array_of_col_names as $result) {
//     $w = FindWord($decoded_json_data, $result, $Fix_array);
//   //  // echo "<pre>";
//   //  // print_r($w);
//   //  // echo "</pre>";
//     array_push($col_headers,$w);
//   }
//   return($col_headers);
// }
// // echo $array_of_col_names;






$abcdegadfadsfasf = FindSymbol($decoded_json_data, "abc", $Fix_array);

$output_array = symbol_loop($abcdegadfadsfasf, $Fix_array);
// echo "BBBBBBBBB";
// echo "<pre>";
// print_r($adasdasddasdsfa );
// echo "</pre>";
// echo "BBBBBBBBBBBB";


function symbol_loop($symbol_array,$Fix_array){

  // echo "<pre>";
  // print_r($symbol_array);
  // echo "</pre>";
  // echo "AAAa";
  $exit_col_array = array();
  foreach($Fix_array as $col_key => $col_value){

    foreach ($symbol_array as $symbol_key => $sym_value) {
      // echo "---------------------------------------------<br />";
      // echo "col_head_final";
      // echo "<pre>";
      // print_r($col_key);
      // echo "</pre>";
      // echo "col_value";
      // echo "<pre>";
      // print_r($col_value);
      // echo "</pre>";
      // echo "---------------------------------------------<br />";
      // echo "symbol";
      // echo "<pre>";
      // print_r($symbol_key );
      // echo "</pre>";
      // echo "sym_value";
      // echo "<pre>";
      // print_r($sym_value);
      // echo "</pre>";


      if ($symbol_key  === "fulltext"){
        $Sym_L = "-999";
        $Sym_R = "-999";

      } else{
        $Sym_L = $sym_value['symb_left_x'];
        $Sym_R = $sym_value['symb_right_x'];
      }
      $Col_L = $col_value['Col_LeftX'];
      $Col_R = $col_value['Col_RightX'];


      // echo "Sym_L <br />" ;
      // echo $Sym_L ."<br />";
      // echo "Sym_R <br />";
      // echo $Sym_R ."<br />";
      // echo "Col_L <br />";
      // echo $Col_L ."<br />";
      // echo "Col_R <br />";
      // echo $Col_R ."<br />";


    if(($Sym_L >= $Col_L && $Sym_R <= $Col_R) || ($Sym_L <= $Col_L && $Sym_R >= $Col_l) && ($symbol_key  != "fulltext")  /*||  ($Sym_L <= $Col_R && $Sym_R >= $Col_R )*/){
        // echo "---------------------------------------------<br />";
        // echo "inthecol <br />";
        $exit_col = $exit_col . $sym_value['symb_text'];
        // echo $exit_col . "<br />";
        // echo "---------------------------------------------<br />";
        unset($symbol_array[$symbol_key]);
      } else {
      }

    }
    $exit_col_array[$col_key] = $exit_col;
    $exit_col = "";


  }
  // echo "---------------------------------------------<br />";
  // echo "final array";
  // echo "<pre>";
  // print_r($exit_col_array);
  // echo "</pre>";
  // echo "---------------------------------------------<br />";
  // echo "Symbols that are left in the array";
  // echo "<pre>";
  // print_r($symbol_array);
  // echo "</pre>";
  // echo "---------------------------------------------<br />";
  return $exit_col_array;
}

function FindSymbol($decoded_json_data, $input_word, $Fix_array){
  $text_str = "";
  $results = array();
  foreach($decoded_json_data['responses'][0]['fullTextAnnotation']['pages'] as $symb_for_each_1){ // [0]
    foreach($symb_for_each_1['blocks']  as $symb_for_each_2){                    // [0]
      foreach ($symb_for_each_2['paragraphs'] as $symb_for_each_3){          //  [0]
        foreach ($symb_for_each_3['words'] as $symb_for_each_4){             // [0]
          foreach ($symb_for_each_4['symbols'] as $symb_for_each_5){          //  [0]
            // echo "<pre>";
            // print_r($symb_for_each_5);
            // echo "</pre>";

            $symbol_text =  $symb_for_each_5['text'];
            $symb_left_x =  $symb_for_each_5['boundingBox']['vertices'][0][x];
            $symb_right_x =  $symb_for_each_5['boundingBox']['vertices'][1][x];
            // $symb_Y = ['boundingBox']['vertices'][0][y];
            // $sym_array[]
            // $sym_str = "abc";
            // $results[] =   $symb_left_x



            $symb_info['symb_text'] = $symbol_text;
            $symb_info['symb_left_x'] = $symb_left_x;
            $symb_info['symb_right_x'] = $symb_right_x;
            array_push($results, $symb_info);

            //      $results[] = $symb_left_x;
            //      $results[] = $symb_right_x;

            $text_str = $text_str . $symbol_text;



          }
        }
      }
    }
  }
  $results['fulltext'] = $text_str;
  return $results;
}

$_SESSION['pr_upload_final_array'] = $output_array;

header("Location:https://www.quotecheck.tech/output_example");
die();




































































































// function all_col_names_output_col_results($decoded_json_data, $array_of_col_names, $Fix_array){
//   $final_array = array();
//   $final_array['col_headers'] = array();
//   $final_array['col_headers']['col_text'] = array();
//   foreach($array_of_col_names as $result) {
//     $col_head_info = FindWord($decoded_json_data, $result, $Fix_array);
//     array_push($final_array['col_headers'],$col_head_info);
//     $find_col_words = FindWordsInCol($decoded_json_data, $col_head_info);
//     array_push($final_array['col_headers']['col_text'],  $find_col_words);
//   }
//   return $final_array;
// }
//
// function all_col_names_output_col_results_para($decoded_json_data, $array_of_col_names, $Fix_array){
//   $final_array = array();
//   $final_array['col_headers'] = array();
//   $final_array['col_headers']['col_text'] = array();
//   foreach($array_of_col_names as $result) {
//     $col_head_info = FindWord($decoded_json_data, $result, $Fix_array);
//     // echo "<pre>";
//     // print_r( $col_head_info);
//     // echo "</pre>";
//
//     array_push($final_array['col_headers'],$col_head_info);
//     $find_para_info= FindParaInCol($decoded_json_data, $col_head_info, $Fix_array);
//     array_push($final_array['col_headers']['col_text'],  $find_para_info);
//   }
//   return $final_array;
// }
//
//
// $abc = all_col_names_output_col_results_para($decoded_json_data, $array_of_col_names, $Fix_array);
//  // echo "final array";
// // echo "<pre>";
// // print_r($abc);
// // echo "</pre>";
//
//
// function GetTextFromPara(){
// // echo "<pre>";
// // print_r($decoded_json_data['responses'][0]['fullTextAnnotation']['pages'][0]['blocks'][0]['paragraphs'][0]['words'][0]['symbols'][0]['text']);
// // echo "</pre>";
// }
//
//
// function FindWord($decoded_json_data, $input_word, $Fix_array){
//   $results = array();
//
//
//   foreach($decoded_json_data['responses'][0]['textAnnotations'] as $word)
//   {
//     if ($word['description'] == "$input_word")
//     {
//
//
//       $results['LeftX'] = ($word['boundingPoly']['vertices'][0]['x'] + $word['boundingPoly']['vertices'][3]['x']) / 2;
//       $results['RightX'] = ($word['boundingPoly']['vertices'][1]['x'] + $word['boundingPoly']['vertices'][2]['x']) / 2;
//       $results['Word'] = $input_word;
//       $results['Confidence'] = 100; //this is a percentage. Let's keep it at 100 for now.
//       $results['MultipleOccurrences'] = false; // this should be set to true if we can find multiple occurences of the word
//       $results['Topleft'] = $word['boundingPoly']['vertices'][3]['x'].','.$word['boundingPoly']['vertices'][3]['y'];
//       $results['Topright'] = $word['boundingPoly']['vertices'][2]['x'].','.$word['boundingPoly']['vertices'][2]['y'];
//       $results['Bottomleft'] = $word['boundingPoly']['vertices'][0]['x'].','.$word['boundingPoly']['vertices'][0]['y'];
//       $results['Bottomright'] = $word['boundingPoly']['vertices'][1]['x'].','.$word['boundingPoly']['vertices'][1]['y'];
//
//
//       $placeholder_word = $word['description'];
//       // echo "<pre>";
//       // print_r($placeholder_word );
//       // echo "</pre>";
//       // echo "<pre>";
//       // print_r($Fix_array[$placeholder_word]);
//       // echo "</pre>";
//
//
//       if ($Fix_array[$placeholder_word] != "") {
//       $results['LeftX'] =  $Fix_array[$placeholder_word]['Col_LeftX'];
//       $results['RightX'] =  $Fix_array[$placeholder_word]['Col_RightX'];
//       }
//
//
//     }
//   }
//   return $results;
// }
//
//
//
//
//
//
// function FindWordsInCol($decoded_json_data, $col_header, $Fix_array){
//   $results = array();
//   $found_words = array();
//   // echo "<br>FindWordsInCol:";
//   foreach($decoded_json_data['responses'][0]['textAnnotations'] as $word)
//   {
//
// //if ($word_left_x <= $col_header['RightX'] && $word_right_x >= $col_header['LeftX'])
//
//     $word_right_x = $word['boundingPoly']['vertices'][1]['x'];
//     $word_left_x = $word['boundingPoly']['vertices'][0]['x'];
//     if ($word_left_x >= $col_header['LeftX'] && $word_right_x <= $col_header['RightX'])
//     {
//     //  $results['Word'] = $word['description'];
//     //  $results['error_msg'] = "testing";
//     //  $results['LeftX'] = $word['boundingPoly']['vertices'][0]['x'];
//       //$results['RightX'] = $word['boundingPoly']['vertices'][1]['x'];
//       //$results['Confidence'] = 100; //this is a percentage. Let's keep it at 100 for now.
//       //$results['MultipleOccurrences'] = false; // this should be set to true if we can find multiple occurences of the word
//       //$results['Topleft'] = $word['boundingPoly']['vertices'][3]['x'].','.$word['boundingPoly']['vertices'][3]['y'];
//       //$results['Topright'] = $word['boundingPoly']['vertices'][2]['x'].','.$word['boundingPoly']['vertices'][2]['y'];
//       //$results['Bottomleft'] = $word['boundingPoly']['vertices'][0]['x'].','.$word['boundingPoly']['vertices'][0]['y'];
//       //$results['Bottomright'] = $word['boundingPoly']['vertices'][1]['x'].','.$word['boundingPoly']['vertices'][1]['y'];
//       $return_word['Word'] = $word['description'];
//       $return_word['LeftX'] = $word['boundingPoly']['vertices'][0]['x'];
//       $return_word['RightX'] = $word['boundingPoly']['vertices'][1]['x'];
//
//       array_push($found_words,$return_word);
//     }
//   }
//   return $found_words;
// }
//
//
//
// function FindParaInCol($decoded_json_data, $col_header, $Fix_array){
//   $results = array();
//   $found_words = array();
//   // echo "<br>FindWordsInCol:";
//
//   foreach ($decoded_json_data['responses'][0]['fullTextAnnotation']['pages'][0]['blocks'] as $key ) {
//
//
//   foreach( $key['paragraphs'] as $para)
//   {
//       $text = "";
//
//
//
// //  if ($para_left_x <= $col_header['RightX'] && $para_right_x >= $col_header['LeftX'])
//
//     $para_right_x = $para['boundingBox']['vertices'][1]['x'];
//     $para_left_x = $para['boundingBox']['vertices'][0]['x'];
//     if ($para_left_x >= $col_header['LeftX'] && $para_right_x <= $col_header['RightX'])
//     {
//                             foreach ($para['words'] as $word) {
//                         //      // echo "word<pre>";
//                         //      // print_r($word);
//                         //      // echo "</pre>";
//                               foreach ( $word['symbols'] as $symbol) {
//                                 $text = $text . $symbol['text'];
//                                 // echo "<pre>";
//                                 // print_r($word['symbols']['property']['detectedBreak']);
//                                 // echo "</pre>";
//
//                                 if ($symbol['property']['detectedBreak']['type']) {
//
//                                   $text = $text . " ";
//                                 }
//                               }
//                             }
//       $results['Word'] = $text;
//       $results['error_msg'] = "testing";
//       $results['LeftX'] = $para['boundingBox']['vertices'][0]['x'];
//       $results['RightX'] = $para['boundingBox']['vertices'][1]['x'];
//     //  $results['Confidence'] = 100; //this is a percentage. Let's keep it at 100 for now.
//     //  $results['MultipleOccurrences'] = false; // this should be set to true if we can find multiple occurences of the word
//       $results['Topleft'] = $para['boundingBox']['vertices'][3]['x'].','.$para['boundingBox']['vertices'][3]['y'];
//       $results['Topright'] = $para['boundingBox']['vertices'][2]['x'].','.$para['boundingBox']['vertices'][2]['y'];
//       $results['Bottomleft'] = $para['boundingBox']['vertices'][0]['x'].','.$para['boundingBox']['vertices'][0]['y'];
//       $results['Bottomright'] = $para['boundingBox']['vertices'][1]['x'].','.$para['boundingBox']['vertices'][1]['y'];
//       $return_word['Word'] = $text;
//       $return_word['LeftX'] = $para['boundingBox']['vertices'][0]['x'] + $para['boundingBox']['vertices'][3]['x'] / 2;
//       $return_word['RightX'] = $para['boundingBox']['vertices'][1]['x'] + $para['boundingBox']['vertices'][2]['x'] / 2;
//       $return_word['BottomY'] = $para['boundingBox']['vertices'][1]['y'] + $para['boundingBox']['vertices'][0]['y'] / 2;
//
//
//       array_push($found_words,$return_word);
//     }
//   }
// }
//
//   return $found_words;
// }
//
// //this function finds the word specified and returns an array with lots of information about where that word is
// //this function should take a word and find it in the document, get the xy location and make a decision whether the word is in the column specified.
// //break this function into parts - it should call other functions to do the work (eg. Find column header in database and get XY)
// function IsWordInColumn($word, $columnHeader) {
//   $result = false;
//   return $result;
// }
//// echo $text_only;
// // echo "<pre>";
// //// print_r(array_keys($decoded_json_data['responses'][0]['textAnnotations']));
// // // echo "keys:    ";
// // // print_r(array_keys($decoded_json_data['responses'][0]['textAnnotations'][0]));
// // //// print_r(array_keys($decoded_json_data['responses'][0]['textAnnotations'][0]['description']));
// // // echo "values:   ";
// // // print_r(array_values($decoded_json_data['responses'][0]['textAnnotations'][0]));
//  // print_r(array_keys($decoded_json_data['responses'][0]['fullTextAnnotation']['pages']));
//
// $keywords = array_values($decoded_json_data['responses'][0]['textAnnotations'][0]); // find word in this array, get index
//
//
// // print_r($keywords);
// var_dump($keywords);
// // echo "<br>";
//
// // echo "------------------".$keywords[1];
//
// // print_r(array_keys($decoded_json_data['responses'][0]['fullTextAnnotation']['pages'][0]['blocks'][0]['paragraphs'][0]));
//
//
// // print_r(array_values($decoded_json_data['responses'][0]['fullTextAnnotation']['pages'][0]['blocks'][0]['paragraphs']));
//
//
// //$numberBlocks = count($decoded_json_data['responses'][0]['fullTextAnnotation']['pages'][0]['blocks']);
// // echo "<br>number of blocks = ".count($decoded_json_data['responses'][0]['fullTextAnnotation']['pages'][0]['blocks']);
// // echo "<br>number of paragraphs in block 1  = ".count($decoded_json_data['responses'][0]['fullTextAnnotation']['pages'][0]['blocks'][0]['paragraphs']);
// // echo "<br>number of words in paragraph 1  = ".count($decoded_json_data['responses'][0]['fullTextAnnotation']['pages'][0]['blocks'][0]['paragraphs'][0]['words']);
// // echo "<br>";
//
// //foreach(array_values($decoded_json_data['responses'][0]['fullTextAnnotation']['pages'][0]['blocks'][0]['paragraphs'][0]['words']) as $word)
// foreach(array_values($decoded_json_data['responses'][0]['fullTextAnnotation']['pages'][0]['blocks'][0]['paragraphs']) as $word)
// {
//     // echo "--:<pre>";
//     // print_r($word);
//     // echo "</pre>";
// }
// //
// // $indexInWordsArray =  array_search($wordToFind, $keywords);
// //
// //
// // $XY_topLefts = array(array_values($decoded_json_data['responses'][0]['textAnnotations'][0]['boundingPoly'][$indexInWordsArray]));
// //
// // $keynumber = array_search($wordToFind, $keywords);
// //
// // if ($keynumber !== false)
// // {
// //     // echo "FOUND=$keynumber<br>";
// //     $temp = $XY_topLefts["$keynumber"];
// //     // echo "XY=".$temp;
// //
// //
// //
// //
// // }
//
//
// //// print_r(array_keys($decoded_json_data['responses'][0]['fullTextAnnotation']['pages']));
// //// print_r(array_keys($decoded_json_data['responses'][0]['fullTextAnnotation']['pages']));
//
// // echo "</pre>";
// die();
//
//
//
//
//
// // $key = array_search($searchString, $decoded_json_data,false);
// // echo "all keys:<pre>";
// // print_r(array_keys($decoded_json_data));
// // echo "</pre>";
//
//
//
//
// // // echo "all:<pre>";
// // array_keys_multi($decoded_json_data);
// // // print_r($mykey);
// // // echo "</pre>";
//
//
// $s = getParentStack('Qty', $decoded_json_data);
// $c = getParentStackComplete('Qty', $decoded_json_data);
// //var_dump($s, $c);
//
// // echo "<pre>";
// // print_r($s);
// // echo "</pre>";
// // echo "<pre>";
// // print_r($c);
// // echo "</pre>";
// die();
//
//
//
//
// //
// // }
// // // echo "key:<pre>";
// // // print_r($key);
// // // echo "</pre>";
//
//
// die();
//
//
// header("Location: https://www.quotecheck.tech/my_home");
//
//
//
//
//
//
//
// /**
// * Gets the parent stack of a string array element if it is found within the
// * parent array
// *
// * This will not search objects within an array, though I suspect you could
// * tweak it easily enough to do that
// *
// * @param string $child The string array element to search for
// * @param array $stack The stack to search within for the child
// * @return array An array containing the parent stack for the child if found,
// *               false otherwise
// */
// function getParentStack($child, $stack) {
//     foreach ($stack as $k => $v) {
//         if (is_array($v)) {
//             // If the current element of the array is an array, recurse it and capture the return
//             $return = getParentStack($child, $v);
//
//             // If the return is an array, stack it and return it
//             if (is_array($return)) {
//                 return array($k => $return);
//             }
//         } else {
//             // Since we are not on an array, compare directly
//             if ($v == $child) {
//                 // And if we match, stack it and return it
//                 return array($k => $child);
//             }
//         }
//     }
//
//     // Return false since there was nothing found
//     return false;
// }
//
// /**
// * Gets the complete parent stack of a string array element if it is found
// * within the parent array
// *
// * This will not search objects within an array, though I suspect you could
// * tweak it easily enough to do that
// *
// * @param string $child The string array element to search for
// * @param array $stack The stack to search within for the child
// * @return array An array containing the parent stack for the child if found,
// *               false otherwise
// */
// function getParentStackComplete($child, $stack) {
//     $return = array();
//     foreach ($stack as $k => $v) {
//         if (is_array($v)) {
//             // If the current element of the array is an array, recurse it
//             // and capture the return stack
//             $stack = getParentStackComplete($child, $v);
//
//             // If the return stack is an array, add it to the return
//             if (is_array($stack) && !empty($stack)) {
//                 $return[$k] = $stack;
//             }
//         } else {
//             // Since we are not on an array, compare directly
//             if ($v == $child) {
//                 // And if we match, stack it and return it
//                 $return[$k] = $child;
//             }
//         }
//     }
//
//     // Return the stack
//     return empty($return) ? false: $return;
// }
//
//
//
//
//
//
// function showStructure() {
//
//
//     foreach ($document->pages() as $page) {
//             foreach ($page['blocks'] as $block) {
//                 $block_text = '';
//                 foreach ($block['paragraphs'] as $paragraph) {
//                     foreach ($paragraph['words'] as $word) {
//                         foreach ($word['symbols'] as $symbol) {
//                             $block_text .= $symbol['text'];
//                         }
//                         $block_text .= ' ';
//                     }
//                     $block_text .= "\n";
//                 }
//                 printf('Block text: %s' . PHP_EOL, $block_text);
//                 printf('Block bounds:' . PHP_EOL);
//                 foreach ($block['boundingBox']['vertices'] as $vertice) {
//                     printf('X: %s Y: %s' . PHP_EOL,
//                         isset($vertice['x']) ? $vertice['x'] : 'N/A',
//                         isset($vertice['y']) ? $vertice['y'] : 'N/A'
//                     );
//                 }
//                 printf(PHP_EOL);
//             }
//         }
//
// }
//
//
//
//
// function array_keys_multi(array $array)
// {
//     $keys = array();
//     foreach ($array as $key => $value) {
//
//
//         if ($value == "Qty")
//         {
//             $found = true;
//             $mykey.= $key;
//             // echo "FOUND! $mykey";
//             break;
//         }
//         $keys[] = $key;
//         if ($found)
//         {
//             $mykey = $key."_".$mykey;
//             // echo "mykey=".$mykey;
//             break;
//         }
//         if (is_array($array[$key])) {
//             $keys = array_merge($keys, array_keys_multi($array[$key]));
//             if ($found) {
//                 $mykey = $key."_".$mykey;
//                 // echo "mykey=".$mykey;
//                 break;
//             }
//         }
//     }
//     return $keys;
// }
?>
