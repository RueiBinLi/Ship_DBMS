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
    <form action="add_purchase.php" method="post" style="display:inline">
      <p style="display:inline; margin-left:5%;">編號</p>
      <input type="text" name="components_number" id="components_number">
      <!-- <p style="display:inline;">品名</p>
      <input type="text" name="components_name" id="components_name">!-->
      <p style="display:inline;">數量</p>
      <input type="text" name="components_amount" id="components_amount">
    <div style="display:inline;">
        <p style="display:inline;">進貨單</p>
        <?php
          $link=require_once "config.php";

          $sql = "SELECT `進貨單編號` FROM `進貨單` WHERE `進貨狀態`='0' ORDER BY `進貨單編號` DESC;";
          $result = $link->query($sql);

          if($result->num_rows>0){
            $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
          }
          ?>
          <select name="purchase_number" style="display:inline;">
          <option value="null"></option>
          <?php
          foreach($options as $option){
          ?>
            <option value="<?php echo $option['進貨單編號']; ?>"><?php echo $option['進貨單編號']; ?></option>
          <?php
          }
          ?>
          </select>
          
        <p style="display:inline;">進貨源</p>
        <?php
          $sql = "SELECT `進貨公司名稱` FROM `進貨源`;";
          $result = $link->query($sql);

          if($result->num_rows>0){
            $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
          }
          ?>
          <select name="customer_name" style="display:inline;">
          <?php
          foreach($options as $option){
          ?>
            <option value="<?php echo $option['進貨公司名稱']; ?>"><?php echo $option['進貨公司名稱']; ?></option>
          <?php
          }
        ?>
        </select>
        <input type="submit" name="add_purchase" value="新增">
        </form>
    </div>
    <div style="display:inline;">
        <p style="margin-left:5%; display:inline;">進貨單</p>
          <?php
          $sql = "SELECT `進貨單編號` FROM `進貨單` WHERE `進貨狀態`='0' ORDER BY `進貨單編號` DESC;";
          $result = $link->query($sql);

          if($result->num_rows>0){
            $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
          }
          ?>
          <form action="#" method="POST" style="display:inline;">
          <select name="purchase_number2" style="display:inline;">
          <?php
          foreach($options as $option){
          ?>
            <option value="<?php echo $option['進貨單編號']; ?>"><?php echo $option['進貨單編號']; ?></option>
          <?php
          }
          ?>
          </select>
          <input type="submit" name="confirm" value="確定" style="display:inline">
          </form>
        <p style="display:inline; margin-left:1%;">進貨源:</p>
        <?php
        if(isset($_POST['confirm'])){
          $purchaseNumber = $_POST["purchase_number2"];
        }
        else {
          $sql = "SELECT 進貨單編號 FROM 進貨單 ORDER BY 進貨單編號 DESC LIMIT 1";
          $result = $link->query($sql);
          $row = $result->fetch_assoc();
          $purchaseNumber = $row['進貨單編號'];
        }
        $sql = "SELECT 進貨公司編號 FROM 進貨單 WHERE 進貨單編號='$purchaseNumber'";
        $result=$link->query($sql);
        $row = $result->fetch_assoc();
        $sql = "SELECT 進貨公司名稱 FROM 進貨源 WHERE 進貨公司編號='$row[進貨公司編號]'";
        $result=$link->query($sql);
        $row = $result->fetch_assoc();
        print($row['進貨公司名稱']);
        ?>
        <p style="display:inline; margin-left:1%;">進貨單時間:</p>
        <?php
        $sql = "SELECT 日期 FROM 進貨單 WHERE 進貨單編號='$purchaseNumber'";
        $result=$link->query($sql);
        $row = $result->fetch_assoc();
        print($row['日期']);
        ?>
        <p style="display:inline; margin-left:55%;">地址:</p>
        <?php
        $sql = "SELECT 進貨公司編號 FROM 進貨單 WHERE 進貨單編號='$purchaseNumber'";
        $result=$link->query($sql);
        $row = $result->fetch_assoc();
        $sql = "SELECT 進貨公司地址 FROM 進貨源 WHERE 進貨公司編號='$row[進貨公司編號]'";
        $result=$link->query($sql);
        $row = $result->fetch_assoc();
        print($row['進貨公司地址']);
        ?>
        <p style="display:inline; margin-left:1%;">電話:</p>
        <?php
        $sql = "SELECT 進貨公司編號 FROM 進貨單 WHERE 進貨單編號='$purchaseNumber'";
        $result=$link->query($sql);
        $row = $result->fetch_assoc();
        $sql = "SELECT 進貨公司電話 FROM 進貨源 WHERE 進貨公司編號='$row[進貨公司編號]'";
        $result=$link->query($sql);
        $row = $result->fetch_assoc();
        print($row['進貨公司電話']);
        ?>
        <p style="display:inline; margin-left:1%;">進貨單編號:</p>
        <?php
        $sql = "SELECT 進貨單編號 FROM 進貨單 WHERE 進貨單編號='$purchaseNumber'";
        $result=$link->query($sql);
        $row = $result->fetch_assoc();
        print($row['進貨單編號']);
        ?>
        <form action="finish_purchase.php" method="POST" style="display:inline;">
          <select name="number" style="display:inline;">
          <?php
          foreach($options as $option){
          ?>
            <option value="<?php echo $option['進貨單編號']; ?>"><?php echo $option['進貨單編號']; ?></option>
          <?php
          }
          ?>
          </select>
          <input type="submit" value="進貨完成" name="finish_purchase">
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
        </tr>
      </thead>
      <tbody>
      <?php
      if(isset($_POST['add_purchase'])){
        $purchaseNumber = $_POST["purchase_number"];
      }
      //$link=require_once "config.php";
      $sql = "SELECT * FROM `進貨單明細` WHERE `進貨單編號` = '$purchaseNumber' ORDER BY `零件編號` ASC;";
      //$sql = "SELECT * from 訂單明細 WHERE 訂單編號='00000001'";
      //$sql = sprintf("SELECT %s FROM %s WHERE %s ORDER BY %s", "零件編號,數量", "訂單明細", "訂單編號='00000001'", "零件編號 ASC");
      $result1=$link->query($sql);

      if($result1->num_rows > 0){
        while($row1 = $result1-> fetch_assoc()){
          $sql = sprintf("SELECT %s FROM %s WHERE %s","品名,規格,型式", "零件", "編號='$row1[零件編號]'");
          $result2 = $link-> query($sql); 
          if($result2->num_rows > 0){
            $row2 = $result2-> fetch_assoc();
            echo "<tr><td>". $row1["零件編號"] ."</td><td>". $row2["型式"] ."</td><td>". $row2["品名"] ."</td><td>" .$row2["規格"] ."</td><td>". $row1["數量"] ."</td></tr>";
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