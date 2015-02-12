/*global window*/
// AdsInContent2 a.k.a. AIC2
var AIC2 = {
	$placeHolder         : false,
	called               : false,
	fingerprint          : 'b',
	fixedGlobalNavHeight : 0,
	startPosition        : 0,
	stopPosition         : 0,
	magicNumber          : 800,
	isRightToLeft        : false,
	visible              : false
};

AIC2.enabled = (function () {
	'use strict';
	try {
		var isTopWindow = (window.top === window.self),
			opts = window.ads.context.opts,
			isEnabled = opts.showAds && opts.adsInContent,
			targeting = window.ads.context.targeting,
			isArticle = targeting.pageType === 'article' && window.wgIsContentNamespace,
			isSearchPage = targeting.pageType === 'search',
			isCorporate = targeting.wikiIsCorporate;

		return isTopWindow &&
			isEnabled &&
			!isCorporate &&
			(isArticle || isSearchPage);

	} catch (e) {
		AIC2.disabledReason = e;
		return false;
	}
}());

AIC2.init = function() {
	if (!AIC2.enabled || AIC2.called) {
		return;
	}

	AIC2.called = true;

	var $window = $(window),
		$globalNavigation;

	AIC2.$placeHolder = $('#WikiaAdInContentPlaceHolder');

	Liftium.d("AIC2: init", 5);

	if ($('body').hasClass('rtl')) {
		Liftium.d("AIC2: rtl wiki", 7);
		//Wikia.Tracker.track({eventName:'liftium.varia', 'ga_category':'varia/AIC2', 'ga_action':'rtl', trackingMethod: 'ad'});
		AIC2.isRightToLeft = true;
	}

	// FIXME
	if ($window.width() < 1010) {
		Liftium.d("AIC2: window too narrow, bailing out", 3);
		//Wikia.Tracker.track({eventName:'liftium.varia', 'ga_category':'varia/AIC2', 'ga_action':'too narrow', trackingMethod: 'ad'});
		return;
	}

	$globalNavigation = $('#globalNavigation');

	if ($globalNavigation.css('position') === 'fixed') {
		AIC2.fixedGlobalNavHeight = $globalNavigation.outerHeight();
	}


	if (!AIC2.checkStartStopPosition()) { return; }

	if (AIC2.startPosition + AIC2.magicNumber < AIC2.stopPosition) {
		Liftium.d("AIC2: page long enough", 7);
		// TODO: remove style once SCSS always serves it
		AIC2.$placeHolder.css('position', 'absolute');
		AIC2.$placeHolder.append('<div id="INCONTENT_BOXAD_1" class="noprint" style="height: 250px; width: 300px; position: relative;"></div>');
		// End of TODO

		$window.bind("scroll.AIC2", AIC2.onScroll ); // FIXME: throttle
		$window.bind("resize.AIC2", AIC2.onScroll ); // FIXME: throttle
	} else {
		Liftium.d("AIC2: page too short", 3);
		//Wikia.Tracker.track({eventName:'liftium.varia', 'ga_category':'varia/AIC2', 'ga_action':'too short', trackingMethod: 'ad'});
	}
};

