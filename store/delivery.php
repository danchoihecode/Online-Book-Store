<?php
session_start();
include_once('./assets/database/connect.php');
$code = $_SESSION['code'];
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
    <title>Cart</title>
</head>

<body>
    <!---------Header-->
    <?php
    include_once('./include/topbar.php');
    ?>

    <?php
    $x=0;
    if (isset($_POST['checkout'])) {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $note = $_POST['note'];
        $delivery = $_POST['delivery'];
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $date = date("Y-m-d G:i:s");
        mysqli_query($con, "UPDATE orders SET date='$date',status=0,phone='$phone',name='$name',email='$email',address='$address',
        delivery='$delivery',note='$note' WHERE code='$code'");
        $_SESSION['code'] = -1;
        $code = $_SESSION['code'];
        $x=1;
    }
    ?>
    <!---------Cart-->
    <div class="container">
        <div class="delivery">
            <div class="info-address">
                <h1>Thông tin giao hàng</h1>
                <form action="" method="post">
                    <table>
                        <tr>
                            <td>Họ tên:</td>
                            <td><input type="text" name="name"></td>
                        </tr>
                        <tr>
                            <td>SĐT:</td>
                            <td><input type="text" name="phone" required></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><input type="text" name="email"></td>
                        </tr>
                        <tr>
                            <td>Địa chỉ:</td>
                            <td><input type="text" name="address" required></td>
                        </tr>
                        <tr>
                            <td>Ghi chú:</td>
                            <td><input type="text" name="note"></td>
                        </tr>
                        <tr>
                            <td>Hình thức trả tiền:</td>
                            <td>
                                <select name="delivery">
                                    <option value="0">Thanh toán khi nhận hàng</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <button type="submit" name="checkout" id="delivery_button">Đặt hàng</button>
                    <div class="popup" id="popup">
                        <img src="./assets/img/404-tick.png">
                        <h2>Cảm ơn</h2>
                        <p>Bạn đã đặt hàng thành công. Đơn hàng đang được xử lí.</p>
                        <button type="button" id="update_button" style="margin-top:50px;" onclick="closePopup()">
                            <a style="text-decoration:none;color:#fff;" href="index.php?p=1">Về trang chủ</a></button>
                    </div>
                </form>
                <script>
                    function closePopup() {
                        var popup = document.getElementById("popup");
                        popup.classList.remove("open-popup");
                    }
                </script>
            </div>
            <div class="list-items-buy">
                <h1>Thông tin đơn hàng</h1>
                <table>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                    <?php
                    $sql_cart = mysqli_query($con, "CALL getOrder('$code')");
                    mysqli_next_result($con);
                    $sql_list_order = mysqli_query($con, "SELECT * FROM orders WHERE code='$code'");
                    $row_list_order = mysqli_fetch_array($sql_list_order);
                    while ($row_fetch_cart = mysqli_fetch_array(($sql_cart))) {
                    ?>
                        <tr>
                            <td><img src="<?php echo $row_fetch_cart['image'] ?>" alt="">
                                <p><?php echo $row_fetch_cart['title'] ?></p>
                            </td>
                            <td><?php echo $row_fetch_cart['price_discount'] ?><sup>đ</sup></td>
                            <td><?php echo $row_fetch_cart['amount'] ?></td>
                            <td>
                                <p><?php echo $row_fetch_cart['purchase'] ?> <sup>đ</sup></p>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <th>Tổng tiền</th>
                        <th></th>
                        <th></th>
                        <th>
                            <p><?php if ($row_list_order) echo $row_list_order['total_purchase'] ?><sup>đ</sup></p>
                        </th>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <?php
    include_once('./include/footer.php');
    ?>
    <script>
    var x=<?php echo $x;?>;
    if (x==1)
    {
    var popup = document.getElementById("popup");
    popup.classList.add("open-popup");
    }
    </script> 
</body>

</html>