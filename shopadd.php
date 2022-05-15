<?php 
header("Content-Type: text/html; charset=utf8");
include 'config.php';
$mealname=$_POST["mealname"];
$uname = $_POST["uname"];

$price=$_POST["price"];   
$quantity=$_POST["quantity"];
$sql = "select  SID from store where UID = (select UID from user where account = '$uname')"; 
$data1 = mysqli_query($link, $sql);              
$rs1 = mysqli_fetch_row($data1); 
if( empty($_FILES["myFile"]["tmp_name"])){
  echo "
  <script> 
      alert('Please fill all the blank!!');
      location.href=  'nav.php?id=$uname&op=0';
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
        location.href=  'nav.php?id=$uname&op=0';
    </script>
    
    ";
    
    exit;
}
if($quantity < 0|| $price < 0){
    echo "
    <script> 
        alert('Cannot be negative!!');
        location.href=  'nav.php?id=$uname&op=0';
    </script>
    
    ";
    exit;
  } 
if(!is_numeric($price)){
  echo "
  <script> 
      alert('wrong format!!');
      location.href=  'nav.php?id=$uname&op=0';
  </script>
  
  ";
  exit;
} 
if(!is_numeric($quantity)){
  echo "
  <script> 
      alert('wrong format!!');
      location.href=  'nav.php?id=$uname&op=0';
  </script>
  
  ";
  exit;
} 
if(floor($price)!=$price){
  echo "
  <script> 
      alert('wrong format!!');
      location.href=  'nav.php?id=$uname&op=0';
  </script>
  
  ";
  exit;
 }
 if(floor($quantity)!=$quantity){
  echo "
  <script> 
      alert('wrong format!!');
      location.href=  'nav.php?id=$uname&op=0';
  </script>
  
  ";
  exit;
 }

//check goods repeated
$sql = "select * from goods where SID = ? and name =?";
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql); 
mysqli_stmt_bind_param($stmt, 'ss', $rs1[0],$mealname); 
mysqli_stmt_execute($stmt); 
$racc =$stmt->get_result();


if(mysqli_num_rows($racc)) {
    echo "
    <script> 
        alert('goods been adds !!');
        location.href=  'nav.php?id=$account&op=0&order=0';
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
    location.href=  'nav.php?id=$uname&op=0';
</script>
";
?>
