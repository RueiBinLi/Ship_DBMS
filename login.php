<?php
//Include config file
$conn=require_once "config.php";

//Define variables and initialize with empty values
$username=$_POST['username'];
$password=$_POST['password'];

//processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $sql = "SELECT * FROM login_db WHERE username ='$username' and password = '$password'";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)==1 && $password==mysqli_fetch_assoc($result)["password"]) {
        session_start();
        //store data in session variables
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = mysqli_fetch_assoc($result)["username"];
        $_SESSION["password"] = mysqli_fetch_assoc($result)["password"];
        header("location:order.php");
    }
    else{
        function_alert("帳號或密碼錯誤");
    }
}
else{
    function_alert("發生未知錯誤");
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