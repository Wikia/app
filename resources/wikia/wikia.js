/**
 * Global Wikia Utilities.
 * Keep it short and reusable.
 */
(function(window) {
	var Wikia = window.Wikia || {};
	
	/**
	 * Reloads current page with random cachebuster value
	 */
	Wikia.reloadPageWithCacheBuster = function() {
		var location = window.location.href;
		var delim = "?";
		if(location.indexOf("?") > 0){
			delim = "&";
		}
		window.location.href = location.split("#")[0] + delim + "cb=" + Math.floor(Math.random()*10000);
	};
	
})(window);