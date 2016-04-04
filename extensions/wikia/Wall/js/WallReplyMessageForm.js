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
		this.replyBodyContent = '.replyBody.content';

		this.replyThread = '.comments > .SpeechBubble';
		this.replyPreviewButton = '.previewButton';

		// Relative to replyThread
		this.replyThreadFollow = '.follow';
		this.replyThreadMessages = 'ul .message';
		this.replyThreadCount = 'ul .load-more .count';

		this.mainContent = 'body';
	},

	initEvents: function() {

		$(this.mainContent)
			.on('click', this.replyPreviewButton, this.proxy(this.showPreview) )
			.on('click', this.replyButton, this.proxy(this.replyToMessage))
			.on('keydown keyup change', this.replyBody, this.proxy(this.change))
			.on('focus', this.replyBody, this.proxy(this.focus))
			.on('blur', this.replyBody, this.proxy(this.blur))
			.find(this.replyBody).autoResize(this.settings.reply);
	},

	focus: function(e) {
		var textarea = $(e.target);
		var reply = textarea.closest(this.replyWrapper);
		reply.addClass('open');
	},

	setContent: function(replyWrapper, content) {
		if(content) {
			replyWrapper.find(this.replyBody).val(content).addClass('content').putCursorAtEnd();
			this.enable(replyWrapper);
		}
	},

	change: function(e) {
		var target = $(e.target),
			hasContent = target.val() != '';

		var wraper = target.closest(this.replyWrapper);
		if (hasContent && !target.hasClass('placeholder') && !target.hasClass('content')) {
			target.addClass('content');
			wraper.find(this.replyButton).removeAttr('disabled');
			wraper.find(this.replyPreviewButton).removeAttr('disabled');
		} else if (!hasContent) {
			target.removeClass('content');
			wraper.find(this.replyButton).attr('disabled', true);
			wraper.find(this.replyPreviewButton).attr('disabled', true);
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
		replyWrapper.find(this.replyPreviewButton).attr('disabled', true);
	},

	enable: function(replyWrapper) {
		replyWrapper.removeClass('loading');
		replyWrapper.find(this.replyBody).removeAttr('disabled');
		replyWrapper.find(this.replyButton).removeAttr('disabled');
		replyWrapper.find(this.replyPreviewButton).removeAttr('disabled');
	},

	replyToMessage: function(e) {
		var target = $(e.target),
			thread = target.closest(this.replyThread);
			reply = target.closest(this.replyWrapper);

		this.disable(reply);

		this.loginBeforeSubmit(this.proxy(function(isAlreadyLogged) {
			this.doReplyToMessage(thread, reply, !isAlreadyLogged);
		}));
	},

	showPreview: function(e) {
		var target = $(e.target),
		reply = target.closest(this.replyWrapper);

		this.showPreviewModal(this.getFormat(reply), '', this.getMessageBody(reply), this.getMessageWidth(reply), function() {
			reply.find('.replyButton').click();
		});
	},

	resetEditor: function(reply) {
		reply.find(this.replyBody).val('').trigger('blur');
	},

	getMessageBody: function(reply) {
		return reply.find(this.replyBodyContent).val();
	},

	doReplyToMessage: function (thread, reply, reload) {
		this.model.postReply(
			this.page,
			this.getMessageBody(reply),
			this.getFormat(reply),
			thread.attr('data-id'),
			reply.data('quotedFrom'),
			//success callback
			this.proxy(function (newMessage) {
				newMessage = $(newMessage);

				this.enable(reply);
				this.resetEditor(reply);

				// fire event when new article comment is/will be added to DOM
				mw.hook('wikipage.content').fire(newMessage);

				newMessage.insertBefore(reply).hide().fadeIn('slow').find('.timeago').timeago();

				if (window.skin && window.skin != 'monobook') {
					WikiaButtons.init(newMessage);
				}

				thread.find(this.replyThreadCount).html(thread.find(this.replyThreadMessages).length);
				thread.find(this.replyThreadFollow).text($.msg('wikiafollowedpages-following')).removeClass('secondary');

				if (reload) {
					this.reloadAfterLogin();
				}
			}),
			//fail callback
			this.proxy(function () {
				this.enable(reply);
				$.showModal($.msg('wall-posting-message-failed-title'), $.msg('wall-posting-message-failed-body'));
			}));
	}
});

Wall.settings.classBindings.replyMessageForm = Wall.ReplyMessageForm;

})(jQuery);
