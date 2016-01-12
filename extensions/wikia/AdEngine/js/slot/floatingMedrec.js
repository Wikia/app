/*global define*/
define('ext.wikia.adEngine.slot.floatingMedrec', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adHelper',
	'jquery',
	'wikia.log',
	'wikia.window'
], function (adContext, adHelper, $, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.floatingMedrec';

	log('load', 'debug', logGroup);

	function init() {
		var context = adContext.getContext(),
			positionFixed = false,
			threshold = 10,
			slotName = 'INCONTENT_BOXAD_1',
			$slot = $('<div class="wikia-ad" style="position: relative;"></div>').attr('id', slotName),
			$placeHolder = $('#WikiaAdInContentPlaceHolder'),
			$footer = $('#WikiaFooter'),
			$leftSkyscraper3 = $('#LEFT_SKYSCRAPER_3'),
			$globalNavigation = $('#globalNavigation'),
			lastAdHeight,
			startPosition,
			stopPosition,
			globalNavigationHeight;

		if (!context.opts.floatingMedrec || !win.wgIsContentNamespace || !$placeHolder.length) {
			log(['init', 'Floating medrec disabled'], 'debug', logGroup);
			return;
		}

		$placeHolder.append($slot);

		globalNavigationHeight = $globalNavigation.height();
		lastAdHeight = $slot.height();

		startPosition = parseInt($placeHolder.offset().top, 10) - globalNavigationHeight - threshold;

		stopPosition = Math.min(
			parseInt($footer.offset().top, 10),
			parseInt($leftSkyscraper3.offset().top, 10)) - globalNavigationHeight - 2 * threshold - lastAdHeight;

		function update() {
			if (lastAdHeight !== $slot.height()) {
				stopPosition -= $slot.height() - lastAdHeight;
				lastAdHeight = $slot.height();
			}

			if (positionFixed && win.scrollY <= startPosition) {
				$slot.css({
					position: 'relative',
					top: '0px'
				});
				positionFixed = false;
			}

			if (win.scrollY > startPosition && win.scrollY < stopPosition) {
				$slot.css({
					position: 'fixed',
					top: globalNavigationHeight + threshold + 'px'
				});
				positionFixed = true;
			}

			if (win.scrollY >= stopPosition) {
				$slot.css({
					position: 'absolute',
					top: stopPosition - startPosition + 'px'
				});
				positionFixed = false;
			}
		}

		win.addEventListener('scroll', adHelper.throttle(update, 100));
		win.addEventListener('resize', adHelper.throttle(update));

		win.adslots2.push(slotName);
	}

	return {
		init: init
	};
});
