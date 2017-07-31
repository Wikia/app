/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.appnexusAst', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.location'
], function (adContext, slotsContext, geo, instantGlobals, loc) {
	'use strict';

	var bidderName = 'appnexusAst',
		debugPlacementId = '5768085',
		slots = {
			oasis: {
				TOP_LEADERBOARD: {
					placementId: '11543171'
				},
				INCONTENT_PLAYER: {
					placementId: '11543172'
				}
			},
			mercury: {
				MOBILE_IN_CONTENT: {
					placementId: '11543173'
				}
			}
		};

	function isEnabled() {
		return geo.isProperGeo(instantGlobals.wgAdDriverAppNexusAstBidderCountries) &&
			!adContext.getContext().targeting.hasFeaturedVideo;
	}

	function prepareAdUnit(slotName, config) {
		var isDebugMode = loc.href.indexOf('appnexusast_debug_mode=1') >= 0;

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
