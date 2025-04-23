-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2024 at 08:17 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `aboutus_tbl`
--

CREATE TABLE `aboutus_tbl` (
  `a_Id` int(11) NOT NULL,
  `a_content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `a_Image` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `aboutus_tbl`
--

INSERT INTO `aboutus_tbl` (`a_Id`, `a_content`, `created_at`, `updated_at`, `a_Image`) VALUES
(1, '<p><span style=\"color:#cccccc;\">With the intent to make the most premium quality art more accessible, Dessine Art is here to revolutionize the Art Industry and enhance the confidence of online art buyers.</span></p><p><span style=\"color:#cccccc;\">With us, you can effortlessly buy art ranging from every style, from classical to contemporary and affordable to high-end pieces. Every artwork on Dessine Art is creatively curated by our team to cater to the aesthetics of art lovers around the world. Along with established artists, we are also promoting the work of budding &nbsp;artists so that it can help them reach out to a wider audience.</span></p>', '2024-10-22 19:33:10', '2024-10-23 08:52:27', 'Meraki.png');

-- --------------------------------------------------------

--
-- Table structure for table `cart_tbl`
--

CREATE TABLE `cart_tbl` (
  `Ct_Id` int(33) NOT NULL,
  `Ct_Quantity` int(45) NOT NULL,
  `Ct_P_Id` int(56) NOT NULL,
  `Ct_U_Email` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cart_tbl`
--

INSERT INTO `cart_tbl` (`Ct_Id`, `Ct_Quantity`, `Ct_P_Id`, `Ct_U_Email`) VALUES
(1, 1, 3, 'jinal.taraviya997@gmail.com'),
(36, 2, 3, 'angelraiyanii@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `category_tbl`
--

CREATE TABLE `category_tbl` (
  `C_Id` int(3) NOT NULL,
  `C_Name` varchar(60) NOT NULL,
  `C_Img` varchar(60) NOT NULL,
  `C_Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_tbl`
--

INSERT INTO `category_tbl` (`C_Id`, `C_Name`, `C_Img`, `C_Status`) VALUES
(1, 'Drawing Materials', '670c9715c2eaadrawing_illustration.png', 'Active'),
(2, 'Sculpting and Modeling', '66f77c93e0b08Sculpting and Modeling.png', 'Active'),
(3, 'Paints', '670b644d762f7acrylicColors.png', 'Active'),
(4, 'Surfaces', '670bbd8b8bad7paper_boards.png', 'Active'),
(5, 'Furniture', '673d5093c819e6713b2b905deaeaseal2.png', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `contact_tbl`
--

CREATE TABLE `contact_tbl` (
  `Co_Id` int(10) NOT NULL,
  `Co_Name` varchar(60) NOT NULL,
  `Co_Email` varchar(100) NOT NULL,
  `Co_Msg` text NOT NULL,
  `Co_Reply` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_tbl`
--

INSERT INTO `contact_tbl` (`Co_Id`, `Co_Name`, `Co_Email`, `Co_Msg`, `Co_Reply`) VALUES
(1, 'Angel Raiyani', 'angelraiyanii@gmail.com', 'first record', 'hello contact us successful🎉🎉'),
(2, 'Jinal taraviya', 'jtaraviya932@rku.ac.in', 'hello, when will new products be added??? ', 'This website is still under development. '),
(3, 'Ayushi Mehta', 'jinal.taraviya997@gmail.com', 'I want to reset my password', 'then do it'),
(4, 'Bhakti Bhut', 'angelraiyanii@gmail.com', 'loved your site😍', '');

-- --------------------------------------------------------

--
-- Table structure for table `offers_tbl`
--

CREATE TABLE `offers_tbl` (
  `Of_Id` int(11) NOT NULL,
  `Of_Name` varchar(255) NOT NULL,
  `Of_Description` text NOT NULL,
  `Of_Discount_Percentage` decimal(5,2) NOT NULL,
  `Of_Cart_Total` int(11) NOT NULL,
  `Of_Max_Discount` int(11) NOT NULL,
  `Of_Start_Date` varchar(10) NOT NULL,
  `Of_End_Date` varchar(10) NOT NULL,
  `Of_Banner` text NOT NULL,
  `Of_Status` enum('Active','Deactivate') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offers_tbl`
--

INSERT INTO `offers_tbl` (`Of_Id`, `Of_Name`, `Of_Description`, `Of_Discount_Percentage`, `Of_Cart_Total`, `Of_Max_Discount`, `Of_Start_Date`, `Of_End_Date`, `Of_Banner`, `Of_Status`) VALUES
(1, 'BigSale24', 'Cart clearance offer \r\nGet 20% discount on total shopping of 3000', 20.00, 3000, 20, '2024-12-05', '2024-12-11', 'slide2.png', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `order_tbl`
--

CREATE TABLE `order_tbl` (
  `O_Id` int(56) NOT NULL,
  `O_U_Email` varchar(56) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `O_Order_Id` varchar(100) NOT NULL,
  `O_Sub_Order_Id` varchar(100) NOT NULL,
  `O_P_Id` int(45) NOT NULL,
  `O_Rating` decimal(10,0) DEFAULT NULL,
  `O_Review` text DEFAULT NULL,
  `O_Total_Amount` decimal(56,0) NOT NULL,
  `O_Quantity` int(56) NOT NULL,
  `O_Add` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `O_Phn` varchar(56) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `O_City` varchar(78) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `O_Zip` int(89) NOT NULL,
  `O_State` varchar(56) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `O_Delivery_Status` enum('Ordered','Shipped','Delivered','Returned','Replaced') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Ordered',
  `O_Payment_Status` enum('Panding','Completed','Failed','') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Completed',
  `O_Offer_Name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `O_Payment_Mode` varchar(10) NOT NULL,
  `O_Date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_tbl`
--

INSERT INTO `order_tbl` (`O_Id`, `O_U_Email`, `O_Order_Id`, `O_Sub_Order_Id`, `O_P_Id`, `O_Rating`, `O_Review`, `O_Total_Amount`, `O_Quantity`, `O_Add`, `O_Phn`, `O_City`, `O_Zip`, `O_State`, `O_Delivery_Status`, `O_Payment_Status`, `O_Offer_Name`, `O_Payment_Mode`, `O_Date`) VALUES
(1, 'angelraiyanii@gmail.com', 'order_PT1np926NbPMO6', '67500e56e4c5d', 3, NULL, NULL, 6500, 3, 'qwerftg', '1234567890', 'Rajkot', 360005, 'Gujarat', 'Ordered', 'Completed', '', '', '2024-12-04 13:39:58'),
(2, 'angelraiyanii@gmail.com', 'order_PT1np926NbPMO6', '67500e56e4c5d', 1, NULL, NULL, 6500, 2, 'qwerftg', '1234567890', 'Rajkot', 360005, 'Gujarat', 'Ordered', 'Completed', '', '', '2024-12-04 13:39:58'),
(3, 'jtaraviya932@rku.ac.in', 'order_PT2CYbrooaHIFQ', '675013d7a6fbd', 1, NULL, NULL, 7000, 1, 'Ranchhod Nagar-7', '1234567890', 'Rajkot', 789998, 'Gujarat', 'Delivered', 'Completed', '', '', '2024-12-04 14:03:27'),
(4, 'jtaraviya932@rku.ac.in', 'order_PT2CYbrooaHIFQ', '675013d7a6fbd', 2, NULL, NULL, 7000, 2, 'Ranchhod Nagar-7', '1234567890', 'Rajkot', 789998, 'Gujarat', 'Delivered', 'Completed', '', '', '2024-12-04 14:03:27'),
(5, 'amehta123@gmail.com', 'order_PT5waQ7AVpi3B5', '6750476c10033', 2, NULL, NULL, 4230, 1, 'qwer', '1234567890', 'Kalavad', 360005, 'Gujarat', 'Delivered', 'Completed', 'BigSale24', '', '2024-12-04 17:43:32'),
(6, 'amehta123@gmail.com', 'order_PT5waQ7AVpi3B5', '6750476c10033', 3, NULL, NULL, 4230, 4, 'qwer', '1234567890', 'Kalavad', 360005, 'Gujarat', 'Delivered', 'Completed', 'BigSale24', '', '2024-12-04 17:43:32'),
(7, 'patelbhakti636@gmail.com', 'order_PT60wFjGqvRqjR', '6750484707ac9', 3, NULL, NULL, 1500, 3, 'Nanivavdi', '1234567890', 'Dhoraji', 360005, 'Gujarat', 'Ordered', 'Completed', 'BigSale24', '', '2024-12-04 17:47:11'),
(8, 'jinal.taraviya2205@gmail.com', 'order_PT6LwR5qSZXUFz', '67504cf172929', 3, NULL, NULL, 1500, 3, 'rk university', '2147483647', 'Rajkot', 360005, 'Gujarat', 'Ordered', 'Completed', 'BigSale24', '', '2024-12-04 18:07:05'),
(9, 'akbarinirali27@gmail.com', 'order_PTtE6O6L86qxtM', '6752ed4587194', 3, NULL, NULL, 500, 1, 'rku', '1234567890', 'Rajkot', 360005, 'Gujarat', 'Ordered', 'Completed', '', '', '2024-12-06 17:55:41'),
(10, 'angelraiyanii@gmail.com', 'order_PU9Bo18r6LBVL9', '6753c8de23c16', 3, NULL, NULL, 11500, 3, 'qwerftg', '1234567890', 'Rajkot', 360005, 'Gujarat', 'Delivered', 'Completed', '', '', '2024-12-07 09:32:38'),
(11, 'angelraiyanii@gmail.com', 'order_PU9Bo18r6LBVL9', '6753c8de23c16', 1, NULL, NULL, 11500, 4, 'qwerftg', '1234567890', 'Rajkot', 360005, 'Gujarat', 'Delivered', 'Completed', '', '', '2024-12-07 09:32:38'),
(12, 'jtaraviya932@rku.ac.in', 'order_PUB6TdzHw5ud4L', '6753e337651d2', 1, NULL, NULL, 7480, 3, 'Ranchhod Nagar-7', '1234567890', 'Rajkot', 789998, 'Gujarat', 'Delivered', 'Completed', 'BigSale24', 'Online', '2024-12-07 11:25:03'),
(13, 'angelraiyanii@gmail.com', 'order_PV0QyZUJwSZNpk', '6756a5644b8c3', 2, NULL, NULL, 14250, 3, 'qwerftg', '1234567890', 'Rajkot', 360005, 'Gujarat', 'Ordered', 'Completed', '', 'Online', '2024-12-09 13:38:04'),
(14, 'angelraiyanii@gmail.com', 'order_PV0QyZUJwSZNpk', '6756a5644b8c3', 1, NULL, NULL, 14250, 3, 'qwerftg', '1234567890', 'Rajkot', 360005, 'Gujarat', 'Ordered', 'Completed', '', 'Online', '2024-12-09 13:38:04'),
(15, 'jtaraviya932@rku.ac.in', 'order_PV6YAA7ex7T4N4', '6756f96ea5247', 2, NULL, NULL, 4480, 1, 'Ranchhod Nagar-7', '1234567890', 'Rajkot', 789998, 'Gujarat', 'Delivered', 'Completed', 'BigSale24', 'Online', '2024-12-09 19:36:38'),
(16, 'jtaraviya932@rku.ac.in', 'order_PV6YAA7ex7T4N4', '6756f96ea5247', 1, NULL, NULL, 4480, 1, 'Ranchhod Nagar-7', '1234567890', 'Rajkot', 789998, 'Gujarat', 'Delivered', 'Completed', 'BigSale24', 'Online', '2024-12-09 19:36:38');

-- --------------------------------------------------------

--
-- Table structure for table `password_token_tbl`
--

CREATE TABLE `password_token_tbl` (
  `Id` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Otp` int(11) NOT NULL,
  `Created_at` datetime NOT NULL,
  `Expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_token_tbl`
--

INSERT INTO `password_token_tbl` (`Id`, `Email`, `Otp`, `Created_at`, `Expires_at`) VALUES
(8, 'akbarinirali27@gmail.com', 602662, '2024-10-23 09:34:51', '2024-10-23 09:35:51');

-- --------------------------------------------------------

--
-- Table structure for table `product_tbl`
--

CREATE TABLE `product_tbl` (
  `P_Id` int(10) NOT NULL,
  `P_Name` varchar(200) NOT NULL,
  `P_Price` int(60) NOT NULL,
  `P_Stock` int(5) NOT NULL,
  `P_Company_Name` varchar(60) NOT NULL,
  `P_SC_Id` int(3) NOT NULL,
  `P_Desc` text NOT NULL,
  `P_Img1` varchar(60) NOT NULL,
  `P_Img2` varchar(60) NOT NULL,
  `P_Status` varchar(10) NOT NULL,
  `P_Discount` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_tbl`
--

INSERT INTO `product_tbl` (`P_Id`, `P_Name`, `P_Price`, `P_Stock`, `P_Company_Name`, `P_SC_Id`, `P_Desc`, `P_Img1`, `P_Img2`, `P_Status`, `P_Discount`) VALUES
(1, 'Nitram Powdered Charcoal 175gms SKU: AZ1635', 2500, 989, 'Nitram', 1, 'Nitram Powdered Charcoal gives artists a versatile way to apply charcoal and produce varied and textured sketch effects\r\nMilled to an extra fine, uniform 100µ particle size\r\nSmooth, velvety consistency\r\nCan be applied with a brush or a paper stump\r\nHelps to produce varied and textured sketch effects\r\nExcellent lightfastness\r\nNitram Extra Fine Powdered Charcoal comes in this sturdy, reusable aluminium tin, with a lid that can be sealed tightly to avoid messy leaks.\r\nThe functional recessed reservoir insert allows you to control the amount of Nitram Charcoal Powder available. It can be easily removed to access and refill the tin.\r\nNitram Powdered Charcoal is milled to an extra-fine, uniform 100µ particle size. It is smooth, velvety and consistent. It has no coarse or grainy lumps that can mar the surface of your paper.\r\nYou can use a brush or a paper stump to create shapes and tones quickly and easily.\r\nThe uses are limited only by your imagination!', '670a79c48ee98charcoalpow.png', '670a8d75a1142powder.png', 'Active', 10),
(2, 'BRUSTRO Watercolor Paint Set of 24 Colors X 12ML Tubes', 2500, 396, 'BRUSTRO ', 3, 'Set of 24 premium watercolor 12 ml tubes\r\nCan be used to paint on all conventional watercolor surfaces\r\nCompatible with Brustro watercolor papers .\r\nBright transparent colors.\r\nColors are intermixable, giving endless color possibilities.', '6713badea01f2wc1.png', '6713badea01f5wc2.png', 'Active', 10),
(3, 'Ohuhu 160 Colors Alcohol Double Tipped Art Marker Set', 5000, 996, 'Ohuhu', 2, 'DUAL TIPS FINE AND CHISEL ENDS: Broad and fine twin tips for precise highlighting and underlining, for drawing with both thin and thick lines. Allows you to create various styles, sketches and patterns with ease\r\n160 UNIQUE VIBRANT COLORS + 1 COLORLESS BLENDER, SUPERIOR BLENDABILITY: The highly pigmented and vibrant markers are built to last against fading, and blend beautifully for added dimension to your artwork\r\nALCOHOL-BASED INK, FAST DRYING: Easily layer and mix different colors without worrying about smudges and blotches\r\nHIGH QUALITY: Marker pens are highly pigmented, allowing you to color in at least 984ft. worth of drawings\r\nCOLOR-CODED CAPS & BONUS CASE, GREAT GIFT IDEA: The color-coded caps allow for ease in organization and use in identifying colors; And also, these marker pen set is quipped with a beautiful black carrying case for ease in travelling and storing', '6714a7283d7a8markers.png', '6714a7283d7b0markers2.png', 'Active', 90);

-- --------------------------------------------------------

--
-- Table structure for table `review_tbl`
--

CREATE TABLE `review_tbl` (
  `R_Id` int(11) NOT NULL,
  `R_U_Email` varchar(100) NOT NULL,
  `R_U_Name` varchar(100) NOT NULL,
  `R_Order_Id` varchar(20) NOT NULL,
  `R_P_Id` int(11) NOT NULL,
  `R_Rating` int(11) NOT NULL,
  `R_Review` text NOT NULL,
  `R_Date` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review_tbl`
--

INSERT INTO `review_tbl` (`R_Id`, `R_U_Email`, `R_U_Name`, `R_Order_Id`, `R_P_Id`, `R_Rating`, `R_Review`, `R_Date`) VALUES
(2, 'jtaraviya932@rku.ac.in', 'Jinal Taraviya', 'order_PUB6TdzHw5ud4L', 1, 3, 'kakakajayayaj', '2024-12-09 13:06:08'),
(5, 'angelraiyanii@gmail.com', 'angel raiyani', 'order_PU9Bo18r6LBVL9', 1, 4, 'qwetyioplkjhgfdsazxcvbnm', '2024-12-09 13:45:29'),
(6, 'jtaraviya932@rku.ac.in', 'Jinal Taraviya', 'order_PT2CYbrooaHIFQ', 2, 5, 'Nice Colors and very good quality product', '2024-12-09 19:28:21');

-- --------------------------------------------------------

--
-- Table structure for table `slider_tbl`
--

CREATE TABLE `slider_tbl` (
  `Id` int(3) NOT NULL,
  `Img_1` varchar(100) NOT NULL,
  `Img_2` varchar(100) NOT NULL,
  `Img_3` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slider_tbl`
--

INSERT INTO `slider_tbl` (`Id`, `Img_1`, `Img_2`, `Img_3`) VALUES
(1, 'slide1.png', 'slide2.png', 'slide3.png');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory_tbl`
--

CREATE TABLE `subcategory_tbl` (
  `SC_Id` int(3) NOT NULL,
  `SC_Name` varchar(60) NOT NULL,
  `C_Id` int(3) NOT NULL,
  `SC_Img` varchar(60) NOT NULL,
  `SC_Status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategory_tbl`
--

INSERT INTO `subcategory_tbl` (`SC_Id`, `SC_Name`, `C_Id`, `SC_Img`, `SC_Status`) VALUES
(1, 'Charcoal', 1, '6753ec4a3f904Charcoal.png', 'Active'),
(2, 'Markers', 1, '6713ae1e1d37bmarkers.png', 'Active'),
(3, 'Watercolors', 3, '6713af6b9a4e9watercolor.png', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE `user_tbl` (
  `U_Id` int(11) NOT NULL,
  `U_Fnm` varchar(255) NOT NULL,
  `U_Lnm` varchar(255) NOT NULL,
  `U_Email` varchar(255) NOT NULL,
  `U_Phn` int(15) NOT NULL,
  `U_Add` text NOT NULL,
  `U_City` char(10) NOT NULL,
  `U_State` char(10) NOT NULL,
  `U_Zip` int(6) NOT NULL,
  `U_Pwd` varchar(255) NOT NULL,
  `U_Profile` varchar(255) DEFAULT NULL,
  `U_Role` char(10) DEFAULT 'Normal',
  `U_Status` char(10) DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`U_Id`, `U_Fnm`, `U_Lnm`, `U_Email`, `U_Phn`, `U_Add`, `U_City`, `U_State`, `U_Zip`, `U_Pwd`, `U_Profile`, `U_Role`, `U_Status`) VALUES
(1, 'Jinal', 'Taraviya', 'jtaraviya932@rku.ac.in', 1234567890, 'Ranchhod Nagar-7', 'Rajkot', 'Gujarat', 789998, 'jinal', '670e05e118e2abg9.png', 'Admin', 'Active'),
(53, 'ayushi', 'mehta', 'amehta123@gmail.com', 1234567890, 'qwer', 'Kalavad', 'Gujarat', 360005, 'ayu', '6713cb1fe29f7Untitled design.png', 'Normal', 'Active'),
(54, 'Angel', 'Raiyani', 'angelraiyanii@gmail.com', 1224567890, 'qwerftg', 'Rajkot', 'Gujarat', 360005, 'angel', '6713ccb4809567.jpg', 'Normal', 'Active'),
(59, 'Kalindi', 'Fichadiya', 'jinal.taraviya997@gmail.com', 2147483647, 'rku', 'Rajkot', 'Gujarat', 360005, 'kallu', '670606a6a6640Untitled design.png', 'Normal', 'Active'),
(63, 'Bhakti', 'Bhut', 'patelbhakti636@gmail.com', 1234567890, 'Nanivavdi', 'Dhoraji', 'Gujarat', 360005, 'bhut', '671875ea5252cghost-face.png', 'Normal', 'Active'),
(65, 'kishn', 'vekariya', 'jinal.taraviya2205@gmail.com', 2147483647, 'rk university', 'Rajkot', 'Gujarat', 360005, 'kallu', '67188ec68a363ghost-face.png', 'Normal', 'Active'),
(66, 'Nirali', 'Akbari', 'akbarinirali27@gmail.com', 1234567890, 'rku', 'Rajkot', 'Gujarat', 360005, 'nirali', '6718a4dbd28c3Screenshot (76).png', 'Normal', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_tbl`
--

CREATE TABLE `wishlist_tbl` (
  `W_Id` int(65) NOT NULL,
  `W_U_Email` varchar(56) NOT NULL,
  `W_P_Id` int(56) NOT NULL,
  `W_quantity` int(56) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `wishlist_tbl`
--

INSERT INTO `wishlist_tbl` (`W_Id`, `W_U_Email`, `W_P_Id`, `W_quantity`) VALUES
(4, 'patelbhakti636@gmail.com', 2, 1),
(6, 'jtaraviya932@rku.ac.in', 0, 1),
(8, 'angelraiyanii@gmail.com', 1, 1),
(12, 'jtaraviya932@rku.ac.in', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aboutus_tbl`
--
ALTER TABLE `aboutus_tbl`
  ADD PRIMARY KEY (`a_Id`);

--
-- Indexes for table `cart_tbl`
--
ALTER TABLE `cart_tbl`
  ADD PRIMARY KEY (`Ct_Id`);

--
-- Indexes for table `category_tbl`
--
ALTER TABLE `category_tbl`
  ADD PRIMARY KEY (`C_Id`);

--
-- Indexes for table `contact_tbl`
--
ALTER TABLE `contact_tbl`
  ADD PRIMARY KEY (`Co_Id`);

--
-- Indexes for table `offers_tbl`
--
ALTER TABLE `offers_tbl`
  ADD PRIMARY KEY (`Of_Id`);

--
-- Indexes for table `order_tbl`
--
ALTER TABLE `order_tbl`
  ADD PRIMARY KEY (`O_Id`);

--
-- Indexes for table `password_token_tbl`
--
ALTER TABLE `password_token_tbl`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `product_tbl`
--
ALTER TABLE `product_tbl`
  ADD PRIMARY KEY (`P_Id`);

--
-- Indexes for table `review_tbl`
--
ALTER TABLE `review_tbl`
  ADD PRIMARY KEY (`R_Id`);

--
-- Indexes for table `slider_tbl`
--
ALTER TABLE `slider_tbl`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `subcategory_tbl`
--
ALTER TABLE `subcategory_tbl`
  ADD PRIMARY KEY (`SC_Id`);

--
-- Indexes for table `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`U_Id`),
  ADD UNIQUE KEY `U_Email` (`U_Email`);

--
-- Indexes for table `wishlist_tbl`
--
ALTER TABLE `wishlist_tbl`
  ADD PRIMARY KEY (`W_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aboutus_tbl`
--
ALTER TABLE `aboutus_tbl`
  MODIFY `a_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart_tbl`
--
ALTER TABLE `cart_tbl`
  MODIFY `Ct_Id` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `category_tbl`
--
ALTER TABLE `category_tbl`
  MODIFY `C_Id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contact_tbl`
--
ALTER TABLE `contact_tbl`
  MODIFY `Co_Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `offers_tbl`
--
ALTER TABLE `offers_tbl`
  MODIFY `Of_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_tbl`
--
ALTER TABLE `order_tbl`
  MODIFY `O_Id` int(56) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `password_token_tbl`
--
ALTER TABLE `password_token_tbl`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_tbl`
--
ALTER TABLE `product_tbl`
  MODIFY `P_Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `review_tbl`
--
ALTER TABLE `review_tbl`
  MODIFY `R_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `slider_tbl`
--
ALTER TABLE `slider_tbl`
  MODIFY `Id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subcategory_tbl`
--
ALTER TABLE `subcategory_tbl`
  MODIFY `SC_Id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `U_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `wishlist_tbl`
--
ALTER TABLE `wishlist_tbl`
  MODIFY `W_Id` int(65) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
