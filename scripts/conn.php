<?php
$db = mysql_connect('localhost', 'coupCal', 'coupCalPass');

if (!$db) {
	echo "Error: unable to connect to database server.";
	exit;
}

if (!mysql_select_db('coupCal', $db)) {
	echo "Error: unable to select database.";
	exit;
}
