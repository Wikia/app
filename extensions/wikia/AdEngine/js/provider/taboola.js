/*global define*/
/*jslint nomen: true*/
/*jshint camelcase: false*/
define('ext.wikia.adEngine.provider.taboola', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.recovery.helper',
	'ext.wikia.adEngine.slotTweaker',
	'wikia.abTest',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.log',
	'wikia.window',
	'wikia.document'
], function (adContext, recoveryHelper, slotTweaker, abTest, geo, instantGlobals, log, window, document) {
	'use strict';

	var abGroups = {
			recovery: abTest.getGroup('PROJECT_43_TABOOLA') === 'YES',
			regular: abTest.getGroup('NATIVE_ADS_TABOOLA') === 'YES'
		},
		config = instantGlobals.wgAdDriverTaboolaConfig || {},
		context = adContext.getContext(),
		libraryLoaded = false,
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
		pageType = context.targeting.pageType,
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

		if (slots[slotName] && config[slotName] && abGroups.regular && geo.isProperGeo(config[slotName].regular)) {
			log(['canHandleSlot', 'Using regular taboola', slotName], 'debug', logGroup);
			supportedSlots.regular.push(slotName);
			return true;
		}

		if (slots[slotName] && config[slotName] && abGroups.recovery && geo.isProperGeo(config[slotName].recovery)) {
			log(['canHandleSlot', 'Using recovery taboola', slotName], 'debug', logGroup);
			supportedSlots.recovery.push(slotName);
			return true;
		}

		return false;
	}

	function loadTaboola() {
		var taboolaInit = {},
			taboolaScript,
			url = '//cdn.taboola.com/libtrc/wikia-network/loader.js';

		if (libraryLoaded) {
			return;
		}

		taboolaInit[pageType] = 'auto';
		window._taboola = window._taboola || [];
		window._taboola.push(taboolaInit);
		window._taboola.push({flush: true});

		taboolaScript = document.createElement('script');
		taboolaScript.async = true;
		taboolaScript.src = url;
		taboolaScript.id = logGroup;
		document.getElementsByTagName('body')[0].appendChild(taboolaScript);

		libraryLoaded = true;
	}

	function fillInSlot(slotName, slotElement, success) {
		var container = document.createElement('div'),
			slot = slots[slotName];
		log(['fillInSlot', slotName, slotElement], 'debug', logGroup);

		if (slotName === 'NATIVE_TABOOLA_ARTICLE') {
			readMoreDiv.parentNode.removeChild(readMoreDiv);
		}
		loadTaboola();
		container.id = slot.id;
		slotElement.appendChild(container);

		window._taboola.push({
			mode: slot.mode,
			container: container.id,
			placement: slot.label + getVerticalName(),
			target_type: 'mix'
		});

		slotTweaker.show(slotName);
		success();
	}

	function fillInSlotByConfig(slotName, slotElement, success) {
		if (supportedSlots.regular.indexOf(slotName) !== -1) {
			fillInSlot(slotName, slotElement, success);
		} else if (supportedSlots.recovery.indexOf(slotName) !== -1) {
			recoveryHelper.addOnBlockingCallback(function () {
				fillInSlot(slotName, slotElement, success);
			});
		}
	}

	return {
		name: 'Taboola',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlotByConfig
	};
});
