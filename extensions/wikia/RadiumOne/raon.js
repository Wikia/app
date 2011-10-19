var RadiumOne = {
	containerId: 'RadiumOne',
	cookieName: 'raon',
	enabledComscoreCats: ['Lifestyle'],
	
	init: function() {
		if (window.wgIntegrateRadiumOne
		|| $.inArray(window.cscoreCat, RadiumOne.enabledComscoreCats) != -1) {
			// if no cookie, get pixel (which sets cookie)
			if (document.cookie.indexOf( RadiumOne.cookieName+'=' ) == -1) {
				$('#'+RadiumOne.containerId).append('<img src="http://rs.gwallet.com/r1/pixel/x2073r'+Math.round(Math.random()*10000000)+'" width="1" height="1" border="0" alt=""/>');
			}			
		}
	},
	
	getDARTKeyValue: function () {
		var value = 0;
		var cookie = $.cookies.get(RadiumOne.cookieName);
		if (cookie) {
			value = cookie;
			
		}
		var kv = 'ro='+value+';';
		return kv;
	}
	
};

RadiumOne.init();