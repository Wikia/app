var SuggestModalWikiaHubsV2 = {
	init: function () {
		// show modal for suggest article
		$('#suggestArticle').click(function () {
			$().log(window.wgUserName);
			if (window.wgUserName) {
				SuggestModalWikiaHubsV2.suggestArticle();
			} else {
				if (window.wgComboAjaxLogin) {
					showComboAjaxForPlaceHolder(false, false, function () {
						AjaxLogin.doSuccess = function () {
							$('#AjaxLoginBoxWrapper').closest('.modalWrapper').closeModal();
							SuggestModalWikiaHubsV2.suggestArticle();
						};
						AjaxLogin.close = function () {
							$('#AjaxLoginBoxWrapper').closeModal();
						};
					}, false, true);
				} else {
					UserLoginModal.show({
						callback: function () {
							UserLogin.forceLoggedIn = true;
							SuggestModalWikiaHubsV2.suggestArticle();
						}
					});
				}
			}
		});
	},
	
	suggestArticle: function () {
		$.nirvana.sendRequest({
			controller: 'WikiaHubsV2SuggestController',
			method: 'suggestArticle',
			format: 'html',
			type: 'get',
			callback: function (html) {
				var modal = $(html).makeModal({width: 490, onClose: SuggestModalWikiaHubsV2.closeModal});
				var form = modal.find('form');
				var formView = modal.find('.form-view');
				var successView = modal.find('.success-view');

				// show submit button
				SuggestModalWikiaHubsV2.showSubmit(modal);

				form.submit(function (e) {
					e.preventDefault();
					var articleUrl = modal.find('input[name=articleurl]').val();
					var reason = modal.find('textarea[name=reason]').val();

					WikiaHubs.trackClick('get-promoted', Wikia.Tracker.ACTIONS.SUBMIT, 'suggest-article-submit', null, {
						lang: wgContentLanguage,
						user_name: window.wgUserName,
						article_url: articleUrl,
						reason: reason,
						page_title: window.wgPageName,
						vertical_id: window.wgWikiaHubsVerticalId
					}, e);

 					$().log('suggestArticle modal submit');
					formView.hide();
					successView.show();
				});
	
				modal.find('button.cancel').click(function (e) {
					e.preventDefault();
					SuggestModalWikiaHubsV2.closeModal(modal);
				});
			}
		});
	},

	showSubmit: function (modal) {
		$('.WikiaForm.WikiaHubs').keyup(function() {
			var empty = false;
			$('.WikiaForm.WikiaHubs .required').each(function () {
				if ($(this).find('input').val() == '' || $(this).find('textarea').val() == '') {
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
		UserLogin.refreshIfAfterForceLogin();
		if (typeof(modal.closeModal) === 'function') {
			modal.closeModal();
		}
	}
};

$(function () {
	SuggestModalWikiaHubsV2.init();
});