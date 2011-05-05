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
		}
	})();

	WE.Editor = $.createClass(Observable,{
		
		states: {
			IDLE: 1,
			INITIALIZING: 2,
			SAVING: 3,
			LOADING_SOURCE: 4,
			LOADING_VISUAL: 5
		},

		constructor: function( plugins, config ) {
			$().log(plugins);
			WE.initAddons();
			WE.Editor.superclass.constructor.call(this);
			WE.fire('newInstance',plugins,config);
			this.pluginConfigs = plugins;
			this.config = $.extend(WE.config,config)
			this.initialized = false;
			this.state = false;
			this.mode = false;
			this.debugEvents(['fire']);
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
			}
		},

		_log: function( type, args ) {
			if (window.console) {
				if (typeof window.console[type] == 'function') {
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
			var autobind = {'initConfig':1,'beforeInit':1,'init':1,'initEditor':1,'initDom':1};
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
	 * UI buttons renderer plugin for Wikia Editor
	 */
	WE.plugins.uibuttons = $.createClass(WE.plugin,{

		requires: ['ui','functions'],

		nextId: 1,

		init: function() {
			this.editor.ui.addHandler('button',this);
			this.editor.ui.buildClickHandler = this.proxy(this.buildClickHandler);
		},

		buildClickHandler: function( config ) {
			var editor = this.editor;
			config.click = function() {
				var mode = editor.mode;
				if (typeof config['click'+mode] == 'function')
					return config['click'+mode].apply(this,arguments);
				else
					editor.warn('Mode "'+mode+'" not supported for button: '+config.name);
			};
			this.editor.fire('uiBuildClickHandler',this.editor,config);
		},

		render: function( config, data ) {
			if (!config)
				return '';

			config.title || (config.title = config.label);
			var id = 'uielem_' + this.nextId++;
			var buttonClass = 'cke_' + config.type;
			var classes = (config.className || '');
			var title = config.title || '';
			var label = config.label || '';

			if (typeof config.click != 'function') {
				this.buildClickHandler(config);
			}
			var clickFn = config.clickFn = config.clickFn || this.editor.addFunction(config.click);

			var html = '';

			html += '<span class="' + buttonClass + ' ' + classes + '">';
			html += '<a id="' + id + '" class="cke_off ' + classes + '"'
				+ ' title="' + title + '"'
				+ ' tabindex="-1"'
				+ ' hidefocus="true"'
			    + ' role="button"'
				+ ' aria-labelledby="' + id + '_label"';

			// Some browsers don't cancel key events in the keydown but in the
			// keypress.
			// TODO: Check if really needed for Gecko+Mac.
			/*
			if ( env.opera || ( env.gecko && env.mac ) )
			{
				html += ' onkeypress="return false;"';
			}
			*/

			// With Firefox, we need to force the button to redraw, otherwise it
			// will remain in the focus state.
			/*
			if ( env.gecko )
			{
				html += ' onblur="this.style.cssText = this.style.cssText;"';
			}
			*/

			html +=	' onclick="WikiaEditor.callFunction(' + clickFn + ', this); return false;">';
			//html += ' onclick="return false;"';
			//html += ' onmousedown="WikiaEditor.callFunction(' + clickFn + ', this); return false;">';

			if ( config.hasIcon !== false ) {
				html += '<span class="cke_icon">&nbsp;</span>';
			}
			if ( config.hasLabel !== false ) {
				var labelClass = config.labelClass || 'cke_label';
				html += '<span id="' + id + '_label" class="' + labelClass + '">' + label + '</span>';
			}

			if ( config.hasArrow ) {
				var arrowClass = config.arrowClass || 'cke_openbutton';
				html += '<span class="' + arrowClass + '">&nbsp;</span>';
			}

			html += '</a>' + '</span>';

			if (typeof data == 'object') {
				data.id = id;
			}

			return html;
		}

	});

	WE.plugins.uipanelbuttons = $.createClass(WE.plugin,{

		requires: ['ui','uibuttons'],

		autoRenderList: false,

		beforeInit: function() {
			this.autoRenderList = [];
			this.editor.on('toolbarsRendered',this.autoRenderPanels,this);
		},

		init: function() {
			this.editor.ui.addHandler('panelbutton',this);
		},

		autoRenderPanels: function() {
			for (var i=0;i<this.autoRenderList.length;i++) {
				this.autoRenderList[i]();
			}
			this.autoRenderList = [];
		},

		render: function( config, data ) {
			data = data || {};
			data.opened = false;
			config = $.extend({},config);
			config.mouseenter = function() {
				data.inside++;
			};
			config.mouseleave = function() {
				data.inside--;
			}
			config.renderpanel = function() {
				var button = $('#'+data.id),
					el = button.exists() &&  button.closest('.cke_'+config.type);
				if (button && el && !data.panel) {
					var pos = el.position();
					var panel = data.panel = $('<div>');
					panel.addClass('cke_panel_dropdown').addClass(config.panelClass || '').appendTo(el.offsetParent());
					config.positionpanel();
					config.panelOnInit && config.panelOnInit(data.panel,config,panel);
					panel.hide();

					button.add(panel)
						.mouseenter(config.mouseenter)
						.mouseleave(config.mouseleave);
					panel
						.delegate('.cke_button, .text-links a','mouseenter',config.mouseleave)
						.delegate('.cke_button, .text-links a','mouseleave',config.mouseenter)
				}
			};
			config.positionpanel = function() {
				var button = $('#'+data.id),
					el = button.exists() &&  button.closest('.cke_'+config.type);
				var pos = el.position();
				var mod = { left: 5, top: -20 };
				data.panel.css({
					position: 'absolute',
					left: pos.left + mod.left,
					top: pos.top + mod.top + el.outerHeight(),
					'padding-top': -mod.top
				});
			};
			config.click = function() {
				var button = $('#'+data.id),
					el = button.closest('.cke_'+config.type);
				if (!data.panel)
					config.renderpanel();
				if (!data.opened) {
					el.addClass('cke_opened');
					config.panelOnShow && config.panelOnShow(data.panel,config,panel);
					config.positionpanel();
					data.panel.show();
					data.opened = true;
					data.inside = 1;
				} else {
					el.removeClass('cke_opened');
					config.panelOnHide && config.panelOnHide(data.panel,config,panel);
					data.panel.hide();
					data.opened = false;
					data.inside = 0;
				}
			};
			this.editor.ui.on('bodyClick',function() {
				if (data.opened && data.inside == 0) {
					config.click();
				}
			});
			this.editor.on('editorFocus',function() {
				if (data.opened) {
					config.click();
				}
			});
			config.hasArrow = true;
			config.labelClass = 'cke_text';
			if (config.autorenderpanel) {
				this.autoRenderList.push(config.renderpanel);
			};
			return this.editor.plugins.uibuttons.render(config,data);
		}

	});

	WE.plugins.uimodulebuttons = $.createClass(WE.plugin,{

		requires: ['ui','uibuttons','uipanelbuttons'],

		init: function() {
			this.editor.ui.addHandler('modulebutton',this);
		},

		render: function( config, data ) {
			config = $.extend({},config);
			data = data || {};

			var editor = this.editor;
			config.panelOnInit = function( panel, config, data ) {
				var module = editor.modules.create(config.module);
				var el = module.render();

				// immitate that module sits in rail
				var headerClass = module.getHeaderClass();
				var elcontent = $('<div>')
					.addClass('module_content')
					.append(el)
				var elmodule = $('<div>')
					.addClass('module module_' + headerClass)
					.attr('data-id',headerClass)
					.append(elcontent);

				panel.append(elmodule);
				module.afterAttach();
			}
			config.panelClass = config.panelClass ? config.panelClass + ' ' : '';

			return this.editor.plugins.uipanelbuttons.render(config,data);
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
			var spaces = this.element.find('[data-space-type]');
			for (var i=0;i<spaces.length;i++) {
				var space = $(spaces.get(i));
				this.spaces[space.attr('data-space-type')] = space;
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
	 * Modules provider plugin for WikiaEditor
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
	 * Toolbar spaces manager
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
		    'ui','uibuttons','uipanelbuttons','uimodulebuttons',
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
			this.editor.fire('editorReady',this.editor);
			this.editor.setMode(this.editor.mode,true);
			this.editor.setState(this.editor.states.IDLE);
			
			var self = this,
				cnt = this.editor.getEditorSpace() || this.editor.element;
			this.textarea = cnt.find('textarea');
			this.textarea
				.focus(this.proxy(this.editorFocused))
				.blur(this.proxy(this.editorBlurred));
			this.editor.fire('editboxReady',this.editor,this.textarea);
		},

		initDom: function() {
			this.editor.fire('editboxReady',this.editor,this.textarea);
		},

		editorFocused: function() {
			this.editor.fire('editorFocus',this.editor);
		},

		editorBlurred: function() {
			this.editor.fire('editorBlur',this.editor);
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
			var editbox = $(this.instance.getThemeSpace('contents').$);
			this.editor.fire('editboxReady',this.editor,editbox);
		},

		editorFocused: function() {
			this.editor.fire('editorFocus',this.editor);
		},

		editorBlurred: function() {
			this.editor.fire('editorBlur',this.editor);
		}

	});

	/**
	 * CKEditor UI elements provider
	 */
	WE.plugins['ui-ckeditor'] = $.createClass(WE.plugin,{

		requires: ['ui','ckeditor'],

		priority: -1,
		ready: false,
		queuedButtons: false,

		mapping: false,

		modeAwareCommands: {},
		stateProxiedCommands: {},

		beforeInit: function() {
			this.queuedButtons = [];
			this.mapping = {
				'button': CKEDITOR.UI_BUTTON
			};
			this.editor.ui.addExternalProvider(this);
			this.editor.on('uiAddElement',this.elementAdded,this);
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
						this.editor.log('command.state ' + commandName + ': ' + state);
						el.addClass('cke_' + (
							state == CKEDITOR.TRISTATE_ON ? 'on' :
							state == CKEDITOR.TRISTATE_DISABLED ? 'disabled' :
							'off')
						);
					} else {
						this.editor.log('command.state ' + commandName + ': off');
						el.addClass('cke_off');
					}
				}
			}
		},

		elementCreated: function( editor, element, data ) {
			this.editor.log('elementCreated: ',element,data);
			if (element.ckcommand) {
				var commandName = element.ckcommand;
				// auto state by ck command
				if (!this.stateProxiedCommands[commandName]) {
					var command = this.editor.ck.getCommand(commandName),
						self = this;
					command.on('state',function(){
						self.proxyCommandState(commandName);
					});
					this.stateProxiedCommands[commandName] = [];
				}
				this.stateProxiedCommands[commandName].push(data.id);
			}
		},

		ckReady: function() {
			this.addQueuedButtons();
			this.ready = true;
			this.editor.fire('uiExternalProviderReady',this.editor);
		},

		elementAdded: function( editor, name, def ) {
			var ck = this.editor.ck,
				ui = this.editor.ck.ui,
				element = $.extend({},def);
			if (!this.mapping[element.type]) {
				return;
			}

			element.type = this.mapping[element.type];
			this.editor.ui.buildClickHandler(element);
			this.addButton(element);
		},

		buildWysiwygClickHandler: function( editor, config ) {
			this.editor.log('buildWysiwygClickHandler',config.name,config);
			if (!config.clickwysiwyg && config.ckcommand) {
				config.clickwysiwyg = function() {
					editor.ck.execCommand(config.ckcommand,config.clickdatawysiwyg);
				};
			}
		},

		addButton: function( element ) {
			if (!this.ready)
				this.editor.ck.ui.add(element.name,element.type,element);
			else
				this.queuedButtons.push(element);
		},

		addQueuedButtons: function() {
			var queue = this.queuedButtons;
			this.queuedButtons = [];
			for (var i=0;i<this.queuedButtons.length;i++)
				this.addButton(this.queuedButtons[i]);
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
				this.editor.log('ui item: ',item);
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
