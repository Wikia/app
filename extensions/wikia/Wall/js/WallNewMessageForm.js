(function(window, $) {

Wall.NewMessageForm = $.createClass(Wall.MessageForm, {
	constructor: function() {
		Wall.NewMessageForm.superclass.constructor.apply(this, arguments);

		this.initElements();

		this.model.bind('newPosted', this.proxy(this.afterPost));
		this.messageSubmit.bind('click', this.proxy(this.postNewMessage));

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
			})
			.click(this.proxy(function() {
				this.track('wall/new_message/subject_field');
			}));

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

	postNewMessage: function() {
		var title = !this.messageTitle.hasClass('placeholder') && this.messageTitle.val().length > 0;

		if(!title && this.messageSubmit.html() != $.msg('wall-button-to-submit-comment-no-topic')) {
			this.messageSubmit.html($.msg('wall-button-to-submit-comment-no-topic'));
			this.messageNoTitle.fadeIn();
			this.messageTitle.addClass('no-title');
			return;
		}

		if (this.messageSubmit.hasClass('wall-require-login')) {
			this.loginBeforeAction(this.proxy(function() {
				this.doPostNewMessage(title, true);
			}));

		} else {
			this.doPostNewMessage(title);
		}
	},

	getMessageBody: function() {
		return this.messageBody.val();
	},

	doPostNewMessage: function(title, reload) {
		this.model.postNew(this.page, title ? this.messageTitle.val() : '', this.getMessageBody(), this.getFormat(), this.notifyEveryone.is(':checked') ? '1':'0');

		this.clearNewMessageTitle();
		this.disableNewMessage();
		this.track(title ? 'wall/new_message/post' : 'wall/new_message/post_without_title');

		if (reload) {
			this.reloadAfterLogin();
		}
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
		var topic_str = this.messageTitle.val();
		var topic = !this.messageTitle.hasClass('placeholder') && topic_str.length > 0;
		this.postNewMessage_ChangeText_handleContent();
		if (topic && this.messageSubmit.html() == $.msg('wall-button-to-submit-comment-no-topic')) {
			this.messageSubmit.html($.msg('wall-button-to-submit-comment'));
			this.messageNoTitle.fadeOut('fast');
			this.messageTitle.removeClass('no-title');
		}
	},

	postNewMessage_ChangeText_handleContent: function() {
		var content = !this.messageBody.hasClass('placeholder');
		content =  content && this.messageBody.val().length > 0;
		if(content) {
			this.messageSubmit.removeAttr('disabled');
		} else {
			this.messageSubmit.attr('disabled','disabled');
		}
	},

	postNewMessage_focus: function(e) {
		this.buttons.show();
		this.track('wall/new_message/body');
		if($(e.target).hasClass('body')) {
			this.messageBody.css('font-size','13px');
		}
	},

	postNewMessage_blur: function() {
		var content = !this.messageBody.hasClass('placeholder');
		content = content && this.messageBody.val().length > 0;
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