/* exported SevenOneMediaHelper */
/* jshint camelcase:false, maxparams:false */

var SevenOneMediaHelper = function (adLogicPageLevelParams, scriptWriter, log, window, $, tracker) {
	'use strict';

	var logGroup = 'SevenOneMediaHelper',
		postponedContainerId = 'seven-one-media-ads-postponed',
		$postponedContainer,
		myAd,
		initialized = false,
		pageLevelParams = adLogicPageLevelParams.getPageLevelParams(),
		targetingParamKeys = ['pform', 'media', 'gnre', 'egnre'],
		slotVars = {
			'popup1': {
				SOI_PU1: true,
				SOI_PL: true,    // powerlayer
				SOI_PU: false,   // popunder
				SOI_FA: false    // baseboard
			},
			'fullbanner2': {
				SOI_FB2: true,
				SOI_PB: true,    // powerbanner (728x180)
				SOI_PD: true,    // pushdown
				SOI_BB: true,    // billboard
				SOI_WP: true,    // wallpaper
				SOI_FP: true     // fireplace
			},
			'rectangle1': {
				SOI_RT1: true,
				SOI_HP: true     // halfpage (300x600)
			},
			'skyscraper1': {
				SOI_SC1: true,
				SOI_SB: true     // sidebar
			},
			'promo1': {
				SOI_PB1: true
			},
			'promo2': {
				SOI_PB2: true
			},
			'promo3': {
				SOI_PB3: true
			}
		},
		slotsQueue = [];

	function track(action) {
		log(['track', action], 'info', logGroup);

		tracker.track({
			eventName: 'liftium.71m',
			ga_category: '71m',
			ga_action: action,
			trackingMethod: 'ad'
		});
	}

	function insertAd(item) {
		var slotname,
			beforeFinish,
			afterFinish,
			postponedSlotId,
			$postponedSlot,
			script;

		slotname = item.slotname;
		beforeFinish = item.params && item.params.beforeFinish;
		afterFinish = item.params && item.params.afterFinish;

		log(['insertAd', slotname], 'info', logGroup);

		// Create the postponed div
		postponedSlotId = 'ad-' + slotname + '-postponed';
		$postponedSlot = $('<div/>').attr('id', postponedSlotId);
		$postponedContainer.append($postponedSlot);

		if (slotname === 'trackEnd') {
			script = '';
		} else {
			script = 'window.myAd && myAd.insertAd(' + JSON.stringify(slotname) + ');';
		}

		scriptWriter.injectScriptByText(
			postponedSlotId,
			script,
			function () {
				if (!myAd) {
					return;
				}

				log(['insertAd', slotname, 'myAd.insertAd done'], 'debug', logGroup);

				if (typeof beforeFinish === 'function') {
					log(['insertAd', slotname, 'calling beforeFinish'], 'debug', logGroup);
					beforeFinish({slotname: slotname});
				}

				if (slotname !== 'trackEnd') {
					log(['insertAd', slotname, 'calling myAd.finishAd'], 'debug', logGroup);
					myAd.finishAd(slotname, 'move');
					log(['insertAd', slotname, 'myAd.finishAd done'], 'debug', logGroup);
				}

				if (typeof afterFinish === 'function') {
					var info = {
						slotname: slotname,
						isSpecialAd: myAd.isSpecialAd(slotname)
					};
					log(['insertAd', slotname, 'calling afterFinish', info], 'debug', logGroup);
					afterFinish(info);
				}

				log(['insertAd', slotname, 'myAd.insertAd done callback executed'], 'debug', logGroup);
			}
		);
	}

	function setVars(vars) {
		var varName;

		log(['setVars', vars], 'debug', logGroup);

		for (varName in vars) {
			if (vars.hasOwnProperty(varName)) {
				window[varName] = vars[varName];
			}
		}
	}

	function injectJavaScripts(slotname, done, error) {
		var javaScriptsPlaceHolder = 'ad-' + slotname;

		scriptWriter.injectScriptByUrl(
			javaScriptsPlaceHolder,
			window.wgAdDriverSevenOneMediaCombinedUrl,
			function () {
				if (!window.SEVENONEMEDIA_CSS) {
					error('sevenonemedia_css');
					return;
				}
				if (!window.myAd) {
					error('my_ad_integration');
					return;
				}
				log('myAd loaded', 'info', logGroup);
				myAd = window.myAd;

				if (window.SOI_IDENTIFIER !== 'wikia') {
					error('wikia');
					return;
				}
				log('Sites/wikia.js loaded', 'info', logGroup);
				myAd.loaded.site = true;

				if (!window.SoiAP) {
					error('globalV6');
					return;
				}
				log('globalV6.js loaded', 'info', logGroup);
				myAd.loaded.global = true;

				done();
			}
		);
	}

	function generateSoiKeyValue() {
		var i, len, key, ret = {};
		for (i = 0, len = targetingParamKeys.length; i < len; i += 1) {
			key = targetingParamKeys[i];
			if (pageLevelParams[key] && pageLevelParams[key][0]) {
				ret[key] = pageLevelParams[key][0].substr(0, 10);
			}
		}
		return ret;
	}

	function initialize(firstSlotname) {
		var subsite = window.cscoreCat && window.cscoreCat.toLowerCase(),
			sub2site = pageLevelParams.s1.replace('_', ''),
			sub3site = subsite === 'lifestyle' && window.cityShort;

		initialized = true;

		log(['initialize'], 'debug', logGroup);

		setVars({
			SOI_SITE: 'wikia',
			SOI_SUBSITE: subsite,
			SOI_SUB2SITE: sub2site,
			SOI_SUB3SITE: sub3site,
			SOI_CONTENT: 'content',
			SOI_WERBUNG: true
		});

		setVars({SOI_KEYVALUE: generateSoiKeyValue()});

		$postponedContainer = $('<div/>').attr('id', postponedContainerId).hide();
		$('body').append($postponedContainer);

		track('stage/init');

		injectJavaScripts(firstSlotname, function () {
			/* done: */

			log('injectJavaScript success', 'info', logGroup);
			track('stage/scripts');

			// Apply CSS
			$('head').append('<style>' + window.SEVENONEMEDIA_CSS + '</style>');
			$('#WikiaTopAds').hide();

		}, function (what) {
			/* error: */

			log(['injectJavaScript failed', what], 'error', logGroup);
			track('error/scripts1');
		});
	}

	/**
	 * Flush pushed ads
	 */
	function flushAds() {
		if (!initialized) {
			return;
		}

		while (slotsQueue.length > 0) {
			insertAd(slotsQueue.shift());
		}
	}

	/**
	 * Push ad to the queue. (Flush the queue with flushAds)
	 *
	 * beforeFinish (optional) is a callback that will be run before calling myAd.finishAd
	 * afterFinish (optional) is a callback that will be run after myAd.finishAd
	 *
	 * @param slotname
	 * @param params {beforeFinish: callback, afterFinish: callback}
	 */
	function pushAd(slotname, params) {
		log(['pushAd', slotname, params], 'info', logGroup);

		if (!initialized) {
			initialize(slotname);
		}

		setVars(slotVars[slotname]);
		slotsQueue.push({slotname: slotname, params: params});
	}

	function trackEnd() {
		log('trackEnd', 'info', logGroup);
		insertAd({slotname: 'trackEnd', params: {
			afterFinish: function () {
				track('stage/ads');
			}
		}});
	}

	return {
		pushAd: pushAd,
		flushAds: flushAds,
		trackEnd: trackEnd
	};
};
