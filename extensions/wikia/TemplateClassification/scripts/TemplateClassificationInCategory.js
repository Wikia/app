/**
 * TemplateClassificationInView module
 *
 * Works for view page.
 *
 * Provides selected type for TemplateClassificationModal and handles type submit
 */
define('TemplateClassificationInCategory',
	['jquery', 'mw', 'wikia.nirvana', 'wikia.tracker', 'wikia.loader', 'wikia.cookies', 'TemplateClassificationModal', 'BannerNotification'],
	function ($, mw, nirvana, tracker, loader, cookies, templateClassificationModal, BannerNotification) {
		'use strict';

		function init() {
			templateClassificationModal.init(getType, sendClassifyTemplatesRequest, 'bulkEditType');

			$('.template-classification-type-text').on('mousedown', function () {
				tracker.track({
					trackingMethod: 'analytics',
					category: 'template-classification-entry-point',
					action: tracker.ACTIONS.CLICK,
					label: 'category-view-page'
				});
			});

			if (!cookies.get('tc-bulk') && mw.config.get('wgUserLanguage') === 'en') {
				showHint();
			}
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
				callback: function (response) {
					var message;

					if (response.notification) {
						message = response.notification;
					} else {
						message = mw.message('template-classification-edit-modal-success').escaped();
					}

					new BannerNotification(
						message,
						'confirm'
					).show();
				},
				onErrorCallback: function (response) {
					var errorMessage, e;

					if (response.responseText) {
						e = $.parseJSON(response.responseText);
						errorMessage = e.exception.message;
					} else {
						errorMessage = mw.message('template-classification-edit-modal-error').escaped();
					}

					new BannerNotification(errorMessage, 'error').show();
				}
			});
		}

		function showHint() {
			$.when(
				loader({
					type: loader.MULTI,
					resources: {
						messages: 'TemplateClassificationHints'
					}
				})
			).done(function (res) {
				var $hintTooltip;

				mw.messages.set(res.messages);

				$hintTooltip = $('#WikiaPageHeader').children('.wikia-menu-button')
					.tooltip({
						placement: 'in right',
						title: createHintMessage(),
						trigger: 'manual'
					});

				$hintTooltip.tooltip('show');

				$('body').on('click', '.close-bulk-hint', function () {
					$hintTooltip.tooltip('hide');
					cookies.set('tc-bulk', 1, { expires: 'never', domain: 'wikia.com' });
				});
			});
		}

		function createHintMessage() {
			var closeHint = '<br/><br/><div class="close-bulk-hint"><a href="#">'
				+ mw.message('template-classification-bulk-classification-agreement').escaped() + '</a></div>';

			return mw.message(
					'template-classification-bulk-classification-hint', mw.config.get('wgUserName')
				).parse() + closeHint;
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
