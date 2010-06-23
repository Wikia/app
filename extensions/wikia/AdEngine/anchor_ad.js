var AnchorAd = {
	settings: {
		close: {
			xoffset: 0,
			yoffset: 0
		},
		speed: 500,
	},

	getCreative: function() {
		var html = '<style type="text/css">\
			.wikia_anchor_ad {\
				background: url(' + AnchorAd.settings.background + ') center center;\
				bottom: 0;\
				height: 120px;\
				left: 0;\
				margin-bottom: -120px;\
				position: fixed;\
				text-align: center;\
				width: 100%;\
				z-index: 1000;\
			}\
			.wikia_anchor_ad .creative {\
				cursor: pointer;\
				margin: 10px auto;\
			}\
			.sprite.close {\
				cursor: pointer;\
				left: 50%;\
				margin-left: ' + parseInt(415 + AnchorAd.settings.close.xoffset) + 'px;\
				margin-top: ' + parseInt(10 + AnchorAd.settings.close.yoffset) + 'px;\
				position: absolute;\
			}\
		</style>\
		<div class="wikia_anchor_ad">\
			<img src="http://images1.wikia.nocookie.net/__cb21710/common/skins/common/blank.gif" class="sprite close" />\
			<img src="' + AnchorAd.settings.creative + '" class="creative" />\
		</div>';

		return html;
	},

	init: function() {
		if (typeof AnchorAd_settings != "undefined") {
			$.extend(true, AnchorAd.settings, AnchorAd_settings);
		}

		if (!AnchorAd.settings.background || !AnchorAd.settings.creative || !AnchorAd.settings.url) {
			WET.byStr("anchor_ad/no_background_creative_or_url_set");
			return;
		}

		$("body").append(this.getCreative());

		if (AnchorAd.settings.url) {
			$(".wikia_anchor_ad .creative").click(function() {
				WET.byStr("anchor_ad/jumped");
				window.location = AnchorAd.settings.url;
			});
		}

		$(".wikia_anchor_ad .close").click(function() {
			WET.byStr("anchor_ad/closed");
			$(".wikia_anchor_ad").animate({"margin-bottom": -120}, AnchorAd.settings.speed);
		});
				
		WET.byStr("anchor_ad/started");
		setTimeout(function() {
			$(".wikia_anchor_ad").animate({"margin-bottom": 0}, AnchorAd.settings.speed);
		}, 2000);
	}

}

AnchorAd.init();