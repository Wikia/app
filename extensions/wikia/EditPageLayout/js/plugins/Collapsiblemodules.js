(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	/**
	 * Collapsible modules handling
	 */
	WE.plugins.collapsiblemodules = $.createClass(WE.plugin,{

		requires: ['modules'],

		MODULE_ID_ATTRIBUTE: 'data-id',
		storageEntry: 'wgRightRailModulesState',

		lastId: 0,
		modules: false,

		beforeInit: function() {
			this.modules = {};
			this.editor.collapsiblemodules = this;
		},

		add: function( moduleObj, el ) {
			if (!el.children('h3').exists()) { // skip modules without header line
				return;
			}

			this.lastId++;

			var id = el.attr(this.MODULE_ID_ATTRIBUTE);
			id = id ? id : this.lastId;
			var module = {
				id: id,
				module: moduleObj,
				el: el,
				header: el.children('h3'),
				chevron: false, // will be filled in a few lines below
				content: el.children('.module_content'),
				state: true
			};
			module.chevron = module.header.find('.chevron');
			this.modules[id] = module;

			var self = this;
			module.header.bind('click.collapse', function(ev) {
				self.toggle(id);
			});

			var defaultState = this.getDefaultState();

			module.state = this.readState(id, defaultState);
			this[ module.state ? 'expand' : 'collapse' ](id);
		},

		toggle: function( id ) {
			var module = this.modules[id],
				state = module.state;

			this[ state ? 'collapse' : 'expand' ](id,true);
			this.setState(id,!state);
		},

		collapse: function(id, animate) {
			var module = this.modules[id];

			if (animate) {
				module.content.slideUp(this.proxy(this.fireToolbarsResized));
			}
			else {
				module.content.hide();
				this.fireToolbarsResized();
			}

			module.chevron.removeClass('collapse').addClass('expand');
		},

		expand: function(id, animate) {
			var module = this.modules[id];

			if (animate) {
				module.content.slideDown(this.proxy(this.fireToolbarsResized));
			}
			else {
				module.content.show();
				this.fireToolbarsResized();
			}

			module.chevron.removeClass('expand').addClass('collapse');
		},

		readState: function( id, defaultState /* true = expanded */ ) {
			var stateSet = $.storage.get(this.storageEntry),
				retval;

			if (stateSet && (typeof stateSet[id] != 'undefined')) {
				// use state from local storage
				retval = !!stateSet[id];
			}
			else {
				// use default value
				retval = defaultState;

				this.saveState(id, defaultState);
			}
			return retval;
		},

		saveState: function( id, state ) {
			var stateSet = $.storage.get(this.storageEntry) || {};
			stateSet[id] = !!state;
			$.storage.set(this.storageEntry, stateSet);
		},

		setState: function( id, state ) {
			var module = this.modules[id];

			module.state = state;

			// save in local storage
			this.saveState(id,state);
		},

		// BugId:4335
		getDefaultState: function() {
			var viewport = $(window).height();

			if (viewport < 600) {
				// expand the first module only
				return (this.lastId < 2);
			}
			else if (viewport < 900) {
				// expand the first and the second module
				return (this.lastId < 3);
			}
			else {
				return true;
			}
		},

		fireToolbarsResized: function() {
			this.editor.fire('toolbarsResized',this.editor);
		}

	});

})(this,jQuery);
