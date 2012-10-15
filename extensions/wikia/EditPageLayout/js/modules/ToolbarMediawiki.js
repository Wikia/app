(function(window){

	var WE = window.WikiaEditor;

	WE.modules.ToolbarMediawiki = $.createClass(WE.modules.base,{

		// this module is only visible in source mode
		modes: {
			source: true
		},

		toolbarBuilt: false,

		template: '<div class="cke_toolbar_source" id="cke_toolbar_source_{{id}}"></div>',

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
			var editor = this.editor,
				i,
				len,
				addButton = function(button) {
					if (editor.fire('beforemediawikibutton',editor,button)) {
						mw.toolbar.insertButton.apply(mw.toolbar, button);
					}
				};

			// use custom place for toolbar
			mw.toolbar.$toolbar = $(toolbarNode);

			// add buttons
			for (i = 0, len = mw.toolbar.buttons.length; i < len; i++) {
				addButton(mw.toolbar.buttons[i]);
			}

			// legacy buttons
			for (i = 0, len = mwCustomEditButtons.length; i < len; i++) {
				var c = mwCustomEditButtons[i];
				addButton([c.imageFile, c.speedTip, c.tagOpen,
					c.tagClose, c.sampleText, c.imageId, c.selectText, c.onclick]);
			}

			GlobalTriggers.fire("beforeMWToolbarRender",toolbarNode);

			this.toolbarNode = toolbarNode;
			this.toolbarBuilt = true;

			this.copyFromToolbar();
			setTimeout($.proxy(this.copyFromToolbar, this),1000);
			this.editor.fire('mediawikiToolbarRendered',this.editor,$(this.toolbarNode));
			this.editor.log('loading source mode toolbar');
			this.setupTracking();
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
				// Toolbar can be disabled in user preferences (BugId:40705).
				if (!this.toolbarBuilt && typeof mw.toolbar != 'undefined') {
					this.buildToolbar(this.el.get(0));
				}
			}
		},

		setupTracking: function() {
			var buttons = this.el.children('img');

			buttons.bind('click', $.proxy(function(ev) {
				var buttonId = $(ev.target).attr('id');
				this.trackButton(buttonId);
			}, this));
		},

		trackButton: function(buttonId) {
			// track clicks on #mw-editbutton-bold as "bold"
			var buttonName = buttonId.split('-').pop();

			// modify selected names to match the spec
			switch(buttonName) {
				case 'link':
					buttonName = 'linkInternal';
					break;

				case 'extlink':
					buttonName = 'linkExternal';
					break;

				case 'headline':
					buttonName = 'heading';
					break;
			}

			this.editor.track(this.editor.getTrackerInitialMode(), 'sourceToolbar', buttonName);
		}
	});

	WE.modules.ToolbarMediawiki.nextId = 1;

})(this);