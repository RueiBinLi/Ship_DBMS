<?php
//Include config file
//$conn=require_once "config.php";
header("Content-Type: text/html; charset=utf8");
session_start();
include("config.php");

//Define variables and initialize with empty values
$username=$_POST["username"];
$password=$_POST["user-pw"];

//processing form data when form is submitted
//$sql = "SELECT * FROM login_db WHERE ˋ使用者名稱ˋ ='" .$username . "'AND ˋ密碼ˋ ='" . $password . "';";
$sql = sprintf("SELECT %s FROM %s WHERE %s", "*", "login_db", "使用者名稱='$username' AND 密碼='$password'");
$result= $link->query($sql);

if($username && $password){
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['使用者名稱'];
        $_SESSION['password'] = $row['密碼'];
        header("location:stock.php");
    }
    else{
        echo "
        <script>
        window.alert('使用者名稱或密碼錯誤');
        window.history.back();
        </script>
        ";
    }
}
else if(!$password && $username){
    echo "
    <script>
    window.alert('請輸入密碼');
    window.history.back();
    </script>";
}
else if(!$username && $password){
    echo "
    <script>
    window.alert('請輸入使用者名稱');
    window.history.back();
    </script>";
}
else{
    echo "
    <script>
    window.alert('請輸入使用者名稱和密碼');
    window.history.back();
    </script>";
}

mysqli_close($link);

function function_alert($message){
    //Display the alert box
    echo "<script>alert('$message');
     window.location.href='index.php';
     </script>";
    return false;
}
?>