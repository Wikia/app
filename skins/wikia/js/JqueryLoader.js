(function(window){
	var jQueryRequested = false;
	window.getJqueryUrl = function() {
		var result = [];
		if (typeof window.jQuery == 'undefined' && jQueryRequested == false) {
			jQueryRequested = true;
			result = result.concat(window.wgJqueryUrl);
		}
		return result;
	};
})(window);
