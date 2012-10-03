<!DOCTYPE html>

<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]--> <html>

<head>


<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width">

<title> Coup Panel </title>
<meta name="description" content="resource main for The Coup - Clarksville, TN">

<script type="application/javascript" src="js/vendor/modernizr-2.6.2.min.js"></script>

<link type="text/css" href="css/eggplant/jquery-ui-1.8.24.custom.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" media="all" href="css/main.css" />

<script> 
</script>

</head>

<body>
<!--[if lt IE 7]>
	<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.2.js"><\/script>')</script>

<script type="application/javascript" src="js/vendor/jquery-ui-1.8.24.custom.min.js"></script>
<script type="application/javascript" src="js/plugins.js"></script>
<script type="application/javascript" src="js/main.js"></script>

<div id="dev_splash">
	<h3 class="highlight"> Welcome to the dev version of your fancy pants admin panel! </h3>
	<p> This is by no means complete and is absolutely liable to change at any time. </p>
	<p> Also please note that while the code handling the form is functional, it's <span class="highlight">not wired up</span> properly yet.
	You're welcome to try uploading a file, but the php script handling the upload will just <span class="highlight">puke</span>. </p>
</div>

<div id="wrapper" class="borderTrans .boxShadowBlack ">
	<div id="header" class="fontWhite BGpurpleGradientAplha boxShadowBlack">
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

	<div id="app" >
		<div id="left_bar">
			<form id="upload_event" 
				enctype="multipart/form-data" > 
				<fieldset>
					<legend> New Event </legend>
					<label class="up_label" for="title"> title </label>
					<input name="title"
					id="title"
					class="clean input_field"
					type="text"
					required> </input>

					<label class="clean up_label" for="description"> event description </label>
					<textarea name="description"
						class="clean"
						id="description"
						requied> </textarea> 

					<label class="clean up_label" for="pub_date"> publication date </label> 
					<input name="pub_date"
					id="pub_date"
					class="clean input_field"
					type="date"
					required> </input>

					<label class="clean up_label" for="event_date"> event date </label>
					<input name="event_date"
					id="event_date"
					class="clean input_field"
					type="date"
					required> </input>

					<label class="clean up_label" for="up_image"> upload image </label>
					<input class="clean hidden" type="hidden" name="MAX_FILE_SIZE" value="3000000" />
					<input id="up_image" type="file" name="image"  class="clean hidden" required />
					<input id="up_file_path" class="clean input_field" type="text" required/>


					<button id="#upload_submit" class="button" type="submit" >Submit </button>
				</fieldset>
			</form>
		</div>

		<div id="right_bar">
			<h2> Upcoming Events </h2>
			<div id="upcoming_display">
				<ul id="eList"></ul>
			</div>
		</div>
		<div class="clear"></div>
		<a href="http://mysql.com"><img class="bottom_logo" src="static/mysql_dolphin_small.png" alt="mysql"></img></a>
		<a href="http://php.net"><img class="bottom_logo" src="static/php_small.png" alt="php"></img></a>
	</div>
</div>

<div id="footer">

</div>


</body>

</html>
