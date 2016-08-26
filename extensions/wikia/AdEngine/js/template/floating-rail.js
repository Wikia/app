/*global define*/
define('ext.wikia.adEngine.template.floating-rail', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.uapContext',
	'ext.wikia.adEngine.utils.math',
	'ext.wikia.adEngine.adHelper',
	'jquery',
	'wikia.log',
	'wikia.document',
	'wikia.window'
], function (adContext, uapContext, math, adHelper, $, log, doc, win) {
	'use strict';

	var $medrec = $('#TOP_RIGHT_BOXAD'),
		$rail = $('#WikiaRail'),
		$railWrapper = $('#WikiaRailWrapper'),
		$wikiaMainContent = $('#WikiaMainContent'),
		$win = $(win),

		adsInRail = 2,
		biggestAdSize = 600,
		globalNavHeight = $('#globalNavigation').height(),
		margin = 10,
		medrecDefaultSize = 250,
		logGroup = 'ext.wikia.adEngine.template.floating-rail',
		railWidth = 300,

		availableSpace,
		floatingSpace,
		scrollTop,
		startPosition,
		stopPosition,

		update = adHelper.throttle(function () {
			startPosition = parseInt($railWrapper.offset().top, 10) - globalNavHeight - margin;
			stopPosition = startPosition + floatingSpace;
			scrollTop = $win.scrollTop();

			// Check if medrec has hidden class for handling tablet mode
			if (scrollTop <= startPosition || $medrec.hasClass('hidden')) {
				$rail.css({
					position: 'relative',
					top: '0px',
					width: railWidth + 'px'
				});
			} else if (scrollTop > startPosition && scrollTop < stopPosition) {
				$rail.css({
					position: 'fixed',
					top: globalNavHeight + margin + 'px',
					width: railWidth + 'px'
				});
			} else if (scrollTop >= stopPosition) {
				$rail.css({
					position: 'absolute',
					top: floatingSpace + 2 * globalNavHeight + 'px',
					width: railWidth + 'px'
				});
			}
		}, 50);

	function getAvailableSpace() {
		if (!availableSpace) {
			availableSpace =
				$wikiaMainContent.height() - $railWrapper.height() + medrecDefaultSize - adsInRail * biggestAdSize;
			availableSpace = Math.max(0, availableSpace);

			log(['getAvailableSpace', availableSpace], 'debug', logGroup);
		}

		return availableSpace;
	}

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

	function getFloatingSpaceParam(slotName) {
		var floatingSpaceParam;

		switch (slotName) {
			case 'TOP_RIGHT_BOXAD':
				floatingSpaceParam = getAvailableSpace();
				break;
			case 'INCONTENT_BOXAD_1':
				floatingSpaceParam = getAvailableSpace() - (floatingSpace || 0);
				break;
			default:
				floatingSpaceParam = 0;
		}

		return math.getBucket(floatingSpaceParam, 100);
	}

	return {
		getFloatingSpaceParam: getFloatingSpaceParam,
		show: show
	};
});
