<?php
    $link=require_once "config.php";

    $prepareNumber = $_POST['prepare_number'];

    $sql = "SELECT 備貨狀態 FROM 備貨單 WHERE 備貨單編號='$prepareNumber'";
    $result = $link->query($sql);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        if($row['備貨狀態'] == '1') {
            echo "
            <script>
            alert('此備貨單已備貨完成');
            window.history.back();
            </script>";
        } else {
            $sql = "UPDATE `備貨單` SET `備貨狀態` = '1' WHERE `備貨單編號` = '$prepareNumber';";
            $link->query($sql);
            $sql = "SELECT 出貨單編號 FROM 出貨單 ORDER BY 出貨單編號 DESC LIMIT 1";
            $result = $link->query($sql);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $row['出貨單編號'] = intval($row['出貨單編號']) + 1;
                $tomorrow = date('Y/m/d',strtotime('+1 day'));
                $sql = "INSERT INTO `出貨單` (`出貨單編號`, `日期`, `出貨備貨編號`, `出貨狀態`) VALUES ('$row[出貨單編號]', '$tomorrow', '$prepareNumber', '0')";
                $link->query($sql);
                header("location:delivery.php");
            }
        }
    }
?>