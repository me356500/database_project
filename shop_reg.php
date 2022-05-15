
<?php 
header("Content-Type: text/html; charset=utf8");
include 'config.php';
$name=$_POST["shop_name"];
$account = $_POST["account"];
$category = $_POST["category"];
$latitude=$_POST["latitude"];
$longitude=$_POST['longitude'];
//欄位空白
if(($name && $latitude && $longitude && $category) == 0) {
    $na; $la; $lo; $ca;
    if(!$name) 
        $na = 'name';
    if(!$latitude)
        $la = 'latitude';
    if(!$longitude)
        $lo = 'longitude';
    if(!$category)
        $ca = 'category';
    echo "
    <script> 
        alert('Blank : $na $la $lo $ca');
        location.href=  'nav.php?id=$account&op=0&order=0';
    </script>
    
    ";
    
    exit;
}
//check name repeated
$sql = "select * from store where name = ?";
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql); 
mysqli_stmt_bind_param($stmt, 's', $name); 
mysqli_stmt_execute($stmt); 
$racc =$stmt->get_result();
if(mysqli_num_rows($racc)) {
    echo "
    <script> 
        alert('Shop_name has been registered !!');
        location.href=  'nav.php?id=$account&op=0&order=0';
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
        location.href=  'nav.php?id=$account&op=0&order=0';
    </script>
    ";
    exit;
}
if($latitude > 90 || $latitude < -90 ) {
    echo "
    
    <script> 
        alert('latitude範圍錯誤 !!');
        location.href=  'nav.php?id=$account&op=0&order=0';
    </script>
    ";
    exit;
}
//可以直接用uname去拉資料庫，account只為大小寫英文
$sql = "select UID from user where account = '$account' ";
$data = mysqli_query($link, $sql);
$rs = mysqli_fetch_row($data);
$uid = $rs[0];

$sql = "select phonenumber from user where account = '$account' ";
$data = mysqli_query($link, $sql);
$rs = mysqli_fetch_row($data);
$phonenumber = $rs[0];

$sql = "INSERT INTO `store` VALUES (NULL ,?,?,?,?,?,?);";
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql); 
mysqli_stmt_bind_param($stmt, 'isidds', $uid, $name, $phonenumber, $longitude, $latitude, $category); 
mysqli_stmt_execute($stmt); 
$result = $stmt->get_result();
mysqli_stmt_close($stmt);
echo "
<script> 
    alert('Register success !!');
    location.href=  'nav.php?id=$account&op=0&order=0';
</script>
";


?>

