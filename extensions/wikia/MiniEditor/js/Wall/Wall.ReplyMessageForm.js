(function(window, $) {

	// Reply Message
	var MiniEditorReplyMessageForm = $.createClass(WallReplyMessageForm, {
		init: function() {
			var self = this;

			this.wall
				.on('click.MiniEditor', '.replyButton', this.proxy(this.replyToMessage))
				.on('click.MiniEditor', '.new-reply .body', this.proxy(this.click)).each(function() {
					$(this).is(':focus') && self.initEditor(this);
				});
		},

		click: function(e) {
			this.initEditor(e.target);
		},
		
		initEditor: function(target) {
			target = $(target);

			// check if editor exists before unbinding placeholder (BugId:23781)
			if (!target.data('wikiaEditor')) {
				// Unbind placeholder and clear textarea before initing mini editor (BugId:23221)
				target.unbind('.placeholder').val('');
			}

			target.miniEditor({
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

		doReplyToMessage: function(main, newreply, reload) {
			var wikiaEditor = $('.wikiaEditor', newreply).data('wikiaEditor'),
				format = wikiaEditor.mode == 'wysiwyg' ? 'wikitext' : '';

			this.model.postReply(this.username, wikiaEditor.getContent(), format, main.attr('data-id'), this.proxy(function(msg) {
				var newmsg = $(msg).hide().insertBefore(newreply).fadeIn('slow');

				newmsg.find('.timeago').timeago();
				newreply.find('textarea.body').placeholder();

				wikiaEditor.fire('editorReset');

				if (window.skin && window.skin != 'monobook') {
					WikiaButtons.init(newmsg);
				}

				main.find('ul li.load-more .count').html(main.find('ul li.message').length);
				main.find('.follow').text($.msg('wikiafollowedpages-following')).removeClass('secondary');

				this.track('wall/message/reply_post');
				this.enable(newreply);

				if (reload) {
					this.reloadAfterLogin();
				}
			}));
		}
	});
	
	// Exports
	window.MiniEditorReplyMessageForm = MiniEditorReplyMessageForm;

})(this, jQuery);