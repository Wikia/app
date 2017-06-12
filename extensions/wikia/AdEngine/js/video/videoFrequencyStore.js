/*global define*/
define('ext.wikia.adEngine.video.videoFrequencyStore', [
	'ext.wikia.adEngine.adLogicPageViewCounter',
	'wikia.cache',
	'wikia.log'
], function (pageViewCounter, cache, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.videoFrequencyStore',
		cacheKey = 'adEngine_outstreamVideoFrequency',
		cacheTtl = cache.CACHE_STANDARD, // 24h
		store = [];

	function save(data) {
		store = cache.get(cacheKey) || store;
		log(['Data retrived from cache', store], log.levels.debug, logGroup);

		store.push(data);

		cache.set(cacheKey, store, cacheTtl);
		log(['Data saved in cache', store, cacheKey, cacheTtl], log.levels.debug, logGroup);
	}

	function countAll(filterFunction) {
		return (filterFunction ? store.filter(filterFunction) : store).length;
	}

	function numberOfVideosSeenInLastPageViews(numberOfCheckedPageViews) {
		var minPV = pageViewCounter.get() - numberOfCheckedPageViews;

		return countAll(function (item) {
			return item.pv >= minPV;
		});
	}

	function numberOfVideosSeenInLast(value, unit) {
		var minDate = (new Date()).getTime() - getInterval(value, unit);

		return countAll(function (item) {
			return item.date >= minDate;
		});
	}

	function getMultiplier(unit) {
		var s = 1000;
		switch (unit) {
			case 's':
			case 'sec':
			case 'second':
			case 'seconds':
				return s;
			case 'm':
			case 'minute':
			case 'minutes':
				return s * 60;
			default:
				throw 'Unsupported time unit';
		}
	}

	function getInterval(value, unit) {
		return value * getMultiplier(unit);
	}

	return {
		save: save,
		numberOfVideosSeenInLast: numberOfVideosSeenInLast,
		numberOfVideosSeenInLastPageViews: numberOfVideosSeenInLastPageViews
	};
});
