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

		var selectedType;

		function init() {
			templateClassificationModal.init(getType, storeTypeForSend);
		}

		function getType(articleId) {
			if (selectedType) {
				return [{type:selectedType}];
			}

			return nirvana.sendRequest({
				controller: 'TemplateClassificationApi',
				method: 'getType',
				type: 'get',
				data: {
					'pageId': articleId
				}
			});
		}

		function storeTypeForSend(templateType) {
			var typeLabel;

			selectedType = mw.html.escape(templateType);

			// Update entry point label
			typeLabel = templateClassificationModal.getLabel(templateType);
			$('.template-classification-type-text').html(typeLabel);

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
