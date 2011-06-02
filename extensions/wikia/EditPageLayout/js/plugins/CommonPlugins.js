(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable);

	/**
	 * Notice area handling
	 */
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

	/**
	 * Loading status indicator
	 */
	WE.plugins.loadingstatus = $.createClass(WE.plugin,{

		requires: ['spaces'],

		MESSAGE_PREFIX: 'loadingStates-',
		
		extraStates: false,
		extraStatesCount: 0,

		beforeInit: function() {
			this.extraStates = {};
			this.editor.on('state',this.proxy(this.stateChanged));
			this.editor.on('extraState',this.proxy(this.extraStateChanged));
		},
		
		init: function() {
			this.el = this.editor.getSpace('loading-status');
			this.set('loading');
		},
		
		extraStateChanged: function( editor, name, state ) {
			var states = editor.states;
			if (state == states.INITIALIZING) {
				if (!this.extraStates[name]) {
					this.extraStates[name] = 1;
					this.extraStatesCount++;
					this.stateChanged(editor,editor.state);
				}
			} else {
				if (this.extraStates[name]) {
					delete this.extraStates[name];
					this.extraStatesCount--;
					this.stateChanged(editor,editor.state);
				}
			}
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
		
			if (value == false && this.extraStatesCount > 0)
				return;
			
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
		},
		
		fireToolbarsResized: function() {
			this.editor.fire('toolbarsResized',this.editor);
		}
		
	});
	
	/**
	 * Adds a custom event "sizeChanged" 
	 * when editor area is resized
	 */
	WE.plugins.sizechangedevent = $.createClass(WE.plugin,{
		
		initDom: function() {
			var self = this, editor = this.editor;
			
			this.fireResizeEvent();
			
			$(window).bind('resize', function() {
				self.fireResizeEvent();
			});

			// trigger this event to recalculate top offset
			this.editor.element.bind('resize', function() {
				self.fireResizeEvent();
			});

			// dirty trick to allow toolbar / right rail to be fully initialized
			//setTimeout(this.proxy(this.fireResizeEvent),10);
		},
		
		fireResizeEvent: function() {
			this.editor.fire('sizeChanged',this.editor);
		}
		
	});

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
	
	/**
	 * Adds textual link "More shortcuts" into source mode toolbar
	 * which shows a modal popup with edit tools.
	 */
	WE.plugins.edittools = $.createClass(WE.plugin,{
		
		LINK_CAPTION_MESSAGE: 'edittools-caption',
		DIALOG_TITLE_MESSAGE: 'edittools-dialog-title',
		
		modal: false,
		html: false,
		
		beforeInit: function() {
			this.editor.on('mediawikiToolbarRendered',this.proxy(this.mediawikiToolbarRendered));
		},
		
		mediawikiToolbarRendered: function( editor, el ) {
			this.html = this.editor.element.find('.mw-editTools').html();
			if (this.html) {
				var link = $('<a class="edittools-button" href="#" />');
				link.text(this.editor.msg(this.LINK_CAPTION_MESSAGE))
				link.click(this.proxy(this.showEdittools));
				$(el).append(link);
			}
		},
		
		showEdittools: function( evt ) {
			evt && evt.preventDefault();
			var title = $.htmlentities(this.editor.msg(this.DIALOG_TITLE_MESSAGE));
			$.showModal(title,this.html,{
				callback: function() {
					$('#EditPageEditTools').delegate('a','click',function(){
						$('#EditPageEditTools').closeModal();
					});
				},
				id: 'EditPageEditTools',
				width: 680
			});
		}
	});
	
	/**
	 * Adds scroll bar to right rail if rail is shorter than the specified minimum
	 */
	WE.plugins.railminimumheight = $.createClass(WE.plugin,{
		
		requires: ['sizechangedevent'],
		
		MINIMUM_HEIGHT: 600,
		CONTAINER_SELECTOR: '> .rail-auto-height',
		
		beforeInit: function() {
			this.editor.on('sizeChanged',this.proxy(this.delayedResize));
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
			var viewportHeight = $.getViewportHeight();
			var el, rail = this.editor.getSpace('rail');
			
			if (rail.exists() && (el = rail.find(this.CONTAINER_SELECTOR)) && el.exists()) {
				if (viewportHeight > this.MINIMUM_HEIGHT) {
					el.css({
						'overflow-y': 'hidden',
						'height': 'auto'
					});
				} else {
					var h = viewportHeight - el.offset().top - (el.outerHeight(true) - el.height());
					el.css({
						'overflow-y': 'auto',
						'height' : h
					});
				}
			}
		}
		
		
	});
	
	
	WE.plugins.cssloadcheck = $.createClass(WE.plugin,{
		
		CSS_STATE_NAME: 'ck-stylesheets',
		
		pollStylesheetsTimer: false,
		pollStylesheetsTimerDelay: 100,
		
		currentDelay: 0,
		maxAllowedDelay: 10000,
		
		lastAnnounced: false,
		
		beforeInit: function() {
			this.pollStylesheetsTimer = new Timer(this.proxy(this.pollStylesheets),this.pollStylesheetsTimerDelay);
			this.editor.on('state',this.proxy(this.stateChanged));
			//this.editor.on('');
		},
		
		init: function() {
			this.stateChanged(this.editor,this.editor.state);
		},
		
		stateChanged: function( editor, state ) {
			var states = this.editor.states;
			
			this.pollStylesheetsTimer.stop();
			if ((state == states.INITIALIZING && this.editor.mode == 'wysiwyg') || state == states.LOADING_VISUAL) {
				// when wysiwyg mode is loading
				this.fireState(states.INITIALIZING);
			} else if (state == states.IDLE && this.lastAnnounced == states.INITIALIZING) {
				this.currentDelay = 0;
				this.pollStylesheets();
			} else {
				this.fireState(states.IDLE);
			}
		},
		
		pollStylesheets: function() {
			this.pollStylesheetsTimer.stop();
			
			var ed = this.editor.getEditorElement(),
				iframe = ed.find('iframe');
			if (iframe.exists()) {
				var doc = iframe.get(0).contentDocument,
					head = doc && $('head',$(doc)),
					headColor = head && head.css('color');
				if ( (typeof headColor == 'string') && $.inArray(headColor.toLowerCase(), ['transparent','rgb(0, 0, 0)','white','#ffffff','#fff']) == -1 ) {
					this.fireState(this.editor.states.IDLE);
					return;
				}
			}
			
			this.currentDelay += this.pollStylesheetsTimerDelay;
			if (this.currentDelay > this.maxAllowedDelay) {
				this.fireState(this.editor.states.IDLE);
				return;
			}
			
			this.pollStylesheetsTimer.start();
		},
		
		fireState: function( state ) {
			if (this.lastAnnounced !== state) {
				this.editor.fire('extraState',this.editor,this.CSS_STATE_NAME,state);
				this.lastAnnounced = state;
			}
		}
		
	});

	/**
	 * Shortcut to automatically add all Wikia specific plugins
	 */
	WE.plugins.wikiacore = $.createClass(WE.plugin,{

		requires: ['core','noticearea','loadingstatus','pagecontrols','autoresizer','edittools',
			'widemodemanager', 'railminimumheight', 'tracker', 'cssloadcheck', 'preloads']

	});

})(this,jQuery);
