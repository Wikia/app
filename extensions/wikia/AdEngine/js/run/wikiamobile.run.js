/*global require*/
require(
	[
		'jquery',
		'JSMessages',
		'ext.wikia.adEngine.adEngine',
		'ext.wikia.adEngine.config.mobile',
		'ext.wikia.adEngine.messageListener',
		'wikia.window',
		'wikia.document',
		'wikia.krux',
		'wikia.log'
	],
	function ($, msg, adEngine, adConfigMobile, messageListener, win, doc, krux, log) {
		'use strict';

		var adLabel = msg('adengine-advertisement'),
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
			}

			log('Loading Krux module, site id: ' + kruxSiteId, logLevel, logGroup);
			krux.load(kruxSiteId);
		});

		// Start queue
		log('Running mobile queue', logLevel, logGroup);
		adEngine.run(adConfigMobile, adSlots, 'queue.mobile');
	}
);
