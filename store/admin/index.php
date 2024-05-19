<?php
session_start();
include_once('../assets/database/connect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/style.css">
  <title>Đăng nhập Admin</title>
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
      width: 400px;
      background: white;
      border-radius: 10px;
      box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.05);
      padding-bottom: 50px;
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
  </style>
</head>

<body>
  <div class="center">
    <h1>Đăng nhập</h1>
    <form action="" method="post">
      <div class="txt_field">
        <input type="text" name="account" required>
        <span></span>
        <label>Tài khoản</label>
      </div>
      <div class="txt_field">
        <input type="password" name="pass" required>
        <span></span>
        <label>Mật khẩu</label>
      </div>
      <input type="submit" value="Login" name="login">
    </form>
  </div>
  <?php
  if (isset($_POST['login'])) {
    $account = $_POST['account'];
    $pass = $_POST['pass'];
    $sql_select_admin = mysqli_query($con, "SELECT * FROM admin WHERE account = '$account' AND password = '$pass'");
    $row_login = mysqli_fetch_array($sql_select_admin);
    if (isset($row_login)) {
      $_SESSION['login'] = $row_login['admin_name'];
      $_SESSION['admin_id'] = $row_login['id'];
      header('Location: quanlysanpham.php');
    } else {
      echo "Sai tài khoản hoặc mật khẩu!";
    }
  }
  ?>

</body>

</html>