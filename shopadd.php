
<?php 
header("Content-Type: text/html; charset=utf8");
include 'config.php';
$mealname=$_POST["mealname"];
$price=$_POST["price"];   
$quantity=$_POST["quantity"];  
$sql = "INSERT INTO `goods` VALUES (NULL ,NULL, ?,?, ?);";
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql); 
mysqli_stmt_bind_param($stmt, 'sii', $mealname, $price , $quantity ); 
mysqli_stmt_execute($stmt); 
$result = $stmt->get_result();
mysqli_stmt_close($stmt);

echo "
<script> 
    alert('ADD success !!');
    location.href='index.html'
</script>
";
?>

