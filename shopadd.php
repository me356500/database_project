<?php 
header("Content-Type: text/html; charset=utf8");
include 'config.php';
$mealname=$_POST["mealname"];
$account = $_POST["account"];

$price=$_POST["price"];   
$quantity=$_POST["quantity"];
$sql = "select  SID from store where UID = (select UID from user where account = '$account')"; 
$data1 = mysqli_query($link, $sql);              
$rs1 = mysqli_fetch_row($data1); 
$filepath = $_FILES["myFile"]["tmp_name"];
if(($mealname && $price && $quantity && $filepath) == 0) {
  $m; $p; $q; $f;
  if(!$mealname)
    $m = 'mealname';
  if(!$price)
    $p = 'price';
  if(!$quantity)
    $q = 'quantity';
  if(!$filepath)
    $f = 'file';
  echo "
  <script> 
      alert('Blank : $m $p $q $f');
      location.href=  'nav.php?id=$account&op=0&order=0';
  </script>
  
  ";
  
  exit;
}
$file = fopen($filepath, "rb");
$fileContents = fread($file, filesize($filepath)); 
  //關閉圖片檔
fclose($file);
  //讀取出來的圖片資料必須使用base64_encode()函數加以編碼：圖片檔案資料編碼
$fileContents = base64_encode($fileContents);

if(!is_numeric($price) || !is_numeric($quantity) ){
  $p; $q;
  if(!is_numeric($price))
    $p = 'price';
  if(!is_numeric($quantity))
    $q = 'quantity';
  echo "
  <script> 
      alert('Wrong format: $p $q should be number!!');
      location.href=  'nav.php?id=$account&op=0&order=0';
  </script>
  ";
  exit;
} 
  if($price < 0 || $quantity < 0){
    $p; $q;
    if($price < 0)
      $p = 'price';
    if($quantity < 0)
      $q = 'quantity';
    echo "
    <script> 
        alert('Wrong format: $p $q cannot be negative!!');
        location.href=  'nav.php?id=$account&op=0&order=0';
    </script>
    
    ";
    exit;
  } 
  
  if(($quantity - floor($quantity + '0') ) > 0 || ($price - floor($price + '0')) > 0 ){
    $p; $q;
    if(($price - floor($price + '0')) > 0 )
      $p = 'price';
    if(($quantity - floor($quantity + '0') ) > 0)
      $q = 'quantity';
    echo "
    <script> 
        alert('Wrong format: $p $q should be integer!!');
        location.href=  'nav.php?id=$account&op=0&order=0';
    </script>
    
    ";
    exit;
  } 
 
$sql = "select * from goods where SID = ? and name =?";
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql); 
mysqli_stmt_bind_param($stmt, 'ss', $rs1[0],$mealname); 
mysqli_stmt_execute($stmt); 
$racc =$stmt->get_result();
if(mysqli_num_rows($racc)) {
    echo "
    <script> 
        alert('Goods have been added !!');
        location.href= 'nav.php?id=$account&op=0&order=0';
    </script>
    ";
    exit;
} 



$imgType=$_FILES["myFile"]["type"];

$sql = "INSERT INTO `goods` VALUES (NULL ,?, ?,?, ?,?,?);";
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql); 
mysqli_stmt_bind_param($stmt, 'isiiss',$rs1[0], $mealname, $price , $quantity,$fileContents, $imgType ); 
mysqli_stmt_execute($stmt); 
$result = $stmt->get_result();
mysqli_stmt_close($stmt);

echo "
<script> 
    alert('ADD success !!');
    location.href=  'nav.php?id=$account&op=0&order=0';
</script>
";
?>