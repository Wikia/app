require(['jquery'], function($) {
	'use strict';

	/* Modal component configuration */
	var modalConfig = {
		vars: {
			id: 'FlagsModal',
			size: 'small', // size of the modal
			content: '', // content
			title: 'Flags',
			buttons: [ // buttons in the footer
				{
					vars: {
						value: 'Done',
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
						value: 'Cancel',
						data: [
							{
								key: 'event',
								value: 'close'
							}
						]
					}
				}
			]
		}
	};

	function init() {
		$('#ca-flags').on('click', showModal);
	}

	/**
	 * Function for showing modal.
	 * First function in showing modal process.
	 * Performs all necessary job to display modal with flags ready to edit
	 * @param event
	 */
	function showModal(event) {
		event.preventDefault();
		Wikia.getMultiTypePackage({
			templates: [{
				controller: 'Flags',
				method: 'editForm',
				params: {
					'page_id': window.wgArticleId
				}
			}],
			styles: '/extensions/wikia/Flags/styles/Modal.scss',
			callback: handlePackage
		});
	}

	/**
	 * Handles package provided by getMultiTypePackage from server.
	 * Loads received styles, adds content to modal and initializes modal component
	 * One of sub-tasks for getting modal shown
	 * @param Object pkg
	 */
	function handlePackage(pkg) {
		/* Load styles */
		require(['wikia.loader'], function (loader) {
			loader.processStyle(pkg.styles);
		});

		/* Add content to modal */
		modalConfig.vars.content = pkg.templates.Flags_editForm;

		require(['wikia.ui.factory'], function (uiFactory) {
			/* Initialize the modal component */
			uiFactory.init(['modal']).then(createComponent);
		});
	}

	/**
	 * Creates modal UI component
	 * One of sub-tasks for getting modal shown
	 * @param uiModal
	 */
	function createComponent(uiModal) {
		/* Create the wrapping JS Object using the modalConfig */
		uiModal.createComponent(modalConfig, processInstance);
	}

	/**
	 * CreateComponent callback that finally shows modal
	 * and binds submit action to Done button
	 * One of sub-tasks for getting modal shown
	 * @param modalInstance
	 */
	function processInstance(modalInstance) {
		var $flagsEditForm = modalInstance.$element.find('#flagsEditForm');

		/* Submit flags edit form on Done button click */
		modalInstance.bind('done', function(){
			$flagsEditForm.trigger('submit');
		});

		/* Show the modal */
		modalInstance.show();
	}

	// Run initialization method on DOM ready
	$(init);
});
