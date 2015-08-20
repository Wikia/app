define(
	'ext.wikia.contentReview.module',
	['jquery', 'mw', 'wikia.loader', 'wikia.nirvana', 'BannerNotification'],
	function($, mw, loader, nirvana, BannerNotification) {
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
			$('#content-review-module-submit').on('click', submitPageForReview);
		}

		function submitPageForReview(event) {
			event.preventDefault();

			var moduleType = $(this).data('type'),
				notification,
				data = {
				pageId: mw.config.get('wgArticleId'),
				wikiId: mw.config.get('wgCityId'),
				editToken: mw.user.tokens.get('editToken')
			};

			nirvana.sendRequest({
				controller: 'ContentReviewApiController',
				method: 'submitPageForReview',
				data: data,
				callback: function () {
					notification = new BannerNotification(
						/**
						 * The following message keys may be generated:
						 * content-review-module-submit-success-insert
						 * content-review-module-submit-success-update
						 */
						mw.message('content-review-module-submit-success-' + moduleType).escaped(),
						'confirm'
					);

					$('.content-review-module').hide();

					notification.show();
				},
				onErrorCallback: function(response) {
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
