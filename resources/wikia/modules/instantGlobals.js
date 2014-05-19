/**
 * AMD module exporting Wikia.InstantGlobals object
 */
/*global define*/
define('wikia.instantGlobals', ['wikia.window'], function(window) {
	'use strict';
	if (window.Wikia && window.Wikia.InstantGlobals) {
		return window.Wikia.InstantGlobals;
	}
});