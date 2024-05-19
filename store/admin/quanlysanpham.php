<?php
include_once('../assets/database/connect.php');
?>

<?php
if (isset($_POST['submit_add'])) {
    $title = $_POST['title'];
    $subcategory_id = $_POST['subcategory_id'];
    $price_original = $_POST['price_original'];
    $price_discount = $_POST['price_discount'];
    $infor = $_POST['infor'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $print_length = $_POST['print_length'];
    if ($_POST['image'] != '') {
        $image = "./assets/img/" . $_POST['image'];
    } else {
        $image = "./assets/img/112815953-stock-vector-no-image-available-icon-flat-vector.jpg";
    }
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $sql_product = mysqli_query($con, "CALL addProduct('$subcategory_id','$title','$price_original','$price_discount','$infor',
    '$author','$publisher','$print_length','$image','$amount','$description')");
    mysqli_next_result($con);
}
if (isset($_GET['xoa'])) {
    $id = $_GET['xoa'];
    $sql_product = mysqli_query($con, "DELETE FROM product WHERE id = '$id'");
}
if (isset($_POST['submit_modify'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $subcategory_id = $_POST['subcategory_id'];
    $price_original = $_POST['price_original'];
    $price_discount = $_POST['price_discount'];
    $infor = $_POST['infor'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $print_length = $_POST['print_length'];
    if ($_POST['image'] != '') {
        $image = "./assets/img/" . $_POST['image'];
    } else {
        $sql_product = mysqli_query($con, "SELECT * FROM product WHERE id = '$id'");
        $row_product = mysqli_fetch_array($sql_product);
        $image = $row_product['image'];
    }
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $sql_product = mysqli_query($con, "CALL updateProduct('$id','$subcategory_id','$title','$price_original','$price_discount','$infor',
    '$author','$publisher','$print_length','$image','$amount','$description')");
    mysqli_next_result($con);
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
    <title>Xử lý sản phẩm</title>
    <style>
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
    <?php
    include_once('./dashboard.php');
    ?>
    <div class="product-left">
        <form action="" method="post">
            <label>Tên sản phẩm</label>
            <input type="text" name="title" placeholder="Tên sản phẩm">
            <label>Danh mục</label>
            <select id="select-category" name="category">
                <?php
                $sql_select_category = mysqli_query($con, "SELECT * FROM category");
                while ($row_select_category = mysqli_fetch_array($sql_select_category)) {
                ?>
                    <option value="<?php echo $row_select_category['id'] ?>"><?php echo $row_select_category['name'] ?></option>
                <?php
                }
                ?>
            </select>

            <label>Danh mục con</label>
            <select id="de" class="select-subcategory" name="subcategory_id">
                <?php
                $sql_select_subcategory = mysqli_query($con, "SELECT * FROM subcategory");
                while ($row_select_subcategory = mysqli_fetch_array($sql_select_subcategory)) {
                ?>
                    <option value="<?php echo $row_select_subcategory['id'] ?>"><?php echo $row_select_subcategory['name'] ?></option>
                <?php
                }
                ?>
            </select>
            <label>Giá gốc</label>
            <input type="number" name="price_original" placeholder="Giá gốc">
            <label>Giá khuyến mãi</label>
            <input type="number" name="price_discount" placeholder="Giá khuyến mãi">
            <label>Giới thiệu sản phẩm</label>
            <textarea name="infor" placeholder="Giới thiệu sản phẩm..." style="height:50px;width:100%"></textarea>
            <label>Tác giả</label>
            <input type="text" name="author" placeholder="Tác giả">
            <label>NXB</label>
            <input type="text" name="publisher" placeholder="NXB">
            <label>Số trang</label>
            <input type="number" name="print_length" placeholder="Số trang">
            <label>Ảnh</label>
            <input type="file" name="image">
            <label>Số lượng trong kho</label>
            <input type="number" name="amount" placeholder="Số lượng trong kho" required>
            <label>Mô tả sản phẩm</label>
            <textarea name="description" placeholder="Mô tả sản phẩm..." style="height:100px;width:100%"></textarea>
            <input style="border-radius:10px" type="submit" name="submit_add" value="Submit">
        </form>
    </div>
    <div class="product-right">
        <div class="category-left" style="width: 12%; padding-left:5px;">
            <ul class="category-list">
                <?php
                $sql_category = mysqli_query($con, 'SELECT * FROM category ORDER BY id ASC');
                while ($row_category = mysqli_fetch_array($sql_category)) {
                ?>
                    <li>
                        <a href="?quanly=danhmuc&id=<?php echo $row_category['id'] ?>">
                            <?php echo $row_category['name'] ?>
                            <i class="down-btn ti-angle-down"></i>
                        </a>
                        <ul class="sub-category">
                            <?php
                            $id_category=$row_category['id'];
                            $sqlsubCategory = mysqli_query($con,"CALL getSub('$id_category')");
                            mysqli_next_result($con);
                            while ($row_subCategory = mysqli_fetch_array($sqlsubCategory)) {                             
                            ?>
                                    <li><a href="?quanly=danhmuccon&id=<?php echo $row_subCategory['id'] ?>">
                                            <?php echo $row_subCategory['name']; ?>
                                        </a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
        <div class="category-right" style="width: 82%; padding-left: 0px;">
            <div class="category-right-title">
                <h1>Danh sách sản phẩm</h1>
            </div>

            <div class="line-border"></div>
            <table class="admin-table">
                <tr class="row1">
                    <th style="width:5%">STT</th>
                    <th style="width:15%">Tên sản phẩm</th>
                    <th style="width:10%">Tác giả</th>
                    <th style="width:12%">NXB</th>
                    <th style="width:10%">Ảnh</th>
                    <th style="width:8%">Giá KM</th>
                    <th style="width:8%">Giá bìa</th>
                    <th style="width:7%">Đã bán</th>
                    <th style="width:7%">Tồn kho</th>
                    <th>Thao tác</th>
                </tr>
                <?php
                $count = 0;
                $id_category = 0;
                $id_subcategory = 0;
                $quanly = 0;
                $id = 0;
                if (isset($_GET['quanly'])) {
                    $quanly = $_GET['quanly'];
                    $id = $_GET['id'];
                }
                if ($quanly == 'danhmuc') {
                    $id_category  = $id;
                } else {
                    $id_subcategory  = $id;
                }

                if ($id_category > 0) {
                    $sql_product = mysqli_query($con, "CALL getProbyCategory('$id_category')");
                    mysqli_next_result($con);
                } else if ($id_subcategory > 0) {
                    $sql_product = mysqli_query($con, "CALL getProbySub('$id_subcategory')");
                    mysqli_next_result($con);
                } else {
                    $sql_product= mysqli_query($con, "SELECT * FROM product ORDER BY id DESC");
                }
                    while ($row_product = mysqli_fetch_array($sql_product)) {
                        $count++;
                ?>
                        <tr>
                            <td><?php echo $count ?></td>
                            <td><?php echo $row_product['title'] ?></td>
                            <td><?php echo $row_product['author'] ?></td>
                            <td><?php echo $row_product['publisher'] ?></td>
                            <td><img style="width: 80px;" src=".<?php echo $row_product['image'] ?>" alt=""></td>
                            <td><?php echo $row_product['price_discount'] ?></td>
                            <td><?php echo $row_product['price_original'] ?></td>
                            <td><?php echo $row_product['sold'] ?></td>
                            <td><?php echo $row_product['amount'] ?></td>
                            <td><a class="get_button" href="?xoa=<?php echo $row_product['id'] ?>">Xóa</a>
                                <a class="get_button" href="suasanpham.php?chinhsua=<?php echo $row_product['id'] ?>">Sửa</a>
                            </td>
                        </tr>
                <?php
                    }
                ?>

            </table>
        </div>

    </div>

    <body>

    </body>

</html>