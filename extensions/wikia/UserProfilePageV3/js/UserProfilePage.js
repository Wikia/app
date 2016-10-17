require(
	['jquery', 'mw', 'wikia.nirvana', 'wikia.window', 'wikia.tracker', 'bucky', 'BannerNotification', 'wikia.ui.factory'],
	function ($, mw, nirvana, window, tracker, bucky, BannerNotification, uiFactory) {
	'use strict';

	var UserProfilePage = {
		questions: [],
		currQuestionIndex: 0,
		modal: null,
		newAvatar: false,
		closingPopup: null,
		userId: null,
		wasDataChanged: false,
		forceRedirect: false,
		reloadUrl: false,
		bucky: bucky('UserProfilePage'),
		bannerNotification: null,

		// reference to modal UI component
		modalComponent: {},

		init: function () {
			var $userIdentityBoxEdit = $('#userIdentityBoxEdit');
			UserProfilePage.userId = $('#user').val();
			UserProfilePage.reloadUrl = $('#reloadUrl').val();
			UserProfilePage.bannerNotification = new BannerNotification().setType('error');

			if (UserProfilePage.reloadUrl === '' || UserProfilePage.reloadUrl === false) {
				UserProfilePage.reloadUrl = mw.config.get('wgScript') + '?title=' + mw.config.get('wgPageName');
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
				tracker.track({
					action: tracker.ACTIONS.CLICK_LINK_TEXT,
					browserEvent: event,
					href: $(event.target).attr('href'),
					label: 'discussion-all-posts-by-user'
				});
			});

			$('#userIdentityBoxClear').click(function (event) {
				event.preventDefault();
				UserProfilePage.clearMastheadContents(
					$(event.target).attr('data-name'),
					$(event.target).attr('data-confirm')
				);
			});

			// for touch devices (without hover state) make sure that Edit is always
			// visible
			if (window.Wikia.isTouchScreen()) {
				$userIdentityBoxEdit.show();
			}
		},

		renderLightbox: function (tabName) {
			if (!UserProfilePage.isLightboxGenerating) {
				// Start profiling
				UserProfilePage.bucky.timer.start('renderLightboxSuccess');
				UserProfilePage.bucky.timer.start('renderLightboxFail');

				//if lightbox is generating we don't want to let user open second one
				UserProfilePage.isLightboxGenerating = true;
				UserProfilePage.newAvatar = false;

				$.when(
					// TODO: this should probably be refactored as mustache template
					nirvana.sendRequest({
						controller: 'UserProfilePage',
						method: 'getLightboxData',
						type: 'GET',
						data: {
							tab: tabName,
							userId: UserProfilePage.userId,
							rand: Math.floor(Math.random() * 100001) // is cache buster really needed here?
						}
					}),
					mw.loader.using('ext.UserProfilePage.Lightbox')
				).done(function (getJSONResponse) {
					var data = getJSONResponse[0];

					uiFactory.init(['modal']).then(function (modal) {

						// set reference to modal UI component for easy creation of confirmation modal
						UserProfilePage.modalComponent = modal;

						var id = $(data.body).attr('id') + 'Wrapper',
							modalConfig = {
								vars: {
									id: id,
									content: data.body,
									size: 'medium',
									title: mw.message('userprofilepage-edit-modal-header').escaped(),
									buttons: [{
										vars: {
											value: mw.message('user-identity-box-avatar-save').text(),
											classes: ['normal', 'primary'],
											data: [{
												key: 'event',
												value: 'save'
											}]
										}
									}, {
										vars: {
											value: mw.message('user-identity-box-avatar-cancel').text(),
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
							editProfileModal.bind('beforeClose', UserProfilePage.beforeClose.bind(UserProfilePage));
							editProfileModal.bind('save', UserProfilePage.saveUserData.bind(UserProfilePage));

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
				}).fail(function (data) {

					window.console.log(data);

					var message, response;

					if (data.responseText) {
						response = JSON.parse(data.responseText);
						message = response.exception.message;
					} else {
						message = data.error;
					}

					uiFactory.init(['modal']).then(function (modal) {
						var modalConfig = {
							vars: {
								id: 'UPPModalError',
								content: message,
								size: 'small',
								title: mw.message('userprofilepage-edit-modal-error').escaped()
							}
						};

						modal.createComponent(modalConfig, function (errorModal) {
							errorModal.show();
							UserProfilePage.bucky.timer.stop('renderLightboxFail');
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
			UserProfilePage.bucky.timer.start('saveUserDataSuccess');
			UserProfilePage.bucky.timer.start('saveUserDataFail');

			var userData = UserProfilePage.getFormData(),
				saveButton = $('button[data-event=save]');

			//prevent from multiple clicks on 'save' button
			saveButton.prop('disabled', true);

			if (UserProfilePage.newAvatar) {
				userData.avatarData = UserProfilePage.newAvatar;
			}

			nirvana.sendRequest({
				controller: 'UserProfilePage',
				method: 'saveUserData',
				type: 'POST',
				data: {
					'userId': UserProfilePage.userId,
					'data': JSON.stringify(userData),
					'token': window.mw.user.tokens.get('editToken')
				}
			}).then(function (data) {
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
			}).fail(
				UserProfilePage.error
			).done(function () {
				saveButton.prop('disabled', false);
			});
		},

		/**
		 * Hnadle error states after ajax requests
		 * @param {string} [msg] Optional error message to display. Otherwise, default message will be used.
		 */
		error: function (msg) {
			if (typeof msg !== 'string') {
				msg = mw.message('oasis-generic-error');
			}

			UserProfilePage.bannerNotification.setContent(msg).show();
		},

		getFormData: function () {
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
				userDataItem;

			Object.getOwnPropertyNames(userData).forEach(function (userDataItemKey) {
				userDataItem = $(document.userData[userDataItemKey]).val();
				if (typeof (userDataItem) !== 'undefined') {
					userData[userDataItemKey] = userDataItem;
				}
			});

			userData.hideEditsWikis = document.userData.hideEditsWikis.checked ? 1 : 0;

			return userData;
		},

		refillBDayDaySelectbox: function (selectboxes) {
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
			var $modal = UserProfilePage.modal.$element;

			if (wikiId >= 0) {
				$modal.find('.favorite-wikis [data-wiki-id="' + wikiId + '"]')
					.fadeOut('fast', function () {
						$(this).remove();
						nirvana.sendRequest({
							controller: 'UserProfilePage',
							method: 'onHideWiki',
							type: 'POST',
							data: {
								userId: UserProfilePage.userId,
								wikiId: wikiId,
								cb: window.wgStyleVersion
							}
						}).then(function (data) {
							if (data.result.success === true) {
								// add the next wiki
								data.result.wikis.forEach(function(wiki) {
									if ($modal.find('.favorite-wikis [data-wiki-id="' + wiki.id + '"]').length === 0) {
										//found the wiki to add. now do it.
										$modal.find('.join-more-wikis')
											.before('<li data-wiki-id="' + wiki.id + '"><span>' + wiki.wikiName +
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
			nirvana.sendRequest({
				controller: 'UserProfilePage',
				method: 'onRefreshFavWikis',
				type: 'POST',
				data: {
					userId: UserProfilePage.userId,
					cb: mw.config.get('wgStyleVersion')
				}
			}).then(function (data) {
				if (data.result.success === true) {
					var favWikisList = UserProfilePage.modal.$element.find('.favorite-wikis'),
						favWikis = '';

					// empty the list
					favWikisList.children().not('.join-more-wikis').remove();

					// add items
					data.result.wikis.forEach(function(wiki) {
						favWikis += '<li data-wiki-id="' + wiki.id + '"><span>' +
							wiki.wikiName + '</span> <img src="' + mw.config.get('wgBlankImgUrl') +
							'" class="sprite-small delete"></li>';
					});
					favWikisList.prepend(favWikis);

					UserProfilePage.toggleJoinMoreWikis();
				}
			});
		},

		toggleJoinMoreWikis: function () {
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
			nirvana.sendRequest({
				controller: 'UserProfilePage',
				method: 'getClosingModal',
				type: 'GET',
				data: {
					userId: UserProfilePage.userId,
					rand: Math.floor(Math.random() * 100001)
				}
			}).then(function (data) {
				var id = $(data.body).attr('id') + 'Wrapper',
					modalConfig = {
						vars: {
							id: id,
							content: data.body,
							size: 'medium',
							title: mw.message('userprofilepage-closing-popup-header').escaped(),
							buttons: [{
								vars: {
									value: mw.message('userprofilepage-closing-popup-save-and-quit').escaped(),
									classes: ['normal', 'primary'],
									data: [{
										key: 'event',
										value: 'save'
									}]
								}
							}, {
								vars: {
									value: mw.message('userprofilepage-closing-popup-discard-and-quit').escaped(),
									data: [{
										key: 'event',
										value: 'quit'
									}]
								}
							}, {
								vars: {
									value: mw.message('userprofilepage-closing-popup-cancel').escaped(),
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
			var answer = window.confirm(question);

			if (answer) {
				nirvana.sendRequest({
					controller: 'UserProfilePage',
					method: 'removeavatar',
					type: 'POST',
					data: {
						avUser: name,
						token: mw.user.tokens.get('editToken')
					}
				}).then(function (data) {
					if (data.status === 'ok') {
						window.location.reload();
					} else {
						UserProfilePage.error(data.error);
					}
				});
			}
		},

		/**
		 * Clear all contents from user profile (including user avatar)
		 * @param {string} targetUser Name of target user
		 * @param {string} confirmationMessage Confirmation message to display
		 */
		clearMastheadContents: function (targetUser, confirmationMessage) {
			var confirmClear = window.confirm(confirmationMessage);
			if (confirmClear) {
				nirvana.sendRequest({
					controller: 'UserProfilePage',
					method: 'clearMastheadContents',
					type: 'POST',
					data: {
						target: targetUser,
						token: mw.user.tokens.get('editToken')
					}
				}).done(function () {
					window.location.reload();
				}).fail(function (res) {
					new BannerNotification(JSON.parse(res.responseText).error, 'error').show();
				});
			}
		}
	};

	$(UserProfilePage.init);
});
