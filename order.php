<!DOCTYPE html>
<html>
<body>
  <link href="layout.css" rel="stylesheet" type="text/css">
  <div class="title">
    輪船零件公司
    <div style="margin-left: auto; margin-right: 0;">
      <a href="index.php">登出</a>
    </div>
  </div>

  <div class="line">
    <HR SIZE=3>
  </div>
    
  <div class="link">
    <a href="order.php">訂單</a>
    <a href="prepare.php">備貨單</a>
    <a href="delivery.php">出貨單</a>
    <a href="purchase.php">進貨單</a>
    <a href="return.php">退貨單</a>
    <a href="stock.php">庫存</a>
  </div>

  <div class="wrap">
    <p style="display:inline;">庫存</p>
    <form action="add_order.php" method="post" style="display:inline">
      <p style="display:inline; margin-left:1%;">編號</p>
      <input type="text" name="components_number" id="components_number">
      <!-- <p style="display:inline;">品名</p>
      <input type="text" name="components_name" id="components_name">!-->
      <p style="display:inline;">數量</p>
      <input type="text" name="components_amount" id="components_amount">
      <p style="display:inline;">單價</p>
      <input type="text" name="components_price" id="components_price">
    <div style="display:inline;">
        <p style="display:inline;">訂單</p>
        <?php
          $link=require_once "config.php";

          $sql = "SELECT 備貨訂單編號 FROM 備貨單 WHERE 備貨狀態='0'";
          $result = $link->query($sql);
          $row = $result->fetch_assoc();
          $sql = "SELECT `訂單編號` FROM `訂單` ORDER BY `訂單編號` DESC;";
          $result = $link->query($sql);

          if($result->num_rows>0){
            $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
          }
          ?>
          <select name="order_number" style="display:inline;">
          <option value="null"></option>
          <?php
          foreach($options as $option){
          ?>
            <option value="<?php echo $option['訂單編號']; ?>"><?php echo $option['訂單編號']; ?></option>
          <?php
          }
          ?>
          </select>
          
        <p style="display:inline;">客戶</p>
        <?php
          $sql = "SELECT `客戶名稱` FROM `客戶`;";
          $result = $link->query($sql);

          if($result->num_rows>0){
            $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
          }
          ?>
          <select name="customer_name" style="display:inline;">
          <?php
          foreach($options as $option){
          ?>
            <option value="<?php echo $option['客戶名稱']; ?>"><?php echo $option['客戶名稱']; ?></option>
          <?php
          }
        ?>
        </select>
        <input type="submit" name="add_order" value="新增">
        </form>
    </div>
    <div style="display:inline;">
      
        <p style="margin-left:5%; display:inline;">訂單</p>
          <?php
          $sql = "SELECT 備貨訂單編號 FROM 備貨單 WHERE 備貨狀態='0'";
          $result = $link->query($sql);
          $row = $result->fetch_assoc();
          $sql = "SELECT `訂單編號` FROM `訂單` ORDER BY `訂單編號` DESC;";
          $result = $link->query($sql);

          if($result->num_rows>0){
            $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
          }
          ?>
          <form action="#" method="POST" style="display:inline;">
          <select name="order_number2" style="display:inline;">
          <?php
          foreach($options as $option){
          ?>
            <option value="<?php echo $option['訂單編號']; ?>"><?php echo $option['訂單編號']; ?></option>
          <?php
          }
          ?>
          </select>
          <input type="submit" name="confirm" value="確定" style="display:inline">
          </form>
        <p style="display:inline; margin-left:1%;">客戶:</p>
        <?php
        if(isset($_POST['confirm'])){
          $orderNumber = $_POST["order_number2"];
        }
        else {
          $sql = "SELECT 訂單編號 FROM 訂單 ORDER BY 訂單編號 DESC LIMIT 1";
          $result = $link->query($sql);
          $row = $result->fetch_assoc();
          $orderNumber = $row['訂單編號'];
        }
        $sql = "SELECT 訂單客戶編號 FROM 訂單 WHERE 訂單編號='$orderNumber'";
        $result=$link->query($sql);
        $row = $result->fetch_assoc();
        $sql = "SELECT 客戶名稱 FROM 客戶 WHERE 客戶編號='$row[訂單客戶編號]'";
        $result=$link->query($sql);
        $row = $result->fetch_assoc();
        print($row['客戶名稱']);
        ?>
        <p style="display:inline; margin-left:1%;">訂單時間:</p>
        <?php
        $sql = "SELECT 日期 FROM 訂單 WHERE 訂單編號='$orderNumber'";
        $result=$link->query($sql);
        $row = $result->fetch_assoc();
        print($row['日期']);
        ?>
        <p style="display:inline; margin-left:67%;">訂單編號:</p>
        <?php
        $sql = "SELECT 訂單編號 FROM 訂單 WHERE 訂單編號='$orderNumber'";
        $result=$link->query($sql);
        $row = $result->fetch_assoc();
        print($row['訂單編號']);
        ?>
        <p style="display:inline; margin-left:1%;">總計:</p>
        <?php
        $sql = "SELECT SUM(單價*數量) FROM 訂單明細 WHERE 訂單編號='$orderNumber'";
        $result = $link->query($sql);
        $row1 = $result->fetch_assoc();
        $total = $row1['SUM(單價*數量)'];
        echo $total;
        ?>
        <form action="finish_order.php" method="POST" style="display:inline;">
          <select name="number" style="display:inline;">
          <?php
          foreach($options as $option){
          ?>
            <option value="<?php echo $option['訂單編號']; ?>"><?php echo $option['訂單編號']; ?></option>
          <?php
          }
          ?>
          </select>
          <input type="submit" value="訂單完成" name="finish_order">
        </form>
    </div>
  </div>

  <div style="float:left; width:50%;">
    <table id="stock_table" border="1">
      <thead style="width:98%">
        <tr>
          <th >編號</th>
          <th >型式</th>
          <th >品名</th>
          <th >規格</th>
          <th >數量</th>
        </tr>
      </thead>
      <?php
      $sql = "SELECT 編號, 品名, 規格, 型式, 數量 from 零件 ORDER BY 編號 ASC";
      $result = $link-> query($sql);

      if($result->num_rows > 0){
        while($row = $result-> fetch_assoc()){
          if($row['數量'] < 0) echo "<tr><td>". $row["編號"] ."</td><td>". $row["型式"] ."</td><td>". $row["品名"] ."</td><td>" .$row["規格"] ."</td><td><span style='color:red;'>". $row["數量"] ."</span></td></tr>";
          else echo "<tr><td>". $row["編號"] ."</td><td>". $row["型式"] ."</td><td>". $row["品名"] ."</td><td>" .$row["規格"] ."</td><td>". $row["數量"] ."</td></tr>";
        }
      }

      //$link-> close();
      ?>
    </table>
  </div>

  <div style="float:left; width:50%;">
    <table id="delivery_table" border="1">
      <thead style="width:98.3%">
        <tr>
          <th>編號</th>
          <th>型式</th>
          <th>品名</th>
          <th>規格</th>
          <th>數量</th>
          <th>單價</th>
        </tr>
      </thead>
      <tbody>
      <?php
      if(isset($_POST['add_order'])){
        $orderNumber = $_POST["order_number"];
      }
      //$link=require_once "config.php";
      $sql = "SELECT * FROM `訂單明細` WHERE `訂單編號` = '$orderNumber' ORDER BY `零件編號` ASC;";
      //$sql = "SELECT * from 訂單明細 WHERE 訂單編號='00000001'";
      //$sql = sprintf("SELECT %s FROM %s WHERE %s ORDER BY %s", "零件編號,數量", "訂單明細", "訂單編號='00000001'", "零件編號 ASC");
      $result1=$link->query($sql);

      if($result1->num_rows > 0){
        while($row1 = $result1-> fetch_assoc()){
          $sql = "SELECT 數量 FROM 零件 WHERE 編號='$row1[零件編號]'";
          $result = $link->query($sql);
          $components_amount = $result->fetch_assoc();
          $sql = sprintf("SELECT %s FROM %s WHERE %s","品名,規格,型式", "零件", "編號='$row1[零件編號]'");
          $result2 = $link-> query($sql); 
          if($result2->num_rows > 0){
            $row2 = $result2-> fetch_assoc();
            if($components_amount['數量'] < 0) echo "<tr><td>". $row1["零件編號"] ."</td><td>". $row2["型式"] ."</td><td>". $row2["品名"] ."</td><td>" .$row2["規格"] ."</td><td><span style='color:red;'>". $row1["數量"] ."</span></td><td>". $row1["單價"] ."</td></tr> <script> alert('庫存不足') </script>";
            else echo "<tr><td>". $row1["零件編號"] ."</td><td>". $row2["型式"] ."</td><td>". $row2["品名"] ."</td><td>" .$row2["規格"] ."</td><td>". $row1["數量"] ."</td><td>". $row1["單價"] ."</td></tr>";
          }
        }
      }
      $link-> close();
      ?>
      <tbody>
    </table>
  </div>
</body>
</html>