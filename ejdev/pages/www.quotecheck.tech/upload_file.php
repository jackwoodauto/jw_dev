<?php

$targetfolder = "pdfs/";

$targetfolder = $targetfolder . basename( $_FILES['file']['name']) ;

if(move_uploaded_file($_FILES['file']['tmp_name'], $targetfolder)) {

    echo "The file ". basename( $_FILES['file']['name']). " is uploaded";

    $imagick = new Imagick();
    $imagick->readImage($_FILES['file']['name']);
    $imagick->writeImage($_FILES['file']['name'".jpg"]);
} else {

    echo "Problem uploading file";
}

?>
