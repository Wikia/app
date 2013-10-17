/*global setTimeout, require*/
var AdProviderSevenOneMedia = function (adLogicPageLevelParams, scriptWriter, log, window, tracker, $) {
	'use strict';

	var logGroup = 'AdProviderSevenOneMedia',
		myAd,
		initialized,
		javaScriptsPlaceHolder = 'SEVENONEMEDIA_FLUSH',
		pageLevelParams = adLogicPageLevelParams.getPageLevelParams(),
		slotMap = {
			'ad-popup1': {
				vars: {
					SOI_PU1: true,
					SOI_PL: true,    // powerlayer
					SOI_PU: false,   // popunder,
					SOI_FA: false    // baseboard
				}
			},
			'ad-fullbanner2': {
				vars: {
					SOI_FB2: true,
					SOI_PB: true,    // powerbanner (728x180)
					SOI_PD: true,    // pushdown
					SOI_BB: true,    // billboard
					SOI_WP: true,    // wallpaper
					SOI_FP: true     // fireplace
				}
			},
			'ad-rectangle1': {
				vars: {
					SOI_RT1: true,
					SOI_HP: true     // halfpage (300x600)
				}
			},
			'ad-skyscraper1': {
				vars: {
					SOI_SC1: true,
					SOI_SB: true     // sidebar
				}
			},

			'TOP_RIGHT_BOXAD': {insertMedrec: true},
			'HOME_TOP_RIGHT_BOXAD': {insertMedrec: true},

			'TOP_LEADERBOARD': {hide: true},
			'HOME_TOP_LEADERBOARD': {hide: true},
			'HUB_TOP_LEADERBOARD': {hide: true},

			'SEVENONEMEDIA_FLUSH': {flush: true}
		},
		slotsQueue = [];

	function canHandleSlot(slot) {
		log(['canHandleSlot', slot], 'debug', logGroup);

		var slotname = slot[0];

		if (slotMap[slotname]) {
			log(['canHandleSlot', slot, true], 'debug', logGroup);
			return true;
		}

		log(['canHandleSlot', slot, false], 'debug', logGroup);
		return false;
	}

	function shiftQueue() {
		var slotname = slotsQueue.shift(),
			deSlotname;

		if (!slotname) {
			return;
		}

		deSlotname = slotname.replace('ad-', '');

		log(['shiftQueue', slotname], 'info', logGroup);

		scriptWriter.injectScriptByText(
			slotname,
			'myAd.insertAd(' + JSON.stringify(deSlotname) + ');',
			function () {
				setTimeout(function () {
					log(['finish Ad', deSlotname], 'info', logGroup);
					myAd.finishAd(deSlotname);
					log(['finish Ad', deSlotname, 'done'], 'info', logGroup);

					// Start TOP_BUTTON_WIDE if leaderboard is of standard size
					if (deSlotname === 'fullbanner2' && !myAd.isSpecialAd('fullbanner2')) {
						log('fullbanner2 not a special ad', 'debug', logGroup);
						var $slot = $('#ad-fullbanner2'),
							height = $slot.height(),
							width = $slot.width();

						if (height >= 90 && height <= 95 && width === 728) {
							log('fullbanner2 has standard size, enabling TOP_BUTTON_WIDE', 'debug', logGroup);
							window.adslots2.push(['TOP_BUTTON_WIDE.force']);
						}
					}

					setTimeout(shiftQueue, 0);
				}, 0);
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
			s1 = pageLevelParams.s1;

		initialized = true;

		if (s0 === 'gaming') {
			s0 = 'videospiele';
		}

		// Markup updates
		$('#TOP_BUTTON_WIDE').remove();
		$('#ad-popup1').after('<div id="TOP_BUTTON_WIDE"></div>');

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
	}

	function injectStyles(done) {
		require(['wikia.loader'], function (loader) {
			loader('/extensions/wikia/AdEngine/SevenOneMedia/my_ad_integration.css').done(
				function () {
					$('#WikiaTopAds').hide();
					$('#TOP_RIGHT_BOXAD, #HOME_TOP_RIGHT_BOXAD').removeClass('default-height');

					done();
				}
			);
		});
	}

	function injectJavaScripts(done, error) {
		var myAdJsUrl = window.wgCdnRootUrl + window.wgAssetsManagerQuery.
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
					"myAd.loadScript('site');",
					function () {
						if (window.SOI_IDENTIFIER !== 'wikia') {
							error('wikia');
							return;
						}

						log('Sites/wikia.js loaded', 'info', logGroup);

						scriptWriter.injectScriptByText(
							javaScriptsPlaceHolder,
							"myAd.loadScript('global');",
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

	function flushAds() {
		injectStyles(function () {
			injectJavaScripts(function () {
				// DONE
				log('injectJavaScript success', 'info', logGroup);
				shiftQueue();
			}, function (what) {
				// ERROR
				log(['injectJavaScript failed', what], 'crit', logGroup);
				// TODO: TRACK THIS
			});
		});
	}

	function fillInSlot(slot) {
		if (!initialized) {
			initialize();
		}

		log(['fillInSlot', slot], 'info', logGroup);

		var slotname = slot[0],
			slotOpts = slotMap[slotname];

		if (slotOpts.hide) {
			return;
		}

		if (slotOpts.flush) {
			// Don't block other things, please
			$(function () {
				setTimeout(flushAds, 0);
			});
			return;
		}

		// Special handling of medrec slot
		if (slotOpts.insertMedrec) {
			$('#' + slotname).html('<div id="ad-rectangle1-outer"><div id="ad-rectangle1"></div></div>');
			slotname = 'ad-rectangle1';
		}

		$('#' + slotname).addClass('ad-wrapper');

		// Add slot-dependent vars
		setVars(slotMap[slotname].vars);

		// Queue for filling in
		slotsQueue.push(slotname);
	}

	return {
		name: 'SevenOneMedia',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
};
