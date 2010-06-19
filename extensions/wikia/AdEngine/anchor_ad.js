var AnchorAd = {
	settings: {
		background: {
			color: "",
			url: "",
			height: 120,
			left: 0,
		},
		close: {
			url: "http://images1.wikia.nocookie.net/__cb21710/common/skins/monaco/images/monaco-sprite.png",
			url_params: "-64px -106px",
			width: 16,
			height: 16,
			h: 5,
			v: 10,
		},
		creative: {
			url: "",
			width: 800,
			height: 100,
			margin: "10px auto",
		},
		speed: 500,
	},

	getCreative: function() {
		if (AnchorAd.settings.html) {
			return AnchorAd.settings.html;
		}

		var bg = AnchorAd.settings.background;
		var fg = AnchorAd.settings.creative;
		var cl = AnchorAd.settings.close;

		var close = cl.v + "px 0 0 " + (  Math.round(fg.width/2) + cl.h) + "px";
		
		var html = '<style type="text/css">\
			.wikia_anchor_ad {\
				background: url(' + bg.url + ') ' + bg.color + ' top center;\
				bottom: 0;\
				height: ' + bg.height + 'px;\
				left: ' + bg.left + 'px;\
				margin-bottom: -' + bg.height + 'px;\
				position: fixed;\
				text-align: center;\
				width: 100%;\
				z-index: 1000;\
			}\
			.wikia_anchor_ad .creative {\
				cursor: pointer;\
				height: ' + fg.height + 'px;\
				margin: ' + fg.margin + ';\
				width: ' + fg.width + 'px;\
			}\
			.sprite.close {\
				background: url(' + cl.url + ') ' + cl.url_params + ';\
				cursor: pointer;\
				height: ' + cl.height + 'px;\
				left: 50%;\
				margin: ' + close + ';\
				position: absolute;\
				width: ' + cl.width + 'px;\
			}\
		</style>\
		<div class="wikia_anchor_ad">\
			<img src="http://images1.wikia.nocookie.net/__cb21710/common/skins/common/blank.gif" class="sprite close" />\
			<img src="' + fg.url + '" class="creative" />\
		</div>';

		return html;
	},

	init: function() {
		if (typeof AnchorAd_settings != "undefined") {
			$.extend(true, AnchorAd.settings, AnchorAd_settings);
		}

		if (!AnchorAd.settings.creative.url) {
			WET.byStr("anchor_ad/no_creative");
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
			$(".wikia_anchor_ad").animate({"margin-bottom": 0 - AnchorAd.settings.background.height}, AnchorAd.settings.speed);
		});
				
		WET.byStr("anchor_ad/started");
		$(".wikia_anchor_ad").animate({"margin-bottom": 0}, AnchorAd.settings.speed);		
	}

}

AnchorAd.init();
