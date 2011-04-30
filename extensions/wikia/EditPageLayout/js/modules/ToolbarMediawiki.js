(function(window){

	var WE = window.WikiaEditor;

	WE.modules.ToolbarMediawiki = $.createClass(WE.modules.base,{

		// this module is only visible in source mode
		modes: {
			source: true
		},

		toolbarBuilt: false,

		template: '<div class="cke_toolbar_source" id="cke_toolbar_source_<%= id %>"></div>',

		getData: function() {
			return {
				id: this.id
			};
		},

		init: function() {
			WE.modules.ToolbarMediawiki.superclass.init.call(this);
			this.id = WE.modules.ToolbarMediawiki.nextId++;
		},

		copyFromToolbar: function() {
			var els = $('#toolbar').children().not('script');
			if (els.exists() && this.toolbarBuilt) {
				$(this.toolbarNode).append(els);
			}
		},

		buildToolbar: function( toolbarNode ) {
			var editor = this.editor;
			function addButton(button) {
				if (editor.fire('beforemediawikibutton',editor,button)) {
					mwInsertEditButton(toolbarNode,button);
				}
			}
			// add buttons
			for (var i = 0; i < mwEditButtons.length; i++) {
				addButton(mwEditButtons[i]);
			}
			for (var i = 0; i < mwCustomEditButtons.length; i++) {
				addButton(mwCustomEditButtons[i]);
			}
			GlobalTriggers.fire("beforeMWToolbarRender",toolbarNode);

			this.toolbarNode = toolbarNode;
			this.toolbarBuilt = true;

			var self = this;
			this.copyFromToolbar();
			setTimeout(function(){ self.copyFromToolbar(); },1000);
			this.editor.log('loading source mode toolbar');
		},

		afterRender: function() {
			this.editor.on({
				mode: this.modeChanged,
				scope: this
			});
			this.modeChanged();
		},

		modeChanged: function() {
			var mode = this.editor.mode;

			// toolbar's lazy loading
			if (mode == 'source') {
				if (!this.toolbarBuilt) {
					this.buildToolbar(this.el.get(0));
				}
			}
		}
		
	});

	WE.modules.ToolbarMediawiki.nextId = 1;

})(this);