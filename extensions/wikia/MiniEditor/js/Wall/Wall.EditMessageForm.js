/*global WikiaEditor, MiniEditor, Wall*/

(function($) {

MiniEditor.Wall = MiniEditor.Wall || {};
MiniEditor.Wall.EditMessageForm = $.createClass(Wall.settings.classBindings.editMessageForm, {
	oldTitle: {},
	oldBody: {},

	editMessage: function(e) {
		var self = this,
			msg = $(e.target).closest('li.message'),
			body = msg.find('.msg-body').first(),
			wikiaEditor = body.data('wikiaEditor'),
			id = msg.attr('data-id'),
			bubble = msg.find('.speech-bubble-message').first(),
			animation = {};

		e.preventDefault();

		this.setOldHTML(id, bubble);

		msg.find('.timestamp').hide();
		$('.follow', bubble).hide();
		msg.find('.wikia-menu-button').removeClass('active');

		// Animate to proper size
		body.closest('.speech-bubble-message').animate(animation, function() {

			// We need to load assets first in order to determine the proper startup mode
			if (!MiniEditor.assetsLoaded) {
				MiniEditor.loadAssets(initEditor);

			} else {
				initEditor();
			}
		});

		$('.msg-title textarea.title', msg).autoResize({
			min: 30,
			limit: 256,
			extraSpace: 15
		});

		// Initialize the editor after assets are loaded
		function initEditor() {
			var mode = MiniEditor.getStartupMode(body),
				format = WikiaEditor.modeToFormat(mode);

			// show message title textarea
			msg.find('.msg-title').first().html('<textarea class="title">' + msg.find('.msg-title a').html() + '</textarea>');

			// Load the editor data in the proper mode
			self.model.loadEditData(self.page, id, 'edit', format, function(data) {
				var hasEdgeCases = typeof data.edgeCases != 'undefined';

				if (wikiaEditor) {
					wikiaEditor.fire('editorActivated');

					// Force source mode if edge cases are found.
					if (hasEdgeCases) {
						wikiaEditor.ck.setMode('source');
					}

					wikiaEditor.setContent(data.htmlorwikitext);

				} else {

					// Set content on element before initializing to keep focus in editbox (BugId:24188).
					body.html(data.htmlorwikitext).miniEditor({
						config: {
							animations: MiniEditor.Wall.Animations,

							// Force source mode if edge cases are found.
							mode: hasEdgeCases ? 'source' : MiniEditor.config.mode
						}
					});
				}
			});
		}
	},

	getNewBody: function(msg) {
		return $('.msg-body', msg).first().data('wikiaEditor').getContent();
	},

	getEditFormat: function(msg) {
		var wikiaEditor = $('.msg-body', msg).first().data('wikiaEditor');

		// Format starts as wikitext, so let's check if we need to convert it to RTEHtml
		// Return the desired message format or empty string if no conversion is necessary.
		return (MiniEditor.ckeditorEnabled && (!wikiaEditor || (wikiaEditor && wikiaEditor.mode != 'source'))) ? 'richtext' : '';
	},

	// if we're in wysiwyg mode, convert message to wikitext to save.
	// Otherwise, don't convert cuz we already have wikitext.
	getSaveFormat: function(msg) {
		return $('.msg-body', msg).first().data('wikiaEditor').mode == 'wysiwyg' ? 'wikitext' : '';
	},

	// Insert old html upon cancelling an edit or source view.
	insertOldHTML: function(id, bubble) {
		$('.msg-title', bubble).html(this.oldTitle[id]);
		$('.msg-body', bubble).html(this.oldBody[id]);
	},

	// Set current html in case edit or source view is cancelled.
	setOldHTML: function(id, bubble) {
		this.oldTitle[id] = bubble.find('.msg-title').html();
		this.oldBody[id] = bubble.find('.msg-body').html();
	},

	afterCancel: function(body, isSource, target, bubble) {
		if (isSource) {
			target.parent().hide();
			bubble.find('.timestamp').show();
		} else {
			this.afterClose(bubble);
			body.data('wikiaEditor').fire('editorReset');
		}
	},

	resetHTMLAfterEdit: function(id, bubble) {
		$('.msg-body', bubble).first().data('wikiaEditor').fire('editorReset');

		this.afterClose(bubble);
	},

	afterClose: function(bubble) {
		$('.follow', bubble).show();
		bubble.find('.timestamp').show();

		if (!bubble.parent().data('is-reply')) {
			bubble.animate({});
		}
	}
});

// Set as default class binding for EditMessageForm
Wall.settings.classBindings.editMessageForm = MiniEditor.Wall.EditMessageForm;

})(jQuery);
