<?PHP
header("Content-Type: text/html; charset=utf8");
$conn= require_once "config.php";
$account = $_POST["Account"];
$password = $_POST["password"];
$password_hash=password_hash($password, PASSWORD_DEFAULT);
$sql = "select * from user where account = ? and password = ?";
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql); 
mysqli_stmt_bind_param($stmt, 'ss', $account, $password); 
mysqli_stmt_execute($stmt); 
$result = $stmt->get_result();

if(mysqli_num_rows($result)){
    header('Location:nav.php?id='.$account);
    exit;
}
else {
    echo "
    <script> 
        alert('login failed !!');
        location.href='index.html'
    </script>
    ";
    exit;
}
mysqli_close($conn);
?>