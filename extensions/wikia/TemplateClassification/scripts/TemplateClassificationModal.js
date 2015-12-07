/**
 * TemplateClassificationModal module
 *
 * Initiates modal and opens it on entry point click
 * Provides two params in init method for handling save and providing selected type
 */
define('TemplateClassificationModal',
	['jquery', 'wikia.window', 'mw', 'wikia.loader', 'wikia.nirvana', 'wikia.tracker', 'wikia.throbber',
		'TemplateClassificationLabeling'],
function ($, w, mw, loader, nirvana, tracker, throbber, labeling) {
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
		}),
		$w = $(w),
		$throbber = $('#tc-throbber');

	/**
	 * @param {function} typeGetterProvided Method that should return type in json format,
	 *  	also can return a promise that will return type
	 *  	eg. return from typeGetterProvided [{type:'exampletype'}]
	 * @param {function} saveHandlerProvided Method that should handle modal save,
	 *  	receives {string} selectedType as parameter
	 */
	function init(typeGetterProvided, saveHandlerProvided, mode) {
		var mode = mode || 'editType';

		saveHandler = saveHandlerProvided;
		typeGetter = typeGetterProvided;
		$typeLabel = $('.template-classification-type-text');

		$w.on('keydown', openModalKeyboardShortcut);

		$typeLabel.click(function (e) {
			e.preventDefault();
			openEditModal(mode);
		});
	}

	function openEditModal(modeProvided) {
		var messagesLoader = falseFunction,
			classificationFormLoader = falseFunction;

		// Unbind modal opening keyboard shortcut while it's open
		$w.unbind('keydown', openModalKeyboardShortcut);

		labeling.init(modeProvided);

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

		// Mark selected type
		$preselectedType = $classificationForm.find('#template-classification-' + templateType);

		if ($preselectedType.length !== 0) {
			$classificationForm.find('input[checked="checked"]').removeAttr('checked');
			$preselectedType.attr('checked', 'checked');
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

			// Re-bind modal opening keyboard shortcut
			$w.on('keydown', openModalKeyboardShortcut);

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

		$w.on('keypress', {modalInstance: modalInstance}, submitFormOnEnterKeyPress);

		/* Show the modal */
		modalInstance.show();

		throbber.remove($throbber);

		// Make sure that focus is in the right place
		$('#template-classification-' + mw.html.escape($preselectedType.val())).focus();
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
			.children('.template-classification-type-label')
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

	function openModalKeyboardShortcut(e) {
		var keyCode = e.keyCode ? e.keyCode : e.which;

		// Shortcut - Shift + Action Key (Ctrl or Cmd) + K
		if (e.shiftKey && (e.ctrlKey || e.metaKey) && keyCode === 75) {
			e.preventDefault();
			openEditModal('editType');
		}
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
