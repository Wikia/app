/*global define*/
define('ext.wikia.adEngine.template.modal', [
	'ext.wikia.adEngine.adContext',
	'wikia.log',
	'wikia.iframeWriter',
	'wikia.window',
	require.optional('wikia.ui.factory')
], function (adContext, log, iframeWriter, win, uiFactory) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.modal',
		modalId = 'ext-wikia-adEngine-template-modal';

	/**
	 * Show the modal ad
	 *
	 * @param {Object} params
	 * @param {string} params.code - code to put into Lightbox
	 * @param {number} params.width - desired width of the Lightbox
	 * @param {number} params.height - desired height of the Lightbox
	 */
	function show(params) {
		log(['show', params], 'debug', logGroup);
		var skin = adContext.getContext().targeting.skin;

		if (skin === 'oasis') {
			log(['showNew desktop modal'], 'debug', logGroup);
			createAndShowDesktopModal(params);
		}

		if (skin === 'mercury') {
			log(['showNew mobile (Mercury) modal'], 'debug', logGroup);
			win.Mercury.Modules.Ads.getInstance().openLightbox(createAdIframe(params));
		}
	}

	function createAndShowDesktopModal(params) {
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
				modal.$content.append(createAdIframe(params));
				modal.$element.width('auto');
				modal.show();
			});
		});
	}

	function createAdIframe(params) {
		return iframeWriter.getIframe({
			code: params.code,
			height: params.height,
			width: params.width,
			classes: ['wikia-ad-iframe']
		});
	}

	return {
		show: show
	};
});
