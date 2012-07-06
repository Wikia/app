(function(window){
	var jQueryRequested = false;
	window.getJqueryUrl = function() {
		var result = [];
		if (typeof window.jQuery == 'undefined' && jQueryRequested == false) {
			jQueryRequested = true;
			result = result.concat(window.wgJqueryUrl);
		}
		console.log && console.log('getJqueryUrl',result);
		return result;
	};
})(window);