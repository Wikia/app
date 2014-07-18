/*global window, define, require, document*/
/*jshint camelcase:false*/
var ads = (function (window, document) {
	'use strict';
	function noop() {}

	function defines() {
		define('ext.wikia.adEngine.adLogicPageParams', function () {

			var hashParams = JSON.parse(document.location.hash.substr(1));

			return {
				getPageLevelParams: function() {
					return hashParams.adParams;
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
			function onAdLoad(slotname, gptEvent) {
				if (!gptEvent.isEmpty) {
					if (window.name) {
						var parentIframeContainer = window.parent.document.getElementById(window.name).parentNode;

						if (parentIframeContainer) {
							parentIframeContainer.className = parentIframeContainer.className.replace('hidden', '');
						}
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
}(window, document));

