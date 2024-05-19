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
      width: 480px;
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
      margin: 20px 0;
    }

    .txt_field input {
      width: 100%;
      padding: 0 5px;
      height: 20px;
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
      top: 23epx;
      left: 0;
      width: 0%;
      height: 2px;
      background: #2691d9;
      transition: .5s;
    }

    .txt_field input:focus~label, .txt_field input:valid~label{
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
      margin: 25px 0;
      text-align: center;
      font-size: 14px;
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
    <?php
    function convert_name($str) {
      $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
      $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
      $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
      $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
      $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
      $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
      $str = preg_replace("/(đ)/", 'd', $str);
      $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
      $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
      $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
      $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
      $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
      $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
      $str = preg_replace("/(Đ)/", 'D', $str);
      return $str;
    }
      $phone = $email = $name = $address = $password = $repass = "";
      if (isset($_POST['register'])){
        $valid = 1;
        $phone = $_POST['phone'];
        if ($phone == NULL){
          echo ("Cần nhập số điện thoại\n");
          $phone = "";
          $valid = 0;
        }
        if (strlen($phone) > 10 || strlen($phone) < 9 || substr($phone, 0, 1) != "0")
        {
          if ($valid != 0)
            echo ("Số điện thoại không hợp lệ\n");
          $phone = "";
          $valid = 0;
        }
        $email = $_POST['email'];
        $name = $_POST['name'];
        if ($name == NULL)
        {
          if ($valid != 0)
            echo ("Cần nhập tên\n");
          $name = "";
          $valid = 0;
        } else {
          $temp_name = $name;
          $temp_name = convert_name($temp_name);
          if (ctype_alpha(str_replace(' ', '', $temp_name)) === false)
          {
            if ($valid != 0)
              echo ("Tên không hợp lệ");
              $valid = 0;
          
          }
        }
        $address = $_POST['address'];
        $pass = $_POST['pass'];
        if ($_POST['pass'] == NULL)
        {
          if ($valid != 0)
            echo ("Cần nhập mật khẩu\n");
          $pass = "";
          $valid = 0;
        }
        if (strlen($pass) < 6)
        {
          if ($valid != 0)
            echo ("Mật khẩu phải dài ít nhất 6 kí tự");
          $pass = "";
          $valid = 0;
        }
        if ($_POST['repass'] == NULL)
        {
          if ($valid != 0)
            echo ("Vui lòng nhập lại mật khẩu để xác thực\n");
          $repass = "";
          $valid = 0;
        }
        if ($_POST['repass'] != $_POST['pass']){
          if ($valid != 0)
            echo ("Mật khẩu nhập lại không đúng\n");
          $repass = "";
          $valid = 0;
        };
        $query = "SELECT COUNT(*) AS c FROM customer WHERE phone like '$phone'";
        $query = mysqli_fetch_assoc($con->query($query));
        $query = $query['c'];
        if ($query == '0' && $valid == 1)
        {
          $sql_insert = mysqli_query($con, "INSERT INTO customer (phone, name, password) 
          VALUES ('$phone', '$name', '$pass')");
          if ($email != NULL)
            $sql_insert = mysqli_query($con, "UPDATE customer SET email = '$email' WHERE phone LIKE '$phone'");
        if ($address != NULL)
          $sql_insert = mysqli_query($con, "UPDATE customer SET address = '$address' WHERE phone LIKE '$phone'");
        header("Location: success.php");
        } else if ($query != '0'){
          echo ("Số điện thoại này đã tồn tại !");
        }
      }
    ?>
    <div class="center">
        <h1>Đăng ký</h1>
        <form action="" method="post">
          <table style="width:100%">
            <tr>
              <td>
                <div class="txt_field">
                  <input type="text" value="<?php echo $phone ?>" name="phone">
                  <span></span>
                  <label>SĐT (*)</label>
                </div>
              </td>
              <td>
                <div class="txt_field">
                  <input type="text" value="<?php echo $email ?>" name="email">
                  <span></span>
                  <label>Email</label>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <div class="txt_field">
                  <input type="text" value="<?php echo $name ?>" name="name">
                  <span></span>
                  <label>Họ tên (*)</label>
                </div>
              </td>
              <td>
                <div class="txt_field">
                  <input type="text" value="<?php echo $address ?>" name="address">
                  <span></span>
                  <label>Địa chỉ</label>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <div class="txt_field">
                  <input type="password" name="pass">
                  <span></span>
                  <label>Mật khẩu (*)</label>
                </div>
              </td>
              <td>
                <div class="txt_field">
                  <input type="password" name="repass">
                  <span></span>
                  <label>Nhắc lại mật khẩu (*)</label>
                </div>
              </td>
            </tr>
          </table>
        <input type="submit" value="Đăng ký" name="register">
        <div class="signup_link">
          <a href="login.php">Đăng nhập lại</a>
        </div>
        </form>
      </div>
    </body>

</html>