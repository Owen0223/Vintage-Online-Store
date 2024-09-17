-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2024 at 11:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grpassign`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartId` int(11) NOT NULL,
  `cartProductQuantity` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `productId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartId`, `cartProductQuantity`, `userId`, `productId`) VALUES
(1, 2, 1, 1),
(2, 1, 1, 2),
(3, 3, 2, 3),
(7, 2, NULL, 1),
(8, 1, NULL, 2),
(10, 2, NULL, 1),
(11, 1, NULL, 2),
(16, 0, 5, 1),
(17, 6, 5, 16),
(19, 2, 6, 16);

-- --------------------------------------------------------

--
-- Table structure for table `favourite`
--

CREATE TABLE `favourite` (
  `userId` int(11) DEFAULT NULL,
  `productId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentId` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `paymentDate` date DEFAULT NULL,
  `paymentMethod` varchar(50) DEFAULT NULL,
  `paymentAddress` varchar(255) NOT NULL,
  `productId` int(11) DEFAULT NULL,
  `paymentProductQuantity` int(11) NOT NULL,
  `paymentChoices` varchar(20) NOT NULL,
  `paymentProductCus` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`paymentId`, `userId`, `paymentDate`, `paymentMethod`, `paymentAddress`, `productId`, `paymentProductQuantity`, `paymentChoices`, `paymentProductCus`) VALUES
