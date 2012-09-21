<?php
	require_once('params.ini.php');
	try {
		$dbh = new PDO("mysql:host=$mysqlHost;dbname=$mysqlDB", 
			$mysqlUser, $mysqlPass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	} catch (PDOException $e) {
		echo "db connection failed: " . $e->getMessage();
	}
