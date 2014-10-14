define('wikia.scrollToLink', ['jquery'], function($) {
	'use strict';
	var offsetToScroll, init, handleLinkTo, getOffsetTop, pushIntoHistory, validateHref;

	init = function(offset) {
		offsetToScroll = offset;

		handleLinkTo(window.location.hash);

		$('body').on('click', 'a', function(event){
			if (handleLinkTo(this.getAttribute('href'))) {
				event.preventDefault();
			}
		});
	};

	getOffsetTop = function(element) {
		return parseInt(element.getBoundingClientRect().top + window.pageYOffset - document.documentElement.clientTop, 10);
	};

	validateHref = function(href) {
		return (href.indexOf("#") === 0 && href.length > 1) ? href.slice(1) : false;
	};

	handleLinkTo = function(href) {
		if(!!(href = validateHref(href))) {
			var target = document.getElementById(href),
				targetOffset;

			if (!!target) {
				targetOffset = getOffsetTop(target);

				$('html, body').animate({ scrollTop: targetOffset - offsetToScroll });
				if (pushIntoHistory({}, document.title, window.location.pathname + '#' + href)) {
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

	return {
		init: init
	};
});
