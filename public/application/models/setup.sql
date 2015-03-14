DROP TABLE IF EXISTS `membership`;

CREATE TABLE `membership` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `first_name` varchar(25) NOT NULL,
 `last_name` varchar(25) NOT NULL,
 `username` varchar(25) NOT NULL,
 `password` varchar(32) NOT NULL,
 `email_address` varchar(50) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `accounts`;

CREATE TABLE `accounts` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `account` varchar(50) NOT NULL,
 `last_due` date NOT NULL,
 `times_per_year` int(11) NOT NULL,
 `amount` decimal(10,2) NOT NULL,
 `autopay` tinyint(1) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

INSERT INTO `membership` (`first_name`, `last_name`, `username`, `password`, `email_address`) VALUES ('Derek', 'Gillett', 'dezgo', '5f4dcc3b5aa765d61d8327deb882cf99', 'mybills@derekgillett.com');

INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Weston Water', '2015-01-06', '4', '596.97');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Domain - derekgillet.com', '2014-04-08', '1', '12');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Weston Electricity', '2015-01-08', '4', '435.34');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Piano Lessons - Ash', '2015-03-10', '12', '177');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Boddington Water & Sewage', '2015-01-12', '4', '445.96');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Boddington Electricity', '2015-01-13', '4', '430.87');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Boddington Gas', '2015-01-13', '4', '80.18');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'eBay fees - my favourite hobby', '2015-03-15', '12', '0');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Broad Pl Water', '2015-01-15', '4', '397.3');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'John McGrath Ford Territory Service', '2014-10-22', '2', '300');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Echo Registration', '2014-04-26', '1', '832.1');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Warner Rates', '2015-02-02', '4', '428.91');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Carbonite Backup - Adri', '2013-05-07', '0.5', '60');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Income Protection Insurance', '2014-05-27', '1', '1878.76');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Mackillop Fees', '2015-03-06', '4', '2468.8');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Territory Registration', '2014-06-07', '1', '1039.3');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Warner Water', '2015-03-15', '4', '441.79');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Broad Pl Land Tax', '2015-03-15', '4', '614.15');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Weston Land Tax', '2015-03-15', '4', '776.4');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Domain - CreativzDesign.com', '2014-06-27', '1', '12');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Echo Service', '2014-12-31', '2', '300');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Lastpass', '2014-07-06', '1', '12.99');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Boddington Building Insurance', '2014-07-06', '1', '915.64');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Boddington Contents Insurance', '2014-08-03', '1', '371.1');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Weston Insurance', '2014-08-06', '1', '830.42');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Warner Insurance', '2014-08-07', '1', '1062.07');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Extra recycling bin', '2014-08-10', '1', '70');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Evernote', '2014-08-26', '1', '50');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Broad Pl Building Insurance', '2014-08-26', '1', '814.26');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Boddington Rates', '2014-09-15', '1', '1545.16');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Broad Pl Rates', '2014-09-15', '1', '1614.44');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Weston Rates', '2014-09-15', '1', '1820.72');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Domain - computerwhiz.com.au', '2013-10-13', '0.5', '24');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Carbonite Backup - Derek', '2015-01-04', '1', '60');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'NRMA Territory Insurance', '2015-02-19', '1', '226');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'NRMA Echo Insurance', '2015-02-19', '1', '182');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'NRMA Membership', '2015-03-03', '1', '89');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Domain - ashleydgillett.com', '2015-03-10', '1', '9.99');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Domain - cassidygillett.com', '2015-03-10', '1', '9.99');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Domain - sabrinagillett.com', '2015-03-10', '1', '9.99');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Domain - ashgillett.com', '2015-03-12', '1', '12');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Domain - adrianagillett.com', '2014-11-21', '0.5', '15.98');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Adri Driver\'s License', '2012-05-02', '0.2', '165');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Derek Driver\'s License', '2014-10-29', '0.2', '167.1');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Domain - derekgillett.com', '2012-11-10', '0.1', '50');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'iiNet', '2015-02-20', '12', '52.78');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'HCF', '2015-02-13', '12', '269.65');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Mobile - Adri', '2015-02-19', '12', '35');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Tae Kwon Do', '2015-03-02', '12', '70');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Orana Fees', '2015-02-12', '12', '669');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Childfund', '2015-02-13', '12', '45');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Worldvision', '2015-02-19', '12', '48');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'CW Phone', '2015-02-22', '12', '10.05');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Mobile - Derek', '1900-01-00', '12', '');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Mobile -Sabri', '1900-01-00', '1', '');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'Followup Then', '2014-04-09', '1', '26');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'TPG - Derek', '2015-02-17', '12', '19.99');
INSERT INTO `accounts` (`id`, `account`, `last_due`, `times_per_year`, `amount`) VALUES (NULL, 'TPG - Adri', '2015-03-05', '12', '24.99');