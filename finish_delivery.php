<?php
    $link=require_once "config.php";

    $deliveryNumber = $_POST['delivery_number'];

    $sql = "UPDATE `出貨單` SET `出貨狀態` = '1' WHERE `出貨單編號` = '$deliveryNumber';";
    $link->query($sql);
    header("location:delivery.php");
?>