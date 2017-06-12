/*global define*/
define('ext.wikia.adEngine.slot.slotTargeting', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.utils.math',
	'ext.wikia.adEngine.wrappers.prebid',
	'wikia.abTest',
	'wikia.instantGlobals'
], function (adContext, math, prebid, abTest, instantGlobals) {
	'use strict';

	var skins = {
			mercury: 'm',
			oasis: 'o'
		},
		pageTypes = {
			article: 'a',
			home: 'h'
		},
		prebidIds = {
			aol: 'ao',
			appnexus: 'an',
			audienceNetwork: 'fb',
			indexExchange: 'ie',
			openx: 'ox',
			veles: 've',
			rubicon: 'ru',
			wikia: 'wk'
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
			LEFT_SKYSCRAPER_2: 's',
			LEFT_SKYSCRAPER_3: 'k',
			PREFOOTER_LEFT_BOXAD: 'p',
			PREFOOTER_RIGHT_BOXAD: 'r',

			MOBILE_TOP_LEADERBOARD: 'l',
			MOBILE_IN_CONTENT: 'i',
			MOBILE_PREFOOTER: 'p',
			MOBILE_BOTTOM_LEADERBOARD: 'b'
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

	function getPrebidSlotId(slotData) {
		var id = 'x',

			bidder,
			cpm,
			size,
			tier;

		if (slotData.hb_bidder) {
			cpm = parseFloat(slotData.hb_pb);

			bidder = valueOrX(prebidIds, slotData.hb_bidder);
			size = slotData.hb_size;
			tier = 't' + math.leftPad(cpm * 100, 4);

			id = bidder + size + tier;
		}

		return id + slotData.wsi.substr(0, 2);
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
		var getVideoTargeting = prebid.get().getAdserverTargetingForAdUnitCode,
			videoTargeting = getVideoTargeting && getVideoTargeting('INCONTENT_PLAYER');

		if (videoTargeting) {
			return videoTargeting.hb_bidder.substr(0, 2) + math.leftPad(parseFloat(videoTargeting.hb_pb) * 100, 4);
		}
	}

	return {
		getAbTestId: getAbTestId,
		getOutstreamData: getOutstreamData,
		getPrebidSlotId: getPrebidSlotId,
		getWikiaSlotId: getWikiaSlotId
	};
});
