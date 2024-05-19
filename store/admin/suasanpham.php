<?php
include_once('../assets/database/connect.php');
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
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&family=Poppins:wght@400;500;600&display=swap');

        * {
            font-family: "Poppins", sans-serif;
        }

        body {
            background: linear-gradient(120deg, #2980b9, #8e44ad);
            height: 100vh;
            overflow: auto;
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
    <div class="sua-san-pham">
        <form action="./quanlysanpham.php" method="post">
            <?php
            if (isset($_GET['chinhsua'])) {
                $id = $_GET['chinhsua'];
                $sql_product = mysqli_query($con, "CALL getProInfor('$id')");
                mysqli_next_result($con);
                $row_product = mysqli_fetch_array($sql_product);
            ?>
                <label>Tên sản phẩm</label>
                <input type="text" name="title" value="<?php echo $row_product['title'] ?>" placeholder="Tên sản phẩm">
                <label>Danh mục</label>
                <select id="select-category" name="category">
                    <?php
                    $sql_select_category = mysqli_query($con, "SELECT * FROM category");
                    while ($row_select_category = mysqli_fetch_array($sql_select_category)) {
                    ?>
                        <option value="<?php echo $row_select_category['id'] ?>"
                        <?php if ($row_select_category['id'] == $row_product['category_id']) echo "selected" ?>>
                        <?php echo $row_select_category['name'] ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>

                <label>Danh mục con</label>
                <select class="select-subcategory" name="subcategory_id">
                    <?php
                    $sql_select_subcategory = mysqli_query($con, "SELECT * FROM subcategory");
                    while ($row_select_subcategory = mysqli_fetch_array($sql_select_subcategory)) {
                    ?>
                        <option value="<?php echo $row_select_subcategory['id'] ?>" 
                        <?php if ($row_select_subcategory['id'] == $row_product['subCategory_id']) echo "selected" ?>>
                        <?php echo $row_select_subcategory['name'] ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
                <label>Giá gốc</label>
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <input type="number" name="price_original" value="<?php echo $row_product['price_original'] ?>" placeholder="Giá gốc">
                <label>Giá khuyến mãi</label>
                <input type="number" name="price_discount" value="<?php echo $row_product['price_discount'] ?>" placeholder="Giá khuyến mãi">
                <label>Giới thiệu sản phẩm</label>
                <textarea name="infor" placeholder="Giới thiệu sản phẩm..." style="height:100px;width:100%"><?php echo $row_product['infor'] ?></textarea>
                <label>Tác giả</label>
                <input type="text" name="author" value="<?php echo $row_product['author'] ?>" placeholder="Tác giả">
                <label>NXB</label>
                <input type="text" name="publisher" value="<?php echo $row_product['publisher'] ?>" placeholder="NXB">
                <label>Số trang</label>
                <input type="number" name="print_length" value="<?php echo $row_product['print_length'] ?>" placeholder="Số trang">
                <label>Ảnh</label>
                <input type="file" name="image">
                <label>Số lượng trong kho</label>
                <input type="number" name="amount" value="<?php echo $row_product['amount'] ?>" placeholder="Số lượng trong kho">
                <label>Mô tả sản phẩm</label>
                <textarea name="description" placeholder="Mô tả sản phẩm..." style="height:100px;width:100%"><?php echo $row_product['description'] ?></textarea>
            <?php
            }
            ?>
            <input type="submit" name="submit_modify" value="Submit">
        </form>
    </div>
</body>

</html>