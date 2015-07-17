/*global define*/
define('ext.wikia.adEngine.template.modal', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adHelper',
	'wikia.log',
	'wikia.iframeWriter',
	'wikia.window',
	require.optional('wikia.ui.factory')
], function (adContext, adHelper, log, iframeWriter, win, uiFactory) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.modal',
		modalId = 'ext-wikia-adEngine-template-modal',
		lightBoxHeaderHeight = 40,
		lightBoxHeaderHeightDesktop = 45,
		maximumRatio = 3, // don't scale the ad more than 3 times
		minimumRatio = 0.66;

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
		var skin = adContext.getContext().targeting.skin;
		var adIframe = createAdIframe(params);

		if (skin === 'oasis') {
			log(['show desktop modal'], 'debug', logGroup);
			createAndShowDesktopModal(adIframe, params);
		}

		if (skin === 'mercury') {
			log(['show mobile (Mercury) modal'], 'debug', logGroup);
			appendScalability(scaleAdIframe, adIframe, params);
			win.Mercury.Modules.Ads.getInstance().openLightbox(adIframe);
		}
	}

	function appendScalability(scaleFn, adIframe, params) {
		if (params.scalable) {
			log(['show scale the ad'], 'debug', logGroup);

			scaleFn(adIframe, params);

			win.addEventListener('resize', adHelper.throttle(function () {
				scaleFn(adIframe, params);
			}));
		}
	}

	function createAndShowDesktopModal(adIframe, params) {
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
				modal.$content.append(adIframe);
				modal.$element.width('auto');
				modal.show();
				appendScalability(scaleAdIframeDesktop, adIframe, params);
			});
		});
	}

	function createAdIframe(params) {
		return iframeWriter.getIframe({
			code: params.code,
			height: params.height,
			width: params.width,
			classes: 'wikia-ad-iframe'
		});
	}

	function scaleAdIframeDesktop(adIframe, params) {
		var ratioWidth = win.innerWidth / params.width,
			ratioHeight = (((win.innerHeight)-(lightBoxHeaderHeightDesktop*2))) / params.height,
			ratio = Math.max(minimumRatio, Math.min(ratioWidth, ratioHeight, maximumRatio)),
			iframeParent = adIframe.parentElement;

		iframeParent.parentElement.style.height = '100%';
		iframeParent.parentElement.style.maxHeight = '100%';

		iframeParent.style.padding = '0px';
		iframeParent.style.width = (params.width * ratio) + 'px';
		iframeParent.style.height = (params.height * ratio) + 'px';

		var verticalDifference = iframeParent.offsetHeight - (params.height * ratio);

		if (verticalDifference > 0) {
			adIframe.style.marginTop = (iframeParent.offsetHeight - (params.height * ratio) )/2 + 'px';
		} else {
			adIframe.style.marginTop = '0px';
		}
		adIframe.style.transform = 'scale(' + ratio + ')';
		adIframe.style.transformOrigin = 'top left';
	}

	function scaleAdIframe(adIframe, params) {
		var ratioWidth = win.innerWidth / params.width,
			ratioHeight = (win.innerHeight - lightBoxHeaderHeight) / params.height,
			ratio = Math.min(ratioWidth, ratioHeight, maximumRatio);

		adIframe.style.marginTop = lightBoxHeaderHeight + 'px';
		adIframe.style.transform = 'scale(' + ratio + ')';
	}

	return {
		show: show
	};
});
