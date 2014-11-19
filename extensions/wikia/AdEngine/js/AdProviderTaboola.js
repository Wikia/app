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
		taboolaSlotname = 'NATIVE_TABOOLA',
		libraryLoaded = false,
		readMoreDiv = document.getElementById('RelatedPagesModuleWrapper'),
		context = adContext.getContext(),
		isMobile = context.targeting.skin === 'wikiamobile',
		pageType = context.targeting.pageType;

	function canHandleSlot(slot) {
		log(['canHandleSlot', slot], 'debug', logGroup);

		if (slot !== taboolaSlotname) {
			log(['canHandleSlot', slot, 'Wrong slot name, disabling'], 'error', logGroup);
			return false;
		}

		if (!readMoreDiv) {
			log(['canHandleSlot', slot, 'No "read more" section, disabling'], 'error', logGroup);
			return false;
		}

		return true;
	}

	function loadTaboola() {
		var taboolaInit, s, url = 'http://cdn.taboola.com/libtrc/wikia-network/loader.js';

		if (libraryLoaded) {
			return;
		}

		if (!isMobile) {
			url = 'http://cdn.taboola.com/libtrc/wikia-' + context.targeting.wikiDbName + '/loader.js';
		}

		taboolaInit = {};
		taboolaInit[pageType] = 'auto';
		readMoreDiv.parentNode.removeChild(readMoreDiv);

		window._taboola = window._taboola || [ taboolaInit ];

		if (isMobile) {
			window._taboola.push({flush: true});
		}

		s = document.createElement('script');
		s.async = true;
		s.src = url;
		s.id = logGroup;
		document.getElementsByTagName('body')[0].appendChild(s);

		libraryLoaded = true;
	}

	function fillInSlot(slotname, success) {
		log(['fillInSlot', slotname], 'debug', logGroup);

		loadTaboola();

		window._taboola.push({
			mode: isMobile ? 'thumbnails-b' : 'thumbnails-a',
			container: slotname,
			placement: ['Read More on', pageType, '@', (isMobile ? 'mobile' : 'desktop')].join(' '),
			target_type: 'mix'
		});

		slotTweaker.show(slotname);
		success();
	}

	return {
		name: 'Taboola',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};

});
