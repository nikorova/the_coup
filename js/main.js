;$(document).ready( function () {
	// cache selectors
	var upForm = $('#upload_event'), 
		$eventDisplay = $('#eList'),
		$imageInput = $('#up_image');

	EDB = {
		build: function newDiv(type, newEvent) {
			if (type == 'panel') {

				var div = $('<div />').addClass('eDispWrapper')
					.append($('<button />').addClass('eBtn eDel cntx hidden').html('delete'))
					.append($('<button />').addClass('eBtn eEdit cntx hidden').html('edit'))
					.append($('<div />').addClass('event').data('id', newEvent.id))
						.children('.event')
							.append($('<span />').addClass('title').html(newEvent.title))
							.append($('<span />').addClass('event_date').html(newEvent.event_date))
							.append($('<span />').addClass('pub_date').html(newEvent.pub_date))
							.append($('<div />').addClass('description').html(newEvent.description))
							.append($('<img />').addClass('eImage').attr('src', newEvent.image_path))
						.end();

				return div;
			}
		},
	};

	EventStore = {
		init: function (getScript) {
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

			this.nothingObj = {
				id: 'nothing',
				title: 'nothing for today', 
				description: 'very exciting fun time',
				pub_date: fd, 
				event_date: fd,
				image_path: 'static/testPatternRetroSmall.jpg',
			};

			// get the daily events from server and display
			var that = this;

			$.get('scripts/getByDate.php?date=' + fd, function (data) {
				if (data.length) {
					$.each(data, function (_k, obj) {
						todays.push(obj);	
					});

				} else {
					todays.push(that.nothingObj);
				}

				for (i = 0; i < todays.length; i++) {
					$eventDisplay.append(EDB.build('panel', todays[i]));
				}
			});

			console.info(mub);
			$eventDisplay.append(mub);


			var newForm = $('<form />').addClass('editForm')
				.append($('<input />').addClass('editInput title').attr({
					type: 'text',
					name: 'title',
					id: 'title'
				}))
				.append($('<input />').addClass('editInput event_date dp').attr({
					type: 'date',
					name: 'event_date',
					id: 'eDate'
				}))
				.append($('<input />').addClass('editInput pub_date dp').attr({
					type: 'date',
					name: 'pub_date',
					id: 'pDate'
				}))
				.append($('<textarea />').addClass('editInput description').attr({
					type: 'text',
					name: 'description',
					id: 'description'
				}))
				.append($('<img />').addClass('eImage').attr('src', ''))
				.append($('<button />').addClass('eBtn eSubmit').html('save'))
				.append($('<button />').addClass('eBtn eCancel').html('cancel'));

			// bind mouseover show delete/edit buttons
			$eventDisplay.on('mouseenter', 'div.eDispWrapper', function (e) {
				var $event = $(this).children('.event');

				$event.css('opacity', '0.6');
				$(this).find(".cntx").removeClass('hidden');
			
			}).on('mouseleave', 'div.eDispWrapper', function (e) {
				var $event= $(this).children('.event');

				$event.css('opacity', '1');
				$(this).find(".cntx").addClass('hidden');
			});


			// bind remove handler for events on display
			$eventDisplay.on('click', '.eDel', function (e) {
				var $this = $(this).siblings('div.event'),	
				name = $this.find('.title').html(),
				id = $this.data('id');

				console.info($this);
				if (confirm('delete event ' + name + '?')) {
					$.get('scripts/deleteEvent.php?id=' + id, function () {
						$this.remove();
					});
				}
			})
			
			// bind edit handler for events on display
			.on('click', '.eEdit', function (e) {
				$event = $(this).siblings('div.event');

				newForm.find('.editInput').each(function(_k, input) {
					var $input = $(input),
						name = $input.attr('name'),
						content = $event.find('*[class="' + name + '"]').html();

					if ($input.is('textarea')) {
						$input.text(content);	
					} else {
						$input.val(content);
					}
				});

				console.info($event.find('.eImage').attr('src'));
				newForm.find('.eImage').attr('src', $event.find('.eImage').attr('src'));
				newForm.data('id', $event.data('id'));
				newForm.find('.dp').datepicker();
				newForm.data('dEvent', $event.detach());
				newForm.clone(true).appendTo($(this).parents('.eDispWrapper'));
			})
			
			// bind on submit handler for edit event on display
			.on('click', '.eSubmit', function (e) {
				e.preventDefault();

				var $this = $(this),
					$form = $this.parents('.editForm'),
					fData = $form.serializeArray(),
					eData = {};

				$.each(fData, function(k, v) {
					eData[v.name] = v.value;
				});

				eData.id = $form.data('id');
				eData.image_path = $form.find('.eImage').attr('src');

				console.info(eData);
				$form.parent().replaceWith(EDB.build('panel', eData));
			})

			.on('click', '.eCancel', function (e) {
				var $form = $(this).parent(),
					dEvent = $form.data('dEvent');

				$form.replaceWith(dEvent);	
			});
		},

		edit: function (item) {

		},


		remove: function (item) {

		}, 
	};

	// init Event Store
	EventStore.init('scripts/load_upcoming_events.php');

	// check for File API
	if (window.File && window.FileList){
	} else { alert('browser does not support needed File API\'s.' 
			+ 'please use a modern browser like a goddamn human being.'); 
	}

	// fileupload plugin init
	upForm.fileupload({
		dataType: 'json',
		url: 'scripts/upload.php',
		fileInput: null,
	});	

	// bind storage callback to fileupload done event 
	upForm.bind('fileuploaddone', function (e, data) {
		var nothingEvent = $eventDisplay.find('a[data-event-id="nothing"]');
		if (nothingEvent) {
			nothingEvent.remove();
		}

		$eventDisplay.append(EDB.build('panel', data.result));
	});

	// bind datepicker to form elements
	$('.dp').datepicker();

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
});
