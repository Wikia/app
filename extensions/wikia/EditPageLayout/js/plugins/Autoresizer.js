(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable);

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
		editboxParentPadding: 0,
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
			
			if (!wgUserName) {
				$('#EditPageEditor').css('margin-bottom', 10);
			}
		},

		editboxReady: function(editor, editbox) {
			this.editbox = editbox;

			// add padding from textarea wrapper on permission error pages (BugId:10562)
			var editboxParent = editbox.parent();
			if (editboxParent) {
				this.editboxParentPadding = editboxParent.outerHeight() - editboxParent.height();
			}

			this.delayedResize();
		},

		delayedResize: function() {
			setTimeout(this.proxy(this.resize),10);
		},

		// get height needed to fit given node into browser's viewport height
		getHeightToFit: function(node) {
			var topOffset = node.offset().top,
				viewportHeight = $(window).height(),
				footerHeight = $('#WikiaFooter').outerHeight(),
				dimensions = {
					nodeHeight: parseInt(viewportHeight - topOffset - this.editboxParentPadding - footerHeight - 1),
					viewportHeight: viewportHeight
				};

			return dimensions;
		},

		resize: function() {
			switch(this.mode) {
				// resize editor area
				case 'editarea':
					if (this.editbox && this.getHeightToFit(this.editbox).viewportHeight > this.minPageHeight) {
						this.editbox.height(this.getHeightToFit(this.editbox).nodeHeight);
						if (!wgUserName) {
							$('#cke_contents_wpTextbox1').height(this.editbox.height() - 10);
						}
					}
					break;

				// resize whole page (edit conflicts)
				case 'editpage':
					this.editarea.css('minHeight', this.getHeightToFit(this.editarea).nodeHeight);
					break;
			}

			// set height of right rail (BugId:7498)
			if (this.rightrail) {
				this.rightrail.height(this.getHeightToFit(this.rightrail).nodeHeight);
			}
		}
	});

})(this,jQuery);
