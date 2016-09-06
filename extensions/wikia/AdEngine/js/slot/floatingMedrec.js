/*global define*/
define('ext.wikia.adEngine.slot.floatingMedrec', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.adLogicPageDimensions',
	'ext.wikia.adEngine.adTracker',
	'jquery',
	'wikia.log',
	'wikia.window'
], function (adContext, adHelper, adLogicPageDimensions, adTracker, $, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.floatingMedrec';

	function init() {
		var context = adContext.getContext(),
			isEnoughSpace = false,
			enabled = false,
			adPushed = false,
			globalNavigationHeight = $('#globalNavigation, .wds-global-navigation').outerHeight(true),
			margin = 10,
			minDistance = 800,
			leftSkyscraper3Selector = '#LEFT_SKYSCRAPER_3',
			slotName = 'INCONTENT_BOXAD_1',
			startPosition,
			stopPoint,
			stopPosition,
			$adSlot = $('<div class="wikia-ad"></div>').attr('id', slotName),
			$footer = $('#WikiaFooter'),
			$placeHolder = $('#WikiaAdInContentPlaceHolder'),
			$win = $(win);

		function getStartPosition(placeHolder) {
			return parseInt(placeHolder.offset().top, 10) - globalNavigationHeight - margin;
		}

		function getStopPosition(ad, footer, leftSkyscraper3) {
			stopPoint = parseInt(footer.offset().top, 10);

			if (leftSkyscraper3.length && parseInt(leftSkyscraper3.height(), 10) !== 0) {
				stopPoint = parseInt(leftSkyscraper3.offset().top, 10);
			}

			return stopPoint - globalNavigationHeight - 2 * margin - ad.height();
		}

		function update() {
			if ($win.scrollTop() <= startPosition) {
				$adSlot.css({
					position: 'relative',
					top: '0px',
					visibility: 'visible'
				});
			}

			if ($win.scrollTop() > startPosition && $win.scrollTop() < stopPosition) {
				$adSlot.css({
					position: 'fixed',
					top: globalNavigationHeight + margin + 'px',
					visibility: 'visible'
				});
			}

			if ($win.scrollTop() >= stopPosition) {
				$adSlot.css({
					position: 'absolute',
					top: stopPosition - startPosition + 'px',
					visibility: 'visible'
				});
			}
		}

		function handleFloatingMedrec() {
			startPosition = getStartPosition($placeHolder);
			stopPosition = getStopPosition($adSlot, $footer, $(leftSkyscraper3Selector));
			isEnoughSpace = stopPosition - startPosition > minDistance;

			if (enabled && !isEnoughSpace) {
				log(['handleFloatingMedrec',
					 'Disabling floating medrec: not enough space in right rail'], 'debug', logGroup);
				if (adLogicPageDimensions.shouldBeShown(slotName)) {
					adTracker.track('floating_medrec/disabling');
				}

				win.removeEventListener('scroll', update);
				win.removeEventListener('resize', update);

				$adSlot.css({
					visibility: 'hidden'
				});

				enabled = false;
			}

			if (!enabled && isEnoughSpace && $win.scrollTop() > startPosition) {
				log(['handleFloatingMedrec', 'Enabling floating medrec'], 'debug', logGroup);

				win.addEventListener('scroll', update);
				win.addEventListener('resize', update);

				enabled = true;

				if (!adPushed) {
					$placeHolder.append($adSlot);
					win.adslots2.push(slotName);
					adPushed = true;
				}
			}
		}

		function start() {
			if (!context.opts.floatingMedrec) {
				log(['init', 'Floating medrec disabled: ad context returns false'], 'debug', logGroup);
				return;
			}

			if (!win.wgIsContentNamespace) {
				log(['init', 'Floating medrec disabled: $wgIsContentNamespace equals false'], 'debug', logGroup);
				return;
			}

			if (!$placeHolder.length) {
				log(['init', 'Floating medrec disabled: no placeHolder'], 'debug', logGroup);
				return;
			}

			win.addEventListener('scroll', adHelper.throttle(handleFloatingMedrec));
			win.addEventListener('resize', adHelper.throttle(handleFloatingMedrec));
		}

		start();
	}

	return {
		init: init
	};
});
