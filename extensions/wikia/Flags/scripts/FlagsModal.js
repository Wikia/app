require(['jquery'], function($) {
	'use strict';

	/* Modal component configuration */
	var modalConfig = {
		vars: {
			id: 'FlagsModal',
			classes: ['edit-flags'],
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
					'pageId': window.wgArticleId
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

		/* Setup toggle show of params fields on checkboxes change */
		hideFieldsets($flagsEditForm);
		toggleFieldsets($flagsEditForm);

		/* Submit flags edit form on Done button click */
		modalInstance.bind('done', function(){
			$flagsEditForm.trigger('submit');
		});

		/* Show the modal */
		modalInstance.show();
	}

	/**
	 * Hide fieldset tags that are siblings to unchecked checkboxes
	 * @param object $flagsEditForm jQuery object of form element
	 */
	function hideFieldsets($flagsEditForm) {
		function hide(event,element) {
			$(element).siblings('fieldset').hide();
		}
		$flagsEditForm.find('input[type=checkbox]:not(:checked)').each(hide);
	}

	/**
	 * Show and hide sibling fieldsets on checkbox change
	 * @param object $flagsEditForm jQuery object of form element
	 */
	function toggleFieldsets($flagsEditForm) {
		function toggle(event) {
			$(event.target).siblings('fieldset').toggle();
		}
		$flagsEditForm.find('input[type=checkbox]').click(toggle);
	}

	// Run initialization method on DOM ready
	$(init);
});
