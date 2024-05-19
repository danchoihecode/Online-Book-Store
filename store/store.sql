-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2023 at 10:59 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addProduct` (IN `sub` INT(11), IN `title` VARCHAR(100), IN `origin` INT(11), IN `discount` INT(11), IN `info` VARCHAR(1000), IN `author` VARCHAR(100), IN `publisher` VARCHAR(100), IN `length` INT(11), IN `image` VARCHAR(200), IN `amount` INT(11), IN `des` VARCHAR(1000))   BEGIN
INSERT INTO product (subcategory_id, title, price_original, price_discount, infor, author,
publisher, print_length, image, amount, description) VALUES (sub,title,origin,discount,info,author,publisher,
length,image,amount,des);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getOrder` (IN `odc` INT(11))   BEGIN
    SELECT code,product_id,image,title,price_discount,p.amount invent,od.amount amount,price_discount * od.amount purchase 
    FROM order_detail od,product p WHERE product_id=id AND code=odc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getProbyCategory` (`ctg_id` INT(11))   BEGIN
select * from product where subCategory_id IN (SELECT id FROM subcategory WHERE category_id=ctg_id) ORDER BY id DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getProbySub` (`sub_id` INT(11))   BEGIN
select * from product where subCategory_id=sub_id ORDER BY id DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getProInfor` (`id` INT(11))   BEGIN
SELECT * FROM product p,subcategory s WHERE p.subCategory_id=s.id AND p.id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getSub` (IN `id` INT(11))   BEGIN
select * from subcategory where category_id=id ORDER BY id DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateProduct` (`code` INT(11), `sub` INT(11), `tl` VARCHAR(100), `origin` INT(11), `dis` INT(11), `inf` VARCHAR(1000), `aut` VARCHAR(100), `pub` VARCHAR(100), `length` INT(11), `img` VARCHAR(200), `amt` INT(11), `des` VARCHAR(1000))   BEGIN
UPDATE product 
SET subcategory_id =sub,title = tl, price_original =origin, 
price_discount = dis, infor =inf, author = aut, publisher =pub, 
print_length = length, image =img, amount =amt, description =des 
WHERE id = code;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `account` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_name`, `account`, `password`) VALUES
(1, 'Hải', 'admin', 'ad');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Luyện thi THPTQG'),
(2, 'Tham khảo'),
(3, 'SGK'),
(4, 'Kĩ năng bổ trợ'),
(6, 'Ngoại ngữ'),
(7, 'Danh mục khác');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `phone` varchar(15) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`phone`, `name`, `email`, `address`, `password`) VALUES
('0345678910', 'Nguyễn Hoàng Minh', 'anh@gmail.com', 'Liên Bảo, Vĩnh Yên', '123456'),
('0866172604', 'Dương Hoàng Hải', 'hoanghai2003vp@gmail.com', 'Phương Liệt - Thanh Xuân - Hà Nội', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `code` int(11) NOT NULL,
  `acc_phone` varchar(15) NOT NULL,
  `date` datetime DEFAULT NULL,
  `status` int(11) DEFAULT 2,
  `total_purchase` int(11) DEFAULT 0,
  `phone` varchar(15) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `delivery` int(11) DEFAULT NULL,
  `note` varchar(300) DEFAULT NULL,
  `quantity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`code`, `acc_phone`, `date`, `status`, `total_purchase`, `phone`, `name`, `email`, `address`, `delivery`, `note`, `quantity`) VALUES
(58, '0345678910', '2023-02-23 19:45:04', 1, 615000, '0314121412', 'Nguyễn Vân Hương', 'an@gmail.com', 'Thanh Xuân,Hà Nội', 0, 'ok lắm ạ', 6),
(66, '0866172604', '2023-02-25 16:54:28', 1, 225000, '0123456789', 'Lê Minh Việt Anh', 'hoanghai2003vp@gmail.com', 'Vĩnh Yên', 0, 'giao sớm nhé ạ', 3);

--
-- Triggers `orders`
--
DELIMITER $$
CREATE TRIGGER `after_update_orders` AFTER UPDATE ON `orders` FOR EACH ROW BEGIN
IF (OLD.status = 2 AND NEW.status = 0)
THEN 
UPDATE product
SET amount=amount-(SELECT amount FROM order_detail WHERE code=NEW.code AND product_id=id),sold=sold+(SELECT amount FROM order_detail WHERE code=NEW.code AND product_id=id)
WHERE id IN (SELECT product_id FROM order_detail WHERE code=NEW.code);   END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `code` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `amount` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`code`, `product_id`, `amount`) VALUES
(58, 19, 3),
(58, 24, 3),
(66, 24, 3);

--
-- Triggers `order_detail`
--
DELIMITER $$
CREATE TRIGGER `after_delete_order_detail` AFTER DELETE ON `order_detail` FOR EACH ROW BEGIN
IF (SELECT COUNT(*) FROM order_detail where code=OLD.code) > 0
THEN
UPDATE orders
SET quantity =(SELECT SUM(amount) FROM order_detail WHERE code = OLD.code),total_purchase=(SELECT SUM(p.purchase) FROM (SELECT code,price_discount * order_detail.amount AS purchase FROM order_detail,product WHERE product_id=id) AS p WHERE code=OLD.code)
WHERE code=OLD.code;
ELSE
UPDATE orders
SET quantity=0,total_purchase=0
WHERE code=OLD.code;
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_order_detail` AFTER INSERT ON `order_detail` FOR EACH ROW BEGIN
UPDATE orders
SET quantity =(SELECT SUM(amount) FROM order_detail WHERE code = NEW.code),total_purchase=(SELECT SUM(p.purchase) FROM (SELECT code,price_discount * order_detail.amount AS purchase FROM order_detail,product WHERE product_id=id) AS p WHERE code=NEW.code)
WHERE code=NEW.code;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_order_detail` AFTER UPDATE ON `order_detail` FOR EACH ROW BEGIN
UPDATE orders
SET quantity =(SELECT SUM(amount) FROM order_detail WHERE code = NEW.code),total_purchase=(SELECT SUM(p.purchase) FROM (SELECT code,price_discount * order_detail.amount AS purchase FROM order_detail,product WHERE product_id=id) AS p WHERE code=NEW.code)
WHERE code=NEW.code;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `subCategory_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `price_original` int(11) NOT NULL,
  `price_discount` int(11) NOT NULL,
  `infor` varchar(1000) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `publisher` varchar(100) DEFAULT NULL,
  `print_length` int(11) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `sold` int(11) DEFAULT 0,
  `description` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `subCategory_id`, `title`, `price_original`, `price_discount`, `infor`, `author`, `publisher`, `print_length`, `image`, `amount`, `sold`, `description`) VALUES
