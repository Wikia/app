/*global define, require*/
define('ext.wikia.adEngine.template.modal', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adHelper',
	'wikia.document',
	'wikia.log',
	'wikia.iframeWriter',
	'wikia.window',
	require.optional('wikia.ui.factory')
], function (adContext, adHelper, doc, log, iframeWriter, win, uiFactory) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.modal',
		modalId = 'ext-wikia-adEngine-template-modal',
		lightBoxExpansionModel = {
			mercury: {
				availableHeightRatio: 1,
				availableWidthRatio: 1,
				heightSubtract: 80,
				minWidth: 100,
				minHeight: 100,
				maximumRatio: 3
			},
			oasis: {
				availableHeightRatio: 0.8,
				availableWidthRatio: 0.9,
				heightSubtract: 90,
				minWidth: 200,
				minHeight: 150,
				maximumRatio: 2
			}
		};

	/**
	 * Show the modal ad
	 *
	 * @param {Object} params
	 * @param {string} params.code - code to put into Lightbox
	 * @param {number} params.width - desired width of the Lightbox
	 * @param {number} params.height - desired height of the Lightbox
	 * @param {boolean} params.scalable - extend iframe to maximum sensible size of the Lightbox
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
			skin = adContext.getContext().targeting.skin,
			lightboxParams = lightBoxExpansionModel[skin];

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

		function createAndShowDesktopModal() {
			var modalConfig = {
				vars: {
					id: modalId,
					size: 'medium',
					content: '',
					title: 'Advertisement',
					closeText: 'Close',
					buttons: []
				}
			};

			uiFactory.init('modal').then(function (uiModal) {
				uiModal.createComponent(modalConfig, function (modal) {
					modal.$content.append(adContainer);
					modal.$element.width('auto');
					modal.show();
				});
			});
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

		if (skin === 'oasis') {
			scaleAdIfNeeded();
			createAndShowDesktopModal();
		}

		if (skin === 'mercury') {
			scaleAdIfNeeded();
			win.Mercury.Modules.Ads.getInstance().openLightbox(adContainer);
		}
	}

	return {
		show: show
	};
});
