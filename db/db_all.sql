/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_all

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2022-08-01 17:38:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `check_list`
-- ----------------------------
DROP TABLE IF EXISTS `check_list`;
CREATE TABLE `check_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `check_no` varchar(255) DEFAULT NULL,
  `check_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of check_list
-- ----------------------------
INSERT INTO `check_list` VALUES ('1', '01', 'เปิดไม่ติด', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('2', '02', 'เครื่องดับเอง', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('3', '03', 'ไม่มีสัญญาณ', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('4', '04', 'เครื่องตกน้ำ', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('5', '05', 'เครื่องตกจากที่สูง', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('6', '06', 'แฟลซเครื่อง แฮงค์ / ค้าง / รวน', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('7', '07', 'โทรเข้า-โทรออกไม่ได้', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('8', '08', 'ไม่มีเสียงเรียกเข้า / ไม่สั่น', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('9', '09', 'เพื่อนไม่ได้ยินเสียงเรา', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('10', '10', 'เราไม่ได้ยินเสียงเพื่อน', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('11', '11', 'มีเสียงแทรก/เสียงซ่า', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('12', '12', 'แบตเตอรี่', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('13', '13', 'ปลดล็อก', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('14', '14', 'อัพ Firmware', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('15', '15', 'ชาร์จแบตเตอรี่ไม่เข้า', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('16', '16', 'แบตหมดเร็ว/เก็บไฟไม่อยู่', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('17', '17', 'ทัชสกรีนไม่ได้', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('18', '18', 'ปุ่มกดบางตัวไม่ทำงาน', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('19', '19', 'วอร์ชาร์จ', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('20', '20', 'อัพภาษาไทย', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('21', '21', 'หน้าจอแตก', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('22', '22', 'หน้าจอแสดงไม่สมบูรณ์', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('23', '23', 'หน้าจอไม่โชว์สีดำ / ขึ้นจอขาวค้าง', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('24', '24', 'หน้าจอขึ้นคำว่า', null, '1', null, null, null, null);
INSERT INTO `check_list` VALUES ('25', '25', 'ติด iCloud', null, '1', null, null, null, null);

-- ----------------------------
-- Table structure for `device_type`
-- ----------------------------
DROP TABLE IF EXISTS `device_type`;
CREATE TABLE `device_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of device_type
-- ----------------------------
INSERT INTO `device_type` VALUES ('1', 'PH', 'โทรศัพท์', '1', null, null, null, null);
INSERT INTO `device_type` VALUES ('2', 'PC', 'คอมพิวเตอร์ตั้งโต๊ะ', '1', null, null, null, null);
INSERT INTO `device_type` VALUES ('3', 'NB', 'Laptop', '1', null, null, null, null);

-- ----------------------------
-- Table structure for `item`
-- ----------------------------
DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `device_type` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of item
-- ----------------------------
INSERT INTO `item` VALUES ('1', '001', 'iPhone 5s', 'iPhone 5s', 'iPhone 5s 2015', '1', null, '1', null, null, '1657698816', '2');
INSERT INTO `item` VALUES ('2', '002', 'iPhone se1', 'iPhone se1', 'iPhone se1', '1', null, '1', '1657698834', '2', '1657699350', '2');
INSERT INTO `item` VALUES ('3', '', 'iPhone 6G', 'iPhone 6G', 'iPhone 6G', '1', null, '1', '1657699386', '2', null, null);
INSERT INTO `item` VALUES ('4', '', 'iPhone 6plus', 'iPhone 6plus', 'iPhone 6plus', '1', null, '1', '1657699401', '2', null, null);
INSERT INTO `item` VALUES ('5', '', 'iPhone 6s', 'iPhone 6s', 'iPhone 6s', '1', null, '1', '1657699417', '2', null, null);
INSERT INTO `item` VALUES ('6', '', 'iPhone 6s plus', 'iPhone 6s plus', 'iPhone 6s plus', '1', null, '1', '1657699433', '2', null, null);
INSERT INTO `item` VALUES ('7', '', 'iPhone 7G', 'iPhone 7G', 'iPhone 7G', '1', null, '1', '1657699469', '2', null, null);
INSERT INTO `item` VALUES ('8', '', 'iPhone 7plus', 'iPhone 7plus', 'iPhone 7plus', '1', null, '1', '1657699616', '2', null, null);
INSERT INTO `item` VALUES ('9', '', 'iPhone 8G', 'iPhone 8G', 'iPhone 8G', '1', null, '1', '1657699651', '2', null, null);
INSERT INTO `item` VALUES ('10', '', 'iPhone 8plus', 'iPhone 8plus', 'iPhone 8plus', '1', null, '1', '1657699672', '2', null, null);
INSERT INTO `item` VALUES ('11', '', 'iPhone x', 'iPhone x', 'iPhone x', '1', null, '1', '1657699697', '2', null, null);
INSERT INTO `item` VALUES ('12', '', 'iPhone xr', 'iPhone xr', 'iPhone xr', '1', null, '1', '1657699713', '2', null, null);
INSERT INTO `item` VALUES ('13', '', 'iPhone xs', 'iPhone xs', 'iPhone xs', '1', null, '1', '1657699733', '2', null, null);
INSERT INTO `item` VALUES ('14', '', 'iPhone xs max', 'iPhone xs max', 'iPhone xs max', '1', null, '1', '1657699755', '2', null, null);
INSERT INTO `item` VALUES ('15', '', 'iPhone se2020', 'iPhone se2020', 'iPhone se2020', '1', null, '1', '1657699778', '2', null, null);
INSERT INTO `item` VALUES ('16', '', 'iPhone 11', 'iPhone 11', 'iPhone 11', '1', null, '1', '1657699796', '2', null, null);
INSERT INTO `item` VALUES ('17', '', 'iPhone 11 pro', 'iPhone 11 pro', 'iPhone 11 pro', '1', null, '1', '1657699810', '2', null, null);
INSERT INTO `item` VALUES ('18', '', 'iPhone 11 pro max', 'iPhone 11 pro max', 'iPhone 11 pro max', '1', null, '1', '1657699829', '2', null, null);
INSERT INTO `item` VALUES ('19', '', 'iPhone 12', 'iPhone 12', 'iPhone 12', '1', null, '1', '1657699852', '2', null, null);
INSERT INTO `item` VALUES ('20', '', 'iPhone 12 pro', 'iPhone 12 pro', 'iPhone 12 pro', '1', null, '1', '1657699868', '2', null, null);
INSERT INTO `item` VALUES ('21', '', 'iPhone 12 pro max', 'iPhone 12 pro max', 'iPhone 12 pro max', '1', null, '1', '1657699901', '2', null, null);

-- ----------------------------
-- Table structure for `item_brand`
-- ----------------------------
DROP TABLE IF EXISTS `item_brand`;
CREATE TABLE `item_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of item_brand
-- ----------------------------
INSERT INTO `item_brand` VALUES ('1', 'Iphone', '', '1', null, null, '1656422795', '6');
INSERT INTO `item_brand` VALUES ('2', 'Samsung', '', '1', '1656404519', '0', null, null);

-- ----------------------------
-- Table structure for `member`
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `zone_id` int(2) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `member_type_id` int(11) DEFAULT NULL,
  `phone_number` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `line_id` varchar(150) DEFAULT NULL,
  `url` varchar(225) DEFAULT NULL,
  `point` float(11,0) DEFAULT NULL,
  `wallet_amount` float(11,0) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of member
-- ----------------------------
INSERT INTO `member` VALUES ('1', '', '', '0', '0', '1', '01222', 'nirantarnoy@gmail.com', '', '', '0', '0', '0', null, null, '1657799642', '2');
INSERT INTO `member` VALUES ('2', '', '', '0', '0', '1', '011-825-1235', 'nirantarnoy@gmail.com', '', '', '0', '0', '0', null, null, '1657799679', '2');
INSERT INTO `member` VALUES ('3', '', '', '0', '0', '1', '0887692818', 'nirantarnoy@gmail.com', '', '', '0', '0', '0', null, null, '1657799682', '2');
INSERT INTO `member` VALUES ('4', '', '', '0', '0', '1', '088-9876545', 'nirantarnoy@gmail.com', '', '', '0', '0', '0', null, null, '1657799686', '2');
INSERT INTO `member` VALUES ('5', 'Tarlek', 'Tarnoy', '0', '0', '1', '045632122', 'nirantarnoy@gmail.com', '', 'http://localhost/imacplus/loginpage.php?ref=85d015967b471a8b', '500', '3000', '1', null, null, '1657799698', '2');
INSERT INTO `member` VALUES ('7', '', '', '0', '5', '1', '09888888', 'tanijanchana@gmail.com', '', 'http://localhost/imacplus/register.php?ref=9ea3e9e73d29ec4d', '0', null, '0', null, null, '1657799703', '2');
INSERT INTO `member` VALUES ('8', null, null, null, '5', null, '099999999999', 'nirantarnoy@gmail.com', null, 'http://localhost/imacplus/register.php?ref=4b6fa9898952d71e', null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for `member_type`
-- ----------------------------
DROP TABLE IF EXISTS `member_type`;
CREATE TABLE `member_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` text,
  `percent_rate` float(11,0) DEFAULT NULL,
  `platform_type_id` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of member_type
-- ----------------------------
INSERT INTO `member_type` VALUES ('1', 'หน้าร้าน Manager SHOP', 'หน้าร้าน Manager SHOP', '31', '0', '1', '1656387969', '0', null, null);
INSERT INTO `member_type` VALUES ('2', 'หน้าร้าน VIP SHOP', 'หน้าร้าน VIP SHOP', '30', '0', '1', '1656387969', '0', null, null);
INSERT INTO `member_type` VALUES ('3', 'หน้าร้าน SHOP', 'หน้าร้าน SHOP', '15', '0', '1', '1656387969', '0', null, null);
INSERT INTO `member_type` VALUES ('4', 'Online Manager SHOP 1', 'Online Manager SHOP 1', '10', '1', '1', '1656387969', '0', null, null);
INSERT INTO `member_type` VALUES ('5', 'VIP SHOP 1', 'VIP SHOP 1', '7', '1', '1', '1656387969', '0', '1657811581', '2');
INSERT INTO `member_type` VALUES ('6', 'Online SHOP 1', 'Online SHOP 1', '5', '1', '1', '1656387969', '0', null, null);
INSERT INTO `member_type` VALUES ('7', 'Online USER 1', 'Online USER 1', '2', '1', '1', '1656387969', '0', null, null);
INSERT INTO `member_type` VALUES ('8', 'Online Manager SHOP 2', 'Online Manager SHOP 2', '7', '1', '1', '1656387969', '0', null, null);
INSERT INTO `member_type` VALUES ('9', 'Online VIP SHOP 2', 'Online VIP SHOP 2', '5', '1', '1', '1656387969', '0', null, null);
INSERT INTO `member_type` VALUES ('10', 'Online SHOP 2', 'Online SHOP 2', '3', '1', '1', '1656387969', '0', null, null);
INSERT INTO `member_type` VALUES ('11', 'Online USER 2', 'Online USER 2', '1', '1', '1', '1656387969', '0', null, null);
INSERT INTO `member_type` VALUES ('12', 'หน้าร้าน USER', '', '5', null, '1', '1657812072', '2', null, null);

-- ----------------------------
-- Table structure for `member_upgrade`
-- ----------------------------
DROP TABLE IF EXISTS `member_upgrade`;
CREATE TABLE `member_upgrade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_no` varchar(255) DEFAULT NULL,
  `trans_date` datetime DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `upgrade_amount` float DEFAULT NULL,
  `upgrade_to_type` int(11) DEFAULT NULL,
  `transfer_doc` varchar(255) DEFAULT NULL,
  `approval_emp_id` int(11) DEFAULT NULL,
  `approve_date` datetime DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of member_upgrade
-- ----------------------------
INSERT INTO `member_upgrade` VALUES ('1', '2200001', '2022-07-14 08:47:12', '2', null, '5000', 'messageImage_1657609640216.jpg', null, null, null, '1', '1657781232', '5', null, null);
INSERT INTO `member_upgrade` VALUES ('2', '2200002', '2022-07-14 09:40:15', '2', null, '300', 'messageImage_1657609640216.jpg', null, null, null, '2', '1657784415', '2', null, null);
INSERT INTO `member_upgrade` VALUES ('3', '2200003', '2022-07-14 11:09:12', '2', null, '600', '43247.jpg', null, null, null, '0', '1657789752', '2', null, null);
INSERT INTO `member_upgrade` VALUES ('4', '2200004', '2022-07-14 13:05:51', '2', null, '100', '', null, null, null, '1', '1657796751', '2', null, null);
INSERT INTO `member_upgrade` VALUES ('6', '2200005', '2022-07-14 13:06:55', '2', null, '100', '', null, null, null, '1', '1657796815', '2', null, null);
INSERT INTO `member_upgrade` VALUES ('7', '2200006', '2022-07-14 16:28:15', '2', null, '500', 'messageImage_1657609640216.jpg', null, null, null, '1', '1657808895', '2', null, null);
INSERT INTO `member_upgrade` VALUES ('8', '2200007', '2022-07-14 16:34:32', '10', null, '1500', 'messageImage_1657609640216.jpg', null, null, null, '0', '1657809272', '10', null, null);
INSERT INTO `member_upgrade` VALUES ('9', '2200008', '2022-08-01 03:47:13', '1', null, '500', '294893373_833593004291068_3557118414408610887_n.jpg', null, null, null, '0', '1659318433', '1', null, null);
INSERT INTO `member_upgrade` VALUES ('10', '2200008', '2022-08-01 03:47:13', '1', null, '500', '294893373_833593004291068_3557118414408610887_n.jpg', null, null, null, '0', '1659318433', '1', null, null);
INSERT INTO `member_upgrade` VALUES ('11', '2200009', '2022-08-01 03:48:00', '1', null, '100', '294893373_833593004291068_3557118414408610887_n.jpg', null, null, null, '0', '1659318480', '1', null, null);
INSERT INTO `member_upgrade` VALUES ('12', '2200010', '2022-08-01 05:38:02', '1', '500', null, '295024544_777702260088440_4004713238093877208_n.jpg', null, null, null, '0', '1659325082', '1', null, null);
INSERT INTO `member_upgrade` VALUES ('13', '2200011', '2022-08-01 05:38:37', '1', '500', null, '295024544_777702260088440_4004713238093877208_n.jpg', null, null, null, '0', '1659325117', '1', null, null);
INSERT INTO `member_upgrade` VALUES ('14', '2200012', '2022-08-01 05:39:44', '1', '500', null, '462936.jpg', null, null, null, '0', '1659325184', '1', null, null);
INSERT INTO `member_upgrade` VALUES ('15', '2200013', '2022-08-01 05:42:52', '1', '500', null, '294893373_833593004291068_3557118414408610887_n.jpg', null, null, null, '0', '1659325372', '1', null, null);
INSERT INTO `member_upgrade` VALUES ('16', '2200014', '2022-08-01 06:00:34', '1', '500', null, '294809477_765506794663805_1868571091061247081_n.jpg', null, null, null, '1', '1659326434', '1', null, null);

-- ----------------------------
-- Table structure for `quotation`
-- ----------------------------
DROP TABLE IF EXISTS `quotation`;
CREATE TABLE `quotation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_no` varchar(255) DEFAULT NULL,
  `quotation_date` datetime DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of quotation
-- ----------------------------

-- ----------------------------
-- Table structure for `quotation_line`
-- ----------------------------
DROP TABLE IF EXISTS `quotation_line`;
CREATE TABLE `quotation_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `price` float DEFAULT NULL,
  `line_total` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of quotation_line
-- ----------------------------

-- ----------------------------
-- Table structure for `shop_type`
-- ----------------------------
DROP TABLE IF EXISTS `shop_type`;
CREATE TABLE `shop_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_type
-- ----------------------------
INSERT INTO `shop_type` VALUES ('1', 'หน้าร้าน Drop off', null, '1', null, null, null, null);
INSERT INTO `shop_type` VALUES ('2', 'Shop Online', null, '1', null, null, null, null);

-- ----------------------------
-- Table structure for `sparepart_type`
-- ----------------------------
DROP TABLE IF EXISTS `sparepart_type`;
CREATE TABLE `sparepart_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sparepart_type
-- ----------------------------
INSERT INTO `sparepart_type` VALUES ('1', 'Mainboard', null, '1', null, null, null, null);
INSERT INTO `sparepart_type` VALUES ('2', 'Monitor', null, '1', null, null, null, null);
INSERT INTO `sparepart_type` VALUES ('3', 'Battery', null, '1', null, null, null, null);
INSERT INTO `sparepart_type` VALUES ('4', 'Test', '', '1', '1657808474', '2', null, null);

-- ----------------------------
-- Table structure for `standard_part_price`
-- ----------------------------
DROP TABLE IF EXISTS `standard_part_price`;
CREATE TABLE `standard_part_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone_model_id` int(11) DEFAULT NULL,
  `platform_price` float DEFAULT NULL,
  `platform_price_include_vat` float DEFAULT NULL,
  `part_type_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of standard_part_price
-- ----------------------------
INSERT INTO `standard_part_price` VALUES ('85', '1', '1500', '1605', '1', '1', '1', '1657766501', '1', '1657776885');
INSERT INTO `standard_part_price` VALUES ('86', '2', '5200', '5564', '1', '1', '1', '1657766501', '1', '1657776885');
INSERT INTO `standard_part_price` VALUES ('87', '3', '1200', '1284', '1', '1', '1', '1657766501', '1', '1657776885');
INSERT INTO `standard_part_price` VALUES ('88', '4', '1500', '1605', '1', '1', '1', '1657766501', '1', '1657776885');
INSERT INTO `standard_part_price` VALUES ('89', '5', '1950', '2086.5', '1', '1', '1', '1657766501', '1', '1657776885');
INSERT INTO `standard_part_price` VALUES ('90', '6', '2000', '2140', '1', '1', '1', '1657766501', '1', '1657776885');
INSERT INTO `standard_part_price` VALUES ('91', '7', '1500', '1605', '1', '1', '1', '1657766501', '1', '1657776885');
INSERT INTO `standard_part_price` VALUES ('92', '8', '1500', '1605', '1', '1', '1', '1657766501', '1', '1657776885');
INSERT INTO `standard_part_price` VALUES ('93', '9', '1800', '1926', '1', '1', '1', '1657766501', '1', '1657776885');
INSERT INTO `standard_part_price` VALUES ('94', '10', '1800', '1926', '1', '1', '1', '1657766501', '1', '1657776885');
INSERT INTO `standard_part_price` VALUES ('95', '11', '1800', '1926', '1', '1', '1', '1657766501', '1', '1657776885');
INSERT INTO `standard_part_price` VALUES ('96', '12', '1800', '1926', '1', '1', '1', '1657766501', '1', '1657776885');
INSERT INTO `standard_part_price` VALUES ('97', '13', '0', '0', '1', '1', '1', '1657766501', '1', '1657776885');
INSERT INTO `standard_part_price` VALUES ('98', '14', '0', '0', '1', '1', '1', '1657766501', '1', '1657776885');
INSERT INTO `standard_part_price` VALUES ('99', '15', '0', '0', '1', '1', '1', '1657766501', '1', '1657776885');
INSERT INTO `standard_part_price` VALUES ('100', '16', '0', '0', '1', '1', '1', '1657766501', '1', '1657776885');
INSERT INTO `standard_part_price` VALUES ('101', '17', '0', '0', '1', '1', '1', '1657766501', '1', '1657776885');
INSERT INTO `standard_part_price` VALUES ('102', '18', '0', '0', '1', '1', '1', '1657766501', '1', '1657776885');
INSERT INTO `standard_part_price` VALUES ('103', '19', '0', '0', '1', '1', '1', '1657766501', '1', '1657776885');
INSERT INTO `standard_part_price` VALUES ('104', '20', '0', '0', '1', '1', '1', '1657766501', '1', '1657776885');
INSERT INTO `standard_part_price` VALUES ('105', '21', '0', '0', '1', '1', '1', '1657766501', '1', '1657776885');
INSERT INTO `standard_part_price` VALUES ('106', '1', '2900', '3103', '2', '1', '1', '1657766941', '1', '1657808429');
INSERT INTO `standard_part_price` VALUES ('107', '2', '1500', '1605', '2', '1', '1', '1657766941', '1', '1657808429');
INSERT INTO `standard_part_price` VALUES ('108', '3', '1500', '1605', '2', '1', '1', '1657766941', '1', '1657808429');
INSERT INTO `standard_part_price` VALUES ('109', '4', '1500', '1605', '2', '1', '1', '1657766941', '1', '1657808429');
INSERT INTO `standard_part_price` VALUES ('110', '5', '1500', '1605', '2', '1', '1', '1657766941', '1', '1657808429');
INSERT INTO `standard_part_price` VALUES ('111', '6', '1500', '1605', '2', '1', '1', '1657766941', '1', '1657808429');
INSERT INTO `standard_part_price` VALUES ('112', '7', '1700', '1819', '2', '1', '1', '1657766941', '1', '1657808429');
INSERT INTO `standard_part_price` VALUES ('113', '8', '1500', '1605', '2', '1', '1', '1657766941', '1', '1657808429');
INSERT INTO `standard_part_price` VALUES ('114', '9', '0', '0', '2', '1', '1', '1657766941', '1', '1657808429');
INSERT INTO `standard_part_price` VALUES ('115', '10', '0', '0', '2', '1', '1', '1657766941', '1', '1657808429');
INSERT INTO `standard_part_price` VALUES ('116', '11', '0', '0', '2', '1', '1', '1657766941', '1', '1657808429');
INSERT INTO `standard_part_price` VALUES ('117', '12', '0', '0', '2', '1', '1', '1657766941', '1', '1657808429');
INSERT INTO `standard_part_price` VALUES ('118', '13', '0', '0', '2', '1', '1', '1657766941', '1', '1657808429');
INSERT INTO `standard_part_price` VALUES ('119', '14', '0', '0', '2', '1', '1', '1657766941', '1', '1657808429');
INSERT INTO `standard_part_price` VALUES ('120', '15', '0', '0', '2', '1', '1', '1657766941', '1', '1657808429');
INSERT INTO `standard_part_price` VALUES ('121', '16', '0', '0', '2', '1', '1', '1657766941', '1', '1657808429');
INSERT INTO `standard_part_price` VALUES ('122', '17', '0', '0', '2', '1', '1', '1657766941', '1', '1657808429');
INSERT INTO `standard_part_price` VALUES ('123', '18', '0', '0', '2', '1', '1', '1657766941', '1', '1657808429');
INSERT INTO `standard_part_price` VALUES ('124', '19', '0', '0', '2', '1', '1', '1657766941', '1', '1657808429');
INSERT INTO `standard_part_price` VALUES ('125', '20', '0', '0', '2', '1', '1', '1657766941', '1', '1657808429');
INSERT INTO `standard_part_price` VALUES ('126', '21', '0', '0', '2', '1', '1', '1657766941', '1', '1657808429');
INSERT INTO `standard_part_price` VALUES ('127', '1', '800', '856', '3', '1', '1', '1657768198', '1', '1657807787');
INSERT INTO `standard_part_price` VALUES ('128', '2', '800', '856', '3', '1', '1', '1657768198', '1', '1657807787');
INSERT INTO `standard_part_price` VALUES ('129', '3', '300', '321', '3', '1', '1', '1657768198', '1', '1657807787');
INSERT INTO `standard_part_price` VALUES ('130', '4', '500', '535', '3', '1', '1', '1657768198', '1', '1657807787');
INSERT INTO `standard_part_price` VALUES ('131', '5', '650', '695.5', '3', '1', '1', '1657768198', '1', '1657807787');
INSERT INTO `standard_part_price` VALUES ('132', '6', '700', '749', '3', '1', '1', '1657768198', '1', '1657807787');
INSERT INTO `standard_part_price` VALUES ('133', '7', '500', '535', '3', '1', '1', '1657768198', '1', '1657807787');
INSERT INTO `standard_part_price` VALUES ('134', '8', '0', '0', '3', '1', '1', '1657768198', '1', '1657807787');
INSERT INTO `standard_part_price` VALUES ('135', '9', '0', '0', '3', '1', '1', '1657768198', '1', '1657807787');
INSERT INTO `standard_part_price` VALUES ('136', '10', '0', '0', '3', '1', '1', '1657768198', '1', '1657807787');
INSERT INTO `standard_part_price` VALUES ('137', '11', '0', '0', '3', '1', '1', '1657768198', '1', '1657807787');
INSERT INTO `standard_part_price` VALUES ('138', '12', '0', '0', '3', '1', '1', '1657768198', '1', '1657807787');
INSERT INTO `standard_part_price` VALUES ('139', '13', '0', '0', '3', '1', '1', '1657768198', '1', '1657807787');
INSERT INTO `standard_part_price` VALUES ('140', '14', '0', '0', '3', '1', '1', '1657768198', '1', '1657807787');
INSERT INTO `standard_part_price` VALUES ('141', '15', '0', '0', '3', '1', '1', '1657768198', '1', '1657807787');
INSERT INTO `standard_part_price` VALUES ('142', '16', '0', '0', '3', '1', '1', '1657768198', '1', '1657807787');
INSERT INTO `standard_part_price` VALUES ('143', '17', '0', '0', '3', '1', '1', '1657768198', '1', '1657807787');
INSERT INTO `standard_part_price` VALUES ('144', '18', '0', '0', '3', '1', '1', '1657768198', '1', '1657807787');
INSERT INTO `standard_part_price` VALUES ('145', '19', '0', '0', '3', '1', '1', '1657768198', '1', '1657807787');
INSERT INTO `standard_part_price` VALUES ('146', '20', '0', '0', '3', '1', '1', '1657768198', '1', '1657807787');
INSERT INTO `standard_part_price` VALUES ('147', '21', '0', '0', '3', '1', '1', '1657768198', '1', '1657807787');

-- ----------------------------
-- Table structure for `transactions`
-- ----------------------------
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_date` datetime DEFAULT NULL,
  `trans_type` int(11) DEFAULT NULL,
  `trans_ref_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `approve_by` int(11) DEFAULT NULL,
  `slip` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of transactions
-- ----------------------------
INSERT INTO `transactions` VALUES ('1', '2022-08-01 03:48:00', '2', '11', '1', '100', '1', null, null, '1659318480', '5', null, null);
INSERT INTO `transactions` VALUES ('2', '2022-08-01 05:38:37', '1', '0', '1', '500', '1', null, null, '1659325117', '5', null, null);
INSERT INTO `transactions` VALUES ('3', '2022-08-01 05:39:44', '1', '0', '1', '500', '1', null, null, '1659325184', '5', null, null);
INSERT INTO `transactions` VALUES ('4', '2022-08-01 05:42:52', '1', '15', '1', '500', '1', null, null, '1659325372', '5', null, null);
INSERT INTO `transactions` VALUES ('5', '2022-08-01 06:00:34', '1', '16', '1', '500', '1', null, null, '1659326434', '5', null, null);
INSERT INTO `transactions` VALUES ('6', '2022-08-01 06:50:24', '2', '12', '1', '100', '1', null, null, '1659329424', '5', null, null);
INSERT INTO `transactions` VALUES ('7', '2022-08-01 06:53:55', '3', '12', '1', '500', '1', null, null, '1659329635', '5', null, null);
INSERT INTO `transactions` VALUES ('8', '2022-08-01 11:53:18', '2', '13', '1', '800', '1', null, null, '1659347598', '5', null, null);
INSERT INTO `transactions` VALUES ('9', '2022-08-01 11:54:39', '2', '14', '1', '500', '1', null, null, '1659347679', '5', null, null);
INSERT INTO `transactions` VALUES ('10', '2022-08-01 11:57:17', '2', '15', '1', '500', '1', null, null, '1659347837', '5', null, null);
INSERT INTO `transactions` VALUES ('11', '2022-08-01 11:57:44', '2', '16', '1', '800', '1', null, null, '1659347864', '5', null, null);
INSERT INTO `transactions` VALUES ('12', '2022-08-01 11:57:47', '2', '17', '1', '800', '1', null, null, '1659347867', '5', null, null);
INSERT INTO `transactions` VALUES ('13', '2022-08-01 11:58:20', '2', '18', '1', '800', '1', null, null, '1659347900', '5', null, null);
INSERT INTO `transactions` VALUES ('14', '2022-08-01 11:58:27', '2', '19', '1', '800', '1', null, null, '1659347907', '5', null, null);
INSERT INTO `transactions` VALUES ('15', '2022-08-01 11:59:21', '2', '20', '1', '800', '1', null, null, '1659347961', '5', null, null);
INSERT INTO `transactions` VALUES ('16', '2022-08-01 12:00:03', '2', '21', '1', '800', '1', null, null, '1659348003', '5', null, null);
INSERT INTO `transactions` VALUES ('17', '2022-08-01 12:01:28', '2', '22', '1', '800', '1', null, null, '1659348088', '5', null, null);

-- ----------------------------
-- Table structure for `trans_type`
-- ----------------------------
DROP TABLE IF EXISTS `trans_type`;
CREATE TABLE `trans_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_name` varchar(255) DEFAULT NULL,
  `trans_type` int(11) DEFAULT NULL,
  `stock_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of trans_type
-- ----------------------------
INSERT INTO `trans_type` VALUES ('1', 'อัพเกรดสมาชิก', '1', null);
INSERT INTO `trans_type` VALUES ('2', 'เติมวอลเล็ท', '1', null);
INSERT INTO `trans_type` VALUES ('3', 'ถอน mPoint', '2', null);
INSERT INTO `trans_type` VALUES ('4', 'แจ้งซ่อม', '1', null);

-- ----------------------------
-- Table structure for `unit`
-- ----------------------------
DROP TABLE IF EXISTS `unit`;
CREATE TABLE `unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updatee_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of unit
-- ----------------------------
INSERT INTO `unit` VALUES ('1', 'ชิ้น', 'ชิ้น', 'ss', '1', '1656404496', '0', null, null);

-- ----------------------------
-- Table structure for `upgrade_trans`
-- ----------------------------
DROP TABLE IF EXISTS `upgrade_trans`;
CREATE TABLE `upgrade_trans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_date` datetime DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `upgrade_to_type` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `approve_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of upgrade_trans
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(225) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `display_name` varchar(225) DEFAULT NULL,
  `member_ref_id` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'alladmin', '25d55ad283aa400af464c76d713c07ad', '1', 'alladmin', '5', '1', null, null, null, null);
INSERT INTO `user` VALUES ('2', 'imacadmin', 'e10adc3949ba59abbe56e057f20f883e', null, 'imacadmin', '5', '1', null, null, null, null);
INSERT INTO `user` VALUES ('3', 'dkdkd', '1f0e1923c01357071e9fa6328a9d330c', null, null, '1', '1', null, null, null, null);
INSERT INTO `user` VALUES ('4', 'niran', '25d55ad283aa400af464c76d713c07ad', null, null, '2', '1', null, null, null, null);
INSERT INTO `user` VALUES ('5', 'AxAdmin', 'e10adc3949ba59abbe56e057f20f883e', null, null, '3', '1', null, null, null, null);
INSERT INTO `user` VALUES ('6', 'adminx', '25d55ad283aa400af464c76d713c07ad', null, null, '4', '1', null, null, null, null);
INSERT INTO `user` VALUES ('7', 'Axx', 'e10adc3949ba59abbe56e057f20f883e', null, null, '5', '1', null, null, null, null);
INSERT INTO `user` VALUES ('8', 'hotjoy112', 'c26b56be964d79dc068ea5fdb57fa597', null, null, '6', '1', null, null, null, null);
INSERT INTO `user` VALUES ('9', 'xx', 'e10adc3949ba59abbe56e057f20f883e', null, null, '7', '1', null, null, null, null);
INSERT INTO `user` VALUES ('10', 'TestSystem', 'e10adc3949ba59abbe56e057f20f883e', null, null, '8', '1', null, null, null, null);

-- ----------------------------
-- Table structure for `usergroup`
-- ----------------------------
DROP TABLE IF EXISTS `usergroup`;
CREATE TABLE `usergroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(225) DEFAULT NULL,
  `description` text,
  `status` int(1) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of usergroup
-- ----------------------------
INSERT INTO `usergroup` VALUES ('1', 'Administrator', '', '1', '1656404666', '0', null, null);

-- ----------------------------
-- Table structure for `wallet_trans`
-- ----------------------------
DROP TABLE IF EXISTS `wallet_trans`;
CREATE TABLE `wallet_trans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_no` varchar(255) DEFAULT NULL,
  `trans_date` datetime DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `wallet_in_amount` float DEFAULT NULL,
  `transfer_doc` varchar(255) DEFAULT NULL,
  `approval_emp_id` int(11) DEFAULT NULL,
  `approve_date` datetime DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wallet_trans
-- ----------------------------
INSERT INTO `wallet_trans` VALUES ('1', '2200001', '2022-07-14 08:47:12', '2', '5000', 'messageImage_1657609640216.jpg', null, null, null, '1', '1657781232', '5', null, null);
INSERT INTO `wallet_trans` VALUES ('2', '2200002', '2022-07-14 09:40:15', '2', '300', 'messageImage_1657609640216.jpg', null, null, null, '2', '1657784415', '2', null, null);
INSERT INTO `wallet_trans` VALUES ('3', '2200003', '2022-07-14 11:09:12', '2', '600', '43247.jpg', null, null, null, '0', '1657789752', '2', null, null);
INSERT INTO `wallet_trans` VALUES ('4', '2200004', '2022-07-14 13:05:51', '2', '100', '', null, null, null, '1', '1657796751', '2', null, null);
INSERT INTO `wallet_trans` VALUES ('6', '2200005', '2022-07-14 13:06:55', '2', '100', '', null, null, null, '1', '1657796815', '2', null, null);
INSERT INTO `wallet_trans` VALUES ('7', '2200006', '2022-07-14 16:28:15', '2', '500', 'messageImage_1657609640216.jpg', null, null, null, '1', '1657808895', '2', null, null);
INSERT INTO `wallet_trans` VALUES ('8', '2200007', '2022-07-14 16:34:32', '10', '1500', 'messageImage_1657609640216.jpg', null, null, null, '0', '1657809272', '10', null, null);
INSERT INTO `wallet_trans` VALUES ('9', '2200008', '2022-08-01 03:47:13', '1', '500', '294893373_833593004291068_3557118414408610887_n.jpg', null, null, null, '0', '1659318433', '1', null, null);
INSERT INTO `wallet_trans` VALUES ('10', '2200008', '2022-08-01 03:47:13', '1', '500', '294893373_833593004291068_3557118414408610887_n.jpg', null, null, null, '0', '1659318433', '1', null, null);
INSERT INTO `wallet_trans` VALUES ('11', '2200009', '2022-08-01 03:48:00', '1', '100', '294893373_833593004291068_3557118414408610887_n.jpg', null, null, null, '0', '1659318480', '1', null, null);
INSERT INTO `wallet_trans` VALUES ('12', '2200010', '2022-08-01 06:50:24', '1', '100', '', null, null, null, '0', '1659329424', '1', null, null);
INSERT INTO `wallet_trans` VALUES ('13', '2200011', '2022-08-01 11:53:18', '5', '800', '1659347598.jpg', null, null, null, '0', '1659347598', '5', null, null);
INSERT INTO `wallet_trans` VALUES ('14', '2200012', '2022-08-01 11:54:39', '5', '500', '1659347679.jpg', null, null, null, '0', '1659347679', '5', null, null);
INSERT INTO `wallet_trans` VALUES ('15', '2200013', '2022-08-01 11:57:17', '5', '500', '1659347837.jpg', null, null, null, '0', '1659347837', '5', null, null);
INSERT INTO `wallet_trans` VALUES ('16', '2200014', '2022-08-01 11:57:44', '5', '800', '1659347864.jpg', null, null, null, '0', '1659347864', '5', null, null);
INSERT INTO `wallet_trans` VALUES ('17', '2200015', '2022-08-01 11:57:47', '5', '800', '1659347867.jpg', null, null, null, '0', '1659347867', '5', null, null);
INSERT INTO `wallet_trans` VALUES ('18', '2200016', '2022-08-01 11:58:20', '5', '800', '1659347900.jpg', null, null, null, '0', '1659347900', '5', null, null);
INSERT INTO `wallet_trans` VALUES ('19', '2200017', '2022-08-01 11:58:27', '5', '800', '1659347907.jpg', null, null, null, '0', '1659347907', '5', null, null);
INSERT INTO `wallet_trans` VALUES ('20', '2200018', '2022-08-01 11:59:21', '5', '800', '1659347961.jpg', null, null, null, '0', '1659347961', '5', null, null);
INSERT INTO `wallet_trans` VALUES ('21', '2200019', '2022-08-01 12:00:03', '5', '800', '1659348003.jpg', null, null, null, '0', '1659348003', '5', null, null);
INSERT INTO `wallet_trans` VALUES ('22', '2200020', '2022-08-01 12:01:28', '5', '800', '1659348088.jpg', null, null, null, '0', '1659348088', '5', null, null);

-- ----------------------------
-- Table structure for `witdraw_trans`
-- ----------------------------
DROP TABLE IF EXISTS `witdraw_trans`;
CREATE TABLE `witdraw_trans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_no` varchar(255) DEFAULT NULL,
  `trans_date` datetime DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `witdraw_amount` float DEFAULT NULL,
  `transfer_doc` varchar(255) DEFAULT NULL,
  `approval_emp_id` int(11) DEFAULT NULL,
  `approve_date` datetime DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of witdraw_trans
-- ----------------------------
INSERT INTO `witdraw_trans` VALUES ('12', '2200001', '2022-08-01 06:53:55', '1', '500', '', null, null, null, '0', '1659329635', '1', null, null);

-- ----------------------------
-- Table structure for `workorders`
-- ----------------------------
DROP TABLE IF EXISTS `workorders`;
CREATE TABLE `workorders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_no` varchar(255) DEFAULT NULL,
  `work_date` datetime DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `phone_model_id` int(11) DEFAULT NULL,
  `phone_color_id` varchar(11) DEFAULT NULL,
  `estimate_price` float DEFAULT NULL,
  `customer_pass` varchar(255) DEFAULT NULL,
  `pre_pay` float DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of workorders
-- ----------------------------
INSERT INTO `workorders` VALUES ('3', '2200001', '2022-06-28 00:00:00', null, 'นิรันดร์ วังญาติ', '0860063601', '1', '1', 'เขียว', '500', '12544', '100', null, '1', '1656388015', '0', null, null);
INSERT INTO `workorders` VALUES ('4', '2200002', '2022-06-28 20:07:53', null, 'xxxx', '098-00000373', '1', '1', 'แดง', '5000', '123444', '1500', '', '1', '1656421673', '0', '1656421687', '0');
INSERT INTO `workorders` VALUES ('5', '2200003', '2022-06-28 20:32:22', null, 'ssss', '0860063601', '1', '1', 'เงิน', '5000', 'Ax12222', '100', '', '1', '1656423142', '0', null, null);

-- ----------------------------
-- Table structure for `workorder_line`
-- ----------------------------
DROP TABLE IF EXISTS `workorder_line`;
CREATE TABLE `workorder_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `workorder_id` int(11) DEFAULT NULL,
  `check_list_id` int(11) DEFAULT NULL,
  `is_checked` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of workorder_line
-- ----------------------------
INSERT INTO `workorder_line` VALUES ('7', '2', '1', '1', null, null);
INSERT INTO `workorder_line` VALUES ('8', '2', '2', '1', null, null);
INSERT INTO `workorder_line` VALUES ('9', '2', '21', '1', null, null);
INSERT INTO `workorder_line` VALUES ('10', '3', '17', '1', null, null);
INSERT INTO `workorder_line` VALUES ('11', '3', '19', '1', null, null);
INSERT INTO `workorder_line` VALUES ('12', '3', '20', '1', null, null);
INSERT INTO `workorder_line` VALUES ('13', '3', '21', '1', null, null);
INSERT INTO `workorder_line` VALUES ('14', '4', '1', '1', null, null);
INSERT INTO `workorder_line` VALUES ('15', '4', '12', '1', null, null);
INSERT INTO `workorder_line` VALUES ('16', '4', '20', '1', null, null);
INSERT INTO `workorder_line` VALUES ('17', '4', '25', '1', null, null);
INSERT INTO `workorder_line` VALUES ('18', '5', '1', '1', null, null);
INSERT INTO `workorder_line` VALUES ('19', '5', '9', '1', null, null);
INSERT INTO `workorder_line` VALUES ('20', '5', '10', '1', null, null);
INSERT INTO `workorder_line` VALUES ('21', '5', '17', '1', null, null);
