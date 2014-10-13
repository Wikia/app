

(function($) {
	'use strict';
	var offset, init, scrollTo, handleLinkTo, pushIntoHistory;

	offset = 80; // height of #globalNavigation plus some additional space

	init = function() {
		handleLinkTo(window.location.hash);

		$('body').on('click', 'a', function(event){
			if (handleLinkTo(this.getAttribute('href'))) {
				event.preventDefault();
			}
		});
	};

	scrollTo = function(targetOffset) {
		window.scrollTo(0, parseInt(targetOffset, 10));
	};

	handleLinkTo = function (href) {
		if(href.indexOf("#") === 0) {
			var $target = $(href);

			if ($target.length) {
				//scrollTo($target.offset().top - offset);
				$('html, body').animate({ scrollTop: $target.offset().top - offset });
				if (pushIntoHistory({}, document.title, window.location.pathname + href)) {
					return true;
				}
			}
		}
		return false;
	};

	pushIntoHistory = function(state, title, url) {
		if(history && "pushState" in history) {
			history.pushState(state, title, url);
			return true;
		}
		return false;
	};

	$(function(){
		init();
	});
}(jQuery));
