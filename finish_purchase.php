<?php
    $link=require_once "config.php";

    $purchaseNumber = $_POST['number'];

    $sql = "SELECT 進貨狀態 FROM 進貨單 WHERE 進貨單編號='$purchaseNumber'";
    $result = $link->query($sql);
    $row = $result->fetch_assoc();

    if($row['進貨狀態'] === '1'){
        echo "
        <script>
        window.alert('此進貨單已進貨完成');
        window.history.back();
        </script>";
    }
    else{
        $sql = "SELECT 零件編號,數量 FROM 進貨單明細 WHERE 進貨單編號='$purchaseNumber'";
        $result1 = $link->query($sql);

        if($result1->num_rows > 0) {
            $i = 0;
            while($i < $result1->num_rows){
                $row = $result1->fetch_assoc();
                $sql = "SELECT 數量 FROM 零件 WHERE 編號='$row[零件編號]'";
                $result = $link->query($sql);
                $components_amount = $result->fetch_assoc();
                $components_amount['數量'] = $components_amount['數量'] + $row['數量'];
                $sql = "UPDATE `零件` SET `數量` = '$components_amount[數量]' WHERE `零件`.`編號` = '$row[零件編號]';";
                $link->query($sql);
                //$sql = "UPDATE 零件 SET 數量='$components_amount' WHERE 編號='$number'";
                $i++;
            }
            $sql = "UPDATE `進貨單` SET `進貨狀態` = '1' WHERE `進貨單編號` = '$purchaseNumber';";
            $link->query($sql);
        }
        header("location:purchase.php");
    }
    
?>