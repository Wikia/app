var RadiumOne = {};

(function(ns){
	ns.containerId = 'RadiumOne';
	ns.cookieName = 'raon';
	ns.enabledComscoreCats = {'Lifestyle': 1, 'Entertainment': 1};
	ns.pixelUrl = 'http://rs.gwallet.com/r1/pixel/x2073r';
	
	ns.init = function(){
		if(
			window.wgIntegrateRadiumOne ||
			(window.cscoreCat in RadiumOne.enabledComscoreCats)
		){
			// if no cookie, get pixel (which sets cookie)
			if(Wikia.CookieCutter.get(RadiumOne.cookieName) === null){
				new Image().src = RadiumOne.pixelUrl+Math.round(Math.random()*10000000);
			}
		}
	};
	
	ns.getDARTKeyValue = function(){
		var kv = '',
		value;

		if(
			window.wgIntegrateRadiumOne ||
			(window.cscoreCat in RadiumOne.enabledComscoreCats)
		){
			value = Wikia.CookieCutter.get(RadiumOne.cookieName) || 0;
			kv = 'ro='+value+';';
		}

		return kv;
	};
})(RadiumOne);

RadiumOne.init();