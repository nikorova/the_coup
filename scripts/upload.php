<?php

if (isset($_POST)) {
	$event = array(
		"title" 			=> $_POST["title"],	
		"description" 		=> $_POST["description"],
		"pub_date" 			=> $_POST["pub_date"],
		"image_name"		=> $_FILES["image"]["name"],
		"image_tmp_name"	=> $_FILES["image"]["tmp_name"],
		"image_size"		=> $_FILES["image"]["size"],
		"image_type"		=> $_FILES["image"]["type"],
		"image_err"			=> $_FILES["image"]["error"],
	);
}

echo "User uploaded:\n";
foreach ($event as $k => $v) {
	echo "$k:\t\t\t\"$v\"\n";	
}

$upload_dir = '/var/www/localhost/the_coup/uploads/';
$image_file = $upload_dir . basename($event["image_name"]);

if (!is_uploaded_file()) {
	echo "file in question was not actually uploaded? (how does that even happen?)";
	exit;
}

$isImage = getImageSize($event["image"]["tmp_name"]);

if (!$isImage) {
	echo "uploaded file is not an image, yo";
	exit;
}
	
if (move_uploaded_file($event["image_tmp_name"], $image_file)) {
	echo "ok! file uploaded!";
} else {
	echo "file validation failed! file upload attack?! nazis!? mules!?";
}


?>
