/**
 * Extension provides a method to force TemplateClassification
 * if both New and Current templateClassificationType hidden fields in #editform are not filled
 */
define('TemplateClassificationModalForce',
	['jquery'],
	function ($) {
		'use strict';
		function forceType() {
			var $editform = $('#editform'),
				$typeFieldCurrent = $editform.find('input[name=templateClassificationTypeCurrent]'),
				$typeFieldNew = $editform.find('input[name=templateClassificationTypeNew]');

			if ((!!$typeFieldCurrent && $typeFieldCurrent.val() !== '') ||
				(!!$typeFieldNew && $typeFieldNew.val() !== '')) {
					// Type defined. Force is not required
					return false;
			}
			// Type not defined force modal
			require(['TemplateClassificationInEdit'], function forceTemplateClassificationModal(tc) {
				tc.open('addTypeBeforePublish');
			});
			// Break article submit
			return true;
		}
		return {
			forceType: forceType
		};
	}
);
