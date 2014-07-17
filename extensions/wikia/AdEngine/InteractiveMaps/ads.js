/*global window, define, require, document*/
/*jshint camelcase:false*/
var ads = (function (window, document) {
	'use strict';
	function noop() {}

	function extend() {
		var obj = arguments[0], i, j, k;

		for(i = 1,  j = arguments.length; i < j; i = i + 1) {
			for (k in arguments[i]) {
				if (arguments[i].hasOwnProperty(k)) {
					obj[k] = arguments[i][k];
				}
			}
		}

		return obj;
	}


	function defines() {
		define('ext.wikia.adEngine.adLogicPageParams', function () {

			var hashParams = JSON.parse(document.location.hash.substr(1));

			return {
				getPageLevelParams: function() {
					return extend(hashParams, {
						s0: 'interactivemaps',
						s1: '_interactivemaps',
						s2: 'interactivemaps'
					});
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
						if (window.name) {
							var parentIframe = window.parent.document.getElementById(window.name);

							if (parentIframe) {
								parentIframe.parentNode.style.display = 'block';
							}
						}
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
}(window, document));

