;$(document).ready( function () {
	EventStore = {
		Bag: window.sessionStorage,

		init: function (getScript) {
			var response = $.get(getScript, function (data, stat, jqxhr) {
				if (stat == 'success') {
					var dataObjs = JSON.parse(data);

					$.each(dataObjs, function (k,v) {
						EventStore.store(v);
					});
				} else {
					var message = 'request status: ' + stat + 'jqXHR: '
					+ jqxhr;
					console.log(message);
				}
			});
		},

		store: function (item) {
			if (this.Bag.getItem('Event:' + item.id)) {
				var message = 'event ' + item.id + ' already in store';
		//		console.log(message); 
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

		}
	};

	EDB = {
		build: function (type, item) {
			if (type == 'panel') {
					return "<a href=\"#\">"
						+ "<li class=\"event\">"
						+	  "<p class=\"e_name\">" + item.title
						+		  "<span class=\"dates\">"
						+			  "<span class=\"p_date\">" + item.pub_date + "</span>"
						+			  "<span class=\"e_date\">" + item.event_date + "</span>"
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

	// empty array for images from form
	var images = [];

	// handle client side file data
	$('#up_file_path').on('click', function (e) {
		e.preventDefault();
	
		iIn = document.getElementById('up_image'); 

		iIn.addEventListener('change', function (e) {
			images = e.target.files;
			$('#up_file_path').val(images[0].name);
		});
		
		$imageInput.trigger('click');					
	});


	// bind file sending activities to submit event on form
	$('#upload_event').on('submit', function (e) {
		e.preventDefault();

		upForm.fileupload('send', {
			files: images,
			formData: upForm.serializeArray(),
		});
	});
	
	$(document).on('storage', function (e) {
		console.log(e);
	});


});

// later
