<?php
session_start();
if(!isset($_SESSION['phone']))
{
  header('Location: login.php');
} 
include_once('./assets/database/connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/fonts/themify-icons/themify-icons.css">
  <script src="./assets/js/js.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product</title>
</head>

<body>
  <!---------Header-->
  <?php
  include_once('./include/topbar.php');
  ?>

  <?php
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
  } else {
    $id = '';
  }
  $sql_product = mysqli_query($con, "SELECT * FROM product WHERE id = '$id'");
  ?>
  <?php
  $x=0;
  if (isset($_POST['addCart'])) {
      if ($_POST['invent'] !=0)
      {
      $phone = $_SESSION['phone'];
      if ($_SESSION['code'] == -1) {
        mysqli_query($con, "INSERT INTO orders(acc_phone) values ('$phone')");
        $result = mysqli_query($con, "SELECT MAX(code) as new FROM orders WHERE acc_phone='$phone'");
        $tmp = mysqli_fetch_array($result);
        $_SESSION['code'] = $tmp['new'];
      }
      $code = $_SESSION['code'];
      $id_product = $_POST['id_product'];
      $sql_select_cart = mysqli_query($con, "SELECT * FROM order_detail WHERE code='$code' AND product_id = '$id_product'");
      $count = mysqli_num_rows($sql_select_cart);
      if ($count > 0) {
        mysqli_query($con, "UPDATE order_detail SET amount = amount + 1 WHERE code='$code' AND product_id = '$id_product'");
      } else {
        mysqli_query($con, "INSERT INTO order_detail (code,product_id) values ('$code','$id_product')");
      }
      $x=2;
      } else $x=1;
  }
  ?>

  <?php
  $row_product = mysqli_fetch_array($sql_product);
  ?>
  <!---------Product-->
  <div id="product">
    <h1 class="category-title-text">Book Store</h1>
    <div class="img-product">
      <img src="<?php echo $row_product['image'] ?>" alt="">
    </div>

    <div class="info-product">
      <h1><?php echo $row_product['title'] ?></h1>
      <p class="sold" style="text-align:left">Đã bán: <?php echo $row_product['sold'] ?></p>
      <p><?php echo $row_product['infor'] ?></p>
      <h2><?php echo $row_product['price_discount'] ?><sup>đ</sup></h2>
      <p style=" margin-top:-10px;" class="price_original_product"><?php echo $row_product['price_original'] ?><sup>đ</sup></p>
      <form method="post">
        <input type="hidden" name="id_product" value="<?php echo $row_product['id'] ?>">
        <input type="hidden" name="invent" value="<?php echo $row_product['amount'] ?>">
        <input type="hidden" name="addCart">
        <button class="get_button">
          <i class="ti-shopping-cart">
            <span>Thêm vào giỏ hàng</span>
          </i>
        </button>
        <div class="popup" id="popup" style="border:1px solid green;">
            <h2 style="font-size:28px;">Sản phẩm này đã hết hàng</h2>
            <p>Sản phẩm đã hết hàng, mong bạn thông cảm.</p>              
            <button type="button" id="update_button" style="margin-top:50px;" onclick="closePopup()">OK</button>
            </div>
        <p id="demo"></p>
      </form>
      <script>
            function closePopup() {               
                var popup = document.getElementById("popup");
                popup.classList.remove("open-popup");
            }
        </script>
      <div class="card">
        <h4 style="margin: 20px 0 10px 0;"><b>CHÚNG TÔI</b> CAM KẾT</h4>
        <div class="commit">
          <p><i class='ti-truck'></i>Giao hàng toàn quốc</p>
        </div>
        <div class="commit">
          <p><i class='ti-money'></i>Giá cả cạnh tranh</p>
        </div>
        <div class="commit">
          <p><i class='ti-gift'></i> Khuyến mại hấp dẫn</p>
        </div>
        <div class="commit">
          <p><i class='ti-check-box'></i>Hoàn tiền 200% nếu phát hiện hàng giả</p>
        </div>
      </div>
    </div>
    <div class="infor-detail-product">
      <h1>Thông tin sản phẩm</h1>
      <table class="infor-detail-table">
        <tr>
          <td>Tên sản phẩm</td>
          <td><?php echo $row_product['title'] ?></td>
        </tr>
        <tr>
          <td>Tác giả</td>
          <td><?php echo $row_product['author'] ?></td>
        </tr>
        <tr>
          <td>NXB</td>
          <td><?php echo $row_product['publisher'] ?></td>
        </tr>
        <tr>
          <td>Số trang</td>
          <td><?php echo $row_product['print_length'] ?></td>
        </tr>
        <tr>
          <td>Kho</td>
          <td><?php echo $row_product['amount'] ?></td>
        </tr>
      </table>
      <p class="line"></p>
      <h2>Mô tả sản phẩm</h2>
      <p>
        <?php echo $row_product['description'] ?>
      </p>
    </div>
  </div>

  <?php
  include_once('./include/footer.php');
  ?>

<script>
    var x=<?php echo $x?>;
    if (x==1)
    {
    var popup = document.getElementById("popup");
    popup.classList.add("open-popup");
    }
    else if (x==2)
    {
    document.getElementById("demo").innerHTML = "Thêm vào giỏ hàng thành công !";
    }
    </script> 
</body>

</html>