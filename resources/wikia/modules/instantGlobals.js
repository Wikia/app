/*global define*/
/**
 * AMD module exporting Wikia.InstantGlobals object
 */
define('wikia.instantGlobals', [
	'wikia.window'
], function(window) {
	'use strict';

	if (window.Wikia && window.Wikia.InstantGlobals) {
		return window.Wikia.InstantGlobals;
	}

	return {};
});
