<?php 
header("Content-Type: text/html; charset=utf8");
include 'config.php';
$pid=$_POST["pid"];
$account = $_POST["account"];
$price = $_POST["price"];

$sql = "update order_list SET state ='cancel' ,end_time=NULL ";
$data1 = mysqli_query($link, $sql);
$sql = "update user,order_list set user.balance = user.balance + ? where user.UID=order_list.UID";
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql); 
mysqli_stmt_bind_param($stmt, 'i',$price ); 
mysqli_stmt_execute($stmt); 
$result = $stmt->get_result();
mysqli_stmt_close($stmt);

$sql = "update user,order_list,store set user.balance = user.balance - ? where store.SID=order_list.SID and store.UID=user.UID";
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql); 
mysqli_stmt_bind_param($stmt, 'i',$price ); 
mysqli_stmt_execute($stmt); 
$result = $stmt->get_result();
mysqli_stmt_close($stmt);


echo "
<script> 
    alert('cancel success !!');
    location.href=  'nav.php?id=$account&op=0&order=0';
</script>
";
?>
