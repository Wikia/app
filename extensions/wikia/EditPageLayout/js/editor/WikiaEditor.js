(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable);

	// fallback - begin
	//window.EditPageToolkit = window.WikiaEditor;
	// fallback - end

	// config defaults
	WE.config = {

	};

	// define subnamespaces
	WE.plugins = {};
	WE.modules = {};

	WE.create = function( plugins, config ) {
		var instance = new WE.Editor(plugins,config);
		instance.show();
		return instance;
	};

	// functions
	WE.functions = [];
	WE.addFunction = function( callback, scope ) {
		var id = WE.functions.length;
		WE.functions.push({
			fn: callback,
			scope: scope || window
		});
		return id;
	};

	WE.callFunction = function( id ) {
		var args = Array.prototype.slice.call(arguments,1);
		var conf = WE.functions[id];
		return conf.fn.apply(conf.scope,args);
	};

	WE.initAddons = (function(){
		var done = false;
		return function() {
			if (!done)
				window.GlobalTriggers.fire('wikiaeditoraddons',WE);
			done = true;
		};
	})();

	// reload the editor (used by AjaxLogin) - BugId:5307
	WE.reloadEditor = function() {
		// clear the edit token - preview will be forced
		$('input[name=wpEditToken]').val('');

		// save the page
		$('#wpSave').click();
	};

	WE.Editor = $.createClass(Observable,{

		states: {
			IDLE: 1,
			INITIALIZING: 2,
			SAVING: 3,
			LOADING_SOURCE: 4,
			LOADING_VISUAL: 5
		},

		editorElement: false,

		constructor: function( plugins, config ) {
			WE.initAddons();
			WE.Editor.superclass.constructor.call(this);
			WE.fire('newInstance',plugins,config);
			this.pluginConfigs = plugins;
			this.config = $.extend(WE.config,config);
			this.initialized = false;
			this.state = false;
			this.mode = false;
			//this.debugEvents(['fire']);
		},

		initPlugins: function() {
			// Get the loading order
			var order = [];
			var loaded = {};
			function queuePlugin(name){
				if (loaded[name]) return;
				var plugin = WE.plugins[name];
				loaded[name] = true; // avoid recursion
				if (!plugin) {
					this.warn('Plugin not found: ' + name);
					return;
				}
				var requires = plugin.requires || plugin.prototype.requires;
				if ($.isArray(requires)) {
					for (var i=0;i<requires.length;i++) {
						queuePlugin.call(this,requires[i]);
					}
				}
				order.push(name);
			}
			for (var i=0;i<this.pluginConfigs.length;i++) {
				queuePlugin.call(this,this.pluginConfigs[i]);
			}

			// Create plugin instances
			this.plugins = {};
			for (var i=0;i<order.length;i++) {
				var cls = WE.plugins[order[i]];
				if (typeof cls == 'function') {
					this.plugins[order[i]] = new cls(this);
				}
			}
		},

		initPlugin: function( name ) {
			if (!this.plugins[name]) {
				var cls = WE.plugins[name];
				if (typeof cls == 'function') {
					this.plugins[name] = new cls(this);
				}
			}
			return this.plugins[name];
		},

		setState: function( state ) {
			if (this.state == state) return;
			this.state = state;
			this.fire('state',this,this.state);
		},

		setMode: function( mode, forceEvents ) {
			if (this.mode == mode && !forceEvents) return;
			this.element.removeClass('mode-'+this.mode);
			this.mode = mode;
			this.element.addClass('mode-'+this.mode);
			this.fire('mode',this,this.mode);
		},

		show: function() {
			if (!this.initialized) {
				this.initPlugins();
				this.mode = this.config.mode = this.config.mode || 'source';
				this.setState(this.states.INITIALIZING);
				this.element = this.config.element;
				this.fire('initConfig',this);
				this.fire('beforeInit',this);
				this.fire('init',this);
				this.fire('initEditor',this,this.editorElement);
				this.fire('initDom',this);
				this.initialized = true;
				this.fire('afterShow',this, this.editorElement);
			}
		},

		_log: function( type, args ) {
			if (window.console) {
				if (typeof window.console[type] == 'function' && typeof window.console[type].apply == 'function') {
					window.console[type].apply(window.console,args);
				} else if (typeof window.console[type] == 'object') { // IE
					var x = [];
					for (var i=0;i<args.length;i++) x.push("args["+i+"]");
					eval("window.console."+type+"("+x.join(',')+");");
				}
			} else if (window.opera) {
				window.opera.postError.apply(window.opera,args);
			}
		},

		log: function() {
			this._log('log',Array.prototype.slice.call(arguments,0));
		},

		warn: function() {
			this._log('warn',Array.prototype.slice.call(arguments,0));
		},

		error: function() {
			this._log('error',Array.prototype.slice.call(arguments,0));
			throw arguments[0];
		}

	});

	/**
	 * Base plugin class
	 */
	WE.plugin = $.createClass(Observable,{

		constructor: function( editor ) {
			WE.plugin.superclass.constructor.call(this);
			this.editor = editor;
			var autobind = {'initConfig':1,'beforeInit':1,'init':1,'initEditor':1,'initDom':1, 'afterShow' : 1};
			for (var fn in autobind) {
				if (typeof this[fn] == 'function') {
					this.editor.on(fn,this[fn],this);
				}
			}
		},

		proxy: function( fn ) {
			return $.proxy(fn,this);
		}

	});

	/**
	 * Internalization plugin for Wikia Editor
	 */
	WE.plugins.messages = $.createClass(WE.plugin,{

		MESSAGE_NAMESPACE: 'wikia-editor-',

		beforeInit: function() {
			this.editor.msg = this.proxy(this.msg);
		},

		msg: function( msg ) {
			var args = Array.prototype.slice.call(arguments,0);
			args[0] = this.MESSAGE_NAMESPACE + args[0];
			return $.msg.apply($,args);
		}

	});

	/**
	 * UI management for Wikia Editor
	 */
	WE.plugins.ui = $.createClass(WE.plugin,{

		priority: 0,
		ready: true,

		initDomCalled: false,
		uiReadyFired: false,

		initConfig: function() {
			this.items = {};
			this.handlers = {};
			this.providers = [this];
		},

		beforeInit: function() {
			this.editor.ui = this;
			var self = this;
			$('body').click(function(ev){
				self.fire('bodyClick',ev,this);
			});
		},

		init: function() {
			var chk = function() {
				if (!this.initDomCalled) return;
				if (this.uiReadyFired) return;
				for (var i=0;i<this.providers.length;i++)
					if (!this.providers[i].ready) return;
				this.uiReadyFired = true;
				this.addDefaults();
				this.editor.fire('uiReady',this);
			}
			var chkInitDom = function() {
				this.initDomCalled = true;
				chk.apply(this);
			}
			this.editor.on({
				uiExternalProviderReady: chk,
				initDom: chkInitDom,
				scope: this
			});
		},

		buildClickHandler: function( config ) {
			if (!config.click) {
				var editor = this.editor;
				config.click = function() {
					var mode = editor.mode;
					if (typeof config['click'+mode] == 'function')
						return config['click'+mode].apply(this,arguments);
					else
						editor.warn('Mode "'+mode+'" not supported for button: '+config.name);
				};
				this.editor.fire('uiBuildClickHandler',this.editor,config);
			}
		},

		addDefaults: function() {
			var elements = {}, config = this.editor.config;
			if (config.uiElements) {
				$.extend(elements,config.uiElements);
			}
			this.editor.fire('uiFetchDefaults',this.editor,elements);
			for (var name in elements) {
				if (typeof elements[name].precondition != 'function' || elements[name].precondition() ) {
					this.addElement(name,elements[name]);
				}
			}
		},

		addExternalProvider: function( externalProvider ) {
			this.providers = this.providers || [];
			for (var i=0;i<this.providers.length;i++) {
				if (this.providers[i].priority >= externalProvider.priority) {
					this.providers.splice(i,0,externalProvider);
					return;
				}
			}
			if (i >= this.providers.length) {
				this.providers.push(externalProvider)
			}
			this.editor.fire('uiAddExternalProvider',this.editor,externalProvider);
		},

		addHandler: function( type, handler ) {
			this.handlers[type] = handler;
			this.editor.fire('uiAddHandler',this.editor,type,handler);
		},

		getHandler: function( type ) {
			return this.handlers[type];
		},

		addElement: function( name, def ) {
			def.name = name;
			this.buildClickHandler(def);
			this.items[name] = def;
			this.editor.fire('uiAddElement',this.editor,name,def);
		},

		getElement: function( name ) {
			return this.items[name];
		},

		createElement: function( name ) {
			var element = this.getElement(name);
			if (!element) return false;
			var handler = this.getHandler(element.type);
			if (!handler) return false;
			var data = {};
			var html = handler.render(element,data);
			this.editor.fire('uiStandardElementCreated',this.editor,element,data);
			return html;
		},

		create: function( name ) {
			for (var i=0;i<this.providers.length;i++) {
				var html = this.providers[i].createElement(name);
				if (html) {
					return html;
				}
			}
			this.editor.warn('UI Element not found: ' + name);
			return '';
		}

	});

	/**
	 * Automatically register UI element types defined in namespaces WikiaEditor.ui
	 */
	WE.plugins.uiautoregister = $.createClass(WE.plugin,{

		requires: ['ui', 'functions'],

		init: function() {
			if (WE.ui) {
				for (var i in WE.ui) {
					if (i != 'base') {
						this.editor.ui.addHandler(i,this);
					}
				}
			}
		},

		render: function( config, data ) {
			var type = config.type;
			if (!WE.ui[type]) return '';

			var e = new WE.ui[type](this.editor,config,data);
			return e.render();
		}

	});


	/**
	 * Space manager plugin for Wikia Editor
	 */
	WE.plugins.spaces = $.createClass(WE.plugin,{

		SPACE_TYPE_ATTRIBUTE: 'data-space-type',
		EDITOR_SPACE: 'editor',

		element: false,
		spaces: false,

		beforeInit: function() {
			this.element = this.editor.config.element;
			this.editor.getSpace = this.proxy(this.getSpace);
			this.editor.getEditorSpace = this.proxy(this.getEditorSpace);
			this.editor.getSpaces = this.proxy(this.getSpaces);

			// Find all spaces
			this.spaces = {};
			var spaces = this.element.find('['+this.SPACE_TYPE_ATTRIBUTE+']');
			for (var i=0;i<spaces.length;i++) {
				var space = $(spaces.get(i));
				this.spaces[space.attr(this.SPACE_TYPE_ATTRIBUTE)] = space;
			}
			// Override with config
			if (this.editor.config.spaces)
				this.spaces = $.extend(this.spaces,this.editor.config.spaces);
		},

		init: function() {
			this.editorElement = this.getEditorSpace();
		},

		getSpace: function( name ) {
			return this.spaces[name] || false;
		},

		getSpaces: function() {
			return this.spaces;
		},

		getEditorSpace: function() {
			return this.getSpace(this.EDITOR_SPACE);
		}

	});

	/**
	 * Modules factory
	 */
	WE.plugins.modules = $.createClass(WE.plugin,{

		locals: false,
		globals: false,

		beforeInit: function() {
			this.locals = {};
			this.globals = WE.modules;
			this.editor.modules = this;
		},

		add: function( name, module ) {
			this.local[name] = module;
		},

		get: function( name ) {
			// Search in local modules
			if (this.locals[name])
				return this.locals[name];
			// Search in global modules
			if (this.globals[name])
				return this.globals[name];
			return false;
		},

		create: function( config /* or name */ ) {
			if (typeof config == 'string') {
				config = { type: config };
			}
			var module = this.get(config.type);
			if (module)
				module = new module(this.editor,config);
			if (!module) {
				this.editor.warn('Module not found: ' + config.type);
			}
			return module;
		}

	});

	/**
	 * Toolbars manager - automatically fills in appropriate spaces
	 * with configured modules during editor initialization.
	 */
	WE.plugins.toolbarspaces = $.createClass(WE.plugin,{

		requires: ['ui','spaces','modules'],

		AUTO_SHOW_ATTRIBUTE: 'data-space-autoshow',

		beforeInit: function() {
			this.editor.on('uiReady',this.proxy(this.renderToolbars));
			this.toolbars = {};
		},

		renderToolbars: function() {
			// Find all toolbars
			var spaces = this.editor.getSpaces();
			var toolbars = this.toolbars = {};
			for (var spaceName in spaces) {
				if (typeof this.editor.config.toolbars[spaceName] != 'undefined') {
					toolbars[spaceName] = {
						name: spaceName,
						el: spaces[spaceName],
						config: this.editor.config.toolbars[spaceName]
					};
				}
			}
			// Create modules for each toolbar
			var types = this.editor.config.toolbarTypes || {};
			for (var name in toolbars) {
				var config = toolbars[name].config;
				if ($.isArray(config)) config = { items:config };
				config.type = config.type || types[name] || 'container';
				config.element = toolbars[name].el;
				toolbars[name].module = this.editor.modules.create(config);
			}
			// Render each toolbar
			for (var name in toolbars) {
				if (toolbars[name].module) {
					toolbars[name].dom = toolbars[name].module.render();
					toolbars[name].module.afterAttach();
				}
			}
			// Show all non-empty toolbars with auto-show property
			for (var name in toolbars) {
				if (toolbars[name].dom && toolbars[name].el.attr(this.AUTO_SHOW_ATTRIBUTE) == 'true') {
					toolbars[name].el.show();
				}
			}
			this.editor.fire('toolbarsRendered',this.editor);
			this.editor.fire('toolbarsResized',this.editor);
		}

	});

	/**
	 * Functions plugin for Wikia Editor
	 */
	WE.plugins.functions = $.createClass(WE.plugin,{

		ids: false,

		beforeInit: function() {
			this.ids = {};
			this.editor.addFunction = this.proxy(this.add);
			this.editor.callFunction = this.proxy(this.call);
			this.editor.on('destroy',this.proxy(this.clear));
		},

		add: function( callback, scope ) {
			var id = WE.addFunction(callback,scope);
			this.ids[id] = true;
			return id;
		},

		call: function( id ) {
			return WE.callFunction.apply(WE,arguments);
		},

		clear: function() {
			for (var id in this.ids) {
				WE.functions[id] = false;
			}
		}

	});

	/**
	 * Core plugins suite
	 */
	WE.plugins.core = $.createClass(WE.plugin,{

		requires: ['functions','messages',
		    'ui','uiautoregister',
		    'spaces','toolbarspaces','collapsiblemodules']

	});

	/**
	 * Mediawiki editor provider
	 */
	WE.plugins.mweditor = $.createClass(WE.plugin,{

		requires: ['ui'],

		initConfig: function() {
			this.editor.config.mode = 'source';
		},

		initEditor: function() {
			this.editor.getEditorElement = this.proxy(this.getEditorElement);
			this.editor.getContent = this.proxy(this.getContent);
			this.editor.setContent = this.proxy(this.setContent);

			var self = this,
				cnt = this.editor.getEditorSpace() || this.editor.element;
			this.textarea = cnt.find('#wpTextbox1');
			if (!this.textarea.exists()) {
				this.textarea = cnt.find('textarea').eq(0); // get the first textarea in the editor
			}
			this.textarea
				.focus(this.proxy(this.editorFocused))
				.blur(this.proxy(this.editorBlurred))
				.click(this.proxy(this.editorClicked));

			//this.editor.fire('editboxReady',this.editor,this.getEditbox());

			this.editor.fire('editorReady',this.editor);
			this.editor.setMode(this.editor.mode,true /* forceEvents */);
			this.editor.setState(this.editor.states.IDLE);
		},

		initDom: function() {
			this.editor.fire('editboxReady',this.editor,this.getEditbox());
		},

		getEditbox: function() {
			return this.textarea;
		},

		getEditorElement: function() {
			return this.textarea;
		},

		getContent: function() {
			return this.getEditorElement().val();
		},

		setContent: function(val, datamode) {
			if(datamode == 'wysiwyg'){
				RTE.ajax('html2wiki', {html: val, title: window.wgPageName}, function(data) {
					this.getEditorElement().val(data.wikitext);
				});
			} else {
				this.getEditorElement().val(val);
			}
		},

		editorFocused: function() {
			this.editor.fire('editorFocus',this.editor);
		},

		editorBlurred: function() {
			this.editor.fire('editorBlur',this.editor);
		},

		editorClicked: function() {
			this.editor.fire('editorClick',this.editor);
		}

	});


	/**
	 * CKEditor provider
	 */
	WE.plugins.ckeditor = $.createClass(WE.plugin,{

		requires: ['ui'],

		loading: true,

		proxyEvents: [ 'mode', 'modeSwitch', 'modeSwitchCancelled', 'themeLoaded' ],

		initEditor: function() {
			var mode = this.editor.config.mode;
			RTE.init(mode);
			this.instance = RTE.instance;
			this.editor.ck = this.instance;
			this.editor.getEditorElement = this.proxy(this.getEditorElement);
			this.editor.getContent = this.proxy(this.getContent);
			this.editor.setContent = this.proxy(this.setContent);

			for (var i=0;i<this.proxyEvents.length;i++) {
				(function(eventName){
					this.instance.on(eventName,function(){
						var args = ['ck-'+eventName,this.editor].concat(arguments);
						this.editor.fire.apply(this.editor,args);
					},this);
				}).call(this,this.proxyEvents[i]);
			}
			this.instance.on('mode',this.proxy(this.modeChanged));
			this.instance.on('modeSwitch',this.proxy(this.beforeModeChange));
			this.instance.on('modeSwitchCancelled',this.proxy(this.modeChangeCancelled));
			this.instance.on('themeLoaded',this.proxy(this.themeLoaded));
			this.instance.on('focus',this.proxy(this.editorFocused));
			this.instance.on('blur',this.proxy(this.editorBlurred));
		},

		modeChanged: function() {
			var mode = this.instance.mode;
			if (this.loading) {
				this.editor.fire('editorReady',this.editor);
			}
			this.editor.setMode(mode,this.loading);
			this.editor.setState(this.editor.states.IDLE);

			this.getEditbox().click(this.proxy(this.editorClicked));

			this.loading = false;
		},

		beforeModeChange: function() {
			if (this.instance.mode == 'source')
				this.editor.setState(this.editor.states.LOADING_VISUAL);
			else
				this.editor.setState(this.editor.states.LOADING_SOURCE);
		},

		modeChangeCancelled: function() {
			this.editor.setState(this.editor.states.IDLE);
		},

		themeLoaded: function() {
			this.editor.fire('editboxReady',this.editor,$(this.instance.getThemeSpace('contents').$));
		},

		getEditbox: function() {
			var editbox;

			// TODO: move it to RTE?
			switch (this.instance.mode) {
				case 'wysiwyg':
					editbox = $(this.instance.document.getBody().$);
					break;

				case 'source':
					editbox = $(this.instance.textarea.$);
					break;
			}

			return editbox;
		},

		getEditorElement: function() {
			switch (this.instance.mode) {
			case 'wysiwyg':
				return $(this.instance.getThemeSpace('contents').$);
				break;
			case 'source':
				return $(this.instance.textarea.$);
			}
			return false;
		},

		getContent: function() {
			return this.instance.getData();
		},

		setContent: function(content, datamode) {
			switch (this.instance.mode) {
				//TODO: in same case this swith is imposible
				case 'wysiwyg':
					if(datamode != 'wysiwyg'){
						RTE.ajax('wiki2html', {wikitext: content, title: window.wgPageName}, $.proxy(function(data) {
							this.instance.setData(data.html);
						}, this));
						return true;
					}
				break;
				case 'source':
					if(datamode == 'wysiwyg') {
						RTE.ajax('html2wiki', {html: content, title: window.wgPageName}, $.proxy(function(data) {
							this.instance.setData(data.wikitext);
						}, this));
						return true;
					}
				break;
			}
			this.instance.setData(content);
		},

		editorFocused: function() {
			this.editor.fire('editorFocus',this.editor);
		},

		editorBlurred: function() {
			this.editor.fire('editorBlur',this.editor);
		},

		editorClicked: function() {
			this.editor.fire('editorClick',this.editor);
		}

	});

	/**
	 * CKEditor UI elements provider
	 */
	WE.plugins['ui-ckeditor'] = $.createClass(WE.plugin,{

		requires: ['ui','ckeditor'],

		priority: -1,
		ready: false,

		modeAwareCommands: {},
		stateProxiedCommands: {},

		beforeInit: function() {
			this.editor.ui.addExternalProvider(this);
			this.editor.on('ck-themeLoaded',this.ckReady,this);

			this.editor.on('uiBuildClickHandler',this.buildWysiwygClickHandler,this);

			this.editor.on('uiStandardElementCreated',this.elementCreated,this);
			this.editor.on('mode',this.modeChanged,this);
		},

		modeChanged: function( editor, mode ) {
			// show/hide appropriate buttons
			for (var name in this.modeAwareCommands) {
				var command = this.editor.ck.getCommand(name);
				if (command && command.modes) {
					for (var i=0;i<command.uiItems.length;i++) {
						var button = command.uiItems[i];
						if (button._.id) {
							$('#'+button._.id)
								.parent()[command.modes[mode]?'removeClass':'addClass']('cke_hidden');
						}
					}
				}
			}
			this.proxyAllCommandsState();
		},

		proxyAllCommandsState: function() {
			for (var commandName in this.stateProxiedCommands)
				this.proxyCommandState( commandName );
		},

		proxyCommandState: function( commandName ) {
			var command = this.editor.ck.getCommand(commandName),
				state = command && command.state,
				elements = this.stateProxiedCommands[commandName];
			if (!command) return;

			for (var i=0;i<elements.length;i++) {
				var id = elements[i],
					el = $('#'+id);
				if (el) {
					el = el.parent(); // workaround stupid HTML markup
					el.removeClass('cke_on cke_off cke_disabled');
					if (this.editor.ck.mode == 'wysiwyg') {
						el.addClass('cke_' + (
							state == CKEDITOR.TRISTATE_ON ? 'on' :
							state == CKEDITOR.TRISTATE_DISABLED ? 'disabled' :
							'off')
						);
					} else {
						el.addClass('cke_off');
					}
				}
			}
		},

		elementCreated: function( editor, element, data ) {
			//this.editor.log('elementCreated: ',element,data);
			if (element.ckcommand) {
				var commandName = element.ckcommand;
				// auto state by ck command
				if (!this.stateProxiedCommands[commandName]) {
					var command = this.editor.ck.getCommand(commandName);

					if (command) {
						command.on('state', $.proxy(function() {
							this.proxyCommandState(commandName);
						}, this));
					}
					this.stateProxiedCommands[commandName] = [];
				}
				this.stateProxiedCommands[commandName].push(data.id);
			}
		},

		ckReady: function() {
			this.ready = true;
			this.editor.fire('uiExternalProviderReady',this.editor);
		},

		buildWysiwygClickHandler: function( editor, button ) {
			//this.editor.log('buildWysiwygClickHandler',button.name,button);
			if (!button.clickwysiwyg && button.ckcommand) {
				button.clickwysiwyg = function() {
					editor.ck.execCommand(button.ckcommand,button.clickdatawysiwyg);
				};
			}
		},

		createElement: function( name ) {
			var ck = this.editor.ck, ui = this.editor.ck.ui, item;
			if (ui._.items[name] && (item = ui.create(name)) ) {
				var output = [];
				item.render(ck, output);
				if (item.command) {
					// auto show/hide buttons
					this.modeAwareCommands[item.command] = true;
				}
				//this.editor.log('ui item: ',item);
				return output.join( '' );
			}
			return false;
		}

	});

	/**
	 * Mediawiki editor plugins list
	 */
	WE.plugins.mweditorsuite = $.createClass(WE.plugin,{

		requires: ['core','mweditor']

	});

	/**
	 * CKEditor plugins list
	 */
	WE.plugins.ckeditorsuite = $.createClass(WE.plugin,{

		requires: ['core','ckeditor','ui-ckeditor']

	});

	GlobalTriggers.fire('wikiaeditor',WE);

})(this,jQuery);
