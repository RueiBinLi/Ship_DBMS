<?php
    $link=require_once "config.php";

    $returnNumber = $_POST['number'];

    $sql = "SELECT 退貨狀態 FROM 退貨單 WHERE 退貨單編號='$returnNumber'";
    $result = $link->query($sql);
    $row = $result->fetch_assoc();

    if($row['退貨狀態'] == '1'){
        echo "
        <script>
        window.alert('此退貨單已經被完成過了');
        window.history.back();
        </script>";
    }
    else{
        $sql = "SELECT 退貨訂單編號 FROM 退貨單 WHERE 退貨單編號='$returnNumber'";
        $result = $link->query($sql);
        $row = $result->fetch_assoc();
        $sql = "SELECT 數量,零件編號 FROM 退貨單明細 WHERE 退貨單編號='$returnNumber'";
        $result0 = $link->query($sql);
        if($result0->num_rows > 0){
            $i = 0;
            while($i < $result0->num_rows){
                $row1 = $result0->fetch_assoc();
                $sql = "SELECT 數量 FROM 訂單明細 WHERE 訂單編號='$row[退貨訂單編號]' AND 零件編號='$row1[零件編號]'";
                $result1 = $link->query($sql);
                $row2 = $result1->fetch_assoc();
                $amount = $row2['數量'] - $row1['數量'];
                $sql = "UPDATE 訂單明細 SET 數量='$amount' WHERE 訂單編號='$row[退貨訂單編號]' AND 零件編號='$row1[零件編號]'";
                $link->query($sql);
                $sql = "SELECT 數量 FROM 零件 WHERE 編號='$row1[零件編號]'";
                $result = $link->query($sql);
                $row3 = $result->fetch_assoc();
                $amount_all = $row3['數量'] + $row1['數量'];
                $sql = "UPDATE 零件 SET 數量='$amount_all' WHERE 編號='$row1[零件編號]'";
                $link->query($sql);
                $i++;
            }
        }
        $sql = "UPDATE `退貨單` SET `退貨狀態` = '1' WHERE `退貨單編號` = '$returnNumber';";
        $link->query($sql);
        header("location:return.php");
    }
?>