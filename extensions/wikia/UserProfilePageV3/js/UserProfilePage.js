var UserProfilePage = {
	ajaxEntryPoint: '/wikia.php?controller=UserProfilePage&format=json',
	questions: [],
	currQuestionIndex: 0,
	modal: null,
	closingPopup: null,
	userId: null,
	wasDataChanged: false,
	userData: null,
	forceRedirect: false,
	isLightboxGenerating: false,
	
	init: function() {
		UserProfilePage.userId = $('#user').val();
		
		$('#UPPAnswerQuestions').click(function(event) {
			event.preventDefault();
			UserProfilePage.renderLightbox('interview');
		});
		
		$('#userIdentityBoxEdit').click(function(event) {
			event.preventDefault();
			UserProfilePage.renderLightbox('about');
		});
		
		$('#userAvatarEdit').click(function(event) {
			event.preventDefault();
			UserProfilePage.renderLightbox('avatar');
		});
		
		$('.masthead-info .wikis li').click(UserProfilePage.trackFavoriteWiki);
	},
	
	renderLightbox: function(tabName) {
		if( UserProfilePage.isLightboxGenerating === false ) {
		//if lightbox is generating we don't want to let user open second one
			UserProfilePage.isLightboxGenerating = true;
			
			UserProfilePage.track('edit/personal_data');
			
			$.getResources([$.getSassCommonURL('/extensions/wikia/UserProfilePageV3/css/UserProfilePage_modal.scss')]);
			
			$.postJSON( this.ajaxEntryPoint, { method: 'getLightboxData', tab: tabName, userId: UserProfilePage.userId, rand: Math.floor(Math.random()*100001) }, function(data) {
				UserProfilePage.modal = $(data.body).makeModal({width : 750, onClose: UserProfilePage.closeModal, closeOnBlackoutClick: UserProfilePage.closeModal});
				var modal = UserProfilePage.modal;
				
				UserProfilePage.renderAvatarLightbox(modal);
				UserProfilePage.renderAboutMeLightbox(modal);
				//UserProfilePage.renderInterviewLightbox(modal);
				
				var tab = modal.find('.tabs a');
				tab.click(function(event) {
					event.preventDefault();
					UserProfilePage.trackLightbox(event);
					UserProfilePage.switchTab($(this).closest('li'));
				});
				
				// Synthesize a click on the tab to hide/show the right panels
				$('[data-tab=' + tabName + '] a').click();
				
				if(typeof FB != 'undefined'){
					// parse FBXML login button
					FB.XFBML.parse();
				}
				
				UserProfilePage.isLightboxGenerating = false;
			}).error(function(data) {
				var response = JSON.parse(data.responseText);
				$.showModal('Error', response.exception.message);
				
				UserProfilePage.isLightboxGenerating = false;
			});
		}
	},
	
	switchTab: function(tab) {
		if( true === UserProfilePage.wasDataChanged ) {
			UserProfilePage.saveUserData(false);
			UserProfilePage.forceRedirect = true;
			UserProfilePage.wasDataChanged = false;
		}

		// Move 'selected' class to the right tab
		var tabs = tab.closest('ul');
		tabs.children('li').each(function(){
			$(this).removeClass('selected');
		});
		tab.addClass('selected');
		
		// Show correct tab content
		var tabName = tab.data('tab');
		$('.tab-content > li').each(function() {
			if( $(this).attr('class') === tabName ) {
				$(this).css('display', 'block');
			} else {
				$(this).css('display', 'none');
			}
		});		
	},
	
	renderAvatarLightbox: function(modal) {
		var avatarUploadInput = modal.find('#UPPLightboxAvatar'),
			avatarForm = modal.find('#usersAvatar');
		avatarUploadInput.change(function(e) {
			UserProfilePage.saveAvatarAIM(avatarForm);
		});
		
		modal.find('.modalToolbar .save').unbind('click').click(function(e) {
			UserProfilePage.track('edit/lightbox/save_personal_data');
			UserProfilePage.closeModal(modal);
			window.location = wgScript + '?title=' + wgPageName; //+ '&action=purge';
			e.preventDefault();
		});
		
		modal.find('.modalToolbar .cancel').unbind('click').click(function(e) {
			UserProfilePage.closeModal(modal);
			e.preventDefault();
		});
		
		var sampleAvatars = modal.find('.sample-avatars img');
		sampleAvatars.each(function(i, val){
			$(val).click(function() {
				UserProfilePage.sampleAvatarChecked(this);
			});
		});
	},
	
	saveAvatarData: function(avatarForm) {
		var file = $('#UPPLightboxAvatar').val();
		
		if( file !== '' ) {
			avatarForm.submit();
		}
	},
	
	sampleAvatarChecked: function(img) {
		UserProfilePage.modal.find('img.avatar').hide();
		UserProfilePage.modal.find('.avatar-loader').show();
		
		var image = $(img),
			userData = {file: image.attr('class'), source: 'sample'};
		
		$.ajax({
			type: 'POST',
			url: this.ajaxEntryPoint+'&method=saveUsersAvatar',
			dataType: 'json',
			data: 'userId=' + UserProfilePage.userId + '&data=' + $.toJSON(userData),
			success: function(data) {
				if( data.success === false ) {
					var errorBox = $(".UPPLightbox #errorBox").show().find('div');
					errorBox.empty();
					errorBox.append( data.errorMsg );
				} else {
					UserProfilePage.modal.find('.avatar-loader').hide();
					
					var avatarImg = UserProfilePage.modal.find('img.avatar');
					avatarImg.attr('src', data.result.avatar);
					avatarImg.show();
				}
			}
		});
	},
	
	saveAvatarAIM: function(form) {
		var inputs = $(form).find('button, input[type=file]');
		var handler = form.onsubmit;
		
		$.AIM.submit(form, {
			onStart: function() {
				UserProfilePage.modal.find('img.avatar').hide();
				UserProfilePage.modal.find('.avatar-loader').show();
			},
			onComplete: function(response) {
				try {
					response = JSON.parse(response);
					
					if( response.result.success === true ) {
						var avatarImg = UserProfilePage.modal.find('img.avatar');
						
						UserProfilePage.modal.find('.avatar-loader').hide();
						avatarImg.attr('src', response.result.avatar).show();
					} else {
						if( typeof(response.result.error) !== 'undefined' ) {
							var errorBox = $(".UPPLightbox #errorBox").show().find('div');
							errorBox.empty();
							errorBox.append( response.result.error );
						}
					}
					
					if( typeof(form[0]) !== 'undefined' ) {
						form[0].reset();
					}
				} catch(e) {
					$().log(e);
					
					form[0].reset();
				}
			}
		});
		
		//unbind original html element handler to avoid loops
		form.onsubmit = null;
		
		$(form).submit();
	},
	
	renderAboutMeLightbox: function(modal) {
		modal.find('.modalToolbar .save').unbind('click').click(function() {
			UserProfilePage.track('edit/lightbox/save_personal_data');
			UserProfilePage.saveUserData();
		});
		
		modal.find('.modalToolbar .cancel').unbind('click').click(function() {
			UserProfilePage.closeModal(modal);
		});
		
		var fbUnsyncButton = modal.find('#facebookUnsync');
		fbUnsyncButton.click(function() {
			UserProfilePage.removeFbProfileUrl();
		});
		
		var monthSelectBox = modal.find('#userBDayMonth'),
			daySelectBox = modal.find('#userBDayDay');
		
		monthSelectBox.change(function() {
			UserProfilePage.refillBDayDaySelectbox({month:monthSelectBox, day:daySelectBox});
		});

		$('.favorite-wikis .delete').live('click', function() {
			UserProfilePage.hideFavWiki($(this).closest('[data-wiki-id]').data('wiki-id'));
		});
		
		modal.find('.favorite-wikis-refresh').click(function(event) {
			event.preventDefault();			
			UserProfilePage.refreshFavWikis()
		});
		
		var formFields = modal.find('input[type="text"], select');
		formFields.change(function() {
			UserProfilePage.wasDataChanged = true;
		});
		
		UserProfilePage.toggleJoinMoreWikis();

		// Make 'feed preferences' link open in a new page		
		$('#facebookPage a').click(function(event) {
			event.preventDefault();
			window.open($(this).attr('href'));
		});
	},
	
	renderInterviewLightbox: function(modal) {

		modal.find('.modalToolbar .save').unbind('click').click(function() {
			UserProfilePage.storeCurrAnswer();
			UserProfilePage.saveInterviewAnswers();
		});
		
		modal.find('.modalToolbar .cancel').unbind('click').click(function() {
			UserProfilePage.closeModal(modal);
		});
		
		var nextButton = modal.find('#UPPLightboxNextQuestionBtn');
		var prevButton = modal.find('#UPPLightboxPrevQuestionBtn');
		
		nextButton.click(function() {
			UserProfilePage.storeCurrAnswer();
			UserProfilePage.currQuestionIndex++;
			UserProfilePage.renderCurrQuestion(nextButton, prevButton);
		});
		
		prevButton.click(function() {
			UserProfilePage.storeCurrAnswer();
			UserProfilePage.currQuestionIndex--;
			UserProfilePage.renderCurrQuestion(nextButton, prevButton);
		});
		
		//where does data come from?
		//UserProfilePage.questions = data.interviewQuestions;
		UserProfilePage.renderCurrQuestion(nextButton, prevButton);
	},
	
	storeCurrAnswer: function() {
		var currAnswerBody = UserProfilePage.modal.find('#UPPLightboxCurrQuestionAnswerBody').val();
		this.questions[this.currQuestionIndex].answerBody = currAnswerBody;
	},

	saveInterviewAnswers: function() {
		$.ajax({
			type: "POST",
			url: this.ajaxEntryPoint+'&method=saveInterviewAnswers',
			dataType: "json",
			data: "answers="+$.toJSON(this.questions),
			success: function(data) {
				if( data.status == "error" ) {
					var errorBox = $(".UPPLightbox #errorBox").show().find('div');
					errorBox.empty();
					errorBox.append( data.errorMsg );
				} else {
					UserProfilePage.closeModal(UserProfilePage.modal);
					window.location = wgScript + '?title=' + wgPageName; //+ '&action=purge'; 
				}
			}
		});
	},

	renderCurrQuestion: function(nextButton, prevButton) {
		var question = this.questions[this.currQuestionIndex];

		if( question != null ) {
			UserProfilePage.modal.find('#UPPLightboxCurrQuestionCaption').html(question.caption);
			UserProfilePage.modal.find('#UPPLightboxCurrQuestionBody').html(question.body);
			UserProfilePage.modal.find('#UPPLightboxCurrQuestionAnswerBody').val(question.answerBody);

			if(this.currQuestionIndex == 0) {
				prevButton.attr('disabled', 'disabled');
				//nextButton.attr('disabled', '');
			}
			else {
				prevButton.attr('disabled', '');
			}

			if(this.currQuestionIndex == (this.questions.length - 1)) {
				nextButton.attr('disabled', 'disabled');
			}
			else {
				nextButton.attr('disabled', '');
			}
		}
	},
	
	//updatePrevNextButtons
	
	saveUserData: function(doRedirect, modal) {
		if( typeof(doRedirect) === 'undefined' ) {
			doRedirect = true;
		}
		
		var userData = UserProfilePage.getFormData();
		
		$.ajax({
			type: 'POST',
			url: this.ajaxEntryPoint+'&method=saveUserData',
			dataType: 'json',
			data: 'userId=' + UserProfilePage.userId + '&data=' + $.toJSON(userData),
			success: function(data) {
				if( data.status == "error" ) {
					var errorBox = $(".UPPLightbox #errorBox").show().find('div');
					errorBox.empty();
					errorBox.append( data.errorMsg );
				} else {
					UserProfilePage.userData = null;
					
					if( true === doRedirect ) {
						if( typeof(modal) !== 'undefined' ) {
							UserProfilePage.closeModal(modal);
						} else {
							UserProfilePage.closeModal(UserProfilePage.modal);
						}
						
						window.location = wgScript + '?title=' + wgPageName; // + '&action=purge';
					}
				}
			}
		});
	},
	
	getFormData: function() {
		if( UserProfilePage.userData === null ) {
			$().log('userData from form');
			//array didn't want to go to php, so i changed it to an object --nAndy
			var userData = {
				name: null,
				location: null,
				occupation: null,
				gender: null,
				fbPage: null,
				website: null,
				twitter: null,
				year: null,
				month: null,
				day: null
			};
			
			for(var i in userData) {
				if( typeof($(document.userData[i]).val()) !== 'undefined' ) {
					userData[i] = $(document.userData[i]).val();
				}
			}
		} else {
			$().log('userData from instance property');
			var userData = UserProfilePage.userData;
		}
		
		return userData;
	},
	
	refillBDayDaySelectbox: function(selectboxes) {
		selectboxes.day.html("");
		var options = '',
			daysInMonth = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
			selectedMonth = selectboxes.month.val();
		
		for(var i = 1; i <= daysInMonth[selectedMonth - 1]; i++) {
			options += '<option value="'+ i + '">' + i + '</option>';
		}
		options = '<option value="0">--</option>' + options;
		
		selectboxes.day.html(options);
	},
	
	fbConnect: function() {
		$.postJSON( this.ajaxEntryPoint, { method: 'onFacebookConnect', cb: wgStyleVersion }, function(data) {
			if( data.result.success === true && typeof(data.result.fbUser) !== 'undefined' ) {
				var userData = {
					name: 'name',
					location: 'current_location',
					occupation: 'work_history',
					gender: 'sex',
					website: 'website',
					fbPage: 'profile_url',
					twitter: null,
					day: 'birthday_date'
				};
				
				for(var i in userData) {
					if( typeof($(document.userData[i]).val()) !== 'undefined' ) {
						var key = userData[i];
						
						UserProfilePage.fillFieldsWithFbData(i, key, data.result.fbUser);
					}
				}
				
				$('#facebookConnect').hide();
				$('#facebookPage').show();
			}
		});
	},
	
	fbConnectAvatar: function() {
		UserProfilePage.modal.find('img.avatar').hide();
		UserProfilePage.modal.find('.avatar-loader').show();
		
		$.postJSON( this.ajaxEntryPoint, { method: 'onFacebookConnect', avatar: true, cb: wgStyleVersion }, function(data) {
			if( data.result.success === true ) {
				$('#facebookConnectAvatar').hide();
				var avatarImg = UserProfilePage.modal.find('img.avatar');
				
				UserProfilePage.modal.find('.avatar-loader').hide();
				avatarImg.attr('src', data.result.avatar).show();
			}
		});
	},
	
	fillFieldsWithFbData: function(i, key, fbData) {
		if( typeof(fbData[key]) === 'string' ) {
			switch(key) {
				case 'birthday_date': 
					UserProfilePage.extractFbDateAndFill(fbData['birthday_date']);
					break;
				default: 
					$(document.userData[i]).val(fbData[key]);
					break;
			}
		}
	},
	
	extractFbDateAndFill: function(date) {
		if( typeof(date) === 'string' ) {
			var dateArray = date.split('/');
			
			var monthSelectBox = $('#userBDayMonth'),
				daySelectBox = $('#userBDayDay');
			
			monthSelectBox.val(dateArray[0]);
			
			UserProfilePage.refillBDayDaySelectbox({month:monthSelectBox, day:daySelectBox});
			
			daySelectBox.val(dateArray[1]);
		}
	},
	
	hideFavWiki: function(wikiId) {
		if( wikiId >= 0 ) {
			UserProfilePage.modal.find('.favorite-wikis [data-wiki-id="' + wikiId + '"]')
				.fadeOut('fast', function() {
					$(this).remove();				
					$.postJSON( UserProfilePage.ajaxEntryPoint, { method: 'onHideWiki', userId: UserProfilePage.userId, wikiId: wikiId, cb: wgStyleVersion }, function(data) {
						if( data.result.success === true ) {
							$().log(data);

							// add the next wiki
							$.each(data.result.wikis, function(index, value) {
								$().log(index);
								if(UserProfilePage.modal.find('.favorite-wikis [data-wiki-id="' + index + '"]').length == 0) {
									//found the wiki to add. now do it.
									$().log('adding');
									UserProfilePage.modal.find('.join-more-wikis').before('<li data-wiki-id="' + index + '"><span>' + value.wikiName + '</span> <img src="' + wgBlankImgUrl + '" class="sprite-small delete"></li>');
									
								}
							});
							UserProfilePage.toggleJoinMoreWikis();
						}
					});
				});
		} else {
			//failed to recive wikiId
		}
	},
	
	refreshFavWikis: function() {
		$.postJSON( this.ajaxEntryPoint, {method: 'onRefreshFavWikis', userId: UserProfilePage.userId, cb: wgStyleVersion}, function(data) {
			if( data.result.success === true ) {
				var favWikisList = UserProfilePage.modal.find('.favorite-wikis');

				// empty the list
				favWikisList.children().not('.join-more-wikis').remove();

				// add items
				for(i in data.result.wikis) {
					favWikisList.prepend('<li data-wiki-id="' + i + '"><span>' + data.result.wikis[i].wikiName + '</span> <img src="' + wgBlankImgUrl + '" class="sprite-small delete"></li>');
				}
		
				UserProfilePage.toggleJoinMoreWikis();				
			}
		});
	},
	
	toggleJoinMoreWikis: function() {
		var joinMoreWikis = UserProfilePage.modal.find('.join-more-wikis');
		if (UserProfilePage.modal.find('.favorite-wikis').children().not('.join-more-wikis').length == 4) {
			joinMoreWikis.hide();
		} else {
			joinMoreWikis.show();
		}
	},
	
	track: function(url) {
		$.tracker.byStr('profile/' + url);
	},
	
	trackLightbox: function(ev) {
		var node = $(ev.target), attr = node.attr('id');
		
		if( attr === 'about') {
			UserProfilePage.track('edit/lightbox/continue_1');
		} else if( attr === 'avatar' ) {
			UserProfilePage.track('edit/lightbox/continue_2');
		}
	},
	
	trackFavoriteWiki: function(ev) {
		UserProfilePage.track('top_wikis');
	},
	
	closeModal: function(modal, resetDataChangedFlag) {
		if( typeof(modal.closeModal) === 'function' ) {
			modal.closeModal();
		} else {
			if( UserProfilePage.wasDataChanged === true ) {
				UserProfilePage.userData = UserProfilePage.getFormData();
				UserProfilePage.displayClosingPopup();
				UserProfilePage.modal.hideModal();
				
				return false;
			}
		}
		
		if( typeof(resetDataChangedFlag) === 'undefined' || resetDataChangedFlag === true ) {
			//changing it for next lightbox openings
			UserProfilePage.wasDataChanged = false;
		}
		
		if( UserProfilePage.forceRedirect === true ) {
			window.location = wgScript + '?title=' + wgPageName; // + '&action=purge';
		}
	},
	
	displayClosingPopup: function() {
		$.postJSON( this.ajaxEntryPoint, { method: 'getClosingModal', userId: UserProfilePage.userId, rand: Math.floor(Math.random()*100001) }, function(data) {
			UserProfilePage.closingPopup = $(data.body).makeModal({width: 450, showCloseButton: false, closeOnBlackoutClick: false});
			
			var modal = UserProfilePage.closingPopup;
			var save = modal.find('.save');
			save.click(function() {
				UserProfilePage.saveUserData(true, modal);
			});
			
			var quit = modal.find('.quit');
			quit.click(function() {
				UserProfilePage.modal.closeModal();
				modal.closeModal();
			});
			
			var cancel = modal.find('.cancel');
			cancel.click(function() {
				modal.closeModal();
				UserProfilePage.modal.showModal();
			});
		});
	}
}

$(function() {
	UserProfilePage.init();
});