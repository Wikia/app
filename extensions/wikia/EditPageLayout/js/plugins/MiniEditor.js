(function(window, $) {
	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	WE.plugins.MiniEditor = $.createClass(WE.plugin, {

		proxyEvents: [
			'ck-instanceReady', 'ck-wysiwygModeReady', 'editorActivated',
			'editorBeforeReady', 'editorBlur', 'editorClear',
			'editorDeactivated', 'editorFocus', 'editorReady',
			'editorReset', 'editorResize'
		],

		beforeInit: function() {
			var i = 0,
				l = this.proxyEvents.length;

			// Set up proxy events on the body element
			// This will allow events fired on the wikiaEditor instance to
			// be passed on to the body element for handling elsewhere.
			for (; eventName = this.proxyEvents[i], i < l; i++) {
				(function(eventName) {
					this.editor.on(eventName, this.proxy(function() {
						this[eventName].apply(this, arguments);
						this.editor.config.body.triggerHandler(eventName, [this.editor].concat(arguments));
					}));
				}).call(this, eventName);
			}
		},

		init: function() {

			// The height of the element we are replacing
			this.originalHeight = this.editor.config.body.outerHeight(true);

			// Cache commonly accessed elements
			this.toolbar = this.editor.getSpace('toolbar');
			this.buttonsWrapper = this.editor.getSpace('buttons');

			if (this.buttonsWrapper.length) {
				this.buttons = this.buttonsWrapper.find('button');
			}
		},

		// CKE properties are now available
		'ck-instanceReady': function() {
			var self = this,
				wikiaEditor = this.editor,
				ckeditor = wikiaEditor.ck;

			// Handle positioning of RTEOverlay (image overlay etc)
			wikiaEditor.getEditboxWrapper().bind('mouseenter.MiniEditor', function() {
				RTE.repositionRTEOverlay(ckeditor.name);
				RTE.overlayNode.data('editor', wikiaEditor);
			});
		},

		// Re-bind event listenners for elements inside wysiwyg iframe
		'ck-wysiwygModeReady': function() {
			this.editor.getEditbox().bind('keyup.MiniEditor', this.proxy(this.editorResize)).keyup();		
		},

		editorActivated: function(isFirstActivation) {
			var self = this,
				wikiaEditor = this.editor,
				element = wikiaEditor.getEditorElement(),
				wrapper = wikiaEditor.getEditboxWrapper(),
				animation = { height: wikiaEditor.config.minHeight },
				afterAnimation = function() {
					this.showButtons();
					this.showToolbar();
					wikiaEditor.element.addClass('editor-open').removeClass('editor-closed');
				};

			if (!wikiaEditor.element.hasClass('active')) {
				if (wikiaEditor.ck) {
					var hasContent = wikiaEditor.getContent();

					// CKEDITOR resizes itself on initialization, which means setting
					// wrapper height to match the element height would result in the
					// wrapper shrinking then expanding again. Also don't need to
					// animate if there is content, it will already be the proper height.
					if (!isFirstActivation && !hasContent) {
						wrapper.height(element.height()).show();
					}

					// Animate to proper height, then focus
					// If editor already has content, editorResize will handle animations
					if (hasContent) {
						afterAnimation.call(self);

					} else {
						wrapper.animate(animation, function() {
							wikiaEditor.getEditbox().focus();
							afterAnimation.call(self);
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
						if (isFirstActivation) {
							// Temporary solution to show scrollbar in the textarea 
							// until we enable autoresizing when RTE is disabled. 
							textarea.css('overflow', 'auto').animate(animation, this.proxy(afterAnimation));

						} else {
							textarea.show();
							afterAnimation.call(this);
						}

					} else {
						element.animate(animation, this.proxy(afterAnimation));
					}
				}

			} else {
				afterAnimation.call(this);
			}

			// Mark as active
			wikiaEditor.element.addClass('active');
		},

		editorBeforeReady: function() {
		},

		editorBlur: function() {
			this.editor.element.removeClass('focused');
		},

		editorClear: function() {
			var ckeditor = this.editor.ck;

			if (ckeditor) {
				ckeditor.setData('');

			} else {
				this.editor.getEditbox().val('');
			}
		},

		editorDeactivated: function(force) {
			var self = this,
				wikiaEditor = this.editor,
				element = wikiaEditor.getEditorElement(),
				animation = { height: self.originalHeight };

			this.hideToolbar();

			if (wikiaEditor.element.hasClass('active') || force) {

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

						wikiaEditor.element.removeClass('editor-open').addClass('editor-closed');					
					});
				}
			}

			// Mark as inactive
			wikiaEditor.element.removeClass('active');
		},

		editorFocus: function() {
			if (this.editor.instanceId != WikiaEditor.instanceId) {
				this.editor.setAsActiveInstance();
			}

			this.editor.element.addClass('focused');
		},

		editorReady: function() {
			var wikiaEditor = this.editor,
				ckeditor = wikiaEditor.ck;

			// Finish benchmarking initialization time
			MiniEditor.initTime = (new Date().getTime() - MiniEditor.initTimer.getTime());
			$().log('End initialization (' + MiniEditor.initTime + 'ms)', 'MiniEditor');
			$().log('Time consumed until ready: ' + ((MiniEditor.loadTime + MiniEditor.initTime) / 1000) + 's', 'MiniEditor');

			// Remove visibility styles that we added for the loading status indicator
			wikiaEditor.config.body.css('visibility', '');

			// Trigger editorActivated
			wikiaEditor.fire('editorActivated', true);
		},

		editorReset: function() {
			this.editor.fire('editorClear');
			this.editor.fire('editorDeactivated', true);
			this.editor.getEditorElement().blur();
		},

		// Resizes the CKEditor body tag on keydown between min height and max height
		// This doesn't work for RTE disabled.   
		editorResize: function() {
			var editbox = this.editor.getEditbox(),
				currentHeight = editbox.outerHeight(true),
				newHeight = currentHeight > this.editor.config.maxHeight ?
					this.editor.config.maxHeight : currentHeight > this.editor.config.minHeight ?
						currentHeight : this.editor.config.minHeight;

			this.editor.getEditboxWrapper().height(newHeight);
			
			// Hack to fix a scrollbar appearing for CKE when resizing
			editbox.parent().toggleClass('resizing', newHeight < this.editor.config.maxHeight);
		},

		hideButtons: function(callback) {
			if (this.buttonsWrapper.length) {
				this.buttons.attr('disabled', true);
				this.buttonsWrapper.slideUp(this.proxy(callback));

			} else {
				callback.call(this);
			}
		},

		hideToolbar: function() {
			this.toolbar.slideUp();
		},

		showButtons: function() {
			if (this.buttonsWrapper.length) {
				this.buttonsWrapper.slideDown();
				this.buttons.show().removeAttr('disabled');
			}
		},

		showToolbar: function() {
			this.toolbar.slideDown();
		}
	});

})(this, jQuery);