var RadiumOne = {
	containerId: 'RadiumOne',
	cookieName: 'raon',
	enabledComscoreCats: ['Lifestyle', 'Entertainment'],
	pixelUrl: 'http://rs.gwallet.com/r1/pixel/x2073r',
	
	init: function() {
		if (window.wgIntegrateRadiumOne
		|| $.inArray(window.cscoreCat, RadiumOne.enabledComscoreCats) != -1) {
			// if no cookie, get pixel (which sets cookie)
			if ($.cookies.get( RadiumOne.cookieName ) === null) {
				new Image().src = RadiumOne.pixelUrl+Math.round(Math.random()*10000000);
			}			
		}
	},
	
	getDARTKeyValue: function () {
		var kv = '';
		if (window.wgIntegrateRadiumOne
		|| $.inArray(window.cscoreCat, RadiumOne.enabledComscoreCats) != -1) {
			var value = $.cookies.get(RadiumOne.cookieName) || 0;
			kv = 'ro='+value+';';
		}
		return kv;
	}
	
};

RadiumOne.init();