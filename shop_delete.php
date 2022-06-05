<?php 
header("Content-Type: text/html; charset=utf8");
include 'config.php';
$pid=$_POST["pid"];
$account = $_POST["account"];
$sql = "delete from goods where pid ='$pid'";
$data1 = mysqli_query($link, $sql);

session_start();
$_SESSION['account'] = ".$account.";

echo "
<script> 
    alert('Delete success !!');
    location.href=  'nav.php?id=$account&op=0&order=0';
</script>
";
?>