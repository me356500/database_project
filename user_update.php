
<?php 
header("Content-Type: text/html; charset=utf8");
include 'config.php';

$account = $_POST["account"];
$latitude=$_POST["latitude"];
$longitude=$_POST['longitude'];

//欄位空白
if(($latitude && $longitude ) == 0) {
    $la; $lo;
    if(!$latitude)
        $la = 'latitude';
    if(!$longitude)
        $lo = 'longitude';
    echo "
    <script> 
        alert('Blank : $la $lo');
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
//可以直接用account去拉資料庫，account只為大小寫英文
$sql = "UPDATE user SET latitude= ? , longitude = ? WHERE account = ?";
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql); 
mysqli_stmt_bind_param($stmt, 'dds',$latitude, $longitude, $account); 
mysqli_stmt_execute($stmt);
echo "
<script> 
    alert('Update success !!');
    location.href=  'nav.php?id=$account&op=0&order=0';
</script>
";


?>

