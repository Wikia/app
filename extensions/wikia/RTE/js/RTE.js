window.RTE = {
	// configuration
	// @see http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html
	config: {
		'alignableElements':  ['p', 'div', 'td' ,'th'],
		'baseFloatZIndex': 1000,
		'bodyId': 'bodyContent',
		'coreStyles_bold': {element: 'b', overrides: 'strong'},
		'coreStyles_italic': {element: 'i', overrides: 'em'},
		'customConfig': '',
		'dialog_backgroundCoverColor': '#000',
		'dialog_backgroundCoverOpacity': (window.skin == 'oasis' ? 0.8 : 0.5),
		'disableDragDrop': false,
		'disableObjectResizing': true,
		'entities': false,
		'format_tags': 'p;h2;h3;h4;h5;pre',
		'height': 400,
		'language': window.wgUserLanguage,
		'removePlugins': 'about,elementspath,filebrowser,flash,forms,horizontalrule,image,justify,link,maximize,newpage,pagebreak,toolbar,save,scayt,smiley,wsc',
		'resize_enabled': false,
		'skin': 'wikia',
		'startupFocus': CKEDITOR.env.gecko ? false : true,
		'theme': 'wikia',
		'toolbar': 'Wikia',
		'toolbarCanCollapse': false
	},

	// reference to current CK instance
	instance: false,

	// editor instance ID
	instanceId: window.RTEInstanceId,

	// is instance fully loaded?
	loaded: false,

	// CK loading time
	loadTime: false,

	// list of our RTE custom plugins (stored in js/plugins) to be loaded on editor init
	plugins: [
		'comment',
		'dialog',
		'dragdrop',
		'edit-buttons',
		'entities',
		'first-run-notice',
		'gallery',
		'justify',
		'link',
		'linksuggest',
		'media',
		'modeswitch',
		'paste',
		'placeholder',
		'signature',
		'template',
		'temporary-save',
		'toolbar',
		'tools',
		'track',
		'widescreen',
		'toolbar'
	],

	// use firebug / opera console to log events / dump objects
	log: function(msg) {
		$().log(msg, 'RTE');
	},

	// send AJAX request
	ajax: function(method, params, callback) {
		if (typeof params != 'object') {
			params = {};
		}
		params.method = method;

		jQuery.post(window.wgScript + '?action=ajax&rs=RTEAjax', params, function(data) {
			if (typeof callback == 'function') {
				callback(data);
			}
		}, 'json');
	},

	// track events
	// @see http://code.google.com/intl/pl-PL/apis/analytics/docs/tracking/eventTrackerGuide.html
	track: function(action, label, value) {
		// get method attributes
		var args = ['ckeditor']; for (i=0; i < arguments.length; i++) args.push(arguments[i]);

		// TODO: use GA event tracking
		// pageTracker._trackEvent.apply(window, args);
		if (typeof jQuery.tracker != 'undefined') {
			jQuery.tracker.byStr(args.join('/'));
		}
	},

	// start editor in mode provided
	init : function(mode) {
		// cache buster used by CK when loading CSS/JS
		CKEDITOR.timestamp = window.wgStyleVersion;

		// allow <img> (used for placeholders) to be placed inside <pre>
		CKEDITOR.dtd.pre.img = 1;

		// allow <center> to be placed inside <p>
		CKEDITOR.dtd.p.center = 1;

		// allow <img> (used for placeholders) to be "direct" child of <table> (refs RT #49507)
		CKEDITOR.dtd.table.img = 1;

		// allow UL id DT (RT#52593)
		CKEDITOR.dtd.dt.ul = 1;

		// allow OL id DT (RT#52593)
		CKEDITOR.dtd.dt.ol = 1;

		// set startup mode
		RTE.config.startupMode = mode;

		// RT #69635: disable media drag&drop on Chrome & Firefox 3.6.9+
		RTE.config.disableDragDrop = $().isChrome() || (CKEDITOR.env.gecko && CKEDITOR.env.version > 10900);

		if (RTE.config.disableDragDrop) {
			RTE.log('media drag&drop disabled');
		}

		// register and load RTE plugins
		RTE.loadPlugins();

		// add and position wrapper for extra RTE stuff
		$('<div id="RTEStuff" />').appendTo('body');
		RTE.repositionRTEStuff();
		$(window).bind('resize', RTE.repositionRTEStuff);

		// make textarea wysiwygable and store editor instance object
		RTE.instance = CKEDITOR.replace('wpTextbox1', RTE.config);

		// load CSS files
		RTE.loadCss();

		//
		// register event handlers
		//

		// editor is loaded
		CKEDITOR.on('instanceReady', RTE.onEditorReady);

		// user wants to switch modes - send AJAX request
		RTE.instance.on('modeSwitch', function() {
			RTE.modeSwitch(RTE.instance.mode);
		});

		// mode is ready
		RTE.instance.on('mode', function() {
			RTE.loading(false);
			RTE.log('mode "' + this.mode + '" is loaded');
		});

		// wysiwyg mode is ready - fire "wysiwygModeReady" custom event
		RTE.instance.on('dataReady', function() {
			if (this.mode == 'wysiwyg') {
				this.fire('wysiwygModeReady');
			}
		});

		RTE.instance.on('wysiwygModeReady', RTE.onWysiwygModeReady);

		// regenerate placeholders after each redo/undo
		RTE.instance.on('afterUndo', function() {
			RTE.instance.fire('wysiwygModeReady');
		});
		RTE.instance.on('afterRedo', function() {
			RTE.instance.fire('wysiwygModeReady');
		});

		// event fired when Widescreen button in pressed
		RTE.instance.on('widescreen', RTE.onWidescreen);

		// CK is loading...
		RTE.loading(true);
	},

	// load extra CSS files
	loadCss: function() {
		var css = [
			window.stylepath + '/monobook/main.css',
			CKEDITOR.basePath + '../css/RTEcontent.css',
			window.RTEMWCommonCss
		];

		// Bartek - for RT #43217
		if( typeof WikiaEnableAutoPageCreate != "undefined" ) {
			css.push( wgExtensionsPath + '/wikia/AutoPageCreate/AutoPageCreate.css' );
		}

		for (var n=0; n<css.length; n++) {
			var cb = ( (css[n].indexOf('?') > -1) ? '' : ('?' + CKEDITOR.timestamp) );
			RTE.instance.addCss('@import url(' + css[n] + cb + ');');
		}

		// disable object resizing in IE
		if (CKEDITOR.env.ie && RTE.config.disableObjectResizing) {
			// IMPORTANT! use local path
			RTE.instance.addCss('img {behavior:url(' + RTE.constants.localPath + '/css/behaviors/disablehandles.htc)}');
		}
	},

	// register and load custom RTE plugins
	loadPlugins: function() {
		var extraPlugins= [];

		for (var p=0; p < RTE.plugins.length; p++) {
			var plugin = RTE.plugins[p];

			extraPlugins.push('rte-' + plugin);

			// register plugin
			CKEDITOR.plugins.addExternal('rte-' + plugin, CKEDITOR.basePath + '../js/plugins/' + plugin + '/');
		}

		// load custom RTE plugins
		RTE.config.extraPlugins = extraPlugins.join(',');
	},

	// final setup
	onEditorReady: function() {
		// base colors: use color / background-color from .color1 CSS class
		RTE.tools.getThemeColors();

		// remove HTML indentation
		RTE.instance.dataProcessor.writer.indentationChars = '';
		RTE.instance.dataProcessor.writer.lineBreakChars = '';

		// override "Source" button to send AJAX request first, instead of mode switching
		CKEDITOR.plugins.sourcearea.commands.source.exec = function(editor) {
			RTE.log('switching mode');

			if (editor.mode == 'wysiwyg') {
				editor.fire('saveSnapshot');
			}

			editor.getCommand('source').setState(CKEDITOR.TRISTATE_DISABLED);

			editor.fire('modeSwitch');
		}

		// reposition #RTEStuff
		RTE.repositionRTEStuff();

		// ok, we're done!
		RTE.loaded = true;
		RTE.loading(false);

		// calculate load time
		RTE.loadTime = ( (new Date()).getTime() - window.wgRTEStart.getTime() ) / 1000;

		RTE.log('CKeditor v' + window.CKEditorVersion + ' (' +
			(window.RTEDevMode ? 'in development mode' : CKEDITOR.revision + ' build ' + CKEDITOR.version) +
			') is ready in "' + RTE.instance.mode + '" mode (loaded in ' + RTE.loadTime + ' s)');

		// editor resizing
		if (typeof window.EditEnhancements == 'function') {
			EditEnhancements();
		}

		// fire custom event for "track" plugin
		RTE.instance.fire('RTEready');

		if(!RTE.config.startupFocus) {
			setTimeout(function() {RTE.instance.focus(); }, 100);
		}
	},

	// extra setup of <body> wrapping editing area in wysiwyg mode
	onWysiwygModeReady: function() {
		RTE.log('onWysiwygModeReady');

		var body = RTE.getEditor();

		body.
			// set ID, so CSS rules from MW can be applied
			attr('id', RTE.instance.config.bodyId).
			// set CSS class with content language of current wiki (used by RT #40248)
			addClass('lang-' + window.wgContentLanguage);

		// RT #38516: remove first <BR> tag (fix strange Opera bug)
		setTimeout(function() {
			if (CKEDITOR.env.opera) {
				var firstChild = RTE.getEditor().children().eq(0);

				// first child is <br> without any attributes
				if (firstChild.is('br')) {
					firstChild.remove();
				}
			}
		}, 750);
	},

	// reposition of #RTEStuff div when Widescreen button is pressed
	onWidescreen: function() {
		RTE.repositionRTEStuff();
	},

	// reposition #RTEStuff div
	repositionRTEStuff: function() {
		var editorPosition = $('#editform').offset();
		var toolbarPosition = $('#cke_wpTextbox1').position(); // in Special:CreatePage CKeditor is not the first child of editform

		if (!toolbarPosition) {
			toolbarPosition = {top: 0};
		}

		$('#RTEStuff').css({
			'left': parseInt(editorPosition.left) + 'px',
			'top': parseInt(editorPosition.top + toolbarPosition.top + $('#cke_top_wpTextbox1').height()) + 'px'
		});
	},

	// get jQuery object wrapping body of editor' iframe
	getEditor: function() {
		return jQuery(RTE.instance.document.$.body);
	},

	// set loading state of an editor (show progress icon)
	loading: function(loading) {
		if (loading) {
			$('body').addClass('RTEloading');
		}
		else {
			$('body').removeClass('RTEloading');
		}
	},

	// handle mode switching (prepare data)
	modeSwitch: function(mode) {
		RTE.log('switching from "' + mode +'" mode');

		// get HTML / wikitext
		var content = RTE.instance.getData();
		//RTE.log(content);

		// show loading indicator
		RTE.loading(true);

		switch (mode) {
			case 'wysiwyg':
				RTE.ajax('html2wiki', {html: content, title: window.wgPageName}, function(data) {
					RTE.instance.setMode('source');
					RTE.instance.setData(data.wikitext);

					RTE.track('switchMode', 'wysiwyg2source');
				});
				break;

			case 'source':
				RTE.ajax('wiki2html', {wikitext: content, title: window.wgPageName}, function(data) {

					// RT #36073 - don't allow mode switch when __NOWYSIWYG__ is found in another article section
					if ( (typeof window.RTEEdgeCase != 'undefined') && (window.RTEEdgeCase == 'nowysiwyg') ) {
						RTE.log('article contains __NOWYSIWYG__ magic word');

						data.edgecase = {
							type: window.RTEEdgeCase,
							info: {
								title: window.RTEMessages.edgecase.title,
								content: window.RTEMessages.edgecase.content
							}
						};
					}

					if (data.edgecase) {
						RTE.log('edgecase found!');
						RTE.tools.alert(data.edgecase.info.title, data.edgecase.info.content);

						// stay in source mode
						RTE.instance.getCommand('source').setState(CKEDITOR.TRISTATE_ON);
						RTE.loading(false);

						// tracking
						RTE.track('switchMode', 'edgecase', data.edgecase.type);
						return;
					}

					RTE.instance.setMode('wysiwyg');
					RTE.instance.setData(data.html);

					RTE.track('switchMode', 'source2wysiwyg');
				});
				break;
		}
	},

	// constants (taken from global JS variables added by RTE backend)
	constants: {
		localPath: window.RTELocalPath,
		urlProtocols: window.RTEUrlProtocols,
		validTitleChars: window.RTEValidTitleChars
	},

	// messages to be used in JS code
	messages: window.RTEMessages
};

