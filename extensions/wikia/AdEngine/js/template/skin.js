/*global define, require*/
define('ext.wikia.adEngine.template.skin', [
	'ext.wikia.adEngine.adContext',
	'wikia.document',
	'wikia.window',
	'wikia.log'
], function (adContext, doc, win, log) {
	'use strict';

	var logGroup = 'ext.wikia.adengine.template.skin';

	/**
	 * Show the skin ad
	 *
	 * @param {Object} params
	 * @param {string} params.destUrl - URL to go when the background is clicked
	 * @param {string} params.skinImage - URL of the 1700x800 image to show in the background
	 * @param {string} params.backgroundColor - background color to use (rrggbb, without leading #)
	 * @param {string} [params.middleColor] - color to use in the middle (rrggbb, without leading #)
	 * @param {Array} params.pixels - URLs of tracking pixels to append when showing the skin
	 */
	function show(params) {
		win.wgAfterContentAndJS.push(function () {
			log(params, 'debug', logGroup);

			params = params || {};

			var adSkin = doc.getElementById('ad-skin'),
				adSkinStyle = adSkin.style,
				wikiaSkin = doc.getElementById('WikiaPageBackground'),
				wikiaSkinStyle = wikiaSkin && wikiaSkin.style,
				i,
				len,
				pixelElement,
				pixelUrl;

			if (win.wgOasisResponsive || win.wgOasisBreakpoints) {
				require(['wikia.backgroundchanger'], function (backgroundchanger) {
					if (!params.middleColor) { // TODO: Revisit this hack after CONCF-842 is fixed
						params.middleColor = params.backgroundColor;
					}
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
					if (params.ten64) {
						bcParams.ten64 = true;
					}
					backgroundchanger.load(bcParams);
				});
			} else {
				adSkinStyle.background = 'url("' + params.skinImage + '") no-repeat top center #' + params.backgroundColor;
			}

			doc.body.classList.add('background-ad');

			adSkinStyle.position = 'fixed';
			adSkinStyle.height = '100%';
			adSkinStyle.width = '100%';
			adSkinStyle.left = 0;
			adSkinStyle.top = 0;
			adSkinStyle.zIndex = 1;
			adSkinStyle.cursor = 'pointer';

			if (wikiaSkinStyle) {
				wikiaSkinStyle.opacity = 1;
			}

			adSkin.onclick = function () {
				log('Click on skin', 'user', logGroup);
				win.open(params.destUrl);
			};

			win.wgAdSkinPresent = true;

			log('Skin set', 5, logGroup);

			if (params.pixels) {
				for (i = 0, len = params.pixels.length; i < len; i += 1) {
					pixelUrl = params.pixels[i];
					if (pixelUrl) {
						log('Adding tracking pixel ' + pixelUrl, 'debug', logGroup);
						pixelElement = doc.createElement('img');
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
