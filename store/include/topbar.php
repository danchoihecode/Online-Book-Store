<!---------Header-->
<div id="header">
<?php 
    if (isset($_POST['trigger_change'])){
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
        $phone = $_SESSION['phone'];
        $name = $pass = "";
        $name = $_POST['name2'];
        $_SESSION['valid_name'] = 1;
        $_SESSION['valid_pass'] = 1;
        $temp_name = $name;
        $temp_name = convert_name($temp_name);
        if (ctype_alpha(str_replace(' ', '', $temp_name)) === false)
        {
            if ($_SESSION['valid_name'] != 0){
                $name = "";
                $_SESSION['valid_name'] = 0;
            }
        }
        $pass = $_POST['pass2'];
        if (strlen($pass) < 6)
        {
          if ($_SESSION['valid_pass'] != 0){
            $pass = "";
            $_SESSION['valid_pass'] = 0;
          }
        }
        if ($_SESSION['valid_name'] == 1 && $_SESSION['valid_pass'] == 1)
        {
            $php1 = "UPDATE customer SET email = '$_POST[email2]' WHERE phone = '$phone'";
            $php2 = "UPDATE customer SET name = '$_POST[name2]' WHERE phone = '$phone'";
            $php5 = "UPDATE customer SET password = '$_POST[pass2]' WHERE phone = '$phone'";
            $php4 = "UPDATE customer SET address = '$_POST[address2]' WHERE phone = '$phone'";
            $php3 = mysqli_query($con, $php1);
            $php3 = mysqli_query($con, $php2);
            $php5 = mysqli_query($con, $php5);
            $php3 = mysqli_query($con, $php4);
            $php1 = "SELECT email FROM customer WHERE phone = '$_SESSION[phone]'";
            $php1 = mysqli_fetch_assoc(mysqli_query($con, $php1));
            $_SESSION['email'] = $php1['email'];
            $_SESSION['log'] = $_POST['name2'];
            $_SESSION['password'] = $_POST['pass2'];
            $_SESSION['location'] = $_POST['address2'];
            header("Location: profile.php");
        } else; #header("Location: changeinfo.php");
    };
    ?>
        <ul id="nav">
            <li>
                <a href="index.php?p=1">Trang chủ</a>
            </li>
            <?php
                $sql_category = mysqli_query($con, 'SELECT * FROM category ORDER BY id ASC'); 
                while($row_category = mysqli_fetch_array($sql_category))
            {
            ?>  
            <li>
                <a href="index.php?quanly=danhmuc&id=<?php echo $row_category['id'] ?>&p=1">
                    <?php echo $row_category['name'] ?>
                    <i class="down-btn ti-angle-down"></i>
                </a>
                <ul class="subnav">
                            <?php
                            $sqlsubCategory = mysqli_query($con, 'SELECT * FROM subCategory ORDER BY id ASC'); 
                            while($row_subCategory = mysqli_fetch_array($sqlsubCategory))
                            {
                                if ($row_subCategory['category_id'] == $row_category['id'])
                                 {
                            ?>
                            <li><a href="index.php?quanly=danhmuccon&id=<?php echo $row_subCategory['id'] ?>&p=1">
                                <?php echo $row_subCategory['name']; ?>
                            </a></li>
                            <?php
                                 }
                            ?>
                            <?php
                            }
                            ?>
                </ul>
            </li>
            <?php
            }
            ?>
        </ul>
        <div class="search-btn">
            <a style="display:block;text-decoration:none" href="./cart.php"><i class="search-icon ti-shopping-cart"></i></a>
        </div>
        <?php
        if (!isset($_SESSION['phone']))
        {
        ?>
        <ul id="nav" style="display:block;float:right;">
        <li><a href="register.php">Đăng ký</a></li>
        </ul>
        <ul id="nav" style="display:block;float:right;">
        <li><a href="login.php">Đăng nhập</a></li>
        </ul>
        <?php      
        } else
        {
        ?>
        <ul id="nav" style="display:block;float:right;">
        <li><a href="index.php?log=logout">Đăng xuất</a></li>
        </ul>
        <ul id="nav" style="display:block;float:right;">
        <li><a href="profile.php">
            <?php
                $short_name = explode(' ', $_SESSION['log']);#
                $result = array_pop($short_name);#
                echo $result;#
            ?>
        </a></li>
        </ul>
        <?php   
        }
        ?>         
    </div>