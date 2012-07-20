/**
 * Hides url bar
 * to ensure that ad is placed correctly
 * when url bar is being hidden
 *
 * @define hideURLBar
 * @require ads
 *
 * @author Jakub Olek
 */
/*global window, define, setTimeout*/

define('hideURLBar', ['ads'], function (ads) {
	'use strict';

	var w = window;

	return function () {
		if (w.pageYOffset < 20) {
			setTimeout(function () {
				w.scrollTo(0, 1);
				if (ads) {
					ads.moveSlot();
				}
			}, 100);
		}
	};
});