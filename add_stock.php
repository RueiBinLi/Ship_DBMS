<?php
    $link=require_once "config.php";

    $number=$_POST["components_number"];
    $name=$_POST["components_name"];
    $specification=$_POST["components_specification"];
    $type=$_POST["components_type"];
    $amount=$_POST["components_amount"];

    $sql=sprintf("SELECT %s FROM %s WHERE %s", "編號, 數量", "零件", "編號='$number'");
    $result=$link->query($sql);
    
    if(array_key_exists('add_stock', $_POST)){
        if($amount && $number){
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $after_amount = $amount + $row["數量"];
                //$sql=sprintf("UPDATE %s SET %s WHERE %s", "零件", "數量='$after_amount'", "零件.編號='$nubmer'");
                $sql="UPDATE `零件` SET `數量` = '$after_amount' WHERE `零件`.`編號` = '$number';";
                $link->query($sql);
                header("location:stock.php");
            }
            else{
                if($name){
                    $sql="INSERT INTO `零件` (`編號`, `品名`, `型式`, `規格`, `數量`) VALUES ('$number', '$name', '$type', '$specification', '$amount');";
                    $link->query($sql);
                    header("location:stock.php");
                }
                else{
                    echo "
                    <script>
                    window.alert('品名不得為空');
                    window.history.back();
                    </script>";
                }
            }
        }
        else if(!$amount && $number){
            echo "
            <script>
            window.alert('請輸入數量');
            window.history.back();
            </script>";
        }
        else if(!$number && $amount){
            echo "
            <script>
            window.alert('請輸入編號');
            window.history.back();
            </script>";
        }
        else{
            echo "
            <script>
            window.alert('請輸入編號和數量');
            window.history.back();
            </script>";
        }
    }
    else if(array_key_exists('minus_stock', $_POST)){
        if($amount && $number){
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $after_amount = $row["數量"] - $amount;
                //$sql=sprintf("UPDATE %s SET %s WHERE %s", "零件", "數量='$after_amount'", "零件.編號='$nubmer'");
                $sql="UPDATE `零件` SET `數量` = '$after_amount' WHERE `零件`.`編號` = '$number';";
                $link->query($sql);
                header("location:stock.php");
            }
            else{
                echo "
                <script>
                alert('沒有此零件');
                window.history.back();
                </script>";
            }
        }
        else if(!$amount && $number){
            echo "
            <script>
            window.alert('請輸入數量');
            window.history.back();
            </script>";
        }
        else if(!$number && $amount){
            echo "
            <script>
            window.alert('請輸入編號');
            window.history.back();
            </script>";
        }
        else{
            echo "
            <script>
            window.alert('請輸入編號和數量');
            window.history.back();
            </script>";
        }
    }
    $link->close();
?>