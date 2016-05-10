(function (window, $) {
	'use strict';

	var SuggestModalWikiaHubsV3 = {
		init: function () {
			// show modal for suggest article
			$('#suggestArticle').click(function () {

				if (window.wgUserName) {
					SuggestModalWikiaHubsV3.suggestArticle();
				} else {
					require(['AuthModal'], function (authModal) {
						authModal.load({
							forceLogin: true,
							url: '/signin?redirect=' + encodeURIComponent(window.location.href),
							origin: 'wikia-hubs',
							onAuthSuccess: function () {
								window.UserLogin.forceLoggedIn = true;
								SuggestModalWikiaHubsV3.suggestArticle();
							}
						});
					});
				}
			});
		},

		suggestArticle: function () {
			$('#suggestArticle').startThrobbing();

			$.nirvana.sendRequest({
				controller: 'WikiaHubsV3Controller',
				method: 'getArticleSuggestModal',
				format: 'json',
				type: 'get',
				data: {'rebuildmessages': true},
				callback: function (data) {
					SuggestModalWikiaHubsV3.openModal(data);
				},
				onErrorCallback: function() {
					$('#suggestArticle').stopThrobbing();
				}
			});
		},

		openModal: function (data) {
			require(['wikia.ui.factory', 'wikia.hubs'], function (uiFactory, wikiaHubs) {
				uiFactory.init(['modal']).then(function (uiModal) {
					var modalConfig = {
						vars: {
							id: 'suggestArticleDialogModal',
							classes: ['suggestArticleDialogModal'],
							size: 'small',
							title: data.title,
							content: data.html,
							buttons: [
								{
									vars: {
										value: data.labelSubmit,
										classes: ['normal', 'primary'],
										data: [
											{
												key: 'event',
												value: 'submit'
											}
										]
									}
								},
								{
									vars: {
										value: data.labelCancel,
										data: [
											{
												key: 'event',
												value: 'close'
											}
										]
									}
								}
							]
						}
					};

					uiModal.createComponent(modalConfig, function (suggestArticleModal) {
						var $modal = suggestArticleModal.$element,
							$articleurl = $modal.find('input[name=articleurl]'),
							$reason = $modal.find('textarea[name=reason]'),
							$submitButton = $modal.find('[data-event=submit]').attr('disabled', 'disabled'),
							$formView = $modal.find('.form-view'),
							$successView = $modal.find('.success-view');

						$modal.on('keyup keydown change', 'textarea[name=reason], input[name=articleurl]',
							function () {
								if (($articleurl.val().length === 0) || ($reason.val().length === 0)) {
									$submitButton.attr('disabled', 'disabled');
								} else {
									$submitButton.removeAttr('disabled');
								}
							});

						suggestArticleModal.bind('submit', function (event) {
							event.preventDefault();
							$submitButton.remove();
							$formView.addClass('hidden');
							$successView.removeClass('hidden');

							// send tracking
							/* jshint camelcase: false */
							wikiaHubs.trackClick(
								'get-promoted',
								Wikia.Tracker.ACTIONS.SUBMIT,
								'suggest-article-submit',
								null, {
									article_url: $articleurl.val(),
									reason: $reason.val(),
									vertical_id: window.wgWikiaHubsVerticalId
								},
								event);
							/* jshint camelcase: true */
						});

						$('#suggestArticle').stopThrobbing();
						suggestArticleModal.show();
					});
				});
			});
		}
	};

	$(function () {
		SuggestModalWikiaHubsV3.init();
	});

})(window, jQuery);
