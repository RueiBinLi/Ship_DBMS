<?php
    $link=require_once "config.php";

    $orderNumber = $_POST['number'];

    $sql = "SELECT 備貨單編號,備貨狀態 FROM 備貨單 WHERE 備貨訂單編號='$orderNumber'";
    $result = $link->query($sql);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        if($row['備貨狀態'] == '1') {
            $sql = "SELECT 備貨單編號 FROM 備貨單 ORDER BY 備貨單編號 DESC LIMIT 1";
            $result = $link->query($sql);
            $row = $result->fetch_assoc();
            $row['備貨單編號'] = intval($row['備貨單編號']) + 1;
            $today = date('Y/m/d');
            $sql = "INSERT INTO `備貨單` (`備貨單編號`, `日期`, `備貨訂單編號`, `備貨狀態`) VALUES ('$row[備貨單編號]', '$today', '$orderNubmer', '0')";
            $link->query($sql);
            echo "
            <script>
            alert('此訂單已完成並將新增新的備貨單');
            window.history.back();
            </script>";
        }
        else{
            header("location:prepare.php");
        }
    } else{
        $sql = "SELECT 備貨單編號 FROM 備貨單 ORDER BY 備貨單編號 DESC LIMIT 1";
        $result = $link->query($sql);
        $row = $result->fetch_assoc();
        $row['備貨單編號'] = intval($row['備貨單編號']) + 1;
        $today = date('Y/m/d');
        $sql = "INSERT INTO `備貨單` (`備貨單編號`, `日期`, `備貨訂單編號`, `備貨狀態`) VALUES ('$row[備貨單編號]', '$today', '$orderNumber', '0')";
        $link->query($sql);
        header("location:prepare.php");
    }
?>