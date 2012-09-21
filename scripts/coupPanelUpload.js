;(function ($, window, document, undefined) {
	var pluginName = 'coupPanelUploadEvent',
	defaults = {
		cacheAjax: false, 
		uploadScriptPath: 'upload.php',
	};

	function Plugin( element, options ) {
		this.element = element; 
		
		this.options = $.extend( {}, defaults, options);

		this._defaults = defaults;
		this._name = pluginName;

		this.init();
	};

	Plugin.prototype.init = function () {
		$.ajaxSetup({
			cache: this.options.cachAjax,
		});

		$(document).ready(function () {
			$(this.element).on('submit', function (e) {

				// create obj from post data 
				var uploadEventData = $(this.element).serialize();

				// ajax req to server
				$.ajax(uploadScriptPath, {
					type: 'POST',
					data: uploadEventData, 
					success: alert(' was success ok: ', res),
					error: alert('was no good ok'), 
					complete: alert('complete callback'), 
				});
				return false;
			});
		});
	};
}) (jQuery);
