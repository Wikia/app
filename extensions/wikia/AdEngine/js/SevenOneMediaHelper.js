/* jshint camelcase:false, maxparams:false */
/*global define,require*/
define('ext.wikia.adEngine.sevenOneMediaHelper', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'jquery',
	require.optional('wikia.krux'),
	'wikia.log',
	'wikia.scriptwriter',
	'wikia.tracker',
	'wikia.window'
], function (adContext, adLogicPageParams, $, krux, log, scriptWriter, tracker, window) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.sevenOneMediaHelper',
		postponedContainerId = 'seven-one-media-ads-postponed',
		$postponedContainer,
		myAd,
		initialized = false,
		pageLevelParams = adLogicPageParams.getPageLevelParams(),
		soiKeywordsParams = ['pform', 'media', 'gnre', 'egnre', 's1'],
		soiKeywordsSegments = {
			'ocr05ve5z': true,
			'ocr1te1tc': true,
			'ocr2nqlbs': true,
			'ocry7a4xg': true,
			'ocr52415y': true,
			'ocr7jc18a': true,
			'ocr6m2jd6': true,
			'ocr8h7h1n': true,
			'ocr88oqh9': true
		},
		slotVars = {
			'popup1': {
				SOI_PU1: true,
				SOI_PL: false,   // powerlayer
				SOI_PU: false,   // popunder
				SOI_FA: false    // baseboard
			},
			'fullbanner2': {
				SOI_FB2: true,
				SOI_PB: true,    // powerbanner (728x180)
				SOI_PD: true,    // pushdown
				SOI_BB: true,    // billboard
				SOI_WP: true,    // wallpaper
				SOI_FP: false    // fireplace
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

	if (!window.wgOasisResponsive) {
		// turn off skyscrapers if it's not responsive Oasis view i.e. hubs pages (ADEN-1792)
		slotVars.skyscraper1.SOI_SC1 = false;
		slotVars.skyscraper1.SOI_SB = false;
	}

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
			adContext.getContext().providers.sevenOneMediaCombinedUrl,
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

				if (!window.globalV6) {
					error('globalV6');
					return;
				}
				log('globalV6.js loaded', 'info', logGroup);
				myAd.loaded.global = true;

				done();
			}
		);
	}

	/**
	 * Remove leading underscore from values.
	 * Keep all values max 10 chars and the whole string max 113 chars.
	 *
	 * @param {Array} keywords
	 * @returns {Array}
	 */
	function filterSoiKeywords(keywords) {
		log(['filterSoiKeywords', keywords], 'debug', logGroup);

		var i, len, val, retLen = 0, ret = [];

		for (i = 0, len = keywords.length; i < len; i += 1) {
			val = keywords[i].replace(/^_/, '').substr(0, 10);
			if (val) {
				retLen += val.length + 1; // include in calculations comma after each value
				if (retLen > 113) {
					break;
				}
				ret.push(val.substr(0, 10));
			}
		}

		log(['filterSoiKeywords', keywords, ret], 'debug', logGroup);

		return ret;
	}

	/**
	 * Generate SOI_KEYWORDS
	 *
	 * @returns {string}
	 */
	function generateSoiKeywords() {
		log('generateSoiKeywords', 'debug', logGroup);

		var i, len, param, val, valIndex, valLen, keywords = [], kruxSegments;

		// Get all values for params defined in soiKeywordsParams
		for (i = 0, len = soiKeywordsParams.length; i < len; i += 1) {

			param = soiKeywordsParams[i];
			val = pageLevelParams[param];

			if (typeof val === 'string') {
				val = [val];
			}

			if (val && val.length) {
				for (valIndex = 0, valLen = val.length; valIndex < valLen; valIndex += 1) {
					keywords.push(val[valIndex]);
				}
			}
		}

		if( krux ) {
			kruxSegments = krux.getSegments();
		}

		if (kruxSegments && kruxSegments.length) {
			for (i = 0, len = kruxSegments.length; i < len; i += 1) {
				if (soiKeywordsSegments[kruxSegments[i]]) {
					keywords.push(kruxSegments[i]);
				}
			}
		}

		log(['generateSoiKeywords', keywords], 'debug', logGroup);
		return filterSoiKeywords(keywords).join(',');
	}

	function initialize(firstSlotname) {
		var subsite, sub2site, sub3site, targeting = adContext.getContext().targeting;

		subsite = targeting.wikiVertical && targeting.wikiVertical.toLowerCase();

		if (targeting.sevenOneMediaSub2Site) {
			sub2site = targeting.sevenOneMediaSub2Site;
			sub3site = pageLevelParams.s1.replace('_', '');
		} else {
			sub2site = pageLevelParams.s1.replace('_', '');
			sub3site = subsite === 'lifestyle' ? targeting.wikiCategory : '';
		}

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

		setVars({SOI_KEYWORDS: generateSoiKeywords()});

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
	 * @param {String} slotname
	 * @param {Object} params {beforeFinish: callback, afterFinish: callback}
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
		if (initialized) {
			insertAd({slotname: 'trackEnd', params: {
				afterFinish: function () {
					track('stage/ads');
				}
			}});
		}
	}

	return {
		pushAd: pushAd,
		flushAds: flushAds,
		trackEnd: trackEnd
	};
});
