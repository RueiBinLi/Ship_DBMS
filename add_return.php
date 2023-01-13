<?php
    $link=require_once "config.php";

    $number=$_POST["components_number"];
    $amount=$_POST["components_amount"];
    $orderNumber=$_POST["order_number"];

    if($orderNumber && $amount && $number){
        //$sql = "SELECT * FROM 訂單明細 WHERE 訂單編號=$orderNumber AND 零件編號=$number";
        $sql = "SELECT `零件編號` FROM `訂單明細` WHERE `訂單編號`='$orderNumber' AND `零件編號`='$number';";
        $result = $link->query($sql);
        if($result->num_rows > 0){
            $sql = "SELECT 退貨單編號 FROM 退貨單 WHERE 退貨訂單編號='$orderNumber'";
            $result = $link->query($sql);
            if($result->num_rows > 0){
                $returnNumber = $result->fetch_assoc();
                $sql = "SELECT 零件編號 FROM 退貨單明細 WHERE 零件編號='$number' AND 退貨單編號='$returnNumber[退貨單編號]'";
                $result = $link->query($sql);
                if($result->num_rows > 0){
                    $sql = "SELECT 數量 FROM 退貨單明細 WHERE 零件編號='$number'";
                    $result = $link->query($sql);
                    $row = $result->fetch_assoc();
                    $calc_amount = $row['數量'] + $amount;

                    $sql = "SELECT 數量 FROM 訂單明細 WHERE 訂單編號='$orderNumber' AND 零件編號='$number'";
                    $result = $link->query($sql);
                    $componentAmount = $result->fetch_assoc();
                    if($componentAmount['數量'] > $calc_amount){
                        $sql = "UPDATE 退貨單明細 SET 數量='$calc_amount' WHERE 零件編號='$number'";
                        $link->query($sql);
                        header("location:return.php");
                    }
                    else{
                        echo "
                        <script>
                        window.alert('退貨數量超過訂單的數量');
                        window.history.back();
                        </script>";
                    }
                }
                else{
                    $sql = "SELECT 數量 FROM 訂單明細 WHERE 訂單編號=$orderNumber AND 零件編號=$number";
                    $result = $link->query($sql);
                    $componentAmount = $result->fetch_assoc();

                    if($componentAmount['數量'] > $amount){
                        $sql = "SELECT 退貨單明細編號 FROM 退貨單明細 ORDER BY 退貨單明細編號 DESC LIMIT 1";
                        $result = $link->query($sql);
                        $order_detail_nubmer = $result->fetch_assoc();
                        $order_detail_nubmer['退貨單明細編號'] = intval($order_detail_nubmer['退貨單明細編號']) + 1 ;
                        $sql = "INSERT INTO `退貨單明細` (`退貨單明細編號`, `退貨單編號`, `零件編號`, `數量`) VALUES ('$order_detail_nubmer[退貨單明細編號]', '$returnNumber[退貨單編號]', '$number', '$amount');";
                        //$sql = "INSERT INTO `退貨單明細` (`退貨單編號`, `退貨單明細編號`, `零件編號`, `數量`) VALUES ('', '', '', '');";
                        $link->query($sql);
                        header("location:return.php");
                    }
                    else{
                        echo "
                        <script>
                        window.alert('退貨數量超過訂單的數量');
                        window.history.back();
                        </script>";
                    }
                }
            }
            else{
                $sql = "SELECT 數量 FROM 訂單明細 WHERE 訂單編號=$orderNumber AND 零件編號=$number";
                $result = $link->query($sql);
                $componentAmount = $result->fetch_assoc();
                //echo $componentAmount['數量'];
                echo $amount;

                if($componentAmount['數量'] > $amount){ 
                    $sql = "SELECT 退貨單編號 FROM 退貨單 ORDER BY 退貨單編號 DESC LIMIT 1";
                    $result = $link->query($sql);
                    $row = $result->fetch_assoc();
                    $today = date('Y/m/d');
                    $row['退貨單編號'] = intval($row['退貨單編號']) + 1;
                    $sql = "INSERT INTO `退貨單` (`退貨單編號`, `日期`, `退貨訂單編號`,`退貨狀態`) VALUES ('$row[退貨單編號]', '$today', '$orderNumber', '0');";
                    $link->query($sql);
                        
                    $sql = "SELECT 退貨單明細編號 FROM 退貨單明細 ORDER BY 退貨單明細編號 DESC LIMIT 1";
                    $result = $link->query($sql);
                    $order_detail_nubmer = $result->fetch_assoc();
                    $order_detail_nubmer['退貨單明細編號'] = intval($order_detail_nubmer['退貨單明細編號']) + 1 ;
                    $sql = "INSERT INTO `退貨單明細` (`退貨單編號`, `退貨單明細編號`, `零件編號`, `數量`) VALUES ('$row[退貨單編號]', '$order_detail_nubmer[退貨單明細編號]', '$number', '$amount');";
                    $result = $link->query($sql);
                    header("location:return.php");
                }
                else{
                    echo "
                    <script>
                    window.alert('退貨數量超過訂單的數量');
                    window.history.back();
                    </script>";
                }
            }
        }
        else{
            echo "
            <script>
            window.alert('此零件不在訂單中');
            window.history.back();
            </script>";
        }

        //header("location:return.php");
    }
    else if(!$number && $orderNumber && $amount){
        echo "
        <script>
        window.alert('請輸入數量');
        window.history.back();
        </script>";
    }
    else if(!$number && $orderNumber && !$amount){
        echo "
        <script>
        window.alert('請輸入數量、編號和單價');
        window.history.back();
        </script>";
    }
    
?>