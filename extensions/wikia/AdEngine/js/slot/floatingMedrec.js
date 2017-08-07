/*global define*/
define('ext.wikia.adEngine.slot.floatingMedrec', [
	'ext.wikia.adEngine.adContext',
	'jquery',
	'wikia.log',
	'wikia.throttle',
	'wikia.window'
], function (
	adContext,
	$,
	log,
	throttle,
	win
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.floatingMedrec';

	function init() {
		var context = adContext.getContext(),
			isEnoughSpace = false,
			enabled = false,
			adPushed = false,
			globalNavigationHeight = $('#globalNavigation').outerHeight(true),
			handleFloatingMedrec,
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

		handleFloatingMedrec = throttle(function () {
			var scrollTop = $win.scrollTop();

			startPosition = getStartPosition($placeHolder);
			stopPosition = getStopPosition($adSlot, $footer, $(leftSkyscraper3Selector));
			isEnoughSpace = stopPosition - startPosition > minDistance;

			if (enabled && !isEnoughSpace) {
				log(['handleFloatingMedrec',
					'Disabling floating medrec: not enough space in right rail'], 'debug', logGroup);


				$adSlot.css({
					visibility: 'hidden'
				});

				enabled = false;
			}

			if (!enabled && isEnoughSpace && scrollTop >= startPosition) {
					log(['handleFloatingMedrec', 'Enabling floating medrec'], 'debug', logGroup);

					enabled = true;

					if (!adPushed) {
						$placeHolder.append($adSlot);
						win.adslots2.push({ slotName: slotName });
						adPushed = true;

						win.removeEventListener('scroll', handleFloatingMedrec);
					}
			}
		});

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

			win.addEventListener('scroll', handleFloatingMedrec);
		}

		start();
	}

	return {
		init: init
	};
});
