/*global define*/
/*jslint nomen: true*/
/*jshint camelcase: false*/
define('ext.wikia.adEngine.provider.taboola', [
	'wikia.log',
	'wikia.window',
	'wikia.document',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.slotTweaker'
], function (log, window, document, adContext, slotTweaker) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.taboola',
		libraryLoaded = false,
		readMoreDiv = document.getElementById('RelatedPagesModuleWrapper'),
		context = adContext.getContext(),
		pageType = context.targeting.pageType,
		mappedVerticals = {
			tv: 'Television',
			games: 'Gaming',
			books: 'Books',
			comics: 'Comics',
			lifestyle: 'Lifestyle',
			music: 'Music',
			movies: 'Movies'
		},
		slots = {
			'NATIVE_TABOOLA_ARTICLE': {
				id: 'taboola-below-article-thumbnails',
				mode: 'thumbnails-c',
				text: 'Below Article Thumbnails - '
			},
			'NATIVE_TABOOLA_RAIL': {
				id: 'taboola-right-rail-thumbnails',
				mode: 'thumbnails-rr',
				text: 'Right Rail Thumbnails - '
			}
		};

	function getVerticalName() {
		var verticalName = mappedVerticals[context.targeting.wikiVertical];
		if (!verticalName) {
			verticalName = 'Other';
		}

		log(['getVerticalName', verticalName], 'debug', logGroup);
		return verticalName;
	}

	function canHandleSlot(slotName) {
		log(['canHandleSlot', slotName], 'debug', logGroup);

		if (!readMoreDiv && slotName === 'NATIVE_TABOOLA_ARTICLE') {
			log(['canHandleSlot', slotName, 'No "read more" section, disabling'], 'error', logGroup);
			return false;
		}

		return !!slots[slotName];
	}

	function loadTaboola() {
		var taboolaInit = {},
			taboolaScript,
			url = '//cdn.taboola.com/libtrc/wikia-network/loader.js';

		if (libraryLoaded) {
			return;
		}
		readMoreDiv.parentNode.removeChild(readMoreDiv);

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

		loadTaboola();
		container.id = slot.id;
		slotElement.appendChild(container);

		window._taboola.push({
			mode: slot.mode,
			container: container.id,
			placement: slot.text + getVerticalName(),
			target_type: 'mix'
		});

		slotTweaker.show(slotName);
		success();
	}

	return {
		name: 'Taboola',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};

});
