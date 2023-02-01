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

  <form action="#" method="POST">
  <div>
      <p>備貨單</p>
          <form action="#" method="POST" style="display:inline">
          <select name="status" style="display:inline">
            <option value="unfinish">備貨未完成</option>
            <option value="finish">備貨完成</option>
          </select>
          <input type="submit" name="if_finish" style="display:inline">
          </form>
          <?php
          if(isset($_POST['if_finish'])) $status = $_POST['status'];
          else $status = 'unfinish';

          $link=require_once "config.php";
          
          if($status == 'finish') $sql = "SELECT `備貨單編號` FROM `備貨單` WHERE `備貨狀態`='1' ORDER BY `備貨單編號` DESC;";
          else $sql = "SELECT `備貨單編號` FROM `備貨單` WHERE `備貨狀態`='0' ORDER BY `備貨單編號` DESC;";
          $result = $link->query($sql);

          if($result->num_rows>0){
            $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
          }
          ?>
          <form action="#" method="POST" style="display:inline;">
          <select name="prepare_number" style="display:inline;">
          <?php
          foreach($options as $option){
          ?>
            <option value="<?php echo $option['備貨單編號']; ?>"><?php echo $option['備貨單編號']; ?></option>
          <?php
          }
          ?>
          </select>
          <input type="submit" name="confirm" value="確定" style="display:inline; margin-left:0.5%;">
          </form>
        <?php
        if(isset($_POST['confirm'])){
          $prepareNumber = $_POST["prepare_number"];
        }
        else {
          $sql = "SELECT 備貨單編號 FROM 備貨單 ORDER BY 備貨單編號 DESC LIMIT 1";
          $result = $link->query($sql);
          $row = $result->fetch_assoc();
          $prepareNumber = $row['備貨單編號'];
        }
        ?>
        <p style="display:inline; margin-left:3%;">備貨單時間:</p>
        <?php
        $sql = "SELECT 日期 FROM 備貨單 WHERE 備貨單編號='$prepareNumber'";
        $result=$link->query($sql);
        $row = $result->fetch_assoc();
        print($row['日期']);
        ?>
        <p style="display:inline; margin-left:3%;">備貨單編號:</p>
        <?php
        $sql = "SELECT 備貨單編號 FROM 備貨單 WHERE 備貨單編號='$prepareNumber'";
        $result=$link->query($sql);
        $row = $result->fetch_assoc();
        print($row['備貨單編號']);
        ?>
        <p style="display:inline; margin-left:3%;">對應訂單編號:</p>
        <?php
        $sql = "SELECT 備貨訂單編號 FROM 備貨單 WHERE 備貨單編號='$prepareNumber'";
        $result=$link->query($sql);
        $row = $result->fetch_assoc();
        print($row['備貨訂單編號']);
        ?>
        <p style="display:inline; margin-left:3%;">備貨狀態:</p>
        <?php
        $sql = "SELECT 備貨狀態 FROM 備貨單 WHERE 備貨單編號='$prepareNumber'";
        $result=$link->query($sql);
        $row = $result->fetch_assoc();
        if($row['備貨狀態'] === '0') print('未完成');
        else print('完成');
        ?>
        <form action="finish_prepare.php" method="POST" style="display:inline; margin-left:3%;">
          <select name="prepare_number" style="display:inline;">
          <?php
          foreach($options as $option){
          ?>
            <option value="<?php echo $option['備貨單編號']; ?>"><?php echo $option['備貨單編號']; ?></option>
          <?php
          }
          ?>
          <input type="submit" name="finish_prepare" value="完成備貨" >
          </select>
        </form>
    </div>

  <div style="float:left; width:100%;">
    <table id="delivery_table" border="1">
      <thead style="width:99%">
        <tr>
          <th>編號</th>
          <th>品名</th>
          <th>規格</th>
          <th>型式</th>
          <th>數量</th>
        </tr>
      </thead>
      <tbody>
      <?php
      //$link=require_once "config.php";
      $sql = "SELECT 備貨訂單編號 FROM 備貨單 WHERE 備貨單編號='$prepareNumber'";
      $result=$link->query($sql);
      $orderNumber = $result->fetch_assoc();
      $sql = "SELECT * FROM `訂單明細` WHERE `訂單編號` = '$orderNumber[備貨訂單編號]' ORDER BY `零件編號` ASC;";
      //$sql = "SELECT * from 訂單明細 WHERE 訂單編號='00000001'";
      //$sql = sprintf("SELECT %s FROM %s WHERE %s ORDER BY %s", "零件編號,數量", "訂單明細", "訂單編號='00000001'", "零件編號 ASC");
      $result1=$link->query($sql);

      if($result1->num_rows > 0){
        while($row1 = $result1-> fetch_assoc()){
          $sql = "SELECT 數量 FROM 零件 WHERE 編號='$row1[零件編號]'";
          $components_amount = $link->query($sql);
          $sql = sprintf("SELECT %s FROM %s WHERE %s","品名,規格,型式", "零件", "編號='$row1[零件編號]'");
          $result2 = $link-> query($sql); 
          if($result2->num_rows > 0){
            $row2 = $result2-> fetch_assoc();
            if($components_amount < $row1['數量']) echo "<tr><td>". $row1["零件編號"] ."</td><td>". $row2["型式"] ."</td><td>". $row2["品名"] ."</td><td>" .$row2["規格"] ."</td><td><span style='color:blue;'>". $row1["數量"] ."</span></td></tr>";
            else echo "<tr><td>". $row1["零件編號"] ."</td><td>". $row2["型式"] ."</td><td>". $row2["品名"] ."</td><td>" .$row2["規格"] ."</td><td>". $row1["數量"] ."</td></tr>";
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