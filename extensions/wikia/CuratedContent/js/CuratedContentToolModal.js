define(
	'curatedContentTool.modal',
	['wikia.ui.factory', 'curatedContentTool.pontoBridge', 'JSMessages'],
	function (uiFactory, pontoBridge, msg) {
		'use strict';
		var modalInstance,
			closeWithoutConfirmation;

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
						return closeWithoutConfirmation ||
						confirm( msg('wikiacuratedcontent-close-modal-prompt-message') );
					}
				};

				uiModal.createComponent(modalConfig, function (_modal) {
					closeWithoutConfirmation = false;
					modalInstance = _modal;
					_modal.show();
					pontoBridge.init(_modal.$content.find('#CuratedContentToolIframe')[0]);
				});
			});
		}

		function close() {
			closeWithoutConfirmation = true;
			modalInstance.trigger('close');
		}

		return {
			close: close,
			open: open
		};
	}
);
