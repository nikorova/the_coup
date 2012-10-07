<?php
require_once('conn.php');
function editEvent($dbh, $eventObj) {
	$sql = "UPDATE `events` SET " 
		. "title=:title "
		. "description=:description "
		. "pub_date=:pub_date "
		. "event_date=:event_date "
		. "WHERE id=:id";


	try {
		$sth = $dbh->prepare($sql);
		$sth->execute($eventData);
	} catch (PDOException $e) {
		echo "update failed: " . $e->getMessage();
	}

	$dbh = null;
}

foreach ($_POST as $k => $v) {
	echo "$k and $v<br />";
}

