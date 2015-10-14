require(['jquery', 'mw', 'wikia.loader', 'wikia.nirvana'], function ($, mw, loader, nirvana) {
	'use strict';

	var
		/* Modal component configuration */
		modalConfig = {
			vars: {
				id: 'TemplateClassificationEditModal',
				classes: ['template-classification-edit-modal'],
				size: 'medium', // size of the modal
				content: '', // content
				title: mw.message('template-classification-edit-modal-title').escaped()
			}
		},
		/* Modal buttons config for done and cancel buttons */
		modalButtons = [{
			vars: {
				value: mw.message('template-classification-edit-modal-save-button-text').escaped(),
				classes: ['normal', 'primary'],
				data: [
					{
						key: 'event',
						value: 'done'
					}
				]
			}
		},
		{
			vars: {
				value: mw.message('template-classification-edit-modal-cancel-button-text').escaped(),
				data: [
					{
						key: 'event',
						value: 'close'
					}
				]
			}
		}];

	modalConfig.vars.buttons = modalButtons;

	function init() {
		$('.template-classification-edit').click(function (e) {
			e.preventDefault();
				// TODO Mark current type
				modalConfig.vars.content = 'classificationForm';

				require(['wikia.ui.factory'], function (uiFactory) {
					/* Initialize the modal component */
					uiFactory.init(['modal']).then(createComponent);
				});
		});
	}

	/**
	 * Creates modal UI component
	 * One of sub-tasks for getting modal shown
	 */
	function createComponent(uiModal) {
		/* Create the wrapping JS Object using the modalConfig */
		uiModal.createComponent(modalConfig, processInstance);
	}

	/**
	 * CreateComponent callback that finally shows modal
	 * and binds submit action to Done button
	 * One of sub-tasks for getting modal shown
	 */
	function processInstance(modalInstance) {
		/* Submit template type edit form on Done button click */
		modalInstance.bind('done', function () {
			// TODO submit
		});

		/* Show the modal */
		modalInstance.show();
	}

	$(init);
});
