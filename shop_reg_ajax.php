<?php
header("Content-Type: text/html; charset=utf8");
include 'config.php';

$name = $_REQUEST["acc"];
$sql = "select * from store where name = ?";
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql); 
mysqli_stmt_bind_param($stmt, 's', $name); 
mysqli_stmt_execute($stmt); 
$racc =$stmt->get_result();
$ret = "";
if(mysqli_num_rows($racc)) {
    $ret = "Shop_Name has been registered!";
}
echo $ret;