(function(window,$){
	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable()),
		slice = [].slice;

	// config defaults
	WE.config = {};

	// define subnamespaces
	WE.plugins = {};
	WE.modules = {};
	WE.instances = {};

	// instance tracking
	WE.instanceId = '';
	WE.instanceCount = 0;

	WE.debounce = false;

	// Lazy loaded components manager
	// Would be nice to use resource loader for this, but we can't load Sass files there :(
	WE.load = (function() {
		var components = {
			VideoEmbedTool: {
				loaded: false,
				requires: [
					wgResourceBasePath + '/extensions/wikia/VideoEmbedTool/js/VET_WikiaEditor.js'
				]
			},
			WikiaMiniUpload: {
				loaded: false,
				requires: [
					$.loadYUI,
					$.loadJQueryAIM,
					$.getSassCommonURL( 'extensions/wikia/WikiaMiniUpload/css/WMU.scss' ),
					wgResourceBasePath + '/extensions/wikia/WikiaMiniUpload/js/WMU.js'
				]
			}
		};

		return function( name ) {
			var component = components[ name ],
				deferred = new $.Deferred();

			if ( component ) {
				if ( component.loaded ) {
					deferred.resolve();

				} else {

					component.loaded = true;
					deferred = $.when( $.getResources( component.requires ) );
				}

			} else {
				deferred.reject({
					error: 'WikiaEditor.load: invalid component name "' + name + '"'
				});
			}

			return deferred.promise();
		}
	})();

	// Update the current instance
	WE.setInstanceId = function(instanceId, event, forceEvents) {
		var editor;

		if (typeof event == 'boolean') {
			forceEvents = event;
			event = undefined;
		}

		if (instanceId == WE.instanceId) {
			if (!forceEvents) {
				$().log('instance "' + WE.instanceId + '" already active', 'WikiaEditor');
				return;
			}

		} else {
			if ((editor = WE.instances[WE.instanceId])) {
				editor.fire('editorDeactivated', event);
				$().log('instance "' + WE.instanceId + '" deactivated', 'WikiaEditor');
			}

			WE.instanceId = instanceId;
		}

		if ((editor = WE.instances[instanceId])) {
			editor.fire('editorActivated', event);
			$().log('instance "' + WE.instanceId + '" activated', 'WikiaEditor');
		}
	};

	// Returns the currently active instance
	WE.getInstance = function(instanceId) {
		return WE.instances[instanceId || WE.instanceId];
	};

	// Helper function for converting text format to mode
	WE.formatToMode = function(format) {
		return format == 'richtext' ? 'wysiwyg' : 'source';
	};

	// Helper function for converting mode to text format
	WE.modeToFormat = function(mode) {
		return mode == 'wysiwyg' ? 'richtext' : 'wikitext';
	};

	// Constructor
	WE.create = function(plugins, config, event) {
		var instance = new WE.Editor(plugins, config),
			instanceId = config.body.attr('id');

		if (!instanceId) {
			instanceId = 'WikiaEditor-' + WE.instanceCount;

			// Body must have an ID! This is a requirement of CKE
			config.body.attr('id', instanceId);
		}

		instance.event = event;
		instance.instanceId = instanceId;

		WE.instances[instanceId] = instance;
		WE.setInstanceId(instanceId, event);
		WE.instanceCount++;

		config.body.data('wikiaEditor', instance);
		instance.fire('instanceCreated', event);
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
		// Bugid 17716 - Don't fire twice if button is double-clicked
		if (WE.debounce) return;
		setTimeout(function() { WE.debounce = false; }, 500);
		WE.debounce = true;

		var args = Array.prototype.slice.call(arguments,1);
		var conf = WE.functions[id];
		return conf.fn.apply(conf.scope,args);
	};

	WE.initAddons = (function(){
		var done = false;
		return function() {
			if (!done){
				window.GlobalTriggers.fire('wikiaeditoraddons',WE);
			}
			done = true;
		};
	})();

	// reload the edit page (used by AjaxLogin / UserLogin) - BugId:5307
	WE.reloadEditor = function() {
		var editorInstance = WE.getInstance(),
			editorForm = editorInstance.ui.getForm();

		// clear the edit token - reload will be forced
		editorForm.find('input[name=wpEditToken]').val('');

		// set the state and submit the edit form
		editorInstance.setState(editorInstance.states.RELOADING);

		this.storeContent();

		window.location.reload(true);
	};

	WE.storeContent = function() {
		window.WikiaEditorStorage.store();
	}

	WE.Editor = $.createClass(Observable, {
		states: {
			IDLE: 1,
			INITIALIZING: 2,
			SAVING: 3,
			LOADING_SOURCE: 4,
			LOADING_VISUAL: 5,
			RELOADING: 6
		},

		ready: false,
		editorElement: false,

		constructor: function( plugins, config ) {
			WE.initAddons();
			WE.Editor.superclass.constructor.call(this);
			WE.fire('newInstance',plugins,config);
			this.pluginConfigs = plugins;
			this.config = $.extend(true, {}, WE.config, config); // clone
			this.initialized = false;
			this.state = false;
			this.mode = false;
		},

		getFormat: function() {
			return WE.modeToFormat(this.mode);
		},

		initPlugins: function() {
			// Get the loading order
			var order = [];
			var loaded = {};
			function queuePlugin(name){
				if (loaded[name]){ return; }
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

		markAsReady: function() {
			if (!this.ready) {
				this.ready = true;
				this.setState(this.states.IDLE);
				this.fire('editorReady', this.event);

				GlobalTriggers.fire('WikiaEditorReady', this);
				$().log('Editor is ready!', 'WikiaEditor');
			}
		},

		setState: function( state ) {
			if (this.state == state) return;
			this.state = state;
			this.fire('state', this, state);
		},

		setMode: function( mode, forceEvents ) {
			if (this.mode == mode && !forceEvents) return;
			this.element.removeClass('mode-' + this.mode);
			this.mode = mode;
			this.element.addClass('mode-' + mode);
			this.fire('mode', this, mode);
		},

		setAsActiveInstance: function(event, forceEvents) {
			if (typeof event == 'boolean') {
				forceEvents = event;
				event = undefined;
			}

			WE.setInstanceId(this.instanceId, event, forceEvents);
		},

		show: function() {
			if (!this.initialized) {
				this.initPlugins();
				this.element = this.config.element;
				this.config.mode = this.config.mode || 'source';
				this.setMode(this.config.mode);
				this.setState(this.states.INITIALIZING);
				this.fire('initConfig', this);
				this.fire('beforeInit', this);
				this.fire('init', this);
				this.fire('initEditor', this);
				this.fire('initDom', this);
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
	WE.plugin = $.createClass(Observable, {

		constructor: function( editor ) {
			WE.plugin.superclass.constructor.call(this);

			var methodName,
				autobindMethods = ['initConfig', 'beforeInit', 'init', 'initEditor', 'initDom', 'afterShow'],
				i = 0,
				l = autobindMethods.length;

			this.editor = editor;

			for (; methodName = autobindMethods[i], i < l; i++) {
				if (typeof this[methodName] == 'function') {
					this.editor.on(methodName, this[methodName], this);
				}
			}
		},

		proxy: function( fn ) {
			return $.proxy(fn, this);
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

				for (var i=0;i<this.providers.length;i++) {
					if (!this.providers[i].ready) return;
				}

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
			var editor = this.editor;

			if (config.forceLogin && wgUserName == null && typeof UserLogin != 'undefined') {
				config.click = function() {
					WE.track( 'force-login-' + config.ckcommand );
					UserLogin.rteForceLogin();
				}

			} else if (!config.click) {
				config.click = function() {
				    var mode = editor.mode;
					if (typeof config['click'+mode] == 'function'){
						return config['click'+mode].apply(this,arguments);
					} else{
						editor.warn('Mode "'+mode+'" not supported for button: '+config.name);
					}
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

		// get editor form wrapping current editor
		getForm: function() {
			return this.editor.element.parent('form');
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
			if (this.editor.config.spaces) {
				this.spaces = $.extend(this.spaces,this.editor.config.spaces);
			}
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
		// All these are included in this file except collapsiblemodules
		requires: ['functions', 'messages', 'ui', 'uiautoregister', 'spaces', 'toolbarspaces', 'collapsiblemodules', 'tracker']
	});

	/**
	 * Mediawiki editor provider
	 */
	WE.plugins.mweditor = $.createClass(WE.plugin,{

		requires: ['ui'],

		// These methods will be publicly available on the editor instance
		proxyMethods: ['getContent', 'setContent', 'getEditbox', 'getEditboxWrapper', 'getEditorElement', 'editorFocus', 'editorBlur'],

		initConfig: function() {
			this.editor.config.mode = 'source';
		},

		beforeInit: function() {
			var i = 0,
				l = this.proxyMethods.length;

			// Set up proxy methods on wikiaEditor
			for (; methodName = this.proxyMethods[i], i < l; i++) {
				this.editor[methodName] = this.proxy(this[methodName]);
			}
		},

		initEditor: function() {
			this.textarea = this.editor.config.body;

			// Mediawiki expects a textarea
			// Extensions will have to handle the html to wikitext conversions
			// TODO: can probably move RTE.ajax() to WikiaEditor to fix this.
			if (!this.textarea.is('textarea')) {
				this.textarea = $('<textarea>')
					.addClass('body')
					.attr('id', 'mw_' + this.editor.instanceId)
					.val($.trim(this.textarea.text()))
					.insertAfter(this.textarea.hide());
			}

			// Event binding
			this.textarea
				.focus(this.proxy(this.editorFocused))
				.blur(this.proxy(this.editorBlurred))
				.click(this.proxy(this.editorClicked))
				.keyup(this.proxy(this.editorKeyUp));

			// Editor is ready now
			this.editor.markAsReady();
		},

		initDom: function() {
			this.editor.fire('editboxReady', this.editor, this.getEditbox());
		},

		getContent: function() {
			return this.textarea.val();
		},

		getEditbox: function() {
			return this.textarea;
		},

		getEditboxWrapper: function() {
			return this.editor.element;
		},

		getEditorElement: function() {
			return this.editor.config.body;
		},

		editorFocus: function() {
			this.textarea.focus();
		},

		editorBlur: function() {
			this.textarea.blur();
		},

		setContent: function(content, datamode) {
			var editbox = this.getEditbox();

			// Needs conversion
			if (datamode == 'wysiwyg') {
				this.html2wiki({ html: content, title: wgPageName }, function(data) {
					editbox.val(data.wikitext);
				});

			} else {
				editbox.val(content);
			}
		},

		html2wiki: function(params, callback) {
			if (typeof params != 'object') {
				params = {};
			}
			params.method = 'html2wiki';

			jQuery.post(window.wgScript + '?action=ajax&rs=RTEAjax', params, function(data) {
				if (typeof callback == 'function') {
					callback(data);
				}
			}, 'json');
		},

		editorFocused: function() {
			this.getEditbox().addClass('focused');
			this.editor.fire('editorFocus', this.editor);
		},

		editorBlurred: function() {
			this.getEditbox().removeClass('focused');
			this.editor.fire('editorBlur', this.editor);
		},

		editorClicked: function() {
			this.editor.fire('editorClick', this.editor);
		},

		editorKeyUp: function() {
			this.editor.fire('editorKeyUp', this.editor);
		}
	});

	/**
	 * CKEditor provider
	 */
	WE.plugins.ckeditor = $.createClass(WE.plugin,{

		requires: ['ui'],

		// These events are proxied from ck and fired on the editor with the 'ck' prefix
		proxyEvents: [
			'blur',
			'focus',
			'instanceReady',
			'keyUp',
			'mode',
			'modeSwitch',
			'modeSwitchCancelled',
			'sourceModeReady',
			'themeLoaded',
			'wysiwygModeReady'
		],

		// These methods will be publicly available on the editor instance
		proxyMethods: [
			'getContent',
			'setContent',
			'getEditbox',
			'getEditboxWrapper',
			'getEditorElement',
			'editorFocus',
			'editorBlur'
		],

		beforeInit: function() {
			var i = 0,
				l = this.proxyMethods.length;

			// Set up proxy methods on wikiaEditor
			for (; methodName = this.proxyMethods[i], i < l; i++) {
				this.editor[methodName] = this.proxy(this[methodName]);
			}
		},

		// wikiaEditor is now available as this.editor
		initEditor: function() {

			// Set up listeners on proxied ck events
			this.editor.on('ck-mode', this.proxy(this.modeChanged));
			this.editor.on('ck-modeSwitch', this.proxy(this.beforeModeChange));
			this.editor.on('ck-modeSwitchCancelled', this.proxy(this.modeChangeCancelled));
			this.editor.on('ck-themeLoaded', this.proxy(this.themeLoaded));
			this.editor.on('ck-focus', this.proxy(this.editorFocused));
			this.editor.on('ck-blur', this.proxy(this.editorBlurred));
			this.editor.on('ck-keyUp', this.proxy(this.editorKeyUp));

			// This one can't be proxied because we need access to it before the proxies are set up
			this.editor.on('ckInstanceCreated', this.proxy(this.ckInstanceCreated));

			// Properly detect when we are finished loading (BugId:20297)
			this.editor.on('afterLoadingStatus', this.proxy(this.afterLoadingStatus));

			// Init RTE for this wikiaEditor instance
			RTE.init(this.editor);
		},

		afterLoadingStatus: function() {
			this.editor.markAsReady();

			// Loading is done, editor container can be visible again
			// And typing can be re-enabled (BugId:23061)
			$(this.editor.ck.container.$).addClass('visible').unbind('keydown.preventTyping');
		},

		// ckeditor instance is now available
		ckInstanceCreated: function(ck) {

			// Store a reference to the CKE instance in wikiaEditor
			this.editor.ck = ck;

			// Set up proxy events on wikiaEditor
			// These events are fired on the CKE instance and proxied over to
			// wikiaEditor as 'ck-originalEventName' to avoid collisions
			for (var i = 0, l = this.proxyEvents.length; i < l; i++) {
				(function(eventName) {
					this.editor.ck.on(eventName, function() {
						this.editor.fire.apply(this.editor, ['ck-' + eventName, this.editor].concat(slice.call(arguments)));
					}, this);
				}).call(this, this.proxyEvents[i]);
			}
		},

		getContent: function() {
			return this.editor.ck.getData();
		},

		// The actual place where the user content is going
		// in WYSIWYG mode, this is the iframe's body element
		// in source mode, this is CKE generated textarea
		getEditbox: function() {
			return $(this.editor.ck.mode == 'wysiwyg' ?
				this.editor.ck.document.getBody().$ : this.editor.ck.textarea.$);
		},

		getEditboxWrapper: function() {
			return $(this.editor.ck.getThemeSpace('contents').$);
		},

		// Returns the original editor element that CKE has replaced
		getEditorElement: function() {
			return $(this.editor.ck.element.$);
		},

		beforeModeChange: function() {

			// Hide the editor container while we switch modes
			$(this.editor.ck.container.$).removeClass('visible')

				// Don't allow typing while switching modes (BugId:23061)
				// We can't use readOnly because it's too buggy so just prevent typing.
				.bind('keydown.preventTyping', function(e) { e.preventDefault(); });

			this.editor.setState(this.editor.ck.mode == 'wysiwyg' ?
				this.editor.states.LOADING_SOURCE : this.editor.states.LOADING_VISUAL);
		},

		modeChanged: function() {
			this.editor.setMode(this.editor.ck.mode);
			this.editor.setState(this.editor.states.IDLE);
			this.getEditbox().click(this.proxy(this.editorClicked)).addClass('focused');
		},

		modeChangeCancelled: function() {
			this.editor.setState(this.editor.states.IDLE);
		},

		themeLoaded: function() {
			this.editor.fire('editboxReady', this.editor, $(this.editor.ck.getThemeSpace('contents').$));
		},

		editorFocus: function() {
			this.editor.ck.focus();
		},

		editorBlur: function() {
			this.editor.ck.blur();
		},

		setContent: function(content, datamode) {
			var ckeditor = this.editor.ck;

			// Needs conversion
			if (datamode && ckeditor.mode != datamode) {
				var params = { title: wgPageName };
				var isWysiwyg = ckeditor.mode == 'wysiwyg';

				params[isWysiwyg ? 'wikitext' : 'html'] = content;

				RTE.ajax(isWysiwyg ? 'wiki2html' : 'html2wiki', params, function(data) {
					ckeditor.setData(data[isWysiwyg ? 'html' : 'wikitext']);
				});

			} else {
				ckeditor.setData(content);
			}
		},

		editorFocused: function() {
			this.getEditbox().addClass('focused');
			this.editor.fire('editorFocus', this.editor);
		},

		editorBlurred: function() {
			this.getEditbox().removeClass('focused');
			this.editor.fire('editorBlur', this.editor);
		},

		editorClicked: function() {
			this.editor.fire('editorClick', this.editor);
		},

		editorKeyUp: function() {
			this.editor.fire('editorKeyUp', this.editor);
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
						var button = command.uiItems[i],
						    ignores = ['ModeWysiwyg','ModeSource']; // override ckeditor's hidding of source/wysiwyg buttons
						if($.inArray(button.command, ignores)<0){
							if (button._.id) {
								$('#'+button._.id)
									.parent()[command.modes[mode]?'removeClass':'addClass']('cke_hidden');
							}
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
			button.clickwysiwyg = function() {
				this.editor.ck.execCommand(button.ckcommand,button.clickdatawysiwyg);
			};
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

				return output.join( '' );
			}

			return false;
		}
	});

	/**
	 * Mediawiki editor plugins list
	 */
	WE.plugins.mweditorsuite = $.createClass(WE.plugin,{
		requires: ['core', 'mweditor']
	});

	/**
	 * CKEditor plugins list
	 */
	WE.plugins.ckeditorsuite = $.createClass(WE.plugin,{
		requires: ['core', 'ckeditor', 'ui-ckeditor']
	});

	GlobalTriggers.fire('wikiaeditor',WE);

})(this, jQuery);
