/*global define*/
define('ext.wikia.adEngine.video.videoFrequencyStore', [
	'ext.wikia.adEngine.utils.time',
	'ext.wikia.adEngine.video.videoFrequencySettings',
	'wikia.cache',
	'wikia.log',
	'wikia.window'
], function (timeUtil, settings, cache, log, win) {
	'use strict';

	var cacheKey = 'adEngine_outstreamVideoFrequency',
		cacheTtl = cache.CACHE_STANDARD, // 1 day
		store = [],
		logGroup = 'ext.wikia.adEngine.video.videoFrequencyStore';

	function removeNotNeededData(data) {
		var requiredNoOfItems = settings.getRequiredNumberOfItems();

		data.sort(function (a, b) {
			return a.date - b.date;
		});

		if (data.length > requiredNoOfItems) {
			data = data.slice(-requiredNoOfItems);
		}

		return data;
	}

	function save(data) {
		store = getAll();
		log(['Data retrived from cache', store], log.levels.debug, logGroup);

		store.push(data);

		store = removeNotNeededData(store);
		cache.set(cacheKey, store, cacheTtl);
		log(['Data saved in cache', store, cacheKey, cacheTtl], log.levels.debug, logGroup);
	}

	function countAll(filterFunction) {
		store = getAll();

		return (filterFunction ? store.filter(filterFunction) : store).length;
	}

	function numberOfVideosSeenInLastPageViews(numberOfCheckedPageViews) {
		var minPV = win.pvNumber - numberOfCheckedPageViews;
		log(['minPV calculated', minPV], log.levels.debug, logGroup);

		return countAll(function (item) {
			return item.pv > minPV;
		});
	}

	function numberOfVideosSeenInTime(value, unit) {
		var minDate = (new Date()).getTime() - timeUtil.getInterval(value, unit);
		log(['minDate calculated', minDate], log.levels.debug, logGroup);

		return countAll(function (item) {
			return item.date > minDate;
		});
	}

	function isValidData (value) {
		var date, pv;

		if (value.date && value.pv) {
			date = parseInt(value.date, 10);
			pv = parseInt(value.pv, 10);

			if (date > 0 && pv > 0) {
				return true;
			}
		}

		return false;
	}

	function getAll() {
		var cachedData = cache.get(cacheKey) || store;

		return cachedData.filter(isValidData);
	}

	return {
		getAll: getAll,
		numberOfVideosSeenInTime: numberOfVideosSeenInTime,
		numberOfVideosSeenInLastPageViews: numberOfVideosSeenInLastPageViews,
		save: save
	};
});
