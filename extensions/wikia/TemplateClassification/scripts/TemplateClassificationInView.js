/**
 * TemplateClassificationInView module
 *
 * Works for view page.
 *
 * Provides selected type for TemplateClassificationModal and handles type submit
 */
define('TemplateClassificationInView', ['jquery', 'mw', 'wikia.nirvana', 'TemplateClassificationModal', 'BannerNotification'],
	function ($, mw, nirvana, templateClassificationModal, BannerNotification) {
		'use strict';

		var $typeLabel;

		function init() {
			$typeLabel = $('.template-classification-type-text');
			templateClassificationModal.init(getType, sendClassifyTemplateRequest);
		}

		function getType() {
			return [{type: $typeLabel.data('type')}];
		}

		function sendClassifyTemplateRequest() {
			nirvana.sendRequest({
				controller: 'TemplateClassificationApi',
				method: 'classifyTemplate',
				data: {
					pageId: mw.config.get('wgArticleId'),
					type: $('#TemplateClassificationEditForm [name="template-classification-types"]:checked').val(),
					editToken: mw.user.tokens.get('editToken')
				},
				callback: function() {
					var notification = new BannerNotification(
						mw.message('template-classification-edit-modal-success').escaped(),
						'success'
					);

					notification.show();
				},
				onErrorCallback: function() {
					var notification = new BannerNotification(
						mw.message('template-classification-edit-modal-error').escaped(),
						'error'
					);

					notification.show();
				}
			});
		}

		return {
			init: init
		};
	}
);

require(['TemplateClassificationInView'], function (tc) {
	'use strict';
	$(tc.init);
});
