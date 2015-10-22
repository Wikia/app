/**
 * TemplateClassificationInEdit module
 *
 * Works for edit page.
 *
 * Provides selected type for TemplateClassificationModal,
 * handles type submit that is stored in hidden input in editform
 */
define('TemplateClassificationInEdit',
	['jquery', 'mw', 'TemplateClassificationModal'],
	function ($, mw, templateClassificationModal) {
		'use strict';

		var $editFromHiddenTypeFiled;

		function init() {
			$editFromHiddenTypeFiled = $('#editform').find('[name=templateClassificationType]');

			templateClassificationModal.init(getType, storeTypeForSend);

			/* Force modal on load for new pages creation */
			if (isNewArticle()) {
				open();
			}
		}

		function open() {
			templateClassificationModal.open();
		}

		function isNewArticle() {
			return mw.config.get('wgArticleId') === 0;
		}

		function getType() {
			/* Return in format required by TemplateClassificationModal module */
			return [{type: $editFromHiddenTypeFiled.attr('value')}];
		}

		function storeTypeForSend(templateType) {
			$editFromHiddenTypeFiled.attr('value', mw.html.escape(templateType));
		}

		return {
			init: init,
			open: open
		};
	}
);

require(['TemplateClassificationInEdit'], function (tc) {
	'use strict';
	$(tc.init);
});
