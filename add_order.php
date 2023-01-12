<?php
    $link=require_once "config.php";

    $number=$_POST["components_number"];
    $amount=$_POST["components_amount"];
    $orderNumber=$_POST["order_number"];
    $price=$_POST["components_price"];
    $customerName=$_POST["customer_name"];

    if($orderNumber === "null" && $customerName && $amount && $number && $price){
        $sql = "SELECT 訂單編號 FROM 訂單 ORDER BY 訂單編號 DESC LIMIT 1";
        $result = $link->query($sql);
        $row = $result->fetch_assoc();
        $str_row = $row['訂單編號'];
        $str = '';
        for($i = 0; $i < 8; $i++) $str.=$str_row[$i];
        $today = date('Y/m/d');
        $today_replace = str_replace("/","",$today);
        $str_today = $today_replace;
        if($str == $today_replace) $row['訂單編號'] = intval($row['訂單編號']) + 1;
        else {$str_today.="0"; $str_today.="1"; $row['訂單編號'] = $str_today;}
        $sql = "SELECT 客戶編號 FROM 客戶 WHERE 客戶名稱='$customerName'";
        $result = $link->query($sql);
        $customerNumber = $result->fetch_assoc();
        $sql = "INSERT INTO `訂單` (`訂單編號`, `日期`, `訂單客戶編號`) VALUES ('$row[訂單編號]', '$today', '$customerNumber[客戶編號]');";
        $link->query($sql);
            
        $sql = "SELECT 訂單明細編號 FROM 訂單明細 ORDER BY 訂單明細編號 DESC LIMIT 1";
        $result = $link->query($sql);
        $order_detail_nubmer = $result->fetch_assoc();
        $order_detail_nubmer['訂單明細編號'] = intval($order_detail_nubmer['訂單明細編號']) + 1 ;
        $length = strlen($order_detail_nubmer['訂單明細編號']);
        for($i = 0; $i < 8-$length; $i++) $order_detail_nubmer['訂單明細編號'] = "0".$order_detail_nubmer['訂單明細編號'];
        $sql = "INSERT INTO `訂單明細` (`訂單編號`, `訂單明細編號`, `零件編號`, `數量`, `單價`) VALUES ('$row[訂單編號]', '$order_detail_nubmer[訂單明細編號]', '$number', '$amount', '$price');";
        $result = $link->query($sql);

        $sql = "SELECT 數量 FROM 零件 WHERE 編號='$number'";
        $result = $link->query($sql);
        $components_amount = $result->fetch_assoc();
        $components_amount['數量'] = $components_amount['數量'] - $amount;
        $sql = "UPDATE `零件` SET `數量` = '$components_amount[數量]' WHERE `零件`.`編號` = '$number';";
        //$sql = "UPDATE 零件 SET 數量='$components_amount' WHERE 編號='$number'";
        $link->query($sql);

        header("location:order.php");
    }
    else if($orderNumber && $number && $amount && $price){
        $sql = "SELECT 零件編號 FROM 訂單明細 WHERE 零件編號='$number' AND 訂單編號='$orderNumber'";
        $result = $link->query($sql);
        if($result->num_rows > 0){
            $sql = "SELECT 數量 FROM 訂單明細 WHERE 零件編號='$number'";
            $result = $link->query($sql);
            $row = $result->fetch_assoc();
            $calc_amount = $row['數量'] + $amount;
            $sql = "UPDATE 訂單明細 SET 數量='$calc_amount' WHERE 零件編號='$number'";
            $link->query($sql);
            $sql = "SELECT 數量 FROM 零件 WHERE 編號='$number'";
            $result = $link->query($sql);
            $components_amount = $result->fetch_assoc();
            $components_amount['數量'] = $components_amount['數量'] - $amount;
            $sql = "UPDATE `零件` SET `數量` = '$components_amount[數量]' WHERE `零件`.`編號` = '$number';";
            //$sql = "UPDATE 零件 SET 數量='$components_amount' WHERE 編號='$number'";
            $link->query($sql);
        } else {
            $sql = "SELECT 訂單明細編號 FROM 訂單明細 ORDER BY 訂單明細編號 DESC LIMIT 1";
            $result = $link->query($sql);
            $order_detail_nubmer = $result->fetch_assoc();
            $order_detail_nubmer['訂單明細編號'] = intval($order_detail_nubmer['訂單明細編號']) + 1 ;
            $length = strlen($order_detail_nubmer['訂單明細編號']);
            for($i = 0; $i < 8-$length; $i++) $order_detail_nubmer['訂單明細編號'] = "0".$order_detail_nubmer['訂單明細編號'];
            $sql = "INSERT INTO `訂單明細` (`訂單編號`, `訂單明細編號`, `零件編號`, `數量`, `單價`) VALUES ('$orderNumber', '$order_detail_nubmer[訂單明細編號]', '$number', '$amount', '$price');";
            $result = $link->query($sql);
            $sql = "SELECT 數量 FROM 零件 WHERE 編號='$number'";
            $result = $link->query($sql);
            $components_amount = $result->fetch_assoc();
            $components_amount['數量'] = $components_amount['數量'] - $amount;
            $sql = "UPDATE `零件` SET `數量` = '$components_amount[數量]' WHERE `零件`.`編號` = '$number';";
            //$sql = "UPDATE 零件 SET 數量='$components_amount' WHERE 編號='$number'";
            $link->query($sql);
        }
        header("location:order.php");
    }
    else if(!$orderNumber && $number && $amount && $price && $customerName){
        echo "
        <script>
        window.alert('請輸入編號');
        window.history.back();
        </script>";
    }
    else if(!$number && $orderNumber && $amount && $price && $customerName){
        echo "
        <script>
        window.alert('請輸入數量');
        window.history.back();
        </script>";
    }
    else if(!$number && $orderNumber && !$amount && !$price){
        echo "
        <script>
        window.alert('請輸入數量、編號和單價');
        window.history.back();
        </script>";
    }
    
?>