(1, 1, '2024-04-22', 'TouchnGo', '111, JALAN INDAH 1/24', 1, 2, 'Shipping', 'Birthday'),
(1, 1, '2024-04-22', 'TouchnGo', '111, JALAN INDAH 1/24', 2, 1, 'Shipping', 'Birthday'),
(2, 1, '2024-04-22', 'TouchnGo', '111, JALAN INDAH 1/24', 1, 2, 'Shipping', 'Birthday'),
(2, 1, '2024-04-22', 'TouchnGo', '111, JALAN INDAH 1/24', 2, 1, 'Shipping', 'Birthday'),
(3, 1, '2024-04-22', 'Card', '111, JALAN INDAH 1/24', 1, 2, 'Shipping', 'Normal'),
(3, 1, '2024-04-22', 'Card', '111, JALAN INDAH 1/24', 2, 1, 'Shipping', 'Normal'),
(4, 1, '2024-04-22', 'TouchnGo', 'iloveu', 1, 2, 'Shipping', 'Birthday'),
(4, 1, '2024-04-22', 'TouchnGo', 'iloveu', 2, 1, 'Shipping', 'Birthday'),
(5, 3, '2024-04-23', 'TouchnGo', '111, JALAN INDAH 1/24', 56, 3, 'Shipping', 'Normal'),
(6, 5, '2024-04-23', 'TouchnGo', '111, JALAN INDAH 1/24', 1, 0, 'Shipping', 'Wedding Aniversary'),
(6, 5, '2024-04-23', 'TouchnGo', '111, JALAN INDAH 1/24', 16, 6, 'Shipping', 'Wedding Aniversary'),
(7, 3, '2024-04-26', 'TouchnGo', 'iloveu', 22, 0, 'Shipping', 'Birthday'),
(7, 3, '2024-04-26', 'TouchnGo', 'iloveu', 59, 0, 'Shipping', 'Birthday'),
(7, 3, '2024-04-26', 'TouchnGo', 'iloveu', 16, 2, 'Shipping', 'Birthday');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productId` int(11) NOT NULL,
  `productName` varchar(100) DEFAULT NULL,
  `productImgUrl` varchar(255) DEFAULT NULL,
  `productPrice` decimal(10,2) DEFAULT NULL,
  `productDesc` text DEFAULT NULL,
  `productCategory` varchar(50) DEFAULT NULL,
  `productVisit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productId`, `productName`, `productImgUrl`, `productPrice`, `productDesc`, `productCategory`, `productVisit`) VALUES
(1, 'Raw Emerald and Diamond Halo Engagement Ring for Women', '1.jpg', 4500.00, 'A stunning engagement ring featuring a raw emerald surrounded by a halo of dazzling diamonds. Crafted to perfection, this ring is designed to symbolize love and commitment.', 'Wearable Items', 96),
(2, 'Emerald Tennis Bracelet in 14K Yellow Gold', '2.jpg', 3200.00, 'Elevate your style with this exquisite emerald tennis bracelet. Crafted in 14K yellow gold, it features a continuous row of vibrant emeralds, making it a timeless and elegant accessory.', 'Wearable Items', 71),
(3, '19th Century Vintage Pocket Watch', '3.jpg', 1800.00, 'A piece of history, this 19th-century vintage pocket watch is a true collector\'s item. With intricate detailing and a classic design, it\'s a beautiful addition to any collection.', 'Wearable Items', 93),
(4, 'Antique Chinese Jeweled Kingfisher Feather Hairpin', '4.jpg', 2500.00, 'This antique Chinese hairpin adorned with kingfisher feathers and jewels is a rare find. A stunning piece of traditional Chinese craftsmanship, perfect for collectors or as a statement accessory.', 'Wearable Items', 54),
(5, 'Vintage Ancient Princess Hairband Women Headband Chinese Qing Dynasty', '5.jpg', 1200.00, 'Transport yourself to the Qing Dynasty with this vintage ancient princess hairband. A beautiful and authentic piece of Chinese history, perfect for costume parties or display.', 'Wearable Items', 94),
(6, 'Vintage Hmong Miao Tribal Ceremonial Torque Etched Necklace China', '6.jpeg', 1600.00, 'This vintage Hmong Miao tribal ceremonial torque necklace is a beautiful representation of traditional Chinese jewelry. The intricate etched design and historical significance make it a valuable addition to any collection.', 'Wearable Items', 4),
(7, 'Ancient Ring Adorned with Roman Emperor Image', '7.jpeg', 3800.00, 'Own a piece of ancient history with this ring adorned with a Roman Emperor image. Crafted with intricate detail, this ring is a remarkable artifact from the past.', 'Wearable Items', 43),
(8, 'Broad Collar of Ancient Egyptian Amulets', '8.jpg', 6500.00, 'A stunning and rare piece, this broad collar of ancient Egyptian amulets is a true treasure. Adorned with intricate symbols and craftsmanship, it\'s a remarkable artifact from ancient Egypt.', 'Wearable Items', 2),
(9, 'Handcrafted Carved Wooden Jewelry Box', '9.jpg', 450.00, 'Keep your jewelry safe and organized with this handcrafted carved wooden jewelry box. The intricate carving and attention to detail make it a beautiful and functional piece.', 'Wearable Items', 82),
(10, 'Antique Chinese Jewelry Box', '10.jpg', 800.00, 'Store your treasures in this antique Chinese jewelry box. With its ornate design and rich history, it\'s a beautiful addition to any collection.', 'Wearable Items', 0),
(11, 'Authentic Certified Roman Bronze Coin Pendant', '11.jpg', 1200.00, 'Own a piece of ancient Rome with this authentic certified Roman bronze coin pendant. A remarkable piece of history, perfect for collectors or as a unique accessory.', 'Ornaments', 56),
(12, 'Antique Chinese Jade Bead Necklace with Carved Turquoise', '12.jpg', 2300.00, 'This antique Chinese jade bead necklace with carved turquoise is a stunning piece of traditional Chinese jewelry. The intricate detailing and vibrant colors make it a valuable addition to any collection.', 'Ornaments', 82),
(13, 'Antique Retro Lion King Statue, Lion Collectible Figurines', '13.jpeg', 950.00, 'Add a touch of retro charm to your home with this antique retro lion king statue. A beautiful collectible figurine, perfect for adding character to any space.', 'Ornaments', 39),
(14, 'Ecraftindia Brass Brown and Green Antique Finish Closed Bullock Cart', '14.jpeg', 300.00, 'Decorate your home with this Ecraftindia brass brown and green antique finish closed bullock cart. A unique and eye-catching piece, perfect for adding a touch of vintage charm to any room.', 'Ornaments', 49),
(15, 'Antique Handcrafted Coastal Decorative Boat', '15.jpeg', 1100.00, 'Bring the spirit of the coast into your home with this antique handcrafted coastal decorative boat. A beautifully detailed piece, perfect for nautical-themed decor.', 'Ornaments', 29),
(16, 'Antique Golden Minakari Work Flower Vase', '16.jpeg', 750.00, 'Add a touch of elegance to your home with this antique golden Minakari work flower vase. The intricate detailing and rich colors make it a beautiful and unique piece of decor.', 'Ornaments', 116),
(17, 'Brass Rajasthani Canon Handicraft Home Decor', '17.jpeg', 550.00, 'Add a touch of royal charm to your home with this brass Rajasthani canon handicraft. A stunning piece of home decor, perfect for adding character to any space.', 'Ornaments', 0),
(18, 'Retro Typewriter Tabletop Decoration', '18.jpg', 180.00, 'Add a nostalgic touch to your home with this retro typewriter tabletop decoration. A charming piece that\'s sure to spark conversation.', 'Ornaments', 11),
(19, 'Sculpture Shaped Decorative Object Table Decor Vintage Aesthetic', '19.jpg', 250.00, 'Enhance your home decor with this sculpture-shaped decorative object. Its vintage aesthetic adds a touch of elegance to any space.', 'Ornaments', 53),
(20, 'Retro Portable Flameless Candle Lamp, LED Luminous Night Light Creative Small Oil Lamp', '20.jpeg', 120.00, 'Create a cozy atmosphere with this retro portable flameless candle lamp. The LED luminous night light adds a creative touch to your home decor.', 'Ornaments', 31),
(21, '19Th Century Oak Cupboard', '21.jpg', 2800.00, 'Add a touch of history to your home with this 19th-century oak cupboard. A beautiful and functional piece of furniture, perfect for storing your treasured items.', 'Furniture', 100),
(22, 'Imperial Beijing-Style Hand-Carved Chair', '22.jpg', 1500.00, 'Add a touch of imperial elegance to your home with this Beijing-style hand-carved chair. A stunning piece of furniture that\'s sure to be a conversation starter.', 'Furniture', 104),
(23, 'A Large And Magnificent Imperial Carved Zitan Mirror Stand, Qianlong Period', '23.jpeg', 9500.00, 'This large and magnificent imperial carved Zitan mirror stand from the Qianlong period is a true treasure. A rare and exquisite piece, perfect for collectors or as a statement piece of furniture.', 'Furniture', 2),
(24, 'Antique Chinese Elmwood Armchairs (Pair)', '24.jpg', 3200.00, 'Add a touch of oriental charm to your home with this pair of antique Chinese elmwood armchairs. Beautifully crafted and full of character, they are the perfect addition to any room.', 'Furniture', 14),
(25, 'Adam Style Giltwood Mirror', '25.jpeg', 1800.00, 'Add a touch of elegance to your home with this Adam style giltwood mirror. Its intricate design and classic style make it a beautiful and timeless piece.', 'Furniture', 61),
(26, 'Brevattato Hermle Italian Brass & Marble Mantel Clock', '26.jpeg', 2500.00, 'Enhance your home decor with this Brevattato Hermle Italian brass & marble mantel clock. A stunning and elegant piece that\'s sure to impress.', 'Furniture', 65),
(27, 'Lovely Ladies Walnut Chair', '27.jpeg', 650.00, 'This lovely ladies walnut chair is both beautiful and comfortable. A perfect addition to any room, it adds a touch of elegance to your home decor.', 'Furniture', 41),
(28, 'Early Victorian Leather-Upholstered Rosewood Stool', '28.jpeg', 950.00, 'Add a touch of vintage charm to your home with this early Victorian leather-upholstered rosewood stool. A beautiful and functional piece, perfect for any room.', 'Furniture', 8),
(29, 'Good Looking Edwardian 2 Seater Sofa For Upholstery', '29.jpeg', 1200.00, 'This good looking Edwardian 2 seater sofa is the perfect piece for upholstery. With its classic design and comfortable seating, it\'s sure to become a favorite in your home.', 'Furniture', 19),
(30, 'Antique Walnut Dressing Table Stool', '30.jpeg', 480.00, 'Add a touch of elegance to your dressing table with this antique walnut dressing table stool. Its classic design and rich finish make it a beautiful and functional piece.', 'Furniture', 73),
(31, 'Vintage Wood Smoothing Plane', '31.jpeg', 150.00, 'This vintage wood smoothing plane is a must-have for any woodworking enthusiast. A beautiful and functional tool that\'s sure to impress.', 'Tools', 5),
(32, 'Vintage Iron Wheel Apple Peeler', '32.jpg', 80.00, 'Make peeling apples a breeze with this vintage iron wheel apple peeler. A practical and charming addition to any kitchen.', 'Tools', 9),
(33, 'Plow Plane With 18 Cutters', '33.jpeg', 250.00, 'This plow plane with 18 cutters is a versatile and essential tool for any woodworking project. With its durable construction and precision design, it\'s sure to become a favorite in your workshop.', 'Tools', 31),
(34, 'Norris Jointer Plane', '34.jpeg', 1200.00, 'This Norris jointer plane is a high-quality tool that\'s perfect for woodworking enthusiasts. Its precision design and durable construction make it a valuable addition to any workshop.', 'Tools', 27),
(35, 'Planer Rangiku Chiyotsuru Sadahide Kanner Carpenter\'s Tool', '35.jpeg', 950.00, 'This Planer Rangiku Chiyotsuru Sadahide Kanner carpenter\'s tool is a rare and valuable find. Perfect for woodworking enthusiasts or collectors of vintage tools.', 'Tools', 43),
(36, 'Vintage Antique Black Cast Iron Heavy Sad Flat Iron', '36.jpg', 120.00, 'Add a touch of nostalgia to your home with this vintage antique black cast iron heavy sad flat iron. A charming piece that\'s sure to spark conversation.', 'Tools', 33),
(37, 'Antique Lighter Silver Match', '37.jpeg', 180.00, 'This antique lighter silver match is a unique and elegant accessory. Perfect for collectors or as a stylish addition to any home.', 'Tools', 36),
(38, 'Antique Suitcase With Locking Mechanism And Keys', '38.jpeg', 350.00, 'Travel in style with this antique suitcase with a locking mechanism and keys. A beautiful and functional piece, perfect for any journey.', 'Tools', 83),
(39, 'Antique Pen Fountain Pen Kosca Milano', '39.jpg', 280.00, 'Write in style with this antique fountain pen, Kosca Milano. A beautiful and elegant accessory, perfect for any writer or collector.', 'Tools', 4),
(40, 'Antique Daisy 40B Butter Churn W/ Pickle Jar Base', '40.jpeg', 550.00, 'This antique Daisy 40B butter churn with a pickle jar base is a charming and functional piece. Perfect for adding a touch of vintage charm to your kitchen decor.', 'Tools', 75),
(41, '17th Century Chinese Blue And White Porcelain Vase', '41.jpg', 6800.00, 'Own a piece of history with this 17th-century Chinese blue and white porcelain vase. A stunning and rare find, perfect for collectors or as a statement piece of decor.', 'Ceramics', 61),
(42, 'Antique Imari Pattern English Teapot', '42.jpeg', 950.00, 'Add a touch of elegance to your tea time with this antique Imari pattern English teapot. A beautiful and functional piece, perfect for any tea enthusiast.', 'Ceramics', 79),
(43, 'Jingdezhen Porcelain Vase Porch Ornaments Antique Official Enamel Porcelain Antique Collection', '43.jpeg', 3200.00, 'This Jingdezhen porcelain vase is a beautiful piece of antique official enamel porcelain. A rare find, perfect for collectors or as a statement piece of decor.', 'Ceramics', 11),
(44, 'Agarwood Vase With Crane Hermit In Gold And Silver Aya, Meiji Period', '44.jpeg', 9800.00, 'This Agarwood vase with crane hermit in gold and silver Aya from the Meiji period is a true treasure. A stunning and rare piece, perfect for collectors or as a statement piece of decor.', 'Ceramics', 21),
(45, 'Ceramic Bowl Decorative Ornament, Antique Blue And White Porcelain Bowl', '45.jpeg', 450.00, 'Add a touch of elegance to your home with this ceramic bowl decorative ornament. Its antique blue and white porcelain design makes it a beautiful and timeless piece of decor.', 'Ceramics', 74),
(46, 'Wine Pot In The Shape Of A Peach (Cadogan Type)', '46.jpg', 1200.00, 'This wine pot in the shape of a peach (Cadogan type) is a unique and elegant piece. A beautiful addition to any collection, perfect for wine enthusiasts or collectors.', 'Ceramics', 1),
(47, 'Antique German Ceramic Decorative Vase', '47.jpg', 750.00, 'Add a touch of European elegance to your home with this antique German ceramic decorative vase. A stunning and timeless piece, perfect for any room.', 'Ceramics', 90),
(48, 'Figural Painted Ceramic Bowl From Kashan, Persia, 13Th Century', '48.jpg', 3500.00, 'Own a piece of history with this figural painted ceramic bowl from Kashan, Persia, 13th century. A stunning and rare find, perfect for collectors or as a statement piece of decor.', 'Ceramics', 40),
(49, 'Large Glazed Antique Ceramic Plate', '49.jpg', 1800.00, 'Add a touch of elegance to your home with this large glazed antique ceramic plate. A beautiful and timeless piece, perfect for any room.', 'Ceramics', 33),
(50, 'Cacherpot Franz And Emilie Schleiss', '50.jpg', 2200.00, 'This Cacherpot Franz and Emilie Schleiss is a stunning piece of antique ceramic. A beautiful addition to any collection, perfect for collectors or as a statement piece of decor.', 'Ceramics', 46),
(51, 'Painting Of Wien Oper', '51.jpg', 4500.00, 'This painting of the Wien Oper is a beautiful piece of art. A stunning addition to any collection, perfect for art enthusiasts or as a statement piece of decor.', 'Artwork', 28),
(52, 'Chinese Caligraphy Copy - Preface To The Poems Collected From The Orchid Pavilion', '52.png', 3200.00, 'Own a piece of history with this Chinese calligraphy copy of the preface to the poems collected from the Orchid Pavilion. A stunning and rare find, perfect for collectors or as a statement piece of decor.', 'Artwork', 5),
(53, 'Poet On A Mountaintop By Shen Zhou', '53.jpeg', 6800.00, 'This painting, \"Poet on a Mountaintop\" by Shen Zhou, is a beautiful piece of art. A stunning addition to any collection, perfect for art enthusiasts or as a statement piece of decor.', 'Artwork', 40),
(54, 'Gate Of Bianjing City By Zhang Zeduan', '54.jpeg', 7500.00, 'Own a piece of history with this painting, \"Gate of Bianjing City\" by Zhang Zeduan. A stunning and rare find, perfect for collectors or as a statement piece of decor.', 'Artwork', 87),
(55, 'Birds In Four Seasons By Pu Zuo', '55.jpeg', 5200.00, 'This painting, \"Birds in Four Seasons\" by Pu Zuo, is a beautiful piece of art. A stunning addition to any collection, perfect for art enthusiasts or as a statement piece of decor.', 'Artwork', 10),
(56, 'Wang Xianzi Imitation By Tang Dynasty', '56.jpg', 3800.00, 'Own a piece of history with this Wang Xianzi imitation by the Tang Dynasty. A stunning and rare find, perfect for collectors or as a statement piece of decor.', 'Artwork', 93),
(57, 'Madame Le Fèvre De Caumartin As Hebe', '57.jpg', 8500.00, 'This painting, \"Madame Le Fèvre de Caumartin as Hebe\", is a beautiful piece of art. A stunning addition to any collection, perfect for art enthusiasts or as a statement piece of decor.', 'Artwork', 25),
(58, 'Gifts Of The Sultan', '58.jpg', 6500.00, 'Own a piece of history with this painting, \"Gifts of the Sultan\". A stunning and rare find, perfect for collectors or as a statement piece of decor.', 'Artwork', 55),
(59, 'The Shah\'s Wise Men Approve Of Zal\'s Marriage', '59.jpg', 9800.00, 'This painting, \"The Shah\'s Wise Men Approve of Zal\'s Marriage\", Folio 86V from the Shahnama (Book of Kings) of Shah Tahmasp, is a beautiful piece of art. A stunning addition to any collection, perfect for art enthusiasts or as a statement piece of decor.', 'Artwork', 103),
(60, 'Feeding Durian By Chuah Thean Teng', '60.jpg', 5200.00, 'This painting, \"Feeding Durian\" by Chuah Thean Teng, is a beautiful piece of art. A stunning addition to any collection, perfect for art enthusiasts or as a statement piece of decor.', 'Artwork', 28),
(61, 'whatever', '../Group Assignment/assets/img/61.jpg', 28282.00, NULL, 'Tools', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `ratingStar` int(11) DEFAULT NULL,
  `ratingComment` text DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `productId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`ratingStar`, `ratingComment`, `userId`, `productId`) VALUES
