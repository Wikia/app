/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.appnexusAst', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.aRecoveryEngine.instartLogic.recovery',
	'wikia.location'
], function (adContext, slotsContext, instartLogic, loc) {
	'use strict';

	var bidderName = 'appnexusAst',
		debugPlacementId = '5768085',
		slots = {
			oasis: {
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
		return adContext.getContext().bidders.appnexusAst && !instartLogic.isBlocking();;
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
