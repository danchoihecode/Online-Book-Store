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
        margin: 30px 30px 10px 20px;
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
  ?>
  <div id="profile">
    <?php
    function p_encrypt($email, $a)
    {
      $em   = explode("@", $email);
      $name = implode('@', array_slice($em, 0, count($em) - 1));
      $len  = strlen($name);
      return substr($name, 0, $a) . str_repeat('*', $len - $a) . "@" . end($em);
    };
    ?>

    <h3 style="margin:30px 0px 20px 20px;">Thông tin khách hàng </h3>
    <?php
    $ph = $_SESSION['phone'];
    $php1 = "SELECT email FROM customer WHERE phone = '$ph'";
    $php1 = mysqli_fetch_assoc(mysqli_query($con, $php1));
    $_SESSION['email'] = $php1['email'];
    ?>
    <table>
      <tr>
        <td>
          Họ và tên : <?php echo $_SESSION['log']; ?>
        </td>
        <td>
          Số điện thoại : <?php echo $_SESSION['phone']; ?>
        </td>
      </tr>
      <tr>
        <td> Email: <?php if ($_SESSION['email'] == '') echo '';
                    else echo p_encrypt($_SESSION['email'], 1); ?></td>
        <td> Địa chỉ : <?php echo $_SESSION['location']; ?> </td>
      </tr>
      <tr>
        <td>
          Mật khẩu : <?php echo str_repeat('*', strlen($_SESSION['password'])); ?>
        </td>
        <td></td>
      </tr>
    </table>
    <a class="change" href="changeinfo.php">Thay đổi thông tin</a>
    <a class="change" href="order.php">Xem lịch sử mua hàng</a>
  </div>
  <?php
  include_once("./include/footer.php");
  ?>
</body>

</html>