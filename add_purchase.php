<?php
    $link=require_once "config.php";

    $number=$_POST["components_number"];
    $amount=$_POST["components_amount"];
    $purchaseNumber=$_POST["purchase_number"];
    $customerName=$_POST["customer_name"];

    if($purchaseNumber === "null" && $customerName && $amount && $number){
        $sql = "SELECT 進貨單編號 FROM 進貨單 ORDER BY 進貨單編號 DESC LIMIT 1";
        $result = $link->query($sql);
        $row = $result->fetch_assoc();
        $row['進貨單編號'] = intval($row['進貨單編號']) + 1;
        $sql = "SELECT 進貨公司編號 FROM 進貨源 WHERE 進貨公司名稱='$customerName'";
        $result = $link->query($sql);
        $customerNumber = $result->fetch_assoc();
        $today = date('Y/m/d');
        $sql = "INSERT INTO `進貨單` (`進貨單編號`, `日期`, `進貨公司編號`, `進貨狀態`) VALUES ('$row[進貨單編號]', '$today', '$customerNumber[進貨公司編號]', '0');";
        $link->query($sql);
            
        $sql = "SELECT 進貨單明細編號 FROM 進貨單明細 ORDER BY 進貨單明細編號 DESC LIMIT 1";
        $result = $link->query($sql);
        $order_detail_nubmer = $result->fetch_assoc();
        $order_detail_nubmer['進貨單明細編號'] = intval($order_detail_nubmer['進貨單明細編號']) + 1 ;
        $sql = "INSERT INTO `進貨單明細` (`進貨單編號`, `進貨單明細編號`, `零件編號`, `數量`) VALUES ('$row[進貨單編號]', '$order_detail_nubmer[進貨單明細編號]', '$number', '$amount');";
        $link->query($sql);

        header("location:purchase.php");
    }
    else if($purchaseNumber && $number && $amount){
        $sql = "SELECT 進貨狀態 FROM 進貨單 WHERE 進貨單編號='$purchaseNumber'";
        $result = $link->query($sql);
        $row = $result->fetch_assoc();
        if($row['進貨狀態'] === '1'){
            $sql = "SELECT 進貨單編號 FROM 進貨單 ORDER BY 進貨單編號 DESC LIMIT 1";
            $result = $link->query($sql);
            $row = $result->fetch_assoc();
            $row['進貨單編號'] = intval($row['進貨單編號']) + 1;
            $sql = "SELECT 進貨公司編號 FROM 進貨源 WHERE 進貨公司名稱='$customerName'";
            $result = $link->query($sql);
            $customerNumber = $result->fetch_assoc();
            $today = date('Y/m/d');
            $sql = "INSERT INTO `進貨單` (`進貨單編號`, `日期`, `進貨公司編號`, `進貨狀態`) VALUES ('$row[進貨單編號]', '$today', '$customerNumber[進貨公司編號]', '0');";
            $link->query($sql);
                    
            $sql = "SELECT 進貨單明細編號 FROM 進貨單明細 ORDER BY 進貨單明細編號 DESC LIMIT 1";
            $result = $link->query($sql);
            $order_detail_nubmer = $result->fetch_assoc();
            $order_detail_nubmer['進貨單明細編號'] = intval($order_detail_nubmer['進貨單明細編號']) + 1 ;
            $sql = "INSERT INTO `進貨單明細` (`進貨單編號`, `進貨單明細編號`, `零件編號`, `數量`) VALUES ('$row[進貨單編號]', '$order_detail_nubmer[進貨單明細編號]', '$number', '$amount');";
            $result = $link->query($sql);

            echo "
            <script>
            window.alert('此進貨單已進貨完成，將新增至新的進貨單');
            window.history.back();
            </script>";
        } else {
            $sql = "SELECT 零件編號 FROM 進貨單明細 WHERE 零件編號='$number' AND 進貨單編號='$purchaseNumber'";
            $result = $link->query($sql);
            if($result->num_rows > 0){
                $sql = "SELECT 數量 FROM 進貨單明細 WHERE 零件編號='$number'";
                $result = $link->query($sql);
                $row = $result->fetch_assoc();
                $calc_amount = $row['數量'] + $amount;
                $sql = "UPDATE 進貨單明細 SET 數量='$calc_amount' WHERE 零件編號='$number'";
                $link->query($sql);
                header("location:purchase.php");                
            }else{
                $sql = "SELECT 進貨單明細編號 FROM 進貨單明細 ORDER BY 進貨單明細編號 DESC LIMIT 1";
                $result = $link->query($sql);
                $order_detail_nubmer = $result->fetch_assoc();
                $order_detail_nubmer['進貨單明細編號'] = intval($order_detail_nubmer['進貨單明細編號']) + 1 ;
                $sql = "INSERT INTO `進貨單明細` (`進貨單編號`, `進貨單明細編號`, `零件編號`, `數量`) VALUES ('$purchaseNumber', '$order_detail_nubmer[進貨單明細編號]', '$number', '$amount');";
                $result = $link->query($sql);
                header("location:purchase.php");
            }
            
        }
    }
    else if(!$purchaseNumber && $number && $amount&& $customerName){
        echo "
        <script>
        window.alert('請輸入編號');
        window.history.back();
        </script>";
    }
    else if(!$number && $purchaseNumber && $amount&& $customerName){
        echo "
        <script>
        window.alert('請輸入數量');
        window.history.back();
        </script>";
    }
    else if(!$number && $purchaseNumber && !$amount){
        echo "
        <script>
        window.alert('請輸入數量、編號');
        window.history.back();
        </script>";
    }
    
?>