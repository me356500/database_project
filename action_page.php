<?php
    header("Content-Type: text/html; charset=utf8");
    include "config.php";
    $lowerbound=$_POST["lowerbound"];
    $upperbound=$_POST["upperbound"];
    $category=$_POST["category"];
    $distance=$_POST["distance"];
    $meal=$_POST["meal"];
    $name=$_POST["shopname"];

    if(!$lowerbound){
        $lowerbound = '0';
    }
    if(!$upperbound){
        $upperbound = '999999';
    }
    if(!$name){
        $name = '';
    }
    if(!$category){
        $category = '';
    }
    if(!$meal){
        $meal = '';
    }
    $sql = "select distinct store.SID, store.name, store.foodtype, store.latitude, store.longitude from store, goods where store.name like '%$name%' and foodtype like '%$category%' and goods.SID = store.SID and goods.price >= $lowerbound and goods.price <= $upperbound and goods.name like '%$meal%'";
    $stmt = mysqli_stmt_init($link); 
    mysqli_stmt_prepare($stmt, $sql); 
    mysqli_stmt_execute($stmt); 
    $data =$stmt->get_result();
    $i = 1;
    echo '<!doctype html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<!-- Required meta tags -->';
    echo '<meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '';
    echo '<!-- Bootstrap CSS -->';
    echo '';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">';
    echo '';
    echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>';
    echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>';
    echo '<title>Hello, world!</title>';
    echo '</head>';
    echo '';
    echo '<body>';
    echo '';
    echo '<div class="row">';
    echo '<div class="  col-xs-8">';
    echo '<table class="table" style=" margin-top: 15px;">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">#</th>';
    echo '';
    echo '<th scope="col">shop name</th>';
    echo '<th scope="col">shop category</th>';
    echo '<th scope="col">Distance</th>';
    echo '';
    echo '</tr>';
    echo '</thead>';
    echo '';
    echo '<tbody>';
    while($rs=mysqli_fetch_row($data)) {
        echo '<tr>';
        echo "<th scope=\"row\">" . $i . "</th>";
        echo "<td>" . $rs[1] . "</td>";
        echo "<td>" . $rs[2] . "</td>";
        echo "<td>near<td>";
        echo "<td>  <button type=\"button\" class=\"btn btn-info \" data-toggle=\"modal\" data-target=\"#macdonald\">Open menu</button></td>";
        echo '</tr>';
        $i++;
    }
    echo '</tbody>';
    echo '</table>';
    
    echo '<div class="modal fade" id="macdonald"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">';
    echo '<div class="modal-dialog">';
    echo '';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<button type="button" class="close" data-dismiss="modal">&times;</button>';
    echo '<h4 class="modal-title">menu</h4>';
    echo '</div>';
    echo '<div class="modal-body">';
    echo '';
    echo '<div class="row">';
    echo '<div class="  col-xs-12">';
    echo '<table class="table" style=" margin-top: 15px;">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">#</th>';
    echo '<th scope="col">Picture</th>';
    echo '';
    echo '<th scope="col">meal name</th>';
    echo '';
    echo '<th scope="col">price</th>';
    echo '<th scope="col">Quantity</th>';
    echo '';
    echo '<th scope="col">Order check</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    echo '<tr>';
    echo '<th scope="row">1</th>';
    echo '<td><img src="Picture/1.jpg" with="50" heigh="10" alt="Hamburger"></td>';
    echo '';
    echo '<td>Hamburger</td>';
    echo '';
    echo '<td>80 </td>';
    echo '<td>20 </td>';
    echo '';
    echo '<td> <input type="checkbox" id="cbox1" value="Hamburger"></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th scope="row">2</th>';
    echo '<td><img src="Picture/2.jpg" with="10" heigh="10" alt="coffee"></td>';
    echo '';
    echo '<td>coffee</td>';
    echo '';
    echo '<td>50 </td>';
    echo '<td>20</td>';
    echo '';
    echo '<td><input type="checkbox" id="cbox2" value="coffee"></td>';
    echo '</tr>';
    echo '';
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '';
    echo '</div>';
    echo '';
    echo '</div>';
    echo '<div class="modal-footer">';
    echo '<button type="button" class="btn btn-default" data-dismiss="modal">Order</button>';
    echo '</div>';
    echo '</div>';
    echo '';
    echo '</div>';
    echo '</div>';
    echo '</body>';
?>
<!--
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <title>Hello, world!</title>
</head>

<body>

<div class="row">
    <div class="  col-xs-8">
        <table class="table" style=" margin-top: 15px;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                
                    <th scope="col">shop name</th>
                    <th scope="col">shop category</th>
                    <th scope="col">Distance</th>
               
                </tr>
            </thead>

            <tbody>
                <tr>
                </tr>
           

            </tbody>
        </table>





<div class="modal fade" id="macdonald"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
    
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">menu</h4>
        </div>
        <div class="modal-body">
  
         <div class="row">
          <div class="  col-xs-12">
            <table class="table" style=" margin-top: 15px;">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Picture</th>
                 
                  <th scope="col">meal name</th>
               
                  <th scope="col">price</th>
                  <th scope="col">Quantity</th>
                
                  <th scope="col">Order check</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td><img src="Picture/1.jpg" with="50" heigh="10" alt="Hamburger"></td>
                
                  <td>Hamburger</td>
                
                  <td>80 </td>
                  <td>20 </td>
              
                  <td> <input type="checkbox" id="cbox1" value="Hamburger"></td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td><img src="Picture/2.jpg" with="10" heigh="10" alt="coffee"></td>
                 
                  <td>coffee</td>
             
                  <td>50 </td>
                  <td>20</td>
              
                  <td><input type="checkbox" id="cbox2" value="coffee"></td>
                </tr>

              </tbody>
            </table>
          </div>

        </div>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Order</button>
        </div>
      </div>
      
    </div>
  </div>
</body>
                    -->