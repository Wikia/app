/*global define*/
/*jslint nomen: true*/
/*jshint camelcase: false*/
define('ext.wikia.adEngine.provider.taboola', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.recovery.helper',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.taboolaHelper',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.log',
	'wikia.window',
	'wikia.document'
], function (adContext, recoveryHelper, slotTweaker, taboolaHelper, geo, instantGlobals, log, window, document) {
	'use strict';

	var config = instantGlobals.wgAdDriverTaboolaConfig || {},
		context = adContext.getContext(),
		logGroup = 'ext.wikia.adEngine.provider.taboola',
		mappedVerticals = {
			tv: 'Television',
			games: 'Gaming',
			books: 'Books',
			comics: 'Comics',
			lifestyle: 'Lifestyle',
			music: 'Music',
			movies: 'Movies'
		},
		readMoreDiv = document.getElementById('RelatedPagesModuleWrapper'),
		slots = {
			'NATIVE_TABOOLA_ARTICLE': {
				id: 'taboola-below-article-thumbnails',
				mode: 'thumbnails-c',
				label: 'Below Article Thumbnails - '
			},
			'NATIVE_TABOOLA_RAIL': {
				id: 'taboola-right-rail-thumbnails',
				mode: 'thumbnails-rr',
				label: 'Right Rail Thumbnails - '
			},
			'TOP_LEADERBOARD_AB': {
				id: 'taboola-above-article-thumbnails',
				mode: 'thumbnails-h-abp',
				label: 'Above Article Thumbnails'
			}
		},
		supportedSlots = {
			recovery: [],
			regular: []
		};

	function getVerticalName() {
		return mappedVerticals[context.targeting.wikiVertical] || 'Other';
	}

	function canHandleSlot(slotName) {
		log(['canHandleSlot', slotName], 'debug', logGroup);
		if (!readMoreDiv && slotName === 'NATIVE_TABOOLA_ARTICLE') {
			log(['canHandleSlot', slotName, 'No "read more" section, disabling'], 'error', logGroup);
			return false;
		}

		if (slots[slotName] && config[slotName] && geo.isProperGeo(config[slotName].regular)) {
			log(['canHandleSlot', 'Using regular taboola', slotName], 'debug', logGroup);
			supportedSlots.regular.push(slotName);
			return true;
		}

		if (slots[slotName] && config[slotName] && geo.isProperGeo(config[slotName].recovery)) {
			log(['canHandleSlot', 'Using recovery taboola', slotName], 'debug', logGroup);
			supportedSlots.recovery.push(slotName);
			return true;
		}

		return false;
	}

	function fillInSlot(slot) {
		var container = document.createElement('div'),
			mappedSlot = slots[slot.name];
		log(['fillInSlot', slot.name], 'debug', logGroup);

		if (slot.name === 'NATIVE_TABOOLA_ARTICLE') {
			readMoreDiv.parentNode.removeChild(readMoreDiv);
		}

		container.id = mappedSlot.id;
		slot.container.appendChild(container);

		taboolaHelper.initializeWidget({
			mode: mappedSlot.mode,
			container: container.id,
			placement: mappedSlot.label + getVerticalName(),
			target_type: 'mix'
		});

		slotTweaker.show(slot.name);
		slot.success();
	}

	function fillInSlotByConfig(slot) {
		if (supportedSlots.regular.indexOf(slot.name) !== -1) {
			fillInSlot(slot);
		} else if (supportedSlots.recovery.indexOf(slot.name) !== -1) {
			recoveryHelper.addOnBlockingCallback(function () {
				fillInSlot(slot);
			});
		}
	}

	return {
		name: 'Taboola',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlotByConfig
	};
});
