/**
 * Global Wikia Utilities.
 * Keep it short and reusable.
 */
(function(window) {
	'use strict';
	
	function cachebuster() {
		var cb = {};
	
		cb.setUrl = function(url) {
			window.location.href = url;
		};
		
		cb.getUrl = function() {
			return window.location.href;
		};
		
		cb.getRandomCb = function() {
			return Math.floor(Math.random()*10000);
		};

		/**
		 * Reloads current page with random cachebuster value
		 */
		cb.reloadPageWithCacheBuster = function() {
			var location = cb.getUrl();
			var delim = "?";
			if(location.indexOf("?") > 0){
				delim = "&";
			}
			cb.setUrl(location.split("#")[0] + delim + "cb=" + cb.getRandomCb());
		};
		
		return cb;
	}
	
	if (window.define && window.define.amd) {
		window.define('cachebuster', cachebuster);
	} else {
		window.Wikia = window.Wikia || {};
		window.Wikia.CacheBuster = cachebuster();
	}
	
})(window);