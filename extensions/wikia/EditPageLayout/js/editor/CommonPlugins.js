(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable);

	WE.plugins.noticearea = $.createClass(WE.plugin,{

		visible: false,

		beforeInit: function() {
			this.editor.on('notice',this.proxy(this.add));
		},

		initDom: function() {
			this.el = this.editor.getSpace('notices-short');
			this.ul = this.el.children('ul').first();
			this.htmlEl = this.editor.getSpace('notices-html');
			this.html = this.htmlEl.html();

			this.ul.click(this.proxy(this.areaClicked));
			this.el.find('.dismiss-icon').click(this.proxy(this.dismissClicked));

			this.update();
		},

		update: function() {
			this.visible = (this.ul.children().length > 0);
			this.el[ this.visible ? 'show' : 'hide' ]();
		},

		areaClicked: function( event ) {
			if (this.html) {
				var header = $.htmlentities(this.editor.msg('notices-dialog-title'));
				$.showModal(header,this.html,{
					width: 700
				});
			}
		},

		dismissClicked: function( event ) {
			var el = this.el, self = this;
			el.fadeOut('slow',function(){
				el.hide();
				self.ul.empty();
				self.html = '';
			});
		},

		add: function( message, type, html ) {
			var li = $('<li>').html(message);
			li.addClass('notice-'+(type||'warning'));
			this.ul.append(li);
			if (html)
				this.html += html;
			else
				this.html += '<div>' + message + '</div>';
			this.update();
			return li;
		}

	});


	WE.plugins.loadingstatus = $.createClass(WE.plugin,{

		requires: ['spaces'],

		MESSAGE_PREFIX: 'loadingStates-',

		init: function() {
			this.el = this.editor.getSpace('loading-status');

			this.editor.on('state',this.proxy(this.stateChanged));
			this.set('loading');
		},

		stateChanged: function( editor, state ) {
			var states = editor.states, value = false;
			if (state == states.INITIALIZING)
				value = 'loading';
			else if (state == states.LOADING_SOURCE)
				value = 'toSource';
			else if (state == states.LOADING_VISUAL)
				value = 'toVisual';
			else if (state == states.SAVING)
				value = 'saving';
			this.set(value);
		},

		set: function( state ) {
			this.state = state;

			this.editor.log('loading-status: ',state);

			if (this.state) {
				var text = this.editor.msg(this.MESSAGE_PREFIX + state);
				this.el.find('.loading-text').text(text);
				this.el.show();
			} else {
				this.el.hide();
			}
		}

	});

	/**
	 * Collapsible modules plugin for Wikia Editor
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
			if (!el.children('h3').exists()) // skip modules without header line
				return;

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
				module.content.slideUp();
			}
			else {
				module.content.hide();
			}

			module.chevron.removeClass('collapse').addClass('expand');
		},

		expand: function(id, animate) {
			var module = this.modules[id];

			if (animate) {
				module.content.slideDown();
			}
			else {
				module.content.show();
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
			var viewport = $.getViewportHeight();

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
		}
	});

	WE.plugins.fitscreen = $.createClass(WE.plugin,{

		editarea: false,
		editbox: false,
		mode: false,

		beforeInit: function() {
			this.mode = this.editor.config.autoResizeMode;
			if (this.mode !== false) {
				this.editor.on('editboxReady',this.proxy(this.editboxReady));
				this.editor.on('mode',this.proxy(this.delayedResize));
				this.editor.on('toolbarsRendered',this.proxy(this.delayedResize));
			}

			this.editarea = $('#EditPageEditor');
		},

		initDom: function() {
			if (this.enabled) {
				this.initResize();
			}
		},

		editboxReady: function( editor, editbox ) {
			this.editbox = editbox;
			this.initResize();
		},

		// init autoresizing feature of textarea / RTE
		initResize: function() {
			var self = this;

			this.resize();

			$(window).bind('resize', function() {
				self.resize();
			});

			// trigger this event to recalculate top offset
			this.editor.element.bind('resize', function() {
				self.resize();
			});

			// dirty trick to allow toolbar / right rail to be fully initialized
			this.delayedResize();
		},

		delayedResize: function() {
			setTimeout(this.proxy(this.resize),10);
		},

		// get height needed to fit given node into browser's viewport height
		getHeightToFit: function(node) {
			var topOffset = node.offset().top,
				viewportHeight = $.getViewportHeight();

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
		}
	});

	WE.plugins.wikiacore = $.createClass(WE.plugin,{

		requires: ['core','noticearea','loadingstatus','pagecontrols','fitscreen',
			'widemodemanager', 'tracker']

	});

	WE.plugins.wikiaui = $.createClass(WE.plugin,{

	});



})(this,jQuery);
