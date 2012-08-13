(function($) {

Wall.ReplyMessageForm = $.createClass(Wall.MessageForm, {
	constructor: function(page, model) {
		Wall.ReplyMessageForm.superclass.constructor.apply(this, arguments);

		this.settings = {
			reply: {
				minFocus:100,
				minContent: 100,
				limit: 9999,
				limitEmpty: 30,
				extraSpace: 30
			}
		};

		this.initElements();
		this.initEvents();

		this.model.bind('pageLoaded', this.proxy(function(page, data) {
			this.initEvents(page);
		}));
	},

	initElements: function() {
		this.replyWrapper = '.new-reply';

		// Relative to replyWrapper
		this.replyButton = '.replyButton';
		this.replyBody = '.replyBody';
		this.replyThread = '.comments > .SpeechBubble';

		// Relative to replyThread
		this.replyThreadFollow = '.follow';
		this.replyThreadMessages = 'ul .message';
		this.replyThreadCount = 'ul .load-more .count';

		this.mainContent = 'body';
	},

	initEvents: function() {
		$(this.mainContent)
			.on('click', this.replyButton, this.proxy(this.replyToMessage))
			.on('keydown keyup change', this.replyBody, this.proxy(this.change))
			.on('focus', this.replyBody, this.proxy(this.focus))
			.on('blur', this.replyBody, this.proxy(this.blur))
			.find(this.replyBody).autoResize(this.settings.reply);
	},

	focus: function(e) {
		$(e.target).closest(this.replyWrapper).addClass('open');
	},

	change: function(e) {
		var target = $(e.target),
			hasContent = target.val() != '';

		if (hasContent && !target.hasClass('placeholder') && !target.hasClass('content')) {
			target.addClass('content');
			target.closest(this.replyWrapper).find(this.replyButton).removeAttr('disabled');

		} else if (!hasContent) {
			target.removeClass('content');
			target.closest(this.replyWrapper).find(this.replyButton).attr('disabled', true);
		}
	},

	blur: function(e) {
		var target = $(e.target);

		if (!target.hasClass('content')) {
			target.closest(this.replyWrapper).removeClass('open');
		}
	},

	disable: function(replyWrapper) {
		replyWrapper.addClass('loading');
		replyWrapper.find(this.replyBody).attr('disabled', true);
		replyWrapper.find(this.replyButton).attr('disabled', true);
	},

	enable: function(replyWrapper) {
		replyWrapper.removeClass('loading');
		replyWrapper.find(this.replyBody).removeAttr('disabled');
		replyWrapper.find(this.replyButton).removeAttr('disabled');
	},

	replyToMessage: function(e) {
		var target = $(e.target),
			thread = target.closest(this.replyThread);
			reply = target.closest(this.replyWrapper);

		this.disable(reply);

		if (target.hasClass('wall-require-login'))  {
			this.loginBeforeAction(this.proxy(function() {
				this.doReplyToMessage(thread, reply, true);
			}));

		} else {
			this.doReplyToMessage(thread, reply, false);
		}
	},

	doReplyToMessage: function(thread, reply, reload) {
		this.model.postReply(this.page, reply.find(this.replyBody).val(), this.getFormat(), thread.attr('data-id'), this.proxy(function(newMessage) {
			newMessage = $(newMessage);

			this.enable(reply);

			reply.find(this.replyBody).val('').trigger('blur');
			newMessage.insertBefore(reply).hide().fadeIn('slow').find('.timeago').timeago();

			if (window.skin && window.skin != 'monobook') {
				WikiaButtons.init(newMessage);
			}

			thread.find(this.replyThreadCount).html(thread.find(this.replyThreadMessages).length);
			thread.find(this.replyThreadFollow).text($.msg('wikiafollowedpages-following')).removeClass('secondary');

			if (reload) {
				this.reloadAfterLogin();
			}
		}));
	}
});

Wall.settings.classBindings.replyMessageForm = Wall.ReplyMessageForm;

})(jQuery);