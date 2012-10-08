<?php

require_once("conn.php");

function mysqlDate($dateString) {
	return $mysqlDate = date('Y-m-d', strtotime($dateString));
}

function getByDate($dbh, $date) {

	$sql = "SELECT id, title, description, pub_date, event_date," 
	   . "image_path FROM `events` WHERE pub_date=:date;";

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

$result= getByDate($dbh, $query);

$resp = [];
foreach ($result as $item) {
	$item["image_path"] = 'scripts/get_event.php?id=' . $item["id"];
	$resp[] = $item;
}
header("Content-Type: text/json");

echo json_encode($resp);
exit();

