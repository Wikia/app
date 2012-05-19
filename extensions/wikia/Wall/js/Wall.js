$(document).ready(function() {
	if( $('#Wall').exists()) {
		var wall = new Wall();
	}
});

var Wall = $.createClass(Object, {
	constructor: function() {
		this.settings = {};
		this.hoverTimer = {};
		this.deletedMessages = {};
		this.isMonobook = window.skin && window.skin == "monobook";
		this.hasMiniEditor = typeof wgEnableMiniEditorExt != "undefined" && !this.isMonobook;

		$("#WikiaArticle")
			.bind('afterWatching', this.proxy(this.onWallWatch))
			.bind('afterUnwatching', this.proxy(this.onWallUnwatch));

		$('#Wall')
			.on('click', '.admin-delete-message', this.proxy(this.confirmAction))
			.on('click', '.delete-message', this.proxy(this.confirmAction))
			.on('click', '.remove-message', this.proxy(this.confirmAction))
			.on('click', '.message-restore', this.proxy(this.confirmAction))
			.on('click', '.message-undo-remove', this.proxy(this.undoRemoveOrAdminDelete))
			.on('click', '.follow.wikia-button', this.proxy(this.switchWatch))
			.on('mouseenter', '.follow.wikia-button', this.proxy(this.hoverFollow))
			.on('mouseleave', '.follow.wikia-button', this.proxy(this.unhoverFollow));

		$('.load-more').on('click', 'a', this.proxy(this.loadMore));
		
		// Make timestamps dynamic
		$('.timeago').timeago();
		
		// If any textarea has content make sure Reply / Post button is visible
		$(document).ready(this.initTextareas);
		
		if(wgTitle.indexOf('/') > 0) {
			var titlePart = wgTitle.split('/');
			this.title = titlePart[0]; 
		} else {
			this.title = wgTitle;
		}
		
		this.page = {'title': this.title, 'namespace': window.wgNamespaceNumber }
		
		//click tracking
		$('#Wall')
			.on('click', '.edited-by a', this.proxy(this.trackClick))
			.on('click', '.timeago-fmt', this.proxy(this.trackClick))
			.on('click', '.username', this.proxy(this.trackClick))
			.on('click', '.avatar', this.proxy(this.trackClick))
			.on('click', '.Pagination', this.proxy(this.trackClick))
			.on('click', '.user-talk-archive-anchor', this.proxy(this.trackClick))
			.on('click', '.wall-owner', this.proxy(this.trackClick))
			.on('click', '.load-more a', this.proxy(this.trackClick))
			.on('click', '.msg-title', this.proxy(this.trackClick))
			.on('click', '.sortingOption', this.proxy(this.trackClick));

		// fix firefox bug (when textarea is disabled and you refresh a page
		// it's still disabled on new page loaded
		$("#Wall textarea").removeAttr('disabled');
		$("#Wall").on('keydown', 'textarea', this.proxy(this.focusButton));

		this.model = new WallBackendBridge();
		this.pagination = new WallPagination(this.page, this.model);
		this.pagination.on('afterPageLoaded', this.proxy(this.afterPagination));

		// Refactor this, it's ugly.
		if (this.hasMiniEditor) {
			this.newMessageForm = new MiniEditorNewMessageForm(this.page, this.model);
			this.editMessageForm = new MiniEditorEditMessageForm(this.page, this.model);
			this.replyMessageForm = new MiniEditorReplyMessageForm(this.page, this.model);

		} else {
			this.newMessageForm = new WallNewMessageForm(this.page, this.model);
			this.editMessageForm = new WallEditMessageForm(this.page, this.model);
			this.replyMessageForm = new WallReplyMessageForm(this.page, this.model);
		}

		this.newMessageForm.on('afterNewMessagePost', this.proxy(this.afterNewMessagePost));

		$(window).bind('hashchange', this.proxy(this.onHashChange));
		this.onHashChange();

		// Expose to public
		$('#Wall').data('Wall', this).triggerHandler('WallInit', [this]);
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

	afterPagination: function() {
		var wall = $('#Wall');

		wall.find('.timeago').timeago();
		wall.find('textarea, input').placeholder();

		if (!this.hasMiniEditor) {
			wall.find('.new-reply textarea').autoResize(this.replyMessageForm.settings.reply);
		}

		if (!this.isMonobook) {
			WikiaButtons.init(wall);
		}
	},

	// TODO: refactor Wall so subclasses have access to settings, then this can go away
	afterNewMessagePost: function(newmsg) {
		newmsg.find('.timeago').timeago();
		newmsg.find('textarea, input').placeholder();

		if (!this.hasMiniEditor) {
			newmsg.find('.new-reply textarea').autoResize(this.replyMessageForm.settings.reply);
		}
	},

	initTextareas: function() {
		setTimeout( function() { // make sure all textareas are inicialized already
			//$('.new-message textarea.body').trigger('focus');
			$('.new-reply textarea').each( function() {
				if( $(this).is(':focus') ) {
					$(this).trigger('focus');
				}
			});
			var title = $('#WallMessageTitle');
			if( title.is(':focus') ) { title.trigger('focus'); }
			var body = $('#WallMessageBody');
			if( body.is(':focus') ) { body.trigger('focus'); }
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
						$(e.target).text($.msg('oasis-follow')).addClass('secondary');
						
						//click tracking
						this.track('wall/message/unfollow');
					} else {
						element.animate({'opacity':0.7},'slow', function() { element.css('opacity','');} );
						$(e.target).text($.msg('wikiafollowedpages-following')).removeClass('secondary');
						
						//click tracking
						this.track('wall/message/follow');
					}
				}}
			)
		});
	},

	hoverFollow: function(e) {
		if( $(e.target).html() == $.msg('wikiafollowedpages-following') ) {
			$(e.target).html($.msg('wall-message-unfollow'));
		}
	},
	
	unhoverFollow: function(e) {
		if( $(e.target).html() == $.msg('wall-message-unfollow') ) {
			$(e.target).html($.msg('wikiafollowedpages-following'));
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
	
	doRestore: function(id, target, formdata) {
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
			if( !this.isMonobook ) {
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
		
		var submode = '';
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
				form.append( $('<input>').attr({'name':'notify-admin', 'id':'notify-admin','type':'checkbox'}) );
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
		
		if(this.isMonobook) {
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
			var formdata = [];
			
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
				this.doRestore(id, target, formdata);
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
	
	track: function(url) {
		if( typeof($.tracker) != 'undefined' ) {
			$.tracker.byStr(url);
		} else {
			WET.byStr(url);
		}
	},
	
	proxy: function(func) {
		return $.proxy(func, this);
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
