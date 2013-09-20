(function($) {

MiniEditor.Wall = MiniEditor.Wall || {};
MiniEditor.Wall.Animations = {
	editorActivated: function(event, wikiaEditor) {
		var element = wikiaEditor.getEditorElement(),
			wrapper = wikiaEditor.getEditboxWrapper(),
			animation = { height: wikiaEditor.config.minHeight };

		if (wikiaEditor.ck) {
			var hasContent = wikiaEditor.getContent();

			// CKEDITOR resizes itself on initialization, which means setting
			// wrapper height to match the element height would result in the
			// wrapper shrinking then expanding again. Also don't need to
			// animate if there is content, it will already be the proper height.
			if (this.isReady && !hasContent) {
				wrapper.height(element.height()).show();
			}

			// Animate to proper height, then focus
			// If editor already has content, editorResize will handle animations
			if (hasContent) {
				wikiaEditor.fire('editorAfterActivated');

			} else {
				wrapper.animate(animation, function() {
					wikiaEditor.getEditbox().focusNoScroll();
					wikiaEditor.fire('editorAfterActivated');
				});
			}

			// Make sure the original element is hidden
			element.hide();

		} else {

			// If element isn't a textarea, we are dealing with content
			// editing. Instead of animating we will need to do a swap.
			if (!element.is('textarea')) {
				var textarea = wikiaEditor.getEditbox();

				element.hide();

				// Only animate on first time showing the edit instance
				if (!this.isReady) {
					// Temporary solution to show scrollbar in the textarea
					// until we enable autoresizing when RTE is disabled.
					textarea.css('overflow', 'auto').animate(animation, function() {
						wikiaEditor.fire('editorAfterActivated');
					});

				} else {
					textarea.show();
					wikiaEditor.fire('editorAfterActivated');
				}

			} else {
				element.animate(animation, function() {
					wikiaEditor.fire('editorAfterActivated');
				});
			}
		}
	},
	editorDeactivated: function(wikiaEditor, force) {
		var element = wikiaEditor.getEditorElement(),
			animation = { height: this.originalHeight };

		// Don't animate or hide buttons if there is content
		if (!wikiaEditor.getContent()) {
			this.hideButtons(function() {
				if (wikiaEditor.ck) {
					var wrapper = wikiaEditor.getEditboxWrapper();

					// Transition back to the original textarea
					wrapper.animate(animation, function() {
						wrapper.hide();
						element.show();
					});

				} else {

					// If element isn't a textarea, we are dealing with content
					// editing. Instead of animating we will need to do a swap.
					if (!element.is('textarea')) {
						wikiaEditor.getEditbox().hide();
						element.show();

					} else {
						element.animate(animation);
					}
				}

				wikiaEditor.fire('editorAfterDeactivated');
			});
		}
	}
};

})(jQuery);