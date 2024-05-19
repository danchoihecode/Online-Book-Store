<?php
    include_once('../assets/database/connect.php');
    session_start();
    if(!isset($_SESSION['login'])){
        header('Location: index.php');
    } 
    if(isset($_GET['login'])){
        $logout = $_GET['login'];
    } else{
        $logout = '';
    }
    if($logout == 'logout'){
        unset($_SESSION['login']);
        header('Location: index.php');
    }
?>

    <div id="header-admin">
        <ul id="nav"> 
            <li><a href="./quanlysanpham.php">Quản lý sản phẩm</a></li>
            <li><a href="./quanlydonhang.php">Quản lý đơn hàng</a></li>
            <li><a href="./quanlydanhmuc.php">Quản lý danh mục</a></li>
            <li><a href="./quanlykhachhang.php">Quản lý khách hàng</a></li>
        </ul>
        
        <div class="acc-logout">
            <h2><?php echo $_SESSION['login'] ?></h2>
            <a href="?login=logout">Đăng xuất</a>
        </div>
       
    </div>