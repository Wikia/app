/**
 * TemplateClassificationInView module
 *
 * Works for view page.
 *
 * Provides selected type for TemplateClassificationModal and handles type submit
 */
define('TemplateClassificationInView', ['jquery', 'mw', 'wikia.nirvana', 'TemplateClassificationModal'],
	function ($, mw, nirvana, templateClassificationModal) {
		'use strict';

		var $typeLabel;

		function init() {
			$typeLabel = $('.template-classification-type-text');
			templateClassificationModal.init(getType, storeTypeForSend);
		}

		function getType() {
			return [{type: $typeLabel.data('type')}];
		}

		function storeTypeForSend() {
			nirvana.sendRequest({
				controller: 'TemplateClassificationApi',
				method: 'classifyTemplate',
				data: {
					pageId: mw.config.get('wgArticleId'),
					type: $('#TemplateClassificationEditForm').serializeArray()[0].value,
					editToken: mw.user.tokens.get('editToken')
				}
			});
		}

		return {
			init: init,
			open: open
		};
	}
);

require(['TemplateClassificationInView'], function (tc) {
	'use strict';
	$(tc.init);
});
