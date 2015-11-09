/*global require*/
(function () {
	'use strict';

	var $ = require('jquery'),
		msg = require('JSMessages'),
		adEngine = require('ext.wikia.adEngine.adEngine'),
		adConfigMobile = require('ext.wikia.adEngine.config.mobile'),
		messageListener = require('ext.wikia.adEngine.messageListener'),
		win = require('wikia.window'),
		doc = require('wikia.document'),
		krux = require('wikia.krux'),
		log = require('wikia.log'),
		adLabel = msg('adengine-advertisement'),
		createSlot = function (name) {
			var $slot = $('<div></div>'),
				$label = $('<label></label>');

			$label.text(adLabel);

			$slot.attr('id', name);
			$slot.addClass('ad-in-content');
			$slot.html($label);

			return $slot.wrapAll('<div></div>').parent().html();
		},
		adSlots = [],
		$firstSection = $('h2[id]').first(),
		$footer = $('#wkMainCntFtr'),
		firstSectionTop = ($firstSection.length && $firstSection.offset().top) || 0,
		kruxSiteId = 'JTKzTN3f',
		logGroup = 'ads_run',
		logLevel = log.levels.info,
		minZerothSectionLength = 700,
		minPageLength = 2000,
		mobileTopLeaderBoard = 'MOBILE_TOP_LEADERBOARD',
		mobileInContent = 'MOBILE_IN_CONTENT',
		mobilePreFooter = 'MOBILE_PREFOOTER',
		mobileTaboola = 'NATIVE_TABOOLA',
		showInContent = firstSectionTop > minZerothSectionLength,
		showPreFooter = doc.body.offsetHeight > minPageLength || firstSectionTop < minZerothSectionLength;

	messageListener.init();

	// Slots
	log('Loading slot: ' + mobileTopLeaderBoard, logLevel, logGroup);
	adSlots.push([mobileTopLeaderBoard]);

	$(doc).ready(function () {
		if (win.wgArticleId && showInContent) {
			log('Loading slot: ' + mobileInContent, logLevel, logGroup);
			$firstSection.before(createSlot(mobileInContent));
			adSlots.push([mobileInContent]);
		}
	});

	$(win).on('load', function () {
		if (win.wgArticleId) {
			// This can wait to on load as the ad is under the fold
			if (showPreFooter) {
				log('Loading slot: ' + mobilePreFooter, logLevel, logGroup);
				$footer.after(createSlot(mobilePreFooter));
				adSlots.push([mobilePreFooter]);
			}
			adSlots.push([mobileTaboola]);
		}

		log('Loading Krux module, site id: ' + kruxSiteId, logLevel, logGroup);
		krux.load(kruxSiteId);
	});

	// Start queue
	log('Running mobile queue', logLevel, logGroup);
	adEngine.run(adConfigMobile, adSlots, 'queue.mobile');
})();
