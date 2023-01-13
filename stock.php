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
    <p style="display:inline; margin-left:20%">庫存</p>
    <form action="add_stock.php" method="post" style="display:inline" onsubmit="return validation()">
      <label for="components_number" style="display:inline; margin-left:2%; margin-right:0;">編號</label>
      <input type="text" name="components_number" id="components_number">
      <label for="components_type" style="display:inline;">型式</label>
      <input type="text" name="components_type" id="components_type">
      <label for="components_name" style="display:inline;">品名</label>
      <input type="text" name="components_name" id="components_name">
      <label for="components_specification" style="display:inline;">規格</labe;>
      <input type="text" name="components_specification" id="components_specification">
      <label for="components_amount" style="display:inline;">數量</label>
      <input type="text" name="components_amount" id="components_amount">
      <input type="submit" name="add_stock" value="新增">
      <input type="submit" name="minus_stock" value="減少">
    </form>

    <script>
        function validation(){
            var n=document.stock_button.components_number.value;
            var am=document.stock_button.components_amount.value;
            if(n.length=="" && am.length=="") {
            alert("請輸入編號和數量");
            return false;
            }
            else{
                if(n.length=="") {
                    alert("請輸入編號");
                    return false;
                }
                else{
                    alert("請輸入數量");
                    return false;
                }
            }
        }
    </script>
  </div>

  <div style="float:left; width:100%; margin-top:10px;">
    <table id="stock_table" border="1">
      <thead style="width:98%">
        <tr>
          <th>編號</th>
          <th>型式</th>
          <th>品名</th>
          <th>規格</th>
          <th>數量</th>
        </tr>
      </thead>
      <?php
      $link=require_once "config.php";

      $sql = "SELECT 編號, 品名, 型式, 規格, 數量 from 零件 ORDER BY 編號 ASC";
      $result = $link-> query($sql);

      if($result->num_rows > 0){
        $i = 0;
        while($row = $result-> fetch_assoc()){
          if($row['數量'] < 0) echo "<tr><td>". $row["編號"] ."</td><td>". $row["型式"] ."</td><td>". $row["品名"] ."</td><td>" .$row["規格"] ."</td><td><span style='color:red;'>". $row["數量"] ."</span></td></tr>";
          else echo "<tr><td>". $row["編號"] ."</td><td>". $row["型式"] ."</td><td>". $row["品名"] ."</td><td>" .$row["規格"] ."</td><td>". $row["數量"] ."</td></tr>";
        }
      }
      else{
        echo "0 result";
      }

      $link-> close();
      ?>
    </table>
  </div>
</body>
</html>