/*global define*/
define('ext.wikia.adEngine.template.modal', [
	'wikia.log',
	'wikia.iframeWriter',
	'wikia.ui.factory'
], function (log, iframeWriter, uiFactory) {
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
		log(['showNew', params], 'debug', logGroup);

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
				var iframe = iframeWriter.getIframe({
					code: params.code,
					height: params.height,
					width: params.width
				});

				modal.$content.append(iframe);
				modal.$element.width('auto');
				modal.show();
			});
		});
	}

	return {
		show: show
	};
});
