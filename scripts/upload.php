<?php

require_once("params.ini.php");
require_once("conn.php");

function mysqlDate($dateString) {
		return $mysqlDate = date('Y-m-d', strtotime($dateString));
}

/*** 
 * @Return assoc array of event params
 */
function createEventFromPost() {
	if (isset($_POST, $_FILES)) {
		return array(
			"title" 			=> $_POST["title"],	
			"description" 		=> $_POST["description"],
			"pub_date" 			=> mysqlDate($_POST["pub_date"]),
			"event_date"		=> mysqlDate($_POST["event_date"]),
			"image_name"		=> $_FILES["files"]["name"][0],
			"image_tmp_name"	=> $_FILES["files"]["tmp_name"][0],
			"image_size"		=> $_FILES["files"]["size"][0],
			"image_type"		=> $_FILES["files"]["type"][0],
			"image_err"			=> $_FILES["files"]["error"][0],
		);
	} else {
		echo "retrieval of post data failed";
		exit;
	}
}

/*** 
 * @param Array $event
 * @param string $imagePath
 * @return Array $row as assoc array of placeholders => event vals 
 */
function createRowFromEvent($event, $imagePath) {
	return $row = array (
			":title" 			=> $event["title"],	
			":description" 		=> $event["description"],
			":pub_date"			=> $event["pub_date"],
			":event_date"		=> $event["event_date"],
			":image_name"		=> $event["image_name"],
			":image_size"		=> $event["image_size"],
			":image_mime_type" 	=> $event["image_type"],
			":image_path"		=> $imagePath,
		);
}

/* 
 * gen and exec sql insert query 
 */
function execSQLInsert($dbh, $data, $table='events') {
	$fields = "title, description, pub_date, event_date, image_name, "
		. "image_size, image_mime_type, image_path";

	$placeHolders =	":title, :description, :pub_date, :event_date, "
		. ":image_name, :image_size, :image_mime_type, :image_path";	

	$sql = "INSERT INTO $table ($fields) VALUES ($placeHolders)";


	try {
		$sth = $dbh->prepare($sql);
		$rowsInserted = $sth->execute($data);
	} catch (PDOException $e) {
		echo "insert failed: ". $e->getMessage();
		exit;
	}		
}

require_once("conn.php");


/* 
 * create new event from post data 
 */

$event = createEventFromPost();

/*
 * upload and image validation code 
 */ 
if ($event["image_err"] != 0) {
	echo "\nimage upload error: " . $event["image_err"];
	exit;
}

if (!is_uploaded_file($event["image_tmp_name"])) {
	echo "file in question was not actually uploaded? (how does that even happen?)";
	exit;
}

$imagePath = $imageUploadDir . "/" . basename($event["image_name"]); 


if (move_uploaded_file($event["image_tmp_name"], $imagePath)) {
	$row = createRowFromEvent($event, $imagePath);	
	execSQLInsert($dbh, $row);

	$getPath= "scripts/get_event.php/?id=" . $dbh->lastInsertId() ;

	echo json_encode(array(
		"id"			=> $dbh->lastInsertId(),
		"title" 		=> $event["title"],
		"description" 	=> $event["description"],
		"pub_date"		=> $event["pub_date"],
		"event_date"	=> $event["event_date"],
		"image_path"	=> $getPath,
		));
} else {
	echo "commit file to filesystem failed! file upload attack?! nazis!? mules!?";
	exit;
}
?>
