/*global define, require, document*/
/*jshint camelcase:false*/
var ads = (function (document) {
	'use strict';
	function noop() {}

	function defines() {
		define('ext.wikia.adEngine.adLogicPageParams', function () {

			return {
				getPageLevelParams: function() {
					return {
						s0: 'interactivemaps',
						s1: '_interactivemaps',
						s2: 'interactivemaps'
					};
				}
			};
		});

		define('ext.wikia.adEngine.gptSlotConfig', function () {
			var slotMapConfig = {
				mobile: {
					MAPS_BUTTON: {size: '250x50'}
				}
			};

			function getConfig(src) {
				var undef;

				if (src === undef) {
					return slotMapConfig;
				}

				return slotMapConfig[src];
			}

			return {
				getConfig: getConfig
			};
		});

		define('ext.wikia.adEngine.wikiaGptAdDetect', function () {
			function onAdLoad(slotname, gptEvent, iframe, adCallback, noAdCallback) {
				if (gptEvent.isEmpty) {
					if (typeof noAdCallback === 'function') {
						noAdCallback();
					}
				} else {
					if (typeof adCallback === 'function') {
						adCallback();
					}
				}
			}

			return {
				onAdLoad: onAdLoad
			};
		});
	}

	function fillAd() {
		require(['ext.wikia.adEngine.provider.directGptMobile'], function (gpt) {
			gpt.fillInSlot('MAPS_BUTTON', noop, noop);
		});
	}

	function load() {
		defines();
		fillAd();
	}

	return {
		load: load
	};
}(document));

