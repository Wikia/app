(function($) {

Forum.ReplyMessageForm = $.createClass(Wall.ReplyMessageForm, {
	constructor: function(page, model) {
		Forum.ReplyMessageForm.superclass.constructor.apply(this, arguments);
	},
	initElements: function() {
		Forum.ReplyMessageForm.superclass.initElements.apply(this, arguments);
		this.replyThread = '#Forum .ForumThreadMessage';
	},
	initEvents: function() {
		$(this.replyWrapper)
			.on('click', this.replyButton, this.proxy(this.replyToMessage))
			.on('keydown keyup change', this.replyBody, this.proxy(this.change))
			.on('focus', this.replyBody, this.proxy(this.focus))
			.on('blur', this.replyBody, this.proxy(this.blur))
			.find(this.replyBody);
	},
	replyToMessage: function(e) {
		var target = $(e.target),
			thread = $(this.replyThread),
			reply = target.closest(this.replyWrapper);

		this.disable(reply);

		if (target.hasClass('wall-require-login'))  {
			this.loginBeforeAction(this.proxy(function() {
				this.doReplyToMessage(thread, reply, true);
			}));

		} else {
			this.doReplyToMessage(thread, reply, false);
		}
	}
});

Wall.settings.classBindings.replyMessageForm = Forum.ReplyMessageForm;

})(jQuery);