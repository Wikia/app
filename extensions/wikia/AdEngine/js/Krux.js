'use strict';
// TODO: ADEN-1332-ize

// krux ad targeting. must come before dart urls are constructed
/*global Krux,define,unescape*/
window.Krux || ((Krux = function () {
	Krux.q.push(arguments);
}).q = []);

Krux.load = function (confid) {
	var k, m, src, s;
	k = document.createElement('script');
	k.type = 'text/javascript';
	k.async = true;
	src = (m = location.href.match(/\bkxsrc=([^&]+)\b/)) && decodeURIComponent(m[1]);
	k.src = src || (location.protocol === 'https:' ? 'https:' : 'http:') + '//cdn.krxd.net/controltag?confid=' + confid;
	s = document.getElementsByTagName('script')[0];
	s.parentNode.insertBefore(k, s);
};

(function () {
	function initKruxGlobalVars() {
		require(['ext.wikia.adEngine.adLogicPageParams'], function (adLogicPageParams) {
			var params, value;

			// Export page level params, so Krux can read them
			params = adLogicPageParams.getPageLevelParams();
			Object.keys(params).forEach(function (key) {
				value = params[key];
				if (value) {
					window['kruxDartParam_' + key] = value.toString();
				}
			});
		});
	}

	function initKrux() {
		function retrieve(n) {
			var m, k = 'kx' + n;
			if (window.localStorage) {
				return window.localStorage[k] || "";
			} else if (navigator.cookieEnabled) {
				m = document.cookie.match(k + '=([^;]*)');
				return (m && unescape(m[1])) || "";
			} else {
				return '';
			}
		}

		var kvs = [];
		Krux.user = retrieve('user');
		if (Krux.user) {
			kvs.push('u=' + Krux.user);
		}
		Krux.segments = retrieve('segs') && retrieve('segs').split(',') || [];
		for (var i = 0; i < Krux.segments.length; i++) {
			kvs.push('ksgmnt=' + Krux.segments[i]);
		}
		Krux.dartKeyValues = kvs.length ? kvs.join(';') + ';' : '';
	}

	var enableKrux;

	try {
		enableKrux = window.ads.context.targeting.enableKruxTargeting;
	} catch (ignore) {}

	if (enableKrux) {
		initKruxGlobalVars();
		initKrux();
	} else {
		Krux.dartKeyValues = '';
	}
}());

define('ext.wikia.adEngine.krux', function () {
	return Krux;
});

define('ext.wikia.adEngine.kruxPageParamsDecorator', function () {
	var maxNumberOfKruxSegments = 27; // keep the DART URL part for Krux segments below 500 chars

	function extendPageParams (params) {
		params.u = Krux.user;
		params.ksgmnt = Krux.segments && Krux.segments.slice(0, maxNumberOfKruxSegments);
	}

	return {
		extendPageParams: extendPageParams
	};
});
