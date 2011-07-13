$(function() {
	UserProfilePage.init();
});

var UserProfilePage = {
	ajaxEntryPoint: '/wikia.php?controller=UserProfilePage&format=json',
	questions: [],
	currQuestionIndex: 0,
	modal: null,
	userId: null,
	wasDataChanged: false,
	
	init: function() {
		UserProfilePage.userId = $('#user').val();
		
		$('#UPPAnswerQuestions').click(function() {
			UserProfilePage.renderLightbox('interview');
		});
		
		$('#userIdentityBoxEdit').click(function() {
			UserProfilePage.renderLightbox('about');
		});
		
		$('#userAvatarEdit').click(function() {
			UserProfilePage.renderLightbox('avatar');
		});
	},
	
	renderLightbox: function(tabName) {
		UserProfilePage.track('edit/personal_data');
		
		$.postJSON( this.ajaxEntryPoint, { method: 'getLightboxData', tab: tabName, userId: UserProfilePage.userId, rand: Math.floor(Math.random()*100001) }, function(data) {
			UserProfilePage.modal = $(data.body).makeModal({ width : 450});
			var modal = UserProfilePage.modal;
			
			UserProfilePage.renderAvatarLightbox(modal);
			UserProfilePage.renderAboutMeLightbox(modal);
			//UserProfilePage.renderInterviewLightbox(modal);
			
			var tab = modal.find('.tab');
			tab.click(UserProfilePage.trackClick);
			tab.click(function() {
				UserProfilePage.switchTab($(this));
			});
			
			if(typeof FB != 'undefined'){
				// parse FBXML login button
				FB.XFBML.parse();
			}
			
		}).error(function(data) {
			var response = $.parseJSON(data.responseText);
			alert( 'Error! '+response.exception.message );
		});
	},
	
	switchTab: function(anchor) {
		if( true === UserProfilePage.wasDataChanged ) {
			UserProfilePage.saveUserData(false);
			UserProfilePage.wasDataChanged = false;
		}
		
		$('.tab').each(function(id, val){
			var tab = $(val);
			tab.removeClass('current');
		});
		
		anchor.addClass('current');
		
		var tabName = anchor.attr('id');
		$('.tabContent').each(function(id, val){
			var tab = $(val);
			if( tab.attr('id') === tabName ) {
				$(val).css('display', 'block');
			} else {
				$(val).css('display', 'none');
			}
		});
	},
	
	renderAvatarLightbox: function(modal) {
		var avatarUploadInput = modal.find('#UPPLightboxAvatar'),
			avatarForm = modal.find('#usersAvatar');
		avatarUploadInput.change(function(e) {
			UserProfilePage.saveAvatarAIM(avatarForm);
		});
		
		var saveButton = modal.find('#UPPLightboxAvatarSaveBtn');
		saveButton.click(function(e) {
			UserProfilePage.track('edit/lightbox/save_personal_data');
			UserProfilePage.closeModal(modal);
			window.location = wgScript + '?title=' + wgPageName; //+ '&action=purge';
			e.preventDefault();
		});
		
		var cancelButton = modal.find('#UPPLightboxAvatarCancelBtn');
		cancelButton.click(function(e) {
			UserProfilePage.closeModal(modal);
			e.preventDefault();
		});
		
		var sampleAvatars = modal.find('#UPPLightboxSampleAvatarsDiv li img');
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
		} else {
			
		}
	},
	
	sampleAvatarChecked: function(img) {
		UserProfilePage.clearBorders();
		
		UserProfilePage.modal.find('.avatar').hide();
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
					
					var avatarImg = UserProfilePage.modal.find('.avatar');
					avatarImg.attr('src', data.result.avatar);
					avatarImg.show();
				}
			}
		});
	},
	
	clearBorders: function() {
		var sampleAvatars = $('#UPPLightboxSampleAvatarsDiv li img');
		sampleAvatars.each(function(i, val){
			//later just class removing probably
			$(val).css('border', 'none');
		});
	},
	
	saveAvatarAIM: function(form) {
		var inputs = $(form).find('button, input[type=file]');
		var handler = form.onsubmit;
		
		$.AIM.submit(form, {
			onStart: function() {
				UserProfilePage.modal.find('.avatar').hide();
				UserProfilePage.modal.find('.avatar-loader').show();
			},
			onComplete: function(response) {
				try {
					response = $.parseJSON(response);
					
					if( response.result.success === true ) {
						var avatarImg = UserProfilePage.modal.find('.avatar');
						
						UserProfilePage.modal.find('.avatar-loader').hide();
						avatarImg.attr('src', response.result.avatar).show();
						
						UserProfilePage.clearBorders();
						//later just class adding probably
						avatarImg.css('border', '3px solid #008000');
					} else {
						$().log('Error.');
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
		var saveButton = modal.find('#UPPLightboxAboutMeSaveBtn');
		saveButton.click(function() {
			UserProfilePage.track('edit/lightbox/save_personal_data');
			UserProfilePage.saveUserData();
		});
		
		var cancelButton = modal.find('#UPPLightboxAboutMeCancelBtn');
		cancelButton.click(function() {
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
		
		var favWikiHide = modal.find('.favwiki');
		favWikiHide.click(function() {
			UserProfilePage.hideFavWiki(this.className);
		});
		
		var hiddenWikiRefresh = modal.find('.favwiki-refresh');
		hiddenWikiRefresh.click(function() {
			$(this).hide();
			UserProfilePage.refreshFavWikis();
		});
		
		var formFields = modal.find('input[type="text"], select');
		formFields.change(function() {
			UserProfilePage.wasDataChanged = true;
		});
	},
	
	renderInterviewLightbox: function(modal) {
		var saveButton = modal.find('#UPPLightboxInterviewSaveBtn');
		saveButton.click(function() {
			UserProfilePage.storeCurrAnswer();
			UserProfilePage.saveInterviewAnswers();
		});
		
		var cancelButton = modal.find('#UPPLightboxInterviewCancelBtn');
		cancelButton.click(function() {
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
		
		UserProfilePage.questions = data.interviewQuestions;
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
			UserProfilePage.modal.find('#UPPLightboxCurrQuestionBody').html(question.body)
			UserProfilePage.modal.find('#UPPLightboxCurrQuestionAnswerBody').val(question.answerBody)

			if(this.currQuestionIndex == 0) {
				prevButton.attr('disabled', 'disabled')
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
	
	saveUserData: function(doRedirect) {
		if( typeof(doRedirect) === 'undefined' ) {
			var doRedirect = true;
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
					if( true === doRedirect ) {
						UserProfilePage.closeModal(UserProfilePage.modal);
						window.location = wgScript + '?title=' + wgPageName; // + '&action=purge';
					}
				}
			}
		});
	},
	
	getFormData: function() {
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
		
		for(i in userData) {
			if( typeof($(document.userData[i]).val()) !== 'undefined' ) {
				userData[i] = $(document.userData[i]).val();
			}
		}
		
		return userData;
	},
	
	refillBDayDaySelectbox: function(selectboxes) {
		selectboxes.day.html("");
		var options = '',
			daysInMonth = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
			selectedMonth = selectboxes.month.val();
		
		for(i = 1; i <= daysInMonth[selectedMonth - 1]; i++) {
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
				
				for(i in userData) {
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
		UserProfilePage.modal.find('.avatar').hide();
		UserProfilePage.modal.find('.avatar-loader').show();
		
		$.postJSON( this.ajaxEntryPoint, { method: 'onFacebookConnect', avatar: true, cb: wgStyleVersion }, function(data) {
			if( data.result.success === true ) {
				$('#facebookConnectAvatar').hide();
				var avatarImg = UserProfilePage.modal.find('.avatar');
				
				UserProfilePage.modal.find('.avatar-loader').hide();
				avatarImg.attr('src', data.result.avatar).show();
				
				UserProfilePage.clearBorders();
				//later just class adding probably
				avatarImg.css('border', '3px solid #008000');
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
	
	hideFavWiki: function(className) {
		if( typeof(className) === 'string' ) {
			var wikiId = className.lastIndexOf('favWikiId-');
			
			if( wikiId >= 0 ) {
				wikiId = className.substr(wikiId + 10); //10 = length of 'favWikiId-'
				$.postJSON( this.ajaxEntryPoint, { method: 'onHideWiki', userId: UserProfilePage.userId, wikiId: wikiId, cb: wgStyleVersion }, function(data) {
					if( data.result.success === true ) {
						$().log(data);
					}
				});
			} else {
				//failed to recive wikiId
			}
		}
	},
	
	refreshFavWikis: function() {
		$.postJSON( this.ajaxEntryPoint, {method: 'onRefreshFavWikis', userId: UserProfilePage.userId, cb: wgStyleVersion}, function(data) {
			if( data.result.success === true ) {
				var favWikisList = UserProfilePage.modal.find('.favWikis');
				
				for(i in data.result.wikis) {
					favWikisList.append('<li>' + data.result.wikis[i].wikiName + '<a href="#" class="favwiki favWikiId-' + i + '">[x]</a></li>');
				}
				
				//"re-binding"
				var favWikiHide = UserProfilePage.modal.find('.favwiki');
				favWikiHide.click(function() {
					UserProfilePage.hideFavWiki(this.className);
				});
			}
		});
	},
	
	track: function(url) {
		$.tracker.byStr('profile/' + url);
	},
	
	trackClick: function(ev) {
		var node = $(ev.target), attr = node.attr('id');
		
		if( attr === 'about') {
			UserProfilePage.track('edit/lightbox/continue_1');
		} else if( attr === 'avatar' ) {
			UserProfilePage.track('edit/lightbox/continue_2');
		}
	},
	
	closeModal: function(modal, resetDataChangedFlag) {
		if( typeof(resetDataChangedFlag) === 'undefined' || resetDataChangedFlag === true ) {
			//changing it for next lightbox openings
			UserProfilePage.wasDataChanged = false;
		}
		
		modal.closeModal();
	}
}