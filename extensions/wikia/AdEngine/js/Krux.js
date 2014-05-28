// krux ad targeting. must come before dart urls are constructed
/*global Krux,define,unescape*/
window.Krux || ((Krux = function () {
	Krux.q.push(arguments);
}).q = []);
Krux.load = function (confid) {
	var k = document.createElement('script');
	k.type = 'text/javascript';
	k.async = true;
	var m, src = (m = location.href.match(/\bkxsrc=([^&]+)\b/)) && decodeURIComponent(m[1]);
	k.src = src || (location.protocol === 'https:' ? 'https:' : 'http:') + '//cdn.krxd.net/controltag?confid=' + confid;
	var s = document.getElementsByTagName('script')[0];
	s.parentNode.insertBefore(k, s);
};

if (window.wgEnableKruxTargeting) {
	(function () {
		'use strict';
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
	})();
} else {
	Krux.dartKeyValues = '';
}

define('ext.wikia.adEngine.krux', function () {
	'use strict';

	return Krux;
});
