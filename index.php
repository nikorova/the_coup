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
<meta name="description" content="resource panel for The Coup - Clarksville, TN">

<script src="js/vendor/modernizr-2.6.2.min.js"></script>
<script type="application/javascript" src="http://code.jquery.com/jquery-1.8.0.min.js"></script>
<script src="js/panel.js"></script>

<link rel="stylesheet" href="style/panel.css">
<link rel="stylesheet" type="text/css" media="all" href="css/main.css" />

</head>

<body>
<!--[if lt IE 7]>
	<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.2.min.js"><\/script>')</script>
<script src="js/plugins.js"></script>
<script src="js/main.js"></script>

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
					class="input_field"
					type="text"
					required> </input>

					<label class="up_label" for="description"> event description </label>
					<textarea name="description"
						id="description"
						requied> </textarea> 

					<label class="up_label" for="pub_date"> publication date </label> 
					<input name="pub_date"
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

<script type="application/javascript"> 
/*
;$(document).ready(function (e) {
	var uploadScript = 'scripts/upload.php';
	var getScript = 'scripts/load_upcoming_events.php';

	// event manager
	// * manages collection of events
	// * * get events from server & add to collection
	// * * get event from form & send to server/add to collection
	// * * delete from collection & send delect request to server
	// * * edit by id & send update request
	// * publish updates to observers
	// * listen to events from ui for update

	EMan = (function () {
		var getScript = 'scripts/load_upcoming_events.php';
		var uploadScript = 'scripts/upload.php';

		// event store using session storage
		// sessionStorage object accepts key,val pairs and caches them
		// key will be a string, val will be an obj
		//
		// don't forget to reconstitue the objects upon retrieval,
		//   as they are stringified when set
		var eventBag = window.sessionStorage;

		function create (key, obj) {
			if (eventBag.getItem(key)) {
				console.log('event object at ', key, ' already exists.');	
			} else {
				eventBag.setItem(key, obj);
			}
		}
		
		function read (id) {
			var eventItem = eventBag.getItem(id);

			if (eventItem) {
				return eventItem;
			} else {
				console.log('no event by id: ',id);
			}
		}

		function update (id) {

		}

		function del (id) {
			if (eventBag.getItem(id)) {
				eventBag.removeItem(id);
				console.log('removed event: ', id);
			} else {
				console.log('no event by id: ', id);
			}
		}

		// get's current collection of events from server as json string
		// re-hydrates them and passes them to create() as id, obj
		function fetchFromServer () {
			var response = $.get(getScript, function (data, stat, jqxhr) {
				if (stat == 'success') {
					var dataObjs = JSON.parse(data);

					console.log('received: ', data.length);

					// $.each() passes k,v to callback, k is unused 
					$.each(dataObjs, function(k, v) {
						create(v.id, v);
					});
				} else {
					var message = 'GET to server reports: ' + stat 
						+ 'jqxhr to follow: ' + jqxhr;
					console.log(message);
				}
			});
		}

		// API
		return {
			// fire this puppy up
			init: function () {
				fetchFromServer();
			}, 

			// returns event object
			getEventByID: function (id) {
				return JSON.parse(read(id));
			},

			// remove obj from Bag
			deleteEventByID: function (id) {
				del(id);
			},

			// update obj with new data
			updateEvent: function (id, newData) {
				
			}
		}
	}) ();

	// this guy's job is to build markup from objects
	Builder = (function () {
/*
		var panelEvent = {
			'elem': '<li />',
				'class': 'event',
				'child': {
					'elem': '<p />',
					'class': 'e_name',
					'html': eventItem.title,
					'child': {
						'elem': '<span />',
						'class': 'dates',
						'child': {
							'elem': '<span />',
							'class': 'p_date',
							'html': eventItem.pubDate,
						},
						'child': {
							'elem': '<span />',
							'class': 'e_date',
							'html': eventItem.eventDate,
						}	
					}
					'child': {
						'elem': '<img />',
						'class': 'e_image',
						'attr': {
							'src': eventItem.imagePath
						}
					}
					'child': {
						'elem': '<p />',
						'class': 'desc',
						'html': eventItem.description
					}
				}
			};

		var panelWidget = [{
			'li': {
				'class': 'event',
			},
			'p': {
				'class': 'e_name',
			},
			'span': {
				'class': 'dates'
			},
			'span': {
				'class': 'p_date'
			},
			'span': {
				'class': 'e_date'
			},
			'img': {
				'class': 'e_image',
				'attr': 'src',
			}
		}];

		var panelEvent = $('<li />') .addClass('event')
			.append($('<p />') .addClass('e_name') .html(eventItem.title)
			.append($('<span />').addClass('dates')
			.append($('<span />').addClass('p_date')
			.append($('<span />').addClass('e_date')
			.append($('<img />').addClass('e_image').attr('src', eventItem.imagePath)
			.append($('<p />').addClass('desc').html(eventItem.description);


		function createEventMarkup(template, eventObj) {
			if (type == 'panel') {
				
			} else if (type == 'front_page') {

			}

		}
			
		return {
			createDiv: function (type, eventObj) {
			}	
			},
		}
	}) ();
	
	EMan.init();
});
 */
</script>

</body>

</html>
