<?php

phpinfo();
$image = array (
	"img_size" => "1024x768",
	"img_name" => "bob.jpg",
	"img_mime" => "jpg",
);

$vals = array_values($image);
$keys = array_keys($image);

echo $vals;
