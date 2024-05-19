<?php    
    include_once('./assets/database/connect.php');
    session_start();
    if (isset($_GET['log']))
    {
        unset($_SESSION['phone']);
        unset($_SESSION['log']);
        header('Location: index.php?p=1');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/fonts/themify-icons/themify-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>

</head>
<body>

    <?php
    include_once('./include/topbar.php');
    include_once('./include/slider.php');
    include_once('./include/home.php');
    include_once('./include/footer.php');
    ?>
</body>
</html>