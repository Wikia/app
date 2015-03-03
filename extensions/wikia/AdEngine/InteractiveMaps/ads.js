/*global window, define, require, document*/
/*jshint camelcase:false*/
var ads = (function (window, document) {
	'use strict';
	function noop() { return; }

	function defines() {
		define('ext.wikia.adEngine.adLogicPageParams', function () {

			var hashParams = JSON.parse(document.location.hash.substr(1));

			return {
				getPageLevelParams: function () {
					return hashParams.adParams;
				}
			};
		});

		define('ext.wikia.adEngine.wikiaGptAdDetect', function () {
			function onAdLoad(slotname, gptEvent) {
				var parentIframeContainer,
					height = gptEvent.size && gptEvent.size[1];

				if (!window.name || gptEvent.isEmpty || height <= 1) {
					return;
				}

				parentIframeContainer = window.parent.document.getElementById(window.name).parentNode;

				if (parentIframeContainer) {
					parentIframeContainer.className = parentIframeContainer.className.replace('hidden', '');
					parentIframeContainer.parentNode.className += ' ad-shown';
				}
			}

			return {
				onAdLoad: onAdLoad
			};
		});
	}

	function fillAd() {
		require(['ext.wikia.adEngine.provider.directGptMaps'], function (gpt) {
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

