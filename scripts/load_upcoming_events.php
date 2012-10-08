<?php
function selectAllEvents() {
	include 'conn.php'; 

	$sql = "SELECT id, title, description, pub_date, event_date, image_path FROM $mysqlEventsTable  ORDER BY event_date";

	try {
		$sth = $dbh->prepare($sql);
		$results = array();
		$sth->execute();
	} catch (PDOException $e) {
		echo "select from db failed: " . $e->getMessage();
	}

	$results= $sth->fetchAll(PDO::FETCH_ASSOC);
	$dbh = null;

	return $results;
} 

$res = selectAllEvents();
echo json_encode($res);
