// AdsInContent2 a.k.a. AIC2
var AIC2 = {
	fingerprint     : 'b',
	called          : false,
	startPosition   : 0,
	stopPosition    : 0,
	magicNumber     : 800,
	WMCbaseWidth    : 680,
	marginLeft      : 190,
	isRightToLeft   : false,
	visible         : false
};
		
AIC2.init = function() {
	Liftium.d("AIC2: init", 5);
	AIC2.called = true;

	if ($("#WikiaMainContent").width() != AIC2.WMCbaseWidth) {
		AIC2.marginLeft = AIC2.marginLeft + parseInt( ($("#WikiaMainContent").width() - AIC2.baseWidth) / 2 );
		Liftium.d("AIC2: non standard width, new marginLeft set to " + AIC2.marginLeft, 5);
		WikiaTracker.track(Liftium.buildTrackUrl([LiftiumOptions.pubid, "AIC2", "wide"]), 'liftium.varia');
	}
	if ($('body').hasClass('rtl')) {
		Liftium.d("AIC2: rtl wiki", 7);
		WikiaTracker.track(Liftium.buildTrackUrl([LiftiumOptions.pubid, "AIC2", "rtl"]), 'liftium.varia');
		AIC2.isRightToLeft = true;
	}

// FIXME
if ($(window).width() < 1010) {
	Liftium.d("AIC2: window too narrow, bailing out", 3);
	WikiaTracker.track(Liftium.buildTrackUrl([LiftiumOptions.pubid, "AIC2", "too_narrow"]), 'liftium.varia');
	return;
}

	if (!AIC2.checkStartStopPosition()) { return; }

	if (AIC2.startPosition + AIC2.magicNumber < AIC2.stopPosition) {
		Liftium.d("AIC2: page long enough", 7);
		$('#WikiaRail').append('<div id="INCONTENT_BOXAD_1" class="noprint" style="height: 250px; width: 300px; position: relative;"><div id="Liftium_300x250_99"><iframe width="300" height="250" id="INCONTENT_BOXAD_1_iframe" class="" noresize="true" scrolling="no" frameborder="0" marginheight="0" marginwidth="0" style="border:none" target="_blank"></iframe></div></div><!-- END SLOTNAME: INCONTENT_BOXAD_1 -->');
		
		//if (!AIC2.checkFooterAd()) {
			$(window).bind("scroll.AIC2", AIC2.onScroll);
			$(window).bind("resize.AIC2", AIC2.onScroll);
		//}

	/*
	WikiaTracker.track(Liftium.buildTrackUrl([LiftiumOptions.pubid, 'AIC2', 'test7']), 'liftium.test');
	if (!Liftium.e(Liftium.debugLevel) || Math.floor(Math.random() * 10) == 7) {
		//Liftium.trackEvent(Liftium.buildTrackUrl(['AIC2', 'test1']), 'UA-17475676-11');
		_gaq.push(['liftium._setAccount', 'UA-17475676-11']);
		_gaq.push(['liftium._setSampleRate', '100']);

		var slot = '300x250_INCONTENT_BOXAD_' + Math.floor(Math.random() * 3);
		var hub = Liftium.getPageVar("Hub", "unknown");
		var lang = Liftium.langForTracking(Liftium.getPageVar("cont_lang", "unknown"));
		var db = Liftium.dbnameForTracking(Liftium.getPageVar("wgDBname", "unknown"));
		var geo = Liftium.geoForTracking(Liftium.getCountry());

		_gaq.push(['liftium._setCustomVar', 1, 'db',   db,   3]);
		_gaq.push(['liftium._setCustomVar', 2, 'hub',  hub,  3]);
		_gaq.push(['liftium._setCustomVar', 3, 'lang', lang, 3]);

		_gaq.push(['liftium._trackEvent', 'slot', 'slot-' + slot,  hub + '/' + lang + '/' + db + '/' + geo]);

		_gaq.push(['liftium._trackEvent',  slot,  'hub-'  + hub,  'lang-' + lang]);
		_gaq.push(['liftium._trackEvent',  slot,  'lang-' + lang, 'geo-' + geo]);
		_gaq.push(['liftium._trackEvent',  slot,  'db-'   + db,   'geo-' + geo]);
		_gaq.push(['liftium._trackEvent',  slot,  'geo-'  + geo]);

		_gaq.push(['liftium._trackPageview', '/999/' + Liftium.buildTrackUrl(['AIC2', 'test2'])]);
	}
	*/

	} else {
		Liftium.d("AIC2: page too short", 3);
		WikiaTracker.track(Liftium.buildTrackUrl([LiftiumOptions.pubid, "AIC2", "too_short"]), 'liftium.varia');
	}
};

