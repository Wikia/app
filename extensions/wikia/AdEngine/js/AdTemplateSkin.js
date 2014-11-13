/*global define, require*/
define('ext.wikia.adEngine.template.skin', [
	'wikia.document',
	'wikia.window',
	'wikia.log'
], function (document, window, log, backgroundchanger) {
	'use strict';

	var logGroup = 'ext.wikia.adengine.template.skin';

	/**
	 * @param params {
	 *   skinImage
	 *   backgroundColor
	 *   middleColor
	 *   destUrl
	 *   pixels
	 * }
	 */
	function show(params) {
		window.wgAfterContentAndJS.push(function () {
			log(params, 'debug', logGroup);

			params = params || {};

			var adSkin = document.getElementById('ad-skin'),
				adSkinStyle = adSkin.style,
				wikiaSkin = document.getElementById('WikiaPageBackground'),
				wikiaSkinStyle = wikiaSkin.style,
				i,
				len,
				pixelElement,
				pixelUrl;

			if (window.wgOasisResponsive || window.skin === 'venus') {
				require(['wikia.backgroundchanger'], function (backgroundchanger) {
					var bcParams = {
						skinImage: params.skinImage,
						skinImageWidth: 1700,
						skinImageHeight: 800,
						backgroundTiled: false,
						backgroundFixed: true,
						backgroundDynamic: true
					};
					if (params.backgroundColor) {
						bcParams.backgroundColor = '#' + params.backgroundColor;
					}
					if (params.middleColor) {
						bcParams.backgroundMiddleColor = '#' + params.middleColor;
					}
					backgroundchanger.load(bcParams);
				});
			} else {
				adSkinStyle.background = 'url("' + params.skinImage + '") no-repeat top center #' + params.backgroundColor;
			}

			adSkinStyle.position = 'fixed';
			adSkinStyle.height = '100%';
			adSkinStyle.width = '100%';
			adSkinStyle.left = 0;
			adSkinStyle.top = 0;
			adSkinStyle.zIndex = 0;
			adSkinStyle.cursor = 'pointer';

			wikiaSkinStyle.opacity = 1;

			adSkin.onclick = function () {
				log('Click on skin', 'user', logGroup);
				window.open(params.destUrl);
			};

			window.wgAdSkinPresent = true;

			log('Skin set', 5, logGroup);

			if (params.pixels) {
				for (i = 0, len = params.pixels.length; i < len; i += 1) {
					pixelUrl = params.pixels[i];
					if (pixelUrl) {
						log('Adding tracking pixel ' + pixelUrl, 'debug', logGroup);
						pixelElement = document.createElement('img');
						pixelElement.src = pixelUrl;
						pixelElement.width = 1;
						pixelElement.height = 1;
						adSkin.appendChild(pixelElement);
					}
				}
			}

			log('Pixels added', 'debug', logGroup);
		});
	}

	return {
		show: show
	};
});
