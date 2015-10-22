/**
 * TemplateClassificationModal module
 *
 * Initiates modal and opens it on entry point click
 * Provides two params in init method for handling save and providing selected type
 */
define('TemplateClassificationModal', ['jquery', 'mw', 'wikia.loader', 'wikia.nirvana'],
function ($, mw, loader, nirvana) {
	'use strict';

	var $classificationForm,
		modalConfig,
		messagesLoaded,
		saveHandler = falseFunction,
		typeGetter = falseFunction;

	/**
	 * @param {function} typeGetterProvided Method that should return type in json format,
	 *  	also can return a promise that will return type
	 *  	eg. return from typeGetterProvided [{type:'exampletype'}]
	 * @param {function} saveHandlerProvided Method that should handle modal save,
	 *  	receives {string} selectedType as parameter
	 */
	function init(typeGetterProvided, saveHandlerProvided) {
		saveHandler = saveHandlerProvided;
		typeGetter = typeGetterProvided;

		$('.template-classification-edit').click(function (e) {
			e.preventDefault();
			openEditModal();
		});
	}

	function openEditModal() {
		var messagesLoader = falseFunction,
			classificationFormLoader = falseFunction;

		if (!messagesLoaded) {
			messagesLoader = getMessages;
		}

		if (!$classificationForm) {
			classificationFormLoader = getTemplateClassificationEditForm;
		}

		// Fetch all data and open modal
		$.when(
			classificationFormLoader(),
			typeGetter(mw.config.get('wgArticleId')),
			messagesLoader()
		).done(handleRequestsForModal);
	}

	function getLabel(templateType) {
		var selectedTypeText;

		if (!$classificationForm) {
			return '';
		}

		selectedTypeText = $classificationForm.find(
			'label[for="template-classification-' + mw.html.escape(templateType) + '"]'
		);

		return selectedTypeText.html();
	}

	function handleRequestsForModal(classificationForm, templateType, loaderRes) {
		if (loaderRes) {
			mw.messages.set(loaderRes.messages);
			messagesLoaded = true;
		}

		if (classificationForm) {
			$classificationForm = $(classificationForm[0]);
		}

		if (templateType) {
			var selectedType = mw.html.escape(templateType[0].type);
			// Mark selected type
			$classificationForm.find('input[checked="checked"]').removeAttr('checked');
			$classificationForm.find('input[value="' + selectedType + '"]').attr('checked', 'checked');
		}

		// Set modal content
		setupTemplateClassificationModal($classificationForm[0].outerHTML);

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
		modalInstance.bind('done', function runSave() {
			processSave(modalInstance);
		});

		/* Show the modal */
		modalInstance.show();
	}

	function processSave(modalInstance) {
		var templateType = $('#TemplateClassificationEditForm').serializeArray()[0].value;

		saveHandler(templateType);

		// Update entry point label
		updateEntryPointLabel(templateType);

		modalInstance.trigger('close');
	}

	function updateEntryPointLabel(templateType) {
		var selectedTypeText = $classificationForm.find(
			'label[for="template-classification-' + mw.html.escape(templateType) + '"] .tc-type-name'
		);
		$('.template-classification-type-text').html(selectedTypeText.html());
	}

	function setupTemplateClassificationModal(content) {
		/* Modal component configuration */
		modalConfig = {
			vars: {
				id: 'TemplateClassificationEditModal',
				classes: ['template-classification-edit-modal'],
				size: 'small', // size of the modal
				content: content, // content
				title: mw.message('template-classification-edit-modal-title').escaped()
			}
		};

		var modalButtons = [
			{
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
			}
		];

		modalConfig.vars.buttons = modalButtons;
	}

	function getTemplateClassificationEditForm() {
		return nirvana.sendRequest({
			controller: 'TemplateClassification',
			method: 'getTemplateClassificationEditForm',
			type: 'get',
			format: 'html'
		});
	}

	function getMessages() {
		return loader({
			type: loader.MULTI,
			resources: {
				messages: 'TemplateClassificationModal'
			}
		});
	}

	function falseFunction() {
		return false;
	}

	return {
		init: init,
		getLabel: getLabel,
		open: openEditModal
	};
});
