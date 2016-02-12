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
			var $toolbar = $('.content-review-toolbar');
			$toolbar.on('click', '.content-review-status-button', removeCompletedAndUpdateLogs);
			$toolbar.on('click', '#content-review-escalate-button', escalateReview);
		}

		function removeCompletedAndUpdateLogs() {
			var	$button = $(this),
				$parent = $button.parent(),
				data = {
					wikiId: parseInt($parent.data('wiki-id')),
					pageId: parseInt($parent.data('page-id')),
					status: parseInt($button.data('status')),
					diff: diff,
					oldid: oldid,
					editToken: mw.user.tokens.get('editToken')
				};

			sendReviewModifyingRequest('removeCompletedAndUpdateLogs', data);
		}

		function escalateReview() {
			var	$parent = $(this).parent(),
				data = {
					wikiId: parseInt($parent.data('wiki-id')),
					pageId: parseInt($parent.data('page-id')),
					diff: diff,
					oldid: oldid,
					editToken: mw.user.tokens.get('editToken')
				};

			sendReviewModifyingRequest('escalateReview', data);
		}

		function sendReviewModifyingRequest(method, data) {
			var notification;

			$('.content-review-diff-button').prop('disabled',true);
			nirvana.sendRequest({
				controller: 'ContentReviewApiController',
				method: method,
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
