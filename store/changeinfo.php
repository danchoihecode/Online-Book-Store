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

      .center {
        position: absolute;
        top: 54%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 400px;
        background: white;
        border-radius: 10px;
        box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.05);
      }

      .center h1 {
        text-align: center;
        padding: 20px 0;
        border-bottom: 1px solid silver;
      }

      .center form {
        padding: 0 40px;
        box-sizing: border-box;
      }

      form .txt_field {
        position: relative;
        border-bottom: 2px solid #adadad;
        margin: 30px 0;
      }

      .txt_field input {
        width: 100%;
        padding: 0 5px;
        height: 40px;
        font-size: 16px;
        border: none;
        background: none;
        outline: none;
      }

      .txt_field label {
        position: absolute;
        top: -11%;
        left: 5px;
        color: #2691d9;
        transform: translateY(-50%);
        font-size: 16px;
        pointer-events: none;
        transition: .5s;
      }

      .txt_field span::before {
        content: '';
        position: absolute;
        top: 40px;
        left: 0;
        width: 0%;
        height: 2px;
        background: #2691d9;
        transition: .5s;
      }

      .txt_field input:focus~label,
      .txt_field input:valid~label {
        top: -5px;
        color: #2691d9;
      }

      .txt_field input:focus~span::before {
        width: 100%;
      }

      .pass {
        margin: -5px 0 20px 5px;
        color: #a6a6a6;
        cursor: pointer;
      }

      .pass:hover {
        text-decoration: underline;
      }

      input[type="submit"] {
        margin-bottom: 50px;
        width: 100%;
        height: 50px;
        border: 1px solid;
        background: #2691d9;
        border-radius: 25px;
        font-size: 18px;
        color: #e9f4fb;
        font-weight: 700;
        cursor: pointer;
        outline: none;
      }

      input[type="submit"]:hover {
        border-color: #2691d9;
        transition: .5s;
      }

      .signup_link {
        margin: 30px 0;
        text-align: center;
        font-size: 16px;
        color: #666666;
      }

      .signup_link a {
        color: #2691d9;
        text-decoration: none;
      }

      .signup_link a:hover {
        text-decoration: underline;
      }
    </style>
  </head>

</head>

<body>

  <?php
  function p_encrypt($email, $a)
  {
    $em   = explode("@", $email);
    $name = implode('@', array_slice($em, 0, count($em) - 1));
    $len  = strlen($name);
    return substr($name, 0, $a) . str_repeat('*', $len - $a) . "@" . end($em);
  }
  include_once("./include/topbar.php");
  include_once("./include/slider.php");
  ?>
  <div id="profile">
    <?php
    $phone = $_SESSION['phone'];
    $name = $_SESSION['log'];
    $email = $_SESSION['email'];
    ?>
    <div class="center">
      <h1 style="color:black">Thay đổi thông tin</h1>
      <form action="" method="post">
        <div class="txt_field">
          <input type="text" value="<?php echo $_SESSION['phone'] ?>" name="phone2" required readonly>
          <span></span>
          <label>Số điện thoại :</label>
        </div>
        <div class="txt_field">
          <input type="text" value="<?php echo $_SESSION['log']; ?>" name="name2" required>
          <span></span>
          <label>Họ và tên :</label>
        </div>
        <div class="txt_field">
          <input type="text" value="<?php echo $_SESSION['email'] ?>" name="email2">
          <span></span>
          <label>Email :</label>
        </div>
        <div class="txt_field">
          <input type="text" value="<?php if ($_SESSION['location'] == '') echo '';
                                    else echo $_SESSION['location']; ?>" name="address2">
          <span></span>
          <label>Địa chỉ :</label>
        </div>
        <div class="txt_field">
          <input type="password" value="" name="pass2" required>
          <span></span>
          <label>Mật khẩu :</label>
        </div>
        <?php
        if ($_SESSION['valid_name'] == 0) echo ('<span style="text-align:center; color: red; font-size: 12.5px;"> ' . "Tên không hợp lệ !");
        if ($_SESSION['valid_pass'] == 0) echo ('<span style="text-align:center; color: red; font-size: 12.5px;"> ' . "Mật khẩu phải dài ít nhất 6 kí tự !");
        ?>
        <br>
        <input type="submit" value="Cập nhật" name="trigger_change">
      </form>
    </div>
  </div>
</body>

</html>