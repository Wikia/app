define(
	'curatedContentTool.modal',
	['wikia.ui.factory', 'curatedContentTool.pontoBridge'],
	function (uiFactory, pontoBridge) {
		var modalInstance;

		function open(title, content) {
			uiFactory.init(['modal']).then(function (uiModal) {
				var modalConfig = {
					vars: {
						id: 'CuratedContentToolModal',
						classes: ['no-scroll'],
						size: 'medium',
						title: title,
						content: content
					}
				};

				uiModal.createComponent(modalConfig, function (_modal) {
					modalInstance = _modal;

					_modal.show();
					pontoBridge.init(_modal.$content.find('#CuratedContentToolIframe')[0]);
				});
			});
		}

		function close() {
			modalInstance.trigger('close');
		}

		return {
			close: close,
			open: open
		};
	}
);
