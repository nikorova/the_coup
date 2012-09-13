<?php
require_once('conn.php');
//
// val upload and return or throw exception
function validateUpload($err_code) {
	if ($err_code == UPLOAD_ERR_OK) {
		return;
	} else {
		switch ($err_code) {
		case UPLOAD_ERR_INI_SIZE:
			$msg = "Upload error via ini: image too large (limit 3mb).";
			break;
		case UPLOAD_ERR_FORM_SIZE:
			$msg = "Upload error via form limit: image too large (limit 5mb).";
			break;

		case UPLOAD_ERR_PARTIAL:
			$msg = "Upload error: image did not finish uploading.";
			break;

		case UPLOAD_ERR_NO_FILE:
			$msg = "Upload error: no file selected.";
			break;

		case UPLOAD_ERR_NO_TMP_DIR:
			$msg = "Upload error: upload folder not found.";
			break;

		case UPLOAD_ERR_CANT_WRITE:
			$msg = "Upload error: cannot write to upload folder.";
			break;

		case UPLOAD_ERR_EXTENSION: 
			$msg = "Upload error: incorrect file extension.";
			break;

		default: 
			$msg = "Unknown error.";
		}
		throw new Exception($msg);
	}
}

$errors = array();

try {
	if (!array_key_exists('image', $_FILES)) {
		throw new Exception("Image not found in uploaded data.");
	}

	$image = $_FILES['image'];

	// validate
	validateUpload($image['error']);	
} catch (Exception $err) {
	echo $err;
	exit;
}

