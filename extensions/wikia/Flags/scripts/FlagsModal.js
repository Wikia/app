require(['jquery', 'wikia.loader', 'mw'], function ($, loader, mw) {
	'use strict';

	/* Modal buttons config for done and cancel buttons */
	var buttonsForFlagsExistingState = [{
		vars: {
			value: mw.message('flags-edit-modal-done-button-text').escaped(),
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
			value: mw.message('flags-edit-modal-cancel-button-text').escaped(),
			data: [
				{
					key: 'event',
					value: 'close'
				}
			]
		}
	}],

	/* Modal close button config*/
	buttonForEmptyState = [{
		vars: {
			value: mw.message('flags-edit-modal-close-button-text').escaped(),
			data: [
				{
					key: 'event',
					value: 'close'
				}
			]
		}
	}],

	/* Modal component configuration */
	modalConfig = {
		vars: {
			id: 'FlagsModal',
			classes: ['edit-flags'],
			size: 'medium', // size of the modal
			content: '', // content
			title: mw.message('flags-edit-modal-title').escaped()
		}
	};

	function init() {
		$('#ca-flags').on('click', showModal);
	}

	/**
	 * Function for showing modal.
	 * First function in showing modal process.
	 * Performs all necessary job to display modal with flags ready to edit
	 */
	function showModal(event) {
		event.preventDefault();
		loader({
			type: loader.MULTI,
			resources: {
				templates: [{
					controller: 'Flags',
					method: 'editForm',
					params: {
						'page_id': mw.config.get('wgArticleId')
					}
				}],
				styles: '/extensions/wikia/Flags/styles/EditFormModal.scss'
			}
		}).done(handlePackage);
	}

	/**
	 * Handles package provided by getMultiTypePackage from server.
	 * Loads received styles, adds content to modal and initializes modal component
	 * One of sub-tasks for getting modal shown
	 */
	function handlePackage(pkg) {
		/* Load styles */
		loader.processStyle(pkg.styles);

		/* Add content to modal */
		var template = Object.keys(pkg.templates)[0];

		modalConfig.vars.content = pkg.templates[template];

		require(['wikia.ui.factory'], function (uiFactory) {
			/* Initialize the modal component */
			uiFactory.init(['modal']).then(createComponent);
		});
	}

	/**
	 * Creates modal UI component
	 * One of sub-tasks for getting modal shown
	 */
	function createComponent(uiModal) {
		/* Look for existence of form tag to determine whether there are any flags on the wikia */
		if (modalConfig.vars.content.indexOf('<form') > -1) {
			modalConfig.vars.buttons = buttonsForFlagsExistingState;
		} else {
			modalConfig.vars.buttons = buttonForEmptyState;
		}
		/* Create the wrapping JS Object using the modalConfig */
		uiModal.createComponent(modalConfig, processInstance);
	}

	/**
	 * CreateComponent callback that finally shows modal
	 * and binds submit action to Done button
	 * One of sub-tasks for getting modal shown
	 */
	function processInstance(modalInstance) {
		var $flagsEditForm = modalInstance.$element.find('#flagsEditForm');
		if ($flagsEditForm.length > 0) {
			/* Submit flags edit form on Done button click */
			modalInstance.bind('done', function () {
				$flagsEditForm.trigger('submit');
			});
		}

		/* Show the modal */
		modalInstance.show();
	}

	// Run initialization method on DOM ready
	$(init);
});
