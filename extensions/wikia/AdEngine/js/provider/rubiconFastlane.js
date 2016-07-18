/*global define*/
define('ext.wikia.adEngine.provider.rubiconFastlane', [
	'ext.wikia.adEngine.slotTweaker',
	'wikia.iframeWriter',
	'wikia.instantGlobals',
	'wikia.log',
	'wikia.window'
], function (slotTweaker, iframeWriter, instantGlobals, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.rubiconFastlane',
		providerName = 'RubiconFastlane',
		rubiconTiersKey = 'rpfl_7450',
		skipTier = instantGlobals.wgAdDriverRubiconFastlaneProviderSkipTier || 0,
		sizeMap = {
			'1': [468, 60],
			'2': [728, 90],
			'8': [120, 600],
			'9': [160, 600],
			'10': [300, 600],
			'15': [300, 250],
			'43': [320, 50],
			'44': [300, 50],
			'49': [336, 280],
			'54': [300, 1050],
			'57': [970, 250],
			'67': [320, 480]
		},
		slotMap = [
			'BOTTOM_LEADERBOARD',
			'HOME_TOP_LEADERBOARD',
			'HOME_TOP_RIGHT_BOXAD',
			'INCONTENT_BOXAD_1',
			'INCONTENT_LEADERBOARD',
			'LEFT_SKYSCRAPER_2',
			'LEFT_SKYSCRAPER_3',
			'PREFOOTER_LEFT_BOXAD',
			'PREFOOTER_MIDDLE_BOXAD',
			'PREFOOTER_RIGHT_BOXAD',
			'TOP_LEADERBOARD',
			'TOP_RIGHT_BOXAD',

			'MOBILE_BOTTOM_LEADERBOARD',
			'MOBILE_IN_CONTENT',
			'MOBILE_PREFOOTER',
			'MOBILE_TOP_LEADERBOARD'
		];

	function getTiers(slotName) {
		var slot,
			tiers;

		if (win.rubicontag && typeof win.rubicontag.getSlot === 'function') {
			slot = win.rubicontag.getSlot(slotName);
		}

		if (slot && typeof slot.getAdServerTargetingByKey === 'function') {
			tiers = slot.getAdServerTargetingByKey(rubiconTiersKey);
		}

		return tiers || [];
	}

	function getBestTier(tiers) {
		var bestPrice = 0,
			bestTier = null;

		tiers.forEach(function (tier) {
			var matches = tier.match(/^\d+_tier(\d+)/),
				value = 0;

			if (matches && matches[1]) {
				value = parseInt(matches[1], 10);
			}

			if (value > bestPrice) {
				bestPrice = value;
				bestTier = tier;
			}
		});

		return bestPrice > skipTier ? bestTier : null;
	}

	function getSizeFromTier(tier) {
		var matches;

		if (tier === null) {
			return;
		}

		matches = tier.match(/^(\d+)_tier/);
		if (matches && matches[1] && sizeMap[matches[1]]) {
			return matches[1];
		}
	}

	function renderCreative(slot, size) {
		var dimensions = sizeMap[size],
			iframe = iframeWriter.getIframe({
				code: '',
				width: dimensions[0],
				height: dimensions[1]
			});

		iframe.id = ['wikia', providerName, slot.name, size].join('/');

		slot.post('success', function () {
			slotTweaker.removeDefaultHeight(slot.name);
			slotTweaker.removeTopButtonIfNeeded(slot.name);
			slotTweaker.adjustLeaderboardSize(slot.name);
			log(['success', slot.name], 'info', logGroup);
		});

		slot.container.setAttribute('data-creative-size', JSON.stringify(dimensions));
		slot.container.appendChild(iframe);

		win.rubicontag.renderCreative(iframe.contentWindow.document.body, slot.name, size);
		slot.success({
			adType: 'success'
		});
	}

	function canHandleSlot(slotName) {
		var canHandle = slotMap.indexOf(slotName) !== -1;

		log(['canHandleSlot', slotName, canHandle], 'debug', logGroup);
		return canHandle;
	}

	function fillInSlot(slot) {
		var tiers = getTiers(slot.name),
			bestTier = getBestTier(tiers),
			size = getSizeFromTier(bestTier);

		log(['fillInSlot', slot.name, bestTier], 'debug', logGroup);
		slot.post('collapse', function () {
			slotTweaker.hide(slot.name);
			log(['collapse', slot.name], 'info', logGroup);
		});

		slot.container.setAttribute('data-creative-tier', JSON.stringify(tiers));
		if (!size || typeof win.rubicontag.renderCreative !== 'function') {
			return slot.collapse({
				adType: 'collapse'
			});
		}

		renderCreative(slot, size);
	}

	return {
		name: providerName,
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
