/*global define, require*/
define('ext.wikia.adEngine.template.modalOasisHandler', [
	require.optional('wikia.ui.factory')
], function (uiFactory) {
	'use strict';

	var oasisHandler = function () {
			this.modalId = 'ext-wikia-adEngine-template-modal';
		};

	oasisHandler.prototype.create = function (adContainer, modalVisible) {
		var modalConfig = {
			vars: {
				id: this.modalId,
				size: 'medium',
				content: '',
				title: 'Advertisement',
				closeText: 'Close',
				buttons: []
			}
		};

		uiFactory.init('modal').then((function (uiModal) {
			uiModal.createComponent(modalConfig, (function (modal) {
				this.modal = modal;
				modal.$content.append(adContainer);
				modal.$element.width('auto');
				if (modalVisible) {
					this.show();
				}
			}).bind(this));
		}).bind(this));
	};

	oasisHandler.prototype.show = function () {
		if (this.modal) {
			this.modal.show();
		}
	};

	oasisHandler.prototype.getExpansionModel = function () {
		return {
			availableHeightRatio: 0.8,
			availableWidthRatio: 0.9,
			heightSubtract: 90,
			minWidth: 200,
			minHeight: 150,
			maximumRatio: 2
		};
	};

	return oasisHandler;
});
