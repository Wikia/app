/*
 * Begin Meerkat library, adapted from
 * http://jarodtaylor.com/meerkat/js/jquery.meerkat.1.0.js
 * Made the following changes:
 *  Cleaned up javascript (jslint compatible)
 *  Cookie functionality ripped, we use frequency capping to prevent
 *  Removed IE < 6 support
 *  Added left': '0' to the meerkat-wrap class  for IE 7
 * second display
 *
 * Depends on jQuery
 */
window.meerkat = (function($) {
	'use strict';

	return function(options) {
		this.settings = {
			close: 'none',
			dontShow: 'none',
			meerkatPosition: 'bottom',
			animationSpeed: 'slow',
			height: 'auto',
			background: 'none'
		};

		if (options) {
			$.extend(this.settings, options);
		}

		var settings = this.settings;

		$('html, body').css({'margin': '0', 'padding': '0', 'height': '100%'});
		$('#meerkat').show();

		$('#meerkat-wrap').css({'position': 'fixed', 'width': '100%', 'height': settings.height, 'left': 0, 'z-index': 1000}).css(settings.meerkatPosition, '0');
		$('#meerkat-container').css({'background': settings.background, 'height': settings.height});

		//Give the close and dontShow elements a cursor (there's no need to use a href)
		$(settings.close + ',' + settings.dontShow).css({'cursor': 'pointer'});

		$('#meerkat-wrap').hide().slideDown(settings.animationSpeed);
		$(settings.close).click(function() {
			$('#meerkat-wrap').slideUp();
		});

		$(settings.dontShow).click(function() {
			$("#meerkat-wrap").slideUp();
		});
	};
}(window.jQuery));
