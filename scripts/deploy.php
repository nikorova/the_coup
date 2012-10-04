<?php
$mysqlHost			= 'db.coupclarksville.com';
$mysqlDB			= 'dbcoupclarksville';
$mysqlEventsTable	= 'events';
$mysqlUser			= 'thecoupdb';
$mysqlPass			= '^peJezPF';

try {
	$dbh = new PDO("mysql:host=$mysqlHost;dbname=$mysqlDB", $mysqlUser, $mysqlPass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo "db connection failed: " . $e->getMessage();	
}

$sql = "CREATE TABLE IF NOT EXISTS `dbcoupclarksville`.`events` ("
	. "`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,"
	. "`title` varchar(255) NOT NULL,"
	. "`description` text NOT NULL,"
	. "`pub_date` date NOT NULL,"
	. "`event_date` date NOT NULL,"
	. "`image_name` varchar(255) NOT NULL,"
	. "`image_size` int(11) NOT NULL,"
	. "`image_mime_type` varchar(255) NOT NULL,"
	. "`image_path` varchar(255) NOT NULL,"
	. "PRIMARY KEY (`id`),"
	. "KEY `pub_date` (`pub_date`)"
	.") ENGINE=MyISAM AUTO_INCREMENT=142 DEFAULT CHARSET=utf8$$";

try {
	$sth = $dbh->prepare($sql);
	$sth->execute();
} catch (PDOException $e) {
	echo "create table failed: " . $e->getMessage();
}

$dhb = null;
echo "create `events` table great success!";
exit();

