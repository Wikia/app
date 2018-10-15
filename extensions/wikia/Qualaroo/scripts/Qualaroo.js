require(['wikia.trackingOptIn', 'mw'], function (trackingOptIn, mw) {
	'use strict';

	var _kiq = [],
		createCookie,
		setABTestProperties;

	createCookie = function(cookieName) {
		document.cookie = cookieName + '=true;path=/;domain=' + mw.config.get('wgCookieDomain');
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
			s.async = true; s.src = mw.config.get('wgQualarooUrl'); f.parentNode.insertBefore(s, f);
		}, 1);
	}

	if (mw.config.get('wgUser')) {
		_kiq.push(['identify', mw.config.get('wgUser')]);
	}

	var dartGnreValues = window.dartGnreValues || [];

	_kiq.push(['set', {
		'userLanguage': mw.config.get('wgUserLanguage'),
		'contentLanguage': mw.config.get('wgContentLanguage'),
		'pageType': window.wikiaPageType,
		'isCorporatePage': (window.wikiaPageIsCorporate ? 'Yes' : 'No'),
		// canonical vertical only: 'Games', 'Entertainment', 'Lifestyle', 'Wikia'
		'verticalName': window.verticalName,
		// all verticals
		'fullVerticalName': window.fullVerticalName,
		'visitorType': window.visitorType,
		'isLoggedIn': !!mw.config.get('wgUserName'),
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

	trackingOptIn.pushToUserConsentQueue(function (optIn) {
		if (optIn === true) {
			loadQualaroo();
		}
	});

	setABTestProperties();

	window._kiq = _kiq;
});
