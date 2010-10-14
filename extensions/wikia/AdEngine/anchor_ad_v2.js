wgAfterContentAndJS.push(
	function(){
		var AnchorAd = {
			settings: {
				close: {
					background: "000000",
					xoffset: 0,
					yoffset: 0
				},
				speed: 500,
			},

			getCreative: function() {
				var html = '<style type="text/css">\
					.wikia_anchor_wrapper {\
						height: 120px;\
						margin: 0 auto;\
						overflow: hidden;\
						position: relative;\
						text-align: center;\
						top: -141px;\
						width: 980px;\
						z-index: 999;\
					}\
					.wikia_anchor_ad {\
						background: url(' + AnchorAd.settings.creative + ') center center;\
						height: 120px;\
						position: absolute;\
						top: 141px;\
						width: 980px;\
					}\
					.wikia_anchor_ad .clickable {\
						cursor: pointer;\
						display: block;\
						left: 90px;\
						position: absolute;\
						width: 800px;\
						height: 100px;\
						top: 10px;\
					}\
					.close {\
						background: url("/extensions/wikia/AdEngine/close_button.png") #' + AnchorAd.settings.close.background + ';\
						cursor: pointer;\
						height: 18px;\
						left: ' + parseInt(950 + AnchorAd.settings.close.yoffset) + 'px;\
						position: absolute;\
						top: ' + parseInt(0 + AnchorAd.settings.close.yoffset) + 'px;\
						width: 18px;\
						z-index: 1;\
					}\
				</style>\
				<div class="wikia_anchor_wrapper">\
					<div class="wikia_anchor_ad">\
						<div class="close"></div>\
						<a class="clickable"></a>\
					</div>\
				</div>';

				return html;
			},

			init: function() {
				if (typeof AnchorAd_settings != "undefined") {
					$.extend(true, AnchorAd.settings, AnchorAd_settings);
				}

				if (!AnchorAd.settings.creative || !AnchorAd.settings.url) {
					WET.byStr("anchor_ad/no_background_creative_or_url_set");
					return;
				}

				$(".toolbar").append(this.getCreative());

				if (AnchorAd.settings.url) {
					$(".wikia_anchor_ad .clickable").click(function() {
						WET.byStr("anchor_ad/jumped");
						window.location = AnchorAd.settings.url;
					});
				}

				$(".wikia_anchor_ad .close").click(function() {
					WET.byStr("anchor_ad/closed");
					$(".wikia_anchor_ad").animate({"top": "141px"}, AnchorAd.settings.speed);
				});
						
				WET.byStr("anchor_ad/started");
				setTimeout(function() {
					$(".wikia_anchor_ad").animate({"top": 0}, AnchorAd.settings.speed);
				}, 2000);
			}

		}

		AnchorAd.init();
	}
);
