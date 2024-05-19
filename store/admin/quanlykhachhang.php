<?php
    include_once('../assets/database/connect.php');
?>
 <?php
            if(isset($_GET['xoa'])){
                $phone = $_GET['xoa'];
                $sql_customer = mysqli_query($con, "DELETE FROM customer WHERE phone = '$phone'"); 
            }
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Admin</title>
    <style>
    input[type="submit"]{
    width: 100%;
    height: 50px;
    border: 1px solid;
    background: #4caf50;
    border-radius: 25px;
    font-size: 18px;
    color: #e9f4fb;
    font-weight: 700;
    cursor: pointer;
    outline: none;
  }
  input[type="submit"]:hover{
    border-color: #4caf50;
    transition: .5s;
  }
    </style>
</head>
<body>
    <?php
        include_once('./dashboard.php');
    ?>
    <div class="left-customer">
        <form  action="" method="POST">
            <label>Tìm khách hàng:</label>
            <input style="margin-top:20px" type="search" name="phone" placeholder="Số điện thoại">
            <input style="width:15%;" type="submit" name="search" value="Tìm kiếm">
        </form>
        <table  class="admin-table">
            <tr class="row1">
                <th style="width:2%">STT</th>
                <th style="width:12%">Tên</th>
                <th style="width:12%">SĐT</th>
                <th style="width:20%">Email</th>
                <th style="width:25%">Địa chỉ</th>
                <th>Thao tác</th>
            </tr>
            <?php
                if(isset($_POST['search'])){
                    $phone = $_POST['phone'];
                    $sql_customer = mysqli_query($con, "SELECT * FROM customer WHERE phone LIKE '%$phone%'"); 
                }
                else{
                    $sql_customer = mysqli_query($con, "SELECT * FROM customer");
                }
                $count = 0;
                while($row_customer = mysqli_fetch_array($sql_customer)){
                    $count++;
            ?>
            <tr>
                <td><?php echo $count ?></td>
                <td><?php echo $row_customer['name'] ?></td>
                <td><?php echo $row_customer['phone'] ?></td>
                <td><?php echo $row_customer['email'] ?></td>
                <td><?php echo $row_customer['address'] ?></td>
                <td>
                    <a class="get_button" href="?xoa=<?php echo $row_customer['phone'] ?>">Xóa</a>
                </td>
            </tr>
            <?php 
            }
            ?>
            
        </table>
    </div>
       
</body>
</html>