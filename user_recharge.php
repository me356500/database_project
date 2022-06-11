
<?php 
header("Content-Type: text/html; charset=utf8");
include 'config.php';
date_default_timezone_set('Asia/Taipei');
$account = $_POST["account"];
$money=$_POST["money"];
session_start();
$_SESSION['account'] = ".$account.";

if(($money) == 0) {
    echo "
    <script> 
        alert('Blank : value');
        location.href=  'nav.php?id=$account&op=0&order=0';
    </script>
    ";
    exit;
}
if(!is_numeric($money) ){
    echo "
    <script> 
        alert('Wrong format: value should be number!!');
        location.href=  'nav.php?id=$account&op=0&order=0';
    </script>
    ";
    exit;
} 
if(is_double($money + 0)) {
    echo "
    <script> 
        alert('money must be integer!!');
        location.href=  'nav.php?id=$account&op=0&order=0';
    </script>
    ";
    exit;
}
if($money <= 0 ){
    echo "
    <script> 
        alert('Wrong format: value should be integer larger than 0!!');
        location.href=  'nav.php?id=$account&op=0&order=0';
    </script>
    ";
    exit;
} 
$addval = $money;
$sql = "select balance from user where account = '$account'";
$data = mysqli_query($link, $sql);
$rs=mysqli_fetch_row($data);
$money = $money + $rs[0];

$sql = "select uid from user where account = '$account'";
$data = mysqli_query($link, $sql);
$rs1=mysqli_fetch_row($data);

$sql = "select name from user where account = '$account'";
$data = mysqli_query($link, $sql);
$n1=mysqli_fetch_row($data);


$link->begin_transaction();


try {
    $sql = "UPDATE user SET balance= ? where account = ?";
    $stmt = mysqli_stmt_init($link); 
    mysqli_stmt_prepare($stmt, $sql); 
    mysqli_stmt_bind_param($stmt, 'is',$money,$account); 
    mysqli_stmt_execute($stmt);

    $n_time = date("Y-m-d H:i:s");
    $sql = "INSERT INTO trade VALUES(\"$rs1[0]\",NULL,?,\"Recharge\",\"$n_time\",\"$n1[0]\")";
    $stmt = mysqli_stmt_init($link); 
    mysqli_stmt_prepare($stmt, $sql); 
    mysqli_stmt_bind_param($stmt, 'i',$addval); 
    mysqli_stmt_execute($stmt);

    $link->commit();
} catch (mysqli_sql_exception $e) {
    $link->rollback();
    throw $e; // but the error must be handled anyway
}


echo "
<script> 
    alert('Add value success !!');
    location.href=  'nav.php?id=$account&op=0&order=0';
</script>
";


?>

