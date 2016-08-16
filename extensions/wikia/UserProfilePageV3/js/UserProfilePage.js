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
	bucky: window.Bucky('UserProfilePage'),
	bannerNotification: null,

	// reference to modal UI component
	modalComponent: {},

	init: function () {
		'use strict';

		var $userIdentityBoxEdit = $('#userIdentityBoxEdit');
		UserProfilePage.userId = $('#user').val();
		UserProfilePage.reloadUrl = $('#reloadUrl').val();
		require(['BannerNotification'], function (BannerNotification) {
			UserProfilePage.bannerNotification = new BannerNotification().setType('error');
		});

		if (UserProfilePage.reloadUrl === '' || UserProfilePage.reloadUrl === false) {
			UserProfilePage.reloadUrl = window.wgScript + '?title=' + window.wgPageName;
		}

		$userIdentityBoxEdit.click(function (event) {
			event.preventDefault();
			UserProfilePage.renderLightbox('about');
		});

		$('#UserAvatarRemove').click(function (event) {
			event.preventDefault();
			UserProfilePage.removeAvatar($(event.target).attr('data-name'),
				$(event.target).attr('data-confirm'));
		});

		$('#userAvatarEdit').click(function (event) {
			event.preventDefault();
			UserProfilePage.renderLightbox('avatar');
		});

		$('#discussionAllPostsByUser').click(function (event) {
			Wikia.Tracker.track({
				action: Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
				browserEvent: event,
				href: $(event.target).attr('href'),
				label: 'discussion-all-posts-by-user'
			});
		});

		// for touch devices (without hover state) make sure that Edit is always
		// visible
		if (Wikia.isTouchScreen()) {
			$userIdentityBoxEdit.show();
		}
	},

	renderLightbox: function (tabName) {
		'use strict';

		if (!UserProfilePage.isLightboxGenerating) {
			// Start profiling
			UserProfilePage.bucky.timer.start('renderLightboxSuccess');
			UserProfilePage.bucky.timer.start('renderLightboxFail');

			//if lightbox is generating we don't want to let user open second one
			UserProfilePage.isLightboxGenerating = true;
			UserProfilePage.newAvatar = false;

			$.when(
				$.getJSON(this.ajaxEntryPoint, {
					method: 'getLightboxData',
					tab: tabName,
					userId: UserProfilePage.userId,
					rand: Math.floor(Math.random() * 100001) // is cache buster really needed here?
				}),
				$.getMessages(['UserProfilePageV3']),
				$.getResources([
					$.getSassCommonURL('/extensions/wikia/UserProfilePageV3/css/UserProfilePage_modal.scss')
				])
			).done(function (getJSONResponse) {
				var data = getJSONResponse[0];

				require(['wikia.ui.factory'], function (uiFactory) {
					uiFactory.init(['modal']).then(function (modal) {

						// set reference to modal UI component for easy creation of confirmation modal
						UserProfilePage.modalComponent = modal;

						var id = $(data.body).attr('id') + 'Wrapper',
							modalConfig = {
								vars: {
									id: id,
									content: data.body,
									size: 'medium',
									title: $.msg('userprofilepage-edit-modal-header'),
									buttons: [{
										vars: {
											value: $.msg('user-identity-box-avatar-save'),
											classes: ['normal', 'primary'],
											data: [{
												key: 'event',
												value: 'save'
											}]
										}
									}, {
										vars: {
											value: $.msg('user-identity-box-avatar-cancel'),
											data: [{
												key: 'event',
												value: 'close'
											}]
										}
									}]
								}
							};
						modal.createComponent(modalConfig, function (editProfileModal) {
							UserProfilePage.modal = editProfileModal;

							var modal = editProfileModal.$element,
								tab = modal.find('.tabs a');

							UserProfilePage.registerAvatarHandlers(modal);
							UserProfilePage.registerAboutMeHandlers(modal);

							// attach handlers to modal events
							editProfileModal.bind('beforeClose',
								$.proxy(UserProfilePage.beforeClose, UserProfilePage));
							editProfileModal.bind('save',
								$.proxy(UserProfilePage.saveUserData, UserProfilePage));

							// adding handler for tab switching
							tab.click(function (event) {
								event.preventDefault();
								UserProfilePage.switchTab($(this).closest('li'));
							});

							// Synthesize a click on the tab to hide/show the right panels
							$('[data-tab=' + tabName + '] a').click();

							// show a message when avatars upload is disabled (BAC-1046)
							if (data.avatarsDisabled === true) {
								UserProfilePage.error(data.avatarsDisabledMsg);
							}

							UserProfilePage.isLightboxGenerating = false;

							editProfileModal.show();
							UserProfilePage.bucky.timer.stop('renderLightboxSuccess');
						});
					});
				});
			}).fail(function (data) {

				console.log(data);

				var message = '',
					response = '';

				if (data.responseText) {
					response = JSON.parse(data.responseText);
					message = response.exception.message;
				} else {
					message = data.error;
				}

				require(['wikia.ui.factory'], function (uiFactory) {
					uiFactory.init(['modal']).then(function (modal) {
						var modalConfig = {
							vars: {
								id: 'UPPModalError',
								content: message,
								size: 'small',
								title: $.msg('userprofilepage-edit-modal-error')
							}
						};

						modal.createComponent(modalConfig, function (errorModal) {
							errorModal.show();
							UserProfilePage.bucky.timer.stop('renderLightboxFail');
						});
					});
				});

				UserProfilePage.isLightboxGenerating = false;
			});
		}
	},

	/**
	 * Checks if anything data was changes before closing modal and if true opens confirmation modal.
	 * Rejected promise stops execution other event handlers in the queue
	 *
	 * @returns {promise|*}
	 */

	beforeClose: function () {
		'use strict';

		var deferred = new $.Deferred();

		if (UserProfilePage.wasDataChanged === true) {
			if ($('#UPPLightboxCloseWrapper').length === 0) {
				setTimeout(function () {
					UserProfilePage.displayClosingPopup();
				}, 50);
			}
			deferred.reject();
		} else {
			deferred.resolve();
		}

		return deferred.promise();
	},

	switchTab: function (tab) {
		'use strict';

		// Move 'selected' class to the right tab
		var tabs = tab.closest('ul'),
			tabName = tab.data('tab');

		tabs.children('li').each(function () {
			$(this).removeClass('selected');
		});
		tab.addClass('selected');

		// Show correct tab content
		$('.tab-content > li').each(function () {
			var currentItem = $(this);
			if (currentItem.attr('class') === tabName) {
				currentItem.show();
			} else {
				currentItem.hide();
			}
		});
	},

	/**
	 * Register handlers related to the Avatar tab of the user edit modal.
	 * @param {object} modal UI component modal
	 */
	registerAvatarHandlers: function (modal) {
		'use strict';

		var $avatarUploadInput = modal.find('#UPPLightboxAvatar'),
			$avatarUploadButton = modal.find('#UPPLightboxAvatarUpload'),
			$avatarForm = modal.find('#usersAvatar'),
			$sampleAvatars = modal.find('.sample-avatars');

		// VOLDEV-83: Fix confusing file upload interface
		$avatarUploadButton.on('click', function () {
			$avatarUploadInput.click();
		});

		$avatarUploadInput.change(function () {
			UserProfilePage.saveAvatarAIM($avatarForm);
		});

		$sampleAvatars.on('click', 'img', function (event) {
			UserProfilePage.sampleAvatarChecked($(event.target));
		});
	},

	sampleAvatarChecked: function (img) {
		'use strict';

		var image = $(img),
			$modal = UserProfilePage.modal.$element,
			avatarImg = $modal.find('img.avatar');

		$modal.find('img.avatar').hide();
		$modal.startThrobbing();

		UserProfilePage.newAvatar = {
			file: image.attr('class'),
			source: 'sample',
			userId: UserProfilePage.userId
		};
		UserProfilePage.wasDataChanged = true;

		avatarImg.attr('src', image.attr('src'));
		$modal.stopThrobbing();
		avatarImg.show();
	},

	saveAvatarAIM: function (form) {
		'use strict';

		UserProfilePage.bucky.timer.start('saveAvatarAIMSuccess');
		UserProfilePage.bucky.timer.start('saveAvatarAIMFail');
		var $modal = UserProfilePage.modal.$element;

		$.AIM.submit(form, {
			onStart: function () {
				$modal.startThrobbing();
			},
			onComplete: function (response) {
				try {
					response = JSON.parse(response);
					var avatarImg = $modal.find('img.avatar');
					if (response.result.success === true) {
						avatarImg.attr('src', response.result.avatar);
						UserProfilePage.newAvatar = {
							file: response.result.avatar,
							source: 'uploaded',
							userId: UserProfilePage.userId
						};
						UserProfilePage.wasDataChanged = true;
						UserProfilePage.bannerNotification.hide();
					} else {
						if (typeof (response.result.error) !== 'undefined') {
							UserProfilePage.error(response.result.error);
						}
					}
					$modal.stopThrobbing();

					if (typeof (form[0]) !== 'undefined') {
						form[0].reset();
						UserProfilePage.bucky.timer.stop('saveAvatarAIMSuccess');
					}
				} catch (e) {
					$modal.stopThrobbing();
					form[0].reset();
					UserProfilePage.bucky.timer.stop('saveAvatarAIMFail');
				}
			}
		});

		//unbind original html element handler to avoid loops
		form.onsubmit = null;

		$(form).submit();
	},

	/**
	 * Register handlers related to the About Me tab of the user edit modal.
	 * @param {object} modal UI component modal
	 */
	registerAboutMeHandlers: function (modal) {
		'use strict';

		var $monthSelectBox = modal.find('#userBDayMonth'),
			$daySelectBox = modal.find('#userBDayDay'),
			$formFields = modal.find('input[type="text"], select'),

			change = function () {
				UserProfilePage.wasDataChanged = true;
			};

		$monthSelectBox.change(function () {
			UserProfilePage.refillBDayDaySelectbox({
				month: $monthSelectBox,
				day: $daySelectBox
			});
		});

		$('.favorite-wikis').on('click', '.delete', function () {
			UserProfilePage.hideFavWiki($(this).closest('li').data('wiki-id'));
		});

		modal.find('.favorite-wikis-refresh').click(function (event) {
			event.preventDefault();
			UserProfilePage.refreshFavWikis();
		});

		$formFields.change(change);
		$formFields.keypress(change);

		UserProfilePage.toggleJoinMoreWikis();
	},

	saveUserData: function () {
		'use strict';

		UserProfilePage.bucky.timer.start('saveUserDataSuccess');
		UserProfilePage.bucky.timer.start('saveUserDataFail');

		var userData = UserProfilePage.getFormData(),
			saveButton = $('button[data-event=save]');

		//prevent from multiple clicks on 'save' button
		saveButton.prop('disabled', true);

		if (UserProfilePage.newAvatar) {
			userData.avatarData = UserProfilePage.newAvatar;
		}

		$.ajax({
			type: 'POST',
			url: this.ajaxEntryPoint + '&method=saveUserData',
			dataType: 'json',
			data: {
				'userId': UserProfilePage.userId,
				'data': JSON.stringify(userData),
				'token': window.mw.user.tokens.get('editToken')
			},
			success: function (data) {
				if (data.status === 'error') {
					UserProfilePage.error(data.errMsg);
					UserProfilePage.bucky.timer.stop('saveUserDataFail');
				} else {
					UserProfilePage.userData = null;
					UserProfilePage.wasDataChanged = false;
					UserProfilePage.modal.trigger('close');
					UserProfilePage.bucky.timer.stop('saveUserDataSuccess');
					UserProfilePage.bucky.flush();
					window.location = UserProfilePage.reloadUrl;
				}
			},
			error: UserProfilePage.error,
			complete: function () {
				saveButton.prop('disabled', false);
			}
		});
	},

	/**
	 * Hnadle error states after ajax requests
	 * @param {string} [msg] Optional error message to display. Otherwise, default message will be used.
	 */
	error: function (msg) {
		'use strict';

		if (typeof msg !== 'string') {
			msg = $.msg('oasis-generic-error');
		}

		UserProfilePage.bannerNotification.setContent(msg).show();
	},

	getFormData: function () {
		'use strict';

		var userData = {
				name: null,
				location: null,
				occupation: null,
				gender: null,
				website: null,
				twitter: null,
				fbPage: null,
				year: null,
				month: null,
				day: null
			},
			i,
			userDataItem;

		for (i in userData) {
			userDataItem = $(document.userData[i]).val();
			if (typeof (userDataItem) !== 'undefined') {
				userData[i] = userDataItem;
			}
		}

		userData.hideEditsWikis = document.userData.hideEditsWikis.checked ? 1 : 0;

		return userData;
	},

	refillBDayDaySelectbox: function (selectboxes) {
		'use strict';

		selectboxes.day.html('');
		var options = '',
			daysInMonth = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
			selectedMonth = selectboxes.month.val(),
			i;

		for (i = 1; i <= daysInMonth[selectedMonth - 1]; i++) {
			options += '<option value="' + i + '">' + i + '</option>';
		}
		options = '<option value="0">--</option>' + options;

		selectboxes.day.html(options);
	},

	hideFavWiki: function (wikiId) {
		'use strict';

		var $modal = UserProfilePage.modal.$element;

		if (wikiId >= 0) {
			$modal.find('.favorite-wikis [data-wiki-id="' + wikiId + '"]')
				.fadeOut('fast', function () {
					$(this).remove();
					$.postJSON(UserProfilePage.ajaxEntryPoint, {
						method: 'onHideWiki',
						userId: UserProfilePage.userId,
						wikiId: wikiId,
						cb: window.wgStyleVersion
					}, function (data) {
						if (data.result.success === true) {
							// add the next wiki
							$.each(data.result.wikis, function (index, value) {
								if ($modal.find('.favorite-wikis [data-wiki-id="' + value.id + '"]').length === 0) {
									//found the wiki to add. now do it.
									$modal.find('.join-more-wikis')
										.before('<li data-wiki-id="' + value.id + '"><span>' + value.wikiName +
											'</span> <img src="' + window.wgBlankImgUrl +
											'" class="sprite-small delete"></li>');

								}
							});
							UserProfilePage.toggleJoinMoreWikis();
						}
					});
				});
		} else {
			// basically it shouldn't happen but i imagine it can happen during development
			$().log('Unexpected error wikiId <= 0');
		}
	},

	refreshFavWikis: function () {
		'use strict';

		$.postJSON(this.ajaxEntryPoint, {
			method: 'onRefreshFavWikis',
			userId: UserProfilePage.userId,
			cb: window.wgStyleVersion
		}, function (data) {
			if (data.result.success === true) {
				var favWikisList = UserProfilePage.modal.$element.find('.favorite-wikis'),
					favWikis = '',
					i;

				// empty the list
				favWikisList.children().not('.join-more-wikis').remove();

				// add items
				for (i in data.result.wikis) {
					favWikis += '<li data-wiki-id="' + data.result.wikis[i].id + '"><span>' +
						data.result.wikis[i].wikiName + '</span> <img src="' + window.wgBlankImgUrl +
						'" class="sprite-small delete"></li>';
				}
				favWikisList.prepend(favWikis);

				UserProfilePage.toggleJoinMoreWikis();
			}
		});
	},

	toggleJoinMoreWikis: function () {
		'use strict';

		var $modal = UserProfilePage.modal.$element,
			minNumOfJoinedWikis = 4,
			joinMoreWikis = $modal.find('.join-more-wikis');
		if ($modal.find('.favorite-wikis').children().not('.join-more-wikis').length === minNumOfJoinedWikis) {
			joinMoreWikis.hide();
		} else {
			joinMoreWikis.show();
		}
	},

	/**
	 * Display confirmation modal when trying to close edit profile modal with unsaved changes
	 */

	displayClosingPopup: function () {
		'use strict';

		$.getJSON(this.ajaxEntryPoint, {
			method: 'getClosingModal',
			userId: UserProfilePage.userId,
			rand: Math.floor(Math.random() * 100001)
		}, function (data) {
			var id = $(data.body).attr('id') + 'Wrapper',
				modalConfig = {
					vars: {
						id: id,
						content: data.body,
						size: 'medium',
						title: $.msg('userprofilepage-closing-popup-header'),
						buttons: [{
							vars: {
								value: $.msg('userprofilepage-closing-popup-save-and-quit'),
								classes: ['normal', 'primary'],
								data: [{
									key: 'event',
									value: 'save'
								}]
							}
						}, {
							vars: {
								value: $.msg('userprofilepage-closing-popup-discard-and-quit'),
								data: [{
									key: 'event',
									value: 'quit'
								}]
							}
						}, {
							vars: {
								value: $.msg('userprofilepage-closing-popup-cancel'),
								data: [{
									key: 'event',
									value: 'close'
								}]
							}
						}]
					}
				};

			UserProfilePage.modalComponent.createComponent(modalConfig, function (confirmationModal) {

				// attaching handlers to button events
				confirmationModal.bind('save', function () {
					confirmationModal.trigger('close');
					UserProfilePage.saveUserData();
				});
				confirmationModal.bind('quit', function () {
					UserProfilePage.wasDataChanged = false;
					UserProfilePage.modal.trigger('close');
					confirmationModal.trigger('close');
				});

				confirmationModal.show();

			});
		});
	},

	removeAvatar: function (name, question) {
		'use strict';

		var answer = window.confirm(question);

		if (answer) {
			$.nirvana.sendRequest({
				controller: 'UserProfilePage',
				method: 'removeavatar',
				format: 'json',
				data: {
					avUser: name,
					token: mw.user.tokens.get('editToken')
				},
				callback: function (data) {
					if (data.status === 'ok') {
						window.location.reload();
					} else {
						UserProfilePage.error(data.error);
					}
				}
			});
		}
	}
};

$(function () {
	'use strict';
	UserProfilePage.init();
});
