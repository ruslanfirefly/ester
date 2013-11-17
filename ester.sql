/*
 Navicat Premium Data Transfer

 Source Server         : estert
 Source Server Type    : MySQL
 Source Server Version : 50531
 Source Host           : localhost
 Source Database       : ester

 Target Server Type    : MySQL
 Target Server Version : 50531
 File Encoding         : utf-8

 Date: 10/06/2013 17:09:18 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `ester_city`
-- ----------------------------
DROP TABLE IF EXISTS `ester_city`;
CREATE TABLE `ester_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `city` (`city`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `ester_city`
-- ----------------------------
BEGIN;
INSERT INTO `ester_city` VALUES ('1', 'Санкт-Петербург'), ('2', 'Москва');
COMMIT;

-- ----------------------------
--  Table structure for `ester_dogovors_finrisk`
-- ----------------------------
DROP TABLE IF EXISTS `ester_dogovors_finrisk`;
CREATE TABLE `ester_dogovors_finrisk` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dogovor` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dog` (`dogovor`)
) ENGINE=MyISAM AUTO_INCREMENT=209 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `ester_dogovors_finrisk`
-- ----------------------------
BEGIN;
INSERT INTO `ester_dogovors_finrisk` VALUES ('12', '333 №111113'), ('13', '333 №111114'), ('14', '333 №111115'), ('15', '333 №111116'), ('16', '333 №111117'), ('17', '333 №111118'), ('18', '333 №111119'), ('31', '333 №1111122'), ('32', '333 №1111123'), ('33', '333 №1111124'), ('34', '333 №1111125'), ('35', '333 №1111126'), ('36', '333 №1111127'), ('37', '333 №1111128'), ('38', '333 №1111129'), ('39', '333 №1111130'), ('40', '333 №1111131'), ('41', '333 №1111132'), ('42', '333 №1111133'), ('43', '333 №1111134'), ('44', '333 №1111135'), ('45', '333 №1111136'), ('46', '333 №1111137'), ('47', '333 №1111138'), ('48', '333 №1111139'), ('49', '333 №1111140'), ('50', '333 №1111141'), ('51', '333 №1111142'), ('52', '333 №1111143'), ('53', '333 №1111144'), ('54', '333 №1111145'), ('55', '333 №1111146'), ('56', '333 №1111147'), ('57', '333 №1111148'), ('58', '333 №1111149'), ('59', '333 №1111150'), ('60', '333 №1111151'), ('61', '333 №1111152'), ('62', '333 №1111153'), ('63', '333 №1111154'), ('64', '333 №1111155'), ('65', '333 №1111156'), ('66', '333 №1111157'), ('67', '333 №1111158'), ('68', '333 №1111159'), ('69', '333 №1111160'), ('70', '333 №1111161'), ('71', '333 №1111162'), ('72', '333 №1111163'), ('73', '333 №1111164'), ('74', '333 №1111165'), ('75', '333 №1111166'), ('76', '333 №1111167'), ('77', '333 №1111168'), ('78', '333 №1111169'), ('79', '333 №1111170'), ('80', '333 №1111171'), ('81', '333 №1111172'), ('82', '333 №1111173'), ('83', '333 №1111174'), ('84', '333 №1111175'), ('85', '333 №1111176'), ('86', '333 №1111177'), ('87', '333 №1111178'), ('88', '333 №1111179'), ('89', '333 №1111180'), ('90', '333 №1111181'), ('91', '333 №1111182'), ('92', '333 №1111183'), ('93', '333 №1111184'), ('94', '333 №1111185'), ('95', '333 №1111186'), ('96', '333 №1111187'), ('97', '333 №1111188'), ('98', '333 №1111189'), ('99', '333 №1111190'), ('100', '333 №1111191'), ('101', '333 №1111192'), ('102', '333 №1111193'), ('103', '333 №1111194'), ('104', '333 №1111195'), ('105', '333 №1111196'), ('106', '333 №1111197'), ('107', '333 №1111198'), ('108', '333 №1111199'), ('109', '333 №111120'), ('110', '333 №111121'), ('111', '333 №111122'), ('112', '333 №111123'), ('113', '333 №111124'), ('114', '333 №111125'), ('115', '333 №111126'), ('116', '333 №111127'), ('117', '333 №111128'), ('118', '333 №111129'), ('119', '333 №1111210'), ('120', '333 №1111211'), ('121', '333 №1111212'), ('122', '333 №1111213'), ('123', '333 №1111214'), ('124', '333 №1111215'), ('125', '333 №1111216'), ('126', '333 №1111217'), ('127', '333 №1111218'), ('128', '333 №1111219'), ('129', '333 №1111220'), ('130', '333 №1111221'), ('131', '333 №1111222'), ('132', '333 №1111223'), ('133', '333 №1111224'), ('134', '333 №1111225'), ('135', '333 №1111226'), ('136', '333 №1111227'), ('137', '333 №1111228'), ('138', '333 №1111229'), ('139', '333 №1111230'), ('140', '333 №1111231'), ('141', '333 №1111232'), ('142', '333 №1111233'), ('143', '333 №1111234'), ('144', '333 №1111235'), ('145', '333 №1111236'), ('146', '333 №1111237'), ('147', '333 №1111238'), ('148', '333 №1111239'), ('149', '333 №1111240'), ('150', '333 №1111241'), ('151', '333 №1111242'), ('152', '333 №1111243'), ('153', '333 №1111244'), ('154', '333 №1111245'), ('155', '333 №1111246'), ('156', '333 №1111247'), ('157', '333 №1111248'), ('158', '333 №1111249'), ('159', '333 №1111250'), ('160', '333 №1111251'), ('161', '333 №1111252'), ('162', '333 №1111253'), ('163', '333 №1111254'), ('164', '333 №1111255'), ('165', '333 №1111256'), ('166', '333 №1111257'), ('167', '333 №1111258'), ('168', '333 №1111259'), ('169', '333 №1111260'), ('170', '333 №1111261'), ('171', '333 №1111262'), ('172', '333 №1111263'), ('173', '333 №1111264'), ('174', '333 №1111265'), ('175', '333 №1111266'), ('176', '333 №1111267'), ('177', '333 №1111268'), ('178', '333 №1111269'), ('179', '333 №1111270'), ('180', '333 №1111271'), ('181', '333 №1111272'), ('182', '333 №1111273'), ('183', '333 №1111274'), ('184', '333 №1111275'), ('185', '333 №1111276'), ('186', '333 №1111277'), ('187', '333 №1111278'), ('188', '333 №1111279'), ('189', '333 №1111280'), ('190', '333 №1111281'), ('191', '333 №1111282'), ('192', '333 №1111283'), ('193', '333 №1111284'), ('194', '333 №1111285'), ('195', '333 №1111286'), ('196', '333 №1111287'), ('197', '333 №1111288'), ('198', '333 №1111289'), ('199', '333 №1111290'), ('200', '333 №1111291'), ('201', '333 №1111292'), ('202', '333 №1111293'), ('203', '333 №1111294'), ('204', '333 №1111295'), ('205', '333 №1111296'), ('206', '333 №1111297'), ('207', '333 №1111298'), ('208', '333 №1111299');
COMMIT;

-- ----------------------------
--  Table structure for `ester_finriski`
-- ----------------------------
DROP TABLE IF EXISTS `ester_finriski`;
CREATE TABLE `ester_finriski` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `familia` varchar(255) NOT NULL,
  `imya` varchar(255) NOT NULL,
  `otchestvo` varchar(255) NOT NULL,
  `dateb` varchar(25) NOT NULL,
  `tel` varchar(30) NOT NULL,
  `seria_pass` varchar(10) NOT NULL,
  `nomer_pass` varchar(50) NOT NULL,
  `vidan_pass` varchar(255) NOT NULL,
  `propiska` varchar(255) NOT NULL,
  `tarif` float NOT NULL,
  `summa` float NOT NULL,
  `summa_pro` varchar(255) NOT NULL,
  `premiya` float NOT NULL,
  `premiya_pro` varchar(255) NOT NULL,
  `insur_from` varchar(100) NOT NULL,
  `insur_to` varchar(100) NOT NULL,
  `userid` int(11) NOT NULL,
  `dogovor` varchar(255) NOT NULL,
  `dog_time` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
delimiter ;;
CREATE TRIGGER `Num_dogovor` AFTER INSERT ON `ester_finriski` FOR EACH ROW Delete from ester_dogovors_finrisk where dogovor in (select dogovor from ester_finriski);
 ;;
delimiter ;

-- ----------------------------
--  Records of `ester_finriski`
-- ----------------------------
BEGIN;
INSERT INTO `ester_finriski` VALUES ('1', '123', '213', '23', '11/06/2014', '12', '213', '213', '21', '3', '2', '23', 'Два рубля 00 копеек', '0.04', 'Ноль рублей 04 копейки', '06/02/2013', '12/06/2013', '14', '', ''), ('2', 'serkin', 'ruslan', 'firefly', '11/06/2014', '9212173', '3234', '122313', 'fire', 'home', '2.5', '400000', 'Четыреста тысяч рублей 00 копеек', '10000', 'Десять тысяч рублей 00 копеек', '06/02/2013', '12/06/2013', '14', '', ''), ('3', 'firefly', 'ruslan', 'fire', '14/05/2013', '99999999', '1111', '22222222', '2222', '2222', '2', '300000', 'Триста тысяч рублей 00 копеек', '6000', 'Шесть тысяч рублей 00 копеек', '01/01/2013', '25/01/2013', '14', '213 №123210', ''), ('4', '654', 'dsfsdf', 'sd', '07/04/2012', 'sd', 'sdf', 'sdf', 'sdf', 'sdf', '2', '344534', 'Триста сорок четыре тысячи пятьсот тридцать четыре рубля 00 копеек', '6890.68', 'Шесть тысяч восемьсот девяносто рублей 68 копеек', '30/01/2013', '12/06/2013', '14', '213 №123210', ''), ('5', 'wqeqwe', 'qweqweqw', 'wq', '17/07/2015', 'q', 'qweqwe', 'qweqweqwe', 'wqe', 'eqe', '2', '324', 'Триста двадцать четыре рубля 00 копеек', '6.48', 'Шесть рублей 48 копеек', '05/06/2013', '28/11/2013', '14', '213 №123211', ''), ('6', 'wqeqwe', 'qweqweqw', 'wq', '17/07/2015', 'q', 'qweqwe', 'qweqweqwe', 'wqe', 'eqe', '2', '324', 'Триста двадцать четыре рубля 00 копеек', '6.48', 'Шесть рублей 48 копеек', '05/06/2013', '28/11/2013', '14', '213 №123212', ''), ('7', 'wqeqwe', 'qweqweqw', 'wq', '17/07/2015', 'q', 'qweqwe', 'qweqweqwe', 'wqe', 'eqe', '2', '324', 'Триста двадцать четыре рубля 00 копеек', '6.48', 'Шесть рублей 48 копеек', '05/06/2013', '28/11/2013', '14', '213 №123213', '23/08/2013'), ('8', 'wqeqwe', 'qweqweqw', 'wq', '17/07/2015', 'q', 'qweqwe', 'qweqweqwe', 'wqe', 'eqe', '2', '324', 'Триста двадцать четыре рубля 00 копеек', '6.48', 'Шесть рублей 48 копеек', '05/06/2013', '28/11/2013', '14', '213 №123214', '23/08/2013'), ('9', 'Иванов ', 'Иван ', 'Иванович', '06/02/1980', '+7-911-911-11-1254', '4567', '456723', 'Питерским отделением милиции № 34 Кировского района  26.01.2004', 'Санкт-Петербург, Пушкин, ул. Главная Дом 5 копрус 4 квартира 34', '2.5', '670000', 'Шестьсот семьдесят тысяч рублей 00 копеек', '16750', 'Шестнадцать тысяч семьсот пятьдесят рублей 00 копеек', '01/01/2013', '31/12/2013', '14', '213 №123215', '23/08/2013'), ('10', 'Иванов ', 'Иван ', 'Иванович', '06/02/1980', '+7-911-911-11-11', '4567', '456723', 'Питерским отделением милиции № 34 Кировского района  26.01.2004', 'Санкт-Петербург, Пушкин, ул. Главная Дом 5 копрус 4 квартира 34', '2.5', '670000', 'Шестьсот семьдесят тысяч рублей 00 копеек', '16750', 'Шестнадцать тысяч семьсот пятьдесят рублей 00 копеек', '01/01/2013', '31/12/2013', '14', '123 № 123123', '23/08/2013'), ('11', 'Иванов 2', 'Иван ', 'Иванович', '06/02/1980', '+7-911-911-11-11', '4567', '456723', 'Питерским отделением милиции № 34 Кировского района  26.01.2004', 'Санкт-Петербург, Пушкин, ул. Главная Дом 5 копрус 4 квартира 34', '2.5', '670000', 'Шестьсот семьдесят тысяч рублей 00 копеек', '16750', 'Шестнадцать тысяч семьсот пятьдесят рублей 00 копеек', '01/01/2013', '31/12/2013', '14', '123 №098908', '23/08/2013'), ('12', '1231232131', '123123123', '1231321231', '04/06/2014', '123123123123', '12313123', '12313131', '123123123123', '2131231231231', '2', '123123', 'Сто двадцать три тысячи сто двадцать три рубля 00 копеек', '2462.46', 'Две тысячи четыреста шестьдесят два рубля 46 копеек', '12/06/2013', '21/06/2013', '9', '333 №111110', '25/08/2013'), ('13', '1231232131', '123123123', '1231321231', '04/06/2014', '123123123123', '12313123', '12313131', '123123123123', '2131231231231', '2', '123123', 'Сто двадцать три тысячи сто двадцать три рубля 00 копеек', '2462.46', 'Две тысячи четыреста шестьдесят два рубля 46 копеек', '12/06/2013', '21/06/2013', '9', '333 №111111', '25/08/2013'), ('14', '324234', '324234', '3242342', '05/02/2010', '234234324', '324234', '324242432', '234234', '324234234', '2', '234234', 'Двести тридцать четыре тысячи двести тридцать четыре рубля 00 копеек', '4684.68', 'Четыре тысячи шестьсот восемьдесят четыре рубля 68 копеек', '01/01/2013', '01/02/2013', '9', '333 №1111110', '25/08/2013'), ('15', '324', '324234', '324234234', '04/03/2011', '7688768768768', '7868686', '678678', '678678', '67867867', '2', '678687', 'Шестьсот семьдесят восемь тысяч шестьсот восемьдесят семь рублей 00 копеек', '13573.7', 'Тринадцать тысяч пятьсот семьдесят три рубля 74 копейки', '03/01/2013', '08/02/2013', '9', '333 №1111111', '25/08/2013'), ('16', '324', '324234', '324234234', '04/03/2011', '7688768768768', '7868686', '678678', '678678', '67867867', '2', '678687', 'Шестьсот семьдесят восемь тысяч шестьсот восемьдесят семь рублей 00 копеек', '13573.7', 'Тринадцать тысяч пятьсот семьдесят три рубля 74 копейки', '03/01/2013', '08/02/2013', '9', '333 №1111112', '25/08/2013'), ('17', 'sdfds', 'dsfsdfsd', 'dsfsdfsdf', '17/07/2015', 'dsfdsfd', 'dfsfdsf', 'dsfsfsf', 'dsfdsfd', 'dsfsdf', '2', '3434230', 'Три миллиона четыреста тридцать четыре тысячи двести тридцать четыре рубля 00 копеек', '68684.7', 'Шестьдесят восемь тысяч шестьсот восемьдесят четыре рубля 68 копеек', '30/01/2013', '15/02/2013', '9', '333 №1111113', '25/08/2013'), ('18', 'sdfds', 'dsfsdfsd', 'dsfsdfsdf', '17/07/2015', 'dsfdsfd', 'dfsfdsf', 'dsfsfsf', 'dsfdsfd', 'dsfsdf', '2', '3434230', 'Три миллиона четыреста тридцать четыре тысячи двести тридцать четыре рубля 00 копеек', '68684.7', 'Шестьдесят восемь тысяч шестьсот восемьдесят четыре рубля 68 копеек', '30/01/2013', '15/02/2013', '9', '333 №1111114', '25/08/2013'), ('19', 'Serkin', 'Ruslan', '324234', '01/08/2012', '34234234', '3424234', 'Ruslan Serkin', '2342342', 'Кантемировская улица 3', '2', '32432400', 'Тридцать два миллиона четыреста тридцать две тысячи четыреста двадцать четыре рубля 00 копеек', '648648', 'Шестьсот сорок восемь тысяч шестьсот сорок восемь рублей 48 копеек', '09/01/2013', '06/02/2013', '9', '333 №1111115', '25/08/2013'), ('20', 'Serkin', 'Ruslan', '324234', '01/08/2012', '34234234', '3424234', 'Ruslan Serkin', '2342342', 'Кантемировская улица 3', '2', '32432400', 'Тридцать два миллиона четыреста тридцать две тысячи четыреста двадцать четыре рубля 00 копеек', '648648', 'Шестьсот сорок восемь тысяч шестьсот сорок восемь рублей 48 копеек', '09/01/2013', '06/02/2013', '9', '333 №1111116', '25/08/2013'), ('21', 'Serkin', 'Ruslan', '324234', '01/08/2012', '34234234', '3424234', 'Ruslan Serkin', '2342342', 'Кантемировская улица 3', '2', '32432400', 'Тридцать два миллиона четыреста тридцать две тысячи четыреста двадцать четыре рубля 00 копеек', '648648', 'Шестьсот сорок восемь тысяч шестьсот сорок восемь рублей 48 копеек', '09/01/2013', '06/02/2013', '9', '333 №1111117', '25/08/2013'), ('22', 'Serkin', 'Ruslan', '324234', '01/08/2012', '34234234', '3424234', 'Ruslan Serkin', '2342342', 'Кантемировская улица 3', '2', '32432400', 'Тридцать два миллиона четыреста тридцать две тысячи четыреста двадцать четыре рубля 00 копеек', '648648', 'Шестьсот сорок восемь тысяч шестьсот сорок восемь рублей 48 копеек', '09/01/2013', '06/02/2013', '9', '333 №1111118', '25/08/2013'), ('23', 'Serkin', 'Ruslan', '324234', '01/03/2011', '234324', '324234', 'Ruslan Serkin', '3424234243', 'Кантемировская улица 3', '2', '243234', 'Двести сорок три тысячи двести тридцать четыре рубля 00 копеек', '4864.68', 'Четыре тысячи восемьсот шестьдесят четыре рубля 68 копеек', '01/01/2013', '12/07/2013', '9', '333 №1111119', '25/08/2013'), ('24', 'Serkin', 'Ruslan', '324234', '01/03/2011', '234324', '324234', 'Ruslan Serkin', '3424234243', 'Кантемировская улица 3', '2', '243234', 'Двести сорок три тысячи двести тридцать четыре рубля 00 копеек', '4864.68', 'Четыре тысячи восемьсот шестьдесят четыре рубля 68 копеек', '01/01/2013', '12/07/2013', '9', '333 №111112', '25/08/2013'), ('25', 'Serkin', 'Ruslan', '324234', '01/03/2011', '234324', '324234', 'Ruslan Serkin', '3424234243', 'Кантемировская улица 3', '2', '243234', 'Двести сорок три тысячи двести тридцать четыре рубля 00 копеек', '4864.68', 'Четыре тысячи восемьсот шестьдесят четыре рубля 68 копеек', '01/01/2013', '12/07/2013', '9', '333 №1111120', '25/08/2013'), ('26', '', 'test', 'test', '18/06/2015', '343434344', '5677', '644646465', 'ghghfghff', 'bvhhfghfghf', '2', '300000', 'Триста тысяч рублей 00 копеек', '6000', 'Шесть тысяч рублей 00 копеек', '04/01/2013', '09/01/2013', '9', '333 №1111121', '25/08/2013');
COMMIT;

-- ----------------------------
--  Table structure for `ester_rolename`
-- ----------------------------
DROP TABLE IF EXISTS `ester_rolename`;
CREATE TABLE `ester_rolename` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rolename` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `role` (`rolename`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `ester_rolename`
-- ----------------------------
BEGIN;
INSERT INTO `ester_rolename` VALUES ('2', 'Админ'), ('4', 'Брокер'), ('3', 'Менеджер'), ('1', 'СуперАдмин'), ('5', 'Фин. Брокер'), ('6', 'Агент');
COMMIT;

-- ----------------------------
--  Table structure for `ester_users`
-- ----------------------------
DROP TABLE IF EXISTS `ester_users`;
CREATE TABLE `ester_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'уникальный айдишник',
  `username` varchar(150) NOT NULL,
  `firstname` varchar(150) DEFAULT NULL,
  `secondname` varchar(150) DEFAULT NULL,
  `token` varchar(255) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `role` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `dogovor` varchar(100) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING HASH,
  UNIQUE KEY `username` (`username`) USING HASH,
  KEY `role` (`role`),
  KEY `city` (`city`),
  FULLTEXT KEY `firstname` (`firstname`),
  FULLTEXT KEY `secondname` (`secondname`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `ester_users`
-- ----------------------------
BEGIN;
INSERT INTO `ester_users` VALUES ('9', 'ruslanfirefly', 'Ruslan', 'Serkin26', '35f4a8d465e6e1edc05f3d8ab658c551', '1', '1', '1', 'superdogovor4', 'ruslan.ru@gmail.com'), ('3', 'fireflyuser', 'fire', 'fly', '8f14e45fceea167a5a36dedd4bea2543', '1', '2', '1', '', 'test@test.ru'), ('14', 'firefly1', '', '', '6512bd43d9caa6e02c990b0a82652dca', '1', '1', '1', '', 'f@DFSD.ER'), ('8', 'testtest', 'firefly', 'firefly12', 'c20ad4d76fe97759aa27a0c99bff6710', '1', '4', '2', '999', 'etst@fure.ru'), ('13', 'goagoagoa', 'goa', 'goa', '67c6a1e7ce56d3d6fa748ab6d9af3fd7', '1', '1', '1', 'goa', 'goa@goa.ru'), ('10', 'watermark', 'Ruslan', 'Serkin', 'f45a1078feb35de77d26b3f7a52ef502', '1', '2', '1', '', 'ruslan.ru@gmail.com'), ('15', 'estertest', 'Ester', 'Test', '3b70862082788390db556bdc20602f29', '1', '1', '1', '333', 'test@test.ru'), ('16', 'baltikabaltika', 'Иван', 'Иванов', '8f14e45fceea167a5a36dedd4bea2543', '1', '4', '1', '01/09/2013-sp', 'baltika@mail.ru');
COMMIT;


-- ----------------------------
--  Table structure for `ester_users`
-- ----------------------------
DROP TABLE IF EXISTS `ester_subordinate_users`;
CREATE TABLE `ester_subordinate_users` (
	`user_id` int(11) NOT NULL,
	`subordinate_user_id` int(11) NOT NULL,
	PRIMARY KEY(`user_id`, `subordinate_user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Function structure for `saveDogovor`
-- ----------------------------
DROP FUNCTION IF EXISTS `saveDogovor`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `saveDogovor`(familia1 varchar(255), imya1 varchar(255), otchestvo1 varchar(255), dateb1 varchar(25), tel1 varchar(30), seria_pass1 varchar(10), nomer_pass1 varchar(50), vidan_pass1 varchar(255), propiska1 varchar(255), tarif1 float, summa1 float, summa_pro1 varchar(255), premiya1 float, premiya_pro1 varchar(255), insur_from1 varchar(100), insur_to1 varchar(100), userid1 int(11), dogovor1 varchar(255), dog_time1 varchar(25)) RETURNS bigint(20)
    MODIFIES SQL DATA
    DETERMINISTIC
BEGIN

	INSERT INTO  ester_finriski SET familia=familia, 
		imya=imya1, 
		otchestvo=otchestvo1, 
		dateb=dateb1, 
		tel=tel1, 
		seria_pass=seria_pass1,
		nomer_pass=nomer_pass1, 
		vidan_pass=vidan_pass1, 
		propiska=propiska1, 
		tarif=tarif1, 
		summa=summa1, 
		summa_pro=summa_pro1, 
		premiya=premiya1, 
		premiya_pro=premiya_pro1, 
		insur_from=insur_from1, 
		insur_to=insur_to1, 
		userid=userid1, 
		dogovor=dogovor1, 
		dog_time=dog_time1;
		
	RETURN LAST_INSERT_ID();

END
 ;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
