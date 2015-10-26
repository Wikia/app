/**
 * TemplateClassificationLabeling module
 *
 */
define('TemplateClassificationLabeling', ['jquery', 'mw', 'wikia.loader', 'wikia.nirvana'],
	function ($, mw) {
		'use strict';
		var mode = 'editType',
			prepareContentStrategy,
			getTitleStrategy;

		function init(modeParam) {
			if (modeParam === 'addTemplate') {
				mode = modeParam;
			} else {
				mode = 'editType';
			}
		}

		function getTitle() {
			return getTitleStrategy[mode]();
		}

		function prepareContent(content) {
			return prepareContentStrategy[mode](content);
		}

		prepareContentStrategy = {
			addTemplate: function PCSAddTemplate(content) {
				var $subtitle = $('<h2>').html(
					mw.message('template-classification-edit-modal-select-type-sub-title').escaped()
				);
				return $subtitle[0].outerHTML + content;
			},
			editType: function PCSEditType(content) {
				return content;
			}
		};

		getTitleStrategy = {
			addTemplate: function GTSAddTemplate() {
				return mw.message('template-classification-edit-modal-title-add-template').escaped();
			},
			editType: function GTSEditType() {
				return mw.message('template-classification-edit-modal-title-edit-type').escaped();
			}
		};

		return {
			init: init,
			getTitle: getTitle,
			prepareContent: prepareContent
		};
	}
);
