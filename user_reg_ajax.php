<?php
header("Content-Type: text/html; charset=utf8");
include 'config.php';

$account = $_REQUEST["acc"];
$sql = "select * from user where account = ?";
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql); 
mysqli_stmt_bind_param($stmt, 's', $account); 
mysqli_stmt_execute($stmt); 
$racc =$stmt->get_result();

$ret = "";
if(mysqli_num_rows($racc)) {
    $ret = "Account have been registered!!";
}
echo $ret;
?>