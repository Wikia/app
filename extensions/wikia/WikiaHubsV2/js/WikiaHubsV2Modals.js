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
		// show modal for suggest related videos
		$('#suggest-popularvideos').click(function () {
			if (window.wgUserName) {
				SuggestModalWikiaHubsV2.suggestVideo();
			} else {
				if (window.wgComboAjaxLogin) {
					showComboAjaxForPlaceHolder(false, false, function () {
						AjaxLogin.doSuccess = function () {
							$('#AjaxLoginBoxWrapper').closest('.modalWrapper').closeModal();
							SuggestModalWikiaHubsV2.suggestVideo();
						};
						AjaxLogin.close = function () {
							$('#AjaxLoginBoxWrapper').closeModal();
						};
					}, false, true);
				} else {
					UserLoginModal.show({
						callback: function () {
							SuggestModalWikiaHubsV2.suggestVideo();
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
				var wikiaForm = new WikiaForm(modal.find('form'));
				
				// show submit button
				SuggestModalWikiaHubsV2.showSubmit(modal);
				
				modal.find('button.submit').click(function (e) {
					e.preventDefault();
					var articleurl = modal.find('input[name=articleurl]').val();
					var reason = modal.find('textarea[name=reason]').val();
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

	suggestVideo: function () {
		$.nirvana.sendRequest({
			controller: 'WikiaHubsV2SuggestController',
			method: 'suggestVideo',
			format: 'html',
			type: 'get',
			callback: function (html) {
				var modal = $(html).makeModal({width: 490, onClose: SuggestModalWikiaHubsV2.closeModal});
				var wikiaForm = new WikiaForm(modal.find('form'));
				
				modal.find('input[name=videourl], input[name=wikiname]').placeholder();
						
				// show submit button
				SuggestModalWikiaHubsV2.showSubmit(modal);
	
				modal.find('button.submit').click(function (e) {
					e.preventDefault();
					var videourl = modal.find('input[name=videourl]').val();
					var wikiname = modal.find('input[name=wikiname]').val();
					$().log('suggestVideo modal submit');
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
	//todo: use QueryString made by Jakub Olek :)
		if (!window.wgUserName) {
			var searchstring = window.location.search || '';
			if (typeof searchstring === "undefined") {
				searchstring = '';
			}

			if (searchstring === '') {
				window.location = window.location + '?cb=' + Math.floor(Math.random() * 10000);
			} else if (searchstring.substr(0, 1) == '?') {
				window.location = window.location + '&cb=' + Math.floor(Math.random() * 10000);
			}
		} else if (typeof(modal.closeModal) === 'function') {
			modal.closeModal();
		}
	}

};

$(function () {
	SuggestModalWikiaHubsV2.init();
});
