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
				var wikiaForm = new WikiaForm(form);
				
				// show submit button
				SuggestModalWikiaHubsV2.showSubmit(modal);

				form.submit(function (e) {
					e.preventDefault();
					var articleUrl = modal.find('input[name=articleurl]').val();
					var reason = modal.find('textarea[name=reason]').val();

					Wikia.Tracker.track({
						action: Wikia.Tracker.ACTIONS.SUBMIT,
						browserEvent: e,
						category: 'SuggestArticle',
						label: 'suggestSubmit',
						trackingMethod: 'internal',
						value: null
					}, {
						lang: wgContentLanguage,
						userName: window.wgUserName,
						articleUrl: articleUrl,
						reason: reason,
						pageName: window.wgPageName
					});

					$().log('suggestArticle modal submit');
					SuggestModalWikiaHubsV2.closeModal(modal);
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
		require(['wikia.querystring'], function (qs){
			if (!window.wgUserName) {
				qs.addCb().goTo();
			} else if (typeof(modal.closeModal) === 'function') {
				modal.closeModal();
			}
		});
	}
};

$(function () {
	SuggestModalWikiaHubsV2.init();
});
