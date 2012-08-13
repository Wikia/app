
var displayAnchorAd = function(){
	var AnchorAd = {
		settings: {
			close: {
				background: "000000",
				xoffset: 0,
				yoffset: 0
			},
			delay: 0,
			height: 120,
			speed: 500,
			width: 980
		},

		getCreative: function() {
			var top = window.wgUserName ? AnchorAd.settings.height+23 : AnchorAd.settings.height;
			var html = '<style type="text/css">\
				.FooterAd {\
					height: 0;\
					width: 1000px;\
					z-index: 0;\
				}\
				.WikiaFooter.float .FooterAd,\
				.WikiaFooter.notoolbar .FooterAd {\
					bottom: 0;\
					position: fixed;\
				}\
				.WikiaFooter.notoolbar .FooterAd {\
					z-index: 1;\
				}\
				.wikia_anchor_wrapper {\
					height: ' + AnchorAd.settings.height + 'px;\
					margin: 0 auto;\
					overflow: hidden;\
					position: relative;\
					text-align: center;\
					top: -' + top + 'px;\
					width: ' + AnchorAd.settings.width + 'px;\
					z-index: 999;\
				}\
				.wikia_anchor_ad {\
					background: url(' + AnchorAd.settings.creative + ') center center;\
					height: ' + AnchorAd.settings.height + 'px;\
					left: 0;\
					position: absolute;\
					top: ' + parseInt(AnchorAd.settings.height+21) + 'px;\
					width: ' + AnchorAd.settings.width + 'px;\
				}\
				.wikia_anchor_ad .clickable {\
					cursor: pointer;\
					display: block;\
					left: 0;\
					position: absolute;\
					width: ' + parseInt(AnchorAd.settings.width-25) + 'px;\
					height: ' + parseInt(AnchorAd.settings.height-20) + 'px;\
					top: 10px;\
				}\
				.close {\
					background: url("' + window.wgExtensionsPath + '/wikia/AdEngine/close_button.png");\
					cursor: pointer;\
					height: 18px;\
					left: ' + parseInt(AnchorAd.settings.width-18 + AnchorAd.settings.close.yoffset) + 'px;\
					position: absolute;\
					top: ' + parseInt(AnchorAd.settings.close.yoffset) + 'px;\
					width: 18px;\
					z-index: 1;\
				}\
				.close_background {\
					background-color: #' + AnchorAd.settings.close.background + ';\
					height: 14px;\
					left: ' + parseInt(AnchorAd.settings.width-16 + AnchorAd.settings.close.xoffset) + 'px;\
					position: absolute;\
					top: ' + parseInt(2 + AnchorAd.settings.close.yoffset) + 'px;\
					width: 14px;\
					z-index: 0;\
				}\
			</style>\
			<div class="wikia_anchor_wrapper">\
				<div class="wikia_anchor_ad">\
					<div class="close"></div><div class="close_background"></div>\
					<a class="clickable"></a>\
				</div>\
			</div>';

			return html;
		},

		init: function() {
			if (window.AnchorAd_settings) {
				$.extend(true, AnchorAd.settings, window.AnchorAd_settings);
			}

			if (!AnchorAd.settings.creative || !AnchorAd.settings.url) {
				return;
			}

			$("#WikiaFooter .FooterAd").append(this.getCreative());

			if (AnchorAd.settings.url) {
				$(".wikia_anchor_ad .clickable").click(function() {
					window.open(AnchorAd.settings.url, "blank");
				});
			}

			$(".wikia_anchor_ad .close").click(function() {
				var top = AnchorAd.settings.height + 21;
				$(".wikia_anchor_ad").animate({"top": top+"px"}, AnchorAd.settings.speed);
			});

			setTimeout(function() {
				$(".wikia_anchor_ad").animate({"top": 0}, AnchorAd.settings.speed);
			}, AnchorAd.settings.delay);
		}

	};

	AnchorAd.init();
};

displayAnchorAd(); // assume jQuery is already loaded (AdDriver is handling ads)
