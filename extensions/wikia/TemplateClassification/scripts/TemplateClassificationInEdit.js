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

		var $editFormHiddenTypeField;

		function init() {
			$editFormHiddenTypeField = $('#editform').find('[name=templateClassificationType]');

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
			return $editFormHiddenTypeField.val();
		}

		function storeTypeForSend(templateType) {
			$editFormHiddenTypeField.val(mw.html.escape(templateType));
			templateClassificationModal.updateEntryPointLabel(templateType);
		}

		return {
			init: init,
			open: templateClassificationModal.open
		};
	}
);

(function () {
	'use strict';

	$(require('TemplateClassificationInEdit').init);
})();
