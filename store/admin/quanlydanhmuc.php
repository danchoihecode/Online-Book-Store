<?php
include_once('../assets/database/connect.php');
?>

<?php
if (isset($_GET['xoa'])) {
    $id = $_GET['xoa'];
    mysqli_query($con, "DELETE FROM category WHERE id = '$id'");
}
if (isset($_POST['themdanhmuc'])) {
    $name = $_POST['danh-muc'];
    mysqli_query($con, "INSERT INTO category (name) values ('$name')");
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
        input[type="submit"] {
            width: 100%;
            border: 1px solid;
            background: #4caf50;
            border-radius: 25px;
            font-size: 16px;
            color: #e9f4fb;
            font-weight: 600;
            padding: 10px;
            cursor: pointer;
            text-align: center;
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
    <div class="danh-muc-left">
        <div class="add-category">
            <h2>Thêm danh mục</h2>
            <form action="#" method="post">
                <input type="text" name="danh-muc" placeholder="Tên danh mục">
                <input id="update_button" style="margin-top:10px;" type="submit" name="themdanhmuc" value="Thêm danh mục">
            </form>
        </div>
    </div>
    <div class="danh-muc-right">
        <table class="admin-table">
            <tr class="row1">
                <th style="width:5%">STT</th>
                <th style="width:40%">Tên danh mục</th>
                <th>Thao tác</th>
            </tr>
            <?php
            $count = 0;
            $sql_category = mysqli_query($con, 'SELECT * FROM category ORDER BY id ASC');
            while ($row_category = mysqli_fetch_array($sql_category)) {
                $count++;
            ?>
                <tr>
                    <td><?php echo $count ?></td>
                    <td><?php echo $row_category['name'] ?></td>
                    <td><a class="get_button" href="?xoa=<?php echo $row_category['id'] ?>">Xóa</a>
                        <a class="get_button" href="?capnhat=<?php echo $row_category['id'] ?>">Cập nhật danh mục</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
    <?php
    if (isset($_GET['capnhat'])) {
    ?>
        <div class="danh-muc-con">

            <table class="admin-table">
                <tr class="row1">
                    <th style="width:5%">STT</th>
                    <th style="width:50%">Tên danh mục con</th>
                    <th>Thao tác</th>
                </tr>
                <?php
                $id_category = 0;
                if (isset($_GET['capnhat'])) {
                    $id_category = $_GET['capnhat'];
                }
                if (isset($_GET['xoasub'])) {
                    $id = $_GET['xoasub'];
                    mysqli_query($con, "DELETE FROM subcategory WHERE id = '$id'");
                }
                if (isset($_POST['themdanhmuccon'])) {
                    $name = $_POST['danh-muc-con'];
                    mysqli_query($con, "INSERT INTO subcategory (category_id, name) values ('$id_category', '$name')");
                }
                $sql_subcategory = mysqli_query($con, "CALL getSub('$id_category')");
                mysqli_next_result($con);
                $count2 = 0;
                while ($row_subcategory = mysqli_fetch_array($sql_subcategory)) {
                    $count2++;
                ?>
                    <tr>
                        <td><?php echo $count2 ?></td>
                        <td><?php echo $row_subcategory['name'] ?></td>
                        <td><a class="get_button" href="?capnhat=<?php echo $id_category ?>&xoasub=<?php echo $row_subcategory['id'] ?>">Xóa</a> </td>
                    </tr>
                <?php
                }
                ?>

            </table>

            <div class="add-category">
                <h2>Thêm danh mục con</h2>
                <form action="#" method="post">
                    <input type="text" name="danh-muc-con" placeholder="Tên danh mục con">
                    <input style="height:40%;margin-top:10px;" id="delivery_button"  type="submit" name="themdanhmuccon" value="Thêm danh mục con">
                </form>
            </div>
        </div>
    <?php
    }
    ?>
</body>

</html>