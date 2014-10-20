/* global wgAfterContentAndJS, wgArticleId, wgPageName, wgScript, MiniEditor, skin */

(function (window, $) {
	'use strict';

	// This file is included on every page.
	// If we aren't on an article page, halt execution here.
	// TODO: revisit this at some point when we have dependency loading.
	if (!window.wgIsArticle) {
		return;
	}

	var $window = $(window),
		ArticleComments;

	ArticleComments = {
		animations: {}, // Used by MiniEditor
		processing: false,
		mostRecentCount: 0,
		messagesLoaded: false,
		miniEditorEnabled: typeof window.wgEnableMiniEditorExt !== 'undefined' && skin === 'oasis',
		loadOnDemand: typeof window.wgArticleCommentsLoadOnDemand !== 'undefined',
		initCompleted: false,
		bucky: window.Bucky('ArticleComments'),

		init: function () {
			ArticleComments.bucky.timer.start('init');

			var $articleComments = $('#article-comments'),
				$articleCommFbMonit = $('#article-comm-fbMonit'),
				$fbCommentMessage = $('#fbCommentMessage'),
				newComment;

			// cache jQuery selector
			this.$commentsList = $('#article-comments-ul');
			this.$actionButtons = this.$wrapper.find('.actionButton');

			if (ArticleComments.miniEditorEnabled) {
				newComment = $('#article-comm');

				newComment.bind('focus', function () {
					ArticleComments.editorInit(this);
				});

				if (newComment.is(':focus')) {
					ArticleComments.editorInit(newComment);
				}
			}

			if (window.wgDisableAnonymousEditing && !window.wgUserName) {
				$('.article-comm-reply').hide();
			} else {
				$articleComments.on('click', '.article-comm-edit', ArticleComments.actionProxy(ArticleComments.edit));
				$articleComments.on('click', '.article-comm-reply', ArticleComments.actionProxy(ArticleComments.reply));
				$('#article-comm-submit').on(
					'click',
					{ source: '#article-comm' },
					ArticleComments.actionProxy(ArticleComments.postComment)
				);
			}

			$articleCommFbMonit.mouseenter(function () {
				$fbCommentMessage.fadeIn('slow');
			});

			$articleCommFbMonit.mouseleave(function () {
				$fbCommentMessage.fadeOut('slow');
			});

			ArticleComments.addHover();
			ArticleComments.initCompleted = true;

			ArticleComments.bucky.timer.stop('init');
		},

		actionProxy: function (callback) {
			return function (e) {
				e.preventDefault();

				// Prevent the action if MiniEditor is enabled and loading
				if (ArticleComments.miniEditorEnabled && MiniEditor.editorIsLoading) {
					$().log('Event cancelled because editor is loading: ', e);
					return true;
				}

				callback.apply(this, arguments);
			};
		},

		edit: function (e) {
			e.preventDefault();

			if (ArticleComments.processing) {
				return;
			}

			// If MiniEditor is enabled, we need to determine the correct content format before making the request
			if (ArticleComments.miniEditorEnabled && !MiniEditor.assetsLoaded) {
				MiniEditor.loadAssets(makeRequest);

			} else {
				makeRequest();
			}

			function makeRequest() {
				ArticleComments.bucky.timer.start('edit.makeRequest');
				var commentId = e.target.id.replace(/^comment/, ''),
					$textfield = $('#article-comm-textfield-' + commentId);

				$.getJSON(wgScript, {
					action: 'ajax',
					article: wgArticleId,
					convertToFormat: ArticleComments.getLoadConversionFormat($textfield),
					id: commentId,
					method: 'axEdit',
					rs: 'ArticleCommentsAjax'

				}, function (json) {
					if (!json.error) {
						var $buttons = $(e.target).closest('.buttons'),
							divFormSelector = '#article-comm-div-form-' + json.id,
							textfieldSelector = '#article-comm-textfield-' + json.id,
							$commentTextDiv = $('#comm-text-' + json.id).hide(),
							$editDivForm = $(divFormSelector),
							$blockquote = $commentTextDiv.parent(),
							$editTemplate = $(json.text).hide(),
							content = $editTemplate.find(textfieldSelector).val(),
							$textfield;

						// editForm has to be added to the DOM the first time we call this function
						if (!$editDivForm.length) {
							$blockquote.append($editTemplate.attr('id', divFormSelector.substr(1)));
							$editDivForm = $(divFormSelector);
						}

						$textfield = $(textfieldSelector);
						if (ArticleComments.miniEditorEnabled) {
							ArticleComments.editorInit($textfield, content, json.edgeCases);

						} else {
							$textfield.val(content);
						}

						$editDivForm.show();
						$buttons.hide();

						$('#article-comm-submit-' + json.id).bind('click', {
							id: json.id,
							emptyMsg: json.emptyMsg
						}, ArticleComments.actionProxy(ArticleComments.saveEdit));

						$('#article-comm-edit-cancel-' + json.id).bind('click', {
							id: json.id,
							target: e.target,
							text: json.text
						}, ArticleComments.actionProxy(ArticleComments.cancelEdit));
					}

					ArticleComments.processing = false;
					ArticleComments.bucky.timer.stop('edit.makeRequest');
				});
			}

			ArticleComments.processing = true;
		},

		cancelEdit: function (e) {
			var commentId = e.data.id;

			e.preventDefault();

			if (ArticleComments.miniEditorEnabled) {
				$('#article-comm-textfield-' + commentId).data('wikiaEditor').fire('editorDeactivated');
			}

			$('#article-comm-div-form-' + commentId).hide();
			$(e.data.target).closest('.buttons').show();
			$('#comm-text-' + commentId).show();
		},

		saveEdit: function (e) {
			var commentId, commentFormDiv, $throbber, $submitButton, $textfield, content;

			ArticleComments.bucky.timer.start('saveEdit');
			e.preventDefault();

			if (ArticleComments.processing) {
				return;
			}

			commentId = e.data.id;
			commentFormDiv = $('#article-comm-form-' + commentId);

			if (commentFormDiv.length) {
				$throbber = $(e.target).siblings('.throbber');
				$submitButton = $('#article-comm-submit-' + commentId);
				$textfield = $('#article-comm-textfield-' + commentId);
				content = ArticleComments.getContent($textfield);

				$submitButton.parent().find('.info').remove();

				if ($.trim(content) === '') {
					$submitButton.after($('<span>').addClass('info').html(e.data.emptyMsg));
					return;
				}

				$('#article-comm-info').html('');
				$throbber.css('visibility', 'visible');
				$textfield.attr('readonly', 'readonly');

				$.postJSON(wgScript, {
					action: 'ajax',
					article: wgArticleId,
					convertToFormat: ArticleComments.getSaveConversionFormat($textfield),
					id: commentId,
					method: 'axSave',
					rs: 'ArticleCommentsAjax',
					title: wgPageName,
					wpArticleComment: content

				}, function (json) {
					$throbber.css('visibility', 'hidden');

					if (!json.error) {
						if (json.commentId && json.commentId !== 0) {
							var comment = $('#comm-' + json.commentId),
								saveTemplate = $(json.text);

							$('#article-comm-div-form-' + json.commentId).hide();

							if (ArticleComments.miniEditorEnabled) {
								$textfield.data('wikiaEditor').fire('editorReset');
							}

							// Update DOM with information from saveTemplate
							comment.find('.article-comm-text')
								.html(saveTemplate.find('.article-comm-text').html()).show();
							comment.find('.edited-by').html(saveTemplate.find('.edited-by').html());
						}
					} else {
						$('#article-comm-info').html(json.msg);
					}

					$textfield.removeAttr('readonly');

					ArticleComments.processing = false;
					ArticleComments.bucky.timer.stop('saveEdit');
				});

				ArticleComments.processing = true;
			}
		},

		reply: function (e) {
			ArticleComments.bucky.timer.start('reply');
			e.preventDefault();

			if (ArticleComments.processing) {
				return;
			}

			$.getJSON(wgScript, {
				action: 'ajax',
				article: wgArticleId,
				id: $(this).closest('li').attr('id').replace(/^comm-/, ''),
				method: 'axReply',
				rs: 'ArticleCommentsAjax',
				title: wgPageName

			}, function (json) {
				var $blockquote = $('#comm-text-' + json.id).parent(),
					$editbox = $blockquote.find('.article-comm-edit-box'),
					$buttons = $blockquote.find('.buttons').hide(),
					$textfield;

				$blockquote.find('.info').remove();

				if ($editbox.length) {
					$editbox.show();

				} else if (!json.error) {
					$blockquote.append(json.html);

					$('#article-comm-reply-submit-' + json.id).bind('click', {
						source: '#article-comm-reply-textfield-' + json.id,
						parentId: json.id
					}, ArticleComments.actionProxy(ArticleComments.postComment));

					// Login required
				} else if (json.error === 2) {
					$blockquote.find('.tools').after($('<span>').addClass('info').html(json.msg));

					// General error. TODO: add caption
				} else {
					require(['wikia.ui.factory'], function (uiFactory) {
						uiFactory.init(['modal']).then(function (uiModal) {
							var moduleConfig = {
								vars: {
									id: 'general_error',
									size: 'small',
									content: json.msg
								}
							};
							uiModal.createComponent(moduleConfig, function (errorModal) {
								errorModal.show();
							});
						});
					});
				}

				$textfield = $('#article-comm-reply-textfield-' + json.id);
				if (ArticleComments.miniEditorEnabled) {
					ArticleComments.editorInit($textfield, {
						editorActivated: function () {
							$blockquote.find('.article-comm-edit-box').show();
						},
						editorDeactivated: function (event, wikiaEditor) {
							if (!wikiaEditor.getContent()) {
								$blockquote.find('.article-comm-edit-box').hide();
								$buttons.show();
							}
						}
					});

				} else {
					$textfield.focus();
				}

				ArticleComments.processing = false;
				ArticleComments.bucky.timer.stop('reply');
			});

			ArticleComments.processing = true;
		},

		postComment: function (e) {
			var $source, $target, $throbber, content, showall, data;
			e.preventDefault();

			if (ArticleComments.processing) {
				return;
			}

			$source = $(e.data.source);
			content = ArticleComments.getContent($source);

			if ($.trim(content) === '') {
				return;
			}

			$target = $(e.target);
			$throbber = $target.siblings('.throbber');
			showall = $.getUrlVar('showall');
			$throbber.css('visibility', 'visible');
			$source.attr('readonly', 'readonly');
			$target.attr('disabled', true);

			data = {
				action: 'ajax',
				article: wgArticleId,
				convertToFormat: ArticleComments.getSaveConversionFormat($source),
				method: 'axPost',
				rs: 'ArticleCommentsAjax',
				title: wgPageName,
				wpArticleComment: content
			};

			if (e.data.parentId) {
				data.parentId = e.data.parentId;
				data.page = $('.article-comments-pagination-link-active').eq(0).attr('page');
			}

			if (showall) {
				data.showall = 1;
			}

			function requestCallback(json) {
				var $parent, $subcomments, parentId, nodes;

				ArticleComments.bucky.timer.start('postComment.requestCallback');
				$throbber.css('visibility', 'hidden');

				if (ArticleComments.miniEditorEnabled) {
					$source.data('wikiaEditor').fire('editorReset');
				} else {
					$source.val('');
				}

				if (!json.error) {
					parentId = json.parentId;
					nodes = $(json.text);

					if (parentId) {
						//second level: reply
						$parent = $('#comm-' + parentId);
						$subcomments = $parent.next();

						if (!$subcomments.hasClass('sub-comments')) {
							$parent.after($subcomments = $('<ul class="sub-comments"></ul>'));
						}

						$subcomments.append(nodes);

						//remove input field and show buttons
						$parent.find('.article-comm-edit-box').hide();
						$parent.find('.buttons').show();
					} else {
						//first level: comment
						nodes.prependTo(ArticleComments.$commentsList);
					}

					//update counter
					$('#article-comments-counter-header').html($.msg('oasis-comments-header', json.counter));

					if (window.skin === 'oasis') {
						$('#WikiaPageHeader, #WikiaUserPagesHeader').find('.commentsbubble').html(json.counter);

						if (!parentId) {
							ArticleComments.mostRecentCount = ArticleComments.mostRecentCount ?
								ArticleComments.mostRecentCount + 1 :
								ArticleComments.$commentsList.children('li').length;

							$('#article-comments-counter-recent').html(
								$.msg('oasis-comments-showing-most-recent', ArticleComments.mostRecentCount)
							);
						}
					}

					//readd events
					ArticleComments.addHover();
					//clear error box
					$('#article-comm-info').html('');
				} else {
					//fill error box
					$('#article-comm-info').html(json.msg);
				}

				$source.removeAttr('readonly');
				$target.removeAttr('disabled');

				ArticleComments.processing = false;
				ArticleComments.bucky.timer.stop('postComment.requestCallback');
			}

			function makeRequest() {
				$.postJSON(wgScript, data, requestCallback);

				ArticleComments.processing = true;
			}

			if (!ArticleComments.messagesLoaded) {
				$.getMessages('ArticleCommentsCounter', function () {
					ArticleComments.messagesLoaded = true;
					makeRequest();
				});
			} else {
				makeRequest();
			}
		},

		setPage: function (e) {
			ArticleComments.bucky.timer.start('setPage');

			var page = parseInt($(this).attr('page'));

			e.preventDefault();

			ArticleComments.$commentsList.addClass('loading');

			$.getJSON(wgScript + '?action=ajax&rs=ArticleCommentsAjax&method=axGetComments&article=' + wgArticleId, {
				page: page,
				order: $('#article-comm-order').attr('value')

			}, function (json) {
				ArticleComments.$commentsList.removeClass('loading');

				if (!json.error) {
					ArticleComments.$commentsList.html(json.text);
					var $articleCommentsPagination = $('.article-comments-pagination');
					if ($articleCommentsPagination.exists()) {
						$articleCommentsPagination.html(json.pagination);
					}

					ArticleComments.addHover();
				}

				ArticleComments.processing = false;
				ArticleComments.bucky.timer.stop('setPage');
			});
		},

		addHover: function () {
			var linkSelectors = [
				'.article-comments-pagination-link-active',
				'#article-comments-pagination-link-prev',
				'#article-comments-pagination-link-next'
			];

			$('.article-comments-pagination-link')
				.bind('click', ArticleComments.setPage)
				.not(linkSelectors.join(', '))
				.hover(function () {
					$(this).addClass('accent');

				}, function () {
					$(this).removeClass('accent');
				});
		},

		// Used to initialize MiniEditor
		editorInit: function (element, events, content, edgeCases) {
			ArticleComments.bucky.timer.start('editorInit');
			var $element = $(element),
				wikiaEditor = $element.data('wikiaEditor'),
				editorActivated,
				hasEdgeCases;

			// Allow ommission of 'events' parameter
			if (typeof events === 'string') {
				edgeCases = content;
				content = events;
				events = {};
			}

			// Check for edge cases
			hasEdgeCases = $.isArray(edgeCases) && edgeCases.length;

			function initEditor() {
				events = events || {};

				// Wrap editorActivated with our own function
				editorActivated = events.editorActivated;
				events.editorActivated = function ( /* event, wikiaEditor */ ) {
					ArticleComments.$actionButtons.removeClass('disabled').removeAttr('disabled');

					if ($.isFunction(editorActivated)) {
						editorActivated.apply(this, arguments);
					}
				};

				// Initialize the editor
				$element.miniEditor({
					config: {
						animations: MiniEditor.Wall.Animations,
						mode: hasEdgeCases ? 'source' : MiniEditor.config.mode
					},
					events: events
				});
			}

			// Already exists
			if (wikiaEditor) {
				wikiaEditor.fire('editorActivated');

				if (content !== undefined) {

					// Force source mode if edge cases are found.
					if (hasEdgeCases) {
						wikiaEditor.ck.setMode('source');
					}

					wikiaEditor.setContent(content);
				}

				// Needs initializing
			} else {
				ArticleComments.$actionButtons.addClass('disabled').attr('disabled', true);

				// Set content on element before initializing to keep focus in editbox (BugId:24188).
				if (content !== undefined) {
					$element.val(content);
				}

				// Load assets first so we have the proper config.mode (BugId:25182)
				if (!MiniEditor.assetsLoaded) {
					MiniEditor.loading($element);
					MiniEditor.loadAssets(initEditor);

				} else {
					initEditor();
				}
			}
			ArticleComments.bucky.timer.stop('editorInit');
		},

		getContent: function (element) {
			return ArticleComments.miniEditorEnabled ? element.data('wikiaEditor').getContent() : element.val();
		},

		getLoadConversionFormat: function (element) {
			return ArticleComments.miniEditorEnabled ? MiniEditor.getLoadConversionFormat(element) : '';
		},

		getSaveConversionFormat: function (element) {
			return ArticleComments.miniEditorEnabled ? MiniEditor.getSaveConversionFormat(element) : '';
		},

		scrollToElement: function (element) {
			var $element = $(element),
				docViewTop = $window.scrollTop(),
				docViewBottom = docViewTop + $window.height(),
				elementTop = $element.offset().top;

			$element.find('blockquote').addClass('current');

			if (elementTop < docViewTop || elementTop > docViewBottom) {
				$('html, body').animate({
					scrollTop: elementTop
				}, 1);
			}
		}
	};

	if (ArticleComments.loadOnDemand) {
		$(function () {
			var content, hash, permalink, styleAssets, belowTheFold, loadAssets;

			ArticleComments.$wrapper = $('#WikiaArticleComments');

			// NO article comment on this page lets just skip
			if (!ArticleComments.$wrapper.length) {
				return;
			}

			hash = window.location.hash;
			permalink = /^#comm-/.test(hash);
			// TODO: we should be able to load it this way
			//styleAssets.push($.getAssetManagerGroupUrl(
			// 'articlecomments' + (ArticleComments.miniEditorEnabled ? '_mini_editor' : '') + '_scss'));
			styleAssets = [$.getSassCommonURL('skins/oasis/css/core/ArticleComments.scss')];
			belowTheFold = function () {
				return ArticleComments.$wrapper.offset().top >= ($window.scrollTop() + $window.height());
			};

			if (ArticleComments.miniEditorEnabled) {
				styleAssets.push($.getSassCommonURL('extensions/wikia/MiniEditor/css/MiniEditor.scss'));
				styleAssets.push($.getSassCommonURL(
					'extensions/wikia/MiniEditor/css/ArticleComments/ArticleComments.scss'));
			}

			loadAssets = function () {
				ArticleComments.bucky.timer.start('loadAssets');
				$.when(
					$.getResources(styleAssets),
					$.nirvana.sendRequest({
						controller: 'ArticleCommentsController',
						method: 'Content',
						format: 'html',
						type: 'GET',
						data: {
							articleId: window.wgArticleId,
							page: ArticleComments.$wrapper.data('page'),
							skin: true
						},
						callback: function (response) {
							content = response;
						}
					})
				).then(function () {
					ArticleComments.$wrapper.removeClass('loading').html(content);

					ArticleComments.init();

					if (permalink) {
						ArticleComments.scrollToElement(hash);
					}
					ArticleComments.bucky.timer.stop('loadAssets');
				});
			};

			// Load comments as they become visible (unless we are requesting a permalink comment)
			if (!permalink && belowTheFold()) {
				$window.on('scrollstop.ArticleCommentsLoadOnDemand', function () {
					if (!belowTheFold()) {
						ArticleComments.$wrapper.addClass('loading');
						$window.off('scrollstop.ArticleCommentsLoadOnDemand');
						loadAssets();
					}
				});

				// Comments are already visible, load them now
			} else {
				loadAssets();
			}
		});

	} else {
		wgAfterContentAndJS.push(ArticleComments.init);
	}

	// Exports
	window.ArticleComments = ArticleComments;

})(this, jQuery);
