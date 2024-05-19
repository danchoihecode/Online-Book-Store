<?php
include_once('./assets/database/connect.php');
session_start();
if (isset($_GET['log'])) {
  unset($_SESSION['phone']);
  unset($_SESSION['log']);
  header('Location: index.php?p=1');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/fonts/themify-icons/themify-icons.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Store</title>

  <head>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&family=Poppins:wght@400;500;600&display=swap');

      body {
        background: linear-gradient(120deg, #2980b9, #8e44ad);
        height: 100vh;
        overflow: auto;
      }

      .change {
        margin: 30px 30px 10px 0px;
        width: 30%;
        height: 50px;
        border: 1px solid;
        background: #2691d9;
        border-radius: 25px;
        font-size: 18px;
        color: #e9f4fb;
        font-weight: 700;
        cursor: pointer;
        outline: none;
        text-decoration: none;
        padding: 10px;
      }

      .change:hover {
        border-color: #2691d9;
        transition: .5s;
      }
    </style>
  </head>

</head>

<body>

  <?php
  include_once("./include/topbar.php");
  $phone = $_SESSION['phone'];
  $query = mysqli_query($con, "SELECT * FROM orders WHERE acc_phone='$phone' ORDER BY date DESC");
  ?>
  <a class="change" href="index.php?p=1">Về trang chủ</a>
  <div id="order">
    <h3 style="margin-bottom:20px;">Lịch sử mua hàng</h3>
    <table>
      <th>STT</th>
      <th>Người nhận hàng</th>
      <th>SĐT người nhận</th>
      <th>Địa chỉ</th>
      <th>Thời gian đặt hàng</th>
      <th>Tổng sản phẩm</th>
      <th>Tổng thanh toán</th>
      <th>Trạng thái</th>
      <?php
      $count = 1;
      while ($rs = mysqli_fetch_array($query)) {
      ?>
        <tr>
          <td><?php echo $count ?></td>
          <td><?php echo $rs['name'] ?></td>
          <td><?php echo $rs['phone'] ?></td>
          <td><?php echo $rs['address'] ?></td>
          <td><?php echo $rs['date'] ?></td>
          <td><?php echo $rs['quantity'] ?></td>
          <td><?php echo $rs['total_purchase'] ?><sup>đ</sup></td>
          <td><?php if ($rs['status'] == 0) echo "Chưa xử lí";
              elseif ($rs['status'] == 2) echo "Chờ đặt hàng"; 
              else echo "Đã xử lí"; ?>
          </td>
        </tr>
      <?php
        $count++;
      }
      ?>
    </table>

  </div>
  <?php
  include_once("./include/footer.php");
  ?>
</body>

</html>