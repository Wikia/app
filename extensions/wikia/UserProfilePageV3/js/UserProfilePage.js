var UserProfilePage = {
	// TODO: use $.nirvana.getJSON instead
	ajaxEntryPoint: '/wikia.php?controller=UserProfilePage&format=json',
	questions: [],
	currQuestionIndex: 0,
	modal: null,
	newAvatar: false,
	closingPopup: null,
	userId: null,
	wasDataChanged: false,
	forceRedirect: false,
	reloadUrl: false,

	init: function() {
		UserProfilePage.userId = $('#user').val();
		UserProfilePage.reloadUrl = $('#reloadUrl').val();

		if( UserProfilePage.reloadUrl == '' || UserProfilePage.reloadUrl === false ) {
			UserProfilePage.reloadUrl = wgScript + '?title=' + wgPageName; //+ '&action=purge';
		}

		$('#UPPAnswerQuestions').click(function(event) {
			event.preventDefault();
			UserProfilePage.renderLightbox('interview');
		});

		$('#userIdentityBoxEdit').click(function(event) {
			event.preventDefault();
			UserProfilePage.renderLightbox('about');
		});

		$('#UserAvatarRemove').click(function(event) {
			event.preventDefault();
			UserProfilePage.removeAvatar($(event.target).attr('data-name'), $(event.target).attr('data-confirm'));
		});

		$('#userAvatarEdit').click(function(event) {
			event.preventDefault();
			UserProfilePage.renderLightbox('avatar');
		});

		// for touch devices (without hover state) make sure that Edit is always
		// visible
		if ( $().isTouchscreen() ) {
			$('#userIdentityBoxEdit').show();
		}
	},

	renderLightbox: function(tabName) {
		if( !UserProfilePage.isLightboxGenerating ) {
			//if lightbox is generating we don't want to let user open second one
			UserProfilePage.isLightboxGenerating = true;
			UserProfilePage.newAvatar = false;

			$.getResources([$.getSassCommonURL('/extensions/wikia/UserProfilePageV3/css/UserProfilePage_modal.scss')]);

			$.getJSON(this.ajaxEntryPoint, {
				method: 'getLightboxData',
				tab: tabName,
				userId: UserProfilePage.userId,
				rand: Math.floor(Math.random()*100001) // is cache buster really needed here?
			}, function(data) {
				UserProfilePage.modal = $(data.body).makeModal({width : 750, onClose: UserProfilePage.closeModal, closeOnBlackoutClick: UserProfilePage.closeModal});
				var modal = UserProfilePage.modal;

				UserProfilePage.renderAvatarLightbox(modal);
				UserProfilePage.renderAboutMeLightbox(modal);
				//UserProfilePage.renderInterviewLightbox(modal);

				var tab = modal.find('.tabs a');
				tab.click(function(event) {
					event.preventDefault();
					UserProfilePage.switchTab($(this).closest('li'));
				});

				// Synthesize a click on the tab to hide/show the right panels
				$('[data-tab=' + tabName + '] a').click();

				$.loadFacebookAPI(function() {
					if(window.FB && FB.XFBML) {
						// parse FBXML login button
						FB.XFBML.parse(document.getElementById('UPPLightboxWrapper'));
					}
				});

				UserProfilePage.isLightboxGenerating = false;
			}).error(function(data) {
				var response = JSON.parse(data.responseText);
				$.showModal('Error', response.exception.message);

				UserProfilePage.isLightboxGenerating = false;
			});
		}
	},

	switchTab: function(tab) {
	/*	if( true === UserProfilePage.wasDataChanged ) {
			UserProfilePage.saveUserData(false);
			UserProfilePage.forceRedirect = true;
			UserProfilePage.wasDataChanged = false;
		} */

		// Move 'selected' class to the right tab
		var tabs = tab.closest('ul');
		tabs.children('li').each(function(){
			$(this).removeClass('selected');
		});
		tab.addClass('selected');

		// Show correct tab content
		var tabName = tab.data('tab');
		$('.tab-content > li').each(function() {
			var currentItem = $(this);
			if( currentItem.attr('class') === tabName ) {
				currentItem.show();
			} else {
				currentItem.hide();
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
			UserProfilePage.closeModal(modal);

			window.location = UserProfilePage.reloadUrl;

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
		UserProfilePage.modal.startThrobbing();

		var image = $(img);
		UserProfilePage.newAvatar = {file: image.attr('class'), source: 'sample', userId: UserProfilePage.userId };
		UserProfilePage.wasDataChanged = true;

		var avatarImg = UserProfilePage.modal.find('img.avatar');
		avatarImg.attr('src', image.attr('src'));
		UserProfilePage.modal.stopThrobbing();
		avatarImg.show();
	},

	saveAvatarAIM: function(form) {
		var inputs = $(form).find('button, input[type=file]');
		var handler = form.onsubmit;

		$.AIM.submit(form, {
			onStart: function() {
				UserProfilePage.modal.startThrobbing();
			},
			onComplete: function(response) {
				try {
					response = JSON.parse(response);
					var avatarImg = UserProfilePage.modal.find('img.avatar');
					if( response.result.success === true ) {
						avatarImg.attr('src', response.result.avatar);
						UserProfilePage.newAvatar = { file: response.result.avatar , source: 'uploaded', userId: UserProfilePage.userId };
						UserProfilePage.wasDataChanged = true;
						GlobalNotification.hide();
					} else {
						if( typeof(response.result.error) !== 'undefined' ) {
							GlobalNotification.show(response.result.error, 'error');
						}
					}
					UserProfilePage.modal.stopThrobbing();

					if( typeof(form[0]) !== 'undefined' ) {
						form[0].reset();
					}
				} catch(e) {
					UserProfilePage.modal.stopThrobbing();
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

		$('.favorite-wikis').on('click', '.delete', function() {
			UserProfilePage.hideFavWiki($(this).closest('li').data('wiki-id'));
		});

		modal.find('.favorite-wikis-refresh').click(function(event) {
			event.preventDefault();
			UserProfilePage.refreshFavWikis();
		});

		var formFields = modal.find('input[type="text"], select');
		var change = function() {
			UserProfilePage.wasDataChanged = true;
		};

		formFields.change(change);
		formFields.keypress(change);

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
			data: "answers="+JSON.stringify(this.questions),
			success: function(data) {
				if( data.status == "error" ) {
					GlobalNotification.show(data.errorMsg, 'error');
				} else {
					UserProfilePage.closeModal(UserProfilePage.modal);

					window.location = UserProfilePage.reloadUrl;
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

		if(UserProfilePage.newAvatar) {
			userData.avatarData = UserProfilePage.newAvatar;
		}

		$.ajax({
			type: 'POST',
			url: this.ajaxEntryPoint+'&method=saveUserData',
			dataType: 'json',
			data: 'userId=' + UserProfilePage.userId + '&data=' + JSON.stringify(userData),
			success: function(data) {
				if( data.status == "error" ) {
					GlobalNotification.show(data.errorMsg, 'warn');
				} else {
					UserProfilePage.userData = null;

					if( true === doRedirect ) {
						if( typeof(modal) !== 'undefined' ) {
							UserProfilePage.closeModal(modal);
						} else {
							UserProfilePage.closeModal(UserProfilePage.modal);
						}

						window.location = UserProfilePage.reloadUrl;
					}
				}
			}
		});
	},

	getFormData: function() {
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
			var userDataItem = $(document.userData[i]).val();
			if( typeof(userDataItem) !== 'undefined' ) {
				userData[i] = userDataItem;
			}
		}
		if (document.userData['hideEditsWikis'].checked) {
			userData['hideEditsWikis'] = 1;
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

				var changed = false;
				for(var i in userData) {
					if( typeof($(document.userData[i]).val()) !== 'undefined' ) {
						var key = userData[i];

						UserProfilePage.fillFieldsWithFbData(i, key, data.result.fbUser);
						changed = true;
					}
				}

				$('#facebookConnect').hide();
				$('#facebookPage').show();

				if( changed === true ) UserProfilePage.wasDataChanged = true;
			}
		});
	},

	fbConnectAvatar: function() {
		UserProfilePage.modal.find('img.avatar').hide();
		UserProfilePage.modal.startThrobbing();
		$.postJSON( this.ajaxEntryPoint, { method: 'onFacebookConnectAvatar', avatar: true, cb: wgStyleVersion }, function(data) {
			if( data.result.success === true ) {
				$('#facebookConnectAvatar').hide();
				var avatarImg = UserProfilePage.modal.find('img.avatar');
				avatarImg.attr('src', data.result.avatar).show();
				UserProfilePage.modal.stopThrobbing();
				UserProfilePage.wasDataChanged = true;
				UserProfilePage.newAvatar = {file: data.result.avatar, source: 'facebook', userId: UserProfilePage.userId };
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

			if( typeof(dateArray[0]) !== 'undefined' ) {
				monthSelectBox.val( parseInt(dateArray[0], 10) );
			}

			if( typeof(dateArray[1]) !== 'undefined' ) {
				UserProfilePage.refillBDayDaySelectbox({month:monthSelectBox, day:daySelectBox});
				daySelectBox.val( parseInt(dateArray[1], 10) );
			}
		}
	},

	hideFavWiki: function(wikiId) {
		if( wikiId >= 0 ) {
			UserProfilePage.modal.find('.favorite-wikis [data-wiki-id="' + wikiId + '"]')
				.fadeOut('fast', function() {
					$(this).remove();
					$.postJSON( UserProfilePage.ajaxEntryPoint, { method: 'onHideWiki', userId: UserProfilePage.userId, wikiId: wikiId, cb: wgStyleVersion }, function(data) {
						if( data.result.success === true ) {
							// add the next wiki
							$.each(data.result.wikis, function(index, value) {
								if(UserProfilePage.modal.find('.favorite-wikis [data-wiki-id="' + value.id + '"]').length == 0) {
									//found the wiki to add. now do it.
									UserProfilePage.modal.find('.join-more-wikis').before('<li data-wiki-id="' + value.id + '"><span>' + value.wikiName + '</span> <img src="' + wgBlankImgUrl + '" class="sprite-small delete"></li>');

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
				var favWikis = '';
				for(i in data.result.wikis) {
					favWikis += '<li data-wiki-id="' + data.result.wikis[i].id  + '"><span>' + data.result.wikis[i].wikiName + '</span> <img src="' + wgBlankImgUrl + '" class="sprite-small delete"></li>';
				}
				favWikisList.prepend(favWikis);

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

	closeModal: function(modal, resetDataChangedFlag) {
		if( typeof(modal.closeModal) === 'function' ) {
			modal.closeModal();
		} else {
			if( UserProfilePage.wasDataChanged === true ) {
				if( $('#UPPLightboxCloseWrapper').length == 0 ) {
					setTimeout(function() {
						UserProfilePage.displayClosingPopup();
					}, 50 );
				}
				return false
			}
		}

		if( typeof(resetDataChangedFlag) === 'undefined' || resetDataChangedFlag === true ) {
			//changing it for next lightbox openings
			UserProfilePage.wasDataChanged = false;
		}

		if( UserProfilePage.forceRedirect === true ) {
			window.location = UserProfilePage.reloadUrl;
		}
	},

	displayClosingPopup: function() {
		$.getJSON( this.ajaxEntryPoint, { method: 'getClosingModal', userId: UserProfilePage.userId, rand: Math.floor(Math.random()*100001) }, function(data) {

			UserProfilePage.closingPopup = $(data.body).makeModal({width: 500, showCloseButton: false, closeOnBlackoutClick: false});

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
			});
		});
	},

	removeAvatar: function(name, question) {
		var answer = confirm(question);

		if(answer){
			$.nirvana.sendRequest({
				controller: 'UserProfilePage',
				method: 'removeavatar',
				format: 'json',
				data: {
					av_user: name
				},
				callback: function(data) {
					if(data.status == "ok") {
						window.location.reload();
					} else {
						alert(data.error);
					}
				}
			});
		}
	}
}

$(function() {
	UserProfilePage.init();
});
