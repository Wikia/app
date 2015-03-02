/*global define*/
/*jshint camelcase:false*/
/*jshint maxdepth:5*/
define('ext.wikia.adEngine.amazonMatch', [
	'ext.wikia.adEngine.adTracker',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adTracker, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.amazonMatch',
		amazonId = '3115',
		amazonResponse,
		amazonTiming,
		amazonCalled = false,
		targetingParams = [],
		amazonSlotsPattern = /^a([0-9]x[0-9])(p[0-9]+)$/;

	/**
	 * Returns price point from Amazon's slot name if it isn't found then return 0
	 *
	 * @param {string} slotName matching amazonSlotsPattern i.e. a1x6p14
	 * @returns {number}
	 */
	function getPricePoint(slotName) {
		var m = slotName.match(amazonSlotsPattern),
			res = 0;

		if (m && typeof m[2] !== undefined) {
			res = ~~m[2].substring(1);
		}

		return res;
	}

	/**
	 * Sorts Amazon's slot names by price point; use this function as an argument for sort() method
	 *
	 * @param {string} a first slot name
	 * @param {string} b second slot name
	 * @returns {number}
	 */
	function sortSlots(a, b) {
		var res = 0,
			indexA = getPricePoint(a),
			indexB = getPricePoint(b);

		if (indexA > indexB) {
			res = 1;
		}

		if (indexA < indexB) {
			res = -1;
		}

		return res;
	}

	/**
	 * Filters out slots - leaves only most valuable slots for each sizes
	 *
	 * @param {Array} slots
	 * @returns {Array}
	 */
	function filterSlots(slots) {
		var slotsBySize = {},
			filteredSlots = [],
			m;

		log(['filterSlots()::slots', slots], 'debug', logGroup);

		slots.sort(sortSlots);
		Object.keys(slots).forEach(function (key) {
			m = slots[key].match(amazonSlotsPattern);
			if (m && !slotsBySize[m[1]]) {
				slotsBySize[m[1]] = true;
				filteredSlots.push(m[0]);
			}
		});

		log(['filterSlots()::filteredSlots', filteredSlots], 'debug', logGroup);

		return filteredSlots;
	}

	function trackState(trackEnd) {
		log(['trackState', amazonResponse], 'debug', logGroup);

		var eventName,
			m,
			key,
			data = {};

		if (amazonResponse) {
			eventName = 'lookupSuccess';
			for (key in amazonResponse) {
				if (amazonResponse.hasOwnProperty(key)) {
					targetingParams.push(key);
					m = key.match(amazonSlotsPattern);
					if (m) {
						if (!data[m[2]]) {
							data[m[2]] = [];
						}
						data[m[2]].push(m[1]);
					}
				}
			}
		} else {
			eventName = 'lookupError';
		}

		if (trackEnd) {
			eventName = 'lookupEnd';
		}

		adTracker.track(eventName + '/amazon', data || '(unknown)', 0);
	}

	function onAmazonResponse(response) {
		amazonTiming.measureDiff({}, 'end').track();
		log(['onAmazonResponse', response], 'debug', logGroup);

		if (response.status === 'ok') {
			amazonResponse = response.ads;
		}

		trackState(true);
	}

	function renderAd(doc, adId) {
		log(['getPageParams', doc, adId, 'available: ' + !!amazonResponse[adId]], 'debug', logGroup);
		doc.write(amazonResponse[adId]);
	}

	function call() {
		log('call', 'debug', logGroup);

		amazonCalled = true;
		amazonTiming = adTracker.measureTime('amazon', {}, 'start');
		amazonTiming.track();

		// Mocking amazon "lib"
		win.amznads = {
			updateAds: onAmazonResponse,
			renderAd: renderAd
		};

		var url = encodeURIComponent(doc.location),
			s = doc.createElement('script'),
			cb = Math.round(Math.random() * 10000000);

		try { url = encodeURIComponent(win.top.location.href); } catch (ignore) {}

		s.id = logGroup;
		s.async = true;
		s.src = '//aax.amazon-adsystem.com/e/dtb/bid?src=' + amazonId + '&u=' + url + '&cb=' + cb;
		doc.body.appendChild(s);

	}

	function wasCalled() {
		log(['wasCalled', amazonCalled], 'debug', logGroup);
		return amazonCalled;
	}

	function getPageParams() {
		log(['getPageParams', targetingParams], 'debug', logGroup);
		return {
			amznslots: targetingParams
		};
	}

	return {
		call: call,
		getPageParams: getPageParams,
		filterSlots: filterSlots,
		trackState: function () { trackState(); },
		wasCalled: wasCalled
	};
});
