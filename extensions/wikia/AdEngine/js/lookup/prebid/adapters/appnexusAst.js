/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.appnexusAst', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.wad.babDetection',
	'wikia.location'
], function (adContext, slotsContext, babDetection, loc) {
	'use strict';

	var bidderName = 'appnexusAst',
		aliases = {
			'appnexus': [bidderName]
		},
		debugPlacementId = '5768085',
		slots = {
			oasis: {
				FEATURED: {
					placementId: '13684967'
				},
				INCONTENT_PLAYER: {
					placementId: '11543172'
				}
			},
			mercury: {
				FEATURED: {
					placementId: '13705871'
				},
				MOBILE_IN_CONTENT: {
					placementId: '11543173'
				}
			}
		};

	function isEnabled() {
		return adContext.get('bidders.appnexusAst') && !babDetection.isBlocking();
	}

	function prepareAdUnit(slotName, config) {
		var isDebugMode = loc.href.indexOf('appnexusast_debug_mode=1') >= 0;

		return {
			code: slotName,
			mediaTypes: {
				video: {
					context: 'instream',
					playerSize: [640, 480]
				}
			},
			bids: [
				{
					bidder: bidderName,
					params: {
						placementId: isDebugMode ? debugPlacementId : config.placementId,
						video: {
							skippable: false,
							playback_method: ['auto_play_sound_off']
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

	function getAliases() {
		return aliases;
	}

	return {
		isEnabled: isEnabled,
		getName: getName,
		getAliases: getAliases,
		getSlots: getSlots,
		prepareAdUnit: prepareAdUnit
	};
});
