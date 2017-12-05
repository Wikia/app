/*global define*/
define('ext.wikia.adEngine.slot.slotTargeting', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.utils.math',
	'wikia.abTest',
	'wikia.instantGlobals',
	require.optional('ext.wikia.adEngine.wrappers.prebid')
], function (adContext, math, abTest, instantGlobals, prebid) {
	'use strict';

	var skins = {
			mercury: 'm',
			oasis: 'o'
		},
		pageTypes = {
			article: 'a',
			home: 'h'
		},
		slotSources = {
			gpt: '1',
			mobile: '1',
			remnant: '2',
			mobile_remnant: '2',
			rec: 'r',
			premium: 'p'
		},
		wsiSlots = {
			TOP_LEADERBOARD: 'l',
			TOP_RIGHT_BOXAD: 'm',
			INCONTENT_PLAYER: 'i',
			INCONTENT_BOXAD_1: 'f',
			BOTTOM_LEADERBOARD: 'b',

			MOBILE_TOP_LEADERBOARD: 'l',
			MOBILE_IN_CONTENT: 'i',
			MOBILE_PREFOOTER: 'p',
			MOBILE_BOTTOM_LEADERBOARD: 'b'
		},
		videoBidders = {
			appnexusAst: 'aa',
			rubicon: 'ru'
		},
		videoSlots = {
			oasis: 'INCONTENT_PLAYER',
			mercury: 'MOBILE_IN_CONTENT'
		};

	function valueOrX(map, key) {
		if (!key || !map[key]) {
			return 'x';
		}

		return map[key];
	}

	function getWikiaSlotId(slotName, slotSource) {
		var context = adContext.getContext(),

			skin = valueOrX(skins, context.targeting.skin),
			slot = valueOrX(wsiSlots, slotName),
			pageType = valueOrX(pageTypes, context.targeting.pageType),
			src = valueOrX(slotSources, slotSource);

		return skin + slot + pageType + src;
	}

	function getAbTestId(slotData) {
		var experimentId = instantGlobals.wgAdDriverAbTestIdTargeting,
			experiments = abTest.getExperiments(),
			id;

		experiments.forEach(function (experiment) {
			if (experimentId === experiment.id) {
				id = experiment.id + '_' + experiment.group.id;
			}
		});

		if (id) {
			return id + slotData.wsi;
		}
	}

	function getOutstreamData() {
		var context = adContext.getContext(),
			getAdserverTargeting = prebid && prebid.get().getAdserverTargetingForAdUnitCode,
			videoTargeting = getAdserverTargeting && getAdserverTargeting(videoSlots[context.targeting.skin]);

			if (videoTargeting) {
				return constructOutstreamString(videoTargeting);
			}
    	}

	function constructOutstreamString(videoTargeting) {
		var bidderName = videoTargeting.hb_bidder,
			isVideoProvider = !!videoBidders[bidderName];

		if (isVideoProvider && videoTargeting.hb_pb) {
			return videoBidders[bidderName] + math.leftPad(parseFloat(videoTargeting.hb_pb) * 100, 4);
		}
	}

	return {
		getAbTestId: getAbTestId,
		getOutstreamData: getOutstreamData,
		getWikiaSlotId: getWikiaSlotId
	};
});
