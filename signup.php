
<?php 
header("Content-Type: text/html; charset=utf8");
include 'config.php';
$name=$_POST["name"];
$password=$_POST["password"];
$password_hash=password_hash($password,PASSWORD_DEFAULT);
$phonenumber=$_POST["phonenumber"];
$account=$_POST["Account"];
$repassword=$_POST["re-password"];
$repassword_hash = password_hash($repassword,PASSWORD_DEFAULT);
$latitude=$_POST["latitude"];
$longitude=$_POST['longitude'];
//欄位空白
if(($name && $password && $phonenumber && $account && $repassword && $latitude && $longitude) == 0) {
    echo "
    <script> 
        alert('Please fill all the blank!!');
        location.href='sign-up.html'
    </script>
    ";
    exit;
}
//check account repeated
$racc = mysqli_query($link, "select * from user where account = '$name'");
if(mysqli_num_rows($racc)) {
    echo "
    <script> 
        alert('Account has been registered !!');
        location.href='sign-up.html'
    </script>
    ";
    exit;
}
//check repassword
if($repassword != $password) {
    echo "
    <script> 
        alert('Password and re-password are not the same !!');
        location.href='sign-up.html'
    </script>
    ";
    exit;
}
// password 只能大小寫
if(preg_match('/(?=.*[a-zA-Z])/', $password) == 0){

    echo "
    <script> 
        alert('password 只能是大小寫英文 !!');
        location.href='sign-up.html'
    </script>
    ";
    exit;
}
// phonenumber taiwan 09xxxxxxxx
if(preg_match("/^09[0-9]{2}-[0-9]{3}-[0-9]{3}$/", $phonenumber) == 0) {
    echo "
    <script> 
        alert('phonenumber wrong !!');
        location.href='sign-up.html'
    </script>
    ";
    exit;
}
//register
$sql = "INSERT INTO `user` VALUES (NULL ,?, ?,?, ?, ?,?);";
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql); 
mysqli_stmt_bind_param($stmt, 'ssisdd', $name, $password, $phonenumber, $account, $latitude, $longitude); 
mysqli_stmt_execute($stmt); 

$result = $stmt->get_result();
if (!$result){
    die('Error: ' . mysqli_error());
}
else{
    echo "
    <script> 
        alert('Register success !!');
        location.href='index.html'
    </script>
    ";
    exit;
}

?>