//
// extend CK config
//

/**
 * ID which will be assigned to <body> of editing area (added by Wikia)
 * @type string
 * @default ''
 * @example
 * config.bodyId = 'content';
*/
CKEDITOR.config.bodyId = '';

/**
 * Base UI background color
 * @type string
 * @default '#ddd'
 * @example
 * config.bodyId = '#36C';
*/
CKEDITOR.config.baseBackgroundColor = '#ddd';

/**
 * Base UI color
 * @type string
 * @default '#000'
 * @example
 * config.bodyId = '#fff';
*/
CKEDITOR.config.baseColor = '#000';

// Wikia toolbar
CKEDITOR.config.toolbar_Wikia =
[
	{
		msg: 'textAppearance',
		groups: [
			['Format'],
			['Bold','Italic','Underline','Strike'],
			['BulletedList','NumberedList'],
			['Link','Unlink'],
			['Outdent','Indent'],
			['JustifyLeft','JustifyCenter','JustifyRight']
		]
	},
	{
		msg: 'insert',
		groups: [
			['Image', 'Gallery', 'Video'],
			['Table'],
			['Template'],
			['Signature']
		]
	},
	{
		msg: 'controls',
		groups: [
			['Undo','Redo'],
			(window.skin == 'oasis' ? false : ['Widescreen']), // temp hack
			['Source']
		]
	}
];

