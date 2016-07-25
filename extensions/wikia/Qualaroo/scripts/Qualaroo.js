( function ( window ) {
	'use strict';
	var _kiq = [],
		createCookie;

	createCookie = function(cookieName) {
		var cookieValue = cookieName + '=true;path=/;domain=';
		if (window.location.host.indexOf('wikia-dev')) {
			cookieValue += '.wikia-dev.com';
		} else {
			cookieValue += '.wikia.com';
		}
		document.cookie = cookieValue;
	};

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
		'isCorporatePage': (window.wikiaPageIsCorporate ? 'Yes' : 'No'),
		'verticalName': window.verticalName,
		'visitorType': window.visitorType,
		'isPowerUserAdmin': !!window.wikiaIsPowerUserAdmin,
		'isPowerUserFrequent': !!window.wikiaIsPowerUserFrequent,
		'isPowerUserLifetime': !!window.wikiaIsPowerUserLifetime,
		'isLoggedIn': !!window.wgUserName
	}]);

	//This approach is hacky and we should use eventHandler provided by Qualaroo.
	//As soon as the fix they issue with it.
	$('body').on('mousedown', 'form[id*="ki-"] > div[class*="ki-"]', function() {
		window._gaq.push(['_setSampleRate', '100']);
		createCookie('qualaroo_survey_submission');
	});

	window._kiq = _kiq;
})( window );
