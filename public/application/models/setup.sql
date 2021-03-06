DROP TABLE IF EXISTS `activity_audit`;

CREATE TABLE `activity_audit` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `member_id` int(11) NULL,
 `activity_date` datetime,
 `activity_type` varchar(20),
 `remote_addr` varchar(40),
 `notes` varchar(256),
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1; 
 
DELIMITER |
CREATE TRIGGER trigger_activity_auditDatetimeInsert BEFORE INSERT ON `activity_audit` FOR EACH ROW 
BEGIN
    SET NEW.activity_date = NOW();
END; 
|
DELIMITER ;

DROP TABLE IF EXISTS `membership`;

CREATE TABLE `membership` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `first_name` varchar(25) NULL,
 `last_name` varchar(25) NULL,
 `params` varchar(256) NOT NULL,
 `email_address` varchar(50) NOT NULL,
 `retrieve_token` varchar(40) NULL,
 `retrieve_expiration` datetime NULL,
 `google_auth_secret` varchar(16) NULL,
 `premium` tinyint(1) NOT NULL DEFAULT 0,
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


 