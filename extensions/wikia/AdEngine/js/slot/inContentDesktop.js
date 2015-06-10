/*global define*/

define('ext.wikia.adEngine.slot.inContentDesktop', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.adLogicPageDimensions',
	'ext.wikia.adEngine.slot.inContent',
	'jquery',
	'wikia.log',
	'wikia.window'
], function (adContext, adTracker, adLogicPageDimensions, inContent, jQuery, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.inContentDesktop',
		context = adContext.getContext(),
		$ad = jQuery('<div class="ad-in-content"><div class="wikia-ad default-height"></div></div>');

	log('load', 'debug', logGroup);

	function init() {
		log('init', 'debug', logGroup);

		// Don't start those slots on no_ads, corporate, home etc
		if (context.opts.pageType !== 'all_ads') {
			log('In content ads not started, because context.opts.pageType is not all_ads', 'info', logGroup);
		}

		log('Registering the slot to adLogicPageDimensions', 'info', logGroup);

		// Register the slot to page dimension module, so it starts only when screen is small enough
		adLogicPageDimensions.addSlot('VIRTUAL_INCONTENT', function () {
			log('Instructed to fill in slot by adLogicPageDimensions', 'info', logGroup);

			var startTime = new Date(),
				totalTime,
				trackedData = {},
				try300x600 = (context.targeting.pageArticleId % 2 === 0), // poor man's consistent coin-flip
				section,
				slotName = 'INCONTENT_1A';

			if (try300x600) {
				log('Trying to fit 300x600', 'info', logGroup);
				$ad.find('.wikia-ad').addClass('height-600');
				section = inContent.getCapableSections($ad)[0];
			}

			if (section) {
				slotName = 'INCONTENT_1C';
			}

			if (!section) {
				$ad.find('.wikia-ad').removeClass('height-600');
				section = inContent.getCapableSections($ad)[0];
			}

			if (section) {
				log('Capable section found, injecting the ad ' + slotName +
					' between ' + section.name + ' and ' + section.nextName, 'info', logGroup);

				$ad.find('.wikia-ad').attr('id', slotName);
				inContent.injectAdPlaceholderIntoSection(section, $ad);
				win.adslots2.push(slotName);

				trackedData.tried300x600 = try300x600 ? 'yes' : 'no';
				trackedData.fitted300x600 = slotName === 'INCONTENT_1C' ? 'yes' : 'no';
				trackedData.top = Math.round($ad.offset().top / 100) * 100;
			} else {
				log('No capable section found', 'info', logGroup);

				trackedData.slot = 'none';
			}

			totalTime = (new Date().getTime() - startTime.getTime());
			log(['total time (s)', totalTime.toFixed(3)], 'debug', logGroup);

			adTracker.track('slot/in_content', trackedData, totalTime);
		});
	}

	return {
		init: init
	};
});
