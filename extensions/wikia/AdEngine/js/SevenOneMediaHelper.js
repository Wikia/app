/*global require*/

var SevenOneMediaHelper = function (adLogicPageLevelParams, scriptWriter, log, window, $) {
	'use strict';

	var logGroup = 'SevenOneMediaHelper',
		postponedContainerId = 'seven-one-media-ads-postponed',
		$postponedContainer,
		myAd,
		initialized = false,
		flushCalled = false,
		allLoaded = false,
		pageLevelParams = adLogicPageLevelParams.getPageLevelParams(),
		firstSlotname,
		slotVars = {
			'popup1': {
				SOI_PU1: true,
				SOI_PL: true,    // powerlayer
				SOI_PU: false,   // popunder,
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

	function shiftQueue() {
		var item = slotsQueue.shift(),
			slotname,
			beforeFinish,
			afterFinish,
			postponedSlotId,
			$postponedSlot;

		if (!item) {
			log(['shiftQueue', 'queue over'], 'info', logGroup);
			return;
		}

		slotname = item.slotname;
		beforeFinish = item.params && item.params.beforeFinish;
		afterFinish = item.params && item.params.afterFinish;

		log(['shiftQueue', slotname], 'info', logGroup);

		// Create the postponed div
		postponedSlotId = 'ad-' + slotname + '-postponed';
		$postponedSlot = $('<div></div>').attr('id', postponedSlotId);
		$postponedContainer.append($postponedSlot);

		scriptWriter.injectScriptByText(
			postponedSlotId,
			'myAd.insertAd(' + JSON.stringify(slotname) + ');',
			function () {
				log(['shiftQueue', slotname, 'myAd.insertAd done'], 'info', logGroup);

				if (typeof beforeFinish === 'function') {
					log(['shiftQueue', slotname, 'calling beforeFinish'], 'info', logGroup);
					beforeFinish({slotname: slotname});
				}

				log(['shiftQueue', slotname, 'calling myAd.finishAd'], 'info', logGroup);
				myAd.finishAd(slotname, 'move');
				log(['shiftQueue', slotname, 'myAd.finishAd done'], 'info', logGroup);

				if (typeof afterFinish === 'function') {
					var info = {
						slotname: slotname,
						isSpecialAd: myAd.isSpecialAd(slotname)
					};
					log(['shiftQueue', slotname, 'calling afterFinish', info], 'info', logGroup);
					afterFinish(info);
				}

				shiftQueue();
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

	function initialize() {
		var vars,
			s0 = pageLevelParams.s0,
			s1 = pageLevelParams.s1.replace('_', '');

		initialized = true;

		log(['initialize'], 'debug', logGroup);

		vars = {
			SOI_SITE: 'wikia',
			SOI_SUBSITE: s0,
			SOI_SUB2SITE: s1,
			SOI_SUB3SITE: '',
			SOI_CONTENT: 'content',
			SOI_WERBUNG: true
		};

		setVars(vars);

		$postponedContainer = $('<div></div>').attr('id', postponedContainerId).hide();
		$('body').append($postponedContainer);
	}

	function injectStyles(done) {
		require(['wikia.loader'], function (loader) {
			loader('/extensions/wikia/AdEngine/SevenOneMedia/my_ad_integration.css').done(
				function () {
					$('#WikiaTopAds').hide();
					done();
				}
			);
		});
	}

	function injectJavaScripts(slotname, done, error) {
		var javaScriptsPlaceHolder = 'ad-' + slotname,
			myAdJsUrl = window.wgCdnRootUrl + window.wgAssetsManagerQuery.
				replace('%1$s', 'one').
				replace('%2$s', 'extensions/wikia/AdEngine/SevenOneMedia/my_ad_integration.js').
				replace('%3$s', '-').
				replace('%4$d', window.wgStyleVersion);

		scriptWriter.injectScriptByUrl(
			javaScriptsPlaceHolder,
			myAdJsUrl,
			function () {
				if (!window.myAd) {
					error('my_ad_integration');
					return;
				}

				log('myAd loaded', 'info', logGroup);
				myAd = window.myAd;

				scriptWriter.injectScriptByText(
					javaScriptsPlaceHolder,
					'myAd.loadScript("site");',
					function () {
						if (window.SOI_IDENTIFIER !== 'wikia') {
							error('wikia');
							return;
						}

						log('Sites/wikia.js loaded', 'info', logGroup);

						scriptWriter.injectScriptByText(
							javaScriptsPlaceHolder,
							'myAd.loadScript("global");',
							function () {
								if (!window.SoiAP) {
									error('globalV6');
									return;
								}

								log('globalV6.js loaded', 'info', logGroup);

								done();
							}
						);
					}
				);
			}
		);
	}

	/**
	 * Flush pushed ads
	 */
	function flushAds() {
		var retries = 0;

		// Styles and scripts are loading, the ads will be flushed eventually
		if (!firstSlotname) {
			log('No ads pushed to queue, not flushing', 'warn', logGroup);
			return;
		}

		if (flushCalled) {
			if (allLoaded) {
				// A whole flush batch had been processed before this flush was called.
				// We need to process another batch now
				shiftQueue();
			}

			return;
		}

		flushCalled = true;

		function tryInjectJavaScripts() {
			injectJavaScripts(firstSlotname, function () {
				// DONE
				allLoaded = true;
				log('injectJavaScript success', 'info', logGroup);
				shiftQueue();
			}, function (what) {
				// ERROR
				log(['injectJavaScript failed', what], 'error', logGroup);
				if (retries === 3) {
					log(['injectJavaScript failed after 3 retries. Quiting', what], 'error', logGroup);
				}
				retries += 1;
				tryInjectJavaScripts();
			});
		}

		injectStyles(tryInjectJavaScripts);

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
		log(['registerSlot', slotname], 'info', logGroup);

		if (!initialized) {
			initialize();
			firstSlotname = slotname;
		}

		setVars(slotVars[slotname]);
		slotsQueue.push({slotname: slotname, params: params});
	}

	return {
		pushAd: pushAd,
		flushAds: flushAds
	};
};
