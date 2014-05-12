(function( window, $ ){
'use strict';

var SuggestModalWikiaHubsV3 = {
	init: function () {
		var UserLoginModal = window.UserLoginModal;

		// show modal for suggest article
		$('#suggestArticle').click(function () {
			$().log(window.wgUserName);
			if (window.wgUserName) {
				SuggestModalWikiaHubsV3.suggestArticle();
			} else {
				if (window.wgComboAjaxLogin) {
					window.showComboAjaxForPlaceHolder(false, false, function () {
						window.AjaxLogin.doSuccess = function () {
							$('#AjaxLoginBoxWrapper').closest('.modalWrapper').closeModal();
							SuggestModalWikiaHubsV3.suggestArticle();
						};
						window.AjaxLogin.close = function () {
							$('#AjaxLoginBoxWrapper').closeModal();
						};
					}, false, true);
				} else {
					UserLoginModal.show( {
						origin: 'wikia-hubs',
						callback: function () {
							window.UserLogin.forceLoggedIn = true;
							SuggestModalWikiaHubsV3.suggestArticle();
						}
					});
				}
			}
		});
	},
	
	suggestArticle: function () {
		$.nirvana.sendRequest({
			controller: 'WikiaHubsV3SuggestController',
			method: 'suggestArticle',
			format: 'html',
			type: 'get',
			callback: function (html) {
				var modal = $(html).makeModal({width: 490, onClose: SuggestModalWikiaHubsV3.closeModal}),
					form = modal.find('form'),
					formView = modal.find('.form-view'),
					successView = modal.find('.success-view');

				// show submit button
				SuggestModalWikiaHubsV3.showSubmit(modal);

				form.submit(function (e) {
					e.preventDefault();
					var articleUrl = modal.find('input[name=articleurl]').val(),
						reason = modal.find('textarea[name=reason]').val();

					window.WikiaHubs.trackClick(
						'get-promoted',
						Wikia.Tracker.ACTIONS.SUBMIT,
						'suggest-article-submit',
						null, {
							article_url: articleUrl,
							reason: reason,
							vertical_id: window.wgWikiaHubsVerticalId
						},
					e);

					$().log('suggestArticle modal submit');
					formView.hide();
					successView.show();
				});

				modal.find('button.cancel').click(function (e) {
					e.preventDefault();
					SuggestModalWikiaHubsV3.closeModal(modal);
				});
			}
		});
	},

	showSubmit: function (modal) {
		$('.WikiaForm.WikiaHubs').keyup(function() {
			var empty = false;
			$('.WikiaForm.WikiaHubs .required').each(function () {
				if ($(this).find('input').val() === '' || $(this).find('textarea').val() === '') {
					empty = true;
				}
			});
			if (!empty) {
				modal.find('button.submit').removeAttr('disabled');
			} else {
				modal.find('button.submit').attr('disabled', 'disabled');
			}
		});
	},

	closeModal: function (modal) {
		window.UserLogin.refreshIfAfterForceLogin();
		if (typeof(modal.closeModal) === 'function') {
			modal.closeModal();
		}
	}
};

	$(function () {
		SuggestModalWikiaHubsV3.init();
	});

})(this, jQuery);
