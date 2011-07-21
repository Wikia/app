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
		mode: false,
		rightrail: false,

		beforeInit: function() {
			this.mode = this.editor.config.autoResizeMode;
			if (this.mode !== false) {
				this.editor.on('editboxReady',this.proxy(this.editboxReady));
				this.editor.on('mode',this.proxy(this.delayedResize));
				this.editor.on('toolbarsRendered',this.proxy(this.delayedResize));
				this.editor.on('sizeChanged',this.proxy(this.delayedResize));
			}

			this.editarea = $('#EditPageEditor');
		},

		initDom: function() {
			// keep right rail within browser's viewport (BugId:7498)
			this.rightrail = this.editor.getSpace('rail');

			if (this.enabled) {
				this.delayedResize();
			}
		},

		editboxReady: function( editor, editbox ) {
			this.editbox = editbox;
			this.delayedResize();
		},

		delayedResize: function() {
			setTimeout(this.proxy(this.resize),10);
		},

		// get height needed to fit given node into browser's viewport height
		getHeightToFit: function(node) {
			var topOffset = node.offset().top,
				viewportHeight = $(window).height();

			return viewportHeight - topOffset;
		},

		resize: function() {
			switch(this.mode) {
				// resize editor area
				case 'editarea':
					if (this.editbox) {
						this.editbox.height(this.getHeightToFit(this.editbox));
					}
					break;

				// resize whole page (edit conflicts)
				case 'editpage':
					this.editarea.css('minHeight', this.getHeightToFit(this.editarea));
					break;
			}

			// set height of right rail (BugId:7498)
			this.rightrail.height(this.getHeightToFit(this.rightrail));
		}
	});

})(this,jQuery);
