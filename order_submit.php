
<?php
header("Content-Type: text/html; charset=utf8");
include 'config.php';
date_default_timezone_set('Asia/Taipei');
$n_time = date("Y-m-d H:i:s");
$sid = $_COOKIE['sid'];
$type = $_COOKIE['Type'];
$goods_number = $_GET['gn'];
$id = $_GET['id'];

$sql_b = 'select goods.img, goods.imgtype, goods.name, goods.price, goods.PID, goods.quantity from goods where goods.SID = '.$sid;
$stmt_b = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt_b, $sql_b); 
mysqli_stmt_execute($stmt_b); 
$data_b =$stmt_b->get_result();
$subtotal = 0;
$now_number = 0;
while($result_b = mysqli_fetch_row($data_b)){
    if (!isset($_COOKIE['pid'.$result_b[4]])) {
        continue;   
    }
    if($_COOKIE['pid'.$result_b[4]] < 0) {
        echo "
        <script> 
            alert('Error: quantity must be positive integer!!');
            location.href=  'nav.php?id=$id&op=0&order=0';
        </script>
        ";
        exit;
    }
    if(!is_int($_COOKIE['pid'.$result_b[4]] + 0)){
        echo "
        <script> 
            alert('Error: quantity is not a integer!!');
            location.href=  'nav.php?id=$id&op=0&order=0';
        </script>
        ";
        exit;
     
    }
    if($result_b[5] < $_COOKIE['pid'.$result_b[4]]){
        echo "
        <script> 
        
            alert('Error: quantity is not enough !!');
            location.href=  'nav.php?id=$id&op=0&order=0';
        </script>
        ";
        exit;
       
    }

    $subtotal = $subtotal + $result_b[3] * (int)$_COOKIE['pid'.$result_b[4]];
    $now_number = $now_number + 1;
}
if($goods_number > $now_number) {
    echo "
        <script> 
            alert('Error: 商店更動商品 請重新下單 !!');
            location.href=  'nav.php?id=$id&op=0&order=0';
        </script>
        ";
        exit;
}
if($subtotal == 0){
    echo "
        <script> 
        
            alert('Error: Must order something !!');
       
            location.href=  'nav.php?id=$id&op=0&order=0';
        </script>
        ";
    exit;
}
$sql_l = "select ST_Distance_Sphere(POINT(store.longitude,store.latitude),POINT(user.longitude, user.latitude)), user.UID, user.balance, store.name, user.name, store.UID from user, store where store.SID = ".$sid." and user.account = '$id'";
$stmt_l = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt_l, $sql_l); 
mysqli_stmt_execute($stmt_l); 
$data_l =$stmt_l->get_result();
$delivery=mysqli_fetch_row($data_l);
$t = $delivery[0] / 100;
$fee = round($t);
if($fee < 10){
    $fee = 10;
}
if($type == 'Pick-Up'){
    $fee = 0;
}
$total = $subtotal + $fee;

if($delivery[2] < $total){
    echo "
    <script> 
        
            alert('Error: Money is not enough !!');
           
            location.href=  'nav.php?id=$id&op=0&order=0';
        </script>
    ";
    exit;
}


$link->begin_transaction();
try {
$sql = 'INSERT INTO order_list VALUES (NULL, '.$delivery[1].', '.$sid.', '.$total.', "'.$n_time.'", "", "", "Nfinished", "'.$type.'")';
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_execute($stmt); 
$result = $stmt->get_result();
mysqli_stmt_close($stmt);

$sql = 'INSERT INTO trade VALUES ('.$delivery[1].', NULL, '.$total.', "Payment", "'.$n_time.'", "'.$delivery[3].'")';
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_execute($stmt); 
$result = $stmt->get_result();
mysqli_stmt_close($stmt);

$sql = 'INSERT INTO trade VALUES ('.$delivery[5].', NULL, '.$total.', "Receive", "'.$n_time.'", "'.$id.'")';
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_execute($stmt); 
$result = $stmt->get_result();
mysqli_stmt_close($stmt);

$sql = 'UPDATE user SET balance = balance - '.$total.' where user.UID = '.$delivery[1];
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_execute($stmt); 
$result = $stmt->get_result();
mysqli_stmt_close($stmt);

$sql = 'UPDATE user SET balance = balance + '.$total.' where user.UID = '.$delivery[5];
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_execute($stmt); 
$result = $stmt->get_result();
mysqli_stmt_close($stmt);
//modify quantity
$sql_b = 'select goods.img, goods.imgtype, goods.name, goods.price, goods.PID, goods.quantity from goods where goods.SID = '.$sid;
$stmt_b = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt_b, $sql_b); 
mysqli_stmt_execute($stmt_b); 
$data_b =$stmt_b->get_result();

while($result_b = mysqli_fetch_row($data_b)){

    $sql = 'UPDATE goods SET quantity = quantity  - '.$_COOKIE['pid'.$result_b[4]].' where pid = '.$result_b[4];
    $stmt = mysqli_stmt_init($link); 
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt); 
    $result = $stmt->get_result();
    mysqli_stmt_close($stmt);
}
$sql = 'select max(OID) from order_list';
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_execute($stmt); 
$out = $stmt->get_result();
$result = mysqli_fetch_row($out);

$sql_b = 'select goods.img, goods.imgtype, goods.name, goods.price, goods.PID from goods where goods.SID = '.$sid;
$stmt_b = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt_b, $sql_b); 
mysqli_stmt_execute($stmt_b); 
$data_b =$stmt_b->get_result();
$subtotal = 0;
// img imgtype name price PID 
// amount 
// oid pid name price quantity img imtype
while($result_b = mysqli_fetch_row($data_b)){
    $temp = 0;
    if (isset($_COOKIE['pid'.$result_b[4]])) {
        $temp = $_COOKIE['pid'.$result_b[4]];  
    }
    $sql_r = "INSERT INTO amount VALUES ('$result[0]', '$result_b[4]' , '$result_b[2]', '$result_b[3]','$temp', '$result_b[0]', '$result_b[1]')";
    $data1 = mysqli_query($link, $sql_r);
}
$link->commit();
} catch (mysqli_sql_exception $e) {
    $link->rollback();
    throw $e; // but the error must be handled anyway
}
echo "
<script> 
    alert('Order success !!');
    
    location.href=  'nav.php?id=$id&op=0&order=0';
    
</script>

";
?>
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