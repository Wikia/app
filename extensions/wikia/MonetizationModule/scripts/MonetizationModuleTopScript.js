/**
 * NOTE: This script must run before the page is rendered
 * in order to properly set the 'fromsearch' variable. Otherwise,
 * when the monetization modules from Monetization service renders
 * the values for the 'fromsearch' will be undefined an no modules
 * will render on the page.
 *
 * A script to determine if the user is referred by
 * a search engine. If so cookie the user for 30 minutes
 * so subsequent page requests by the same user is also
 * considered from search.
 */
(function (window, document) {
	'use strict';

	window.isFromSearch = function () {
		var ref = document.referrer;
		if (document.cookie.replace(/(?:(?:^|.*;\s*)fromsearch\s*\=\s*([^;]*).*$)|^.*$/, "$1") === "1") {
			return true;
		} else if (ref.match(/^https?:\/\/(www\.)?google(\.com?)?(\.[a-z]{2}t?)?\//i)) {
			return true;
		} else if (ref.indexOf('bing.com') !== -1 && ref.indexOf('q=') !== -1) {
			return true;
		} else if (ref.match(/^https?:\/\/r\.search\.yahoo\.com\/[^?]*$/i)) {
			return true;
		} else if (ref.indexOf('ask.com') !== -1 && ref.indexOf('q=') !== -1) {
			return true;
		} else if (ref.indexOf('aol.com') !== -1 && ref.indexOf('q=') !== -1) {
			return true;
		} else if (ref.indexOf('baidu.com') !== -1 && ref.indexOf('wd=') !== -1) {
			return true;
		} else if (ref.indexOf('yandex.com') !== -1 && ref.indexOf('text=') !== -1) {
			return true;
		}
		return false;
	};

	window.fromsearch = window.isFromSearch();
	if (window.fromsearch) {
		var date = new Date();
		date.setTime(date.getTime() + (30 * 60 * 1000));
		document.cookie = 'fromsearch=1; expires='+date.toGMTString()+'; path=/';
	}
	return window.fromsearch;
})(window, document);
