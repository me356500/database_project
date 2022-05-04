<?php 
    include("config.php");
    if ($_FILES['myFile']['error'] === UPLOAD_ERR_OK) {
        echo '檔案名稱: ' . $_FILES['myFile']['name'] . '<br/>';
        echo '檔案類型: ' . $_FILES['myFile']['type'] . '<br/>';
        echo '檔案大小: ' . ($_FILES['myFile']['size'] / 1024) . ' KB<br/>';
        echo '暫存名稱: ' . $_FILES['myFile']['tmp_name'] . '<br/>';
    }
    
    //開啟圖片檔
    $file = fopen($_FILES['myFile']['tmp_name'], "rb");
    // 讀入圖片檔資料
    $fileContents = fread($file, filesize($_FILES['myFile']['tmp_name'])); 
    //關閉圖片檔
    fclose($file);
    //讀取出來的圖片資料必須使用base64_encode()函數加以編碼：圖片檔案資料編碼
    $fileContents = base64_encode($fileContents);
  

    //組合查詢字串
    $imgType=$_FILES['myFile']['type'];
    $sql="INSERT INTO test VALUES ('$fileContents','$imgType')";

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
        }
    }
    else{

    }
    echo $img;
?>