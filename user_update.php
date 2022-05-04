
<?php 
header("Content-Type: text/html; charset=utf8");
include 'config.php';

$uname = $_POST["uname"];
$latitude=$_POST["latitude"];
$longitude=$_POST['longitude'];

//欄位空白
if(($latitude && $longitude ) == 0) {
    echo "
    <script> 
        alert('Please fill all the blank!!');
        location.href= 'nav.php?id=$uname';
    </script>
    
    ";
    
    exit;
}

if((is_double($latitude + 0) && is_double($longitude + 0)) == 0) {
    echo "
    
    <script> 
        alert('經緯度要是float !!');
        location.href=  'nav.php?id=$uname';
    </script>
    ";
    exit;
}
if($longitude > 360 || $longitude < 0) {
    echo "
    
    <script> 
        alert('longitude範圍錯誤 !!');
        location.href=  'nav.php?id=$uname';
    </script>
    ";
    exit;
}
if($latitude > 90 || $latitude < -90 ) {
    echo "
    
    <script> 
        alert('latitude範圍錯誤 !!');
        location.href=  'nav.php?id=$uname';
    </script>
    ";
    exit;
}
//可以直接用uname去拉資料庫，account只為大小寫英文
$sql = "UPDATE user SET latitude='$latitude' WHERE account = '$uname'";
$data = mysqli_query($link, $sql);
$sql = "UPDATE user SET longitude='$longitude' WHERE account = '$uname'";
$data = mysqli_query($link, $sql);

echo "
<script> 
    alert('Update success !!');
    location.href=  'nav.php?id=$uname&op=0';
</script>
";


?>
