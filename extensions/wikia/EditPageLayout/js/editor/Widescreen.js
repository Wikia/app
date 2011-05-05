(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable);

	WE.plugins.sourcewidemode = $.createClass(WE.plugin,{

		requires: ['spaces'],

		className: 'editpage-sourcewidemode',
		wideClassName: 'editpage-sourcewidemode-on',
		storageEntry: 'wgSourceModeWidescreen',

		triggerClassName: 'editpage-widemode-trigger',

		enabled: false,
		trigger: false,
		wide: false,

		activate: function() {
			this.enabled = true;
			if (this.enabled) {
				this.active = this.editor.mode == 'source';
				// set up the trigger
				this.trigger = this.editor.element.find('.'+this.triggerClassName)
				this.trigger.click(this.proxy(this.toggle));
				this.trigger.css('display','');

				// set up the editor body
				this.editor.element.addClass(this.className);

				// load the saved state (if any)
				this.loadState();

				// adjust the height when changing modes
				this.editor.on('mode',this.modeChanged,this);
			}
		},
		
		init: function() {
			this.track(this.wide ? 'initOn' : 'initOff');
		},

		modeChanged: function() {
			var toolbar = this.editor.getSpace('toolbar');

			// adjust bar height and position
			var cssTop = toolbar.offset().top + toolbar.outerHeight(true) - this.trigger.offsetParent().offset().top;
			cssTop += 2; // go below toolbar border

			this.trigger.css('top', cssTop);
		},

		toggle: function() {
			this.setState(!this.getState());
			this.saveState();

			this.track(this.wide ? 'switchOn' : 'switchOff');
		},

		loadState: function() {
			var wide = $.storage.get(this.storageEntry) == true;
			this.setState(wide);
		},

		setState: function( wide ) {
			this.wide = wide;
			this.editor.element[wide ? 'addClass' : 'removeClass'](this.wideClassName);
		},

		saveState: function() {
			$.storage.set(this.storageEntry,this.wide);
		},

		getState: function() {
			return this.editor.element.hasClass(this.wideClassName);
		},

		track: function(ev) {
			this.editor.track('widescreenSource', ev);
		}
	});

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
