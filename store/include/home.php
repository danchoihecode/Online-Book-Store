<!---------Main-->
<div id="category">
    <div class="category-left">
        <h1 class="category-title-text">Danh mục</h1>
        <ul class="category-list">
            <?php
            $sql_category = mysqli_query($con, 'SELECT * FROM category ORDER BY id ASC');
            while ($row_category = mysqli_fetch_array($sql_category)) {
            ?>
                <li>
                    <a href="index.php?quanly=danhmuc&id=<?php echo $row_category['id'] ?>&p=1">
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
                                <li><a href="index.php?quanly=danhmuccon&id=<?php echo $row_subCategory['id']?>&p=1">
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

    <div class="category-right">
        <div class="category-title">
            <?php
            $id_category = 0;
            $id_subcategory = 0;
            $quanly = "";
            $id = 0;
            if(isset($_GET['quanly']))    
            {
            $quanly = $_GET['quanly'];
            $id = $_GET['id'];
            }         
            if ($quanly == 'danhmuc') {
                $id_category  = $id;
                $sql="SELECT * FROM product WHERE subCategory_id IN (SELECT id FROM subcategory WHERE category_id=$id_category)";    
                $sql_category=mysqli_query($con,"SELECT name FROM category WHERE id=$id_category");
                $row_category=mysqli_fetch_array($sql_category);
                $list=$row_category['name'];             
            } else if ($quanly =="danhmuccon")
            {   $id_subcategory  = $id;
                $sql="SELECT * FROM product WHERE subCategory_id=$id_subcategory";
                $sql_subcategory=mysqli_query($con,"SELECT c.name category_name,s.name sub_name 
                FROM category c,subcategory s WHERE c.id=s.category_id AND s.id=$id_subcategory");
                $row_subcategory=mysqli_fetch_array($sql_subcategory);
                $list=$row_subcategory['category_name'] ." \ " . $row_subcategory['sub_name'];
            } else
            {
                $sql="SELECT * FROM product";
                $list="Tất cả danh mục";
            }                      
            ?>
            <h1 class="category-title-text"><?php echo $list ?></h1>
        </div>
        <div class="pagination">
        <?php
        $x=$_GET['p'];
        if ($x==1) $x++;
        if ($quanly =="")
        {
            ?>
            <a href="index.php?p=<?php echo $x - 1 ?>">&laquo;</a>
            <?php
        } else
        {
            ?>
            <a href="index.php?quanly=<?php echo $quanly ?>&id=<?php echo $id ?>&p=<?php echo $x - 1?>">&laquo;</a>
            <?php
        }
        $x=$_GET['p'];
        if ($x==6) $x--;
        for ($i=1;$i<=6;$i++)
        {
           if ($quanly !="")
           {
        ?>
           <a id="p<?php echo $i?>" href="index.php?quanly=<?php echo $quanly ?>&id=<?php echo $id ?>&p=<?php echo $i ?>"><?php echo $i ?></a>
        <?php
           } else
           {
        ?>
           <a id="p<?php echo $i?>" href="index.php?p=<?php echo $i ?>"><?php echo $i ?></a>
        <?php   
           }
        }
        if ($quanly =="")
        {
            ?>
            <a href="index.php?p=<?php echo $x + 1 ?>">&raquo;</a>
            <?php
        } else
        {
            ?>
            <a href="index.php?quanly=<?php echo $quanly ?>&id=<?php echo $id ?>&p=<?php echo $x + 1 ?>">&raquo;</a>
            <?php
        }
        $x=$_GET['p'];
        ?>
        <script>
            document.getElementById("p<?php echo$x?>").className="active";
        </script>
        </div>
        <div class="category-right-filter">
            <form action="" method="post">
                <input class="get_button" type="submit" name="top_seller" value="Bán chạy">
                <input class="get_button" type="submit" name="price_desc" value="Giá cao nhất">
                <input class="get_button" type="submit" name="price_asc" value="Giá thấp nhất">
            </form>
        </div>
        <div class="category-right-content">
            <?php
            $p=($_GET['p']-1)*8;
            if (isset($_POST['top_seller'])) {
                $sql  .=" ORDER BY sold DESC LIMIT $p,8 ";
            } else if (isset($_POST['price_desc'])) {
                $sql  .=" ORDER BY price_discount DESC LIMIT $p,8";
            } else if (isset($_POST['price_asc'])) {
                $sql .=" ORDER BY price_discount ASC LIMIT $p,8";
            } else {
                $sql .=" ORDER BY id DESC LIMIT $p,8";
            }
            $sql_product=mysqli_query($con,$sql);
            while ($row_product = mysqli_fetch_array($sql_product)) {              
            ?>
                    <div class="category-right-content-item">
                        <a href="product.php?id=<?php echo $row_product['id'] ?>">
                            <img src="<?php echo $row_product['image'] ?>" alt="">
                            <h1><?php echo $row_product['title'] ?></h1>
                        </a>
                        <p class="price_discount"><?php echo $row_product['price_discount'] ?><sup>đ</sup></p>
                        <p class="price_original"><?php echo $row_product['price_original'] ?><sup>đ</sup></p>
                        <p class="sold" >Đã bán <?php echo $row_product['sold'] ?></p>
                    </div>
            <?php
            }
            ?>
       
        </div>
       
    </div>
 
</div>