<?php
header("Content-Type: text/html; charset=utf8");
include 'config.php';
$sid = $_COOKIE['sid'];
$type = $_COOKIE['Type'];
session_start();
$id = $_GET['id'];

$_SESSION['account'] = ".$id.";
echo '<div class="modal fade" id="calculate"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">';
echo '<div class="modal-dialog">';
      echo '<div class="modal-content">';
        echo '<div class="modal-header">';
          echo '<button type="button" class="close" data-dismiss="modal">&times;</button>';
          echo '<h4 class="modal-title">order details</h4>';
        echo '</div>';
        echo '<div class="modal-body">';
          echo '<div class="row">';
            echo '<div class="  col-xs-12">';
              echo '<table class="table" style=" margin-top: 15px;">';
                echo '<thead>';
                  echo '<tr>';
                    echo '<th scope="col">Picture</th>';
                    echo '<th scope="col">meal name</th>';
                    echo '<th scope="col">price</th>';
                    echo '<th scope="col">Order Quantity</th>';
                  echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                
                $sql_b = 'select goods.img, goods.imgtype, goods.name, goods.price, goods.PID from goods where goods.SID = '.$sid;
                //$sql_b = "select goods.img, goods.imgtype, goods.name, goods.price, goods.PID from goods where goods.SID = ".getcookie('sid');
                $stmt_b = mysqli_stmt_init($link); 
                mysqli_stmt_prepare($stmt_b, $sql_b); 
                mysqli_stmt_execute($stmt_b); 
                $data_b =$stmt_b->get_result();
                $subtotal = 0;
                while($result_b = mysqli_fetch_row($data_b)){
                  $subtotal = $subtotal + $result_b[3] * (int)$_COOKIE['pid'.$result_b[4]];
                  echo '<tr>';
                  echo '<td><img src="data:'.$result_b[1].';base64,'.$result_b[0].'" /></td>';
                  echo '<td>'.$result_b[2].'</td>';
                  echo '<td>'.$result_b[3].'</td>';
                  echo '<td>'.$_COOKIE['pid'.$result_b[4]].'</td>';
                  echo '</tr>';
                }
                echo '</tbody>';
              echo '</table>';
              echo 'Subtotal: $'.$subtotal.'<br>';
              $sql_l = "select ST_Distance_Sphere(POINT(store.longitude,store.latitude),POINT(user.longitude, user.latitude)) from user, store where store.SID = ".$_COOKIE['sid']." and user.account = '$id'";
              $stmt_l = mysqli_stmt_init($link); 
              mysqli_stmt_prepare($stmt_l, $sql_l); 
              mysqli_stmt_execute($stmt_l); 
              $data_l =$stmt_l->get_result();
              $delivery=mysqli_fetch_row($data_l);
              $t = $delivery[0] / 100;
              $fee = round($t);
              if($fee < 10){
                $fee = 10;
              }
              if($_COOKIE['Type'] == 'Pick-Up'){
                $fee = 0;
              }
              echo 'Delivery fee: $'.$fee.'<br>';
              $total = $subtotal + $fee;
              echo 'Total Price: $'.$total;
            echo '</div>';
          echo '</div>';
        echo '</div>';
      echo '</div>';
    echo '</div>';
    echo '</div>';
?>