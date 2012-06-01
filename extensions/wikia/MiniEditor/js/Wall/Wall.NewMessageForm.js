(function(window, $) {

	// New Message
	var MiniEditorNewMessageForm = $.createClass(WallNewMessageForm, {
		initEvents: function() {
			var self = this;

			if (this.WallMessageBody.is(':focus')) {
				self.initEditor();	
			}

			this.WallMessageBody.add(this.WallMessageTitle).focus(function(event) {
				self.initEditor(event);
			});
		},

		initEditor: function(event) {
			var self = this;

			if (!this.WallMessageBody.data('wikiaEditor')) {
				this.WallMessageBody.unbind('.placeholder');
			}

			this.WallMessageBody.miniEditor({
				events: {
					editorReady: function(event, wikiaEditor) {
						if (!MiniEditor.ckeditorEnabled) {
							wikiaEditor.getEditbox()
								.placeholder()
								.triggerHandler('focus.placeholder');
						}
						if (!$.browser.webkit) {
							self.WallMessageTitle.keydown(function(e) {
								if ( e.keyCode == 9 ) {
									e.preventDefault();
									wikiaEditor.editorFocus();
								}
							});
						}
					}
				}
			}, event);
		},

		getMessageBody: function() {
			return this.WallMessageBody.data('wikiaEditor').getContent();
		},

		// Return an empty string if we don't need to convert, 
		// or 'wikitext' if we need to convert to wikitext.
		getFormat: function() { 
			return this.WallMessageBody.data('wikiaEditor').mode == 'wysiwyg' ? 'wikitext' : '';
		},

		clearNewMessageBody: function() {
			// empty override
		},

		clearNewMessageTitle: function() {
			this.WallMessageTitle.val('').trigger('blur').find('.no-title-warning').fadeOut('fast');	
		},

		disableNewMessage: function() {
			this.WallMessageTitle.trigger('blur');
			this.WallMessageBody.data('wikiaEditor').fire('editorReset');
		},

		enableNewMessage: function() {
			// Note: this was copied and pasted from parent class. Could be more dry
			this.WallMessageSubmit.html($.msg('wall-button-to-submit-comment'));
			this.WallMessageTitle.removeClass('no-title');
			
			$('.new-message .no-title-warning').fadeOut('fast');
		},
		
		postNewMessage_ChangeText_handleContent: function() {
			// empty override
		}
	});
	
	// Exports
	window.MiniEditorNewMessageForm = MiniEditorNewMessageForm;

})(this, jQuery);