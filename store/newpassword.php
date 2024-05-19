<?php
session_start();
include_once('./assets/database/connect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/style.css">
  <title> Đăng ký </title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&family=Poppins:wght@400;500;600&display=swap');

    * {
      font-family: "Poppins", sans-serif;
    }

    body {
      background: linear-gradient(120deg, #2980b9, #8e44ad);
      height: 100vh;
      overflow: auto;
    }

    .center {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 600px;
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
      top: 50%;
      left: 5px;
      color: #adadad;
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

    .txt_field input:focus~span::before,
    .txt_field input:valid~span::before {
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

<body>
  <div class="center">
    <h1>Lấy lại mật khẩu cho bạn</h1>
    <p style="text-align:center">Vui lòng nhập mật khẩu mới</p>
    <form action="" method="post">
      <div class="txt_field">
        <input type="password" name="new_password">
        <span></span>
        <label>Mật khẩu</label>
      </div>
      <div class="txt_field">
        <input type="password" name="renew_password">
        <span></span>
        <label>Nhập lại mật khẩu</label>
      </div>
      <input type="submit" value="Submit" name="submit">
      <div class="signup_link">
        <a href="index.php?log=logout">Quay về trang chủ</a>
      </div>
    </form>
  </div>
  <?php
  if (isset($_POST['submit'])) {
    $code = $_POST['new_password'];
    $code2 = $_POST['renew_password'];
    if ($code == $code2) {
      $php = $con->query("UPDATE customer SET password = '$code' WHERE email = '$_SESSION[email]'");
      $_SESSION['email'] = '';
      $_SESSION['phone'] = '';
      header("Location: success.php");
    } else {
      echo ("Mật khẩu nhập lại không đúng");
    }
  }
  ?>
</body>

</html>