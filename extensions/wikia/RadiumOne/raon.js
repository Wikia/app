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
	
	function getCookie(cookieName){
		var cookies = {},
			pair, name, value,
			separated = document.cookie.split(';');
		
		for(var i = 0; i < separated.length; i = i + 1){
			pair = separated[i].split( '=' );
			name = pair[0].replace( /^\s*/, '' ).replace( /\s*$/, '' );
			value = decodeURIComponent( pair[1] );
			cookies[name] = value;
		}
		
		return (typeof cookies[cookieName] !== 'undefined' ) ? cookies[cookieName] : null;
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