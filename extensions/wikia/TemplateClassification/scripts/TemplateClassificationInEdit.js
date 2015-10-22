/**
 * TemplateClassificationInEdit module
 *
 * Works for edit page.
 *
 * Provides selected type for TemplateClassificationModal,
 * handles type submit that is stored in hidden innput in editrofm
 */
define('TemplateClassificationInEdit',
	['jquery', 'mw', 'TemplateClassificationModal'],
	function ($, mw, templateClassificationModal) {
		'use strict';

		var $editFromHiddenTypeFiled = $();

		function init() {
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
			var type;
			if ($editFromHiddenTypeFiled.length === 0){
				$editFromHiddenTypeFiled = $('#editform').find('[name=templateClassificationType]');
			}
			if ($editFromHiddenTypeFiled.length === 0) {
				type = '';
			} else {
				type = $editFromHiddenTypeFiled.attr('value');
			}
			/* Return in format required by TemplateClassificationModal module */
			return [{type:type}];
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
