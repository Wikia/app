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
		maximumRatio = 3; // don't scale the ad more than 3 times

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

			if (params.scalable) {
				log(['show scale the ad'], 'debug', logGroup);

				win.addEventListener('resize', function () {
					scaleAdIframeDesktop(adIframe, params);
				});
			}
		}

		if (skin === 'mercury') {
			log(['show mobile (Mercury) modal'], 'debug', logGroup);



			if (params.scalable) {
				log(['show scale the ad'], 'debug', logGroup);

				scaleAdIframe(adIframe, params);

				win.addEventListener('resize', adHelper.throttle(function () {
					scaleAdIframe(adIframe, params);
				}));
			}
			win.Mercury.Modules.Ads.getInstance().openLightbox(adIframe);
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
				scaleAdIframeDesktop(adIframe, params);
				modal.show();
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

		var border = 45;
		var ratioWidth = win.innerWidth / params.width;
		var ratioHeight = (win.innerHeight-border*2) / params.height;
		var ratio = Math.min(ratioWidth, ratioHeight, maximumRatio);

		adIframe.parentElement.style.padding = '0px';
		adIframe.parentElement.style.width = (params.width * ratio) + 'px';
		adIframe.parentElement.style.height = (params.height * ratio) + 'px';
		adIframe.style.display = 'block';
		adIframe.style.margin = '0 auto';
		adIframe.style.transform = 'scale(' + ratio + ')';
		adIframe.style.marginTop = (params.height) - (params.height / ratio) + 'px';
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
