(function(window, $) {
	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	WE.plugins.MiniEditor = $.createClass(WE.plugin, {

		isReady: false,

		proxyEvents: [
			'ck-instanceReady',
			'editorActivated',
			'editorAfterActivated',
			'editorBeforeReady',
			'editorBlur',
			'editorClear',
			'editorDeactivated',
			'editorAfterDeactivated',
			'editorFocus',
			'editorReady',
			'editorReset',
			'editorResize',
			'editorKeyUp'
		],

		beforeInit: function() {
			console.trace('WE.plugins');		var i = 0,
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
		console.trace('WE.plugins');
			// The height of the element we are replacing
			this.originalHeight = this.editor.config.body.outerHeight(true);

			// Cache commonly accessed elements
			this.toolbar = this.editor.getSpace('toolbar');
			this.buttonsWrapper = this.editor.getSpace('buttons');

			if (this.buttonsWrapper.length) {
				this.buttons = this.buttonsWrapper.find('button, input[submit]');
			}

			// TODO: instead of having separate events for every type of content
			// insertion method we should have a universal 'content has changed' event.
			this.editor.on( 'editorAddMedia', this.proxy( this.editorKeyUp ) );
			this.editor.on( 'editorAddLink', this.proxy( this.editorKeyUp ) );
			this.editor.on( 'editorInsertTags', this.proxy( this.editorKeyUp ) );
		},

		// CKE properties are now available
		'ck-instanceReady': function() {
			var wikiaEditor = this.editor,
				ckeditor = wikiaEditor.ck;

			// Handle positioning of RTEOverlay (image overlay etc)
			wikiaEditor.getEditboxWrapper().bind('mouseenter.MiniEditor', function() {
				RTE.repositionRTEOverlay(ckeditor.name);
				RTE.overlayNode.data('wikiaEditor', wikiaEditor);
			});
		},

		'ck-wysiwygModeReady': function() {
			this.editorResize();
		},

		editorActivated: function(event) {
		console.trace('WE.plugins');
			$(window).on('beforeunload.PreventLeaveBeforeSave', function (e) {
				if (this.editor.getContent().length) {
					return $.msg('wikia-editor-leaveconfirm-message');
				}
			}.bind(this));

			var animations = this.editor.config.animations;

			// Don't activate if target is not body. Basically, this means the editor
			// was focused by something other than its editbox. If the body has been focused
			// since editor initialization began, ignore the event.
			if (event && event.target != this.editor.config.body.get(0)) {
				return;

			} else if (!this.editor.element.hasClass('active')) {
				this.editor.element.removeClass('preloading');

				if ($.isFunction(animations.editorActivated)) {
					animations.editorActivated.apply(this, [event, this.editor]);
				}

			} else {
				this.editor.fire('editorAfterActivated');
			}

			this.editor.element.addClass('active');
		},

		editorKeyUp: function() {
			console.trace('WE.plugins');		this.editorToggleButtonsDisabled();

			if ( this.editor.ck != undefined ) {
				this.editorResize();
			}
		},

		editorToggleButtonsDisabled: function() {
			console.trace('WE.plugins');		this.buttons.prop( 'disabled', !this.editor.getContent().length );
		},

		editorAfterActivated: function() {
			console.trace('WE.plugins');		this.showButtons();
			this.showToolbar();

			this.editor.element.addClass('editor-open').removeClass('editor-closed');

			if (!this.isReady) {
				this.isReady = true;
			}
		},

		editorBeforeReady: function() {
			console.trace('WE.plugins');		// Intentionally blank. Used by editor element (see proxy events above).
		},

		editorBlur: function() {
			console.trace('WE.plugins');		this.editor.element.removeClass('focused');
		},

		editorClear: function() {
			console.trace('WE.plugins');		if (this.editor.ck) {
				this.editor.ck.setData('');

			} else {
				this.editor.getEditbox().val('');
			}
		},

		editorDeactivated: function(force) {
			console.trace('WE.plugins');		$(window).off('beforeunload.PreventLeaveBeforeSave');
			var animations = this.editor.config.animations;

			this.hideToolbar();

			if (this.editor.element.hasClass('active') || force) {
				if ($.isFunction(animations.editorDeactivated)) {
					animations.editorDeactivated.apply(this, [this.editor, force]);
				}
			}

			this.editor.element.removeClass('active');
		},

		editorAfterDeactivated: function() {
			console.trace('WE.plugins');		this.editor.element.removeClass('editor-open').addClass('editor-closed');
		},

		editorFocus: function() {
			console.trace('WE.plugins');		if (this.editor.instanceId != WikiaEditor.instanceId) {
				this.editor.setAsActiveInstance();
			}

			this.editor.element.addClass('focused');
		},

		editorReady: function(event) {
		console.trace('WE.plugins');
			// Finish benchmarking initialization time
			MiniEditor.initTime = (new Date().getTime() - MiniEditor.initTimer.getTime());
			$().log('End initialization (' + MiniEditor.initTime + 'ms)', 'MiniEditor');
			$().log('Time consumed until ready: ' + ((MiniEditor.loadTime + MiniEditor.initTime) / 1000) + 's', 'MiniEditor');

			// Remove loading class from wrapper
			this.editor.element.removeClass('loading');

			// Trigger editorActivated
			this.editor.fire('editorActivated', event);

			var replacedElement = this.editor.getEditorElement();
			if(replacedElement.is('textarea') && typeof this.editor.ck != "undefined") {
				replacedElement.val("");
			}
		},

		editorReset: function() {
			console.trace('WE.plugins');		this.editor.fire('editorClear');
			this.editor.fire('editorDeactivated', true);
			this.editor.getEditorElement().blur();
		},

		// Resizes the CKEditor body tag on keydown between min height and max height
		// This doesn't work for RTE disabled.
		editorResize: function() {
			console.trace('WE.plugins');		var editbox = this.editor.getEditbox(),
				currentHeight = editbox.outerHeight(true),
				newHeight = currentHeight > this.editor.config.maxHeight ?
					this.editor.config.maxHeight : currentHeight > this.editor.config.minHeight ?
						currentHeight : this.editor.config.minHeight;

			this.editor.getEditboxWrapper().height(newHeight);

			// Hack to fix a scrollbar appearing for CKE when resizing
			editbox.parent().toggleClass('resizing', newHeight < this.editor.config.maxHeight);
		},

		hideButtons: function(callback) {
			console.trace('WE.plugins');		if (this.buttonsWrapper.length) {
				this.buttons.attr('disabled', true);
				this.buttonsWrapper.slideUp(this.proxy(callback));

			} else {
				callback.call(this);
			}
		},

		hideToolbar: function() {
			console.trace('WE.plugins');		this.toolbar.slideUp();
		},

		showButtons: function() {
			console.trace('WE.plugins');		if (this.buttonsWrapper.length) {
				this.buttonsWrapper.slideDown();
				this.buttons.show();
			}
		},

		showToolbar: function() {
			console.trace('WE.plugins');		this.toolbar.slideDown();
		}
	});

})(this, jQuery);
