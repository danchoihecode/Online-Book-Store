<?php
include_once('../assets/database/connect.php');
?>
<?php
if (isset($_GET['xoa'])) {
    $code = $_GET['xoa'];
    $sql_order = mysqli_query($con, "DELETE FROM orders WHERE code = '$code'");
    unset($code);
}
?>
   
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Xử lý đơn hàng</title>
    <style>
        input[type="submit"] {
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

        input[type="submit"]:hover {
            border-color: #4caf50;
            transition: .5s;
        }
    </style>
</head>

<body>
    <?php
    include_once('./dashboard.php');
    ?>
    <?php
    if (isset($_GET['xem'])) 
    {
    ?>
    <div class="right-order">
        <h3 style="margin-bottom: 10px;">Chi tiết đơn hàng</h3>
        <form action="" method="post">
            <table class="admin-table">
                <tr class="row1">
                    <th style="width:5%">STT</th>
                    <th style="width:15%">Mã đơn hàng</th>
                    <th style="width:35%">Tên SP</th>
                    <th style="width:5%">SL</th>
                </tr>
                <?php
                if (isset($_GET['xem'])) {
                    $count2 = 0;
                    $code = $_GET['xem'];
                    $sql_order = mysqli_query($con, "CALL getOrder('$code')");
                    mysqli_next_result($con);
                    $sql_list_order = mysqli_query($con, "SELECT total_purchase,delivery FROM orders WHERE code='$code'");
                    $row_list_order = mysqli_fetch_array($sql_list_order);
                    $sum=$row_list_order['total_purchase'];
                    $delivery=$row_list_order['delivery'];
                    while ($row_order = mysqli_fetch_array($sql_order)) {
                        $count2++;
                ?>
                        <tr>
                            <td><?php echo $count2 ?></td>
                            <td><?php echo $row_order['code'] ?></td>
                            <td><?php echo $row_order['title'] ?></td>
                            <td><?php echo $row_order['amount'] ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
                <tr>
                    <td></td>
                    <td></td>    
                    <td>Tổng cộng</td>                           
                    <td><?php if(isset($sum)) echo $sum ?><sup style="float:right;">đ</sup></td>
                </tr>
            </table>
            <h4 style="margin-top:30px;">Hình thức trả tiền:
            <?php if (isset($delivery))
            {
                if ($delivery ==0)  echo "Thanh toán khi nhận hàng"; else echo "Chuyển khoản trước";
            } ?>
            </h4>
            <h3 style="margin: 20px 0 10px 0;">Người nhận hàng</h3>
            <table class="admin-table">
                <tr class="row1">
                    <th style="width:20%">Tên</th>
                    <th style="width:12%">SĐT</th>
                    <th style="width:20%">Email</th>
                    <th style="width:25%">Địa chỉ</th>
                </tr>
                <?php
                if (isset($_GET['xem'])) {
                    $code = $_GET['xem'];
                    $sql_select_listorder = mysqli_query($con, "SELECT * FROM orders WHERE code = '$code'");
                    $row_select_listorder = mysqli_fetch_array($sql_select_listorder);
                ?>
                    <tr>
                        <td><?php echo $row_select_listorder['name'] ?></td>
                        <td><?php echo $row_select_listorder['phone'] ?></td>
                        <td><?php echo $row_select_listorder['email'] ?></td>
                        <td><?php echo $row_select_listorder['address'] ?></td>
                    </tr>
                <?php
                }
                ?>
            </table>
            <?php
            if (isset($_POST['submit'])) {
                $status = $_POST['status'];
                $sql_update = mysqli_query($con, "UPDATE orders SET status = '$status' WHERE code = '$code'");
            }
            ?>
            <?php
            if (isset($code)) {
                $count = 0;
                $sql_listorders = mysqli_query($con, "SELECT * FROM orders WHERE code = '$code'");
                $row_listorder = mysqli_fetch_array($sql_listorders);

            ?>
                <input type="radio" name="browser" onclick="myFunction(this.value)" value="1" <?php if ($row_listorder['status'] == 1) echo "checked" ?>>Đã xử lý<br>
                <input type="radio" name="browser" onclick="myFunction(this.value)" value="0" <?php if ($row_listorder['status'] == 0) echo "checked" ?>>Chưa xử lý<br><br>
            <?php
            }
            ?>
            <input type="hidden" name="status" id="result">
            <input type="submit" name="submit" value="Cập nhật">
            <script>
                function myFunction(browser) {
                    document.getElementById("result").value = browser;
                }
            </script>
        </form>


    </div>
    <?php
    }
    ?>
    <div class="left-order" style="float:left">
        <h3 style="margin-bottom: 10px;">Danh sách đơn hàng</h3>
        <table class="admin-table">
            <tr class="row1">
                <th style="width:5%">STT</th>
                <th style="width:10%">Mã ĐH</th>
                <th style="width:15%">Tình trạng</th>
                <th style="width:15%">Tên KH</th>
                <th style="width:15%">Ngày đặt</th>
                <th style="width:15%">Ghi chú</th>
                <th>Thao tác</th>
            </tr>
            <?php
            $count = 0;
            $sql_listorders = mysqli_query($con, "SELECT code,status,c.name name,date,note FROM orders,customer c WHERE acc_phone=c.phone");
            while ($row_listorder = mysqli_fetch_array($sql_listorders)) {
                if ($row_listorder['status'] != 2) {
                    $count++;
            ?>
                    <tr>
                        <td><?php echo $count ?></td>
                        <td><?php echo $row_listorder['code'] ?></td>
                        <td>
                            <?php
                            if ($row_listorder['status'] == 0) {
                                echo "Chưa xử lý";
                            } else {
                                echo "Đã xử lý";
                            }
                            ?>
                        </td>
                        <td><?php echo $row_listorder['name'] ?></td>
                        <td><?php echo $row_listorder['date'] ?></td>
                        <td><?php echo $row_listorder['note'] ?></td>
                        <td><a class="get_button" href="?xoa=<?php echo $row_listorder['code'] ?>">Xóa</a>
                            <a class="get_button" href="?xem=<?php echo $row_listorder['code'] ?>">Xem</a>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </table>
    </div>

    <body>

    </body>

</html>