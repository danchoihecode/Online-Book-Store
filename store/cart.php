<?php
session_start();
include_once('./assets/database/connect.php');
?>
<?php
$code = $_SESSION['code'];
$a = array();
if (isset($_POST['count'])) $count = $_POST['count'];
else $count = 0;
if (isset($_POST['modifyCart'])) {
    for ($i = 1; $i <= $count; $i++) {
        $id_product = $_POST["product_$i"];
        $amount = $_POST["amount_$i"];
        $invent = $_POST["invent_$i"];
        if ($amount <= $invent) {
            mysqli_query($con, "UPDATE order_detail SET amount = '$amount' WHERE code='$code' AND product_id = '$id_product'");
        } else array_push($a, $i);
    }
} else {
    for ($i = 1; $i <= $count; $i++) {
        if (isset($_POST["x_$i"])) {
            $id_product = $_POST["product_$i"];
            mysqli_query($con, "DELETE FROM order_detail WHERE code='$code' AND product_id='$id_product'");
        }
    }
}
$sql_cart = mysqli_query($con, "CALL getOrder('$code')");
mysqli_next_result($con);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/fonts/themify-icons/themify-icons.css">
    <script type="text/javascript" src="./assets/js/js.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
</head>

<body>
    <!---------Header-->
    <?php
    include_once('./include/topbar.php');
    ?>
    <!---------Cart-->
    <div class="container">
        <h1 class="category-title-text">Giỏ hàng</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="cart-content">
                <div class="left-cart">
                    <table>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Xóa</th>
                        </tr>
                        <?php
                        $count = 0;
                        while ($row_fetch_cart = mysqli_fetch_array(($sql_cart))) {
                            $count++;
                        ?>
                            <tr>
                                <input type="hidden" name="product_<?php echo $count ?>" value="<?php echo $row_fetch_cart['product_id'] ?>">
                                <input type="hidden" name="invent_<?php echo $count ?>" value="<?php echo $row_fetch_cart['invent'] ?>">
                                <td><img src="<?php echo $row_fetch_cart['image'] ?>" alt="">
                                    <p><?php echo $row_fetch_cart['title'] ?></p>
                                    <p style="color:red;text-align:center;"><?php if (in_array($count, $a)) echo "Kho chỉ còn " . $row_fetch_cart['invent'] . " cuốn !" ?></p>
                                </td>
                                <td><?php echo $row_fetch_cart['price_discount'] ?><sup>đ</sup></td>
                                <td><input id="insert_qty" type="number" name="amount_<?php echo $count ?>" value="<?php echo $row_fetch_cart['amount'] ?>" min="1">
                                    
                                </td>
                                <td>
                                    <p><?php echo $row_fetch_cart['purchase'] ?> <sup>đ</sup></p>
                                </td>
                                <td><input type="submit" name="x_<?php echo $count ?>" id="delete_button" value="X">
                            </tr>
                        <?php
                        }
                        ?>
                        <input type="hidden" name="count" value="<?php echo $count ?>">
                    </table>
                </div>
                <?php
                $sql_list_order = mysqli_query($con, "SELECT * FROM orders WHERE code='$code'");
                $row_list_order = mysqli_fetch_array($sql_list_order);
                ?>
                <div class="right-cart">
                    <table>
                        <tr>
                            <th colspan="2">Tổng tiền</th>
                        </tr>
                        <tr>
                            <td>Tổng sản phẩm</td>
                            <td><?php if ($row_list_order) echo $row_list_order['quantity'] ?></td>
                        </tr>
                        <tr>
                            <td>Tổng tiền hàng</td>
                            <td>
                                <p><?php if ($row_list_order) echo $row_list_order['total_purchase'] ?><sup>đ</sup></p>
                            </td>
                        </tr>
                    </table>

                    <div class="cart-button">
                        <input type="submit" name="modifyCart" id="update_button" value="Cập nhật giỏ hàng">
                        <a class="blue-button" href="./index.php?p=1">Tiếp tục mua sắm</a>
                        <a class="blue-button" href="./delivery.php">Mua hàng</a>
                    </div>
                </div>
            </div>
            <div class="popup" id="popup" style="border:1px solid green;">
            <h2 style="font-size:28px;color:red">Vui lòng nhập lại số lượng.</h2>
            <p>Có <?php echo count($a)?> sản phẩm không còn đủ trong kho !</p>              
            <button type="button" id="update_button" style="margin-top:50px;" onclick="closePopup()">OK</button>
            </div>
        </form>
        <script>
            function closePopup() {
                var popup = document.getElementById("popup");
                popup.classList.remove("open-popup");
            }
        </script>
    </div>
    <!---------Footer-->
    <?php
    include_once('./include/footer.php');
    ?>
    <script>
    var x=<?php echo count($a);?>;
    if (x>0)
    {
    var popup = document.getElementById("popup");
    popup.classList.add("open-popup");
    }
    </script> 
</body>

</html>