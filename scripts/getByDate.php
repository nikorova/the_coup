<?php

function mysqlDate($dateString) {
	return $mysqlDate = date('Y-m-d', strtotime($dateString));
}

function getByDate($date) {
	require_once("conn.php");

	$sql = "SELECT id, title, description, pub_date, event_date," 
	   . "image_path FROM `events` WHERE event_date=:date;";

	try {
		$sth = $dbh->prepare($sql);

		$sth->bindValue(":date", mysqlDate($date));

		$results = array(); 

		$sth->execute();
	} catch (PDOException $e) {
		echo "select by date failed: " . $e->getMessage();
	}

	$results = $sth->fetchAll(PDO::FETCH_ASSOC);
	$dbh = null;

	return $results; 
}

$query = $_GET["date"];

$response = getByDate($query);
header("Content-Type: text/json");
echo json_encode($response);
exit();

