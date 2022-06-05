<?php 
header("Content-Type: text/html; charset=utf8");
include 'config.php';
$mealname = $_POST["mealname"];
$shopname = $_POST["shopname"];
$price = $_POST["price"];   
$quantity = $_POST["quantity"];
$account = $_POST["account"];
$goodid = $_POST["goodid"];



if(( $price && $quantity ) == 0) {
    $p; $q;
    if(!$price) 
        $p = 'price';
    if(!$quantity) 
        $q = 'quantity';   
    echo "
    <script> 
        alert('Blank : $p $q');
        location.href=  'nav.php?id=$account&op=0&order=0';
    </script>
    ";
    exit;
}
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
     
  

$sql = "update goods set price = ?, quantity= ? where PID=? and SID=$shopname ";
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql); 
mysqli_stmt_bind_param($stmt, 'iii',$price,$quantity,$goodid  ); 
mysqli_stmt_execute($stmt); 
$result = $stmt->get_result();
mysqli_stmt_close($stmt);
echo "
<script> 
    alert('Edit success !!');
    location.href=  'nav.php?id=$account&op=0&order=0';
</script>
";
?>
