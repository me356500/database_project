<?php 
header("Content-Type: text/html; charset=utf8");
include 'config.php';
$mealname=$_POST["mealname"];
$uname = $_POST["uname"];

$price=$_POST["price"];   
$quantity=$_POST["quantity"];
$sql = "select  SID from user,store where user.UID=store.UID";
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql);                
mysqli_stmt_execute($stmt); 
$data1 =$stmt->get_result();              
$rs1=mysqli_fetch_row($data1); 
if( empty($_FILES["myFile"]["tmp_name"])){
  echo "
  <script> 
      alert('Please fill all the blank!!');
      location.href=  'nav.php?id=$uname';
  </script>
    ";
    exit;
}

$file = fopen($_FILES["myFile"]["tmp_name"], "rb");
$fileContents = fread($file, filesize($_FILES["myFile"]["tmp_name"])); 
  //關閉圖片檔
fclose($file);
  //讀取出來的圖片資料必須使用base64_encode()函數加以編碼：圖片檔案資料編碼
$fileContents = base64_encode($fileContents);
if(($mealname && $price && $quantity && $file) == 0) {
    echo "
    <script> 
        alert('Please fill all the blank!!');
        location.href=  'nav.php?id=$uname';
    </script>
    
    ";
    
    exit;
}
if(!is_numeric($price)){
  echo "
  <script> 
      alert('wrong format!!');
      location.href=  'nav.php?id=$uname';
  </script>
  
  ";
  exit;
} 
if(!is_numeric($quantity)){
  echo "
  <script> 
      alert('wrong format!!');
      location.href=  'nav.php?id=$uname';
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
    location.href=  'nav.php?id=$uname';
</script>
";/*
if($conn->query($sql) === TRUE) {
    echo "成功";
} 
else {
  //echo "Error: " . $sql . "<br>" . $conn->error;
    echo "失敗";
}*/
//$conn->close();



?>

