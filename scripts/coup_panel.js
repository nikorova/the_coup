;(function ($, window, document, undefined) {
	var pluginName = 'coupPanel',
	defaults = {
		cacheAjax: false, 
		loadingGifPath: '../static/ajax-loader.gif',
		eventLoadScript: 'load_upcoming_events.php',
		eventUploadScript: 'upload.php',
	};

	function Plugin = function (element, options) {
		this.element = element;

		this.options = $.extend( {}, defaults, options);

		this._defaults = defaults; 
		this._name = pluginName;

		this.init();
	}

	Plugin.prototype.init = function () {
		// do ajax setup
		$.ajaxSetup({
			cache:  this.options.cacheAjax,
		});

		// init vars for event handlers
		console.log(settings.loadingGifPath);
		var loadingGif = '<img src="' + settings.loadingGifPath + '" alt="loading..."/>';

		$(document).ready(function () {
			$('#upload_submit').on('click', function (e) {

				return false;
			});

			// load events in right panel
			$('#load_events').on('click', function (e) {
				$(this).html(loadingGif).load(eventLoadScript);
				return false;
			});
		});
	};
}) (jQuery); 
