(function($) {

MiniEditor.Wall = MiniEditor.Wall || {};
MiniEditor.Wall.ReplyMessageForm = $.createClass(Wall.settings.classBindings.replyMessageForm, {
	initEvents: function() {
		var self = this;

		$(this.replyWrapper)
			.on('click.MiniEditor', this.replyButton, this.proxy(this.replyToMessage))
			.on('click.MiniEditor', this.replyBody, this.proxy(this.initEditor));

		$(this.replyBody).each(function() {
			if ($(this).is(':focus')) {
				self.initEditor({ target: this });
			}
		});
	},

	initEditor: function(e) {
		var target = $(e.target);

		// check if editor exists before unbinding placeholder (BugId:23781)
		if (!target.data('wikiaEditor')) {
			// Unbind placeholder and clear textarea before initing mini editor (BugId:23221)
			target.unbind('.placeholder').val('');
		}

		target.miniEditor({
			config: {
				animations: MiniEditor.Wall.Animations
			},
			events: {
				editorReady: function(event, wikiaEditor) {
					// Wait till after editor is loaded to know whether RTE is enabled.
					// If no RTE, re-enable placeholder on the textarea.
					if (!MiniEditor.ckeditorEnabled) {
						wikiaEditor.getEditbox().placeholder();
					}
				}
			}
		});
	},

	doReplyToMessage: function(thread, reply, reload) {
		var wikiaEditor = $('.wikiaEditor', reply).data('wikiaEditor'),
			format = wikiaEditor.mode == 'wysiwyg' ? 'wikitext' : '';

		this.model.postReply(this.page, wikiaEditor.getContent(), format, thread.attr('data-id'), this.proxy(function(newMessage) {
			newMessage = $(newMessage);

			this.enable(reply);

			reply.find(this.replyBody).val('').trigger('blur');
			newMessage.insertBefore(reply).hide().fadeIn('slow').find('.timeago').timeago();
			wikiaEditor.fire('editorReset');

			if (window.skin && window.skin != 'monobook') {
				WikiaButtons.init(newMessage);
			}

			thread.find(this.replyThreadCount).html(thread.find(this.replyThreadMessages).length);
			thread.find(this.replyThreadFollow).text($.msg('wikiafollowedpages-following')).removeClass('secondary');

			this.track('wall/message/reply_post');

			if (reload) {
				this.reloadAfterLogin();
			}
		}));
	}
});

// Set as default class binding for ReplyMessageForm
Wall.settings.classBindings.replyMessageForm = MiniEditor.Wall.ReplyMessageForm;

})(jQuery);