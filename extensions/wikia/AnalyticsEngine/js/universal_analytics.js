/*!
 * Google Universal Analytics
 *
 * @version: 1
 */

(function (window, undefined) {
	'use strict';

	if (!window.wgNoExternals) {
		/**
		 * Creates a temporary global ga object and loads analy  tics.js.
		 * Paramenters o, a, and m are all used internally.  They could have been declared using 'var',
		 * instead they are declared as parameters to save 4 bytes ('var ').
		 *
		 * @param {Window}      i The global context object.
		 * @param {Document}    s The DOM document object.
		 * @param {string}      o Must be 'script'.
		 * @param {string}      g URL of the analytics.js script. Inherits protocol from page.
		 * @param {string}      r Global name of analytics object.  Defaults to 'ga'.
		 * @param {DOMElement?} a Async script tag.
		 * @param {DOMElement?} m First script tag in document.
		 */
		(function (i, s, o, g, r, a, m) {
			i['GoogleAnalyticsObject'] = r; // Acts as a pointer to support renaming.

			// Creates an initial ga() function.  The queued commands will be executed once analytics.js loads.
			i[r] = i[r] || function () {
					(i[r].q = i[r].q || []).push(arguments);
				},

				// Sets the time (as an integer) this tag was executed.  Used for timing hits.
				i[r].l = 1 * new Date ();

			// Insert the script tag asynchronously.  Inserts above current tag to prevent blocking in
			// addition to using the async attribute.
			a = s.createElement(o),
				m = s.getElementsByTagName(o)[0];
			a.async = 1;
			a.src = g;
			m.parentNode.insertBefore(a, m);
		})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
	} else {
		// prevent errors when wgNoExternals is set
		window.ga = function () {};
	}

	var cookieExists, isProductionEnv, blockingTracked = {
		sourcePoint: false,
		pageFair: false
	};

	/**
	 * Main Tracker
	 *
	 * To be used for everything that is not advertisement
	 */
	isProductionEnv = !window.wgGaStaging;

	cookieExists = function (cookieName) {
		return document.cookie.indexOf(cookieName) > -1;
	};

	// Main Roll-up Account - UA-32129070-1/UA-32129070-2
	if (isProductionEnv) {
		// Production Environment
		window.ga(
			'create', 'UA-32129070-1', 'auto',
			{
				'sampleRate': (cookieExists('qualaroo_survey_submission') ? 100 : 10),
				'allowLinker': true,
				'userId': window.wgGAUserIdHash

			}
		);
	} else {
		// Development Environment
		window.ga(
			'create', 'UA-32129070-2', 'auto',
			{
				'sampleRate': (cookieExists('qualaroo_survey_submission') ? 100 : 10),
				'allowLinker': true,
				'userId': window.wgGAUserIdHash
			}
		);
	}

	if (window.wgIsGASpecialWiki) {
		// Special Wikis account - UA-32132943-1/UA-32132943-2
		if (isProductionEnv) {
			// Production Environment
			window.ga(
				'create', 'UA-32132943-1', 'auto',
				{
					'name': 'special',
					'sampleRate': 100,
					'allowLinker': true,
					'userId': window.wgGAUserIdHash
				}
			);
		} else {
			// Development Environment
			window.ga(
				'create', 'UA-32132943-2', 'auto',
				{
					'name': 'special',
					'sampleRate': 100,
					'allowLinker': true,
					'userId': window.wgGAUserIdHash
				}
			);
		}

		// Enable Demographics and Interests Reports
		window.ga('special.require', 'displayfeatures');
	}

	if (window.wgGAUserIdHash) {
		// Separate account for Logged-In users - UA-32132943-7/UA-32132943-8
		if (isProductionEnv) {
			// Production Environment
			window.ga(
				'create', 'UA-32132943-7', 'auto',
				{
					'name': 'loggedin_users',
					'sampleRate': 100,
					'allowLinker': true,
					'userId': window.wgGAUserIdHash
				}
			);
		} else {
			// Development Environment
			window.ga(
				'create', 'UA-32132943-8', 'auto',
				{
					'name': 'loggedin_users',
					'sampleRate': 100,
					'allowLinker': true,
					'userId': window.wgGAUserIdHash
				}
			);

			// Enable Demographics and Interests Reports
			window.ga('loggedin_users.require', 'displayfeatures');
		}
	}

	if (isProductionEnv) {
		// VE account - UA-32132943-4'
		window.ga(
			'create', 'UA-32132943-4', 'auto',
			{
				'name': 've',
				'sampleRate': 100,
				'allowLinker': true,
				'userId': window.wgGAUserIdHash
			}
		);

		// Enable Demographics and Interests Reports
		window.ga('ve.require', 'displayfeatures');
	}

	// Enable Demographics and Interests Reports
	window.ga('require', 'displayfeatures');

	/**
	 * Wrapper function to a generic ga() function call.
	 *
	 * Has the same interface as a ga() but behind the scenes it pushes
	 * to both the main account and the special account.
	 *
	 * Note that functions pushed into ga() must be executed only once, so we
	 * treat that just in case, to avoid duplicated function calls if we
	 * decide to push a function inside _gaWikiaPush.
	 *
	 * eg:
	 *    _gaWikiaPush(['send', 'pageview'], ['send', 'cat', 'act']);
	 *
	 * @param {Array(string)[, ...]} commands - each Array is a command pushed to both
	 *    accounts
	 */
	function _gaWikiaPush(commands) {
		var i, spec, args = Array.prototype.slice.call(arguments);
		for (i = 0; i < args.length; i++) {
			// If it's a function just push to Google UA
			if (typeof args[i] === 'function') {
				window.ga(args[i]);
				continue;
			} else if (args[i][0] === 'send' && args[i].length === 7) {
				args[i][6] = {'nonInteraction': args[i][6]};
			}
			window.ga.apply(window, args[i]);

			// Push to specific namespaces if method not already namespaced
			if (args[i][0].indexOf('.') === -1) {
				if (window.wgIsGASpecialWiki) {
					spec = args[i].slice();
					// Send to Special Wikis Account
					spec[0] = 'special.' + spec[0];
					window.ga.apply(window, spec);
				}

				// If user is logged in we send to Logged-In Users Account
				if (window.wgGAUserIdHash) {
					spec = args[i].slice();
					spec[0] = 'loggedin_users.' + spec[0];
					window.ga.apply(window, spec);
				}

				// If category is editor-ve, track for VE account
				if (args[i][1] && args[i][1] === 'editor-ve') {
					spec = args[i].slice();
					spec[0] = 've.' + spec[0];
					window.ga.apply(window, spec);
				}
			}
		}
	}

	function getEsrbRating() {
		var rating = 'not set';

		if (window.ads && window.ads.context.targeting.esrbRating) {
			rating = window.ads.context.targeting.esrbRating;
		}

		return rating;
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

	function trackBlocking(value) {
		if (blockingTracked.sourcePoint) {
			return;
		}
		blockingTracked.sourcePoint = true;
		_gaWikiaPush(['set', 'dimension6', value]);
		window.ga('ads.set', 'dimension6', value);
		guaTrackAdEvent('ad/sourcepoint/detection', value, '', 0, true);
		guaTrackEvent('ads-sourcepoint-detection', 'impression', value, 0, true);
	}

	function trackBlockingPageFair(isBlocked) {
		var pageFairDimension = 'dimension7',
			value = isBlocked ? 'Yes' : 'No'
		;

		if (blockingTracked.pageFair) {
			return;
		}
		blockingTracked.pageFair = true;

		_gaWikiaPush(['set', pageFairDimension, value]);
		window.ga('ads.set', pageFairDimension, value);
		guaTrackAdEvent('ad/pagefair/detection', value, '', 0, true);
		guaTrackEvent('ads-pagefair-detection', 'impression', value, 0, true);
	}

	/**** High-Priority Custom Dimensions ****/
	_gaWikiaPush(
		['set', 'dimension1', window.wgDBname],                        // DBname
		['set', 'dimension2', window.wgContentLanguage],               // ContentLanguage
		['set', 'dimension3', window.cscoreCat],                       // Hub
		['set', 'dimension4', window.skin],                            // Skin
		['set', 'dimension5', !!window.wgUserName ? 'user' : 'anon']  // LoginStatus
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

	/**** Medium-Priority Custom Dimensions ****/
	_gaWikiaPush(
		['set', 'dimension8', window.wikiaPageType],                            // PageType
		['set', 'dimension9', window.wgCityId],                                 // CityId
		['set', 'dimension13', getEsrbRating()],                                // ESRB rating
		['set', 'dimension14', window.wgGaHasAds ? 'Yes' : 'No'],               // HasAds
		['set', 'dimension15', window.wikiaPageIsCorporate ? 'Yes' : 'No'],     // IsCorporatePage
		['set', 'dimension16', getKruxSegment()],                               // Krux Segment
		['set', 'dimension17', window.wgWikiVertical],                          // Vertical
		['set', 'dimension18', window.wgWikiCategories.join(',')],              // Categories
		['set', 'dimension19', window.wgArticleType],                           // ArticleType
		['set', 'dimension20', window.wgABPerformanceTest || 'not set'],        // Performance A/B testing
		['set', 'dimension21', String(window.wgArticleId)],                     // ArticleId
		['set', 'dimension23', window.wikiaIsPowerUserFrequent ? 'Yes' : 'No'], // IsPowerUser: Frequent
		['set', 'dimension24', window.wikiaIsPowerUserLifetime ? 'Yes' : 'No'], // IsPowerUser: Lifetime
		['set', 'dimension25', String(window.wgNamespaceNumber)],               // Namespace Number
		['set', 'dimension26', String(window.wgSeoTestingBucket || 0)]          // SEO Testing bucket
	);

	/*
	 * Remove when SOC-217 ABTest is finished
	 */
	_gaWikiaPush(['set', 'dimension39', getUnconfirmedEmailUserType()]);      // UnconfirmedEmailUserType
	/*
	 * end remove
	 */

	/**
	 * Checks if Optimizely object and its crucial data attributes are available
	 *
	 * @returns {boolean}
	 */
	function isOptimizelyLoadedAndActive() {
		var optimizely = window.optimizely;

		return optimizely &&
			optimizely.activeExperiments &&
			Array.isArray(optimizely.activeExperiments) &&
			optimizely.activeExperiments.length > 0 &&
			typeof optimizely.allExperiments === 'object' &&
			Object.keys(optimizely.allExperiments).length > 0 &&
			typeof optimizely.variationNamesMap === 'object' &&
			Object.keys(optimizely.variationNamesMap).length > 0;
	}

	// UA integration code is also used in Mercury SPA - if you change it here, change it there too:
	// function integrateOptimizelyWithUA and above in
	// https://github.com/Wikia/mercury/blob/dev/front/scripts/mercury/utils/variantTesting.ts
	if (isOptimizelyLoadedAndActive()) {
		var optimizely = window.optimizely;

		optimizely.activeExperiments.forEach(function (experimentId) {
			if (
				optimizely.allExperiments.hasOwnProperty(experimentId) &&
				typeof optimizely.allExperiments[experimentId].universal_analytics === 'object'
			) {
				var dimension = optimizely.allExperiments[experimentId].universal_analytics.slot,
					experimentName = optimizely.allExperiments[experimentId].name,
					variationName = optimizely.variationNamesMap[experimentId];

				_gaWikiaPush([
					'set',
					'dimension' + dimension,
					'Optimizely ' + experimentName + ' (' + experimentId + '): ' + variationName
				]);
			}
		});
	}

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
				abGroupName = abExp.group ? abExp.group.name : (abList.nouuid ? 'NOBEACON' : 'NOT_IN_ANY_GROUP');
				_gaWikiaPush(['set', 'dimension' + abSlot, abGroupName]);
				abCustomVarsForAds.push(['ads.set', 'dimension' + abSlot, abGroupName]);
			}
		}
		if (abForceTrackOnLoad) {
			var abRenderStart = window.wgNow || (new Date()), abOnLoadHandler;

			abOnLoadHandler = function () {
				var renderTime = (new Date()).getTime() - abRenderStart.getTime();
				setTimeout(function () {
					window.guaTrackEvent('ABtest', 'ONLOAD', 'TIME', renderTime);
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
	_gaWikiaPush(['send', 'pageview']);

	if (window.ads && window.ads.context.opts.showAds) {
		document.addEventListener('sp.blocking', function () {
			window.ads.runtime.sp.blocking = true;
			trackBlocking('Yes');
		});
		document.addEventListener('sp.not_blocking', function () {
			window.ads.runtime.sp.blocking = false;
			trackBlocking('No');
		});

		document.addEventListener('pf.blocking', function () {
			trackBlockingPageFair(true);
		});
		document.addEventListener('pf.not_blocking', function () {
			trackBlockingPageFair(false);
		});
	}

	/**
	 * Advertisement Tracker, pushed separatedly.
	 *
	 * To be used for all ad impression and click events
	 */
	// Advertisment Account UA-32129071-1/UA-32129071-2
	if (isProductionEnv) {
		window.ga(
			'create', 'UA-32129071-1', 'auto',
			{
				'name': 'ads',
				'sampleRate': 100,
				'allowLinker': true,
				'userId': window.wgGAUserIdHash
			}
		);
	} else {
		window.ga(
			'create', 'UA-32129071-2', 'auto',
			{
				'name': 'ads',
				'sampleRate': 100,
				'allowLinker': true,
				'userId': window.wgGAUserIdHash
			}
		);
	}

	// Enable Demographics and Interests Reports
	window.ga('ads.require', 'displayfeatures');

	/* Ads Account Custom Dimensions */
	window.ga('ads.set', 'dimension1', window.wgDBname);                                 // DBname
	window.ga('ads.set', 'dimension2', window.wgContentLanguage);                        // ContentLanguage
	window.ga('ads.set', 'dimension3', window.cscoreCat);                                // Hub
	window.ga('ads.set', 'dimension4', window.skin);                                     // Skin
	window.ga('ads.set', 'dimension5', !!window.wgUserName ? 'user' : 'anon');           // LoginStatus

	/**** Medium-Priority Custom Dimensions ****/
	window.ga('ads.set', 'dimension8', window.wikiaPageType);                            // PageType
	window.ga('ads.set', 'dimension9', window.wgCityId);                                 // CityId
	window.ga('ads.set', 'dimension13', getEsrbRating());                                // ESRB rating
	window.ga('ads.set', 'dimension14', window.wgGaHasAds ? 'Yes' : 'No');               // HasAds
	window.ga('ads.set', 'dimension15', window.wikiaPageIsCorporate ? 'Yes' : 'No');     // IsCorporatePage
	window.ga('ads.set', 'dimension16', getKruxSegment());                               // Krux Segment
	window.ga('ads.set', 'dimension17', window.wgWikiVertical);                          // Vertical
	window.ga('ads.set', 'dimension18', window.wgWikiCategories.join(','));              // Categories
	window.ga('ads.set', 'dimension19', window.wgArticleType);                           // ArticleType
	window.ga('ads.set', 'dimension21', String(window.wgArticleId));                     // ArticleId
	window.ga('ads.set', 'dimension21', String(window.wgArticleId));                     // ArticleId
	window.ga('ads.set', 'dimension23', window.wikiaIsPowerUserFrequent ? 'Yes' : 'No'); // IsPowerUser: Frequent
	window.ga('ads.set', 'dimension24', window.wikiaIsPowerUserLifetime ? 'Yes' : 'No'); // IsPowerUser: Lifetime
	window.ga('ads.set', 'dimension25', String(window.wgNamespaceNumber));               // Namespace Number
	window.ga('ads.set', 'dimension26', String(window.wgSeoTestingBucket || 0));         // SEO Testing bucket

	/**** Include A/B testing status ****/
	if (window.Wikia && window.Wikia.AbTest) {
		var i;
		for (i = 0; i < abCustomVarsForAds.length; i++) {
			window.ga.apply(window, abCustomVarsForAds[i]);
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
	 *    guaTrackAdEvent('Impression', 'Top Banner', 'AdId');
	 *
	 * @param {string} category Event Category.
	 * @param {string} action Event Action.
	 * @param {string} [opt_label=""] Event Label.
	 * @param {number} [opt_value=0] Event Value. Have to be an integer.
	 * @param {boolean} [opt_noninteractive=false] Event noInteractive.
	 */
	window.guaTrackAdEvent = function (category, action, opt_label, opt_value, opt_noninteractive) {
		var args, adHitSample = 1; //1%
		if (Math.random() * 100 <= adHitSample) {
			args = Array.prototype.slice.call(arguments);

			if (args.length === 5) {
				args[4] = {'nonInteraction': args[4]};
			}

			args.unshift('ads.send', 'event');
			try {
				window.ga.apply(window, args);
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
	window.guaTrackEvent = function (category, action, opt_label, opt_value, opt_noninteractive) {
		var args = Array.prototype.slice.call(arguments);

		args.unshift('send', 'event');
		try {
			_gaWikiaPush(args);
		} catch (e) {}
	};

	/**
	 * Track a fake pageview in Google Analytics
	 *
	 * @param {string} fakePage The fake URL to track. This should begin with a leading '/'.
	 * @param {string} opt_namespace Namespace of the pageview. Used in GA reporting.
	 */
	window.guaTrackPageview = function (fakePage, opt_namespace) {
		var nsPrefix = (opt_namespace) ? opt_namespace + '.' : '';
		_gaWikiaPush([nsPrefix + 'send', 'pageview', fakePage]);
	};

}(window));
