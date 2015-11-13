/**
 * TemplateClassificationModal module
 *
 * Initiates modal and opens it on entry point click
 * Provides two params in init method for handling save and providing selected type
 */
define('TemplateClassificationModal',
	['jquery', 'mw', 'wikia.loader', 'wikia.nirvana', 'wikia.tracker', 'TemplateClassificationLabeling'],
function ($, mw, loader, nirvana, tracker, labeling) {
	'use strict';

	var $classificationForm,
		$preselectedType,
		$typeLabel,
		modalConfig,
		messagesLoaded,
		saveHandler = falseFunction,
		typeGetter = falseFunction,
		track = tracker.buildTrackingFunction({
			category: 'template-classification-dialog',
			trackingMethod: 'analytics'
		});

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
		$typeLabel = $('.template-classification-type-text');

		$('.template-classification-edit').click(function (e) {
			e.preventDefault();
			openEditModal('editType');
		});
	}

	function openEditModal(modeProvided) {
		var messagesLoader = falseFunction,
			classificationFormLoader = falseFunction;

		labeling.init(modeProvided);

		if (!messagesLoaded) {
			messagesLoader = getMessages;
		}

		if (!$classificationForm) {
			classificationFormLoader = getTemplateClassificationEditForm;
		}

		// Fetch all data and open modal
		$.when(
			classificationFormLoader(),
			typeGetter(),
			messagesLoader()
		).done(handleRequestsForModal);
	}

	function getTypeMessage(templateType) {
		return mw.message('template-classification-type-' + mw.html.escape(templateType));
	}

	function handleRequestsForModal(classificationForm, templateType, loaderRes) {
		if (loaderRes) {
			mw.messages.set(loaderRes.messages);
			messagesLoaded = true;
		}

		if (classificationForm) {
			$classificationForm = $(classificationForm[0]);
		}

		if (!templateType) {
			templateType = 'unknown';
		}

		// Mark selected type
		$preselectedType = $classificationForm.find('input#template-classification-' + templateType);

		if (!!$preselectedType) {
			$classificationForm.find('input[checked="checked"]').removeAttr('checked');
			$preselectedType.attr('checked', 'checked').prop('autofocus', true);
		}

		// Set modal content
		setupTemplateClassificationModal(
			labeling.prepareContent($classificationForm[0].outerHTML)
		);

		require(['wikia.ui.factory'], function (uiFactory) {
			/* Initialize the modal component */
			uiFactory.init(['modal']).then(createComponent);

			// Track - open TC modal
			track({action: tracker.ACTIONS.OPEN});
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
		modalInstance.bind('done', function runSave(e) {
			processSave(modalInstance);

			// Track - primary-button click
			track({
				action: tracker.ACTIONS.CLICK_LINK_BUTTON,
				label: $(e.currentTarget).text()
			});
		});

		modalInstance.bind('close', function () {
			// Track - close TC modal
			track({
				action: tracker.ACTIONS.CLOSE,
				label: 'close-event'
			});
		});

		modalInstance.$element.find('input:radio').change(function trackRadioChange(e) {
			// Track - click to change a template's type
			track({
				action: tracker.ACTIONS.CLICK_LINK_TEXT,
				label: $(e.currentTarget).val()
			});
		});

		/* Show the modal */
		modalInstance.show();
	}

	function processSave(modalInstance) {
		var newTemplateType = $('#TemplateClassificationEditForm [name="template-classification-types"]:checked').val(),
			oldTemplateType = '';

		if (!!$preselectedType) {
			oldTemplateType = $preselectedType.val();
		}

		if (newTemplateType !== oldTemplateType) {
			// Track - modal saved with changes
			track({
				action: tracker.ACTIONS.SUBMIT,
				label: 'changed',
				value: newTemplateType
			});

			saveHandler(newTemplateType);
		} else {
			// Track - modal saved without changes
			track({
				action: tracker.ACTIONS.SUBMIT,
				label: 'nochange',
				value: oldTemplateType
			});
		}

		modalInstance.trigger('close');
	}

	function updateEntryPointLabel(templateType) {
		$typeLabel
			.data('type', mw.html.escape(templateType))
			.html(getTypeMessage(templateType).escaped());
	}

	function setupTemplateClassificationModal(content) {
		/* Modal component configuration */
		modalConfig = {
			vars: {
				id: 'TemplateClassificationEditModal',
				classes: ['template-classification-edit-modal'],
				size: 'small', // size of the modal
				content: content, // content
				title: labeling.getTitle()
			}
		};

		var modalButtons = [
			{
				vars: {
						value: labeling.getConfirmButtonLabel(),
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
				messages: 'TemplateClassificationModal,TemplateClassificationTypes'
			}
		});
	}

	function falseFunction() {
		return false;
	}

	return {
		init: init,
		open: openEditModal,
		updateEntryPointLabel: updateEntryPointLabel
	};
});
