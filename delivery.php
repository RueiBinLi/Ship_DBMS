<!DOCTYPE html>
<html>
<body>
  <link href="layout.css" rel="stylesheet" type="text/css">
  <div class="title">
    輪船零件公司
  </div>

  <div class="line">
    <HR SIZE=3>
  </div>
    
  <div class="link">
    <a href="order.php">訂貨單</a>
    <a href="delivery.php">出貨單</a>
    <a href="prepare.php">備貨單</a>
  </div>
    
  <div class="wrap">
    <div class="stock_list">庫存</div>
    <div class="order_list">出貨單</div>
  </div>

  <div style="float:left; width:50%;">
    <table id="stock_table" border="1">
      <thead style="width:93.2%">
        <tr>
          <th width="23.3%">編號</th>
          <th width="23.3%">品名</th>
          <th width="23.3%">規格</th>
          <th width="23.3%">型式</th>
        </tr>
      </thead>
      <?php
      $conn = mysqli_connect("localhost", "root", "", "test")
      if($conn-> connect_error){
        die("Connection failed:". $conn-> connect_error);
      }

      $sql = "SELECT 編號, 品名, 型式, 規格 from 零件";
      $result = $conn-> query($sql);

      if($result-> num_rows>0){
        while($row = $result-> fetch_assoc()){
          echo "<tr><td>". $row["編號"] ."</td><td>". $row["品名"] ."</td><td>". $row["型式"] ."</td><td>" .$row["規格"] ."</td></tr>";
        }
        echo "</table>";
      }
      else{
        echo "0 result";
      }

      $conn-> close();
      ?>
      <tbody>
        <tr>
          <td>1</td>
          <td>螺絲</td>
          <td>10 10</td>
          <td>K180</td>
          <td width="43px"><input type="submit" value="新增"></td>
        </tr>
      <tbody>
    </table>
  </div>

  <div style="float:left; width:50%;">
    <table id="delivery_table" border="1">
      <thead style="width:98.3%">
        <tr>
          <th>編號</th>
          <th>品名</th>
          <th>規格</th>
          <th>型式</th>
          <th>數量</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>螺絲</td>
          <td>10 10</td>
          <td>K180</td>
          <td>100</td>
        </tr>
      <tbody>
    </table>
  </div>
</body>
</html>