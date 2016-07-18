(function (window, $) {
	'use strict';

	var Wall = $.createClass(Object, {
		bucky: window.Bucky('Wall'),
		constructor: function (element, settings) {
			var self = this;

			if (Wall.initialized) {
				return;
			}

			// start performance profiling
			this.bucky.timer.start('constructor');

			Wall.initialized = true;
			this.wall = $(element);
			this.settings = $.extend(true, {}, Wall.settings, settings);
			this.deletedMessages = {};
			this.isMonobook = window.skin && window.skin === 'monobook';
			this.hasMiniEditor = typeof window.wgEnableMiniEditorExt !== 'undefined' && !this.isMonobook;
			this.title = window.wgTitle;
			this.page = {
				title: this.title,
				namespace: window.wgNamespaceNumber
			};
			this.WallTooltipMeta = $('#WallTooltipMeta');

			this.model = new Wall.BackendBridge();
			if (this.settings.pageController) {
				this.model.pageController = this.settings.pageController;
			}

			// TODO: refactor to have classes share common resources instead of passing them around
			$.each(this.settings.classBindings, this.proxy(function (localName, ClassToBind) {
				this[localName] = new ClassToBind(this.page, this.model);
			}));

			this.pagination.on('afterPageLoaded', this.proxy(this.afterPagination));
			this.newMessageForm.on('afterNewMessagePost', this.proxy(this.afterNewMessagePost));

			this.wall
				.on('click', '.admin-delete-message', this.proxy(this.confirmAction))
				.on('click', '.fast-admin-delete-message', this.proxy(this.confirmAction))
				.on('click', '.delete-message', this.proxy(this.confirmAction))
				.on('click', '.remove-message', this.proxy(this.confirmAction))
				.on('click', '.message-restore', this.proxy(this.confirmAction))
				.on('click', '.message-undo-remove', this.proxy(this.undoRemoveOrAdminDelete))
				.on('click', '.follow', this.proxy(this.switchWatch))
				.on('keydown', 'textarea', this.proxy(this.focusButton))
				.on('click', '.edit-notifyeveryone', this.proxy(this.editNotifyEveryone))
				.on('click', '.close-thread', this.proxy(this.confirmAction))
				.on('click', '.reopen-thread', this.proxy(this.doThreadChange))
				.on('click', '.votes', this.proxy(this.showVotersModal))
				.on('click', '.vote', this.proxy(this.vote))
				.on('click', '.quote-button', this.proxy(this.quote))
				.on('click', '.quote-of', this.proxy(this.scrollToQuoted))
				.on('mouseenter', '.follow', this.proxy(this.hoverFollow))
				.on('mouseleave', '.follow', this.proxy(this.unhoverFollow))
				.on('click', '.load-more a', this.proxy(this.loadMore))
				.on('click', '.related-topics .edit-topic-link', this.proxy(this.handleEditTopics))
				.on('click', '.move-thread', this.proxy(this.moveThread))
			// Fix FireFox bug where textareas remain disabled on page reload
			.find('textarea').removeAttr('disabled');

			$('#WikiaArticle')
				.bind('afterWatching', this.proxy(this.onWallWatch))
				.bind('afterUnwatching', this.proxy(this.onWallUnwatch));

			// Enable tooltips
			this.setUpVoteTooltips();

			$('#ForumNewMessage .highlight').popover({
				content: function () {
					return self.WallTooltipMeta.find('.tooltip-highlight-thread').clone();
				},
				placement: 'top'
			});

			$('.timeago').timeago();

			// If any textarea has content make sure Reply / Post button is visible
			$(document).ready(this.initTextareas);
			$(window).bind('hashchange', this.proxy(this.onHashChange)).trigger('hashchange');

			// stop performance profiling
			this.bucky.timer.stop('constructor');
		},

		setUpVoteTooltips: function () {
			// tooltips for votes
			var self = this,
				votesLink,
				votingControls = $('.voting-controls');

			votingControls.find('.vote').popover({
				content: function () {
					var $this = $(this);

					if ($this.hasClass('voted') || $this.hasClass('inprogress')) {
						return self.WallTooltipMeta.find('.tooltip-votes-voted').clone();
					}
					return self.WallTooltipMeta.find('.tooltip-votes-vote').clone();
				},
				placement: 'top'
			});

			votesLink = votingControls.find('.votes');
			if (!votesLink.hasClass('notlink')) {
				this.enableVotesLink(votesLink);
			}
		},

		enableVotesLink: function (votesLink) {
			var self = this;

			votesLink.popover({
				content: function () {
					return self.WallTooltipMeta.find('.tooltip-votes-voterlist').clone();
				},
				placement: 'top'
			});
		},

		disableVotesLink: function (votesLink) {
			votesLink.popover('destroy');
		},

		onHashChange: function () {
			if (window.location.hash) {
				var number = parseInt(window.location.hash.substr(1));
				$('li.message-' + number).removeClass('hide').addClass('show');
			}
		},

		onWallWatch: function () {
			$('.SpeechBubble .follow').fadeOut();
		},

		onWallUnwatch: function () {
			$('.SpeechBubble .follow').fadeIn();
		},

		//hack for safari tab index
		focusButton: function (e) {
			var $element, $button;
			if (e.keyCode === 9 && !e.shiftKey) {
				$element = $(e.target);
				$button = $element.closest('.SpeechBubble')
					.find('button#WallMessageSubmit, .save-edit, .replyButton').first();
				if ($element.attr('id') !== 'WallMessageTitle' && !$element.hasClass('title')) {
					$button.focus();
					e.preventDefault();
				}
			}
		},

		afterPagination: function () {
			var wall = $('#Wall');

			wall.find('.timeago').timeago();
			wall.find('textarea, input').placeholder();

			if (!this.hasMiniEditor) {
				wall.find('.new-reply textarea').autoResize(this.replyMessageForm.settings.reply);
			}

			if (!this.isMonobook) {
				window.WikiaButtons.init(wall);
			}
		},

		// TODO: refactor Wall so subclasses have access to settings, then this can go away
		afterNewMessagePost: function (newmsg) {
			newmsg.find('.timeago').timeago();
			newmsg.find('textarea, input').placeholder();

			if (!this.hasMiniEditor) {
				newmsg.find('.new-reply textarea').autoResize(this.replyMessageForm.settings.reply);
			}
		},

		initTextareas: function () {
			setTimeout(function () {
				var title, body;

				// make sure all textareas are inicialized already
				$('.new-reply textarea').each(function () {
					var el = $(this);
					if (el.is(':focus')) {
						el.trigger('focus');
					}
				});
				title = $('#WallMessageTitle');
				if (title.is(':focus')) {
					title.trigger('focus');
				}
				body = $('#WallMessageBody');
				if (body.is(':focus')) {
					body.trigger('focus');
				}
			}, 50);
		},

		scrollToQuoted: function (e) {
			var postfix, main, el, p;

			//check if we are on thread page
			//then we are just going to use link
			if ($('.Wall.Thread').length !== 0) {
				return true;
			}

			e.preventDefault();
			postfix = $(e.target).data('postfix');
			main = $(e.target).closest('.message-main');

			if (postfix > 1) {
				el = $('.message-' + postfix, main);
			} else {
				el = main;
			}

			if (!el.is(':visible')) {
				main.find('li.SpeechBubble').show();
				$('.load-more', main).remove();
			}

			p = el.offset();
			window.scrollTo(0, p.top);
		},

		// TODO: this should be refactored so it can be used elsewhere
		switchWatch: function (e) {
			var element = $(e.target),
				isWatched = parseInt(element.attr('data-iswatched')),
				commentId = element.closest('[data-id]').attr('data-id');

			element.animate({
				'opacity': 0.5
			}, 'slow');

			this.model.switchWatch(element, isWatched, commentId, this.proxy(this.afterSwitchWatch));
		},

		afterSwitchWatch: function (element, data) {
			var isWatched = parseInt(element.attr('data-iswatched'));
			if (data.status) {
				element.attr('data-iswatched', isWatched ? 0 : 1);
				if (isWatched) {
					element.animate({
						'opacity': 0.7
					}, 'slow', function () {
						element.css('opacity', '');
					});
					element.text($.msg('oasis-follow')).addClass('secondary').removeClass('following');
				} else {
					element.animate({
						'opacity': 0.7
					}, 'slow', function () {
						element.css('opacity', '');
					});
					element.text($.msg('wikiafollowedpages-following')).removeClass('secondary').addClass('following');
				}
			}
		},

		hoverFollow: function (e) {
			var target = $(e.target);
			if (target.html() === $.msg('wikiafollowedpages-following')) {
				target.html($.msg('wall-message-unfollow'));
			}
		},

		unhoverFollow: function (e) {
			var target = $(e.target);
			if (target.html() === $.msg('wall-message-unfollow')) {
				target.html($.msg('wikiafollowedpages-following'));
			}
		},

		loadMore: function (e) {
			var $target, commentId;

			e.preventDefault();
			$target = $(e.target);
			$target.closest('ul').find('li.SpeechBubble').show();
			$target.closest('.load-more').remove();

			commentId = $target.closest('li.message').attr('data-id');
			$.nirvana.sendRequest({
				controller: 'WallNotificationsExternalController',
				method: 'markAsRead',
				format: 'json',
				type: 'POST',
				data: {
					id: commentId
				}
			});
		},

		vote: function (e) {
			e.preventDefault();
			if (!window.wgUserName) {
				window.wikiaAuthModal.load({
					forceLogin: true,
					origin: 'wall-and-forum',
					onAuthSuccess: function () {
						this.voteBase(e, function () {
							window.location.reload();
						});
					}.bind(this)
				});
			} else {
				this.voteBase(e, this.proxy(function (target, data, dir) {
					var votes = target.closest('li.message').find('.votes:first'),
						number = votes.find('.number:first'),
						val = dir + parseInt(number.text());
					number.html(val);
					votes.data('votes', val);
					if (val > 0) {
						votes.removeClass('notlink');
						this.enableVotesLink(votes);
					} else {
						votes.addClass('notlink');
						this.disableVotesLink(votes);
					}
					target.toggleClass('voted')
						.removeClass('inprogress');
				}));
			}
		},

		voteBase: function (e, callback) {
			var $target = $(e.target).closest('a'),
				id = $target.closest('li.message').attr('data-id'),
				dir = $target.hasClass('voted') ? -1 : 1;

			if ($target.hasClass('inprogress')) {
				return true;
			}

			$target.addClass('inprogress');

			$.nirvana.sendRequest({
				controller: 'WallExternalController',
				method: 'vote',
				format: 'json',
				type: 'POST',
				data: {
					dir: dir,
					id: id
				},
				callback: function (data) {
					callback($target, data, dir);
				}
			});
		},

		showVotersModal: function (e) {
			var $target = $(e.target),
				id = $target.closest('li.message').data('id'),
				votes = parseInt($target.closest('.votes').data('votes'), 10);

			if (votes > 0) {
				$.nirvana.sendRequest({
					controller: 'WallExternalController',
					method: 'votersModal',
					format: 'html',
					data: {
						id: id
					},
					callback: function (data) {
						require(['wikia.ui.factory'], function (uiFactory) {
							uiFactory.init(['modal']).then(function (uiModal) {
								var votersModalConfig = {
									vars: {
										id: 'WallVotersModalWrapper',
										size: 'small',
										content: data,
										title: $.msg('wall-votes-modal-title')
									}
								};

								uiModal.createComponent(votersModalConfig, function (votersModal) {
									votersModal.show();
								});
							});
						});
					}
				});

				$.getResources([$.getSassCommonURL('/extensions/wikia/Wall/css/WallVoters.scss')]);
			}
		},

		undoRemoveOrAdminDelete: function (e) {
			var $target = $(e.target),
				id = $target.attr('data-id');
			$.nirvana.sendRequest({
				controller: 'WallExternalController',
				method: 'undoAction',
				type: 'POST',
				data: {
					msgid: id
				},
				callback: this.proxy(function () {
					var msg = $target.closest('li');
					msg.fadeOut('fast', this.proxy(function () {
						if (this.deletedMessages[id]) {
							msg.remove();
							this.deletedMessages[id].fadeIn('slow');
						}
					}));
				})
			});
		},

		doRestore: function (id, target, formdata) {
			$.nirvana.sendRequest({
				controller: 'WallExternalController',
				method: 'restoreMessage',
				type: 'POST',
				data: {
					msgid: id,
					formdata: formdata
				},
				callback: this.proxy(function () {
					window.location.reload();
				})
			});
		},

		confirmAction: function (e) {
			e.preventDefault();

			var $target = $(e.target),
				isreply = $target.closest('.SpeechBubble').attr('data-is-reply'),
				wallMsg = $target.closest('li.message, .message-restore'),
				id = wallMsg.attr('data-id'),
				type = isreply ? 'reply' : 'thread',
				mode = $target.attr('data-mode').split('-'),
				submode = '',
				formdata = {},
				msg,
				title,
				cancelmsg,
				okmsg,
				form = $('<form>'),
				self = this;

			if (mode[1]) {
				submode = mode[1];
			}

			mode = mode[0];
			if (submode === 'fast' || mode === 'fastadmin') {
				this.doAction(id, mode, wallMsg, $target, formdata);
				return true;
			}

			title = $.msg('wall-action-' + mode + '-' + type + '-title');
			okmsg = $.msg('wall-action-' + mode + '-confirm-ok');
			cancelmsg = $.msg('wall-action-all-confirm-cancel');

			//delete && remove
			msg = $.msg('wall-action-' + mode + '-confirm');
			form.append($('<textarea>').attr({
				'class': 'wall-action-reason',
				'name': 'reason',
				'id': 'reason'
			}));
			if (mode !== 'restore') {
				form.append($('<div>').text($.msg('wall-action-' + mode + '-' + type + '-confirm-info'))
					.addClass('subtle'));
				if (mode === 'admin' || mode === 'remove') {
					form.append($('<input>').attr({
						'name': 'notify-admin',
						'id': 'notify-admin',
						'type': 'checkbox'
					}));
					form.append($('<label for="notify-admin">').text($.msg('wall-action-all-confirm-notify')));
				}
			}
			msg += '<form>' + form.html() + '</form>';

			if (mode === 'rev') {
				//rev delete
				if (isreply) {
					msg = $.msg('wall-action-rev-reply-confirm');
				} else {
					msg = $.msg('wall-action-rev-thread-confirm');
				}
			}

			require(['wikia.ui.factory'], function (uiFactory) {
				uiFactory.init(['modal']).then(function (uiModal) {
					var modalPrimaryBtnId = 'WikiaConfirmOk',
						confirmModalConfig = {
							vars: {
								id: 'WikiaConfirm',
								size: 'medium',
								content: msg,
								title: title,
								buttons: [{
									vars: {
										id: modalPrimaryBtnId,
										value: okmsg,
										classes: ['normal', 'primary'],
										disabled: (mode !== 'rev'),
										data: [{
											key: 'event',
											value: modalPrimaryBtnId
										}]
									}
								}, {
									vars: {
										value: cancelmsg,
										data: [{
											key: 'event',
											value: 'close'
										}]
									}
								}]
							}
						};

					uiModal.createComponent(confirmModalConfig, function (confirmModal) {
						confirmModal.bind('WikiaConfirmOk', function () {
							var formdata = confirmModal.$element.find('form').serializeArray();
							confirmModal.deactivate();
							self.doAction(id, mode, wallMsg, $target, formdata, confirmModal);
						});

						confirmModal.$element.find('textarea.wall-action-reason')
							.bind('keydown keyup change', function (e) {
								var $target = $(e.target);
								if ($target.val().length > 0) {
									confirmModal.$element.find('#' + modalPrimaryBtnId).removeAttr('disabled');
								} else {
									confirmModal.$element.find('#' + modalPrimaryBtnId).attr('disabled', 'disabled');
								}
							});

						confirmModal.show();
					});
				});
			});
		},

		/*
		 * work as delete(mode: rev),
		 * admin delete(mode:admin),
		 * remove(mode: remove),
		 * restore(mode: restore)
		 */

		doAction: function (id, mode, msg, target, formdata, modal) {
			switch (mode) {
			case 'close':
				this.doThreadChangeSendRequest(id, 'close', formdata);
				break;
			case 'restore':
				this.doRestore(id, target, formdata);
				break;
			default:
				this.doDelete(id, mode, msg, formdata, modal);
				break;
			}
		},

		doDelete: function (id, mode, msg, formdata, modal) {
			$.nirvana.sendRequest({
				controller: 'WallExternalController',
				method: 'deleteMessage',
				type: 'POST',
				format: 'json',
				data: {
					mode: mode,
					msgid: id,
					username: this.username,
					formdata: formdata
				},
				callback: this.proxy(function (data) {
					if (data.status) {
						if (data.html) {
							this.deletedMessages[id] = msg;

							msg.fadeOut('fast', this.proxy(function () {
								$(data.html).hide().insertBefore(msg).fadeIn('fast');
							}));
						} else {
							msg.fadeOut('fast', function () {
								msg.remove();
							});
						}

						if (typeof (modal) !== 'undefined') {
							// VSTF can delete without confirmation modal
							modal.trigger('close');
						}
					}
				})
			});
		},

		doThreadChangeSendRequest: function (id, newState, formdata) {
			$.nirvana.sendRequest({
				controller: 'WallExternalController',
				method: 'changeThreadStatus',
				format: 'json',
				type: 'POST',
				data: {
					msgid: id,
					newState: newState,
					formdata: formdata
				},
				callback: this.proxy(function (json) {
					if (json.status) {
						if (typeof window.UserLoginAjaxForm === 'function') {
							window.UserLoginAjaxForm.prototype.reloadPage();
						} else {
							window.location.reload();
						}
					}
				})
			});
		},

		doThreadChange: function (e) {
			e.preventDefault();
			var $target = $(e.target),
				id = $target.closest('li.message').attr('data-id'),
				newState = '';
			if ($target.hasClass('reopen-thread')) {
				newState = 'open';
			} else if ($target.hasClass('close-thread')) {
				newState = 'close';
			}
			if (id && newState) {
				this.doThreadChangeSendRequest(id, newState, {});
			}
		},

		editNotifyEveryone: function (e) {
			var $element = $(e.target),
				wallMsg,
				id;

			e.preventDefault();

			if ($element.attr('data-inprogress')) {
				return true;
			}

			wallMsg = $element.closest('li.message');
			id = wallMsg.attr('data-id');

			$element.animate({
				'opacity': 0.5
			}, 'slow');
			$element.attr('data-inprogress', true);

			this.model.notifyEveryone(wallMsg.attr('data-id'), $element.attr('data-dir'), function () {
				window.location.reload();
			});
		},

		quote: function (e) {
			e.preventDefault();

			var replyForm = this.replyMessageForm,
				message = $(e.target).closest('.message'),
				reply = message.find(replyForm.replyWrapper),
				quotedFrom = message.data('id'),
				formTarget,
				$editorPromise,
				$editorDeferred,
				$deferredQuote,
				$quotePromise;

			if (reply.length === 0) {
				reply = message.parent().find(replyForm.replyWrapper);
			}

			formTarget = reply.find(replyForm.replyBody);

			//scroll
			$('body').scrollTo(reply, {
				duration: 600
			});

			// start loading editor and get promise, or mock dummy promise
			if (typeof replyForm.initEditor === 'function') {
				$editorPromise = replyForm.initEditor({
					target: formTarget
				});
			} else {
				// dummy promise
				$editorDeferred = $.Deferred();
				$editorPromise = $editorDeferred.promise();
				$editorDeferred.resolve('');
			}

			// get formatted quote
			$deferredQuote = $.Deferred();
			$quotePromise = $deferredQuote.promise();

			$.nirvana.sendRequest({
				controller: 'WallExternalController',
				method: 'getFormattedQuoteText',
				format: 'json',
				data: {
					messageId: message.data('id'),
					convertToFormat: replyForm.editor && replyForm.editor.data('wikiaEditor') ?
						window.WikiaEditor.modeToFormat(replyForm.editor.data('wikiaEditor').mode) :
						'wikitext'
				},
				callback: function (data) {
					$deferredQuote.resolve(data);
				}
			});

			// merge two async operations here
			$.when($editorPromise, $quotePromise).done(function () {
				var data = arguments[1];
				if (data.status === 'success') {
					replyForm.setContent(reply, data.markup);
				}
			});

			reply.data('quotedFrom', quotedFrom);
		},

		handleEditTopics: function (e) {
			e.preventDefault();
			var rootMessageId = $(e.target).closest('.message').data('id');
			if (window.wgDisableAnonymousEditing && !window.wgUserName) {
				require(['AuthModal'], function (authModal) {
					authModal.load({
						forceLogin: true,
						origin: 'wall-and-forum',
						onAuthSuccess: this.proxy(function () {
							this.editTopics(rootMessageId);
						})
					});
				}.bind(this));
			} else {
				this.editTopics(rootMessageId);
			}
		},

		editTopics: function (rootMessageId) {
			var relatedTopics = $('.related-topics'),
				messageTopicEditSection = $('.message-topic-edit'),
				messageTopicSection = messageTopicEditSection.find('.message-topic'),
				topics = [],
				model = this.model,
				messageTopic;

			relatedTopics.hide();
			messageTopicEditSection.show();

			relatedTopics.find('.related-topic').each(function () {
				topics.push($(this).data('topic'));
			});

			messageTopic = messageTopicSection.data('messageTopic');

			if (messageTopic) {
				messageTopic.resetSelections(topics);
			} else {
				messageTopic = messageTopicSection.messageTopic({
					'topics': topics
				}).data('messageTopic');
				messageTopicEditSection
					.on('click.MessageTopic', '.save-button', function () {
						var buttons = messageTopicEditSection.find('button'),
							topics = messageTopic.getTopics();
						buttons.attr('disabled', true);
						model.updateTopics(rootMessageId, topics, function (json) {
							buttons.attr('disabled', false);
							relatedTopics.find('.related-topic').remove();
							relatedTopics.prepend($('#RelatedTopicTemplate').mustache({
								topics: json.topics
							}));
							relatedTopics.show();
							messageTopicEditSection.hide();
						});
					})
					.on('click.MessageTopic', '.cancel-button', function () {
						relatedTopics.show();
						messageTopicEditSection.hide();
					});
			}

			messageTopic.input.focus();

		},

		moveThread: function (e) {
			e.preventDefault();
			var id = $(e.target).closest('.message').data('id');

			$.nirvana.sendRequest({
				controller: 'WallExternalController',
				method: 'moveModal',
				format: 'html',
				type: 'POST',
				data: {
					id: id
				},
				callback: function (html) {
					require(['wikia.ui.factory'], function (uiFactory) {
						uiFactory.init(['modal']).then(function (uiModal) {
							var moveThreadModalConfig = {
								vars: {
									id: 'WallMoveModalWrapper',
									size: 'small',
									content: html,
									title: $.msg('wall-action-move-thread-heading'),
									buttons: [{
										vars: {
											classes: ['normal', 'primary'],
											value: $.msg('wall-action-move-thread-ok'),
											data: [{
												key: 'event',
												value: 'submit'
											}]
										}
									}, {
										vars: {
											value: $.msg('cancel'),
											data: [{
												key: 'event',
												value: 'close'
											}]
										}
									}]
								}
							};

							uiModal.createComponent(moveThreadModalConfig, function (moveThreadModal) {
								var form = new window.WikiaForm(moveThreadModal.$content.find('.WikiaForm'));

								moveThreadModal.bind('submit', function (event) {
									event.preventDefault();

									moveThreadModal.deactivate();
									$.nirvana.sendRequest({
										controller: 'WallExternalController',
										method: 'moveThread',
										format: 'json',
										type: 'POST',
										data: {
											destinationBoardId: moveThreadModal.$content
												.find('.destinationBoardId option:selected').val(),
											rootMessageId: id
										},
										callback: function (json) {
											if (json.status === 'ok') {
												Wikia.Querystring().addCb().goTo();
											} else if (json.status === 'error') {
												form.clearAllInputErrors();
												if (json.errorfield) {
													form.showInputError(json.errorfield, json.errormsg);
												} else {
													form.showGenericError(json.errormsg);
												}
												moveThreadModal.activate();
											}
										}
									});
								});

								moveThreadModal.show();
							});
						});
					});
				}
			});
		},

		proxy: function (func) {
			return $.proxy(func, this);
		}
	});

	// Global public settings
	Wall.settings = {
		classBindings: {}
	};

	// jQuery bridge
	$.fn.wikiaWall = function (settings) {
		return this.each(function () {
			$(this).data('Wall', new Wall(this, settings)).triggerHandler('WallInit', [this]);
		});
	};

	// Exports
	window.Wall = Wall;

})(window, jQuery);
