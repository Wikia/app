/**
 * Extension provides a method to force TemplateClassification
 * if templateClassificationType hidden field in #editform is not filled
 */
define('TemplateClassificationModalForce',
	['jquery'],
	function ($) {
		'use strict';
		function forceType() {
			var $typeField = $('#editform').find('input[name=templateClassificationType]');

			if ($typeField.length > 0) {
				if ($typeField.val() !== '') {
					// Type defined. Force is not required
					return false;
				}
			}
			// Type not defined force modal
			require('TemplateClassificationInEdit').open('addTypeBeforePublish');

			// Break article submit
			return true;
		}
		return {
			forceType: forceType
		};
	}
);
