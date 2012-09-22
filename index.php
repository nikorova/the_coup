<!DOCTYPE html>
<html>

<head>
<title> Coup Panel </title>
<script type="application/javascript" src="http://code.jquery.com/jquery-1.8.0.min.js"></script>

<!--
<script type="application/javascript" src="scripts/coupPanelUpload.js"></script>
-->

<link rel="stylesheet" type="text/css" media="all" href="style/panel.css" />

<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script> 
<![endif]-->

<!--[if lte IE 7]>
	<script src="js/IE8.js" type="text/javascript"></script>
<![endif]-->

<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" media="all" href="css/ie6.css"/>
<![endif]-->
</head>

<body>
<div id="dev_splash">
	<h3 class="highlight"> Welcome to the dev version of your fancy pants admin panel! </h3>
	<p> This is by no means complete and is absolutely liable to change at any time. </p>
	<p> Also please note that while the code handling the form is functional, it's <span class="highlight">not wired up</span> properly yet.
	You're welcome to try uploading a file, but the php script handling the upload will just <span class="highlight">puke</span>. </p>
</div>

<div id="wrapper">
	<div id="header">
		<nav>
			<h1> Coup Panel </h1>
			<ul> 
				<li> <a href="#"> New Event </a> </li>
				<li> <a href="#"> New Event </a> </li>
				<li> <a href="#"> New Event </a> </li>
			</ul>
		</nav>
	</div>
	<div class="corner_bit"></div>

	<div id="app">
		<div id="left_bar">
			<form id="upload_event" enctype="multipart/form-data" > 
				<fieldset>
					<legend> New Event </legend>
					<label class="up_label" for="title"> title </label>
					<input name="title"
					id="title"
					class="input_field"
					type="text"
					required> </input>

					<label class="up_label" for="description"> event description </label>
					<textarea name="description"
						id="description"
						requied> </textarea> 
					<label class="up_label" for="pub_date"> publication date </label> <input name="pub_date"
					id="pub_date"
					class="input_field"
					type="date"
					required> </input>

					<label class="up_label" for="event_date"> event date </label>
					<input name="event_date"
					id="event_date"
					class="input_field"
					type="date"
					required> </input>

					<label class="up_label" for="up_image"> upload image </label>
					<input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
					<input name="image"
					id="up_image"
					type="file"
					required />

					<button id="#upload_submit" class="button" type="submit" >Submit </button>
				</fieldset>
			</form>
		</div>

		<div id="right_bar">
			<h2> Upcoming Events </h2>
			<div id="upcoming_display">
				<button id="load_events"> ROAD EVENTS</button>
				<ul> 
					
				</ul>
			</div>
		</div>
		<div class="clear"></div>
		<a href="http://mysql.com"><img class="bottom_logo" src="static/mysql_dolphin_small.png" alt="mysql"></img></a>
		<a href="http://php.net"><img class="bottom_logo" src="static/php_small.png" alt="php"></img></a>
	</div>
</div>

<div id="footer">

</div>

<script type="application/javascript"> 
;$(document).on('submit','#upload_event', function () {
	// sneak the iframe onto the form
	iframe = '<iframe id="upIframe" class="hidden"/>
	$('#left_panel').append(iframe);

	// set the form's target to the iframe
	$('#upload_event').attr('target', 'upFrame');

	// get the form data and make the POST
	var formData = $(this).serialize();
	console.log(formData);

	$.ajax('scripts/upload.php', {
		type: 'POST',
	 	content: 'multipart/form-data',
		data: formData, 
		success: alert(' was success ok'),
		error: alert('was no good ok'), 
		complete: alert('complete callback'), 
	});

	return false;	
});
	</script>

</body>

</html>