//
// extend CK core objects
//

// override this method, so we can ignore attributes matching _rte_*
CKEDITOR.dom.element.prototype.hasAttributesOriginal = CKEDITOR.dom.element.prototype.hasAttributes;

CKEDITOR.dom.element.prototype.hasAttributes = function() {
	var ret = this.hasAttributesOriginal();

	// check for internal RTE attributes
	if (ret == true) {
		var internalAttribs = ['_rte_washtml', '_rte_line_start', '_rte_empty_lines_before'];

		for (i=0; i<internalAttribs.length; i++) {
			if (this.hasAttribute(internalAttribs[i])) {
				ret = false;
			}
		}
	}

	return ret;
}

// catch requests for language JS files
CKEDITOR.langRegExp = /lang\/([\w\-]+).js/;

// load CK files from _source subdirectory
CKEDITOR.getUrl = function( resource ) {

	// catch requests for /lang/xx.js
	if (CKEDITOR.langRegExp.test(resource)) {
		var matches = resource.match(CKEDITOR.langRegExp);
		var lang = matches[1];

		RTE.log('language "' + lang + '" requested');

		// fetch JSON with language definition from backend
		var url = window.wgServer + wgScript + '?action=ajax&rs=RTEAjax&method=i18n&uselang=' + lang +
			'&cb=' + window.wgMWrevId + '-' + window.wgStyleVersion;

		return url;
	}

	// If this is not a full or absolute path.
	if ( resource.indexOf('://') == -1 && resource.indexOf( '/' ) !== 0 ) {
		// Wikia: add _source subdirectory
		if ( resource.indexOf('_source') == -1 ) {
			resource = '_source/' + resource;
		}

		resource = this.basePath + resource;
	}

	// Add the timestamp, except for directories.
	if ( this.timestamp && resource.charAt( resource.length - 1 ) != '/' ) {
		resource += ( resource.indexOf( '?' ) >= 0 ? '&' : '?' ) + this.timestamp;
	}

	return resource;
}

