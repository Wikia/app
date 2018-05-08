/*global define*/
/**
 * AMD module exporting Wikia.InstantGlobals object
 */
define('wikia.instantGlobals', [
	'wikia.trackingOptOut',
	'wikia.window'
], function(trackingOptOut, window) {
	'use strict';

	if (window.Wikia && window.Wikia.InstantGlobals) {
		return trackingOptOut.checkOptOut(window.Wikia.InstantGlobals);
	}

	return {};
});
