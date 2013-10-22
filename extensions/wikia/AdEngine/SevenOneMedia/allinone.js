/*global:window,document,Wikia*/

Wikia = window.Wikia || {};
Wikia.SevenOneMediaIntegration = {
	enabled: window.wgShowAds && window.wgAdDriverUseSevenOneMedia && Wikia.AbTest.inGroup('SEVENONEMEDIA_ADS', 'ENABLED'),
	loadStyle: function(url) {
		function escape(text) {
			return $('<i></i>').text(text).html();
		}
		if (Wikia.SevenOneMediaIntegration.enabled) {
			document.write('<link rel="stylesheet" href="' + escape(url) + '" />');
		}
	},
	track: function (stage) {
		Wikia.Tracker && Wikia.Tracker.track({
			eventName: 'liftium.71m',
			ga_category: '71m',
			ga_action: 'stage/' + stage,
			trackingMethod: 'ad'
		});
	},
	start: function () {
		if (!Wikia.SevenOneMediaIntegration.enabled) {
			return;
		}
		$('#TOP_BUTTON_WIDE').remove();
		$('#WikiaTopAds').hide().after(
			'<div id="ads-outer">' +
				'<div id="TOP_BUTTON_WIDE"></div>' +
				'<div id="ad-fullbanner2-outer">' +
					'<div id="ad-fullbanner2" class="ad-wrapper" style="visibility:hidden;"></div>' +
				'</div>' +
				'<div id="ad-skyscraper1-outer">' +
					'<div id="ad-skyscraper1" class="ad-wrapper" style="display:none;"></div>' +
				'</div>' +
			'</div>'
		);

		// <!-- (END T4.1) -->

		// <!-- (T4.2) Placeholder for rectangle1 -->

		window.SOI_RT1 = true;
		window.SOI_HP  = true;

		$('#TOP_RIGHT_BOXAD, #HOME_TOP_RIGHT_BOXAD').html(
			'<div id="ad-rectangle1-outer">' +
				'<div id="ad-rectangle1" class="ad-wrapper" style="display:none;"></div>' +
			'</div>'
		);

		// <!-- (END T4.2) -->
		(function () {
			var params = AdLogicPageLevelParams(Wikia.log, window, Krux).getPageLevelParams();

			// <!-- (T3) Ad configuration -->
			window.SOI_SITE     = 'wikia';
			window.SOI_SUBSITE  = params.s0;
			window.SOI_SUB2SITE = params.s1.replace('_', '');
			window.SOI_SUB3SITE = ''; // third level
			window.SOI_CONTENT  = 'content'; // content|video|gallery|game
			window.SOI_WERBUNG  = true;
		}());

		// Available tags
		window.SOI_PU1 = true; // popup1
		window.SOI_FB2 = true; // fullbanner2
		window.SOI_SC1 = true; // skyscraper1

		// Suitability for special ads
		// - from popup1
		window.SOI_PU = false; // popup/popunder
		window.SOI_PL = true; // powerlayer
		window.SOI_FA = false; // baseboard (mnemonic: FooterAd, FloorAd)

		// - from fullbanner2
		window.SOI_PB = true; // powerbanner (728x180)
		window.SOI_PD = true; // pushdown
		window.SOI_BB = true; // billboard
		window.SOI_WP = true; // wallpaper
		window.SOI_FP = true; // fireplace

		// - from skyscraper1
		window.SOI_SB = true; // sidebar (300|400x600, auto-scaling, fixed position)

		// Video ads
		window.SOI_VP  = false;
		window.SOI_LPY = false; // true => fullepisode
		window.SOI_VA1 = false; // preroll
		window.SOI_VA2 = false; // postroll
		window.SOI_VA3 = SOI_LPY; // midroll
		window.SOI_VA4 = false; // overlay
		window.SOI_VA5 = false; // sponsor
		window.SOI_AUTOPLAY = ''; // on|off

		if (!window.myAd) {
			window.myAd = {};
			myAd.loadScript = myAd.insertAd = myAd.finishAd = myAd.exists = function(){};
			myAd.getVideoAdRequest = function(){return '';}
		}

		document.write(
			'<scr' + 'ipt>Wikia.SevenOneMediaIntegration.track("init");</scr' + 'ipt>' +
			'<scr' + 'ipt>myAd.loadScript("site");</scr' + 'ipt>' +
			'<scr' + 'ipt>myAd.loadScript("global");</scr' + 'ipt>' +
			'<scr' + 'ipt>Wikia.SevenOneMediaIntegration.track("scripts");</scr' + 'ipt>' +
			'<div id="ads-postponed" style="display:none">' +
				'<table><tr><td>'  +
					'<div id="ad-popup1-postponed" class="ad-wrapper">' +
						'<scr' + 'ipt type="text/javascript">' +
							'myAd.insertAd("popup1");' +
						'</scr' + 'ipt>' +
					'</div>' +
				'</td></tr></table>' +
				'<scr' + 'ipt type="text/javascript">' +
					'myAd.finishAd("popup1", "move");' +
				'</scr' + 'ipt>' +
				'<table><tr><td>' +
					'<div id="ad-fullbanner2-postponed" class="ad-wrapper">' +
						'<scr' + 'ipt type="text/javascript">' +
							'myAd.insertAd("fullbanner2");' +
						'</scr' + 'ipt>' +
					'</div>' +
				'</td></tr></table>' +
				'<scr' + 'ipt type="text/javascript">' +
					'myAd.finishAd("fullbanner2", "move");' +
					'if (!myAd.isSpecialAd("fullbanner2")) {' +
						'window.adslots2.push(["TOP_BUTTON_WIDE.force"]);' +
					'}' +
				'</scr' + 'ipt>' +
				'<table><tr><td>' +
					'<div id="ad-skyscraper1-postponed" class="ad-wrapper">' +
						'<scr' + 'ipt type="text/javascript">' +
							'myAd.insertAd("skyscraper1");' +
						'</scr' + 'ipt>' +
					'</div>' +
				'</td></tr></table>' +
				'<scr' + 'ipt type="text/javascript">' +
					'myAd.finishAd("skyscraper1", "move");' +
				'</scr' + 'ipt>' +
				'<table><tr><td>' +
					'<div id="ad-rectangle1-postponed" class="ad-wrapper">' +
						'<scr' + 'ipt type="text/javascript">' +
							'myAd.insertAd("rectangle1");' +
					'</scr' + 'ipt>' +
				'</div>' +
				'</td></tr></table>' +
				'<scr' + 'ipt type="text/javascript">' +
					'$("#TOP_RIGHT_BOXAD, #HOME_TOP_RIGHT_BOXAD").removeClass("default-height");' +
					'myAd.finishAd("rectangle1", "move");' +
				'</scr' + 'ipt>' +
			'</div>' +
			'<scr' + 'ipt>Wikia.SevenOneMediaIntegration.track("ads");</scr' + 'ipt>'
		);
	}
};
