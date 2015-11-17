/*global define*/
define('ext.wikia.adEngine.template.modal', [
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.provider.gpt.adDetect',
	'ext.wikia.adEngine.template.modalHandlerFactory',
	'wikia.document',
	'wikia.log',
	'wikia.iframeWriter',
	'wikia.window'
], function (adHelper, adDetect, modalHandlerFactory, doc, log, iframeWriter, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.modal',
		modalHandler = modalHandlerFactory.create();

	/**
	 * Show the modal ad
	 *
	 * @param {Object} params
	 * @param {string} params.code - code to put into Lightbox
	 * @param {number} params.width - desired width of the Lightbox
	 * @param {number} params.height - desired height of the Lightbox
	 * @param {boolean} params.scalable - extend iframe to maximum sensible size of the Lightbox
	 * @param {boolean} [params.canHop] - detect ad in the embedded iframe
	 * @param {string}  [params.slotName] - name of the original slot (required if params.canHop set to true)
	 * @param {number} [params.closeDelay] - delay (in seconds) after which a close button will appear and modal will be able to close
	 */
	function show(params) {
		log(['show', params], 'debug', logGroup);

		var adContainer = doc.createElement('DIV'),
			adIframe = iframeWriter.getIframe({
				code: params.code,
				height: params.height,
				width: params.width,
				classes: 'wikia-ad-iframe'
			}),
			async = params.canHop && params.slotName,
			gptEventMock = {
				size: {
					width: params.width,
					height: params.height
				}
			},
			lightboxParams = modalHandler.getExpansionModel();

		if (modalHandler === null) {
			return;
		}

		function scaleAd() {
			var availableWidth = Math.max(
					win.innerWidth * lightboxParams.availableWidthRatio,
					lightboxParams.minWidth
				),
				availableHeight = Math.max(
					win.innerHeight * lightboxParams.availableHeightRatio - lightboxParams.heightSubtract,
					lightboxParams.minHeight
				),
				ratioWidth = availableWidth / params.width,
				ratioHeight = availableHeight / params.height,
				ratio = Math.min(ratioWidth, ratioHeight, lightboxParams.maximumRatio);

			adIframe.style.transform = 'scale(' + ratio + ')';
			adIframe.style.msTransform = 'scale(' + ratio + ')';
			adIframe.style.WebkitTransform = 'scale(' + ratio + ')';

			adIframe.style.transformOrigin = 'top left';
			adIframe.style.msTransformOrigin = 'top left';
			adIframe.style.WebkitTransformOrigin = 'top left';

			adContainer.style.width = Math.floor(params.width * ratio) + 'px';
			adContainer.style.height = Math.floor(params.height * ratio) + 'px';
		}

		function scaleAdIfNeeded() {
			if (params.scalable) {
				scaleAd();
				win.addEventListener('resize', adHelper.throttle(function () {
					scaleAd();
				}));
			}
		}

		adIframe.style.maxWidth = 'none';
		adContainer.appendChild(adIframe);

		if (async) {
			adIframe.addEventListener('load', function () {
				adDetect.onAdLoad(params.slotName + ' (modal inner iframe)', gptEventMock, adIframe, function () {
					log(['ad detect', params.slotName, 'success'], 'info', logGroup);
					win.postMessage('{"AdEngine":{"slot_' + params.slotName + '":true,"status":"success"}}', '*');
					modalHandler.show();
				}, function () {
					log(['ad detect', params.slotName, 'hop'], 'info', logGroup);
					win.postMessage('{"AdEngine":{"slot_' + params.slotName + '":true,"status":"hop"}}', '*');
				});
			});
		}

		scaleAdIfNeeded();
		if (!params.hasOwnProperty('closeDelay')) {
			params.closeDelay = 0;
		}
		modalHandler.create(adContainer, !async, params.closeDelay);
	}

	return {
		show: show
	};
});
