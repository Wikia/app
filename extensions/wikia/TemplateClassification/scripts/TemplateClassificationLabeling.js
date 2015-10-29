/**
 * TemplateClassificationLabeling module
 *
 */
define('TemplateClassificationLabeling',
	['jquery', 'mw'],
	function ($, mw) {
		'use strict';

		var availableModes = [
				'editType',
				'addTemplate',
				'addTypeBeforePublish'
			],
			mode = 'editType',
			getTitleStrategy,
			prepareConfirmButtonStrategy,
			prepareContentStrategy;

		function init(modeParam) {
			if (availableModes.indexOf(modeParam) >= 0) {
				mode = modeParam;
			}
		}

		function getConfirmButtonLabel() {
			return prepareConfirmButtonStrategy[mode]();
		}

		function getTitle() {
			return getTitleStrategy[mode]();
		}

		function prepareContent(content) {
			return prepareContentStrategy[mode](content);
		}

		prepareConfirmButtonStrategy = (function prepareConfirmButtonStrategy() {
			function addTemplate() {
				return mw.message('template-classification-edit-modal-add-button-text').escaped();
			}

			function editType() {
				return mw.message('template-classification-edit-modal-save-button-text').escaped();
			}

			return {
				addTemplate: addTemplate,
				editType: editType,
				addTypeBeforePublish: editType
			};
		})();

		getTitleStrategy = (function getTitleStrategy() {
			function addTemplate() {
				return mw.message('template-classification-edit-modal-title-add-template').escaped();
			}

			function editType() {
				return mw.message('template-classification-edit-modal-title-edit-type').escaped();
			}

			function addTypeBeforePublish() {
				return mw.message('template-classification-edit-modal-select-type-sub-title').escaped();
			}

			return {
				addTemplate: addTemplate,
				editType: editType,
				addTypeBeforePublish: addTypeBeforePublish
			};
		})();

		prepareContentStrategy = (function prepareContentStrategy() {
			function addTemplate(content) {
				var $subtitle = $('<h2>').html(
					mw.message('template-classification-edit-modal-select-type-sub-title').escaped()
				);
				return $subtitle[0].outerHTML + content;
			}

			function editType(content) {
				return content;
			}

			return {
				addTemplate: addTemplate,
				editType: editType,
				addTypeBeforePublish: editType
			};
		})();

		return {
			init: init,
			getConfirmButtonLabel: getConfirmButtonLabel,
			getTitle: getTitle,
			prepareContent: prepareContent
		};
	}
);
