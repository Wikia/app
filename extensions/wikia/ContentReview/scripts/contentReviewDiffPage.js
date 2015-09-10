define(
	'ext.wikia.contentReview.diff.page',
	['BannerNotification', 'wikia.querystring', 'jquery', 'mw', 'wikia.loader', 'wikia.nirvana'],
	function (BannerNotification, Querystring, $, mw, loader, nirvana) {
		'use strict';
		var qs = new Querystring(),
			diff = qs.getVal('diff', null),
			oldid = qs.getVal('oldid', null);

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
			var	$button = $(this),
				notification,
				data = {
					wikiId: parseInt($button.attr('data-wiki-id')),
					pageId: parseInt($button.attr('data-page-id')),
					status: parseInt($button.attr('data-status')),
					diff: diff,
					oldid: oldid,
					editToken: mw.user.tokens.get('editToken')
				};

			$('.content-review-diff-button').prop('disabled',true);
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
						notification.show();
					}
				},
				onErrorCallback: function () {
					notification = new BannerNotification(
						mw.message('content-review-diff-page-error').escaped(),
						'error'
					);
					$('.content-review-diff-button').prop('disabled',false);
					notification.show();
				}
			});
		}

		return {
			init: init
		};
	});
