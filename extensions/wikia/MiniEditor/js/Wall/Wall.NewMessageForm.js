(function($) {

MiniEditor.Wall = MiniEditor.Wall || {};
MiniEditor.Wall.NewMessageForm = $.createClass(Wall.settings.classBindings.newMessageForm, {
	initEvents: function() {
		var self = this;

		if (this.messageBody.is(':focus')) {
			self.initEditor();
		}

		this.messageBody.add(this.messageTitle).focus(function(event) {
			self.initEditor(event);
		});

		this.messageTitle.autoResize({
			min: 30,
			limit: 256,
			extraSpace: 15
		});
	},

	initEditor: function(event) {
		var self = this;

		if (!this.messageBody.data('wikiaEditor')) {
			this.messageBody.unbind('.placeholder');
		}

		this.messageBody.miniEditor({
			config: {
				animations: MiniEditor.Wall.Animations
			},
			events: {
				editorReady: function(event, wikiaEditor) {
					if (!MiniEditor.ckeditorEnabled) {
						wikiaEditor.getEditbox()
							.placeholder()
							.triggerHandler('focus.placeholder');
					}
					if ($.browser.msie) {
						self.messageTitle.keydown(function(e) {
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
		return this.messageBody.data('wikiaEditor').getContent();
	},

	// Return an empty string if we don't need to convert,
	// or 'wikitext' if we need to convert to wikitext.
	getFormat: function() {
		return this.messageBody.data('wikiaEditor').mode == 'wysiwyg' ? 'wikitext' : '';
	},

	clearNewMessageBody: function() {
		// empty override
	},

	clearNewMessageTitle: function() {
		this.messageTitle.val('').trigger('blur');
		this.messageNoTitle.fadeOut('fast');
	},

	disableNewMessage: function() {
		this.messageTitle.trigger('blur');
		this.messageBody.data('wikiaEditor').fire('editorReset');
	},

	enableNewMessage: function() {
		this.messageSubmit.html($.msg('wall-button-to-submit-comment'));
		this.messageTitle.removeClass('no-title');
		this.messageNoTitle.fadeOut('fast');
	},

	postNewMessage_ChangeText_handleContent: function() {
		// empty override
	}
});

// Set as default class binding for NewMessageForm
Wall.settings.classBindings.newMessageForm = MiniEditor.Wall.NewMessageForm;

})(jQuery);