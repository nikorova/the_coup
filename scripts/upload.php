<?php
if (isset(_POST)) {
	$event = array (
	"title" => _POST["title"],
	"description" => _POST["description"], 
	"pub_date" => _POST["pub_date"], 
	"image" => _POST["image"]
	);

	foreach ($event as $k => $v) {
		echo "User uploaded:\n";
		echo "$k\t\t\t$v";	
	}
}

echo 
?>
