/**
 * TemplateClassificationModal module
 *
 * Initiates modal and opens it on entry point click
 * Provides two params in init method for handling save and providing selected type
 */
define('TemplateClassificationModal',
	['jquery', 'wikia.window', 'mw', 'wikia.loader', 'wikia.nirvana', 'wikia.tracker', 'wikia.throbber',
		'TemplateClassificationLabeling', require.optional('wikia.infoboxBuilder.templateClassificationHelper')],
function ($, w, mw, loader, nirvana, tracker, throbber, labeling, infoboxBuilderHelper) {
	'use strict';

	var $classificationForm,
		$saveBtn,
		$typeLabel,
		messagesLoaded,
		modalConfig,
		modalMode,
		newTypeModes = ['addTemplate', 'addTypeBeforePublish'],
		preselectedType,
		saveHandler = falseFunction,
		typeGetter = falseFunction,
		track = tracker.buildTrackingFunction({
			category: 'template-classification-dialog',
			trackingMethod: 'analytics'
		}),
		$w = $(w),
		$throbber = $('#tc-throbber'),
		forceClassificationModalMode = 'addTypeBeforePublish';

	/**
	 * @param {function} typeGetterProvided Method that should return type in json format,
	 *  	also can return a promise that will return type
	 *  	eg. return from typeGetterProvided [{type:'exampletype'}]
	 * @param {function} saveHandlerProvided Method that should handle modal save,
	 *  	receives {string} selectedType as parameter
	 */
	function init(typeGetterProvided, saveHandlerProvided, modeProvided) {
		var mode = modeProvided || 'editType';

		saveHandler = saveHandlerProvided;
		typeGetter = typeGetterProvided;
		$typeLabel = $('.template-classification-type-text');

		$typeLabel.click(function (e) {
			e.preventDefault();
			openEditModal(mode);
		});

		setupTooltip();
	}

	function openEditModal(modeProvided) {
		var messagesLoader = falseFunction,
			classificationFormLoader = falseFunction;

		modalMode = modeProvided;

		labeling.init(modalMode);

		if (!messagesLoaded) {
			messagesLoader = getMessages;
		}

		if (!$classificationForm) {
			classificationFormLoader = getTemplateClassificationEditForm;
		}

		throbber.show($throbber);

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

		preselectedType = templateType;

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
		var $preselectedTypeInput;

		/* Submit template type edit form on Done button click */
		modalInstance.bind('done', function runSave(e) {
			var label = e ? $(e.currentTarget).text() : 'keypress';

			processSave(modalInstance);

			// Track - primary-button click or save by pressing Enter key
			track({
				action: tracker.ACTIONS.CLICK_LINK_BUTTON,
				label: label
			});
		});

		modalInstance.bind('close', function () {
			$w.unbind('keypress', submitFormOnEnterKeyPress);

			// Track - close TC modal
			track({
				action: tracker.ACTIONS.CLOSE,
				label: 'close-event'
			});

			if (infoboxBuilderHelper) {
				infoboxBuilderHelper.showHiddenEditor();
			}
		});

		if (newTypeModes.indexOf(modalMode) >= 0) {
			$saveBtn = modalInstance.$element.find('footer button.primary').attr('disabled','disabled');
		}

		modalInstance.$element.find('input:radio').change(function handleRadioChange(e) {
			if (newTypeModes.indexOf(modalMode) >= 0) {
				$saveBtn.removeAttr('disabled');
			}
			// Track - click to change a template's type
			track({
				action: tracker.ACTIONS.CLICK_LINK_TEXT,
				label: $(e.currentTarget).val()
			});
		});

		$w.on('keypress', {modalInstance: modalInstance}, submitFormOnEnterKeyPress);

		/* Show the modal */
		modalInstance.show();

		throbber.remove($throbber);

		// Make sure that focus is in the right place but scroll the modal window to the top
		$preselectedTypeInput = modalInstance.$element.find('#template-classification-' + preselectedType);
		if ($preselectedTypeInput.length !== 0) {
			$classificationForm.find('input:checked').removeProp('checked');
			$preselectedTypeInput.prop('checked', true).focus();
		}

		if (preselectedType === 'unknown') {
			modalInstance.scroll(0);
		}
	}

	function processSave(modalInstance) {
		var newTemplateType = $('#TemplateClassificationEditForm [name="template-classification-types"]:checked').val();

		if (newTemplateType !== preselectedType) {
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
				value: preselectedType
			});
		}

		if (modalMode === forceClassificationModalMode && newTemplateType) {
			$('#wpSave').click();
		} else if (
			infoboxBuilderHelper &&
			infoboxBuilderHelper.shouldRedirectToInfoboxBuilder(newTemplateType, modalMode)
		) {
			throbber.show(modalInstance.$content);
			infoboxBuilderHelper.redirectToInfoboxBuilder();
		} else {
			modalInstance.trigger('close');
		}
	}

	function updateEntryPointLabel(templateType) {
		$typeLabel
			.data('type', mw.html.escape(templateType))
			.children('.template-classification-type-label')
			.html(getTypeMessage(templateType).escaped());
	}

	function setupTemplateClassificationModal(content) {
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

		/* Modal component configuration */
		modalConfig = {
			vars: {
				id: 'TemplateClassificationEditModal',
				classes: ['template-classification-edit-modal'],
				size: 'medium', // size of the modal
				content: content, // content
				title: labeling.getTitle()
			}
		};

		modalConfig.vars.buttons = modalButtons;
	}

	function setupTooltip() {
		$('.template-classification-type-wrapper').tooltip({
			delay: {show: 500, hide: 300}
		});
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

	function submitFormOnEnterKeyPress(e) {
		var keyCode = e.keyCode ? e.keyCode : e.which;

		// On Enter key press
		if (keyCode === 13) {
			e.preventDefault();
			e.data.modalInstance.trigger('done');
		}
	}

	return {
		init: init,
		open: openEditModal,
		updateEntryPointLabel: updateEntryPointLabel
	};
});
