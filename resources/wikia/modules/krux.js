/*global Krux, define, window*/
window.Krux || ((Krux = function () {
	Krux.q.push(arguments);
}).q = []);

define('wikia.krux', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker',
	'wikia.document',
	'wikia.tracker',
	'wikia.window'
], function (adContext, adTracker, doc, wikiaTracker, win) {
	'use strict';

	var maxNumberOfKruxSegments = 50,
		kruxScriptId = 'krux-control-tag',
		kruxLoaded = false,
		segmentsCountTracked = false;

	function exportPageParams(adLogicPageParams) {
		var params, value;

		if (Object.keys) {
			params = adLogicPageParams.getPageLevelParams();
			Object.keys(params).forEach(function (key) {
				value = params[key];
				if (value) {
					win['kruxDartParam_' + key] = value.toString();
				}
			});
		}
	}

	function addConfigScript(confid) {
		var k, m, src, s;

		k = document.createElement('script');
		k.type = 'text/javascript';
		k.id = kruxScriptId;
		k.async = true;
		src = (m = location.href.match(/\bkxsrc=([^&]+)\b/)) && decodeURIComponent(m[1]);
		k.src = src || (location.protocol === 'https:' ? 'https:' : 'http:') + '//cdn.krxd.net/controltag?confid=' + confid;
		s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(k, s);
	}

	function load(confid) {
		require([
			'ext.wikia.adEngine.adContext',
			'ext.wikia.adEngine.adLogicPageParams'
		], function (
			adContext,
			adLogicPageParams
		) {
			var script;
			if (adContext.getContext().targeting.enableKruxTargeting) {
				// Export page level params, so Krux can read them
				exportPageParams(adLogicPageParams);

				script = doc.getElementById(kruxScriptId);
				if (script) {
					script.parentNode.removeChild(script);
				}

				// Add Krux pixel
				addConfigScript(confid);
				kruxLoaded = true;

				// Add GA tracking
				adTracker.track('krux/load');
				wikiaTracker.track({
					category: 'ads-trackers',
					action: 'krux',
					label: 'load',
					value: 0,
					trackingMethod: 'analytics'
				});
			}
		});
	}

	function getParams(n) {
		var k = 'kx' + n;
		if (win.localStorage) {
			return win.localStorage[k] || '';
		} else {
			return '';
		}
	}

	function trackNumberOfSegments(numberOfSegments) {
		if (segmentsCountTracked) {
			return;
		}
		var label = numberOfSegments + '';
		while (label.length < 4) {
			label = '0' + label;
		}

		adTracker.track('krux/segments_count', {}, numberOfSegments, label);
		segmentsCountTracked = true;
	}

	function getSegments() {
		var segments = getParams('segs'),
			segsArray;

		if (segments === '') {
			trackNumberOfSegments(0);
			return [];
		}

		segsArray = segments.split(',');
		trackNumberOfSegments(segsArray.length);
		return segsArray.slice(0, maxNumberOfKruxSegments);
	}

	function getUser() {
		return getParams('user');
	}

	function sendEvent(eventId, data) {
		if (!kruxLoaded) {
			return false;
		}
		Krux('admEvent', eventId, data || {});
		return true;
	}

	// Mercury solution to track number of segments on each page view
	adContext.addCallback(function () {
		segmentsCountTracked = false;
	});

	return {
		load: load,
		getSegments: getSegments,
		getUser: getUser,
		sendEvent: sendEvent
	};
});
