/**
 * TemplateClassificationInView module
 *
 * Works for view page.
 *
 * Provides selected type for TemplateClassificationModal and handles type submit
 */
define('TemplateClassificationInCategory', ['jquery', 'mw', 'wikia.nirvana', 'wikia.tracker', 'TemplateClassificationModal', 'BannerNotification'],
	function ($, mw, nirvana, tracker, templateClassificationModal, BannerNotification) {
		'use strict';

		var $typeLabel;

		function init() {

			$typeLabel = $('.template-classification-type-text');
			templateClassificationModal.init(getType, sendClassifyTemplatesRequest, 'bulkEditType');

			$typeLabel.on('mousedown', function () {
				tracker.track({
					trackingMethod: 'analytics',
					category: 'template-classification-entry-point',
					action: tracker.ACTIONS.CLICK,
					label: 'category-view-page'
				});
			});
		}

		function getType() {
			return '';
		}

		function sendClassifyTemplatesRequest(selectedTemplateType) {
			nirvana.sendRequest({
				controller: 'TemplateClassification',
				method: 'classifyTemplateByCategory',
				data: {
					type: selectedTemplateType,
					category: mw.config.get('wgTitle'),
					editToken: mw.user.tokens.get('editToken')
				},
				callback: function () {
					var notification = new BannerNotification(
						mw.message('template-classification-edit-modal-success').escaped(),
						'confirm'
					);

					notification.show();
				},
				onErrorCallback: function (error) {
					var errorMessage, e;

					if (error.responseText.length) {
						e = $.parseJSON(error.responseText);
						errorMessage = e.exception.message;
					} else {
						errorMessage = mw.message('template-classification-edit-modal-error').escaped();
					}

					var notification = new BannerNotification(errorMessage, 'error');

					notification.show();
				}
			});
		}

		function animateOnError($element) {
			$element.addClass('template-classification-error');
			$element.one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function (e) {
				$element.removeClass('template-classification-error');
			});
		}

		return {
			init: init
		};
	}
);

require(['TemplateClassificationInCategory'], function (tc) {
	'use strict';
	$(tc.init);
});
