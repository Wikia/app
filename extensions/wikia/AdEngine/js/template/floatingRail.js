/*global define*/
define('ext.wikia.adEngine.template.floatingRail', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.utils.math',
	'jquery',
	'wikia.log',
	'wikia.throttle',
	'wikia.window'
], function (adContext, math, $, log, throttle, win) {
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
		logGroup = 'ext.wikia.adEngine.template.floatingRail',
		railWidth = 300,

		availableSpace,
		articleHeight,
		floatingSpace,
		scrollTop,
		startPosition,
		stopPosition,

		update = throttle(function () {
			startPosition = parseInt($railWrapper.offset().top, 10) - globalNavHeight - margin;
			stopPosition = startPosition + floatingSpace;
			scrollTop = $win.scrollTop();

			// Check if medrec has hidden class for handling tablet mode
			if (scrollTop <= startPosition || $medrec.hasClass('hidden')) {
				$rail.css({
					position: 'static',
					paddingTop: '0px',
					top: '0px',
					width: railWidth + 'px'
				});
			} else if (scrollTop > startPosition && scrollTop < stopPosition) {
				$rail.css({
					position: 'fixed',
					paddingTop: '0px',
					top: globalNavHeight + margin + 'px',
					width: railWidth + 'px'
				});
			} else if (scrollTop >= stopPosition) {
				$rail.css({
					position: 'static',
					paddingTop: floatingSpace + 'px',
					top: '0px',
					width: railWidth + 'px'
				});
			}
		}, 50);

	function getChildrenHeight() {
		var height = 0;

		$rail.children().each(function () {
			height += $(this).height();
		});

		return height;
	}

	function getAvailableSpace() {
		if (!availableSpace) {
			availableSpace =
				$wikiaMainContent.height() - getChildrenHeight() + medrecDefaultSize - adsInRail * biggestAdSize;
			availableSpace = Math.max(0, availableSpace);

			log(['getAvailableSpace', availableSpace], 'debug', logGroup);
		}

		return availableSpace;
	}

	function getArticleHeight() {
		if (!articleHeight) {
			articleHeight = $wikiaMainContent.height();
			log(['getArticleHeight', articleHeight], 'debug', logGroup);
		}
		return articleHeight;
	}

	function show(params) {
		var offset = params.offset || 0,
			context = adContext.getContext(),
			isPageSupported = context.targeting.skin === 'oasis' &&
				context.targeting.pageType === 'article';

		if (context.opts.adMix3Enabled || context.opts.premiumAdLayoutEnabled) {
			return;
		}

		if(!isPageSupported || getAvailableSpace() === 0) {
			return;
		}

		floatingSpace = Math.min(offset, getAvailableSpace());

		win.addEventListener('scroll', update);
		win.addEventListener('resize', update);
	}

	function getArticleHeightParameter() {
		var space = getArticleHeight();
		return math.getBucket(space, 1500);
	}

	return {
		getArticleHeightParameter: getArticleHeightParameter,
		show: show
	};
});
