;$(document).ready( function () {

	EDB = {
		build: function (type, item) {
			if (type == 'panel') {
				var date = item.event_date.split('-');
				var eds = new Date(date[1] + ' ' + date[2] + ' ' + date[0]);
				var seds = eds.toDateString().split(' ');	
				var feds = seds[0] + ' ' + seds[2] + ' ' + seds[1] + '' + seds[3];


				var date = item.pub_date.split('-');
				var pds = new Date(date[1] + ' ' + date[2] + ' ' + date[0]);
				var spds = pds.toDateString().split(' ');	
				var fpds = spds[2] + ' ' + spds[1] + '' + spds[3];
					return "<a href=\"#\">"
						+ "<li class=\"event\">"
						+	  "<p class=\"e_name\">" + item.title
						+		  "<span class=\"dates\">"
						+			  "<span class=\"p_date\">pub. " + fpds  + "</span>"
						+			  "<span class=\"e_date\">" + feds + "</span>"
						+		  "</span>"
						+	  "</p>" 
						+	  "<img class=\"e_image\" src=\"" + item.image_path + "\" ></img>"
						+	  "<p class=\"desc\">" + item.description + "</p>"
						+ "</li>"
						+ "</a>";
			}

			if (type == 'frontpage' ) {

			}
		},
	};

	EventStore = {
		Bag: window.sessionStorage,

		init: function (getScript) {
			// get events from server and store
			$.get(getScript, function (data, stat, jqxhr) {
				if (stat == 'success') {
					// hydrate json returned by server
					var dataObjs = JSON.parse(data);

					// populate event store
					$.each(dataObjs, function (k,v) {
						EventStore.store(v);
					});

				} else {
					var message = 'request status: ' + stat + 'jqXHR: '
					+ jqxhr;
					console.log(message);
				}
			});

			// event collection, markup blob, date object, split and 
			// formatted date
			var todays = [], mub = null,
				d = new Date(), 
				sd = null,
				fd = null;

			// months reference for formatting
			var months = {
				'January':		'01',
				'Jan':			'01',
				'February':		'02',
				'Feb':			'02',
				'March':		'03',
				'Mar':			'03',
				'April':		'04',
				'Apr':			'04',
				'May':			'05',
				'June':			'06',
				'Jun':			'06',
				'July':			'07',
				'Jul':			'07',
				'August':		'08',
				'Aug':			'08',
				'September':	'09',
				'Sept':			'09',
				'October':		'10',
				'Oct':			'10',
				'November':		'11',
				'Nov':			'11',
				'December':		'12',
				'Dec':			'12'
			};

			// hit that mysql date format, son
			sd = d.toString().split(' ');
			fd = sd[3] + '-' + months[sd[1]] + '-' + sd[2];

			console.log('fd: ',fd);

			// get the daily events from server and display
			$.get('scripts/getByDate.php?date=' + fd, 
					function (data, stat, jqxhr) {
						if (stat == 'success') {
							if (data.length) {
								$.each(data, function (_k, obj) {
									todays.push(obj);	
								});

								for (i = 0; i < todays.length; i++) {
									if (!mub) {
										mub = EDB.build('panel', todays[i]);
									} else {
										mub += EDB.build('panel', todays[i]);
									}
									$('#eList').html(mub);
								}
							} else {
								var nothingObj = {
									title: 'Nothing for today', 
									description: 'very exciting fun time',
									pub_date: fd, 
									event_date: fd,
									image_path: 'static/testPatternRetroSmall.jpg',
								};

								todays.push(nothingObj);

								for (i = 0; i < todays.length; i++) {
									console.log('todays in loop: ', todays[i]);
									if (!mub) {
										mub = EDB.build('panel', todays[i]);
									} else {
										mub += EDB.build('panel', todays[i]);
									}
									console.log('mub ', mub);
									$('#eList').append(mub);
								}

							}
						} else {
							var message = 'request status: ' + stat + ' jqXHR: ' + jqxhr;
							console.log(message);
						}
					});


			$('#upcoming_display').append(mub);
		},

		store: function (item) {
			if (this.Bag.getItem('Event:' + item.id)) {
				var message = 'event ' + item.id + ' already in store';
				console.log(message); 
			} else {
				this.Bag.setItem('Event:' + item.id, JSON.stringify(item));
				this.Bag.setItem('Event:index', this.Bag.length);
			}
		},

		edit: function (item) {

		},

		get: function (id) {
			if (item = this.Bag.getItem('Event:' + id)) {
				return item;		
			} else {
				console.log('event not in store');
				return null;
			}
		},

		remove: function (item) {
			if (!this.Bag.getItem('Event:' + item.id)) {
				console.log('event not in store');	
			} else {
				this.Bag.removeItem('Event:' + item.id);
			}
		}, 

		clear: function () {
			if (confirm('clear event store? for real?')) {
				this.Bag.clear();
			};
		},

		length: function () {
			return this.Bag.length;
		}
	};

	// init Event Store
	EventStore.init('scripts/load_upcoming_events.php');

	// check for File API
	if (window.File &&  window.FileList){
	} else { alert('browser does not support needed File API\'s'); }

	// cache selectors
	var upForm = $('#upload_event'), 
		$imageInput = $('#up_image');

	// fileupload plugin init
	upForm.fileupload({
		dataType: 'json',
		url: 'scripts/upload.php',
		fileInput: null,
	});	

	// bind storage callback to fileupload done event 
	upForm.bind('fileuploaddone', function (e, data) {
		EventStore.store(data.result);

		$('#upcoming_display').append(EDB.build('panel', data.result));
	});

	// bind datepicker to form elements
	$('#event_date').datepicker();
	$('#pub_date').datepicker();

	// empty array for images from form
	var images = [];

	// handle client side file data
	$('#up_file_path').on('focus', function (e) {
		e.preventDefault();
	
		iIn = document.getElementById('up_image'); 

		iIn.addEventListener('change', function (e) {
			images = e.target.files;
			$('#up_file_path').val(images[0].name);
		});
		
		$(this).trigger('blur');
		$imageInput.trigger('click');					
	});


	// bind file sending activities to submit event on form
	$('#upload_event').on('submit', function (e) {
		e.preventDefault();

		upForm.fileupload('send', {
			files: images,
			formData: upForm.serializeArray(),
		});

		document.getElementById('upload_event').reset();
	});
	
	$(document).on('storage', function (e) {
		console.log(e);
	});
});
