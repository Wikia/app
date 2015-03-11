'use strict';

/*global Krux,define*/
window.Krux || ((Krux = function () {
	Krux.q.push(arguments);
}).q = []);

define('wikia.krux', function () {
	var maxNumberOfKruxSegments = 27;

	function load(confid) {
		require([
			'ext.wikia.adEngine.adContext',
			'ext.wikia.adEngine.adLogicPageParams'
		], function (
			adContext,
			adLogicPageParams
		) {
			var params, value, k, m, src, s;

			if (adContext.getContext().targeting.enableKruxTargeting) {
				// Export page level params, so Krux can read them
				params = adLogicPageParams.getPageLevelParams();
				Object.keys(params).forEach(function (key) {
					value = params[key];
					if (value) {
						window['kruxDartParam_' + key] = value.toString();
					}
				});

				k = document.createElement('script');
				k.type = 'text/javascript';
				k.async = true;
				src = (m = location.href.match(/\bkxsrc=([^&]+)\b/)) && decodeURIComponent(m[1]);
				k.src = src || (location.protocol === 'https:' ? 'https:' : 'http:') + '//cdn.krxd.net/controltag?confid=' + confid;
				s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(k, s);
			}
		});
	}

	function getParams(n) {
		var k = 'kx' + n;
		if (window.localStorage) {
			return window.localStorage[k] || '';
		} else {
			return '';
		}
	}

	function getDartSegmentsLimit() {
		return maxNumberOfKruxSegments;
	}

	return {
		load: load,
		getParams: getParams,
		getDartSegmentsLimit: getDartSegmentsLimit
	};
});
