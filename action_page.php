<?php
header("Content-Type: text/html; charset=utf8");
include 'config.php';
session_start();

$lowerbound=$_POST["lowerbound"];
$upperbound=$_POST["upperbound"];
$category=$_POST["category"];
$distance=$_POST["distance"];
$meal=$_POST["meal"];
$name=$_POST["shopname"];
$uname = $_POST["uname"];
$order = $_POST['order'];
$_SESSION['account'] = "test";

header('Location:nav.php?id='.$uname."&op=1"."&shopname=".$name."&meal=".$meal."&distance=".$distance."&category=".$category."&lowerbound=".$lowerbound."&upperbound=".$upperbound."&order=".$order);
?>