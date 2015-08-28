define(
	'curatedContentTool.modal',
	['wikia.ui.factory', 'curatedContentTool.pontoBridge'],
	function (uiFactory, pontoBridge) {
		'use strict';
		var modalInstance,
			closeModal;

		function open(title, content) {
			uiFactory.init(['modal']).then(function (uiModal) {
				var modalConfig = {
					vars: {
						id: 'CuratedContentToolModal',
						classes: ['no-scroll', 'curated-content-tool-modal'],
						size: 'medium',
						title: title,
						content: content
					},
					confirmCloseModal: function () {
						return closeModal || confirm("Are you sure you want to close this modal?");
					}
				};

				uiModal.createComponent(modalConfig, function (_modal) {
					closeModal = false;
					modalInstance = _modal;
					_modal.show();
					pontoBridge.init(_modal.$content.find('#CuratedContentToolIframe')[0]);
				});
			});
		}

		function close() {
			closeModal = true;
			modalInstance.trigger('close');
		}

		return {
			close: close,
			open: open
		};
	}
);
