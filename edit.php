
<?php 
header("Content-Type: text/html; charset=utf8");
include 'config.php';
$mealname=$_POST["mealname"];
$price=$_POST["price"];   
$quantity=$_POST["quantity"];
$uname = $_POST["account"];
if(( $price && $quantity ) == 0) {
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

$sql = "update goods set price = ?, quantity= ? where name=?";

//UPDATE goods SET price = 40, quantity= 50 where name='applee';
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql); 
mysqli_stmt_bind_param($stmt, 'iis',$price,$quantity,$mealname  ); 
mysqli_stmt_execute($stmt); 
$result = $stmt->get_result();
mysqli_stmt_close($stmt);

echo "
<script> 
    alert('edit success !!');
    location.href=  'nav.php?id=$uname&op=0';
</script>
";
?>