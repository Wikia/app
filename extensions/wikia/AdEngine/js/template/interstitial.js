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
		modalPadding = 20,
		pollingInterval = 1000; // 1s

	function show(params) {
		log(['show', params], 'debug', logGroup);

		var iframe = doc.getElementById(params.slot).querySelector('iframe'),
			iframeBody = iframe.contentWindow.document.body,
			selector = params.elem;

		function onFound(element) {
			var modalConfig = {
					vars: {
						id: modalId,
						size: params.size || 'medium',
						content: element.outerHTML,
						title: 'Advertisement',
						closeText: 'Close',
						buttons: []
					}
				};

			uiFactory.init('modal').then(function (uiModal) {
				uiModal.createComponent(modalConfig, function (modal) {
					var width = params.width || modal.$content[0].querySelector(selector).clientWidth;
					modal.$element.width(width + 2 * modalPadding);
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
