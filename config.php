<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'me356500');
define('DB_PASSWORD', 'aa881212');
define('DB_NAME', 'test2');
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
mysqli_query($link, 'SET NAMES utf8');
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
else{
    return $link;
}
?>