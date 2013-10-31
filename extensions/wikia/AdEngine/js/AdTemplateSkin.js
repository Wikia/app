/*global define, Image*/
define('ext.wikia.adengine.template.skin', ['wikia.document', 'wikia.window', 'wikia.log'], function (document, window, log) {
	'use strict';

	var logGroup = 'ext.wikia.adengine.template.skin';

	/**
	 * @param params {
	 *   skinImage
	 *   backgroundColor
	 *   destUrl
	 *   pixels
	 * }
	 */
	function show(params) {
		log(params, 'debug', logGroup);

		var adSkin = document.getElementById('ad-skin'),
			adSkinStyle = adSkin.style,
			wikiaSkin = document.getElementById('WikiaPageBackground'),
			wikiaSkinStyle = wikiaSkin.style,
			i,
			len,
			pixelElement,
			pixelUrl;

		params = params || {};

		if (window.wgOasisResponsive) {
			params.skinImageWidth = 1700;
			params.skinImageHeight = 800;
			params.backgroundTiled = false;
			params.backgroundFixed = true;
			params.backgroundDynamic = true;

			BackgroundChanger.load(params);
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

		adSkin.onclick = function (e) {
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
	}

	return {
		show: show
	};
});
