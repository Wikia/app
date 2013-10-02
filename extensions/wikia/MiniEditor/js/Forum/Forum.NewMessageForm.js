(function($) {

MiniEditor.Forum.NewMessageForm = $.createClass(Wall.settings.classBindings.newMessageForm, {
	disableNewMessage: function() {
		this.message.find('.submit').attr('disabled', 'disabled');
		this.message.addClass('loading');
	},
	enableNewMessage: function() {
		this.messageSubmit.html($.msg('wall-button-to-submit-comment'));
		this.messageTitle.removeClass('no-title');
		this.messageNoTitle.fadeOut('fast');
		this.message.removeClass('loading');
	}
});

// Set as default class binding for NewMessageForm
Wall.settings.classBindings.newMessageForm = MiniEditor.Forum.NewMessageForm;

})(jQuery);