(5, 'okay lah', 5, 16),
(4, 'Good product', 1, 1),
(5, 'Excellent product', 1, 2),
(3, 'Average product', 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `userName` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `userEmail` varchar(100) DEFAULT NULL,
  `userAddress` varchar(255) DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userName`, `password`, `userEmail`, `userAddress`, `isAdmin`) VALUES
(0, 'Admin', 'admin', 'admin@admin.com', 'A201, INTI IU, Persiaran Perdana BBN, 71800 Putra Nilai, Negeri Sembilan', 1),
(1, 'Owen', '12345', 'user1@example.com', '123 Street, City, Country', 0),
(2, 'Lynn', '12345', 'user2@example.com', '456 Avenue, Town, Country', 0),
(3, 'Chris Tay', '123456', 'tayxukai@fmail.com', '6, Jalan Seri Orkid 27, Taman Seri Orkid, 81300 Skudai, Johor', 0),
(4, 'shabi', '6969', 'i22022244@student.newinti.edu.my', '111, JALAN INDAH 1/24', 0),
(5, 'Dr Wan', '123456', 'whatever@lah.com', 'no need', 0),
(6, 'user', 'password', 'email@email.com', 'abc', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartId`),
  ADD KEY `FK_Cart_User` (`userId`),
  ADD KEY `FK_Cart_Product` (`productId`);

--
-- Indexes for table `favourite`
--
ALTER TABLE `favourite`
  ADD KEY `userId` (`userId`),
  ADD KEY `productId` (`productId`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD KEY `FK_Payment_User` (`userId`),
  ADD KEY `FK_Payment_Product` (`productId`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productId`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD KEY `FK_Rating_User` (`userId`),
  ADD KEY `FK_Rating_Product` (`productId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_Cart_Product` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`),
  ADD CONSTRAINT `FK_Cart_User` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`);

--
-- Constraints for table `favourite`
--
ALTER TABLE `favourite`
  ADD CONSTRAINT `favourite_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `favourite_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `FK_Payment_Product` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`),
  ADD CONSTRAINT `FK_Payment_User` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `FK_Rating_Product` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`),
  ADD CONSTRAINT `FK_Rating_User` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
