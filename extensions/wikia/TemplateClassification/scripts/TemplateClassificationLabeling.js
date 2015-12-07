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
				'addTypeBeforePublish',
				'bulkEditType'
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

			function addTypeBeforePublish() {
				return mw.message('savearticle').escaped();
			}

			return {
				addTemplate: addTemplate,
				editType: editType,
				addTypeBeforePublish: addTypeBeforePublish,
				bulkEditType: editType
			};
		})();

		getTitleStrategy = (function getTitleStrategy() {
			function editType() {
				return mw.message('template-classification-edit-modal-title-edit-type').escaped();
			}

			function chooseType() {
				return mw.message('template-classification-edit-modal-title-select-type').escaped();
			}

			function bulkEditType() {
				return mw.message('template-classification-edit-modal-title-bulk-types').escaped();
			}

			return {
				addTemplate: chooseType,
				editType: editType,
				addTypeBeforePublish: chooseType,
				bulkEditType: bulkEditType
			};
		})();

		prepareContentStrategy = (function prepareContentStrategy() {
			function editType(content) {
				var helpText = $('<p></p>').addClass('tc-instructions')
					.html(mw.message('template-classification-edit-modal-help').parse())[0].outerHTML;
				return addTargetBlankToLinks(helpText + content);
			}

			return {
				addTemplate: editType,
				editType: editType,
				addTypeBeforePublish: editType,
				bulkEditType: editType
			};
		})();

		/**
		 * Adds target="_blank" to all links in content
		 * @param {string} content
		 * @returns {string}
		 */
		function addTargetBlankToLinks(content) {
			var $c = $('<div>').html(content);
			$c.find('a').attr('target', '_blank');
			return $c.html();
		}

		return {
			init: init,
			getConfirmButtonLabel: getConfirmButtonLabel,
			getTitle: getTitle,
			prepareContent: prepareContent
		};
	}
);