// use this method to change current mode from JS code (selenium test)
CKEDITOR.editor.prototype.switchMode = function(mode) {
	if (this.mode == mode) {
		return;
	}

	RTE.log('switchMode("' + mode + '")');

	this.mode = (mode == 'wysiwyg') ? 'source' : 'wysiwyg';

	CKEDITOR.plugins.sourcearea.commands.source.exec(this);
}

// modify parent node of button
CKEDITOR.dom.element.prototype.setState = function( state ) {
	var node = this.getParent();

	switch ( state )
	{
		case CKEDITOR.TRISTATE_ON :
			node.addClass( 'cke_on' );
			node.removeClass( 'cke_off' );
			node.removeClass( 'cke_disabled' );
			break;
		case CKEDITOR.TRISTATE_DISABLED :
			node.addClass( 'cke_disabled' );
			node.removeClass( 'cke_off' );
			node.removeClass( 'cke_on' );
			break;
		default :
			node.addClass( 'cke_off' );
			node.removeClass( 'cke_on' );
			node.removeClass( 'cke_disabled' );
			break;
	}
};

//
// extend jQuery
//

// get meta data from given node
jQuery.fn.getData = function() {
	var json = this.attr('_rte_data');
	if (!json) {
		return {};
	}

	// decode JSON
	json = decodeURIComponent(json);

	var data = $.secureEvalJSON(json) || {};
	return data;
}

// set meta data for given node
jQuery.fn.setData = function(key, value) {
	var data = {};

	// prepare data to be stored
	if (typeof key == 'object') {
		data = key;
	}
	else if (typeof key == 'string') {
		data[key] = value;
	}

	// read current data stored in node and merge with data
	data = jQuery().extend(true, this.getData(), data);

	// encode JSON
	var json = $.toJSON(data);

	this.attr('_rte_data', encodeURIComponent(json));

	// return modified data
	return data;
}

// set type of given placeholder
jQuery.fn.setType = function(type) {
	$(this).attr('class', 'placeholder placeholder-' + type).setData('type', type);
}

// load RTE on DOM ready
jQuery(function() {
	RTE.log('starting...');

	// select initial mode
	var mode = window.RTEInitMode ? window.RTEInitMode : 'wysiwyg';

	RTE.init(mode);
});
