<?PHP
header("Content-Type: text/html; charset=utf8");
$conn= require_once "config.php";
$account = $_POST["Account"];
$password = $_POST["password"];
$password_hash=password_hash($password, PASSWORD_DEFAULT);
$sql = "select password from user where account = ?";
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql); 
mysqli_stmt_bind_param($stmt, 's', $account); 
mysqli_stmt_execute($stmt); 
$result = $stmt->get_result();

if($rs = mysqli_fetch_row($result)){
    
    if (password_verify($password, $rs[0])) {
        session_start();
        $_SESSION['account'] = $account;
        header("Location:nav.php?id=".$account."&op=0&order=0");
        exit;
    } else {
        echo "
        <script> 
            alert('login failed !!');
            location.href='index.html'
        </script>
        ";
        exit;
    }
    

    
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