<?php

require_once("conn.php");

function getEvent($dbh, $evnentID) {
	$sql = "SELECT id, title, description, pub_date, event_date, image_path FROM $mysqlEventsTable";

	try {
		$sth = $dbh->prepare($sql);
		$sth->execute();	
		$results =  array();
	} catch (PDOException $e) {
		echo "select from db failed: ". $e->getMesage();
	}

	$results = $sth->fetchAll(PDO::FETCH_ASSOC);
	$dbh = null;

	return $results;
}

$docRoot = $_SERVER["DOCUMENT_ROOT"];
echo $imageUploadDir;





