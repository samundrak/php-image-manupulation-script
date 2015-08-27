<?php

$download = $_GET['img'];
if(!empty($download)){
    if(file_exists($download)){
        header("Content-Description: File Transfer");
        header("Content-Type: image/jpeg");
        header("Content-Disposition: attachment; filename=\"$download\"");
        readfile ($download);
    }else{
        header("Location: index.php");
    }
}else{
    header("Location: index.php");

}