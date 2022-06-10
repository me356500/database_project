<?php
header("Content-Type: text/html; charset=utf8");
include 'config.php';
date_default_timezone_set('Asia/Taipei');
$n_time = date("Y-m-d H:i:s");
$sid = $_COOKIE['sid'];
$type = $_COOKIE['Type'];

$id = $_GET['id'];

$sql_b = 'select goods.img, goods.imgtype, goods.name, goods.price, goods.PID, goods.quantity from goods where goods.SID = '.$sid;
$stmt_b = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt_b, $sql_b); 
mysqli_stmt_execute($stmt_b); 
$data_b =$stmt_b->get_result();
$subtotal = 0;
while($result_b = mysqli_fetch_row($data_b)){
    if(!is_int($_COOKIE['pid'.$result_b[4]] + 0)){
        echo "
        <script> 
            alert('error: quantity is not a integer!!');
            location.href=  'nav.php?id=$id&op=0&order=0';
        </script>
        ";
    }
    if($result_b[5] < $_COOKIE['pid'.$result_b[4]]){
        echo "
        <script> 
            alert('error: quantity isn't enough !!');
            location.href=  'nav.php?id=$id&op=0&order=0';
        </script>
        ";
    }
    $subtotal = $subtotal + $result_b[3] * (int)$_COOKIE['pid'.$result_b[4]];
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
        alert('error: money isn't enough !!');
        location.href=  'nav.php?id=$id&op=0&order=0';
    </script>
    ";
}

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

$sql = 'INSERT INTO trade VALUES ('.$delivery[5].', NULL, '.$total.', "Recieve", "'.$n_time.'", "'.$delivery[4].'")';
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
while($result_b = mysqli_fetch_row($data_b)){
    $sql_r = 'INSERT INTO amount VALUES ('.$result[0].', '.$result_b[4].' , '.$_COOKIE['pid'.$result_b[4]].', '.$result_b[2].', '.$result_b[3].', '.$result_b[0].', '.$result_b[1].')';
    $stmt_r = mysqli_stmt_init($link); 
    mysqli_stmt_prepare($stmt_r, $sql_r);
    mysqli_stmt_execute($stmt_r); 
    $result_r = $stmt_r->get_result();
    mysqli_stmt_close($stmt_r);
}

echo "
<script> 
    alert('Order success !!');
    location.href=  'nav.php?id=$id&op=0&order=0';
</script>
";
?>
