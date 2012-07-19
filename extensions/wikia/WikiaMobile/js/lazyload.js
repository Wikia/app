/**
 * @define lazyload
 *
 * Image lazy loading
 */
/*global window, define, document, $*/
define('lazyload', function () {
	'use strict';

	function load(elements, loadingClass, completeClass) {
		var x,
			y,
			elm,
			onload = function () {
				this.className = this.className.replace(
					loadingClass,
					completeClass
				);
			};

		for (x = 0, y = elements.length; x < y; x += 1) {
			elm = elements[x];

			//load only visible images (i.e. in the article intro),
			//images in sections will be loaded on demand
			if (elm && elm.offsetWidth > 0 && elm.offsetHeight > 0) {
				elm.onload = onload;
				elm.src = elm.getAttribute('data-src');
			}
		}
	}

	return load;
});