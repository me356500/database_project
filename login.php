<?PHP
header("Content-Type: text/html; charset=utf8");
$conn= require_once "config.php";
$name = $_POST["Account"];
$password = $_POST["password"];
$password_hash=password_hash($password, PASSWORD_DEFAULT);
$sql = "select * from user where account = '$name' and password='$password'";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result)){
    header("refresh:0;url=nav.html");
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