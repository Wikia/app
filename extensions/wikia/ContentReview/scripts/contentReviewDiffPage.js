define(
	'ext.wikia.contentReview.diff.page',
	['BannerNotification', 'jquery', 'mw', 'wikia.loader', 'wikia.nirvana'],
	function (BannerNotification, $, mw, loader, nirvana) {
		'use strict';

		function init() {
			$.when(loader({
				type: loader.MULTI,
				resources: {
					messages: 'ContentReviewDiffPage'
				}
			})).done(function (res) {
				mw.messages.set(res.messages);
				bindEvents();
			});
		}

		function bindEvents() {
			$('.content-review-diff-button').on('click', removeCompletedAndUpdateLogs);
		}

		function removeCompletedAndUpdateLogs() {
			var $button = $(this),
				notification,
				data = {
					wikiId: $button.attr('data-wiki-id'),
					pageId: $button.attr('data-page-id'),
					status: $button.attr('data-status'),
					editToken: mw.user.tokens.get('editToken')
				};

			nirvana.sendRequest({
				controller: 'ContentReviewApiController',
				method: 'removeCompletedAndUpdateLogs',
				data: data,
				callback: function (response) {
					if (response.notification) {
						notification = new BannerNotification(
							response.notification,
							'confirm'
						);
						$('.content-review-diff-button').hide();

						notification.show();
					}
				},
				onErrorCallback: function () {
					notification = new BannerNotification(
						mw.message('content-review-diff-page-error').escaped(),
						'error'
					);
					notification.show();
				}
			});
		}

		return {
			init: init
		};
	});
