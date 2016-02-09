define(
	'ext.wikia.contentReview.module',
	['jquery', 'mw', 'wikia.loader', 'wikia.nirvana', 'wikia.window', 'BannerNotification'],
	function ($, mw, loader, nirvana, win, BannerNotification) {
		'use strict';

		function init() {
			$.when(loader({
				type: loader.MULTI,
				resources: {
					messages: 'ContentReviewModule'
				}
			})).done(function (res) {
				mw.messages.set(res.messages);
				bindEvents();
			});
		}

		function bindEvents() {
			$('.content-review-module-submit').on('click', submitPageForReview);
		}

		function submitPageForReview(event) {
			var notification,
				pageName = $(this).attr('data-page-name');

			event.preventDefault();

			nirvana.sendRequest({
				controller: 'ContentReviewApiController',
				method: 'submitPageForReview',
				data: {
					pageName: pageName,
					editToken: mw.user.tokens.get('editToken')
				},
				callback: function () {
					win.location.reload(true);
				},
				onErrorCallback: function (response) {
					var e, errorMsg;
					if (response.responseText.length > 0) {
						e = $.parseJSON(response.responseText);
						if (e.exception.details.length > 0) {
							errorMsg = e.exception.details;
						} else {
							errorMsg = e.exception.message;
						}
						notification = new BannerNotification(
							mw.message('content-review-module-submit-exception', errorMsg).escaped(),
							'error'
						);

						notification.show();
					}
				}
			});
		}

		return {
			init: init
		};
	}
);
