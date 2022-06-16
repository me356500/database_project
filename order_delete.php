<script>
  function deleteAllCookies() {
        var cookies = document.cookie.split(";");
        for (var i = 0; i < cookies.length; i++) {
            
            var cookie = cookies[i];
            var eqPos = cookie.indexOf("=");
            var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
            document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
        }
        }
</script>

<?php 
header("Content-Type: text/html; charset=utf8");
date_default_timezone_set('Asia/Taipei');
include 'config.php';
$oid=$_POST["oid"];
$account = $_POST["account"];
$price = $_POST["price"];
//session
session_start();
$_SESSION['account'] = ".$account.";

$n_time = date("Y-m-d H:i:s");



$sql = "select uid from user where account = '$account'";
$data = mysqli_query($link, $sql);
$uid=mysqli_fetch_row($data);

$sql = "select pid,quantity from amount where oid = '$oid'";
$redo_goods = mysqli_query($link, $sql);


$sql = "select uid from store where sid =(select sid from order_list where oid='$oid')";
$data = mysqli_query($link, $sql);
$uid_shop=mysqli_fetch_row($data);

$sql = "select name from store where sid =(select sid from order_list where oid='$oid')";
$data = mysqli_query($link, $sql);
$shop_name=mysqli_fetch_row($data);

$sql = "select balance from user where uid = '$uid_shop[0]'";
$data = mysqli_query($link, $sql);
$shop_balance=mysqli_fetch_row($data);

$sql = "select state from order_list where OID= '$oid' ";
$data = mysqli_query($link, $sql);
$order_state=mysqli_fetch_row($data);

if($order_state[0]=='Finished') {
    echo "
    <script> 
        alert('Cancel failed !!');
        location.href= 'nav.php?id=$account&op=0&order=0';
    </script>
    ";
    exit;
} 
if($shop_balance[0] < $price) {
    echo "
    <script> 
        alert('Store does not have enough money to refund !!');
        location.href='nav.php?id=$account&op=0&order=0'
    </script>
    ";
    exit;
}


$link->begin_transaction();

try {
    while($item = mysqli_fetch_row($redo_goods)) {
        $sql = "select pid from goods where pid = '$item[0]'";
        $data = mysqli_query($link, $sql);
        // check goods have been deleted or not
        if(mysqli_fetch_row($data)) {
            $sql = "UPDATE goods SET quantity=quantity+'$item[1]' where pid = '$item[0]'";
            $data = mysqli_query($link, $sql);
        }
    }
    $sql = "UPDATE user SET balance=balance+'$price' where account = '$account'";
    $data1 = mysqli_query($link, $sql);

    $sql = "UPDATE user SET balance=balance-'$price' where uid = '$uid_shop[0]'";
    $data1 = mysqli_query($link, $sql);

    $sql = "INSERT INTO trade VALUES(\"$uid[0]\",NULL,'$price',\"Receive\",\"$n_time\",\"$shop_name[0]\")";
    $data1 = mysqli_query($link, $sql);

    $sql = "INSERT INTO trade VALUES(\"$uid_shop[0]\",NULL,'$price',\"Payment\",\"$n_time\",\"$account\")";
    $data1 = mysqli_query($link, $sql);

    $sql = "update order_list SET end_time='$n_time',state ='Cancel'  where oid = '$oid' ";
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