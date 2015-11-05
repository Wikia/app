/**
 * TemplateClassificationInEdit module
 *
 * Works for edit page.
 *
 * Provides selected type for TemplateClassificationModal,
 * handles type submit that is stored in hidden input in editform
 */
define('TemplateClassificationInEdit',
	['jquery', 'mw', 'wikia.tracker', 'TemplateClassificationModal'],
	function ($, mw, tracker, templateClassificationModal) {
		'use strict';

		var $editFormHiddenTypeFieldCurrent,
			$editFormHiddenTypeFieldNew;

		function init() {
			var $editform = $('#editform');
			$editFormHiddenTypeFieldCurrent = $editform.find('[name=templateClassificationTypeCurrent]');
			$editFormHiddenTypeFieldNew = $editform.find('[name=templateClassificationTypeNew]');

			templateClassificationModal.init(getType, storeTypeForSend);

			/* Force modal on load for new pages creation */
			if (isNewArticle() && !getType()) {
				templateClassificationModal.open('addTemplate');
			}

			$('.template-classification-edit').on('mousedown', function () {
				tracker.track({
					trackingMethod: 'analytics',
					category: 'template-classification-entry-point',
					action: tracker.ACTIONS.CLICK,
					label: 'edit-page'
				});
			});
		}

		function isNewArticle() {
			return mw.config.get('wgArticleId') === 0;
		}

		function getType() {
			/* Return in format required by TemplateClassificationModal module */
			return $editFormHiddenTypeFieldNew.val() ?
				$editFormHiddenTypeFieldNew.val() : $editFormHiddenTypeFieldCurrent.val();
		}

		function storeTypeForSend(templateType) {
			$editFormHiddenTypeFieldNew.val(mw.html.escape(templateType));
			templateClassificationModal.updateEntryPointLabel(templateType);
		}

		return {
			init: init,
			open: templateClassificationModal.open
		};
	}
);

require(['TemplateClassificationInEdit'], function (tc) {
	'use strict';
	$(tc.init);
});
