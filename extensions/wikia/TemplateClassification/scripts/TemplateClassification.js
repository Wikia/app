require(['jquery', 'mw', 'wikia.loader', 'wikia.nirvana'],
function ($, mw, loader, nirvana) {
	'use strict';

	var $classificationForm,
		$editFromHiddenTypeFiled,
		modalConfig,
		selectedType;

	function init() {
		$('.template-classification-edit').click(function (e) {
			e.preventDefault();
			openEditModal();
		});
		if (isNewArticle()) {
			openEditModal();
		}
	}

	function openEditModal() {
		if (selectedType) {
			// All data in house, just open modal
			handleRequestsForModal(false, [{type:selectedType}], false);
			return true;
		}

		if (isNewArticle()) {
			// Open modal without type selected
			$.when(
				getTemplateClassificationEditForm(),
				false,
				getMessages()
			).done(handleRequestsForModal);
			return;
		}

		// Fetch all data and open modal
		$.when(
			getTemplateClassificationEditForm(),
			getTemplateType(mw.config.get('wgArticleId')),
			getMessages()
		).done(handleRequestsForModal);
	}

	function handleRequestsForModal(classificationForm, templateType, loaderRes) {
		if (loaderRes) {
			mw.messages.set(loaderRes.messages);
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
		modalInstance.bind('done', function () {
			var templateType = $('#TemplateClassificationEditForm').serializeArray()[0].value;
			selectedType = mw.html.escape(templateType);
			if (isNewArticle()) {
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

	function isNewArticle() {
		return mw.config.get('wgArticleId') === 0 && mw.config.get('wgTransactionContext').action === 'edit';
	}

	function storeTypeForSend(templateType) {
		if (!$editFromHiddenTypeFiled) {
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

	$(init);
});
