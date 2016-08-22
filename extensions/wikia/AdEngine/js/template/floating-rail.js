/*global define*/
define('ext.wikia.adEngine.template.floating-rail', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.uapContext',
	'ext.wikia.adEngine.adHelper',
	'jquery',
	'wikia.log',
	'wikia.document',
	'wikia.window'
], function (adContext, uapContext, adHelper, $, log, doc, win) {
	'use strict';

	var	$medrec = $('#TOP_RIGHT_BOXAD'),
		$rail = $('#WikiaRail'),
		$railWrapper = $('#WikiaRailWrapper'),
		$wikiaMainContent = $('#WikiaMainContent'),
		$win = $(win),
		adsInRail = 2,
		availableSpace,
		biggestAdSize = 600,
		globalNavHeight = $('#globalNavigation').height(),
		floatingSpace,
		margin = 10,
		medrecDefaultSize = 250,
		logGroup = 'ext.wikia.adEngine.template.floating-rail',
		railWidth = 300,
		startPosition,
		stopPosition,

		update = adHelper.throttle(function () {
			startPosition = parseInt($railWrapper.offset().top, 10) - globalNavHeight - margin;
			stopPosition = startPosition + floatingSpace;

			if ($win.scrollTop() <= startPosition || $medrec.hasClass('hidden')) {
				$rail.css({
					position: 'relative',
					top: '0px',
					width: railWidth + 'px'
				});
			} else if ($win.scrollTop() > startPosition && $win.scrollTop() < stopPosition) {
				$rail.css({
					position: 'fixed',
					top: globalNavHeight + margin + 'px',
					width: railWidth + 'px'
				});
			} else if ($win.scrollTop() >= stopPosition) {
				$rail.css({
					position: 'absolute',
					top: floatingSpace + 2 * globalNavHeight + 'px',
					width: railWidth + 'px'
				});
			}
		}, 50);

	function show(params) {
		var offset = params.offset || 0,
			context = adContext.getContext(),
			isPageSupported = context.targeting.skin === 'oasis' &&
				context.targeting.pageType === 'article';

		if(!isPageSupported || !uapContext.getUapId() || getAvailableSpace() === 0) {
			return;
		}

		floatingSpace = Math.min(offset, getAvailableSpace());

		win.addEventListener('scroll', update);
		win.addEventListener('resize', update);
	}

	function getFloatingSpace() {
		return floatingSpace;
	}

	function getAvailableSpace() {
		if (!availableSpace) {
			availableSpace = Math.max(
				0,
				$wikiaMainContent.height() - $railWrapper.height() + medrecDefaultSize - adsInRail * biggestAdSize
			);

			log(['getAvailableSpace', availableSpace], 'debug', logGroup);
		}

		return availableSpace;
	}

	return {
		getAvailableSpace: getAvailableSpace,
		getFloatingSpace: getFloatingSpace,
		show: show
	};
});
