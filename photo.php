<?php include("config.php");?>
<?php
    if ($_FILES['myFile']['error'] === UPLOAD_ERR_OK) {
        echo '檔案名稱: ' . $_FILES['myFile']['name'] . '<br/>';
        echo '檔案類型: ' . $_FILES['myFile']['type'] . '<br/>';
        echo '檔案大小: ' . ($_FILES['myFile']['size'] / 1024) . ' KB<br/>';
        echo '暫存名稱: ' . $_FILES['myFile']['tmp_name'] . '<br/>';
    }
    
    

    //
    if($link->query($sql) === TRUE) {
        echo "success";
    } 
    else {
      //echo "Error: " . $sql . "<br>" . $conn->error;
        echo "失敗";
    }

    $sql="SELECT * FROM test";
    $result = $link->query($sql);
    $link->close();
    //查詢結果
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $img=$row["img"];
            $logodata = $img;
            echo '<img src="data:'.$row['imgtype'].';base64,' . $logodata . '" />';
            echo $img;
        }
    }
    else{

    }
    echo $img;
?>