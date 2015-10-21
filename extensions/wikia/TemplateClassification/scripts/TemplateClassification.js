define('TemplateClassification', ['jquery', 'mw', 'wikia.loader', 'wikia.nirvana'],
function ($, mw, loader, nirvana) {
	'use strict';

	var $classificationForm,
		$editFromHiddenTypeFiled = $(),
		modalConfig,
		selectedType,
		messagesLoaded;

	function init() {
		$('.template-classification-edit').click(function (e) {
			e.preventDefault();
			openEditModal();
		});

		/* Force modal on load for new pages creation */
		if (isNewArticle() && isEditPage()) {
			openEditModal();
		}
	}

	function openEditModal() {
		var messagesLoader = falseFunction,
			classificationFormLoader = falseFunction,
			typeLoader = getTemplateType;

		if (!messagesLoaded) {
			messagesLoader = getMessages;
		}

		if (!$classificationForm) {
			classificationFormLoader = getTemplateClassificationEditForm;
		}

		if (isEditPage()) {
			selectedType = getType();
		}

		if (selectedType) {
			typeLoader = function () {return [{type:selectedType}];};
		}

		if (isNewArticle() && !selectedType) {
			typeLoader = falseFunction;
		}

		// Fetch all data and open modal
		$.when(
			classificationFormLoader(),
			typeLoader(mw.config.get('wgArticleId')),
			messagesLoader()
		).done(handleRequestsForModal);
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
			selectedType = mw.html.escape(templateType[0].type);
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
		//modalInstance = instance;
		/* Submit template type edit form on Done button click */
		modalInstance.bind('done', function processSave() {
			var selectedTypeText,
				templateType = $('#TemplateClassificationEditForm').serializeArray()[0].value;

			selectedType = mw.html.escape(templateType);

			// Update entry point label
			selectedTypeText = $classificationForm.find('label[for="template-classification-' + selectedType + '"]');
			$('.template-classification-type-text').html(selectedTypeText.html());

			// Don't send save request when on edit page
			if (isEditPage()) {
				storeTypeForSend(templateType);
			} else {
				nirvana.sendRequest({
					controller: 'TemplateClassificationMockApi',
					method: 'setTemplateType',
					data: {
						'articleId': mw.config.get('wgArticleId'),
						'templateType': templateType
					}
				});
			}
			modalInstance.trigger('close');
		});

		/* Show the modal */
		modalInstance.show();
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

	function getTemplateType(articleId) {
		return nirvana.sendRequest({
			controller: 'TemplateClassificationMockApi',
			method: 'getTemplateType',
			type: 'get',
			data: {
				'articleId': articleId
			}
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

	function isEditPage() {
		return mw.config.get('wgTransactionContext').action === 'edit';
	}

	function isNewArticle() {
		return mw.config.get('wgArticleId') === 0 && isEditPage();
	}

	function storeTypeForSend(templateType) {
		if ($editFromHiddenTypeFiled.length === 0) {
			$editFromHiddenTypeFiled = $('<input>').attr({
				'type': 'hidden',
				'name': 'templateClassificationType',
				'value': mw.html.escape(templateType)
			});
			$('#editform').append($editFromHiddenTypeFiled);
		} else {
			$editFromHiddenTypeFiled.attr('value', mw.html.escape(templateType));
		}
	}

	function getType() {
		if ($editFromHiddenTypeFiled.length === 0){
			$editFromHiddenTypeFiled = $('#editform').find('[name=templateClassificationType]');
		}
		if ($editFromHiddenTypeFiled.length === 0) {
			return '';
		}
		return $editFromHiddenTypeFiled.attr('value');
	}

	function falseFunction() {
		return false;
	}

	return {
		init: init,
		open: openEditModal
	};
});

require([],function () {
	'use strict';
	require(['TemplateClassification'],function (tc) {
		$(tc.init);
	});
});
