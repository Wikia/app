/*global define*/
define('ext.wikia.adEngine.slot.skyScraper3', [
	'ext.wikia.adEngine.adContext',
	'jquery',
	'wikia.log',
	'wikia.window'
], function (adContext, $, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.skyScraper3';

	log('load', 'debug', logGroup);

	function adjustSize($slot) {
		$slot.css('top', (-1 * $slot.height()) + 'px');
	}

	function init() {
		var $footer = $('#WikiaFooter'),
			$rail = $('#WikiaRail'),
			slotName = 'LEFT_SKYSCRAPER_3',
			$slot = $('<div class="wikia-ad"></div>').attr('id', slotName),
			context = adContext.getContext();

		log('init', 'debug', logGroup);

		// Don't start those slots on no_ads, corporate, home etc
		if (context.opts.pageType !== 'all_ads') {
			log('skyScraper3 not started, because context.opts.pageType is not all_ads', 'info', logGroup);
			return;
		}

		if (!$rail.length) {
			log('skyScraper3 not started, because there is no rail', 'info', logGroup);
			return;
		}

		if (!$footer.length) {
			log('skyScraper3 not started, because there is no footer', 'info', logGroup);
			return;
		}

		// In case old HTML is served with new JS, safe to remove later:
		if ($('#' + slotName).length) {
			log('skyScraper3 not added. It was already there', 'error', logGroup);
			return;
		}

		$footer.prepend($slot);
		win.adslots2.push({
			slotName: slotName,
			onSuccess: function () {
				adjustSize($slot);
				$rail.addClass('left-skyscraper-3-present');
			}
		});
	}

	return {
		init: init
	};
});
