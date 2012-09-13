// this here is the Roller jQuery plugin, designed for le Coup
;(function ($) {
	$.fn.coupCal= function (options) {
		var settings = $.extend({
			// settings defaults obj
			}, options);
		});

		// pseudo 
		var images = {};
		$.ajax('coupImgStore.php', {
			success: function(res) {
				for (img in res) {
					images[res.img_name] = img_url;
				}
			});

		this.attr('src', images.img_name);
		// /psuedo
	}; 
}) (jQuery);


