( function ( window, document ) {
	'use strict';
	var _kiq = [],
		createCookie,
		setABTestProperties;

	createCookie = function(cookieName) {
		var cookieValue = cookieName + '=true;path=/;domain=',
			hostName = window.location.host,
			devDomainIndex = hostName.indexOf('wikia-dev');
		if (devDomainIndex > -1) {
			cookieValue += '.' + hostName.substr(devDomainIndex);
		} else {
			cookieValue += '.wikia.com';
		}
		document.cookie = cookieValue;
	};

	setABTestProperties = function () {
		var ABTestPrefix = 'ABTest_',
			ABTestProperties = {},
			isAnyABTestActive = false;

		Wikia.AbTest.getExperiments().forEach(function (experiment) {
			if (experiment.group) {
				ABTestProperties[ABTestPrefix + experiment.name] = experiment.group.name;
				isAnyABTestActive = true;
			}
		});

		if (isAnyABTestActive) {
			_kiq.push(['set', ABTestProperties]);
		}
	};

	function loadQualaroo () {
		setTimeout(function(){
			var d = document, f = d.getElementsByTagName('script')[0], s = d.createElement('script'); s.type = 'text/javascript';
			s.async = true; s.src = window.wgQualarooUrl; f.parentNode.insertBefore(s, f);
		}, 1);
	}

	function setAdBlockEnabledAndLoadQualaroo(enabled) {
		_kiq.push(['set', {
			'adBlockEnabled': enabled
		}]);
		loadQualaroo();
	}


	if (window.wgUser) {
		_kiq.push(['identify', window.wgUser]);
	}

	var dartGnreValues = window.dartGnreValues || [];

	_kiq.push(['set', {
		'userLanguage': window.wgUserLanguage,
		'contentLanguage': window.wgContentLanguage,
		'pageType': window.wikiaPageType,
		'isCorporatePage': (window.wikiaPageIsCorporate ? 'Yes' : 'No'),
		// canonical vertical only: 'Games', 'Entertainment', 'Lifestyle', 'Wikia'
		'verticalName': window.verticalName,
		// all verticals
		'fullVerticalName': window.fullVerticalName,
		'visitorType': window.visitorType,
		'isPowerUserAdmin': !!window.wikiaIsPowerUserAdmin,
		'isPowerUserFrequent': !!window.wikiaIsPowerUserFrequent,
		'isPowerUserLifetime': !!window.wikiaIsPowerUserLifetime,
		'isLoggedIn': !!window.wgUserName,
		'cpBenefitsModalShown': document.cookie.indexOf('cpBenefitsModalShown') > -1,
		'isContributor': window.isContributor,
		'isCurrentWikiAdmin': window.isCurrentWikiAdmin,
		'isDartGnreAdventure': dartGnreValues.indexOf('adventure') > -1,
		'isDartGnreAction': dartGnreValues.indexOf('action') > -1,
		'isDartGnreFantasy': dartGnreValues.indexOf('fantasy') > -1,
		'isDartGnreRpg':dartGnreValues.indexOf('rpg') > -1,
		'isDartGnreScifi': dartGnreValues.indexOf('scifi') > -1,
		'isDartGnreOpenworld': dartGnreValues.indexOf('openworld') > -1,
		'isDartGnreFighting': dartGnreValues.indexOf('fighting') > -1,
		'isDartGnreDrama': dartGnreValues.indexOf('drama') > -1,
		'isDartGnreCasual': dartGnreValues.indexOf('casual') > -1,
		'isDartGnreAnime': dartGnreValues.indexOf('anime') > -1,
		'isDartGnreShooter': dartGnreValues.indexOf('shooter') > -1,
		'isDartGnreCartoon': dartGnreValues.indexOf('cartoon') > -1,
		'isDartGnreComedy': dartGnreValues.indexOf('comedy') > -1,
		'isDartGnre3rdpersonshooter': dartGnreValues.indexOf('3rdpersonshooter') > -1,
		'isDartGnreFps': dartGnreValues.indexOf('fps') > -1,
		'isDartGnreHorror': dartGnreValues.indexOf('horror') > -1,
		'isDartGnreDriving': dartGnreValues.indexOf('driving') > -1,
		'isDartGnreSports': dartGnreValues.indexOf('sports') > -1
	}]);

	//This approach is hacky and we should use eventHandler provided by Qualaroo.
	//As soon as the fix they issue with it.
	$('body').on('mousedown', 'form[id*="ki-"] > div[class*="ki-"]', function() {
		window._gaq.push(['_setSampleRate', '100']);
		createCookie('qualaroo_survey_submission');
	});

	if (window.ads.context.opts.sourcePointDetection) {
		if (!window.ads.runtime || !window.ads.runtime.sp || window.ads.runtime.sp.blocking === undefined) {
			document.addEventListener('sp.blocking', function () {
				setAdBlockEnabledAndLoadQualaroo(true);
			});

			document.addEventListener('sp.not_blocking', function () {
				setAdBlockEnabledAndLoadQualaroo(false);
			});
		} else {
			setAdBlockEnabledAndLoadQualaroo(window.ads.runtime.sp.blocking);
		}
	} else {
		loadQualaroo();
	}

	setABTestProperties();

	window._kiq = _kiq;
})( window, document );
