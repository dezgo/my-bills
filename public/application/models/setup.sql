DROP TABLE IF EXISTS `membership1`;

CREATE TABLE `membership1` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `first_name` varchar(25) NOT NULL,
 `last_name` varchar(25) NOT NULL,
 `username` varchar(25) NOT NULL,
 `password` varchar(32) NOT NULL,
 `email_address` varchar(50) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `accounts1`;

CREATE TABLE `accounts1` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `account` varchar(50) NOT NULL,
 `last_due` date NOT NULL,
 `times_per_year` int(11) NOT NULL,
 `amount` decimal(10,2) NOT NULL,
 `autopay` tinyint(1) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;



