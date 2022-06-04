<?php 
header("Content-Type: text/html; charset=utf8");
include 'config.php';
$oid=$_POST["oid"];
$account = $_POST["account"];
$price = $_POST["price"];

$n_time = date("Y-m-d H:i:s");

$sql_o = "select state from order_list where OID= '$oid' ";

$stmt_o = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt_o, $sql_o); 
mysqli_stmt_execute($stmt_o); 
$data_o =$stmt_o->get_result();
$rd=mysqli_fetch_row($data_o);

if($rd[0]=='Finished') {
    echo "
    <script> 
        alert('cancel failed !!');
        location.href= 'nav.php?id=$account&op=0&order=0';
    </script>
    ";
    exit;
} 
$sql = "update order_list SET end_time='$n_time',state ='Cancel'  where oid = '$oid' ";
$data1 = mysqli_query($link, $sql);

$sql = "select uid from user where account = '$account'";
$data = mysqli_query($link, $sql);
$uid=mysqli_fetch_row($data);

$sql = "select uid from store where sid =(select sid from order_list where oid='$oid')";
$data = mysqli_query($link, $sql);
$uid_shop=mysqli_fetch_row($data);










$link->begin_transaction();

try {
    $sql = "UPDATE user SET balance=balance+'$price' where account = '$account'";
    $data1 = mysqli_query($link, $sql);

    $sql = "UPDATE user SET balance=balance+'$price' where uid = '$uid_shop[0]'";
    $data1 = mysqli_query($link, $sql);

    $sql = "INSERT INTO trade VALUES(\"$uid[0]\",NULL,'$price',\"Receive\",\"$n_time\",\"$uid_shop[0]\")";
    $data1 = mysqli_query($link, $sql);

    $sql = "INSERT INTO trade VALUES(\"$uid_shop[0]\",NULL,'$price',\"Payment\",\"$n_time\",\"$uid[0]\")";
    $data1 = mysqli_query($link, $sql);
   

    $link->commit();
} catch (mysqli_sql_exception $e) {
    $link->rollback();
    throw $e; // but the error must be handled anyway
}


echo "
<script> 
    alert('Cancel success !!');
    location.href=  'nav.php?id=$account&op=0&order=0';
</script>
";
?>