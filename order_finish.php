<?php 
header("Content-Type: text/html; charset=utf8");
include 'config.php';
date_default_timezone_set('Asia/Taipei');
$oid=$_POST["oid"];
$account = $_POST["account"];
$n_time = date("Y-m-d H:i:s");

$sql = "update order_list SET end_time = '$n_time',state = 'Finished' where oid = '$oid'";
$data1 = mysqli_query($link, $sql);

session_start();
$_SESSION['account'] = ".$account.";

echo "
<script> 
    alert('Finish success !!');
    location.href=  'nav.php?id=$account&op=0&order=0';
</script>
";
?>