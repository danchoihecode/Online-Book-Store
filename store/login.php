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
  <title>Đăng nhập</title>
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
    .pass a {
      color:#a6a6a6;
      text-decoration:none;
    }
    .pass a:hover {
      color:#a6a6a6;
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
    <h1>Đăng nhập</h1>
    <form action="" method="post">
      <div class="txt_field">
        <input type="text" name="phone" required>
        <span></span>
        <label>Tài khoản</label>
      </div>
      <div class="txt_field">
        <input type="password" name="pass" required>
        <span></span>
        <label>Mật khẩu</label>
      </div>
      <div class="pass"><a href="forgetpassword.php">Quên mật khẩu ?</a></div>
      <input type="submit" value="Đăng nhập" name="login">
      <div class="signup_link">
        Chưa có tài khoản ? <a href="register.php">Đăng ký</a>
      </div>
    </form>
  </div>
  <?php
  if (isset($_POST['login'])) {
    $phone = $_POST['phone'];
    $pass = $_POST['pass'];
    $sql_select_user = mysqli_query($con, "SELECT * FROM customer WHERE phone='$phone' AND password = '$pass'");
    $row_login = mysqli_fetch_array($sql_select_user);
    if (isset($row_login)) {
      $_SESSION['log'] = $row_login['name'];
      $_SESSION['phone'] = $row_login['phone'];
      $_SESSION['email'] = $row_login['email'];
      $_SESSION['profile'] = 1;
      $_SESSION['valid_name'] = 1;  #
      $_SESSION['valid_pass'] = 1;  #
      $locate = mysqli_fetch_assoc($con->query("SELECT address FROM customer WHERE phone ='$phone'"));
      if ($locate['address'] == NULL) $_SESSION['location'] = ''; else 
      $_SESSION['location'] = $row_login['address'];
      $_SESSION['password'] = $_POST['pass'];
      $sql_check=mysqli_query($con,"SELECT * FROM orders WHERE acc_phone='$phone' AND status= 2");
      $row=mysqli_fetch_array($sql_check);
      if($row) {
        $_SESSION['code']=$row['code'];
      }
      else {$_SESSION['code'] =-1;}
      header('Location: index.php?p=1');
    } else {
      echo "Sai số điện thoại hoặc mật khẩu!";
    }
  }
  ?>

</body>

</html>