
<?php 
header("Content-Type: text/html; charset=utf8");
include 'config.php';
$name=$_POST["name"];
$password=$_POST["password"];
$repassword=$_POST["re-password"];
$phonenumber=$_POST["phonenumber"];
$account=$_POST["Account"];
$latitude=$_POST["latitude"];
$longitude=$_POST['longitude'];
if(($name && $password && $phonenumber && $account && $repassword && $latitude && $longitude) == 0) {
    $n; $pa; $ph; $acc; $rep; $la; $lo;
    if(!$name)
        $n = 'name';
    if(!$password)
        $pa = 'password';
    if(!$phonenumber)
        $ph = 'phonenumber';
    if(!$account)
        $acc = 'account';
    if(!$repassword)
        $rep = 'repassword';
    if(!$latitude)
        $la = 'latitude';
    if(!$longitude)
        $lo = 'longitude';
    echo "
    <script> 
        alert('Blank : $n $pa $ph $acc $rep $la $lo');
        location.href='sign-up.html'
    </script>
    ";
    exit;
}
if(!preg_match('/^[0-9a-zA-Z\s]+$/', $password)){
    echo "
    <script> 
        alert('password 只能是大小寫英文及數字 !!');
        location.href='sign-up.html'
    </script>
    ";
    exit;
}
if(!preg_match('/^[0-9a-zA-Z\s]+$/', $repassword)){
    echo "
    <script> 
        alert('repassword 只能是大小寫英文及數字 !!');
        location.href='sign-up.html'
    </script>
    ";
    exit;
}
$password_hash=password_hash($password,PASSWORD_DEFAULT);
$repassword_hash = password_hash($repassword,PASSWORD_DEFAULT);

//check account repeated
$sql = "select * from user where account = ?";
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql); 
mysqli_stmt_bind_param($stmt, 's', $account); 
mysqli_stmt_execute($stmt); 
$racc =$stmt->get_result();


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
if(!preg_match('/^[0-9a-zA-Z\s]+$/', $account)){

    echo "
    <script> 
        alert('account 只能是大小寫英文及數字 !!');
        location.href='sign-up.html'
    </script>
    ";
    exit;
}
// 名字
if(!preg_match('/^[a-zA-Z\s]+$/', $name)){

    echo "
    <script> 
        alert('name 只能是大小寫英文 !!');
        location.href='sign-up.html'
    </script>
    ";
    exit;
}

// phonenumber taiwan 09xxxxxxxx
if(preg_match("/^09[0-9]{8}$/", $phonenumber) == 0) {
    echo "
    <script> 
        alert('phonenumber format wrong !!');
        location.href='sign-up.html'
    </script>
    ";
    exit;
}
if(!is_numeric($longitude) && !is_numeric($latitude)){
    $lo; $la;
    if(!is_numeric($longitude))
        $lo = 'longitude';
    if(!is_numeric($latitude))
        $la = 'latitude';
    echo "
    <script> 
        alert('Wrong format: $lo $la should be number!!');
        location.href=  'nav.php?id=$account&op=0&order=0';
    </script>
    ";
    exit;
  } 

if(!is_double($longitude + 0) && !is_double($latitude + 0)) {
    $la; $lo;
    if(!is_double($longitude + 0))
        $lo = 'longitude';
    if(!is_double($latitude + 0))
        $la = 'latitude';
    echo "
    <script> 
        alert('$lo $la must be float !!');
        location.href=  'nav.php?id=$account&op=0&order=0';
    </script>
    ";
    exit;
}
if($longitude > 180 || $longitude < -180) {
    echo "
    
    <script> 
        alert('longitude範圍錯誤 !!');
        location.href='sign-up.html'
    </script>
    ";
    exit;
}
if($latitude > 90 || $latitude < -90 ) {
    echo "
    
    <script> 
        alert('latitude範圍錯誤 !!');
        location.href='sign-up.html'
    </script>
    ";
    exit;
}
//register

$sql = "INSERT INTO `user` VALUES (NULL ,?, ?,?,'0', ?,?,?, 'user');";
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql); 
mysqli_stmt_bind_param($stmt, 'sssidd', $account, $password, $name, $phonenumber, $longitude, $latitude); 
mysqli_stmt_execute($stmt); 

$result = $stmt->get_result();
mysqli_stmt_close($stmt);

echo "
<script> 
    alert('Register success !!');
    location.href='index.html'
</script>
";


?>

