$(document).ready(function() {
	if( $('#Wall').exists()) {
		var wall = new Wall();
	}
});

//var global_hide = 0;

var Wall = $.createClass(Object, {
	constructor: function() {
		this.settings = {};
		this.hoverTimer = {};
		this.deletedMessages = {};
		this.settings.new_title = {min: 30, minFocus:30, minContent: 30, limit: 300, limitEmpty: 30, extraSpace: 15};
		this.settings.new_body = {minFocus:100, minContent: 100, limit: 9999, limitEmpty: 70, extraSpace: 30};
		this.settings.edit_title = {min: 30, minFocus:30, minContent: 30, limit: 300, limitEmpty: 30, extraSpace: 0};
		this.settings.edit_body = this.settings.new_body;
		this.settings.reply = {minFocus:100, minContent: 100, limit: 9999, limitEmpty: 30, extraSpace: 30};
		
		$("#WikiaArticle")
			.bind('afterWatching', this.proxy(this.onWallWatch))
			.bind('afterUnwatching', this.proxy(this.onWallUnwatch) );
		
		// Submit new wall post
		$('.wall-require-login').live('click', this.proxy(this.onAfterAjaxLogin));
		$('.wall-reply-require-login').live('click', this.proxy(this.onAfterAjaxLogin));
		$('#WallMessageSubmit').bind('click', this.proxy(this.postNewMessage));
		$('#WallMessagePreview').bind('click', this.proxy(this.previewNewMessage));
		$('#WallMessagePreviewCancel').bind('click', this.proxy(this.cancelPreviewNewMessage));
		
		// New wall post change
		$('#WallMessageTitle, #WallMessageBody')
			.keydown(this.proxy(this.postNewMessage_ChangeText_pre))
			.keyup(this.proxy(this.postNewMessage_ChangeText_pre))
			.change(this.proxy(this.postNewMessage_ChangeText_pre))
			.focus(this.proxy(this.postNewMessage_focus))
			.blur(this.proxy(this.postNewMessage_blur));
			
		$('#WallMessageTitle')
			.keydown(function(e) { if(e.which == 13) {$('#WallMessageBody').focus(); return false; }})
			.autoResize(this.settings.new_title)
			.click(this.proxy(function() {
				this.track('wall/new_message/subject_field');
			}));
		$('#WallMessageBody')
			.keydown(function(e) {
				if ( e.which == 9 && e.shiftKey ) {
					e.preventDefault();
					$('#WallMessageTitle').focus();
					return false;
				}
			 })
			.autoResize(this.settings.new_body)
			.click(this.proxy(function() {
				this.track('wall/new_message/body');
			}));

		// Reply focus, blur, and reply events
		$('.new-reply textarea')
			.bind('keydown keyup change', this.proxy(this.reply_ChangeText))
			.live('focus', this.proxy(this.replyFocus))
			.live('blur', this.proxy(this.replyBlur))
			.autoResize(this.settings.reply)
			.click(this.proxy(function() {
				this.track('wall/message/reply_field');
			}));
		$('.replyButton').live('click', this.proxy(this.replyToMessage));
		$('.replyPreview').live('click', this.proxy(this.replyToMessagePreview));
		$('.replyPreviewCancel').live('click', this.proxy(this.replyToMessagePreviewCancel));
		
		// Delete
		$('#Wall .admin-delete-message').live('click', this.proxy(this.confirmAction));
		$('#Wall .delete-message').live('click', this.proxy(this.confirmAction));
		
		//Remove
		$('#Wall .remove-message').live('click', this.proxy(this.confirmAction));
		
		//Restore
		$('#Wall .message-restore').live('click', this.proxy(this.confirmAction));
		
		//View source
		$('#Wall .source-message').live('click', this.proxy(this.viewSource));
		
		// Edit
		$('#Wall .edit-message').live('click', this.proxy(this.editMessage));
		$('#Wall .cancel-edit').live('click', this.proxy(this.cancelEdit));
		$('#Wall .save-edit').live('click', this.proxy(this.saveEdit));
		
		$('#Wall .message-undo-remove').live('click', this.proxy(this.undoRemoveOrAdminDelete));

		
		//$('#Wall .preview-edit').live('click', this.proxy(this.previewEdit));
		//$('#Wall .cancel-preview-edit').live('click', this.proxy(this.cancelPreviewEdit));
		
		// Pagination
		$('.Pagination a').live('click', this.proxy(this.switchPage));

		$('.load-more a').live('click', this.proxy(this.loadMore));
		
		// Make timestamps dynamic
		$('.timeago').timeago();
		
		$('#Wall .follow.wikia-button')
			.live('click', this.proxy(this.switchWatch))
			.live('mouseenter', this.proxy(this.hoverFollow))
			.live('mouseleave', this.proxy(this.unhoverFollow));
		
		// If any textarea has content make sure Reply / Post button is visible
		$(document).ready(this.initTextareas);
		
		if(wgTitle.indexOf('/') > 0) {
			var titlePart = wgTitle.split('/');
			this.username = titlePart[0]; 
		} else {
			this.username = wgTitle;
		}
		
		//click tracking
		$('.user-talk-archive-anchor').click(this.proxy(this.trackClick) );
		$('.edited-by a').live( 'click', this.proxy(this.trackClick) );
		$('.timeago-fmt').live( 'click', this.proxy(this.trackClick) );
		$('.username').live( 'click', this.proxy(this.trackClick) );
		$('.avatar').live( 'click', this.proxy(this.trackClick) );
		$('.Pagination').live( 'click', this.proxy(this.trackClick) );
		$('.wall-owner').click(this.proxy(this.trackClick));
		$('.load-more a').click(this.proxy(this.trackClick));
		$('.msg-title').click(this.proxy(this.trackClick));
		$('.sortingOption').click(this.proxy(this.trackClick));
		
		// fix firefox bug (when textarea is disabled and you refresh a page
		// it's still disabled on new page loaded
		$('textarea').removeAttr('disabled');
		
		$("#Wall textarea").live('keydown', this.proxy(this.focusButton) );
		
		/*
		 * commented out - functionality temporary taken out (mark msg as read when scrolling)
		 */
		/*
		this.seenCommentStart = {}; // user saw start of a thread (within browser window)
		this.seenCommentEnd = {};   // user saw end of a thread (within browser window)
		this.seenCommentSend = {};   // mark after sending (no repeats)
		$(document).scroll( this.proxy(this.scrollEvent) );
		*/
		
		$().log(this.username, "Wall username");
		
		$(window).bind('hashchange', this.proxy(this.onHashChange) );
		this.onHashChange();
	},
	
	proxy: function(func) {
		return $.proxy(func, this);
	},
	
	onHashChange: function() {
		if(window.location.hash) {
			var number = parseInt(window.location.hash.substr(1));
			$('li.message-' +  number ).removeClass('hide').addClass('show');
		}
	},
	
	onWallWatch: function(e) {
		$('.SpeechBubble .follow.wikia-button').fadeOut();
	},
	
	onWallUnwatch: function(e) {
		$('.SpeechBubble .follow.wikia-button').fadeIn();
	},
	
	//hack for safari tab index
	focusButton: function(e) {
		if(e.keyCode == 9 && !e.shiftKey) {
			var element = $(e.target);
			var button = element.closest('.SpeechBubble')
				.find('button#WallMessageSubmit,.save-edit,.replyButton').first();
			if(element.attr('id') != 'WallMessageTitle' && !element.hasClass('title')) {
				button.focus();
				e.preventDefault();
			}
		}
	},
	
	initTextareas: function() {
		setTimeout( function() { // make sure all textareas are inicialized already
			//$('.new-message textarea.body').trigger('focus');
			$('.new-reply textarea').each( function() {
				if( $(this).is(':focus') ) $(this).trigger('focus');
			});
			var title = $('#WallMessageTitle');
			if( title.is(':focus') ) title.trigger('focus');
			var body = $('#WallMessageBody');
			if( body.is(':focus') ) body.trigger('focus');
		}, 50);
	},

	switchWatch: function(e) {
		var element = $(e.target);
		var isWatched = parseInt(element.attr('data-iswatched'));
		var commentId = element.closest('li').attr('data-id');
		
		element.animate({'opacity':0.5},'slow');
		$.nirvana.sendRequest({
			controller: 'WallExternalController',
			method: 'switchWatch',
			format: 'json',
			data: {
				isWatched: isWatched,
				commentId: commentId
			},
			callback: this.proxy(function(data) {
				if(data.status) {
					element.attr('data-iswatched', isWatched ? 0:1);
					if(isWatched) {
						element.animate({'opacity':0.7},'slow', function() { element.css('opacity','');} );
						$(e.target).text($.msg('wall-message-follow')).addClass('secondary');
						
						//click tracking
						this.track('wall/message/unfollow');
					} else {
						element.animate({'opacity':0.7},'slow', function() { element.css('opacity','');} );
						$(e.target).text($.msg('wall-message-following')).removeClass('secondary');
						
						//click tracking
						this.track('wall/message/follow');
					}
				}}
			)
		});
	},
	
	switchPage: function(e) {
		e.preventDefault();
		var page = $(e.target).closest('li').attr('data-page');
		e.preventDefault();
		this._switchPage(page, 0.5);
	},
	
	_switchPage: function(page, fadeopacity) {
		$('#Wall .comments').animate({'opacity':fadeopacity},'slow');

		$.nirvana.sendRequest({
			controller: 'WallExternalController',
			method: 'getCommentsPage',
			format: 'json',
			data: {
				page: page,
				username: this.username
			},
			callback: this.proxy(function(data) {
				var newhtml = $(data.html);
				$('#Wall .comments').html($('.comments',newhtml).html()).animate({'opacity':1},'slow');
				$('#Wall .Pagination').html($('.Pagination',newhtml).html());
				
				var destination = $('#Wall').offset().top;
				if($.browser.msie) {
					$("html:not(:animated),body:not(:animated)").css({ scrollTop: destination-20});
				} else {
					$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination-20}, 500 );
				}
				
				setTimeout(this.proxy(function() {
					$('#Wall').find('textarea,input').placeholder();
					$('.timeago').timeago();
					$('.new-reply textarea')
						.bind('keydown keyup change', this.proxy(this.reply_ChangeText))
						.autoResize(this.settings.reply);
				}), 100);				
			})
		});
	},
	
	hoverFollow: function(e) {
		if( $(e.target).html() == $.msg('wall-message-following') ) {
			$(e.target).html($.msg('wall-message-unfollow'));
		}
	},
	
	unhoverFollow: function(e) {
		if( $(e.target).html() == $.msg('wall-message-unfollow') ) {
			$(e.target).html($.msg('wall-message-following'));
		}
	},
	
	loadMore: function(e) {
		e.preventDefault();
		
		$(e.target).closest('ul').find('li.SpeechBubble').show();
		$(e.target).closest('.load-more').remove();
		
		var comment_id = $(e.target).closest('li.message').attr('data-id');
		$.nirvana.sendRequest({
			controller: 'WallNotificationsExternalController',
			method: 'markAsRead',
			format: 'json',
			data: { id: comment_id },
			callback: function(data) { }
		});
			
	},

	/*
	 * Message functions
	 */
	postNewMessage: function(href) {
		var topic = !$('#WallMessageTitle').hasClass('placeholder') && $('#WallMessageTitle').val().length > 0;

		if(!topic && $('#WallMessageSubmit').html() != $.msg('wall-button-to-submit-comment-no-topic')) {
			this.cancelPreviewNewMessage();
			$('#WallMessageSubmit').html($.msg('wall-button-to-submit-comment-no-topic'));
			$('.new-message .no-title-warning').fadeIn();
			$('.new-message input').addClass('no-title');
			return;
		}
		
		if( $('#WallMessageSubmit').hasClass('wall-require-login') ) {
		//do nothing -- ajax combo box will take care of it starting from now
			return;
		}
		
		this.disableNewMessage();
		
		// are we on 1st page? (Pagination)
		if( $('#Wall .Pagination .first').length == 0 || $('#Wall .Pagination .first').hasClass('selected') ) {
			// we are all good - no need to force pagination
		} else {
			// let's force pagination - to post new msg on the top of 1st page
			var destination = $('#Wall').offset().top;
			if($.browser.msie) {
				$("html:not(:animated),body:not(:animated)").css({ scrollTop: destination-20});
			} else {
				$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination-20}, 500 );
			}
			this._switchPage( 1, 0 ); // switch to page 1, fade to 0 opacity on animate
		}
		
		$.nirvana.sendRequest({
			controller: 'WallExternalController',
			method: 'postNewMessage',
			data: {
				body: $('#WallMessageBody').val(),
				messagetitle: topic ? $('#WallMessageTitle').val() : '',
				username: this.username
			},
			callback: this.proxy(function(data) {
				this.cancelPreviewNewMessage();
				$('#WallMessageBody').val("").trigger('blur');
				$('#WallMessageTitle').val("").trigger('blur');
				var newmsg = $(data['message']);
				
				if(window.skin && window.skin != "monobook") {
					WikiaButtons.init(newmsg);
				}
				
				$('#Wall .comments').prepend(newmsg);
				if(!$.browser.msie) { // IE is too slow for that (even IE8)
					newmsg.hide()
						.css('opacity',0)
						.slideDown('slow')
						.animate({'opacity':1},'slow');
				}
				$('.timeago',newmsg).timeago();
				$('.new-reply textarea', newmsg).bind('keydown keyup change', this.proxy(this.reply_ChangeText))
				$('textarea', newmsg).autoResize(this.settings.reply).placeholder();
				
				this.enableNewMessage();
				$('.new-message .speech-bubble-message').css({'padding-bottom':10});
				$('#WallMessageSubmit').hide();
				
				if( typeof(href) == 'string' ) {
					window.location.href = href;
				}
				
				//click tracking
				if( !topic ) {
					this.track('wall/new_message/post_without_title');
				} else {
					this.track('wall/new_message/post');
				}
			})
			
		});
	},
	
	undoRemoveOrAdminDelete: function(e) {
		var target = $(e.target);
		var id = target.attr('data-id');
		$.nirvana.sendRequest({
			controller: 'WallExternalController',
			method: 'undoAction',
			data: {
				msgid: id 
			},
			callback: this.proxy(function(data) {
				var msg = target.closest('li');
				msg.fadeOut('fast', this.proxy(function() {
					if(this.deletedMessages[id]) {
						msg.remove();
						this.deletedMessages[id].fadeIn('slow');
					}
				}));
			})
		});
	},	
	
	doRestor: function(id, target, formdata) {
		$.nirvana.sendRequest({
			controller: 'WallExternalController',
			method: 'restoreMessage',
			data: {
				msgid: id,
				formdata: formdata
			},
			callback: this.proxy(function(data){
				this.afterRestore(data, target);
			})
		});
	},
	
	afterRestore: function(data, target) {
		var msg = target.closest('li');
		
		if(msg.attr('is-reply') != 1 ) {
			$('#WallBrickHeader .TitleRemoved').hide();
			$('.SpeechBubble.new-reply').show();
		}
		
		if(data.buttons) {
			var buttonswrap = msg.find('.buttonswrapper:first');
			buttonswrap.html(data.buttons);
			if( window.skin && window.skin != "monobook" ) {
				WikiaButtons.init(buttonswrap);
			}
		}
	
		var placeholder = msg.find('.deleteorremove-infobox:first');
		if(placeholder.exists()) {
			placeholder.html('');
			placeholder.addClass('empty');
			return true;
		}
	
		if(data.buttons) {
			var buttons = msg.find('.buttonswrapper:first');
			buttons.html('');
			$().log(data.buttons);
		}
		
		msg.fadeOut('fast', this.proxy(function() {
			if(this.deletedMessages[id]) {
				msg.remove();
				this.deletedMessages[id].fadeIn('slow');
			}
		}));
	},
	
	previewNewMessage: function() {
		var topic = !$('#WallMessageTitle').hasClass('placeholder') && $('#WallMessageTitle').val().length > 0;
		
		$.nirvana.sendRequest({
			controller: 'WallExternalController',
			method: 'previewMessage',
			data: {
				body: $('#WallMessageBody').val(),
				messagetitle: topic ? $('#WallMessageTitle').val() : '',
				username: this.username
			},
			callback: this.proxy(function(data) {
				$('#WallMessageBody').hide();
				$('#WallMessageTitle').hide();
				
				var newmsg  = $('.new-message .speech-bubble-message');
				newmsg.addClass('preview-bubble');
				var preview = $('<div class="preview"></div>' );
				preview.append( '<div class="preview-title">'+data['title']+'</div>' );
				preview.append( '<div class="edited-by"><a>'+data['displayname']+'</a><a class="subtle">'+data['displayname2']+'</a></div>' );
				preview.append( '<div class="preview-body">' +data['body']+'</div>' );
				$('.new-message .preview').remove();
				
				preview.prependTo(newmsg);
				
				$('#WallMessagePreviewCancel').show();
				$('#WallMessagePreview').hide();
			})
			
		});
	},	

	cancelPreviewNewMessage: function() {
		var newmsg  = $('.new-message .speech-bubble-message');
		newmsg.removeClass('preview-bubble');
		
		$('#WallMessageBody').show();
		$('#WallMessageTitle').show();
		
		$('.new-message .speech-bubble-message .preview').remove();
		
		$('#WallMessagePreviewCancel').hide();
		$('#WallMessagePreview').show();
	},	
	
	onAfterAjaxLogin: function(e) {
		var event = e;
				
		if( UserLoginModal.show({
				callback: this.proxy(function() {
					var eventTarget = $(event.target),
						wallReply = false,
						wallPost = false;
					
					if( eventTarget.hasClass('wall-require-login') ) {
						if( eventTarget.hasClass('replyButton') ) {
							wallReply = true;
						} else {
							wallPost = true;
						}
						
						eventTarget.removeClass('wall-require-login');
					}
					
					var href = eventTarget.attr('data');
					if( wallPost && href ) {
						this.postNewMessage(href);
					} else if(wallReply && href) {
						this.replyToMessage(event, href);
					}
				}) //this.proxy()
			}) //UserLoginModal.show()
		) {
			event.preventDefault();
		}
	},
	
	postNewMessage_ChangeText_pre: function(e) {
		var trg = $(e.target);
		if(trg.hasClass('title')) {
			var topic_str = trg.val();
			var topic_len = topic_str.length;
			if(topic_len >= 200) trg.val( topic_str.slice(0,200) );
		}
		setTimeout( this.proxy(this.postNewMessage_ChangeText), 50 );
	},
	
	postNewMessage_ChangeText: function() {
		// check if both topic and content are filled
		var topic_str = $('#WallMessageTitle').val();
		var topic_len = topic_str.length;
		var topic = !$('#WallMessageTitle').hasClass('placeholder') && topic_len > 0;
		var content = !$('#WallMessageBody').hasClass('placeholder');
		content =  content && $('#WallMessageBody').val().length > 0;
		if(content) {
			$('#WallMessageSubmit').removeAttr('disabled');
			$('#WallMessagePreview').removeAttr('disabled');
		} else {
			$('#WallMessageSubmit').attr('disabled','disabled');
			$('#WallMessagePreview').attr('disabled','disabled');
		}
		if(topic && $('#WallMessageSubmit').html() == $.msg('wall-button-to-submit-comment-no-topic')) {
			$('#WallMessageSubmit').html($.msg('wall-button-to-submit-comment'));
			$('.new-message .no-title-warning').fadeOut('fast');
			$('#WallMessageTitle').removeClass('no-title');
		}
	},

	postNewMessage_focus: function(e) {
		$('#WallMessageSubmit').show();
		$('#WallMessagePreview').show();
		$('.new-message .speech-bubble-message').css({'padding-bottom':45});
		//if($(e.target).hasClass('title'))
		//	$(e.target).css('line-height','170%');
		if($(e.target).hasClass('body'))
			$('.new-message textarea.body').css('font-size','13px');
	},

	postNewMessage_blur: function() {
		//topic = !$('.new-message textarea.title').hasClass('placeholder') && $('.new-message textarea.title').val().length > 0;
		var content = !$('#WallMessageBody').hasClass('placeholder');
		content = content && $('#WallMessageBody').val().length > 0;
		if(!content) {
			$('#WallMessageSubmit').attr('disabled', 'disabled').hide();
			$('#WallMessagePreview').attr('disabled', 'disabled').hide();
			$('.new-message .speech-bubble-message').css({'padding-bottom':10});
			$('.new-message textarea.body').css('font-size','14px');
		}
		/*if(!title) {
			$('.new-message textarea.title:focus').css('line-height','normal');
		}*/
	},

	disableNewMessage: function() {
		$('#WallMessageSubmit, #WallMessagePreview, .new-message textarea').attr('disabled', 'disabled');
		$('.new-message .loadingAjax').show();
		$('.new-message .speech-bubble-message').addClass('loading');
	},

	enableNewMessage: function() {
		$('#WallMessageSubmit, #WallMessagePreview, .new-message textarea').removeAttr('disabled');
		$('#WallMessageSubmit, #WallMessagePreview').fadeOut('fast');
		$('#WallMessageSubmit').html($.msg('wall-button-to-submit-comment'));
		$('.new-message .no-title-warning').fadeOut('fast');
		$('#WallMessageTitle').removeClass('no-title');
		$('.new-message .loadingAjax').hide();
		$('.new-message .speech-bubble-message').removeClass('loading');
	},
	
	previewEdit: function(e) {
		e.preventDefault();
		
		var el = $(e.target).closest('.message');
		var isreply = el.attr('data-is-reply');
		el = $('.speech-bubble-message',el).first();
		
		var topic = null;
		if($('textarea.title',el).length>0)
			topic = !$('textarea.title',el).not('textarea[tabindex=-1]').hasClass('placeholder') && $('textarea.title',el).not('textarea[tabindex=-1]').val().length > 0;
		
		$.nirvana.sendRequest({
			controller: 'WallExternalController',
			method: 'previewMessage',
			data: {
				body: $('textarea.body',el).not('textarea[tabindex=-1]').val(),
				messagetitle: topic ? $('textarea.title',el).not('textarea[tabindex=-1]').val() : '',
				username: this.username
			},
			callback: this.proxy(function(data) {
				$('.msg-title, .edited-by, .msg-body',el).hide();
				el.addClass('preview-bubble');
				
				var preview = $('<div class="preview"></div>' );
				if(!isreply)
					preview.append( '<div class="preview-title">' +data['title']+'</div>' );
				preview.append( '<div class="edited-by"><a>'+data['displayname']+'</a><a class="subtle">'+data['displayname2']+'</a></div>' );
				preview.append( '<div class="preview-body">' +data['body']+'</div>' );
				$('.preview',el).remove();
				preview.prependTo(el);
				
				$('.preview-edit',el.parent()).hide();
				$('.cancel-preview-edit',el.parent()).show();
			})

		});
	},
	
	cancelPreviewEdit: function(e) {
		e.preventDefault();
		
		var el = $(e.target).closest('.message');
		el = $('.speech-bubble-message',el).first();
		el.removeClass('preview-bubble');
		
		$('.preview', el).remove();
		$('.msg-title, .edited-by, .msg-body').show();
		$('.preview-edit', el.parent()).show();
		$('.cancel-preview-edit', el.parent()).hide();
	},

	editMessage: function(e) {
		e.preventDefault();
		this.editOrSource(e, 'edit');
	},
	
	viewSource: function(e) {
		e.preventDefault();
		this.editOrSource(e, 'source');
	},
	
	editOrSource: function(e, mode) {
		var msg = $(e.target).closest('li.message');
		var id = msg.attr('data-id');
		var isreply = msg.attr('data-is-reply');
		 
		$('.buttons' ,msg).first().hide();
		msg.find('.wikia-menu-button').removeClass("active");
		
		var data = {
			'msgid': id,
			'isreply': isreply,
			'username': this.username
		};
		
		$.nirvana.sendRequest({
			controller: 'WallExternalController',
			method: 'editMessage',
			format: 'json',
			data: data,
			callback: this.proxy(function(data) {
				if(data.status == false && data.forcereload == true) {
					var url = window.location.href;
					if (url.indexOf('#') >= 0) {
						url = url.substring( 0, url.indexOf('#') );
					}
					window.location.href = url + '?reload=' + Math.floor(Math.random()*999);
				}
				
				var bubble = $('.speech-bubble-message', msg).first();
				
				var beforeedit = bubble.html();
				
				var editbuttons = $('<div class="edit-buttons"></div>');
				if(mode != 'source') {
					$('<button class="wikia-button save-edit">'+$.msg('wall-button-save-changes')+'</button>').appendTo(editbuttons);
					//$('<button class="wikia-button preview-edit secondary">'+$.msg('wall-button-to-preview-comment')+'</button>').appendTo(editbuttons);
					//	$('<button class="wikia-button cancel-preview-edit secondary" style="display: none;">'+$.msg('wall-button-to-cancel-preview')+'</button>').appendTo(editbuttons);
					$('<button class="wikia-button cancel-edit secondary">'+$.msg('wall-button-cancel-changes')+'</button>').appendTo(editbuttons);
					$('.msg-title', msg).first().html('<textarea class="title">'+$('.msg-title a', msg).html()+'</textarea>');
				} else {
					$('<button class="wikia-button cancel-edit">'+$.msg('wall-button-done-source')+'</button>').appendTo(editbuttons);
					$('.edited-by', msg).append($('<span class="sourceview subtle">'+$.msg('wall-message-source')+'</span>'));
				}
				
				$('.msg-body', msg).first().html('<textarea  ' + (mode == 'source' ? 'readonly="readonly"':'') + ' class="body">'+data.wikitext+'</textarea>');
				$('.follow', msg).hide();
				$('textarea.title', msg).first()
					.keydown(function(e) { if(e.which == 13) { return false; }})
					.autoResize(this.settings.edit_title).trigger('change');
				$('textarea.body', msg).first().focus().autoResize(this.settings.edit_body).trigger('change');
				
				bubble.append(editbuttons);
				bubble.append( $('<div class="before-edit"></div>').html(beforeedit) );
				
				//click tracking
				this.track('wall/message/action/edit');
			})
			
		});
		
	},
	
	cancelEdit: function(e) {
		e.preventDefault();
		
		this.cancelPreviewEdit(e);

		var msg = $(e.target).closest('.message');
		
		var beforeedit = $('.before-edit', msg).html();
		
		$('.sourceview', msg).remove();
		
		/* restore html to state from before edit */
		var bubble = $('.speech-bubble-message',msg);
		bubble.first().html(beforeedit);
		$('.buttons', msg).first().show();
		
		if( window.skin && window.skin != "monobook" ) {
			WikiaButtons.init(bubble);
		}
		
		//click tracking
		this.track('wall/message/edit/cancel');
	},
	
	saveEdit: function(e) {
		var msg = $(e.target).closest('li.message'),
			id = msg.attr('data-id'),
			isreply = msg.attr('data-is-reply'),
			newtitle = $('.msg-title textarea.title', msg).val(),
			newbody = $('.msg-body textarea.body', msg).val(),
			data = {
				msgid: id,
				newtitle: newtitle,
				newbody: newbody,
				isreply: isreply,
				username: this.username
			};
		
		$.nirvana.sendRequest({
			controller: 'WallExternalController',
			method: 'editMessageSave',
			format: 'json',
			data: data,
			callback: this.proxy(function(data) {
				this.cancelPreviewEdit(e);
				var beforeedit = $('.before-edit', msg).html(),
					bubble = $('.speech-bubble-message', msg).first();
				
				$('.speech-bubble-message', msg).first().html(beforeedit);
				$('.msg-title', msg).first().html(data.msgTitle);
				$('.msg-body', msg).first().html(data.body);
				
				//click tracking
				var timestamp = $(bubble).find('.timestamp');
				
				var editor = timestamp.find('.username');
				if(editor.exists()) {
					timestamp.find('.username').html(data.username).attr('href', data.userUrl);
				} else {
					timestamp.prepend($($.msg('wall-message-edited', data.userUrl, data.username, data.historyUrl)));
				}
				
				timestamp.find('.timeago').attr('title', data.isotime).timeago();
				timestamp.find('.timeago-fmt').html(data.fulltime);
				
				if(window.skin && window.skin != "monobook") {
					WikiaButtons.init(msg);
				}
				
				//$('.SpeechBubble .timestamp .permalink') 
				$('.buttons', msg).first().show();
				this.track('wall/message/edit/save_changes');
			})
		});
	},

	/*
	 * Reply functions
	 */
	replyToMessagePreview: function(e) {
		var el = $(e.target).closest('.new-reply');
		el = $('.speech-bubble-message',el);

		$.nirvana.sendRequest({
			controller: 'WallExternalController',
			method: 'previewMessage',
			data: {
				body: $('textarea.content', el).val(),
				messagetitle: '',
				username: this.username
			},
			callback: this.proxy(function(data) {
				$('textarea.content').hide();
				el.addClass('preview-bubble');
				
				var preview = $('<div class="preview"></div>' );
				preview.append( '<div class="edited-by"><a>'+data['displayname']+'</a><a class="subtle">'+data['displayname2']+'</a></div>' );
				preview.append( '<div class="preview-body">' +data['body']+'</div>' );
				$('.preview',el).remove();
				preview.prependTo(el);
				
				$('.replyPreviewCancel',el.parent()).show();
				$('.replyPreview',el.parent()).hide();
			})

		});
	},	
	
	replyToMessagePreviewCancel: function(e) {
		var el = $(e.target).closest('.new-reply');
		$('.speech-bubble-message',el).removeClass('preview-bubble');
		$('textarea.content',el).show();
		
		$('.speech-bubble-message .preview',el).remove();
		
		$('.replyPreview',el).show();
		$('.replyPreviewCancel',el).hide();
	},	
	
	
	replyToMessage: function(e, href) {
		if( $(e.target).hasClass('wall-require-login') ) {
		//do nothing -- ajax combo box will take care of it starting from now
			return;
		}
		
		var main = $(e.target).closest('.comments > .SpeechBubble');
		var newreply = $(e.target).closest('.SpeechBubble');
		this.disableReply(newreply);
		$.nirvana.sendRequest({
			controller: 'WallExternalController',
			method: 'replyToMessage',
			data: {
				body: newreply.find('textarea').val(),
				parent: main.attr('data-id'),
				username: this.username
			},
			callback: this.proxy(function(data) {
				this.replyToMessagePreviewCancel(e);
				this.enableReply($(e.target).closest('.SpeechBubble'));
				//this.replyShrink($(e.target).closest('.SpeechBubble'), true);
				main.find('textarea').val("").trigger('blur');
				var newmsg = $($(data['message'])).insertBefore(main.find('ul li.new-reply')).hide().fadeIn('slow');
				
				if(window.skin && window.skin != "monobook") {
					WikiaButtons.init(newmsg);
				}
				
				//$('<div class="highlight"></div>').appendTo(newmsg);//.fadeTo(0,0.05).fadeTo(1000, 0.05).fadeOut(3000);
				$('.timeago',newmsg).timeago();
				//$('.SpeechBubble[data-id='+main.attr('data-id')+']:after',newmsg.parent()).css('opacity',1).animate({opacity:'0'},2000);
				main.find('ul li.load-more .count').html(main.find('ul li.message').length);
				$('.speech-bubble-message', newreply).css({'margin-left':'0px'});
				$('.speech-bubble-avatar', newreply).hide();
				
				if( typeof(href) == 'string' ) {
					window.location.href = href;
				}
				
				$('.follow', $(e.target).closest('.SpeechBubble.message')).text($.msg('wall-message-following')).removeClass('secondary');
				
				//click tracking
				this.track('wall/message/reply_post');
			})

		});
	},

	disableReply: function(e) {
		$('textarea', e).attr('disabled', 'disabled');
		$('.replyButton', e).attr('disabled', 'disabled');
		$('.loadingAjax', e).show();
		$('.speech-bubble-message', e).addClass('loading');
	},

	enableReply: function(e) {
		$('textarea', e).removeAttr('disabled');
		$('.replyButton', e).removeClass('loading').removeAttr('disabled');
		$('.loadingAjax', e).hide();
		$('.speech-bubble-message', e).removeClass('loading');
	},

	replyFocus: function(e) {
		var el = $(e.target).closest('.SpeechBubble');
		$('.replyButton', el).show();
		$('.replyPreview',el).show();
		$(el).css({ 'margin-bottom': '40px'});
		$('.speech-bubble-message', el).stop().css({'margin-left':'40px'});
		$('.speech-bubble-avatar', el).show();
		$('textarea',el).css('line-height','inherit');
	},

	reply_ChangeText: function(e) {
		var target = $(e.target);
		var content = !target.hasClass('placeholder') && target.val().length > 0;

		if(content && !target.hasClass('content') ) {
			target.closest('.SpeechBubble').find('.replyButton').removeAttr('disabled');
			target.addClass('content');
			var el = target.closest('.SpeechBubble');
			$('button', el ).removeAttr('disabled');
		} else if(!content && target.hasClass('content')) {
			target.closest('.SpeechBubble').find('.replyButton').attr('disabled', 'disabled');
			target.removeClass('content');
			var el = target.closest('.SpeechBubble');
			$('button', el ).attr('disabled','disabled');
		}
	},

	replyBlur: function(e) {
		var content = !$(e.target).hasClass('placeholder') && $(e.target).val().length > 0;

		if(!content) {
			var el = $(e.target).closest('.SpeechBubble');
			$('button', el ).hide();
			$(el).css({ 'margin-bottom': '0px'});
			$('.speech-bubble-message', el).animate({'margin-left':'0px'},150);
			$('.speech-bubble-avatar', el)
				.css('position','absolute')
				.fadeOut(150);
			$('textarea',el).css('line-height','normal');
		} 
	},

	confirmAction: function(e) {
		e.preventDefault();
		var target = $(e.target);
		
		var isreply = target.closest('.SpeechBubble').attr('data-is-reply');
		
		var wallMsg = target.closest('li.message');
		var id = wallMsg.attr('data-id');
		
		if(target.attr('data-id')) {
			var id = target.attr('data-id');
		}
		
		var type = isreply ? 'reply':'thread';
		var mode = target.attr('data-mode').split('-');
		
		var submode = ''
		if(mode[1]) {
			submode = mode[1]; 
		} 
		
		mode = mode[0];
		if(submode == 'fast') {
			var formdata = {};
			this.doAction(id, mode, wallMsg, target, formdata );
			return true;
		}
		
		var msg;
		var title;
		var cancelmsg;
		var okmsg;
	
		title = $.msg('wall-action-' + mode + '-' + type + '-title');
		okmsg = $.msg('wall-action-' + mode + '-confirm-ok');
		cancelmsg = $.msg('wall-action-all-confirm-cancel');
		
		//delete && remove
		msg = $.msg('wall-action-'+mode+'-confirm');
		var form = $('<form>');
		form.append( $('<textarea>').attr({'class':'wall-action-reason','name':'reason','id':'reason'}) );
		if(mode != 'restore') {
			form.append( $('<div>').text( $.msg('wall-action-'+mode+'-'+ type +'-confirm-info') ).addClass('subtle') );
			if(mode == 'admin' || mode == 'remove' ) {
				form.append( $('<input>').attr({'name':'notify-admin', 'id':'notify-admin','type':'checkbox'}) )
				form.append( $('<label>').text( $.msg('wall-action-all-confirm-notify') ) );
			}
		}
		msg += '<form>'+form.html()+'</form>';
	
		if( mode == 'rev' ) {
		//rev delete
			if(isreply) {
				msg = $.msg('wall-action-rev-reply-confirm');
			} else {
				msg = $.msg('wall-action-rev-thread-confirm');
			}
		}
		
		if(window.skin && window.skin == "monobook") {
			this.confirmActionMonobook(id, mode, msg, target, wallMsg, target);
		} else {
			$.confirm({
				title: title,
				content: msg,
				cancelMsg: cancelmsg,
				okMsg: okmsg,
				width: 400,
				onOk: this.proxy(function() {
					var formdata = $('.modalWrapper form').serializeArray();
					this.doAction(id, mode, wallMsg, target, formdata );
				})
			});
			
			if(mode != 'rev') {
				$('#WikiaConfirmOk').attr('disabled', 'disabled');	
			} 
			
			$('textarea.wall-action-reason').bind('keydown keyup change', function(e) {
				var target = $(e.target);
				if(target.val().length > 0) {
					$('#WikiaConfirmOk').removeAttr('disabled');
				} else {
					$('#WikiaConfirmOk').attr('disabled', 'disabled');
				}
			});
		}
	},
	
	confirmActionMonobook: function(id, mode, msg, target, wallMsg, formdata) {
		if( mode == 'rev' ) {
			var answer = confirm(msg);
			if(answer){
				this.doAction(id, 'rev', wallMsg);
			}
		} if( mode == 'restore' || mode == 'admin' || mode == 'adminnotify' || mode == 'remove' || mode == 'removenotify' ) {
			var formdata = []
			
			if(mode == 'adminnotify' || mode == 'removenotify') {
				formdata.push({name:'notify-admin', 'value': true});	
			} else {
				formdata.push({name:'notify-admin', 'value': false});
			}
			
			do {
				var reply = prompt( $.msg('wall-confirm-monobook-' + mode.replace('notify','')) , "");			
				if(reply === null) {
					return ;
				}
				
				if(reply.length < 1 && mode !=  'restore') {
					alert( $.msg('wall-confirm-monobook-lack-of-reason') );
				} else {
					break;
				}
				
			} while(1);

			
			formdata.push({name:'reason', 'value': reply});
			
			if(mode == 'adminnotify'){
				mode = 'admin';
			}
			
			if(mode == 'removenotify'){
				mode = 'remove';
			}
			
			this.doAction(id, mode, wallMsg, target, formdata);
		}
	},
	
	
	/*
	 * work as delete(mode: rev), 
	 * admin delete(mode:admin), 
	 * remove(mode: remove), 
	 * restore(mode: restore)   
	 */

	doAction: function(id, mode, msg, target, formdata){
		switch(mode) {
			case 'restore':
				this.doRestor(id, target, formdata);
			break;
			default:
				this.doDelete(id, mode, msg, formdata);
			break;
		}
	},
	
	doDelete: function(id, mode, msg, formdata){
		$.nirvana.sendRequest({
			controller: 'WallExternalController',
			method: 'deleteMessage',
			format: 'json',
			data: {
				mode: mode,
				msgid: id,
				username: this.username,
				formdata: formdata
			},
			callback: this.proxy(function(data) {
				if(data.status) {
					if( data.html ) {
						this.deletedMessages[id] = msg;

						msg.fadeOut('fast', this.proxy(function() {
							$(data.html).hide().insertBefore(msg).fadeIn('fast');
						}));
					} else {
						msg.fadeOut('fast', function() { msg.remove(); });
					}
				}
				//click tracking
				this.track('wall/message/action/delete');
			})
		});	
	},
	
	scrollEvent: function(e) {
		var window_start = $(document).scrollTop();
		var window_end = window_start + $(window).height();
		if(window_start + 100 > window_end) window_end = window_start + 100; 
		var wall = this;
		$('ul.comments > li').each( function() {
			var comment_start = $(this).offset().top;
			var comment_end =  comment_start + $(this).height();
			var comment_id = $(this).attr('data-id');
			//$().log( comment_start + ':' + comment_end + ' in ' + window_start + ':' + window_end);
			
			if(comment_start >= window_start && comment_start <= window_end) {
				wall.seenCommentStart[ comment_id ] = true;
			}
			if(comment_end >= window_start && comment_end <= window_end) {
				wall.seenCommentEnd[ comment_id ] = true;
			}
				
			if(comment_id in wall.seenCommentStart && comment_id in wall.seenCommentEnd && !(comment_id in wall.seenCommentSend)) {
				wall.seenCommentSend[ comment_id ] = true;
				$.nirvana.sendRequest({
					controller: 'WallNotificationsExternalController',
					method: 'markAsRead',
					format: 'json',
					data: { id: comment_id },
					callback: function() {}
				});
			}
			
		});
	},
	
	track: function(url) {
		if( typeof($.tracker) != 'undefined' ) {
			$.tracker.byStr(url);
		} else {
			WET.byStr(url);
		}
	},
	
	trackClick: function(event) {
		var node = $(event.target),
			parent = node.parent();
		
		if( node.hasClass('user-talk-archive-anchor') ) {
			this.track('wall/archived_talk_page/view');
		} else if( node.hasClass('timeago-fmt') && parent.parent().hasClass('timestamp') ) {
			this.track('wall/message/timestamp');
		} else if( node.hasClass('username') && parent.hasClass('timestamp') ) {
			this.track('wall/message/edited_by');
		} else if( parent.hasClass('edited-by') && node.hasClass('subtle') ) {
			this.track('wall/message/username');
		} else if( parent.hasClass('edited-by') && !node.hasClass('subtle') ) {
			this.track('wall/message/name');
		} else if( parent.hasClass('msg-title') ) {
			this.track('wall/message/title');
		} else if( parent.parent().hasClass('speech-bubble-avatar') ) {
			this.track('wall/message/avatar');
		} else if( parent.hasClass('load-more') ) {
			this.track('wall/message/uncondense');
		} else if( node.hasClass('wall-owner') && parent.hasClass('WallName') ) {
			this.track('wall/thread_page/owners_wall');
		} else if( parent.parent().hasClass('Pagination') && parent.hasClass('next') ) {
			this.track('wall/pagination/next');
		} else if( parent.parent().hasClass('Pagination') && parent.hasClass('prev') ) {
			this.track('wall/pagination/prev');
		} else if( parent.parent().hasClass('Pagination')  ) {
			this.track('wall/pagination/number');
		}
	}

});
