<?php
header("Content-Type: text/html; charset=utf8");
include 'config.php';
$account = $_POST['account'];
$sid = $_POST['sid'];
$type = $_POST['Type'];
$sql = 'select goods.name, goods.PID, goods.price from goods where goods.SID = '.$sid;
$stmt = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt, $sql); 
mysqli_stmt_execute($stmt); 
$data =$stmt->get_result();
$price = 0;
while($rs=mysqli_fetch_row($data)){
    if($_POST[$rs[0]] != 0){
        $price = $price + $rs[2] * $_POST[$rs[0]];
        $sql_i = "INSERT INTO amount VALUES (0, ".$rs[1].", ".$_POST[$rs[0]].")";
        $stmt_i = mysqli_stmt_init($link); 
        mysqli_stmt_prepare($stmt_i, $sql_i); 
        mysqli_stmt_execute($stmt_i);
        $result = $stmt_i->get_result();
        mysqli_stmt_close($stmt_i);
    }
}
$sql_o = "INSERT INTO order_list VALUES (0, -1, ".$sid.", ".$price.", NULL, NULL, NULL, NULL, \"".$type."\")";
$stmt_o = mysqli_stmt_init($link); 
mysqli_stmt_prepare($stmt_o, $sql_o); 
mysqli_stmt_execute($stmt_o);
$result = $stmt_o->get_result();
mysqli_stmt_close($stmt_o);
# header('Location:nav.php?id='.$account.'&op=0&order=0');
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
                        $sql_b = 'select goods.img, goods.imgtype, goods.name, goods.price, amount.quantity from amount, goods where amount.OID = 0';
                        $stmt_b = mysqli_stmt_init($link); 
                        mysqli_stmt_prepare($stmt_b, $sql_b); 
                        mysqli_stmt_execute($stmt_b); 
                        $data_b =$stmt_b->get_result();
                        $subtotal = 0;
                        while($result_b = mysqli_fetch_row($data_b)){
                        $subtotal = $subtotal + $result_b[3] * $result_b[4];
                        echo '<tr>';
                        echo '<td><img src="data:'.$result_b[1].';base64,'.$result_b[0].'" /></td>';
                        echo '<td>'.$result_b[2].'</td>';
                        echo '<td>'.$result_b[3].'</td>';
                        echo '<td>'.$result_b[4].'</td>';
                        echo '</tr>';
                        }
                        echo '</tbody>';
                    echo '</table>';
                    $sql_in = 'select order_list.SID, order_list.category from order_list where order_list.UID = -1';
                    $stmt_in = mysqli_stmt_init($link); 
                    mysqli_stmt_prepare($stmt_in, $sql_in); 
                    mysqli_stmt_execute($stmt_in); 
                    $data_in =$stmt_in->get_result();
                    $result = mysqli_fetch_row($data_in);
                    echo 'Subtotal: $'.$subtotal.'<br>';
                    $sql_l = "select ST_Distance_Sphere(POINT(store.longitude,store.latitude),POINT(user.longitude, user.latitude)) from user, store where store.SID = '$result[0]' and user.account = '$account'";
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
                    if($result[1] == 'Pick-Up'){
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
?>