(1, 13, 'Đắc nhân tâm', 86000, 75000, 'Đắc Nhân Tâm - Là cuốn sách bán chạy nhất từ trước đến nay. Quyển sách đưa ra các lời khuyên về cách thức cư xử, ứng xử và giao tiếp với mọi người để đạt được thành công trong cuộc sống.', 'Dale Carnegie', 'Tổng hợp thành phố Hồ Chí Minh', 320, './assets/img/sach-dac-nhan-tam.jpg', 200, 677, ''),
(2, 2, 'Chuỗi phản ứng hóa học', 38000, 30000, '', 'Ngô Ngọc An', 'Đại Học Quốc Gia Hà Nội', 213, './assets/img/giup-tri-nho-chuoi-phan-ung-hoa-hoc.jpg', 62, 682, ''),
(3, 5, 'Từ vựng tiếng anh', 95000, 76000, 'Cuốn sách Câu Hỏi Trắc Nghiệm Chuyên Đề Từ Vựng Tiếng Anh mang đến cho các bạn học sinh những kiến thức cần thiết cho việc ôn luyện Tiếng Anh.', 'Vĩnh Bá', 'Đại Học Quốc Gia Hà Nội', 322, './assets/img/cauhoitracnghiemchuyendetuvungtienganh1.jpg', 67, 620, ''),
(8, 13, 'Tuổi Trẻ Đáng Giá Bao Nhiêu', 70000, 56000, 'Tuổi Trẻ Đáng Giá Bao Nhiêu', 'Rosie Nguyễn', 'Nhà xuất bản Hội Nhà văn', 285, './assets/img/tuoi-tre-dang-gia-bao-nhieu.png', 668, 8, '\"Bạn hối tiếc vì không nắm bắt lấy một cơ hội nào đó, chẳng có ai phải mất ngủ.\r\n\r\nBạn trải qua những ngày tháng nhạt nhẽo với công việc bạn căm ghét, người ta chẳng hề bận lòng.\r\n\r\nBạn có chết mòn nơi xó tường với những ước mơ dang dở, đó không phải là việc của họ.\r\n\r\nSuy cho cùng, quyết định là ở bạn. Muốn có điều gì hay không là tùy bạn.\r\n\r\nNên hãy làm những điều bạn thích. Hãy đi theo tiếng nói trái tim. Hãy sống theo cách bạn cho là mình nên sống.\r\n\r\nVì sau tất cả, chẳng ai quan tâm.\"\r\n\r\nNhận định\r\n\r\n\"Tôi đã đọc quyển sách này một cách thích thú. Có nhiều kiến thức và kinh nghiệm hữu ích, những điều mới mẻ ngay cả với người gần trung niên như tôi.\r\n\r\nTuổi trẻ đáng giá bao nhiêu? được tác giả chia làm 3 phần: HỌC, LÀM, ĐI.\r\n\r\nNhưng tôi thấy cuốn sách còn thể hiện một phần thứ tư nữa, đó là ĐỌC.\r\n\r\nHãy đọc sách, nếu bạn đọc sách một cách bền bỉ, sẽ đến lúc bạn bị thôi thúc không ngừng bởi ý muốn viết nên cuốn sách của riêng mình.\r\n\r\nNếu tôi còn ở tuổi đôi mươi, hẳn là tôi sẽ đọc Tuổ'),
(10, 39, 'Giáo Trình Triết Học Mác – Lênin', 89000, 80000, '(Dành Cho Bậc Đại Học Hệ Không Chuyên Lý Luận Chính Trị) - Bộ mới năm 2021', 'Bộ Giáo Dục Và Đào Tạo', 'Nhà Xuất Bản Chính Trị Quốc Gia Sự Thật', 496, './assets/img/0c3a491b7e23820a5907adef10ef8033-removebg-preview.png', 91, 14, 'Giáo trình do Ban biên soạn gồm các tác giả là nhà nghiên cứu, nhà giáo dục thuộc Viện Triết học - Học viện Chính trị quốc gia Hồ Chí Minh, các học viện, trường đại học, Viện Triết học - Viện Hàn lâm Khoa học xã hội Việt Nam, tổ chức biên soạn trên cơ sở kế thừa những kết quả nghiên cứu trước đây, đồng thời bổ sung nhiều nội dung, kiến thức, kết quả nghiên cứu mới, gắn với công cuộc đổi mới ở Việt Nam, nhất là những thành tựu trong 35 năm đổi mới đất nước.\r\n\r\nGiáo trình gồm 03 chương:\r\n\r\nChương 1 trình bày những nét khái quát nhất về triết học, triết học Mác - Lênin và vai trò của triết học Mác - Lênin trong đời sống xã hội.\r\nChương 2 trình bày những nội dung cơ bản của chủ nghĩa duy vật biện chứng, gồm: vấn đề vật chất và ý thức; phép biện chứng duy vật; lý luận nhận thức của chủ nghĩa duy vật biện chứng.\r\nChương 3 trình bày những nội dung cơ bản của chủ nghĩa duy vật lịch sử, gồm: vấn đề hình thái kinh tế - xã hội; giai cấp và dân tộc; nhà nước và cách mạng xã hội; ý thức xã hội; tri'),
(11, 36, 'Bài tập Hóa học lớp 10', 24000, 20000, 'Bộ sách Cánh Diều', 'Bộ Giáo Dục Và Đào Tạo', 'Nhà Xuất Bản Đại Học Sư Phạm', 252, './assets/img/6a08021a7be448fdfe87836e8acb2f2e.png', 660, 13, 'Sách Bài tập Hóa học lớp 10 shop bán thuộc bộ sách giáo khoa Cánh Diều. Bộ sách Giáo khoa Cánh Diều lớp 10 được phê duyệt theo quyết định số 442/QĐ-BGDĐT ngày 28 tháng 01 năm 2022 của Bộ trưởng Bộ Giáo dục và Đào tạo. Bộ sách  được nhiều cở sở Giáo dục trên cả nước lựa chọn để giảng dạy từ năm học 2022-2023.'),
(12, 10, 'GIÁO TRÌNH DẠY VIẾT TIẾNG ANH TOÀN TẬP', 125000, 100000, '\"Giáo Trình Dạy Viết Tiếng Anh Toàn Tập\" được biên soạn dành cho những học sinh, sinh viên mong muốn nâng cao các kĩ năng viết tiếng anh để có thể viết các bài luận ,những người đang công tác tại cá doanh nghiệp , các văn phòng công ty muốn cải thiện kỹ năng viết báo cáo và chuyên đề thuyết trình', 'Diễm Ly, Hoàng Thanh', 'Đại Học Quốc Gia Hà Nội', 432, './assets/img/giao-trinh-day-viet-tieng-anh-toan-tap-bia-truoc-1.gif', 89, 11, 'Quyển sách\"Giáo Trình Dạy Viết Tiếng Anh Toàn Tập\" được biên soạn dành cho những học sinh, sinh viên mong muốn nâng cao các kĩ năng viết tiếng anh để có thể viết các bài luận và đạt điểm cao tại các trường đại học,cao đẳng. Đặc biệt, sách cũng dành cho những người đang công tác tại cá doanh nghiệp , các văn phòng công ty muốn cải thiện kỹ năng viết báo cáo và chuyên đề thuyết trình sao cho thật thu hút và có sức thuyết phục trước ban lãnh đạo lẫn đồng nghiệp , góp phần thắng tiến nhanh chống trong nghề nghiệp của mình.\r\n\r\nSách gồm 6 phần , hướng dẫn qui trình viết tiếng Anh ngay từ những bước khởi đầu như chuẩn bị đề tài, xem xét đối tượng nào sẽ đọc bài viết và mục đích cuối cùng ma bạn muốn bài viết của bạn đạt đươc là gì đề từ đó giới hạn phạm vi đề tài và triển khai các ý cho phù hợp, Sau đó bạn đọc sẽ học qua các phương pháp đề phát triển đoạn văn thường được yêu càu viết ở trường , bao gồm minh họa, tường thuật , miêu tả , định nghĩa, so sánh, đối chiếu, phân loại , nguyên nhân v'),
(13, 39, 'Giáo Trình Kinh Tế Chính Trị Mác - Lênin', 80000, 63000, 'Dành Cho Bậc Đại Học Hệ Không Chuyên Lý Luận Chính Trị', 'Bộ Giáo Dục Và Đào Tạo', 'Nhà Xuất Bản Chính Trị Quốc Gia Sự Thật', 292, './assets/img/8935279135226_1.png', 40, 10, ''),
(15, 39, 'Giáo Trình Lịch Sử Đảng Cộng Sản Việt Nam', 90000, 86000, 'Dành Cho Bậc Đại Học Hệ Không Chuyên Lý Luận Chính Trị', 'Bộ Giáo Dục Và Đào Tạo', 'Nhà Xuất Bản Chính Trị Quốc Gia Sự Thật', 440, './assets/img/8935279135240.png', 38, 12, ''),
(16, 40, 'Vật Lý 12', 19000, 15000, 'Sách giáo khoa Vật Lý 12 chương trình chuẩn', 'Bộ Giáo Dục Và Đào Tạo', 'NXB Giáo Dục Việt Nam', 232, './assets/img/9786040286482_1_1.jpg', 139, 26, ''),
(17, 41, 'Kỹ năng bán hàng tuyệt đỉnh', 99000, 68000, 'Kỹ năng bán hàng tuyệt đỉnh sẽ cho bạn đọc biết được những quy tắc bán hàng, vốn là điều kiện tiên quyết để gặt hái thành công trong bất kỳ lĩnh vực nào, với bất kỳ ai, bất kỳ ở đâu.', 'Grant Cardone', 'Thế Giới', 296, './assets/img/item2.jpg', 57, 43, ''),
(18, 13, 'Khéo Ăn Nói Sẽ Có Được Thiên Hạ', 1300000, 86000, '', 'Trác Nhã', 'Văn Học', 404, './assets/img/item7.jpg', 194, 6, 'Trong xã hội thông tin hiện đại, sự im lặng không còn là vàng nữa, nếu không biết cách giao tiếp thì dù là vàng cũng sẽ bị chôn vùi. Trong cuộc đời một con người, từ xin việc đến thăng tiến, từ tình yêu đến hôn nhân, từ tiếp thị cho đến đàm phán, từ xã giao đến làm việc… không thể không cần đến kĩ năng và khả năng giao tiếp. Khéo ăn khéo nói thì đi đâu, làm gì cũng gặp thuận lợi. Không khéo ăn nói, bốn bề đều là trở ngại khó khăn.\r\n\r\nĐã bao giờ đánh mất một công việc, bạn bỏ lỡ một mối quan hệ tuyệt vời, hay đơn giản là bạn cảm thấy khó nói chuyện với mọi người. Bạn có bao giờ nghĩ là do kĩ năng nói chuyện của mình chưa tốt, chưa thuyết phục được mọi người. Bạn đổ lỗi cho số phận và vận may của mình chưa đến. Hãy dừng việc than thân trách phận và hành động để thay đòi chính mình.\r\n\r\nVậy làm thế nào để cải thiện và tránh gặp phải những tình huống như trên? Làm thế nào để ăn nói khéo léo? Có phương pháp và quy luật nào được áp dụng khi giao tiếp không? Có nguyên tắc và bí quyết nào cho c'),
(19, 13, 'Hành Động - Hành Trình Tạo Nên Những Thay Đổi Tích Cực', 150000, 130000, 'Hành trình tạo nên những thay đổi tích cực\r\n\r\nNếu thay đổi là điều khả dĩ, vậy tại sao chúng ta lại không cố gắng làm nhiều thứ hơn để có thể thay đổi cả thế giới?', 'John C Maxwell, Rob Hoskins', 'Thế Giới', 280, './assets/img/item1.jpg', 142, 8, ''),
(20, 13, 'Trí Tuệ Do Thái', 150000, 120000, 'Trí tuệ Do Thái là một cuốn sách tư duy đầy tham vọng trong việc nâng cao khả năng tự học tập, ghi nhớ và phân tích - những điều đã khiến người Do Thái vượt trội lên, chiếm lĩnh những vị trí quan trọng trong ngành truyền thông, ngân hàng và những giải thưởng sáng tạo trên thế giới.', 'Eran Katz', 'Công Thương', 438, './assets/img/trituedothai.png', 0, 5, ''),
(21, 13, 'Dám Dũng Cảm - 13 Nguyên Tắc Sống Can Đảm Mỗi Ngày', 130000, 115000, '', 'Franziska Iseli', 'Thế Giới', 320, './assets/img/item4.jpg', 117, 6, 'Một cuộc sống vô vị và ngập tràn luyến tiếc không phải do sự an bài của số phận, mà do bạn chưa đủ can đảm để sống một cuộc đời tuyệt đẹp mà thôi. Bạn không thể cứ đứng yên trong “vòng an toàn” của bản thân và mong cầu một cuộc đời tự do, hạnh phúc sẽ đến.'),
(22, 42, 'Tâm Lý Học Giải Mã Tình Yêu', 100000, 90000, '', 'Logan Ury', 'Thế Giới', 216, './assets/img/item5.jpg', 40, 10, 'Tâm lý học giải mã tình yêu được đúc kết từ kinh nghiệm nghiên cứu cùng quan sát hành vi trong nhiều năm của nhà khoa học Logan Ury sẽ tiết lộ những yếu tố gây ra các quyết định sai lầm của bạn và hướng dẫn bạn thay đổi hành vi của mình để tìm kiếm “tình yêu đích thực”.'),
(23, 13, 'Chinh Phục Mục Tiêu', 105000, 100000, 'Chinh phục mục tiêu - 21 chiến lược giúp bạn chạm tay tới ước mơ', 'Brian Tracy', 'Tổng Hợp TPHCM', 328, './assets/img/item3.jpg', 35, 10, 'Trong \"Chinh phục mục tiêu\", Brian Tracy tập hợp tất cả mọi kinh nghiệm, ý tưởng và chiến lược hiện thực hoá mục tiêu thành một hệ thống bài bản. Tác giả trình bày 21 ý tưởng đột phá, mà chỉ cần biết đến chúng thôi sẽ giúp con đường đến thành công của bạn ít trắc trở hơn rất nhiều. Chẳng hạn như: Lên kế hoạch, đo lường tiến bộ của bản thân, kết giao với những người phù hợp hay luôn luôn linh hoạt.\r\n\r\nSau cùng, Brian Tracy nhận định: \"Phẩm chất quan trọng mà bạn có thể phát triển để thành công trong đời chính là thói quen hành động dựa trên những kế hoạch, mục tiêu, ý tưởng và kiến thức sâu rộng. Bạn càng thường xuyên nỗ lực, bạn càng nhanh chóng chiến thắng. Có sự liên hệ trực tiếp giữa số việc mà bạn nỗ lực và những thành tựu bạn đạt được trong đời\".\r\n\r\n\"Chinh phục mục tiêu\" là cẩm nang hướng dẫn cách xác lập và hoàn thành mục tiêu, đạt được thành công và sống một cuộc đời tuyệt vời.\r\n\r\nBáo chí về \"Chinh phục mục tiêu\" và Brian Tracy: \r\n\r\n\"Brian Tracy là một cái tên gắn liền với việ'),
(24, 45, 'Món Ăn Được Nhiều Người Ưa Thích', 100000, 75000, 'Ăn uống là một phần thiết yếu trong cuộc sống của con người. Tuỳ theo khẩu vị của mỗi người hay mỗi gia đình mà món ăn có sự thay đổi về gia vị, cách chế biến. Nấu một món ăn dễ nhưng cũng khó. Dễ là chỉ việc theo một công thức có sẵn hay ngẫu hứng làm theo ý của mình, rồi nấu chín và ... thưởng thức; nhưng đôi khi lại khó vì mỗi người một khẩu vị và chiều theo ý thích của tất cả mọi người không phải chuyện đơn giản.', 'Nguyễn Dzoãn Cẩm Vân', 'NXB Hồng Đức', 239, './assets/img/873a268e022781e848d2f40fa8c21358.jpg', 4, 31, 'Cuốn sách này xin gửi đến các bà nội trợ những món ăn tương đối dễ làm, gia vị hay các loại thực phẩm chế biến cũng dễ tìm và khẩu vị chắc cũng không đến nỗi kén lắm.\r\n\r\nHy vọng các bạn sẽ thực hiện thật nhanh và sẽ có những món ăn mới, ngon cho cả nhà hay bạn bè cùng thưởng thức.');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`id`, `category_id`, `name`) VALUES
(1, 1, 'Vật lý'),
(2, 1, 'Hóa học'),
(3, 1, 'Sinh học'),
(4, 1, 'Toán'),
(5, 1, 'Anh Văn'),
(9, 2, 'Lớp 12'),
(10, 6, 'Tiếng anh'),
(11, 6, 'Tiếng Hàn'),
(12, 6, 'Tiếng Trung'),
(13, 4, 'Kĩ năng sống'),
(22, 2, 'Lớp 11'),
(32, 1, 'Địa lý'),
(36, 2, 'Lớp 10'),
(37, 2, 'Lớp 9'),
(39, 2, 'Đại học'),
(40, 3, 'Cấp 3'),
(41, 4, 'Kinh doanh'),
(42, 7, 'Tình yêu '),
(44, 7, 'Sức khỏe'),
(45, 7, 'Ẩm thực');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`phone`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`code`),
  ADD KEY `acc_phone` (`acc_phone`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`code`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product` (`subCategory_id`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sadsa` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`acc_phone`) REFERENCES `customer` (`phone`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`acc_phone`) REFERENCES `customer` (`phone`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`code`) REFERENCES `orders` (`code`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`subCategory_id`) REFERENCES `subcategory` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `subcategory_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
