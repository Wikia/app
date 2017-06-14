/*global define*/
define('ext.wikia.adEngine.video.videoFrequencyStore', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageViewCounter',
	'ext.wikia.adEngine.utils.time',
	'wikia.cache',
	'wikia.log'
], function (adContext, pageViewCounter, timeUtil, cache, log) {
	'use strict';

	var cacheKey = 'adEngine_outstreamVideoFrequency',
		cacheTtl = cache.CACHE_LONG, // 1 month
		context = adContext.getContext(),
		store = [],
		logGroup = 'ext.wikia.adEngine.video.videoFrequencyStore';

	function removeNotNeededData(data) {
		var requiredNoOfItems = getRequiredNoOfItems();

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
		return (filterFunction ? store.filter(filterFunction) : store).length;
	}

	function numberOfVideosSeenInLastPageViews(numberOfCheckedPageViews) {
		var minPV = pageViewCounter.get() - numberOfCheckedPageViews;
		log(['minPV calculated', minPV], log.levels.debug, logGroup);

		return countAll(function (item) {
			return item.pv >= minPV;
		});
	}

	function numberOfVideosSeenInLast(value, unit) {
		var minDate = (new Date()).getTime() - timeUtil.getInterval(value, unit);
		log(['minDate calculated', minDate], log.levels.debug, logGroup);

		return countAll(function (item) {
			return item.date >= minDate;
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

	function getRequiredNoOfItems() {
		if (!context.opts.outstreamVideoFrequencyCapping || context.opts.outstreamVideoFrequencyCapping.length === 0) {
			return 0;
		}

		var max = Math.max.apply(null, context.opts.outstreamVideoFrequencyCapping.map(function (value) {
			return parseInt(value.split('/')[0], 10);
		}));

		return max ? max : 0;
	}

	function getAll() {
		var cachedData = cache.get(cacheKey) || store;

		return cachedData.filter(isValidData);
	}

	return {
		getAll: getAll,
		numberOfVideosSeenInLast: numberOfVideosSeenInLast,
		numberOfVideosSeenInLastPageViews: numberOfVideosSeenInLastPageViews,
		save: save
	};
});
