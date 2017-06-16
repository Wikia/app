/*global define*/
define('ext.wikia.adEngine.slot.floatingMedrec', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.slot.service.viewabilityHandler',
	'jquery',
	'wikia.abTest',
	'wikia.log',
	'wikia.throttle',
	'wikia.window'
], function (
	adContext,
	viewabilityHandler,
	$,
	abTest,
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
			margin = 10,
			minDistance = 800,
			leftSkyscraper3Selector = '#LEFT_SKYSCRAPER_3',
			slotName = 'INCONTENT_BOXAD_1',
			startPosition,
			stopPoint,
			stopPosition,
			$adSlot = $('<div class="wikia-ad"></div>').attr('id', slotName),
			$footer = $('#WikiaFooter'),
			$recirculationRail = $('#recirculation-rail'),
			$placeHolder = $('#WikiaAdInContentPlaceHolder'),
			$win = $(win),
			refresh = {
				refreshAdPos: 0,
				lastRefreshTime: new Date(),
				refreshNumber: 0,
				adVisible: true,
			},
			admix3or5Enabled = context.opts.adMix3Enabled || context.opts.adMix5Enabled;

		function getStartPosition(placeHolder) {
			return parseInt(placeHolder.offset().top, 10) -
					// TODO understand when palceholder height is required
				globalNavigationHeight - margin;
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

			if (!context.opts.adMixExperimentEnabled) {
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

				if (context.opts.adMix1Enabled) {
					refreshAdIfPossible();
				}

				if (admix3or5Enabled && shouldChangeSlot($adSlot.offset().top, 6)) {
					if (refresh.adVisible) {
						$adSlot.addClass('hidden');
						$recirculationRail.show();
					} else {
						viewabilityHandler.refreshOnView(slotName, 0);
						$recirculationRail.hide();
					}

					refresh.adVisible = !refresh.adVisible;
				}

		}

		function getDifference(currentAdPos) {
			return currentAdPos > refresh.refreshAdPos ? currentAdPos - refresh.refreshAdPos : refresh.refreshAdPos - currentAdPos;
		}

		function refreshAdIfPossible() {
			var currentAdPos = $adSlot.offset().top;

			if (shouldChangeSlot(currentAdPos, 3)) {
				viewabilityHandler.refreshOnView(slotName, 0);
			}
		}

		function shouldChangeSlot(currentAdPos, maxChanges) {
			var heightScrolled = getDifference(currentAdPos),
				timeDifference = (new Date()) - refresh.lastRefreshTime,
				result = heightScrolled > 10 && timeDifference > 10000 && refresh.refreshNumber < maxChanges;

			if (result) {
				refresh.lastRefreshTime = new Date();
				refresh.refreshAdPos = currentAdPos;
				refresh.refreshNumber++;
			}

			return result;
		}

		function handleFloatingMedrec() {
			var scrollTop = $win.scrollTop();

			startPosition = getStartPosition($placeHolder);
			stopPosition = getStopPosition($adSlot, $footer, $(leftSkyscraper3Selector));
			isEnoughSpace = stopPosition - startPosition > minDistance;

			if (enabled && !isEnoughSpace) {
				log(['handleFloatingMedrec',
					'Disabling floating medrec: not enough space in right rail'], 'debug', logGroup);

				win.removeEventListener('scroll', update);
				win.removeEventListener('resize', update);

				if (!context.opts.adMixExperimentEnabled) {
					$adSlot.css({
						visibility: 'hidden'
					});
				}

				enabled = false;
			}

			if (!enabled && isEnoughSpace && scrollTop >= startPosition) {
					log(['handleFloatingMedrec', 'Enabling floating medrec'], 'debug', logGroup);

					enabled = !admix3or5Enabled;

					if (!adPushed && (!admix3or5Enabled || shouldChangeSlot(scrollTop, 6))) {
						$placeHolder.append($adSlot);
						win.adslots2.push({
							slotName: slotName,
							onSuccess: function () {
								win.addEventListener('scroll', update);
								win.addEventListener('resize', update);

								refresh.refreshAdPos = $adSlot.offset().top;
								refresh.lastRefreshTime = new Date();
							}
						});
						adPushed = true;

						if (admix3or5Enabled) {
							$recirculationRail.hide();
						}
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

			win.addEventListener('scroll', throttle(handleFloatingMedrec));
			win.addEventListener('resize', throttle(handleFloatingMedrec));
		}

		start();
	}

	return {
		init: init
	};
});
