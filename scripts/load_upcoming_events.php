<?php
function selectAllEvents() {
	include 'conn.php'; 

	$sql = "SELECT title, description, pub_date, event_date, image_path FROM $mysqlEventsTable ";

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

function createShortDescriptions($queryResults, $shortLength = 24) {
	$events = array();
	foreach ($queryResults as $event) {
		$shortDesc = null;	
		$descWords = explode(' ', $event["description"]);
		
		if ($shortLength < count($descWords)) {
			for ($i = 0; $i < $shortLength; $i++) {
				$shortDesc .= $descWords[$i] . ' ';
			}
			$shortDesc .= $descWords[$shortLength] . '...';
		} else {
			$shortDesc = $event["description"];
		}

		$event["short_description"] = $shortDesc;	
		$events[] = $event;
	}

	return $events;
}

function generateMarkupFromEvents($events) {
	$eventsMarkup = array();
	foreach ($events as $event) { 
		$name = $event["title"];
		$pubDate = $event["pub_date"];
		$eventDate = $event["event_date"];
		$imagePath = "uploads/" . basename($event["image_path"]);
		$shortDesc = $event["short_description"];

		$markup = "<a href=\"#\">"
			. "<li class=\"event\">"
		    .	  "<p class=\"e_name\"> $name"
			.		  "<span class=\"dates\">"
			.			  "<span class=\"p_date\"> $pubDate </span>"
			.			  "<span class=\"e_date\"> $eventDate </span>"
			.		  "</span>"
			.	  "</p>" 
			.	  "<img class=\"e_image\" src=\"$imagePath\" ></img>"
			.	  "<p class=\"desc\"> $shortDesc </p>"
			. "</li>"
			. "</a>";

		$eventsMarkup[] = $markup;
	}

	return $eventsMarkup;
}
