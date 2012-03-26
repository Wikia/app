/*

 * Message functions
 */

var WallNewMessageForm = $.createClass(WallMessageForm, {
	initDom: function() {
		// cache commonly used dom elements
		this.WallComments = $('#Wall .comments');
		this.WallMessageTitle = $('#WallMessageTitle');
		this.WallMessageBody = $('#WallMessageBody');
		this.WallMessageSubmit = $('#WallMessageSubmit');
	},
	
	constructor: function(username) {
		WallNewMessageForm.superclass.constructor.apply(this,arguments);
		this.initDom();
		var self = this;
		
		this.WallMessageSubmit.bind('click', this.proxy(this.postNewMessage));
		this.model.bind('newPosted', this.proxy(this.afterPost));
		this.initEvents();

		this.WallMessageTitle
			.keydown(function(e) { if(e.which == 13) {self.WallMessageBody.focus(); return false; }})
			.autoResize({min: 30, minFocus:30, minContent: 30, limit: 300, limitEmpty: 30, extraSpace: 15})
			.click(this.proxy(function() {
				this.track('wall/new_message/subject_field');
			}))
			.keydown(this.proxy(this.postNewMessage_ChangeText_pre))
			.keyup(this.proxy(this.postNewMessage_ChangeText_pre))
			.change(this.proxy(this.postNewMessage_ChangeText_pre));
	},
	
	initEvents: function() {
		// New wall post change
		var out = this.WallMessageTitle.add(this.WallMessageBody)
			.keydown(this.proxy(this.postNewMessage_ChangeText_pre))
			.keyup(this.proxy(this.postNewMessage_ChangeText_pre))
			.change(this.proxy(this.postNewMessage_ChangeText_pre))
			.focus(this.proxy(this.postNewMessage_focus))
			.blur(this.proxy(this.postNewMessage_blur));
	

		this.WallMessageBody
			.keydown(function(e) {
				if ( e.which == 9 && e.shiftKey ) {
					e.preventDefault();
					self.WallMessageTitle.focus();
					return false;
				}
		 })
		.autoResize({minFocus:100, minContent: 100, limit: 9999, limitEmpty: 70, extraSpace: 30});
	},
	
	postNewMessage: function() {
		var title = !this.WallMessageTitle.hasClass('placeholder') && this.WallMessageTitle.val().length > 0;

		if(!title && this.WallMessageSubmit.html() != $.msg('wall-button-to-submit-comment-no-topic')) {
			this.WallMessageSubmit.html($.msg('wall-button-to-submit-comment-no-topic'));
			$('.new-message .no-title-warning').fadeIn();
			$('.new-message input').addClass('no-title');
			return;
		}

		if (this.WallMessageSubmit.hasClass('wall-require-login')) {
			this.loginBeforeAction(this.proxy(function() {
				this.doPostNewMessage(title, true);
			}));

		} else {
			this.doPostNewMessage(title);
		}
	},
	
	getMessageBody: function() {
		return this.WallMessageBody.val();
	},
	
	doPostNewMessage: function(title, reload) {
		this.model.postNew(this.username, title ? this.WallMessageTitle.val() : '', this.getMessageBody(), this.getFormat());
		this.clearNewMessageTitle();
		this.disableNewMessage();

		//click tracking
		if( !title ) {
			this.track('wall/new_message/post_without_title');
		} else {
			this.track('wall/new_message/post');
		}
		
		if(reload) {
			this.reloadAfterLogin;
		}
	},
	
	clearNewMessageBody: function() {
		this.WallMessageBody.val('').trigger('blur');	
	},
	
	clearNewMessageTitle: function() {
		this.WallMessageTitle.val('').trigger('blur');	
	},
	
	afterPost: function(newmsg) {
		newmsg.hide();

		this.clearNewMessageBody();
		this.WallComments.prepend(newmsg);

		// IE is too slow for animations
		if ($.browser.msie) {
			newmsg.show();

		} else {
			newmsg.css('opacity', 0).slideDown('slow').animate({ opacity: 1 }, 'slow');
		}

		newmsg.find('.timeago').timeago();
		newmsg.find('textarea, input').placeholder();

		if (window.skin && window.skin != 'monobook') {
			WikiaButtons.init(newmsg);
		}

		this.enableNewMessage();

		this.fire('afterNewMessagePost', newmsg);
	},
	
	postNewMessage_ChangeText_pre: function(e) {
		var trg = $(e.target);
		if(trg.hasClass('title')) {
			var topic_str = trg.val();
			var topic_len = topic_str.length;
			if(topic_len >= 200) { trg.val( topic_str.slice(0,200) ); }
		}
		setTimeout( this.proxy(this.postNewMessage_ChangeText), 50 );
	},
	
	postNewMessage_ChangeText: function() {
		// check if both topic and content are filled
		var topic_str = this.WallMessageTitle.val();
		var topic_len = topic_str.length;
		var topic = !this.WallMessageTitle.hasClass('placeholder') && topic_len > 0;
		this.postNewMessage_ChangeText_handleContent();
		if(topic && this.WallMessageSubmit.html() == $.msg('wall-button-to-submit-comment-no-topic')) {
			this.WallMessageSubmit.html($.msg('wall-button-to-submit-comment'));
			$('.new-message .no-title-warning').fadeOut('fast');
			this.WallMessageTitle.removeClass('no-title');
		}
	},
	
	postNewMessage_ChangeText_handleContent: function() {
		var content = !this.WallMessageBody.hasClass('placeholder');
		content =  content && this.WallMessageBody.val().length > 0;
		if(content) {
			this.WallMessageSubmit.removeAttr('disabled');
		} else {
			this.WallMessageSubmit.attr('disabled','disabled');
		}
	},

	postNewMessage_focus: function(e) {
		this.WallMessageSubmit.show();
		this.track('wall/new_message/body');
		//if($(e.target).hasClass('title'))
		//	$(e.target).css('line-height','170%');
		if($(e.target).hasClass('body')) {
			$('.new-message textarea.body').css('font-size','13px');
		}
	},

	postNewMessage_blur: function() {
		//topic = !$('.new-message textarea.title').hasClass('placeholder') && $('.new-message textarea.title').val().length > 0;
		var content = !this.WallMessageBody.hasClass('placeholder');
		content = content && this.WallMessageBody.val().length > 0;
		if(!content) {
			this.WallMessageSubmit.attr('disabled', 'disabled').hide();
			$('.new-message textarea.body').css('font-size','14px');
		}
		/*if(!title) {
			$('.new-message textarea.title:focus').css('line-height','normal');
		}*/
	},

	disableNewMessage: function() {
		this.WallMessageSubmit.add('.new-message textarea').attr('disabled', 'disabled');
		$('.new-message .loadingAjax').show();
		$('.new-message .speech-bubble-message').addClass('loading');
	},

	enableNewMessage: function() {
		this.WallMessageSubmit.hide().add('.new-message textarea').removeAttr('disabled');
		this.WallMessageSubmit.fadeOut('fast');
		this.WallMessageSubmit.html($.msg('wall-button-to-submit-comment'));
		this.WallMessageTitle.removeClass('no-title');
		
		$('.new-message .no-title-warning').fadeOut('fast');
		$('.new-message .loadingAjax').hide();
		$('.new-message .speech-bubble-message').removeClass('loading');
	}
});