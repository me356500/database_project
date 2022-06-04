<?php 
header("Content-Type: text/html; charset=utf8");
include 'config.php';
date_default_timezone_set('Asia/Taipei');
$oid=$_POST["oid"];
$account = $_POST["account"];
$n_time = date("Y-m-d H:i:s");



$sql_o = "select state from order_list where OID= '$oid' ";

$stmt_o = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt_o, $sql_o); 
mysqli_stmt_execute($stmt_o); 
$data_o =$stmt_o->get_result();
$rd=mysqli_fetch_row($data_o);

if($rd[0]=='cancel') {
    echo "
    <script> 
        alert('finish failed !!');
        location.href= 'nav.php?id=$account&op=0&order=0';
    </script>
    ";
    exit;
} 



$sql = "update order_list SET end_time = '$n_time',state = 'Finished' where oid = '$oid'";
$data1 = mysqli_query($link, $sql);

echo "
<script> 
    alert('Finish success !!');
    location.href=  'nav.php?id=$account&op=0&order=0';
</script>
";
?>