/*global Krux,define*/
window.Krux || ((Krux = function () {
	Krux.q.push(arguments);
}).q = []);

define('wikia.krux', ['wikia.window', 'wikia.document'], function (win, doc) {
	'use strict';

	var maxNumberOfKruxSegments = 27,
		kruxScriptId = 'krux-control-tag';

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

	function getSegments() {
		var segments = getParams('segs'),
			segsArray;

		if (segments === '') {
			return [];
		}

		segsArray = segments.split(',');
		if (segsArray.indexOf('ph3uhzc41') > maxNumberOfKruxSegments - 1) {
			segsArray.unshift('ph3uhzc41');
		}

		return segsArray.slice(0, maxNumberOfKruxSegments);
	}

	function getUser() {
		return getParams('user');
	}

	return {
		load: load,
		getSegments: getSegments,
		getUser: getUser
	};
});
