/*
 * Provides ResourceTiming performance stats for Bucky reporting
 *
 * They include:
 *  - number of assets fetched
 *  - type of assets fetched
 *  - number of assets fetched from browser's cache
 *  - time statistics
 *
 * @see PLATFORM-645
 * @see http://calendar.perfplanet.com/2012/an-introduction-to-the-resource-timing-api
 *
 * @author macbre
 */
define('bucky.resourceTiming', ['jquery', 'wikia.window', 'bucky'], function ($, window, bucky) {
	'use strict';

	var assetIdx = 0,
		wikiaAssetRegex = /^https?:\/\/([^\/]+)(\.wikia-dev\.com|\.wikia\.com|\.wikia\.nocookie\.net)\//;

	/**
	 * Check the support of ResourceTiming
	 * @returns {boolean}
	 *
	 * @see http://caniuse.com/#feat=resource-timing
	 */
	function isSupported() {
		return ('performance' in window) && (typeof window.performance.getEntriesByType === 'function');
	}

	/**
	 * Returns true if given asset comes from Wikia servers (including CDN and devboxes)
	 *
	 * @param {string} url URL to check
	 * @return {boolean} is this a Wikia asset?
	 */
	function isWikiaAsset(url) {
		return wikiaAssetRegex.test(url);
	}

	/**
	 * Get statistics for a given collection of PerformanceResourceTiming entries
	 *
	 * @param {array} resources
	 * @return object
	 */
	function getResourcesStats(resources) {
		var len, res,
			stats = {};

		/**
		 * Initialize stats entry for a given type
		 *
		 * @param {string} type
		 */
		function initStatsEntry(type) {
			stats[type] = {
				count: 0,
				time: 0
			};
		}

		/**
		 * Add an entry to statistics collection
		 *
		 * Measure total time and count entry of the same type
		 *
		 * @param {string} type
		 * @param {float} time
		 */
		function addStatsEntry(type, time) {
			if (typeof stats[type] !== 'undefined') {
				stats[type].count++;
				stats[type].time += time;
			}
		}

		['total', 'cached', '3rdparty', 'css', 'link', 'iframe', 'img', 'script', 'xmlhttprequest'].map(function(item) {
			initStatsEntry(item);
		});

		// we're "sharing" assetIdx between calls to getResourcesStats
		// each time it's called we only send statistics on assets that we've fetched
		// AFTER the previous call
		for (len=resources.length; assetIdx<len; assetIdx++) {
			res = resources[assetIdx];

			/**
			console.log(JSON.stringify({
				idx: assetIdx,
				type: res.initiatorType,
				url: res.name,
				duration: res.duration,
				dns: res.domainLookupStart ? res.domainLookupEnd - res.domainLookupStart : false,
				isWikiaAsset: isWikiaAsset(res.name)
			}));
			/**/

			// report duration (which includes assets being blocked!)
			// @see http://www.stevesouders.com/blog/2014/11/25/serious-confusion-with-resource-timing/
			addStatsEntry(res.initiatorType, res.duration);
			addStatsEntry('total', res.duration);

			// browser cache hit
			if (res.duration === 0) {
				addStatsEntry('cached', 0);
			}

			// 3rd-party assets
			if (!isWikiaAsset(res.name)) {
				addStatsEntry('3rdparty', res.duration);
			}
		}

		return stats;
	}

	/**
	 * Send resources stats to Bucky
	 *
	 * @param {string} eventName
	 */
	function reportToBucky(eventName) {
		var key, subkey, sink, stats;

		// iterate all resources
		stats = getResourcesStats(window.performance.getEntriesByType('resource') || []);

		// report to bucky
		sink = bucky('ResourceTiming.' + eventName);

		for (key in stats) {
			for (subkey in stats[key]) {
				sink.send(key + '.' + subkey, Math.round(stats[key][subkey]));
			}
		}
	}

	// public API
	return {
		isSupported: isSupported,
		isWikiaAsset: isWikiaAsset, // exposed for unit tests
		reportToBucky: reportToBucky
	};
});
