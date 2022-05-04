<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', '109550128');
define('DB_PASSWORD', '1469275830');
define('DB_NAME', 'hw');
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
mysqli_query($link, 'SET NAMES utf8');
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
else{
    return $link;
}
?>