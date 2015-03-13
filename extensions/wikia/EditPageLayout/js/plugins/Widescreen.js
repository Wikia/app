(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	/**
	 * Wide screen mode handling in source mode.
	 * Switched using the vertical bar at right side of the editor.
	 */
	WE.plugins.sourcewidemode = $.createClass(WE.plugin,{

		requires: ['spaces'],

		className: 'editpage-sourcewidemode',
		wideClassName: 'editpage-sourcewidemode-on',
		narrowClassName: 'editpage-sourcewidemode-off',
		storageEntry: 'wgSourceModeWidescreen',

		triggerClassName: 'editpage-widemode-trigger',

		$rail: null,
		$toolbar: null,
		$editpage: null,
		expandedToolbarBreakpoint: null,
		initialized: false,

		enabled: false,
		trigger: false,
		wide: false,

		initNodes: function() {
			this.$rail = $('#EditPageRail');
			this.$editpage = $('#EditPage');
			this.$toolbar = $('#EditPageToolbar .cke_toolbar_source');
			this.expandedToolbarBreakpoint =  this.$toolbar.width() + this.$rail.width();
			this.initialized = true;
		},

		sizeChanged: function() {
			if (this.initialized && this.editor.mode === 'source' && this.wide) {
				if (this.$editpage.width() > this.expandedToolbarBreakpoint) {
					this.$editpage.removeClass('toolbar-expanded');
				} else {
					this.$editpage.addClass('toolbar-expanded');
				}
			}
		},

		activate: function() {
			this.enabled = true;
			if (this.enabled) {
				this.active = this.editor.mode === 'source';
				// set up the trigger
				this.trigger = this.editor.element.find('.'+this.triggerClassName);
				this.trigger.click(this.proxy(this.toggle));

				// set up the editor body
				this.editor.element.addClass(this.className);

				// load the saved state (if any)
				this.loadState(true);

				this.editor.on('ck-sourceModeReady', this.modeChanged, this);

				// needed on initial load
				this.editor.on('toolbarsRendered', this.modeChanged, this);

				this.editor.on('sizeChanged', this.sizeChanged, this);
			}
		},

		modeChanged: function() {
			var toolbar = this.editor.getSpace('toolbar');

			// adjust bar height and position
			var cssTop = toolbar.offset().top + toolbar.outerHeight(true) - this.trigger.offsetParent().offset().top;

			this.trigger.css('top', cssTop);

			// resize source mode textarea in IE (BugId:6289)
			if (this.editor.ck) {
				this.editor.ck.fire('resize');
			}

			if (!this.initialized && this.editor.mode === 'source' && this.wide) {
				this.initNodes();
			}

			$(window).trigger('resize');
		},

		toggle: function() {
			this.setState(!this.getState());
			this.saveState();

			// toolbar height can change - resize the editor (BugId:5694)
			this.modeChanged();
		},

		loadState: function( initial ) {
			var wide = $.storage.get(this.storageEntry) == true;
			this.editor.log('widescreen::load() - wide = '+(wide?'true':'false'));
			if (initial) {
				if (typeof this.editor.config.wideInSourceInitial != 'undefined') {
					wide = !!this.editor.config.wideInSourceInitial;
					this.editor.log('widescreen::load() - wide[2] = '+(wide?'true':'false'));
				}
			}

			this.setState(wide);
		},

		setState: function( wide ) {
			this.wide = wide;
			this.editor.element[wide ? 'addClass' : 'removeClass'](this.wideClassName);
			this.editor.element[!wide ? 'addClass' : 'removeClass'](this.narrowClassName);
		},

		saveState: function() {
			$.storage.set(this.storageEntry,this.wide);
			$.post(window.wgScript + '?action=ajax&rs=EditPageLayoutAjax&method=setWidescreen',{
				state: this.wide ? '1' : '0'
			});
		},

		getState: function() {
			return this.editor.element.hasClass(this.wideClassName);
		}
	});

	/**
	 * Wide screen mode appearing on main page - keeps the same height of toolbar and right rail
	 */
	WE.plugins.mainpagewidemode = $.createClass(WE.plugin,{

		requires: ['spaces'],

		enabled: false,
		initialized: false,
		pageControlsHeight: false,

		activate: function() {
			this.enabled = true;
			if (this.enabled) {
				this.editor.element.addClass('editpage-visualwidemode');
				this.editor.on('toolbarsRendered',this.adjustHeights,this);
			}
		},

		init: function() {
			if (this.enabled) {
				this.editor.fire('mainpagewidemodeinit');
			}
		},

		adjustHeights: function() {
			var toolbar = this.editor.getSpace('toolbar'),
				rail = this.editor.getSpace('rail');
			if (!toolbar.exists() || !rail.exists()) {
				return;
			}

			var deltaToolbar = toolbar.innerHeight() - toolbar.height();
			toolbar.css('min-height',rail.innerHeight() - deltaToolbar);
		}
	});

	/**
	 * Wide screen chooser and manager. Lazy initializes the choosen plugin during editor load
	 */
	WE.plugins.widemodemanager = $.createClass(WE.plugin,{

		beforeInit: function() {
			var config = this.editor.config;
			if (!config.wideModeDisabled) {
				if (config.toolbars && (!config.toolbars.rail || config.toolbars.rail.length == 0) ) {
					this.editor.log('choosing wide mode plugin: mainpage');
					this.editor.initPlugin('mainpagewidemode').activate();
				} else {
					if (!config.wideInSourceDisabled) {
						this.editor.log('choosing wide mode plugin: source');
						this.editor.initPlugin('sourcewidemode').activate();
					}
				}
			}
		}

	});

})(this,jQuery);
