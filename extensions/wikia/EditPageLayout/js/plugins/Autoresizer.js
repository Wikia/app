(function(window,$){

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
		minPageHeight: 500,
		rightrail: false,
		widemode: false,

		beforeInit: function() {
			this.mode = this.editor.config.autoResizeMode;
			if (this.mode !== false) {
				this.editor.on('editboxReady',this.proxy(this.editboxReady));
				this.editor.on('mode',this.proxy(this.delayedResize));
				this.editor.on('toolbarsRendered',this.proxy(this.delayedResize));
				this.editor.on('sizeChanged',this.proxy(this.delayedResize));
				this.editor.on('mainpagewidemodeinit', this.proxy(function() {
					this.widemode = true;
				}));
			}

			this.editarea = $('#EditPageEditor');
		},

		initDom: function() {
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
			this.editbox.parentsUntil("#EditPageEditorWrapper").andSelf().each(function() {
				node = $(this);
				offsetHeight += (node.outerHeight(true) - node.height());
			});

			this.editboxOffsetHeight = (offsetHeight + footerHeight);

			this.delayedResize();
		},

		delayedResize: function() {
			setTimeout(this.proxy(this.resize),10);
		},

		// get height needed to fit given node into browser's viewport height
		getHeightToFit: function(node) {
			var topOffset = node.offset().top,
				viewportHeight = $(window).height(),
				dimensions = {
					nodeHeight: parseInt(viewportHeight - topOffset),
					viewportHeight: viewportHeight
				};

			if( window.wgEnableWikiaBarExt && typeof(window.WikiaBar) === 'object' ) {
			//old admin tool bar had position relative and was always at the bottom
			//with the admin tool bar in WikiaBar container we want it to be at the bottom but
			//to have the page hight fit viewportHeight
				dimensions.nodeHeight = this.getDimensionsWithWikiaBar(dimensions.nodeHeight);
			}

			return dimensions;
		},

		getDimensionsWithWikiaBar: function(nodeHeight) {
			var editorHeight = $('#EditPage').outerHeight(true) || 0,
				editorToolbarHeight = $('#EditPageToolbar').height() || 0,
				editPageEditorWrapperHeight = $('#EditPageEditorWrapper').outerHeight(true) || 0,
				editorBottomBorder = editorHeight - editorToolbarHeight - editPageEditorWrapperHeight,
				wikiaBarOffset = window.WikiaBar.getWikiaBarOffset(),
				newEditAreaHeight = parseInt( (nodeHeight - editorBottomBorder - wikiaBarOffset), 10);

			//bugId:49405; quick fix for edit page with a really, really long diff
			return (newEditAreaHeight <= 0) ? this.minPageHeight : newEditAreaHeight;
		},

		resize: function() {
			switch(this.mode) {
				// resize editor area
				case 'editarea':
					if( this.editbox ) {
						var cachedDimensions = this.getHeightToFit(this.editbox);
						if( cachedDimensions.viewportHeight > this.minPageHeight ) {
							this.editbox.height(cachedDimensions.nodeHeight);
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
				this.rightrail.height($('#EditPageMain').height());
			}
		}
	});

})(this,jQuery);
