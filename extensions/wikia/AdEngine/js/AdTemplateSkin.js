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
			pixelUrl,
			body = document.getElementsByTagName('body')[0],
			head = document.getElementsByTagName('head')[0],
			style = document.createElement('style'),
			responsiveLink = document.createElement('link'),
			imagePreload = new Image();

		params = params || {};

		if (window.wgOasisResponsive) {
			responsiveLink.rel = 'stylesheet';
			responsiveLink.href = window.wgCdnRootUrl +
				'/__am/' + window.wgStyleVersion + '/sass/' +
				'color-body%3D%2523' + params.backgroundColor + '%26' +
				'background-image%3DNA%26' +
				'background-fixed%3Dtrue%26' +
				'background-tiled%3Dfalse%26' +
				'background-image-height%3D800%26' +
				'background-image-width%3D1700%26' +
				'widthType%3D2' +
				'//skins/oasis/css/core/responsive.scss';

			style.textContent = 'body:after, body:before {' +
				'  background-image:url(' + params.skinImage + ');' +
				'}';

			// Preload skin image, so it effectively download in parallel to the CSS
			imagePreload.src = params.skinImage;

			// Append the necessary CSS
			head.appendChild(responsiveLink);
			head.appendChild(style);

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
