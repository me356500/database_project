<?php
header("Content-Type: text/html; charset=utf8");

//session
session_start();

$id = $_GET['id'];
$op = $_GET['op'];
$order = $_GET['order'];


$_SESSION['account'] = ".$id.";

header("Location:nav.php?id=".$id."&op=0&order=0");
echo "<script>
window.location.hash = '#menu2';
</script>";
?>