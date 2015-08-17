/*global define*/
define('ext.wikia.adEngine.adLogicPageViewCounter', [
	'wikia.cache',
	'wikia.window'
], function (cache, window) {
	'use strict';

	var cacheKey = 'adEngine_pageViewCounter',
		cacheTtl = 24 * 3600 * 1000, // 1 day to clear the page view counter
		now = window.wgNow || new Date(),
		initialValue = {
			since: now.getTime(),
			pvs: 0
		};

	function isValidValue(val) {
		// Check the basic structure: {since: number, pvs: number}
		if (!val || isNaN(val.since) || isNaN(val.pvs)) {
			return false;
		}

		var pvs = val.pvs,
			age = now.getTime() - val.since;

		// pvs must be positive, age must be within 0..cacheTtl
		if (pvs < 0 || age < 0 || age > cacheTtl) {
			return false;
		}

		return true;
	}

	function get() {
		var val = cache.get(cacheKey, now);

		if (!isValidValue(val)) {
			val = initialValue;
		}

		return val.pvs;
	}

	function increment() {
		var val, age, ttlLeft;

		val = cache.get(cacheKey, now);

		if (!isValidValue(val)) {
			val = initialValue;
		}

		age = now.getTime() - val.since;
		ttlLeft = cacheTtl - age;
		val.pvs += 1;

		cache.set(cacheKey, val, ttlLeft, now);
	}

	return {
		get: get,
		increment: increment
	};
});
