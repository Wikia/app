var RadiumOne = {};

(function(ns){
	var indexOf = Array.prototype.indexOf;
	
	function inArray(elem, array){
		if(indexOf)
			return indexOf.call(array, elem);

		for(var i = 0, length = array.length; i < length; i++){
			if(array[i] === elem)
				return i;
		}

		return -1;
	}
	
	function fetchCookieVal(offset) {
		var endstr = document.cookie.indexOf(";", offset);

		if(endstr == -1)
			endstr = document.cookie.length;

		return unescape(document.cookie.substring(offset, endstr));
	}
	
	function getCookie(name){
		var arg = name + "=",
		alen = arg.length,
		clen = document.cookie.length,
		i = 0;

		while(i < clen){
			var j = i + alen;
			if(document.cookie.substring(i, j) == arg)
				return fetchCookieVal(j);

			i = document.cookie.indexOf(" ", i) + 1;

			if(i == 0)
				break; 
		}

		return null;
	}
	
	ns.containerId = 'RadiumOne';
	ns.cookieName = 'raon';
	ns.enabledComscoreCats = ['Lifestyle', 'Entertainment'];
	ns.pixelUrl = 'http://rs.gwallet.com/r1/pixel/x2073r';
	
	ns.init = function(){
		if (window.wgIntegrateRadiumOne
		|| inArray(window.cscoreCat, RadiumOne.enabledComscoreCats) != -1) {
			// if no cookie, get pixel (which sets cookie)
			if (getCookie( RadiumOne.cookieName ) === null) {
				new Image().src = RadiumOne.pixelUrl+Math.round(Math.random()*10000000);
			}			
		}
	};
	
	ns.getDARTKeyValue = function(){
		var kv = '',
		value;

		if(
			window.wgIntegrateRadiumOne ||
			inArray(window.cscoreCat, RadiumOne.enabledComscoreCats) != -1
		) {
			value = getCookie(RadiumOne.cookieName) || 0;
			kv = 'ro='+value+';';
		}

		return kv;
	};
})(RadiumOne);

RadiumOne.init();