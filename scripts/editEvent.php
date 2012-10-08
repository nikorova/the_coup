<?php
require_once('conn.php');
function editEvent($dbh, $eventArr) {
	$sql = "UPDATE `events` SET " 
		. "title=:title "
		. "description=:description "
		. "pub_date=:pub_date "
		. "event_date=:event_date "
		. "WHERE id=:id";


	try {
		$sth = $dbh->prepare($sql);
		$sth->execute($eventArr);
		echo "event updated!";
	} catch (PDOException $e) {
		echo "update failed: " . $e->getMessage();
	}

	$dbh = null;
}

$pData = $_POST['data'];
$pArr = array();

foreach ($pData as $k => $v) {
	$pArr[':'.$k] = $v;
}

echo editEvent($dbh, $pArr);

