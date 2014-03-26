( function ( window ) {
	'use strict';
	var _kiq = _kiq || [];
	setTimeout(function(){
		var d = document, f = d.getElementsByTagName('script')[0], s = d.createElement('script'); s.type = 'text/javascript';
		s.async = true; s.src = window.wgQualarooUrl; f.parentNode.insertBefore(s, f);
	}, 1);
	if (window.wgUser) {
		_kiq.push(['identify', window.wgUser]);
	}
	_kiq.push(['set', {
		'userLanguage': window.wgUserLanguage,
		'contentLanguage': window.wgContentLanguage,
		'pageType': window.wikiaPageType,
		'isCorporatePage': window.wikiaPageIsCorporate,
		'verticalName': window.cscoreCat
	}]);
})( window );
