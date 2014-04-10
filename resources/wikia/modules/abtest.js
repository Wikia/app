/**
 * A set of AMD modules wrapping local storage API
 */
define('wikia.abTest', ['wikia.window'], function(window, undef) {
	'use strict';
	if (window.Wikia && window.Wikia.AbTest) {
		return window.Wikia.AbTest;
	}
	return undef;
});