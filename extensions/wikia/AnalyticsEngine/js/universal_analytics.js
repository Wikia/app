/*!
 * Google Universal Analytics
 *
 * @version: 1
 */

require(['wikia.window', 'mw', 'wikia.trackingOptOut'], function (context, mw, trackingOptOut) {
	'use strict';

	if (!context.wgNoExternals && !trackingOptOut.isOptedOut()) {
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
		})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
	} else {
		// prevent errors when wgNoExternals is set or user is opted out
		context.ga = function () {};
		return;
	}

	var isProductionEnv,
		blockingTracked = {
			babDetector: false,
			pageFair: false
		},
		GASettings = {
			babDetector: {
				trackName: 'babDetector',
				dimension: 6,
				name: 'babdetector'
			},
			pageFair: {
				trackName: 'pageFair',
				dimension: 7,
				name: 'pagefair'
			}
		},
		listenerSettings = [
			{
				eventName: 'bab.blocking',
				value: true,
				detectorSettings: GASettings.babDetector
			},
			{
				eventName: 'bab.not_blocking',
				value: false,
				detectorSettings: GASettings.babDetector
			},
			{
				eventName: 'pf.blocking',
				value: true,
				detectorSettings: GASettings.pageFair
			},
			{
				eventName: 'pf.not_blocking',
				value: false,
				detectorSettings: GASettings.pageFair
			}
		],
		config = mw.config.get('wgUniversalAnalyticsConfiguration');

	/**
	 * Main Tracker
	 *
	 * To be used for everything that is not advertisement
	 */
	isProductionEnv = config.isProduction;

	// Main Roll-up Account - UA-32129070-1/UA-32129070-2
	if (isProductionEnv) {
		// Production Environment
		context.ga(
			'create', 'UA-32129070-1', 'auto',
			{
				'sampleRate': 100,
				'allowLinker': true,
				'userId': config.userIdHash

			}
		);
	} else {
		// Development Environment
		context.ga(
			'create', 'UA-32129070-2', 'auto',
			{
				'sampleRate': 100,
				'allowLinker': true,
				'userId': config.userIdHash
			}
		);
	}

	if (isProductionEnv) {
		// VE account - UA-32132943-4'
		context.ga(
			'create', 'UA-32132943-4', 'auto',
			{
				'name': 've',
				'sampleRate': 100,
				'allowLinker': true,
				'userId': config.userIdHash
			}
		);

		// Enable Demographics and Interests Reports
		context.ga('ve.require', 'displayfeatures');
	}

	// Enable Demographics and Interests Reports
	context.ga('require', 'displayfeatures');

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
				context.ga(args[i]);
				continue;
			} else if (args[i][0] === 'send' && args[i].length === 7) {
				args[i][6] = {'nonInteraction': args[i][6]};
			}
			context.ga.apply(window, args[i]);

			// Push to specific namespaces if method not already namespaced
			if (args[i][0].indexOf('.') === -1) {
				// If category is editor-ve, track for VE account
				if (args[i][1] && args[i][1] === 'editor-ve') {
					spec = args[i].slice();
					spec[0] = 've.' + spec[0];
					context.ga.apply(window, spec);
				}
			}
		}
	}

	function getEsrbRating() {
		var rating = 'not set';

		if (context.ads && context.ads.context.targeting.esrbRating) {
			rating = context.ads.context.targeting.esrbRating;
		}

		return rating;
	}

	function hasPortableInfobox() {
		if (context.ads && context.ads.context.targeting.hasPortableInfobox) {
			return 'Yes';
		}

		return 'No';
	}

	function hasFeaturedVideo() {
		if (context.ads && context.ads.context.targeting.hasFeaturedVideo) {
			return 'Yes';
		}

		return 'No';
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

		if (context.localStorage) {
			kruxSegments = (context.localStorage.kxsegs || '').split(',');
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

	function trackBlocking(detectorSettings, isBlocked) {
		var value = isBlocked ? 'Yes' : 'No';
		if (blockingTracked[detectorSettings.trackName]) {
			return;
		}
		blockingTracked[detectorSettings.trackName] = true;
		_gaWikiaPush(['set', 'dimension' + detectorSettings.dimension, value]);
		context.ga('ads.set', 'dimension' + detectorSettings.dimension, value);
		guaTrackAdEvent('ad/' + detectorSettings.name + '/detection', value, '', 0, true);
		guaTrackEvent('ads-' + detectorSettings.name + '-detection', 'impression', value, 0, true);
	}

	/**** High-Priority Custom Dimensions ****/
	_gaWikiaPush(
		['set', 'dimension1', context.wgDBname],                        // DBname
		['set', 'dimension2', context.wgContentLanguage],               // ContentLanguage
		['set', 'dimension3', context.cscoreCat],                       // Hub
		['set', 'dimension4', context.skin],                            // Skin
		['set', 'dimension5', !!context.wgUserName ? 'user' : 'anon']  // LoginStatus
	);

	/**** Medium-Priority Custom Dimensions ****/
	_gaWikiaPush(
		['set', 'dimension8', context.wikiaPageType],                                // PageType
		['set', 'dimension9', context.wgCityId],                                     // CityId
		['set', 'dimension13', getEsrbRating()],                                    // ESRB rating
		['set', 'dimension14', context.wgGaHasAds ? 'Yes' : 'No'],                   // HasAds
		['set', 'dimension15', context.wikiaPageIsCorporate ? 'Yes' : 'No'],         // IsCorporatePage
		['set', 'dimension16', getKruxSegment()],                                   // Krux Segment
		['set', 'dimension17', context.wgWikiVertical],                              // Vertical
		['set', 'dimension18', context.wgWikiCategories.join(',')],                  // Categories
		['set', 'dimension19', context.wgArticleType],                               // ArticleType
		['set', 'dimension20', 'not set'],                                          // Performance A/B testing (Not used any more)
		['set', 'dimension21', String(context.wgArticleId)],                         // ArticleId
		['set', 'dimension25', String(context.wgNamespaceNumber)],                   // Namespace Number
		['set', 'dimension27', String(context.wgCanonicalSpecialPageName || '')],    // Special page canonical name (SUS-1465)
		['set', 'dimension28', hasPortableInfobox()],                               // If there is Portable Infobox on the page (ADEN-4708)
		['set', 'dimension29', hasFeaturedVideo()]                                  // If there is Featured Video on the page (ADEN-5420)
	);

	/**** Include A/B testing status ****/
	if (context.Wikia && context.Wikia.AbTest) {
		var abList = context.Wikia.AbTest.getExperiments( /* includeAll */ true),
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
			abSlot = context.Wikia.AbTest.getGASlot(abExp.name);
			if (abSlot >= 40 && abSlot <= 49) {
				abGroupName = abExp.group ? abExp.group.name : (abList.nouuid ? 'NOBEACON' : 'NOT_IN_ANY_GROUP');
				_gaWikiaPush(['set', 'dimension' + abSlot, abGroupName]);
				abCustomVarsForAds.push(['ads.set', 'dimension' + abSlot, abGroupName]);
			}
		}
		if (abForceTrackOnLoad) {
			var abRenderStart = context.wgNow || (new Date()), abOnLoadHandler;

			abOnLoadHandler = function () {
				var renderTime = (new Date()).getTime() - abRenderStart.getTime();
				setTimeout(function () {
					context.guaTrackEvent('ABtest', 'ONLOAD', 'TIME', renderTime);
				}, 10);
			};
			// @see: http://stackoverflow.com/q/3763080/
			if (context.attachEvent) {
				context.attachEvent('onload', abOnLoadHandler);
			} else if (context.addEventListener) {
				context.addEventListener('load', abOnLoadHandler, false);
			}
		}
	}

	// Unleash
	_gaWikiaPush(['send', 'pageview']);

	if (context.ads && context.ads.context.opts.showAds) {
		listenerSettings.map(function (listenerSetting) {
			document.addEventListener(listenerSetting.eventName, function () {
				trackBlocking(listenerSetting.detectorSettings, listenerSetting.value);
			});
		});
	}

	/**
	 * Advertisement Tracker, pushed separatedly.
	 *
	 * To be used for all ad impression and click events
	 */
	// Advertisment Account UA-32129071-1/UA-32129071-2
	if (isProductionEnv) {
		context.ga(
			'create', 'UA-32129071-1', 'auto',
			{
				'name': 'ads',
				'sampleRate': 100,
				'allowLinker': true,
				'userId': config.userIdHash
			}
		);
	} else {
		context.ga(
			'create', 'UA-32129071-2', 'auto',
			{
				'name': 'ads',
				'sampleRate': 100,
				'allowLinker': true,
				'userId': config.userIdHash
			}
		);
	}

	// Enable Demographics and Interests Reports
	context.ga('ads.require', 'displayfeatures');

	/* Ads Account Custom Dimensions */
	context.ga('ads.set', 'dimension1', context.wgDBname);                                 // DBname
	context.ga('ads.set', 'dimension2', context.wgContentLanguage);                        // ContentLanguage
	context.ga('ads.set', 'dimension3', context.cscoreCat);                                // Hub
	context.ga('ads.set', 'dimension4', context.skin);                                     // Skin
	context.ga('ads.set', 'dimension5', !!context.wgUserName ? 'user' : 'anon');           // LoginStatus

	/**** Medium-Priority Custom Dimensions ****/
	context.ga('ads.set', 'dimension8', context.wikiaPageType);                            // PageType
	context.ga('ads.set', 'dimension9', context.wgCityId);                                 // CityId
	context.ga('ads.set', 'dimension13', getEsrbRating());                                // ESRB rating
	context.ga('ads.set', 'dimension14', context.wgGaHasAds ? 'Yes' : 'No');               // HasAds
	context.ga('ads.set', 'dimension15', context.wikiaPageIsCorporate ? 'Yes' : 'No');     // IsCorporatePage
	context.ga('ads.set', 'dimension16', getKruxSegment());                               // Krux Segment
	context.ga('ads.set', 'dimension17', context.wgWikiVertical);                          // Vertical
	context.ga('ads.set', 'dimension18', context.wgWikiCategories.join(','));              // Categories
	context.ga('ads.set', 'dimension19', context.wgArticleType);                           // ArticleType
	context.ga('ads.set', 'dimension20', 'not set');                                      // Performance A/B testing (not used any more)
	context.ga('ads.set', 'dimension21', String(context.wgArticleId));                     // ArticleId
	context.ga('ads.set', 'dimension25', String(context.wgNamespaceNumber));               // Namespace Number
	context.ga('ads.set', 'dimension27', String(context.wgCanonicalSpecialPageName || '')); // Special page canonical name (SUS-1465)
	context.ga('ads.set', 'dimension28', hasPortableInfobox());                            // If there is Portable Infobox on the page (ADEN-4708)
	context.ga('ads.set', 'dimension29', hasFeaturedVideo());                              // If there is Featured Video on the page (ADEN-5420)

	/**** Include A/B testing status ****/
	if (context.Wikia && context.Wikia.AbTest) {
		var i;
		for (i = 0; i < abCustomVarsForAds.length; i++) {
			context.ga.apply(window, abCustomVarsForAds[i]);
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
	context.guaTrackAdEvent = function (category, action, opt_label, opt_value, opt_noninteractive) {
		var args, adHitSample = 1; //1%
		if (Math.random() * 100 <= adHitSample) {
			args = Array.prototype.slice.call(arguments);

			if (args.length === 5) {
				args[4] = {'nonInteraction': args[4]};
			}

			args.unshift('ads.send', 'event');
			try {
				context.ga.apply(window, args);
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
	context.guaTrackEvent = function (category, action, opt_label, opt_value, opt_noninteractive) {
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
	context.guaTrackPageview = function (fakePage, opt_namespace) {
		var nsPrefix = (opt_namespace) ? opt_namespace + '.' : '';
		_gaWikiaPush([nsPrefix + 'send', 'pageview', fakePage]);
	};

	/**
	 * Set Custom Dimension
	 *
	 * @param {number|string} index
	 * @param {string} value
	 */
	context.guaSetCustomDimension = function (index, value) {
		_gaWikiaPush(['set', 'dimension' + index, value]);
	}

}(window));
