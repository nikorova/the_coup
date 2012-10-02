<?php
require_once("conn.php");
function getEvent($dbh, $eventID) {
	$sql = "SELECT id, title, description, pub_date, event_date, image_mime_type, image_path FROM events where id=:id";

	try {
		$sth = $dbh->prepare($sql);
		$sth->execute(array(":id" => $eventID));	
		$results =  array();
	} catch (PDOException $e) {
		echo "select from db failed: ". $e->getMessage();
	}

	$results = $sth->fetch(PDO::FETCH_ASSOC);

	$dbh = null;

	return $results;
}

$id = htmlspecialchars($_GET["id"]);

$event = getEvent($dbh, $id);

$fd = fopen($event["image_path"], 'rb');

header("Content-Type: " . $event["image_mime_type"]);
header("Content-Length: " . filesize($event["image_path"]));

fpassthru($fd);

exit;



