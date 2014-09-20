/**
 * AMD module exporting Wikia.AbTest object
 */
/*global define*/
define('wikia.abTest', ['wikia.window'], function(window) {
	'use strict';
	if (window.Wikia && window.Wikia.AbTest) {
		return window.Wikia.AbTest;
	}
});
