<?php
header("Content-Type: text/html; charset=utf8");

session_start();

$id = $_GET['id'];
$op = $_GET['op'];
$order = $_GET['order'];


$_SESSION['account'] = ".$id.";

header("Location:nav.php?id=".$id."&op=".$op."&order=".$order."");
?>