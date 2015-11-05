(function () {
	'use strict';

	var $ = require('jquery');

	function preventHighlighting(element){
		if (typeof element.onselectstart !== 'undefined') { // IE
			element.onselectstart = function () {
				return false;
			};
		} else if (typeof element.style.MozUserSelect !== 'undefined') { // Moz-based (FireFox, etc.)
			element.style.MozUserSelect = 'none';
		} else {
			element.onmousedown = function () {
				return false;
			};
		}
		element.style.cursor = 'default';
	}

	$('.lyricbox').each(function () {
		preventHighlighting(this);
	});

	$('body').bind('contextmenu', function(ev) {
		ev.preventDefault();
	});
})();
