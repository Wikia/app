(function($) {

MiniEditor.Wall = MiniEditor.Wall || {};
MiniEditor.Wall.ReplyMessageForm = $.createClass(Wall.ReplyMessageForm, {
	constructor: function(page, model) {
		MiniEditor.Wall.ReplyMessageForm.superclass.constructor.apply(this,arguments);
	},
	
	deferred: '',
	initEvents: function() {
		var self = this;

		$(this.mainContent)
			.on('click.MiniEditor', this.replyButton, this.proxy(this.replyToMessage))
			.on('click', this.replyPreviewButton, this.proxy(this.showPreview))
			.on('click.MiniEditor', this.replyBody, this.proxy(this.initEditor))
			.on('focus.MiniEditor', this.replyBody, this.proxy(this.focus));

		$(this.replyBody).each(function() {
			if ($(this).is(':focus')) {
				self.initEditor({ target: this });
			}
		});
	},
	
	focus: function(e) {
		this.initEditor({ target: e.target });
	},
	
	setContent: function(replyWrapper, content) {
		if(content) {
			var wikiaEditor = this.editor.data('wikiaEditor');
			wikiaEditor.setContent(content);
			wikiaEditor.getEditbox().putCursorAtEndCE();
		}
	},
	
	activatedCallback: function(event, wikiaEditor) {
		this.deferred.resolve(wikiaEditor);
	},

	initEditor: function(e) {
		var target = $(e.target);
		this.deferred = $.Deferred();
		
		// check if editor exists before unbinding placeholder (BugId:23781)
		if (!target.data('wikiaEditor')) {
			// Unbind placeholder and clear textarea before initing mini editor (BugId:23221)
			target.unbind('.placeholder').val('');
		}

		this.editor = target.miniEditor({
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
				},
				editorActivated: $.proxy(this.activatedCallback, this)
			}
		});
		
		return this.deferred.promise();
	},

	getMessageBody: function(reply) {
		var wikiaEditor = $('.wikiaEditor', reply).data('wikiaEditor');
		return wikiaEditor.getContent();
	}, 
	
	getFormat: function(reply) {
		var wikiaEditor = $('.wikiaEditor', reply).data('wikiaEditor');
		var format = wikiaEditor.mode == 'wysiwyg' ? 'wikitext' : '';
		return format;
	},
	
	resetEditor: function() {
		var wikiaEditor = $('.wikiaEditor', reply).data('wikiaEditor');
		reply.find(this.replyBody).val('').trigger('blur');
		wikiaEditor.fire('editorReset');
	}
});

// Set as default class binding for ReplyMessageForm
Wall.settings.classBindings.replyMessageForm = MiniEditor.Wall.ReplyMessageForm;

})(jQuery);