AIC2.checkStartStopPosition = function() {
	var startPosition, stopPosition, adHeight
		, $footer = $('#WikiaFooter')
		, $leftSkyScraper = $('#LEFT_SKYSCRAPER_3')
		, $incontentBoxAd = $('#INCONTENT_BOXAD_1');

	Liftium.d("AIC2: check start/stop position", 7);

	if (!AIC2.$placeHolder.length) {
		Liftium.d("AIC2: no rail", 3);
		//Wikia.Tracker.track({eventName:'liftium.varia', 'ga_category':'varia/AIC2', 'ga_action':'no rail', trackingMethod: 'ad'});
		// No rail, no ads
		return false;
	}

	try {
		adHeight = parseInt($incontentBoxAd.height(), 10) || 0;
		startPosition = parseInt(AIC2.$placeHolder.offset().top, 10) - AIC2.fixedGlobalNavHeight;
		stopPosition = parseInt($footer.offset().top, 10) - 10 - adHeight - AIC2.fixedGlobalNavHeight;

		if ($leftSkyScraper.is(':visible') && $leftSkyScraper.height() > 50) {
			Liftium.d("AIC2: sky3 found", 3);
			stopPosition = parseInt($leftSkyScraper.offset().top, 10) - 20 - adHeight - AIC2.fixedGlobalNavHeight;
		}
	} catch (e) {
		Liftium.d("AIC2: catched in start/stop:", 1, e);
		Wikia.Tracker.track({
			eventName: 'liftium.errors',
			ga_category: 'errors/AIC2',
			ga_action: 'try-catch',
			trackingMethod: 'ad'
		});
		// bail out - missing elements, broken dom, erroneous cast...
		return false;
	}

	Liftium.d("AIC2: start/stop old/new", 7, [AIC2.startPosition, AIC2.stopPosition, startPosition, stopPosition]);

	// first time here (AIC2.init, most likely) - set up and proceed
	if (!AIC2.startPosition && !AIC2.stopPosition) {
		AIC2.startPosition = startPosition;
		AIC2.stopPosition = stopPosition;
		Liftium.d("AIC2: start/stop position set up", 7);
		return true;
	}

	// numbers are correct - continue
	// actually, height/offset varries a bit on each scroll, allow for some wiggle room
	if (AIC2.isAlmostEqual(AIC2.startPosition, startPosition) && AIC2.isAlmostEqual(AIC2.stopPosition, stopPosition)) {
		Liftium.d("AIC2: start/stop position correct", 7);
		return true;
	}

	// numbers don't match - fix and skip a beat
	AIC2.startPosition = startPosition;
	AIC2.stopPosition = stopPosition;
	Liftium.d("AIC2: start/stop position fixed", 5);
	return false;
};

AIC2.isAlmostEqual = function(a, b) {
	return Math.abs(a - b) < 3;
};

AIC2.onScroll = function() {
	var $window = $(window),
		$incontentBoxAd = $('#INCONTENT_BOXAD_1');

	Liftium.d("AIC2: onScroll", 9);

	if (($window.scrollTop() > AIC2.startPosition) && ($window.scrollTop() < AIC2.stopPosition)) {
		if (!AIC2.visible) {
			Liftium.d("AIC2.showAd", 5);
			if (!AIC2.checkStartStopPosition()) { return; }
			if ($incontentBoxAd.hasClass('wikia-ad') === false) {
				window.adslots2.push('INCONTENT_BOXAD_1');
				$incontentBoxAd.addClass('wikia-ad');
			}
			$incontentBoxAd.css({
				'position': 'fixed',
				'top': (10 + AIC2.fixedGlobalNavHeight) + 'px',
				'visibility': 'visible'
			});

			AIC2.visible = true;
		}
	} else {
		if (AIC2.visible) {
			Liftium.d("AIC2.hideAd", 5);
			$incontentBoxAd.css('visibility', 'hidden');
			AIC2.glueAd();

			AIC2.visible = false;
		}
	}
};

AIC2.glueAd = function() {
	Liftium.d("AIC2: glueAd", 9);

	var $incontentBoxAd = $('#INCONTENT_BOXAD_1'),
		adPosition = parseInt($incontentBoxAd.offset().top);

	if (adPosition > AIC2.stopPosition) {
		Liftium.d("AIC2: glue at the bottom", 7);

		var bigSpace = parseInt(AIC2.stopPosition - AIC2.startPosition + 10);
		// bottom
		$incontentBoxAd.css({
			'position': 'absolute',
			'top': bigSpace + 'px'
		});
	} else {
		Liftium.d("AIC2: glue at the top", 7);

		// top
		$incontentBoxAd.css({
			'position': 'relative',
			'top': '10px'
		});
	}

	$incontentBoxAd.css('visibility', 'visible');
};
