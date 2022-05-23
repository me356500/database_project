<?php 
header("Content-Type: text/html; charset=utf8");
include 'config.php';
$pid=$_POST["pid"];
$account = $_POST["account"];

$sql = "update order_list SET state ='cancel' ";
$data1 = mysqli_query($link, $sql);
echo "
<script> 
    alert('cancel success !!');
    location.href=  'nav.php?id=$account&op=0&order=0';
</script>
";
?>