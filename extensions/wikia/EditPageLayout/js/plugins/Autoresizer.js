(function(window, $) {

	var $window = $( window );
	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	/**
	 * Automatically resizes editor area depenging on mode
	 * which is specified in config.autoResizeMode:
	 * - editarea - makes the editor fit into browser window
	 * - editpage - force editor minimum height
	 */
	WE.plugins.autoresizer = $.createClass(WE.plugin,{

		requires: ['sizechangedevent'],

		editarea: false,
		editbox: false,

		// contains any offset heights that will have an overall effect on the
		// height of the editbox element.
		editboxOffsetHeight: 0,
		mode: false,
		minPageHeight: 300,
		rightrail: false,
		widemode: false,
		wikiaBarEnabled: false,

		beforeInit: function() {
			this.mode = this.editor.config.autoResizeMode;
			this.wikiaBarEnabled = window.wgEnableWikiaBarExt && typeof window.WikiaBar === 'object';
			if (this.mode !== false) {
				this.editor.on('editboxReady',this.proxy(this.editboxReady));
				this.editor.on('mode',this.proxy(this.delayedResize));
				this.editor.on('toolbarsRendered',this.proxy(this.delayedResize));
				this.editor.on('sizeChanged',this.proxy(this.delayedResize));
				this.editor.on('mainpagewidemodeinit', this.proxy(function() {
					this.widemode = true;
				}));
			}
		},

		initDom: function() {
			this.editarea = $('#EditPageEditor');
			this.editPage = $('#EditPage');
			this.editPageEditorWrapper = $('#EditPageEditorWrapper');
			this.editPageMain = $('#EditPageMain');
			this.wikiaBarWrapper = $('#WikiaBarWrapper');

			// keep right rail within browser's viewport (BugId:7498)
			if (this.widemode === false) {
				this.rightrail = this.editor.getSpace('rail');
			}

			if (this.enabled) {
				this.delayedResize();
			}
		},

		editboxReady: function(editor, editbox) {
			var node,
				footerHeight = $("#WikiaFooter").outerHeight(true) || 0,
				offsetHeight = 0,
				self = this;

			this.editbox = editbox;

			if (!footerHeight) {
				this.editarea.addClass("noFooter");
			}

			// travel all the way up to the editor wrapper and remove any heights from margins/padding/borders
			this.editbox.parentsUntil(this.editPageEditorWrapper).andSelf().each(function() {
				node = $(this);
				offsetHeight += (node.outerHeight(true) - node.height());
			});

			this.editboxOffsetHeight = (offsetHeight + footerHeight);

			this.delayedResize();

			// BugId: 68871 force document to reflow (Safari 6 on OSX 10.8 bug - impossible to scroll iframe content)
			this.editbox.css('visibility', 'visible');

		},

		delayedResize: function() {
			setTimeout(this.proxy(this.resize),10);
		},

		// get height needed to fit given node into browser's viewport height
		getHeightToFit: function(node) {
			var topOffset = node.offset().top,
				viewportHeight = $window.height(),
				dimensions = {
					nodeHeight: parseInt(viewportHeight - topOffset - this.editboxOffsetHeight),
					viewportHeight: viewportHeight
				};

			if ( this.wikiaBarEnabled && !this.wikiaBarWrapper.hasClass('hidden') ) {
				dimensions.nodeHeight -= this.wikiaBarWrapper.outerHeight(true);
			}

			if ( dimensions.nodeHeight < this.minPageHeight ) {
				dimensions.nodeHeight = this.minPageHeight;
			}

			return dimensions;
		},

		resize: function() {
			switch(this.mode) {
				// resize editor area
				case 'editarea':
					if ( this.editbox ) {
						var dimensions = this.getHeightToFit(this.editbox);
						if ( dimensions.viewportHeight > this.minPageHeight ) {
							this.editbox.height( dimensions.nodeHeight );
						}
					}
					break;

				// resize whole page (edit conflicts)
				case 'editpage':
					this.editarea.css('minHeight', this.getHeightToFit(this.editarea).nodeHeight);
					break;
			}

			// set height of right rail (BugId:7498)
			// make sure it's the same height as #EditPageMain (BugId:16542)
			if (this.rightrail) {
				this.rightrail.height(this.editPageMain.height());
			}
		}
	});
})(this, jQuery);