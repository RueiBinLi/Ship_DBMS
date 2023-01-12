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
    <a href="stock.php">庫存</a>
  </div>

  <div class="wrap">
    <p style="display:inline;">庫存</p>
    <p style="display:inline; margin-left:29%;">編號</p>
    <form action="#" method="post" style="display:inline">
      <input type="text" name="number_search" size=10px>
      <p style="display:inline;">品名</p>
      <input type="text" name="components_name" size=10px>
      <input type="submit" name="add_delivery" value="新增">
    </form>
    <!--<p style="display:inline; margin-left:30px;">搜尋(零件)</p>
    <form action="#" method="post" style="display:inline;">
      <input type="text" name="search" size="10px" style="display:inline; margin-top:17px;">
      <input type="submit" value="確認">
    </form>!-->
    <?php
    /*$link=require_once "config.php";
    $search=$_post['search'];

    if(isset($_POST['add_delivery'])){
      $sql=sprintf("INSERT INTO ")
    }*/
    ?>
    <div style="margin-left:5%; display:inline-block;">
        <p>進貨單</p>
    </div>
    <div style="margin-left:5%; display:inline-block;">
        <p>公司名稱</p>
    </div>
    <select name="select_purchase_company" style="display:inline-block;">
        <option value="A">AAAAAA</option>
    </select>
    <div style="margin-left:5%; display:inline-block;">
        <p>進貨單編號</p>
    </div>
    <select name="select_purchase" style="display:inline-block;">
        <option value="A">AAAAAAAAAA</option>
    </select>
  </div>

  <div style="float:left; width:50%;">
    <table id="stock_table" border="1">
      <thead style="width:98%">
        <tr>
          <th >編號</th>
          <th >品名</th>
          <th >規格</th>
          <th >型式</th>
          <th >數量</th>
        </tr>
      </thead>
      <?php
      $link=require_once "config.php";

      $sql = "SELECT 編號, 品名, 規格, 型式, 數量 from 零件 ORDER BY 編號 ASC";
      $result = $link-> query($sql);

      if($result->num_rows > 0){
        $i = 0;
        while($row = $result-> fetch_assoc()){
            echo "<tr><td>". $row["編號"] ."</td><td>". $row["品名"] ."</td><td>". $row["規格"] ."</td><td>" .$row["型式"] ."</td><td>". $row["數量"] ."</td></tr>";
        }
      }
      else{
        echo "0 result";
      }

      $link-> close();
      ?>
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