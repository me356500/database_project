
<?php 
header("Content-Type: text/html; charset=utf8");
include 'config.php';
$account = $_POST["account"];
$money=$_POST["money"];
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

$sql = "select balance from user where account = '$account'";
$data = mysqli_query($link, $sql);
$rs=mysqli_fetch_row($data);
$money = $money + $rs[0];

$link->begin_transaction();
try {
    $sql = "UPDATE user SET balance= ? where account = ?";
    $stmt = mysqli_stmt_init($link); 
    mysqli_stmt_prepare($stmt, $sql); 
    mysqli_stmt_bind_param($stmt, 'is',$money,$account); 
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

