<?php
header("Content-Type: text/html; charset=utf8");

//session
session_start();

$id = $_GET['id'];
$op = $_GET['op'];
$order = $_GET['order'];
$menu = $_GET['filter'];

$_SESSION['account'] = ".$id.";
if($menu == 4) {
    header("Location:nav.php?id=".$id."&op=".$op."&order=".$order."");
    exit;
}
header("Location:nav.php?id=".$id."&op=".$op."&order=".$order."&menu=".$menu."");
echo "<script>
window.location.hash = '#menu2';
</script>";
?>