/*global define*/
define('ext.wikia.adengine.provider.remnantdartmobile', ['wikia.log', 'ext.wikia.adengine.slottweaker', 'ext.wikia.adengine.gpthelper'], function (log, slotTweaker, wikiaGpt) {
	'use strict';

	var logGroup = 'AdProviderDartRemnantMobile',
		srcName = 'rh_mobile',
		slotMap = {
			MOBILE_TOP_LEADERBOARD: {size: '320x50'},
			MOBILE_IN_CONTENT: {size: '300x250'},
			MOBILE_PREFOOTER: {size: '300x250'}
		};

	wikiaGpt.init(slotMap, srcName);

	function canHandleSlot(slotname) {
		return !!slotMap[slotname];
	}

	function fillInSlot(slotname, success, hop) {
		log(['fillInSlot', slotname], 5, logGroup);

		wikiaGpt.pushAd(slotname,
			function () { // Success
				var slot = document.getElementById( slotname ),
					$iframe = $( slot ).find( 'iframe' ).contents();

				if (
					$iframe.find( 'body *:not(script)' ).length === 0 ||
						$iframe.find( 'body img' ).width() <= 1
					) {
					log( 'Slot seems to be empty: ' + slotname, 5, logGroup );
					slotTweaker.hide(slotname);
					slotTweaker.hideSelfServeUrl(slotname);
				}
			},
			function () { // Hop

				log(slotname + ' was not filled by DART', 'info', logGroup);

				slotTweaker.hide(slotname);
				slotTweaker.hideSelfServeUrl(slotname);

				success();
			},
			srcName
		);
		wikiaGpt.flushAds();
	}

	return {
		name: 'RemnantDartMobile',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
