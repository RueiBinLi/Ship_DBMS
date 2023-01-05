<!DOCTYPE HTML>
<?php
//Initialize the session
session_start();

//check if the user is already logged in, if yes the redirect him to order page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: order.php");
  exit;
}
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>登入</title>
</head>

<body>
  <div class="title">
    <h1>輪船零件公司</h1>
  </div>

<form name='f1' method="post" action="login.php" onsubmit="return validation()">
  <label for="username">帳號:</label>
  <input type="text" name="username" id="username">
  <br>
  <label for="user-pw">密碼:</label>
  <input type="password" name="user-pw" id="user-pw">
  <br>
  <input type="submit" value="登入" name="submit">
</form>

<script>
  function validation(){
    var id=document.f1.username.value;
    var ps=document.f1.password.value;
    if(id.length=="" && ps.length=="") {
      alert("User Name and Password fields are empty");
      return false;
    }
    else{
      if(id.length=="") {
        alert("User Name is empty");
        return false;
      }
    }
  }
</script>
      
</body>
</html>