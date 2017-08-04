/*global define*/
define('ext.wikia.adEngine.provider.gpt.targeting', [
	'wikia.window'
], function (win) {
	'use strict';

	function getPageLevelTargetingValue(key) {
		var pubads;

		if (typeof win.googletag.pubads === "function") {
			pubads = win.googletag.pubads();
		}

		return pubads &&
			typeof pubads.getTargeting === "function" &&
			pubads.getTargeting(key);
	}

	return {
		getPageLevelTargetingValue: getPageLevelTargetingValue
	};
});
