(function(window, $) {
	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable);

	WE.plugins.MiniEditor = $.createClass(WE.plugin, {

		// Whether or not this instance is currently active.
		// "Active" means that the editor is visible and ready to use
		isActive: false,
		hasFocus: false,
		blurTimout: false,

		init: function() {
			this.editor.on('editorActivated', this.proxy(this.editorActivated));
			this.editor.on('editorDeactivated', this.proxy(this.editorDeactivated));
			this.editor.on('editorFocus', this.proxy(this.editorFocus));
			this.editor.on('editorBlur', this.proxy(this.editorBlur));
			this.editor.on('editorClear', this.proxy(this.editorClear));
			this.editor.on('editorResize', this.proxy(this.editorResize));
			this.editor.on('editorReady', this.proxy(this.editorReady));

			// This event will be ignored for non CK editors
			this.editor.on('ck-instanceReady', this.proxy(this.ckInstanceReady));
		},

		// CKE properties are now available for CK editors
		ckInstanceReady: function() {
			var ckeditor = this.editor.ck,
				self = this;
			
			ckeditor.focus();
			
			// when ckeditor dialogs open and close, toggle this.hasFocus so editor doesn't shrink up
			ckeditor.on('dialogShow', function() { 
				self.hasFocus = true;
			});

			ckeditor.on('dialogHide', function() { 
				self.hasFocus = false;
			});
		},

		// Editor is ready!
		editorReady: function() {
			var wikiaEditor = this.editor,
				ckeditor = wikiaEditor.ck,
				editorElement = wikiaEditor.getEditorElement();

			this.originalHeight = editorElement.outerHeight(true);

			// Cache commonly accessed elements
			this.buttonsWrapper = $('#' + wikiaEditor.instanceId + 'Buttons');
			this.buttons = this.buttonsWrapper.find('button');
			this.toolbar = wikiaEditor.getSpace('toolbar');

			// Remove visibility styles that we added for the loading status indicator
			editorElement.css('visibility', '');

			// Editor resizing
			wikiaEditor.getEditbox().bind('keyup.MiniEditor', this.proxy(this.editorResize)).keyup();
			
			// Handle positioning of RTEOverlay (image overlay etc) for CKE
			if (ckeditor) {
				wikiaEditor.getEditboxWrapper().bind('mouseenter.MiniEditor', function() {
					RTE.repositionRTEOverlay(ckeditor.name);
					RTE.overlayNode.data('editor', wikiaEditor);
				});
			}
			
			// Clicking inside editor area should not blur the editor (BugId:18713)
			wikiaEditor.element.parent().bind('click.MiniEditor', function(e) {
				var target = $(e.target);
				if(!target.is('textarea')) {
					wikiaEditor.editorFocus();		
				}
			});

			// Finish benchmarking initialization time
			MiniEditor.initTime = (new Date().getTime() - MiniEditor.initTimer.getTime());
			$().log('End initialization (' + MiniEditor.initTime + 'ms)', 'MiniEditor');
			$().log('Time consumed until ready: ' + ((MiniEditor.loadTime + MiniEditor.initTime) / 1000) + 's', 'MiniEditor');
		},

		editorFocus: function() {
			clearTimeout(this.blurTimout)
			this.editor.setAsActiveInstance();
			this.hasFocus = false;
			this.editor.element.addClass('focused');
			this.editorActivated();
		},

		editorBlur: function() {
			console.log('blurred')
			var self = this;
			self.blurTimout = setTimeout(function() {
				if(self.hasFocus) {
					self.hasFocus=false;
					return;
				}
				self.editor.element.removeClass('focused');
				self.editorDeactivated();			
			}, 200)
		},

		editorActivated: function(fromFocus) {
			var self = this,
				element = this.editor.getEditorElement(),
				animation = { height: self.editor.config.minHeight },
				wrapper = this.editor.getEditboxWrapper();

			if (!wrapper.is(":visible")) {
				if (this.editor.ck) {
					// Hide the original textarea
					var elementHeight = element.height();
					element.hide().blur();

					// Switch to CKE and transition from original textarea height
					wrapper
						.height(elementHeight)
						.show()
						.animate(animation, function() {
							self.editor.getEditbox().show().focus();
						});
				} else {
					element.animate(animation);
				}
			}

			this.showButtons();
			this.showToolbar();
			this.isActive = true;
			this.editor.log('activated "' + this.editor.instanceId + '"');
		},

		editorDeactivated: function(force) {
			var self = this,
				wikiaEditor = this.editor,
				element = wikiaEditor.getEditorElement(),
				animation = { height: self.originalHeight };

			// if the textarea is already visible, no need to do animation
			if (!element.is(":visible")) {

				// only hide if there's no content or we're forcing a switch
				if (!this.editor.getContent() || force) { 
					// if the editor started as a div instead of a textarea, don't do animation
					if(!wikiaEditor.fromDiv) {
						if (this.editor.ck) {
							var wrapper = this.editor.getEditboxWrapper();
		
							// Transition back to the original textarea
							wrapper.animate(animation, function() {
								wrapper.hide();
								element.show().blur();
							});
		
						} else {
							element.animate(animation);
						}
					}
					this.hideButtons();
				}
			}

			this.hideToolbar();
			this.isActive = false;
			this.editor.log('deactivated "' + this.editor.instanceId + '"');
		},

		// Resizes the editor on keydown between min height and max height
		editorResize: function() {
			var editbox = this.editor.getEditbox(),
				currentHeight = editbox.outerHeight(true),
				newHeight = currentHeight > this.editor.config.maxHeight ?
					this.editor.config.maxHeight : currentHeight > this.editor.config.minHeight ?
						currentHeight : this.editor.config.minHeight;

			if (this.editor.ck) {
				this.editor.getEditboxWrapper().height(newHeight);

				// Hack to fix a scrollbar appearing for CKE when resizing
				editbox.parent().toggleClass('resizing', newHeight < this.editor.config.maxHeight);

			} else {
				editbox.height(newHeight);
			}
		},

		showButtons: function() {
			this.buttonsWrapper.slideDown();
			this.buttons.removeAttr('disabled');
		},

		hideButtons: function() {
			this.buttonsWrapper.slideUp();
			this.buttons.attr('disabled', true);
		},

		showToolbar: function() {
			this.toolbar.slideDown();
		},

		hideToolbar: function() {
			this.toolbar.slideUp();
		},

		editorClear: function() {
			if (this.editor.ck) {
				this.editor.ck.setData('');
			} else {
				this.editor.getEditorElement().val('');
			}
		},

		reset: function(elementId) {
			this.editor.ui.uiReadyFired = false;
			
			if (this.editor.ck) {
				this.editor.ck.destroy();
			}
		}
	});

})(this,jQuery);