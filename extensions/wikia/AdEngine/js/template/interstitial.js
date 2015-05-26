/*global define*/
define('ext.wikia.adEngine.template.interstitial', [
	'wikia.document',
	'wikia.log',
	'wikia.ui.factory',
	'wikia.window'
], function (doc, log, uiFactory, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.interstitial',
		modalId = 'ext-wikia-adEngine-template-interstitial',
		pollingInterval = 1000; // 1s

	/**
	 * Show the interstitial ad
	 *
	 * @deprecated use ext.wikia.adEngine.template.modal instead
	 *
	 * @param {Object} params
	 * @param {string} params.slot - ID of the slot to put into Lightbox
	 * @param {string} params.elem - selector of the element to pull from the GPT iframe
	 * @param {number} [params.width] - desired width of the Lightbox
	 */
	function show(params) {
		log(['show', params], 'debug', logGroup);

		var iframe = doc.getElementById(params.slot).querySelector('iframe'),
			iframeBody = iframe.contentWindow.document.body,
			selector = params.elem;

		function onFound(element) {
			var modalConfig = {
					vars: {
						id: modalId,
						size: 'medium',
						content: element.outerHTML,
						title: 'Advertisement',
						closeText: 'Close',
						buttons: []
					}
				};

			uiFactory.init('modal').then(function (uiModal) {
				uiModal.createComponent(modalConfig, function (modal) {
					var width = params.width || 'auto';
					modal.$element.width(width);
					modal.show();
				});
			});
		}

		function waitForElement() {
			var element = iframeBody.querySelector(selector);

			if (element) {
				onFound(element);
				return;
			}

			win.setTimeout(waitForElement, pollingInterval);
		}

		waitForElement();
	}

	return {
		show: show
	};
});
