DROP TABLE IF EXISTS `membership`;

CREATE TABLE `membership` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `first_name` varchar(25) NOT NULL,
 `last_name` varchar(25) NOT NULL,
 `password` varchar(32) NOT NULL,
 `email_address` varchar(50) NOT NULL,
 `update_date` datetime,
 `create_date` datetime,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

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
 `times_per_year` int(11) NOT NULL,
 `amount` decimal(10,2) NOT NULL,
 `autopay` tinyint(1) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;
