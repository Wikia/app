var SuggestModalWikiaHubsV2 = {
	init: function () {
		// show modal for suggest article
		$('#suggestArticle').click(function () {
			$().log(window.wgUserName);
			if (window.wgUserName) {
				SuggestModal.suggestArticle();
			} else {
				if (window.wgComboAjaxLogin) {
					showComboAjaxForPlaceHolder(false, false, function () {
						AjaxLogin.doSuccess = function () {
							$('#AjaxLoginBoxWrapper').closest('.modalWrapper').closeModal();
							SuggestModal.suggestArticle();
						};
						AjaxLogin.close = function () {
							$('#AjaxLoginBoxWrapper').closeModal();
						};
					}, false, true);
				} else {
					UserLoginModal.show({
						callback: function () {
							SuggestModal.suggestArticle();
						}
					});
				}
			}
		});
		// show modal for suggest related videos
		$('#suggest-popularvideos').click(function () {
			if (window.wgUserName) {
				SuggestModal.suggestVideo();
			} else {
				if (window.wgComboAjaxLogin) {
					showComboAjaxForPlaceHolder(false, false, function () {
						AjaxLogin.doSuccess = function () {
							$('#AjaxLoginBoxWrapper').closest('.modalWrapper').closeModal();
							SuggestModal.suggestVideo();
						};
						AjaxLogin.close = function () {
							$('#AjaxLoginBoxWrapper').closeModal();
						};
					}, false, true);
				} else {
					UserLoginModal.show({
						callback: function () {
							SuggestModal.suggestVideo();
						}
					});
				}
			}
		});
	},
	
	suggestArticle: function () {
		$.nirvana.sendRequest({
			controller: 'WikiaHubsSuggestController',
			method: 'modalArticle',
			format: 'html',
			type: 'get',
			callback: function (html) {
				var modal = $(html).makeModal({width: 490, onClose: SuggestModal.closeModal});
				var wikiaForm = new WikiaForm(modal.find('form'));
				
				// show submit button
				SuggestModal.showSubmit(modal);
				
				modal.find('button.submit').click(function (e) {
					e.preventDefault();
					var articleurl = modal.find('input[name=articleurl]').val();
					var reason = modal.find('textarea[name=reason]').val();
					$.nirvana.sendRequest({
						controller: 'WikiaHubsSuggestController',
						method: 'modalArticle',
						format: 'json',
						data: {
							hubname: window.wgPageName,
							articleurl: articleurl,
							reason: reason,
							submit: 1
						},
						callback: function (res) {
							if (res['result'] == 'ok') {
								modal.find('.WikiaForm').replaceWith('<p>' + res['msg'] + '</p>');
								modal.find('.close-button').show();
							} else if (res['result'] == 'error') {
								wikiaForm.clearInputError('articleurl');
								wikiaForm.clearInputError('reason');
								wikiaForm.showInputError(res['errParam'], res['msg']);
							} else {
								// TODO: show error message
								GlobalNotification.show('Something is wrong', 'error');
							}
						}
					});
				});
	
				modal.find('button.cancel').click(function (e) {
					e.preventDefault();
					SuggestModal.closeModal(modal);
				});
			}
		});
	},

	suggestVideo: function () {
		$.nirvana.sendRequest({
			controller: 'WikiaHubsSuggestController',
			method: 'modalRelatedVideos',
			format: 'html',
			type: 'get',
			callback: function (html) {
				var modal = $(html).makeModal({width: 490, onClose: SuggestModal.closeModal});
				var wikiaForm = new WikiaForm(modal.find('form'));
				
				modal.find('input[name=videourl], input[name=wikiname]').placeholder();
						
				// show submit button
				SuggestModal.showSubmit(modal);
	
				modal.find('button.submit').click(function (e) {
					e.preventDefault();
					var videourl = modal.find('input[name=videourl]').val();
					var wikiname = modal.find('input[name=wikiname]').val();
					$.nirvana.sendRequest({
						controller: 'WikiaHubsSuggestController',
						method: 'modalRelatedVideos',
						format: 'json',
						data: {
							hubname: window.wgPageName,
							videourl: videourl,
							wikiname: wikiname,
							submit: 1
						},
						callback: function (res) {
							if (res['result'] == 'ok') {
								modal.find('.WikiaForm').replaceWith('<p>' + res['msg'] + '</p>');
								modal.find('.close-button').show();
							} else if (res['result'] == 'error') {
								wikiaForm.clearInputError('videourl');
								wikiaForm.clearInputError('wikiname');
								wikiaForm.showInputError(res['errParam'], res['msg']);
							} else {
								// TODO: show error message
								GlobalNotification.show('Something is wrong', 'error');
							}
						}
					});
				});
	
				modal.find('button.cancel').click(function (e) {
					e.preventDefault();
					SuggestModal.closeModal(modal);
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
	$('#carouselContainer').carousel();
});
