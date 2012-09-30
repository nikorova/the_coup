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

	EventStore.init('scripts/load_upcoming_events.php');

	$('#upload_event').on('submit', function (e) {

		var upframe = $('<iframe />')
			.addClass('hidden')
			.attr('id', 'upframe');

		$(this).append(upframe);

		$(this).attr({
			'action': 'scripts/upload.php',
			'target': 'upframe',
			'method': 'POST'
		});

		e.preventDefault();
	});

	$(document).on('load', function (e) {
		console.log('event: ', e.type);
		var XHR = e.target;
		var eventItem = XHR.response; 
		console.log('xhr: ', XHR);
		console.log('loaded: ', eventItem);
			
		if (XHR.response.status == 200) {
			EventStore.store(eventItem);
		}
	});

	$(window).on('storage', function (e) {
		var eventItem = e.newValue;	

		
	});


});

// later

