DROP TABLE IF EXISTS `membership`;

CREATE TABLE `membership` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `first_name` varchar(25) NULL,
 `last_name` varchar(25) NULL,
 `password` varchar(32) NOT NULL,
 `email_address` varchar(50) NOT NULL,
 `update_date` datetime,
 `create_date` datetime,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

DELIMITER |
CREATE TRIGGER trigger_membershipDatetimeInsert BEFORE INSERT ON `membership` FOR EACH ROW 
BEGIN
    SET NEW.create_date = NOW();
END; 
|
CREATE TRIGGER trigger_membershipDatetimeModify BEFORE UPDATE ON `membership` FOR EACH ROW 
BEGIN 
    SET NEW.update_date = NOW();
END; 
|
DELIMITER ;

DROP TABLE IF EXISTS `accounts`;

CREATE TABLE `accounts` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `member_id` int(11) NOT NULL,
 `account` varchar(50) NOT NULL,
 `last_due` date NOT NULL,
 `times_per_year` decimal(5,2) NOT NULL,
 `amount` decimal(10,2) NOT NULL,
 `autopay` tinyint(1) NOT NULL DEFAULT 0,
 `update_date` datetime,
 `create_date` datetime,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

DELIMITER |
CREATE TRIGGER trigger_accountsDatetimeInsert BEFORE INSERT ON `accounts` FOR EACH ROW 
BEGIN
    SET NEW.create_date = NOW();
END; 
|
CREATE TRIGGER trigger_accountsDatetimeModify BEFORE UPDATE ON `accounts` FOR EACH ROW 
BEGIN 
    SET NEW.update_date = NOW();
END; 
|
DELIMITER ;

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
 `member_id` int(11) NOT NULL,
 `setting_name` varchar(50) NOT NULL,
 `setting_value` varchar(50) NOT NULL,
 `update_date` datetime,
 `create_date` datetime,
 PRIMARY KEY (`member_id`, `setting_name`)
 ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DELIMITER |
CREATE TRIGGER trigger_settingsDatetimeInsert BEFORE INSERT ON `settings` FOR EACH ROW 
BEGIN
    SET NEW.create_date = NOW();
END; 
|
CREATE TRIGGER trigger_settingsDatetimeModify BEFORE UPDATE ON `settings` FOR EACH ROW 
BEGIN 
    SET NEW.update_date = NOW();
END; 
|
DELIMITER ;

DROP TABLE IF EXISTS `payments`;
 
CREATE TABLE `payments` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `member_id` int(11) NOT NULL,
 `account` varchar(50) NOT NULL,
 `payment_date` datetime,
 `amount` decimal(10,2) NOT NULL,
 `update_date` datetime,
 `create_date` datetime,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

DELIMITER |
CREATE TRIGGER trigger_paymentsDatetimeInsert BEFORE INSERT ON `payments` FOR EACH ROW 
BEGIN
    SET NEW.create_date = NOW();
END; 
|
CREATE TRIGGER trigger_paymentsDatetimeModify BEFORE UPDATE ON `payments` FOR EACH ROW 
BEGIN 
    SET NEW.update_date = NOW();
END; 
|
DELIMITER ;

DROP TABLE IF EXISTS `account_tags`;
 
CREATE TABLE `account_tags` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `account_id` int(11) NOT NULL,
 `tagname` varchar(50) NOT NULL,
 `update_date` datetime,
 `create_date` datetime,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

DELIMITER |
CREATE TRIGGER trigger_account_tagsDatetimeInsert BEFORE INSERT ON `account_tags` FOR EACH ROW 
BEGIN
    SET NEW.create_date = NOW();
END; 
|
CREATE TRIGGER trigger_account_tagsDatetimeModify BEFORE UPDATE ON `account_tags` FOR EACH ROW 
BEGIN 
    SET NEW.update_date = NOW();
END; 
|
DELIMITER ;

DROP TABLE IF EXISTS `payment_tags`;
 
CREATE TABLE `payment_tags` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `payment_id` int(11) NOT NULL,
 `tagname` varchar(50) NOT NULL,
 `update_date` datetime,
 `create_date` datetime,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

DELIMITER |
CREATE TRIGGER trigger_payment_tagsDatetimeInsert BEFORE INSERT ON `payment_tags` FOR EACH ROW 
BEGIN
    SET NEW.create_date = NOW();
END; 
|
CREATE TRIGGER trigger_payment_tagsDatetimeModify BEFORE UPDATE ON `payment_tags` FOR EACH ROW 
BEGIN 
    SET NEW.update_date = NOW();
END; 
|
DELIMITER ;

DROP TABLE IF EXISTS `timezones`;

CREATE TABLE `timezones` (
 `offset` decimal(3,1) NOT NULL,
 `timezone` varchar(4) NOT NULL,
 PRIMARY KEY (`offset`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `timezones` VALUES (-12,'UM12');
INSERT INTO `timezones` VALUES (-11,'UM11');
INSERT INTO `timezones` VALUES (-10,'UM10');
INSERT INTO `timezones` VALUES (-9,'UM9');
INSERT INTO `timezones` VALUES (-8,'UM8');
INSERT INTO `timezones` VALUES (-7,'UM7');
INSERT INTO `timezones` VALUES (-6,'UM6');
INSERT INTO `timezones` VALUES (-5,'UM5');
INSERT INTO `timezones` VALUES (-4,'UM4');
INSERT INTO `timezones` VALUES (-3.5,'UM25');
INSERT INTO `timezones` VALUES (-3,'UM3');
INSERT INTO `timezones` VALUES (-2,'UM2');
INSERT INTO `timezones` VALUES (-1,'UM1');
INSERT INTO `timezones` VALUES (0,'UTC');
INSERT INTO `timezones` VALUES (1,'UP1');
INSERT INTO `timezones` VALUES (2,'UP2');
INSERT INTO `timezones` VALUES (3,'UP3');
INSERT INTO `timezones` VALUES (3.5,'UP25');
INSERT INTO `timezones` VALUES (4,'UP4');
INSERT INTO `timezones` VALUES (4.5,'UP35');
INSERT INTO `timezones` VALUES (5,'UP5');
INSERT INTO `timezones` VALUES (5.5,'UP45');
INSERT INTO `timezones` VALUES (6,'UP6');
INSERT INTO `timezones` VALUES (7,'UP7');
INSERT INTO `timezones` VALUES (8,'UP8');
INSERT INTO `timezones` VALUES (9,'UP9');
INSERT INTO `timezones` VALUES (9.5,'UP85');
INSERT INTO `timezones` VALUES (10,'UP10');
INSERT INTO `timezones` VALUES (11,'UP11');
INSERT INTO `timezones` VALUES (12,'UP12');

 