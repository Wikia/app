/*exported AdProviderRemnantDart*/
var AdProviderRemnantDart = function (adTracker, log, slotTweaker, wikiaGpt) {
	'use strict';

	var logGroup = 'AdProviderRemnantDart',

		slotMap = {
			'EXIT_STITIAL_BOXAD_1': {'size': '300x250'},
			'HOME_TOP_LEADERBOARD': {'size': '728x90', 'tile': 2, 'loc': 'top', 'dcopt': 'ist'},
			'HOME_TOP_RIGHT_BOXAD': {'size': '300x250', 'tile': 1, 'loc': 'top'},
			'INCONTENT_BOXAD_1': {'size': '300x250'},
			'INVISIBLE_1': {'size': '0x0', 'useGw': true},
			'INVISIBLE_2': {'size': '0x0', 'useGw': true},
			'LEFT_SKYSCRAPER_2': {'size': '160x600', 'tile': 3, 'loc': 'middle'},
			'LEFT_SKYSCRAPER_3': {'size': '160x600', 'tile': 6, 'loc': 'footer'},
			'TEST_TOP_RIGHT_BOXAD': {'size': '300x250', 'tile': 1, 'loc': 'top'},
			'TEST_HOME_TOP_RIGHT_BOXAD': {'size': '300x250', 'tile': 1, 'loc': 'top'},
			'TOP_BUTTON_WIDE': {'size': '292x90', 'tile': 3, 'loc': 'top'},

			'TOP_LEADERBOARD': {'size': '728x90', 'tile': 2, 'loc': 'top', 'dcopt': 'ist'},
			'TOP_RIGHT_BOXAD': {'size': '300x250', 'tile': 1, 'loc': 'top'},
			'PREFOOTER_LEFT_BOXAD': {'size': '300x250', 'tile': 7, 'loc': 'footer'},
			'PREFOOTER_RIGHT_BOXAD': {'size': '300x250', 'tile': 8, 'loc': 'footer'},
			'WIKIA_BAR_BOXAD_1': {'size': '300x250', 'tile': 4, 'loc': 'bottom'}
		};

	wikiaGpt.init(slotMap, true);

	function isAmznOnPage( slotname, slot ) {
		log( ['isAmznOnPage', slotname], 'debug', logGroup );

		var matches, i;

		if ( !window.amzn_targs || !slot.size ) {
			return false;
		}

		matches = window.amzn_targs.match( /\d+x\d+/g );

		for ( i = 0; i < matches.length; i++ ) {
			if ( slot.size.indexOf( matches[i].toLowerCase() ) !== -1 ) {
				return true;
			}
		}

		return false;
	}

	function canHandleSlot(slotname) {

		if (!slotMap[slotname]) {
			return false;
		}

		return isAmznOnPage(slotname, slotMap[slotname]);
	}

	function fillInSlot(slotname, success) {

		log(['fillInSlot', slotname], 5, logGroup);

		var slotTracker = adTracker.trackSlot('addriver2', slotname);

		slotTracker.init();

		wikiaGpt.pushAd(
			slotname,
			function () { // Success
				slotTweaker.removeDefaultHeight(slotname);
				slotTweaker.removeTopButtonIfNeeded(slotname);
				slotTweaker.adjustLeaderboardSize(slotname);

				success();
			},
			function () { // Hop
				log(slotname + ' was not filled by DART', 'info', logGroup);

				slotTweaker.hide(slotname);
				slotTweaker.hideSelfServeUrl(slotname);

				success();
			},
			true
		);

		wikiaGpt.flushAds();
	}

	return {
		name: 'RemnantDart',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
};
