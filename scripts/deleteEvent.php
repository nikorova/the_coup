<?php


function deleteEvent($eventID) {
require_once('conn.php');
	$sql = "DELETE FROM `events` where id=:id";

	try {
		$sth = $dbh->prepare($sql);
		$sth->execute(array(":id" => $eventID));
	} catch (PDOException $e) {
		echo "delete from db failed: " . $e->getMessage();
	}

	$dbh = null;

	return array('result' => 'successfully deleted event '. $eventID);
}

$res = deleteEvent(htmlspecialchars($_GET["id"]));

header('Content-Type: text/json');
echo json_encode($res);
