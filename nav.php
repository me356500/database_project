<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <title>Hello, world!</title>
</head>

<body>
 
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand " href="#">WebSiteName</a>
      </div>

    </div>
  </nav>
  <div class="container">

    <ul class="nav nav-tabs">
      <li class="active"><a href="#home">Home</a></li>
      <li><a href="#menu1">shop</a></li>


    </ul>
    
    <div class="tab-content">
      <div id="home" class="tab-pane fade in active">
        <h3>Profile</h3>
        <a href="index.html">Logout</a>
        <div class="row">
          <div class="col-xs-10">

            <?php
              $conn= require_once "config.php";
              $id = $_GET['id'];
              $sql = "select name from user where account = ?";
              $stmt = mysqli_stmt_init($link); 
              mysqli_stmt_prepare($stmt, $sql); 
              mysqli_stmt_bind_param($stmt, 's', $id); 
              mysqli_stmt_execute($stmt); 
              $data =$stmt->get_result();
              
            ?>
            Accouont: 
            <?php
             $rs=mysqli_fetch_row($data);
             echo $rs[0];
            ?>
            , Identity:
            <?php
             $sql = "select identity from user where account = ?";
             $stmt = mysqli_stmt_init($link); 
             mysqli_stmt_prepare($stmt, $sql); 
             mysqli_stmt_bind_param($stmt, 's', $id); 
             mysqli_stmt_execute($stmt); 
             $data =$stmt->get_result();
            
             $rs=mysqli_fetch_row($data);
             echo $rs[0];
            ?> 
            , PhoneNumber:
            <?php
             $sql = "select phonenumber from user where account = ?";
             $stmt = mysqli_stmt_init($link); 
             mysqli_stmt_prepare($stmt, $sql); 
             mysqli_stmt_bind_param($stmt, 's', $id); 
             mysqli_stmt_execute($stmt); 
             $data =$stmt->get_result();
             $rs=mysqli_fetch_row($data);
             echo "0";
             echo $rs[0];
            ?>
            , location: 
            <?php
             $sql = "select latitude,longitude from user where account = ?";
             $stmt = mysqli_stmt_init($link); 
             mysqli_stmt_prepare($stmt, $sql); 
             mysqli_stmt_bind_param($stmt, 's', $id); 
             mysqli_stmt_execute($stmt); 
             $data =$stmt->get_result();
             $rs=mysqli_fetch_row($data);
             
             echo $rs[0];
             echo ", ";
             echo $rs[1];
            ?>
            
            <button type="button " style="margin-left: 5px;" class=" btn btn-info " data-toggle="modal"
            data-target="#location">edit location</button>
            
            <!--  -->
            <div class="modal fade" id="location"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog  modal-sm">
              
                <div class="modal-content">
                <form action="user_update.php" method="POST">
                  <?php
                  $acc = $_GET['id'];
                  echo '<input type="hidden" name="account" value='.$acc.'>';
                  ?>

                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">edit location</h4>
                  </div>
                  <div class="modal-body">
                    <label class="control-label " for="latitude">latitude</label>
                    <input type="text" class="form-control" id="latitude" placeholder="enter latitude" name = "latitude">
                      <br>
                      <label class="control-label " for="longitude">longitude</label>
                    <input type="text" class="form-control" id="longitude" placeholder="enter longitude" name = "longitude">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-default" >Edit</button>
                  </div>

                </form>
                </div>
               
              </div>
            </div>
            
            


            <!--  -->
            walletbalance:
            <?php
             $sql = "select balance from user where account = ?";
             $stmt = mysqli_stmt_init($link); 
             mysqli_stmt_prepare($stmt, $sql); 
             mysqli_stmt_bind_param($stmt, 's', $id); 
             mysqli_stmt_execute($stmt); 
             $data =$stmt->get_result();
             $rs=mysqli_fetch_row($data);
             echo $rs[0];
            ?> 
            
            <!-- Modal -->
            <button type="button " style="margin-left: 5px;" class=" btn btn-info " data-toggle="modal"
              data-target="#myModal">Add value</button>
            <div class="modal fade" id="myModal"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog  modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add value</h4>
                  </div>
                  <div class="modal-body">
                    <input type="text" class="form-control" id="Meal" placeholder="enter add value">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Add</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- 
                
             -->
        <h3>Search</h3>
        <div class=" row  col-xs-8">
        <form class="form-horizontal" action="action_page.php" method="POST">
          <?php
              $acc = $_GET['id'];
              echo '<input type="hidden" name="account" value='.$acc.'>';
            ?>  
          <div class="form-group">
              <label class="control-label col-sm-1" for="Shop">Shop</label>
              <div class="col-sm-5">
              <input type="text" class="form-control" placeholder="Enter Shop name" name="shopname">
              </div>
              <label class="control-label col-sm-1" for="distance">distance</label>
              <div class="col-sm-5">


              <select class="form-control" id="sel1" name="distance">
                  <option>all</option>
                  <option>near</option>
                  <option>medium </option>
                  <option>far</option>

                </select>
              </div>

            </div>

            <div class="form-group">

              <label class="control-label col-sm-1" for="Price">Price</label>
              <div class="col-sm-2">

                <input type="text" class="form-control" name="lowerbound">

              </div>
              <label class="control-label col-sm-1" for="~">~</label>
              <div class="col-sm-2">

                <input type="text" class="form-control"name="upperbound">

              </div>
              <label class="control-label col-sm-1" for="Meal">Meal</label>
              <div class="col-sm-5">
              <input type="text" list="Meals" class="form-control" id="Meal" placeholder="Enter Meal" name="meal">
                
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-1" for="category"> category</label>
            
              
                <div class="col-sm-5">
                <input type="text" list="categorys" class="form-control" id="category" placeholder="Enter shop category" name="category">
                  
                </div>
                <button type="submit" style="margin-left: 18px;"class="btn btn-primary">Search</button>
              
            </div>
            
          </form>
          <?php
            $id = $_GET['id'];
            $op = $_GET['op'];
            if($op == 1){
              $lowerbound=$_GET["lowerbound"];
              $upperbound=$_GET["upperbound"];
              $category=$_GET["category"];
              $distance=$_GET["distance"];
              $meal=$_GET["meal"];
              $name=$_GET["shopname"];
            }
            else{
              $lowerbound = '0';
              $upperbound = '999999';
              $category = '';
              $meal = '';
              $name = '';
              $distance = 'all';
            }
            echo '<a href="nav.php?id='.$id.'&op=1&shopname='.$name.'&meal='.$meal.'&distance='.$distance.'&category='.$category.'&lowerbound='.$lowerbound.'&upperbound='.$upperbound.'&order=0">order by name</a><br>';
            echo '<a href="nav.php?id='.$id.'&op=1&shopname='.$name.'&meal='.$meal.'&distance='.$distance.'&category='.$category.'&lowerbound='.$lowerbound.'&upperbound='.$upperbound.'&order=1">order by category</a><br>';
            echo '<a href="nav.php?id='.$id.'&op=1&shopname='.$name.'&meal='.$meal.'&distance='.$distance.'&category='.$category.'&lowerbound='.$lowerbound.'&upperbound='.$upperbound.'&order=2">order by distance</a>';
          ?>


        </div>
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
                <?php
                  $id = $_GET['id'];
                  $op = $_GET['op'];
                  if($op == 1){
                    $lowerbound=$_GET["lowerbound"];
                    $upperbound=$_GET["upperbound"];
                    $category=$_GET["category"];
                    $distance=$_GET["distance"];
                    $meal=$_GET["meal"];
                    $name=$_GET["shopname"];
                    $order=$_GET['order'];
                    if($lowerbound == ''){
                      $lowerbound = '0';
                    }
                    if($upperbound == ''){
                      $upperbound = '999999';
                    }
                    if($distance == 'near'){
                      $dis_1 = '0';
                      $dis_2 = "2000";
                    }
                    else if($distance == 'medium'){
                      $dis_1 = '2000';
                      $dis_2 = "10000";
                    }
                    else if($distance == 'all') {
                      $dis_1 = '0';
                      $dis_2 = "999999999";
                    }
                    else{
                      $dis_1 = '10000';
                      $dis_2 = "999999999";
                    }
                    if($order == '0'){
                      $order = "store.name";
                    }
                    else if($order == '1'){
                      $order = "store.foodtype";
                    }
                    else if($order == '2'){
                      $order = "distant";
                    }
                  }
                  else{
                    $lowerbound = '0';
                    $upperbound = '999999';
                    $category = '';
                    $meal = '';
                    $name = '';
                    $dis_1 = '0';
                    $dis_2 = "999999999";
                    $order = "store.name";
                    if($order == '0'){
                      $order = "store.name";
                    }
                    else if($order == '1'){
                      $order = "store.foodtype";
                    }
                    else if($order == '2'){
                      $order = "distant";
                    }
                  }
                  $name = "%".$name."%";
                  $category = "%".$category."%";
                  $meal = "%".$meal."%";
                  $sql = "select distinct store.SID, store.name, store.foodtype, ST_Distance_Sphere(POINT(store.longitude,store.latitude),POINT(user.longitude, user.latitude)) as distant from store, goods, user where store.name like ? and foodtype like ? and goods.SID = store.SID and goods.price >= ? and goods.price <= ? and goods.name like ? and user.account = ? and ST_Distance_Sphere(POINT(store.longitude,store.latitude),POINT(user.longitude, user.latitude)) >= ? and ST_Distance_Sphere(POINT(store.longitude,store.latitude),POINT(user.longitude, user.latitude)) < ? order by $order";
                  $stmt = mysqli_stmt_init($link); 
                  mysqli_stmt_prepare($stmt, $sql);
                  mysqli_stmt_bind_param($stmt, 'ssiissdd', $name, $category, $lowerbound, $upperbound, $meal, $id, $dis_1, $dis_2);
                  mysqli_stmt_execute($stmt); 
                  $data =$stmt->get_result();
                  $i = 1;
                  while($rs=mysqli_fetch_row($data)) {
                   
                    echo '<tr>';
                    echo "<th scope=\"row\">" . $i . "</th>";
                    echo "<td>" . $rs[1] . "</td>";
                    echo "<td>" . $rs[2] . "</td>";
                    if($rs[3] > 10000){
                      echo "<td>far</td>";
                    }
                    else if($rs[3] < 2000){
                      echo "<td>near</td>";
                    }
                    else{
                      echo "<td>medium</td>";
                    }
                    echo "<td>  <button type=\"button\" class=\"btn btn-info \" data-toggle=\"modal\" data-target=\"#" . $rs[0] . "\">Open menu</button></td>";
                    echo '</tr>';
                    $i++;
                  }
                 
                  
                ?>
                
            
                </tr>
           

              </tbody>
            </table>
            <?php
  
  $sql = "select distinct SID from store";
  
  $stmt = mysqli_stmt_init($link); 
  mysqli_stmt_prepare($stmt, $sql); 
  mysqli_stmt_execute($stmt); 
  $data =$stmt->get_result();
  while($rs=mysqli_fetch_row($data)){
    
    echo '<div class="modal fade" id="' . $rs[0] . '"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">';
    echo '<div class="modal-dialog">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<button type="button" class="close" data-dismiss="modal">&times;</button>';
    echo '<h4 class="modal-title">menu</h4>';
    echo '</div>';
    echo '<div class="modal-body">';
    echo '<div class="row">';
    echo '<div class="  col-xs-12">';
    echo '<table class="table" style=" margin-top: 15px;">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">#</th>';
    echo '<th scope="col">Picture</th>';
    echo '<th scope="col">meal name</th>';
    echo '<th scope="col">price</th>';
    echo '<th scope="col">Quantity</th>';
    echo '<th scope="col">Order check</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    $sql_goods = "select distinct name, price, quantity, img, imgtype, PID from goods where goods.SID = " . $rs[0];
    $stmt_2 = mysqli_stmt_init($link); 
    mysqli_stmt_prepare($stmt_2, $sql_goods); 
    mysqli_stmt_execute($stmt_2); 
    $data_2 =$stmt_2->get_result();
    $j = 1;
    
    while($rss=mysqli_fetch_row($data_2)){
      echo '<tr>';
      echo "<th scope=\"row\">" . $j . "</th>";
      echo '<td><img src="data:' . $rss[4] . ';base64,' . $rss[3] . '" /></td>';
      echo "<td>" . $rss[0] . "</td>";
      echo "<td>" . $rss[1] . "</td>";
      echo "<td>" . $rss[2] . "</td>";
      echo "<td> <input type=\"checkbox\" id=" . $rss[0] . " value=" . $rss[0] . "></td>";
      $j++;
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="modal-footer">';
    echo '<button type="button" class="btn btn-default" data-dismiss="modal">Order</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
  }
?>

                <!-- Modal -->
   
          </div>

        </div>
      </div>
      <div id="menu1" class="tab-pane fade">

      <form action="shop_reg.php" class="fh5co-form animate-box" data-animate-effect="fadeIn" method="post">
        <h3> Start a business </h3>
        <a href="index.html">Logout</a>
        <div class="form-group ">
          <div class="row">
            <div class="col-xs-2">
              <label for="ex5">shop name</label>
              <?php
              $id = $_GET['id'];
              $sql = "select name from store where UID = (select UID from user where account = '$id')";
              $data = mysqli_query($link, $sql);              
              
              if( !empty($rs=mysqli_fetch_row($data))){
                
                echo "<input class='form-control' id='ex5' type='text' value='$rs[0]' name = 'shop_name' readonly><br>";
              }
              else if( empty($rs=mysqli_fetch_row($data))){
                
                echo "<input class='form-control' id='ex5' type='text' placeholder='macdonald' name = 'shop_name'><br>";
              }               
              ?> 
            </div>
            <div class="col-xs-2">
              <label for="ex5">shop category</label>
              <?php
              $id = $_GET['id'];
              $sql = "select foodtype from store where UID = (select UID from user where account = '$id')";
              $data = mysqli_query($link, $sql);               
              if( !empty($rs=mysqli_fetch_row($data))){
                echo "<input class='form-control' id='ex5' type='text' value='$rs[0]' name = 'category' readonly><br>";
              }
              else if( empty($rs=mysqli_fetch_row($data))){
                
                echo "<input class='form-control' id='ex5' type='text' placeholder='fastfood' name = 'category'><br>";
              }  
              ?> 
            </div>
            <div class="col-xs-2">
              <label for="ex6">latitude</label>
              <?php
              $id = $_GET['id'];
              $sql = "select latitude from store where UID = (select UID from user where account = '$id')";
              $data = mysqli_query($link, $sql);               
              if( !empty($rs=mysqli_fetch_row($data))){
                echo "<input class='form-control' id='ex5' type='text' value='$rs[0]' name = 'latitude' readonly><br>";
              }
              else if( empty($rs=mysqli_fetch_row($data))){
                
                echo "<input class='form-control' id='ex5' type='text' placeholder='80.5' name = 'latitude'><br>";
              }  
              ?> 
            </div>
            <div class="col-xs-2">
              <label for="ex8">longitude</label>
              <?php
              $id = $_GET['id'];
              $sql = "select longitude from store where UID = (select UID from user where account = '$id')";
              $data = mysqli_query($link, $sql);               
              if( !empty($rs=mysqli_fetch_row($data))){
                echo "<input class='form-control' id='ex5' type='text' value='$rs[0]' name = 'longitude' readonly><br>";
              }
              else if( empty($rs=mysqli_fetch_row($data))){
                
                echo "<input class='form-control' id='ex5' type='text' placeholder='23.5' name = 'longitude'><br>";
              }  
              ?> 
            </div>
          </div>
        </div>

        <?php
        $acc = $_GET['id'];
        echo '<input type="hidden" name="account" value='.$acc.'>';
        ?>
        <div class=" row" style=" margin-top: 25px;">
          <div class=" col-xs-3">
            <?php
             
             $acc = $_GET['id'];
             //account 已經過濾過不用防injection
             $sql = "select * from store where uid = (select uid from user where account = '$acc')";
             $data = mysqli_query($link, $sql);
             if(mysqli_num_rows($data)) {
                echo '<button type="submit" class="btn btn-primary" disabled >register</button>';
             }
             else {
              echo '<button type="submit" class="btn btn-primary" >register</button>';
             }
            
            ?>
          </div>
        </div>
        </form>

        
        <hr>
        <h3>ADD</h3>
        <form action="shopadd.php" method="post" Enctype="multipart/form-data">
        <div class="form-group ">
          <div class="row">

            <div class="col-xs-6">
              <label for="ex3">meal name</label>
              <input class="form-control" id="ex3" type="text"  name = "mealname">
            </div>
          </div>
          <div class="row" style=" margin-top: 15px;">
            <div class="col-xs-3">
              <label for="ex7">price</label>
              <input class="form-control" id="ex7" type="text" name = "price">
            </div>
            <div class="col-xs-3">
              <label for="ex4">quantity</label>
              <input class="form-control" id="ex4" type="text" name = "quantity">
            </div>
          </div>


          <div class="row" style=" margin-top: 25px;">
          
            <div class=" col-xs-3">
              <label for="ex12">上傳圖片</label>
              <input id="myFile" type="file" name="myFile" multiple class="file-loading">

            </div>
            <div class=" col-xs-3">

              <button style=" margin-top: 15px;" type="submit" class="btn btn-primary">Add</button>
            </div>
            <?php
                $acc = $_GET['id'];
                echo '<input type="hidden" name="uname" value='.$acc.'>';
                ?>
                 
            </form>
          </div>
        </div>

        <div class="row">
          <div class="  col-xs-8">
            <table class="table" style=" margin-top: 15px;">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Picture</th>
                  <th scope="col">meal name</th>
              
                  <th scope="col">price</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Edit</th>
                  <th scope="col">Delete</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                <?php
                    $id = $_GET['id'];
                    echo '<input type="hidden" name="account" value='.$acc.'>';
                    $sql = "select distinct goods.PID, img, imgtype,goods.name, goods.price, goods.quantity from goods where SID=(select SID from store where UID = (select UID from user where account = '$id'))";
                    $data = mysqli_query($link, $sql);
                    $i = 1;
                    while($rs=mysqli_fetch_row($data)) {
                      echo '<form action="shop_edit.php"  method="post">';
                      
                      echo '<tr>';
                      echo "<th scope=\"row\">" . $i . "</th>";
                      echo '<td><img src="data:' . $rs[2] . ';base64,' . $rs[1] . '" /></td>';                     
                      echo "<td>" . $rs[3] . "</td>";
                      echo "<td>" . $rs[4] . "</td>";
                      echo "<td>" . $rs[5] . "</td>";
                      echo '<input type="hidden" name="mealname" value='.$rs[3].'>';   
                      echo '<input type="hidden" name="account" value='.$id.'>';                
                      echo "<td>  <button type=\"button\" class=\"btn btn-info \" data-toggle=\"modal\" data-target=\"#" . $rs[0] . "\">Edit</button></td>";
                      echo '<div class="modal fade" id="' . $rs[0] . '"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">';
                      echo '<div class="modal-dialog" role="document">';
                      echo '<div class="modal-content">';
                      echo '<div class="modal-header">';
                      echo '<h5 class="modal-title" id="staticBackdropLabel">'. $rs[3] . ' Edit</h5>';
                      
                      echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                      echo '<span aria-hidden="true">&times;</span>';
                      echo '</button>';
                      echo ' </div>';
                            echo '<div class="modal-body">';
                                echo '<div class="row" >';
                                  echo '<div class="col-xs-6">';
                                    echo '<label for="ex71">price</label>';
                                    echo '<input class="form-control" id="ex71" type="text" name = "price">';
                                  echo '</div>';
                                  echo '<div class="col-xs-6">';
                                    echo '<label for="ex41">quantity</label>';
                                    echo '<input class="form-control" id="ex41" type="text" name = "quantity">';
                                  echo '</div>';
                                echo '</div>';
                            echo '</div>';
                            echo '<div class="modal-footer">';
                                echo '<button type = "submit" class="btn btn-secondary" >Edit</button> ';    
                            echo '</div>';
                          echo '</div>';
                        echo '</div>';
                      echo '</div>';   
                      echo '</form>';
                      
                      echo '<form action="shop_delete.php"  method="post">';
                      echo '<input type="hidden" name="pid" value='.$rs[0].'>'; 
                      echo '<input type="hidden" name="account" value='.$id.'>';  
                      echo "<td>  <button type=\"submit\" class=\"btn btn-danger \" data-toggle=\"modal\" data-target=\"#" . $rs[0] . "\">delete</button></td>";
                      echo '</form>';
                      echo '</tr>';
                       $i++;
                      
                      
                    }
                    ?>
                  
                  </tr>
              </tbody>
            </table>
          </div>

        </div>


      </div>



    </div>
  </div>

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
  <script>
    $(document).ready(function () {
      $(".nav-tabs a").click(function () {
        $(this).tab('show');
      });
    });
  </script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>