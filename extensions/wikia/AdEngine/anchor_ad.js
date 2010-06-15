var AnchorAd = {
	settings: {
		background: {
			color: "",
			height: 120,
			left: 0,
			url: "http://images4.wikia.nocookie.net/__cb20100606044158/techteamtest/images/e/ee/Anchor-ad-background.png",
		},
		close: "right",
		creative: {
			height: 100,
			margin: "10px auto",
			url: "http://images1.wikia.nocookie.net/__cb21710/common/skins/common/blank.gif",
			width: 800,
		},
		speed: 500,
	},

	getCreative: function() {
		if (AnchorAd.settings.html) {
			return AnchorAd.settings.html;
		}

		var bg = AnchorAd.settings.background;
		var fg = AnchorAd.settings.creative;

		if (AnchorAd.settings.close == "right") {
			var close = "5px 0 0 " + (  Math.round(fg.width/2) + 5) + "px";
		} else if (AnchorAd.settings.close == "left") {
			var close = "5px 0 0 " + ( -Math.round(fg.width/2) - 5 - 16) + "px";
		} else {
			var close = AnchorAd.settings.close;
		}
		
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
				background: url(http://images1.wikia.nocookie.net/__cb21710/common/skins/monaco/images/monaco-sprite.png) -64px -106px;\
				cursor: pointer;\
				height: 16px;\
				left: 50%;\
				margin: ' + close + ';\
				position: absolute;\
				/* top: 5px; */\
				width: 16px;\
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
				
		$(".wikia_anchor_ad").animate({"margin-bottom": 0}, AnchorAd.settings.speed);		
	}

}

AnchorAd.init();
