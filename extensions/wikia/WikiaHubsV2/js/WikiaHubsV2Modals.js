(function( window, $ ){
	'use strict';

	var SuggestModalWikiaHubsV2 = {
		init: function () {

			// show modal for suggest article
			$('#suggestArticle').click(function () {
				$().log(window.wgUserName);
				if (window.wgUserName) {
					SuggestModalWikiaHubsV2.suggestArticle();
				} else {
					window.UserLoginModal.show( {
						origin: 'wikia-hubs',
						callback: function () {
							UserLogin.forceLoggedIn = true;
							SuggestModalWikiaHubsV2.suggestArticle();
						}
					});
				}
			});
		},

		suggestArticle: function () {
			$.nirvana.sendRequest({
				controller: 'WikiaHubsV2Controller',
				method: 'getArticleSuggestModal',
				format: 'json',
				type: 'get',
				data: {'rebuildmessages': true},
				callback: function (data) {
					SuggestModalWikiaHubsV2.openModal(data);
				}
			});
		},

		openModal: function(data) {
			require(['wikia.ui.factory'], function (uiFactory) {
				uiFactory.init(['modal']).then(function (uiModal) {
					var modalConfig = {
						vars: {
							id: 'suggestArticleDialogModal',
							size: 'small',
							title: data.title,
							content: data.html,
							buttons: [{
								vars: {
									value: data.labelSubmit,
									classes: ['normal', 'primary'],
									data: [{
										key: 'event',
										value: 'submit'
									}]
								}
							}, {
								vars: {
									value: data.labelCancel,
									data: [{
										key: 'event',
										value: 'close'
									}]
								}
							}]
						}
					};

					uiModal.createComponent(modalConfig, function (suggestArticleModal) {
						var $modal = suggestArticleModal.$element,
							$articleurl = $modal.find('input[name=articleurl]'),
							$reason = $modal.find('textarea[name=reason]'),
							$submitButton = $modal.find('[data-event=submit]').attr('disabled', 'disabled'),
							$formView = $modal.find('.form-view'),
							$successView = $modal.find('.success-view');

						$modal.on('keyup keydown change', 'textarea[name=reason], input[name=articleurl]', function(e) {
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

							WikiaHubs.trackClick(
								'get-promoted',
								Wikia.Tracker.ACTIONS.SUBMIT,
								'suggest-article-submit',
								null, {
									article_url: $articleurl.val(),
									reason: $reason.val(),
									vertical_id: window.wgWikiaHubsVerticalId
								},
							e);

							$().log('suggestArticle modal submit');
						});

						suggestArticleModal.show();
					});
				});
			});
		}
	};

	$(function () {
		SuggestModalWikiaHubsV2.init();
	});

})(this, jQuery);