AIC2.checkStartStopPosition = function() {
	Liftium.d("AIC2: check start/stop position", 7);

	try {
		var adHeight = parseInt($('#INCONTENT_BOXAD_1').height()) || 0;

		var startPosition = parseInt($('#WikiaRail').offset().top) + parseInt($('#WikiaRail').height()) - adHeight;
		var stopPosition = parseInt($('#WikiaFooter').offset().top) - 10 - adHeight;

		if ($('#LEFT_SKYSCRAPER_3').length && $('#LEFT_SKYSCRAPER_3').height() > 50) {
			Liftium.d("AIC2: sky3 found", 3);
			stopPosition = parseInt($('#LEFT_SKYSCRAPER_3').offset().top) - 20 - adHeight;
		}
	} catch (e) {
		Liftium.d("AIC2: catched in start/stop:", 1, e);
		WikiaTracker.track(Liftium.buildTrackUrl([LiftiumOptions.pubid, "error", "AIC2", "try_catch"]), 'liftium.errors');
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
	if (a == b) { return true; }
	if (b - 3 < a && a < b + 3) { return true; }
	
	return false;
};

AIC2.onScroll = function() {
	Liftium.d("AIC2: onScroll", 9);
		
	if (($(window).scrollTop() > AIC2.startPosition) && ($(window).scrollTop() < AIC2.stopPosition)) {
		if (!AIC2.visible) {
			Liftium.d("AIC2.showAd", 5);
			if (!AIC2.checkStartStopPosition()) { return; }
			//if (!AIC2.checkFooterAd()) {
				if ($('#INCONTENT_BOXAD_1').hasClass('wikia-ad') == false) {
					LiftiumOptions.placement = "INCONTENT_BOXAD_1";
					Liftium.callInjectedIframeAd("300x250", document.getElementById("INCONTENT_BOXAD_1_iframe"));
					$('#INCONTENT_BOXAD_1').addClass('wikia-ad');
				}
				$('#INCONTENT_BOXAD_1').css({
					'position': 'fixed',
					'top': '10px',
					'bottom': '',
					'left': '50%',
					'margin-left': AIC2.marginLeft + 'px'
				});
				if (AIC2.isRightToLeft) {
					$('#INCONTENT_BOXAD_1').css({
						'left': ''
					});
				}
				$('#INCONTENT_BOXAD_1').css('visibility', 'visible');
				
				AIC2.visible = true;
			//}
		}
	} else {
		if (AIC2.visible) {
			Liftium.d("AIC2.hideAd", 5);
			$('#INCONTENT_BOXAD_1').css('visibility', 'hidden');
			AIC2.glueAd();

			AIC2.visible = false;
		}
	}
};

AIC2.glueAd = function() {
	Liftium.d("AIC2: glueAd", 9);

	var adPosition = parseInt($('#INCONTENT_BOXAD_1').offset().top);
	if (adPosition > AIC2.stopPosition) {
		Liftium.d("AIC2: glue at the bottom", 7);

		var bigSpace = parseInt(AIC2.stopPosition - AIC2.startPosition + 10);
		// bottom
		$('#INCONTENT_BOXAD_1').css({
			'position': 'relative',
			'top': bigSpace + 'px',
			'bottom': '',
			'left': '',
			'margin-left': ''
		});
	} else {
		Liftium.d("AIC2: glue at the top", 7);

		// top
		$('#INCONTENT_BOXAD_1').css({
			'position': 'relative',
			'top': '10px',
			'bottom': '',
			'left': '',
			'margin-left': ''
		});
	}

	$('#INCONTENT_BOXAD_1').css('visibility', 'visible');
};

AIC2.checkFooterAd = function() {
	Liftium.d("AIC2: footer ad detection", 7);
	if ($(".wikia_anchor_ad").length) {
		Liftium.d("AIC2: footer ad detected, bailing out", 3);
		$(window).unbind("scroll.AIC2");
		return true;
	} else {
		Liftium.d("AIC2: footer ad not detected, proceeding", 7);
		return false;
	}
};

if (top == self && !(window.wgUserName && !window.wgUserShowAds) && window.wgEnableAdsInContent && window.wgIsContentNamespace && ! AIC2.called && ! window.wgIsMainpage ) {
	wgAfterContentAndJS.push(function(){AIC2.init();});
}
