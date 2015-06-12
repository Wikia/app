/*!
 * Google Analytics customizations for "Wikia"
 *
 * ! Please don't touch this file without consulting Cardinal Path.
 *
 * @preserve Copyright(c) 2012 Cardinal Path
 * @author Eduardo Cereto <ecereto@cardinalpath.com>
 *
 * @version: prod_11
 */

(function (window, undefined) {
	'use strict';
	var possibleDomains, i, cookieExists, isProductionEnv;
	/**
	 * Main Tracker
	 *
	 * To be used for everything that is not advertisement
	 */
	window._gaq = window._gaq || [];
	isProductionEnv = !window.wgGaStaging;

	cookieExists = function (cookieName) {
		return document.cookie.indexOf(cookieName) > -1;
	};

	// Main Roll-up Account - UA-32129070-1/UA-32129070-2
	if (isProductionEnv) {
		window._gaq.push(['_setAccount', 'UA-32129070-1']); // PROD
	} else {
		window._gaq.push(['_setAccount', 'UA-32129070-2']); // DEV
	}

	if (!cookieExists('qualaroo_survey_submission')) {
		window._gaq.push(['_setSampleRate', '10']);
	} else {
		// 100% sampling for users who participated in Qualaroo survey
		window._gaq.push(['_setSampleRate', '100']);
	}

	if (window.wgIsGASpecialWiki) {
		// Special Wikis account - UA-32132943-1/UA-32132943-2
		if (isProductionEnv) {
			window._gaq.push(['special._setAccount', 'UA-32132943-1']); // PROD
		} else {
			window._gaq.push(['special._setAccount', 'UA-32132943-2']); // DEV
		}

		window._gaq.push(['special._setSampleRate', '100']); // No Sampling
	}

	if (isProductionEnv) {
		window._gaq.push(['ve._setAccount', 'UA-32132943-4']); // PROD
		window._gaq.push(['ve._setSampleRate', '100']); // No Sampling
	}

	/**
	 * Wrapper function to a generic _gaq push
	 *
	 * Has the same interface as a _gaq.push but behind the scenes it pushes
	 * to both the main account and the special account.
	 *
	 * Note that functions pushed into _gaq must be executed only once, so we
	 * treat that just in case, to avoid duplicated function calls if we
	 * decide to push a function inside _gaqWikiaPush.
	 *
	 * eg:
	 *    _gaqWikiaPush(['_trackPageview'], ['_trackEvent', 'cat', 'act']);
	 *
	 * @param {Array(string)[, ...]} commands - each Array is a command pushed to both
	 *    accounts
	 */
	function _gaqWikiaPush(commands) {
		var i, spec, args = Array.prototype.slice.call(arguments);
		for (i = 0; i < args.length; i++) {
			// If it's a function just push to _gaq
			if (typeof args[i] === 'function') {
				window._gaq.push(args[i]);
				continue;
			}

			window._gaq.push(args[i]);

			// Push to specific namespaces if method not already namespaced
			if (args[i][0].indexOf('.') === -1) {
				if (window.wgIsGASpecialWiki) {
					spec = args[i].slice();
					// Send to Special Wikis Account
					spec[0] = 'special.' + spec[0];
					window._gaq.push(spec);
				}

				// If category is editor-ve, track for VE account
				if (args[i][1] && args[i][1] === 'editor-ve') {
					spec = args[i].slice();
					spec[0] = 've.' + spec[0];
					window._gaq.push(spec);
				}
			}
		}
	}

	function getKruxSegment() {
		var kruxSegment = 'not set',
			uniqueKruxSegments = {
				ocry7a4xg: 'Game Heroes 2014',
				ocr1te1tc: 'Digital DNA 2014',
				ocr6m2jd6: 'Inquisitive Minds 2014',
				ocr05ve5z: 'Culture Caster 2014',
				ocr88oqh9: 'Social Entertainers 2014'
			},
			uniqueKruxSegmentsKeys = Object.keys(uniqueKruxSegments),
			markedSegments = [],
			kruxSegments = [];

		if (window.localStorage) {
			kruxSegments = (window.localStorage.kxsegs || '').split(',');
		}

		if (kruxSegments.length) {
			markedSegments = uniqueKruxSegmentsKeys.filter(function (n) {
				return kruxSegments.indexOf(n) !== -1;
			});
			if (markedSegments.length) {
				kruxSegment = uniqueKruxSegments[markedSegments[0]];
			}
		}

		return kruxSegment;
	}

	// All domains that host content for wikia.
	possibleDomains = ['wikia.com', 'ffxiclopedia.org', 'jedipedia.de',
		'marveldatabase.com', 'memory-alpha.org', 'uncyclopedia.org',
		'websitewiki.de', 'wowwiki.com', 'yoyowiki.org'
	];

	// Use one of the domains above. If none matches the tag will fallback to
	// the default which is 'auto', probably good enough in edge cases.
	for (i = 0; i < possibleDomains.length; i++) {
		if (document.location.hostname.indexOf(possibleDomains[i]) > -1) {
			_gaqWikiaPush(['_setDomainName', possibleDomains[i]]);
			break;
		}
	}

	/**** High-Priority CVs ****/
	_gaqWikiaPush(
		['_setCustomVar', 1, 'DBname', window.wgDBname, 3],
		['_setCustomVar', 2, 'ContentLanguage', window.wgContentLanguage, 3],
		['_setCustomVar', 3, 'Hub', window.cscoreCat, 3],
		['_setCustomVar', 4, 'Skin', window.skin, 3],
		['_setCustomVar', 5, 'LoginStatus', !!window.wgUserName ? 'user' : 'anon', 3]
	);

	/*
	 * Remove when SOC-217 ABTest is finished
	 */
	/**
	 * Get unconfirmed email AbTest user type
	 * @returns {string}
	 */
	function getUnconfirmedEmailUserType() {
			if (!window.wgUserName) {
				return 'anon';
			} else {
				switch (window.wgNotConfirmedEmail) {
				case '1':
					return 'unconfirmed';
				case '2':
					return 'confirmed';
				default:
					return 'old user';
				}
			}
		}
		/*
		 * end remove
		 */

	/**** Medium-Priority CVs ****/
	_gaqWikiaPush(
		['_setCustomVar', 8, 'PageType', window.wikiaPageType, 3],
		['_setCustomVar', 9, 'CityId', window.wgCityId, 3],
		['_setCustomVar', 14, 'HasAds', window.wgGaHasAds ? 'Yes' : 'No', 3],
		['_setCustomVar', 15, 'IsCorporatePage', window.wikiaPageIsCorporate ? 'Yes' : 'No', 3],
		['_setCustomVar', 16, 'Krux Segment', getKruxSegment(), 3],
		['_setCustomVar', 17, 'Vertical', window.wgWikiVertical, 3],
		['_setCustomVar', 18, 'Categories', window.wgWikiCategories.join(','), 3],
		['_setCustomVar', 19, 'ArticleType', window.wgArticleType, 3],

		/*
		 * Remove when SOC-217 ABTest is finished
		 */
		['_setCustomVar', 39, 'UnconfirmedEmailUserType', getUnconfirmedEmailUserType(), 3]
		/*
		 * end remove
		 */
	);

	/**** Include A/B testing status ****/
	if (window.Wikia && window.Wikia.AbTest) {
		var abList = window.Wikia.AbTest.getExperiments( /* includeAll */ true),
			abExp, abGroupName, abSlot, abIndex,
			abForceTrackOnLoad = false,
			abCustomVarsForAds = [];
		for (abIndex = 0; abIndex < abList.length; abIndex++) {
			abExp = abList[abIndex];
			if (!abExp || !abExp.flags) {
				continue;
			}
			if (!abExp.flags.ga_tracking) {
				continue;
			}
			if (abExp.flags.forced_ga_tracking_on_load && abExp.group) {
				abForceTrackOnLoad = true;
			}
			abSlot = window.Wikia.AbTest.getGASlot(abExp.name);
			if (abSlot >= 40 && abSlot <= 49) {
				abGroupName = abExp.group ? abExp.group.name : (abList.nouuid ? 'NOBEACON' : 'CONTROL');
				_gaqWikiaPush(['_setCustomVar', abSlot, abExp.name, abGroupName, 3]);
				abCustomVarsForAds.push(['ads._setCustomVar', abSlot, abExp.name, abGroupName, 3]);
			}
		}
		if (abForceTrackOnLoad) {
			var abRenderStart = window.wgNow || (new Date()), abOnLoadHandler;

			abOnLoadHandler = function () {
				var renderTime = (new Date()).getTime() - abRenderStart.getTime();
				setTimeout(function () {
					window.gaTrackEvent('ABtest', 'ONLOAD', 'TIME', renderTime);
				}, 10);
			};
			// @see: http://stackoverflow.com/q/3763080/
			if (window.attachEvent) {
				window.attachEvent('onload', abOnLoadHandler);
			} else if (window.addEventListener) {
				window.addEventListener('load', abOnLoadHandler, false);
			}
		}
	}

	// Unleash
	_gaqWikiaPush(['_trackPageview']);

	/**
	 * Advertisement Tracker, pushed separatedly.
	 *
	 * To be used for all ad impression and click events
	 */
	// Advertisment Account UA-32129071-1/UA-32129071-2
	if (isProductionEnv) {
		window._gaq.push(['ads._setAccount', 'UA-32129071-1']); // PROD
	} else {
		window._gaq.push(['ads._setAccount', 'UA-32129071-2']); // DEV
	}

	// Try to use the full domain to get a different cookie domain
	window._gaq.push(['ads._setDomainName', document.location.hostname]);

	/* Ads Account customVars */
	window._gaq.push(
		['ads._setCustomVar', 1, 'DBname', window.wgDBname, 3],
		['ads._setCustomVar', 2, 'ContentLanguage',window.wgContentLanguage, 3],
		['ads._setCustomVar', 3, 'Hub', window.cscoreCat, 3],
		['ads._setCustomVar', 4, 'Skin', window.skin, 3],
		['ads._setCustomVar', 5, 'LoginStatus', !!window.wgUserName ? 'user' : 'anon', 3]
	);

	/**** Medium-Priority CVs ****/
	window._gaq.push(
		['ads._setCustomVar', 8, 'PageType', window.wikiaPageType, 3],
		['ads._setCustomVar', 9, 'CityId', window.wgCityId, 3],
		['ads._setCustomVar', 14, 'HasAds', window.wgGaHasAds ? 'Yes' : 'No', 3],
		['ads._setCustomVar', 15, 'IsCorporatePage', window.wikiaPageIsCorporate ? 'Yes' : 'No', 3],
		['ads._setCustomVar', 16, 'Krux Segment', getKruxSegment(), 3],
		['ads._setCustomVar', 17, 'Vertical', window.wgWikiVertical, 3],
		['ads._setCustomVar', 18, 'Categories', window.wgWikiCategories.join(','), 3],
		['ads._setCustomVar', 19, 'ArticleType', window.wgArticleType, 3]
	);

	/**** Include A/B testing status ****/
	if (window.Wikia && window.Wikia.AbTest) {
		if (abCustomVarsForAds.length) {
			window._gaq.push.apply(window._gaq, abCustomVarsForAds);
		}
	}

	/**
	 * Function used by the backend to trigger advertisement events
	 *
	 * Will sample the advertisement hits and send them to the appropriate
	 * account.
	 *
	 * Has the same parameters as _trackEvent.
	 * eg:
	 *    gaTrackAdEvent('Impression', 'Top Banner', 'AdId');
	 *
	 * @param {string} category Event Category.
	 * @param {string} action Event Action.
	 * @param {string} [opt_label=""] Event Label.
	 * @param {number} [opt_value=0] Event Value. Have to be an integer.
	 * @param {boolean} [opt_noninteractive=false] Event noInteractive.
	 */
	window.gaTrackAdEvent = function (category, action, opt_label, opt_value, opt_noninteractive) {
		var args, adHitSample = 1; //1%
		if (Math.random() * 100 <= adHitSample) {
			args = Array.prototype.slice.call(arguments);
			args.unshift('ads._trackEvent');
			try {
				window._gaq.push(args);
			} catch (e) {}
		}
	};

	/**
	 * Function used by the backend to trigger non-advertisement events
	 *
	 * Will fire the event to Main account and Special wikis accounts
	 * respectig standard GA sampling for the main.
	 *
	 * Has the same parameters as _trackEvent.
	 * eg:
	 *    gaTrackEvent('Impression', 'Top Banner', 'AdId');
	 *
	 * @param {string} category Event Category.
	 * @param {string} action Event Action.
	 * @param {string} [opt_label=""] Event Label.
	 * @param {number} [opt_value=0] Event Value. Have to be an integer.
	 * @param {boolean} [opt_noninteractive=false] Event noInteractive.
	 */
	window.gaTrackEvent = function (category, action, opt_label, opt_value, opt_noninteractive) {
		var args = Array.prototype.slice.call(arguments);
		args.unshift('_trackEvent');
		try {
			_gaqWikiaPush(args);
		} catch (e) {}
	};

	/**
	 * Track a fake pageview in Google Analytics
	 *
	 * @param {string} fakePage The fake URL to track. This should begin with a leading '/'.
	 * @param {string} opt_namespace Namespace of the pageview. Used in GA reporting.
	 */
	window.gaTrackPageview = function (fakePage, opt_namespace) {
		var nsPrefix = (opt_namespace) ? opt_namespace + '.' : '';
		_gaqWikiaPush([nsPrefix + '_trackPageview', fakePage]);
	};

}(window));

(function (win, doc) {
	'use strict';
	if (!win.wgNoExternals) {
		var ga = doc.createElement('script'),
			firstScript = doc.getElementsByTagName('script')[0];

		ga.type = 'text/javascript';
		ga.async = true;
		ga.src = ('https:' === doc.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';

		firstScript.parentNode.insertBefore(ga, firstScript);
	}
})(window, document);
