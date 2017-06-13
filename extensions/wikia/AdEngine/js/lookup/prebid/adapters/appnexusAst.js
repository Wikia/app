/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.appnexusAst',[
	'ext.wikia.adEngine.context.slotsContext',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.location'
], function (slotsContext, geo, instantGlobals, loc) {
	'use strict';

	var bidderName = 'appnexusAst',
		debugPlacementId = '5768085',
		slots = {
			oasis: {
				TOP_LEADERBOARD: {
					placementId: '5768085' // FIXME
				},
				INCONTENT_PLAYER: {
					placementId: '5768085' // FIXME
				}
			},
			mercury: {
				MOBILE_IN_CONTENT: {
					placementId: '5768085' // FIXME
				}
			}
		};

	function isEnabled() {
		return geo.isProperGeo(instantGlobals.wgAdDriverAppNexusAstBidderCountries);
	}

	function prepareAdUnit(slotName, config) {
		var isDebugMode = loc.href.search('appnexusast_debug_mode=1') >= 0;

		return {
			code: slotName,
			sizes: [ 640, 480 ],
			mediaType: 'video-outstream',
			bids: [
				{
					bidder: bidderName,
					params: {
						placementId: isDebugMode ? debugPlacementId : config.placementId,
						video: {
							skippable: false,
							playback_method: [ 'auto_play_sound_off' ]
						}
					}
				}
			]
		};
	}

	function getSlots(skin) {
		return slotsContext.filterSlotMap(slots[skin]);
	}

	function getName() {
		return bidderName;
	}

	return {
		isEnabled: isEnabled,
		getName: getName,
		getSlots: getSlots,
		prepareAdUnit: prepareAdUnit
	};
});
