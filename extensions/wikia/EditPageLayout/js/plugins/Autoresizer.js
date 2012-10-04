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

			/** Start of Wikia change @author nAndy **/
			//FIXME: talk to Władek/Macbre about better way of making it and moving this logic maybe to new class which extends this one
			if( window.wgEnableWikiaBarExt ) {
				var mainHeight = $('#EditPageMain').height() || 0,
					nodeHeight = node.height() || 0,
					toolbarHeight = $('#EditPageToolbar').height() || 0,
					introHeight = $('#EditPageIntro').outerHeight(true) || 0,
					editNoticeHeight = $('#EditPageEditNotice').outerHeight(true) || 0;

				var editorBottomBorder = mainHeight - nodeHeight - toolbarHeight - introHeight - editNoticeHeight;
				dimensions.nodeHeight = parseInt(viewportHeight - topOffset - editorBottomBorder - window.WikiaBar.getWikiaBarOffset());
			}
			/** End of Wikia change **/

			return dimensions;
		},

		resize: function() {
			switch(this.mode) {
				// resize editor area
				case 'editarea':
					if (this.editbox && this.getHeightToFit(this.editbox).viewportHeight > this.minPageHeight) {
						this.editbox.height(this.getHeightToFit(this.editbox).nodeHeight);
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
