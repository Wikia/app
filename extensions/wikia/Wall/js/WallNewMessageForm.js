(function(window, $) {

Wall.NewMessageForm = $.createClass(Wall.MessageForm, {
	constructor: function() {
		Wall.NewMessageForm.superclass.constructor.apply(this, arguments);

		this.initElements();

		this.model.bind('newPosted', this.proxy(this.afterPost));
		
		this.messageSubmit.bind('click', this.proxy(this.postNewMessage));
		this.messagePreview.bind('click', this.proxy(this.showPreview));

		this.initEvents();
	},

	initElements: function() {
		this.buttons = $('#WallMessageBodyButtons');
		this.comments = $('#Wall .comments');
		this.message = $('.new-message');
		this.loading = this.message.find('.loadingAjax');
		this.messageNoTitle = this.message.find('.no-title-warning');
		this.messageTitle = $('#WallMessageTitle');
		this.messageBody = $('#WallMessageBody');
		this.messageSubmit = $('#WallMessageSubmit');
		this.messagePreview = $('#WallMessagePreview');
		this.notifyEveryone = $('#NotifyEveryone');
	},

	initEvents: function() {
		var self = this;

		this.messageTitle
			.keydown(function(e) {
				if (e.which == 13) {
					self.messageBody.focus();
					return false;
				}
			})
			.autoResize({
				min: 30,
				minFocus:30,
				minContent: 30,
				limit: 300,
				limitEmpty: 30,
				extraSpace: 15
			});

		this.messageBody
			.keydown(function(e) {
				if ( e.which == 9 && e.shiftKey ) {
					e.preventDefault();
					self.messageTitle.focus();
					return false;
				}
		 	})
			.autoResize({
				minFocus:100,
				minContent: 100,
				limit: 9999,
				limitEmpty: 70,
				extraSpace: 30
			});

		this.messageTitle.add(this.messageBody)
			.keydown(this.proxy(this.postNewMessage_ChangeText_pre))
			.keyup(this.proxy(this.postNewMessage_ChangeText_pre))
			.change(this.proxy(this.postNewMessage_ChangeText_pre))
			.focus(this.proxy(this.postNewMessage_focus))
			.blur(this.proxy(this.postNewMessage_blur));
	},

	getTitle: function() {
		var msgTitleVal = $.trim(this.messageTitle.val()), // prevent titles containing only whitespace
			title = !this.messageTitle.hasClass('placeholder') && msgTitleVal.length > 0;
		return title ? this.messageTitle.val():'';
	},
	
	postNewMessage: function() {
		var title = this.getTitle();

		if(!title && this.messageSubmit.html() != $.msg('wall-button-to-submit-comment-no-topic')) {
			this.messageSubmit.html($.msg('wall-button-to-submit-comment-no-topic'));
			this.messageNoTitle.fadeIn();
			this.messageTitle.addClass('no-title');
			return;
		}

		this.loginBeforeSubmit(this.proxy(function(isAlreadyLogged) {
			this.doPostNewMessage(title);
			this.reload = !isAlreadyLogged;
		}));
	},

	getMessageBody: function() {
		return $.trim(this.messageBody.val());
	},

	showPreview: function(e) {
		this.showPreviewModal(this.getFormat(), this.getTitle(), this.getMessageBody(), this.getMessageWidth(this.message), this.proxy( function() {
			this.postNewMessage();
		}));
	},
	
	doPostNewMessage: function(title) {
		var topics = this.messageTopic ? this.messageTopic.data('messageTopic').getTopics() : [];
	
		this.model.postNew(this.page, title ? this.messageTitle.val() : '', this.getMessageBody(), this.getFormat(), this.notifyEveryone.is(':checked') ? '1':'0', topics);

		this.clearNewMessageTitle();
		this.disableNewMessage();
	},

	clearNewMessageBody: function() {
		this.messageBody.val('').trigger('blur');
	},

	clearNewMessageTitle: function() {
		this.messageTitle.val('').trigger('blur');
	},

	afterPost: function(newmsg) {
		newmsg.hide();

		this.clearNewMessageBody();
		this.enableNewMessage();

		this.comments.prepend(newmsg);

		// IE is too slow for animations
		if ($.browser.msie) {
			newmsg.show();

		} else {
			newmsg.css('opacity', 0).slideDown('slow').animate({ opacity: 1 }, 'slow');
		}

		newmsg.find('.msg-body').show();

		if (window.skin && window.skin != 'monobook') {
			WikiaButtons.init(newmsg);
		}

		this.fire('afterNewMessagePost', newmsg);
		
		if(this.reload) {
			this.reloadAfterLogin();
		}
	},

	postNewMessage_ChangeText_pre: function(e) {
		var target = $(e.target);
		if (target.hasClass('title')) {
			var title = target.val();
			if (title.length >= 200) {
				target.val(title.slice(0, 200));
			}
		}

		setTimeout( this.proxy(this.postNewMessage_ChangeText), 50 );
	},

	postNewMessage_ChangeText: function() {
		// check if both topic and content are filled
		var topic_str = $.trim(this.messageTitle.val());
		var topic = !this.messageTitle.hasClass('placeholder') && topic_str.length > 0;
		this.postNewMessage_ChangeText_handleContent();
		if (topic && this.messageSubmit.html() == $.msg('wall-button-to-submit-comment-no-topic')) {
			this.messageSubmit.html($.msg('wall-button-to-submit-comment'));
			this.messageNoTitle.fadeOut('fast');
			this.messageTitle.removeClass('no-title');
		}
	},

	postNewMessage_ChangeText_handleContent: function() {
		var content = this.canSubmit();
		if(content) {
			this.messageSubmit.removeAttr('disabled');
			this.messagePreview.removeAttr('disabled');
		} else {
			this.messageSubmit.attr('disabled','disabled');
			this.messagePreview.attr('disabled','disabled');
		}
	},
	
	canSubmit: function() {
		var message = this.getMessageBody();
		return !this.messageBody.hasClass('placeholder') && message.length > 0;
	},

	postNewMessage_focus: function(e) {
		this.buttons.show();
		if($(e.target).hasClass('body')) {
			this.messageBody.css('font-size','13px');
		}
	},

	postNewMessage_blur: function() {
		var content = this.canSubmit();
		var title = this.messageTitle.val();
		if (title.length > 0) {
			this.messageTitle.val($.trim(title));
		}
		if(!content) {
			this.buttons.hide();
			this.messageSubmit.attr('disabled', 'disabled');
			this.messageBody.css('font-size','14px');
		}
	},

	disableNewMessage: function() {
		this.messageSubmit.add(this.messageBody).attr('disabled', 'disabled');
		this.message.addClass('loading');
		this.loading.show();
	},

	enableNewMessage: function() {
		this.messageSubmit.add(this.messageBody).removeAttr('disabled');
		this.messageSubmit.html($.msg('wall-button-to-submit-comment'));
		this.messageTitle.removeClass('no-title');
		this.messageNoTitle.fadeOut('fast');
		this.message.removeClass('loading');
		this.loading.hide();
	}
});

Wall.settings.classBindings.newMessageForm = Wall.NewMessageForm;

})(window, jQuery);
