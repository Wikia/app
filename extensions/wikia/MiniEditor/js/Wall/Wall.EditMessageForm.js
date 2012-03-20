(function(window, $) {

	// Edit Message
	var MiniEditorEditMessageForm = $.createClass(WallEditMessageForm, {
		oldTitle: {},
		oldBody: {},

		editMessage: function(e) {
			var self = this,
				msg = $(e.target).closest('li.message'),
				body = msg.find('.msg-body').first(),
				wikiaEditor = body.data('wikiaEditor'),
				mode = MiniEditor.getLoadConversionFormat(body),
				id = msg.attr('data-id'),
				bubble = msg.find('.speech-bubble-message').first(),
				animation = msg.data('is-reply') ? {} : {
					'padding-top': 10,
					'padding-left': 10,
					'padding-right': 10,
					'padding-bottom': 10
				};

			e.preventDefault();

			this.setOldHTML(id, bubble);
			this.track('wall/message/action/edit');

			msg.find('.timestamp').hide();
			msg.find('.buttons').first().hide();
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

			// Initialize the editor after assets are loaded
			function initEditor() {

				// show message title textarea
				msg.find('.msg-title').first().html('<textarea class="title">' + msg.find('.msg-title a').html() + '</textarea>');

				// Load the editor data in the proper mode
				self.model.loadEditData(self.username, id, 'edit', mode, function(data) {

					// If edgecases were found, force source mode
					if (typeof data.edgeCases != 'undefined') {
						mode = 'source';
					}

					if (wikiaEditor) {
						wikiaEditor.fire('editorActivated');
						wikiaEditor.ck.setMode(mode);
						wikiaEditor.ck.setData(data.htmlorwikitext);

					} else {
						body.miniEditor({
							config: { mode: mode },
							events: {
								editorReady: function(event, wikiaEditor) {
									wikiaEditor.setContent(data.htmlorwikitext);
								}
							}
						});
					}
				});
			}
		},

		getNewBodyVal: function(msg) {
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
				bubble.animate({
					'padding-top': 10,
					'padding-left': 20,
					'padding-right': 20,
					'padding-bottom': 10
				});
			}
		}
	});

	// Exports
	window.MiniEditorEditMessageForm = MiniEditorEditMessageForm;

})(this, jQuery);