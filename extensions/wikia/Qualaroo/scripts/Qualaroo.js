( function ( window ) {
	'use strict';
	var _kiq = _kiq || [];
	setTimeout(function(){
		var d = document, f = d.getElementsByTagName('script')[0], s = d.createElement('script'); s.type = 'text/javascript';
		s.async = true; s.src = '//s3.amazonaws.com/ki.js/52510/bgJ.js'; f.parentNode.insertBefore(s, f);
	}, 1);
	if (window.wgUser) {
		_kiq.push(['identify', window.wgUser]);
	}
})( window );
