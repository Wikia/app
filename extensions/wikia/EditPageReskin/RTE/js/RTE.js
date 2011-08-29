/*global CKEDITOR: true */

window.RTE = {
	// configuration
	// @see http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html
	config: {
		alignableElements: {
			div: true,
			p: true,
			td: true,
			th: true
		},
		baseFloatZIndex: 20000001, // $zTop from _layout.scss
		bodyClass: 'WikiaArticle',
		bodyId: 'bodyContent',
		contentsCss: $.getSassCommonURL('/extensions/wikia/EditPageReskin/RTE/css/content.scss'),
		coreStyles_bold: {element: 'b', overrides: 'strong'},
		coreStyles_italic: {element: 'i', overrides: 'em'},
		customConfig: '',
		dialog_backgroundCoverColor: '#000',
		dialog_backgroundCoverOpacity: (window.skin == 'oasis' ? 0.8 : 0.5),
		disableDragDrop: false,
		disableObjectResizing: true,
		entities: false,
		format_tags: 'p;h2;h3;h4;h5;pre',
		height: 400, // default height when "auto resizing" is not applied
		language: window.wgUserLanguage,
		plugins:
			'basicstyles,' +
			'button,' +
			'clipboard,' +
			'contextmenu,' +
			'dialog,' +
			'enterkey,' +
			'format,' +
			'htmldataprocessor,' +
			'indent,' +
			'keystrokes,' +
			'list,' +
			'pastetext,' +
			'removeformat,' +
			'sourcearea,' +
			'table,' +
			'tabletools,' +
			'undo,' +
			'wysiwygarea',
		resize_enabled: false,
		richcomboCss: $.getSassCommonURL('extensions/wikia/EditPageReskin/RTE/css/richcombo.scss'),
		skin: 'wikia',
		startupFocus: true,
		theme: 'wikia'
	},

	// reference to current CK instance
	instance: false,

	// editor instance ID
	instanceId: window.RTEInstanceId,

	// is instance fully loaded?
	loaded: false,

	// CK loading time
	loadTime: false,

	// reference to #RTEStuff node
	// TODO: store this node per instance
	stuffNode: false,

	// list of our RTE custom plugins (stored in js/plugins) to be loaded on editor init
	plugins: [
		'accesskey',
		'comment',
		'dialog',
		'dragdrop',
		'entities',
		'gallery',
		'justify',
		'link',
		'linksuggest',
		'media',
		'modeswitch',
		'overlay',
		'paste',
		'placeholder',
		'plbelement',
		'poll',
		'signature',
		'spellchecker',
		'template',
		'temporary-save',
		'toolbar',
		'tools',
		'track'
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

	track: function(action, label, value) {
	},

	// start editor in mode provided
	init : function(mode) {
		// Fire the global event
		GlobalTriggers.fire('rtebeforeinit', RTE, CKEDITOR);

		// cache buster used by CK when loading CSS/JS
		CKEDITOR.timestamp = window.wgStyleVersion;

		// CKEDITOR.dtd fixes
		// TODO: move to different place

		// allow <img> (used for placeholders) to be placed inside <pre>
		CKEDITOR.dtd.pre.img = 1;

		// allow <center> to be placed inside <p>
		CKEDITOR.dtd.p = $.extend({}, CKEDITOR.dtd.p, {center:1});

		// allow <img> (used for placeholders) to be "direct" child of <table> (refs RT #49507)
		CKEDITOR.dtd.table.img = 1;

		// allow UL and OL in DT (RT#52593)
		// DTD rules for <dt> use $inline elements which should not be modified (BugId:1304)
		CKEDITOR.dtd.dt = $.extend({}, CKEDITOR.dtd.dt, {ul:1, ol:1});

		// allow placeholders in UL/OL lists (BugId:10481)
		CKEDITOR.dtd.ol = $.extend({}, CKEDITOR.dtd.ol, {img:1});
		CKEDITOR.dtd.ul = $.extend({}, CKEDITOR.dtd.ul, {img:1});

		// set startup mode
		RTE.config.startupMode = mode;

		// RT #69635: disable media drag&drop in Firefox 3.6.9+ (fixed in Firefox 3.6.11)
		RTE.config.disableDragDrop = (CKEDITOR.env.gecko && (CKEDITOR.env.geckoRelease == "1.9.2.9" || CKEDITOR.env.geckoRelease == "1.9.2.10"));

		if (RTE.config.disableDragDrop) {
			RTE.log('media drag&drop disabled');
		}

		// register and load RTE plugins
		RTE.loadPlugins();

		// add and position wrapper for extra RTE stuff
		RTE.stuffNode = $('<div>', {id: 'RTEStuff'}).appendTo('body');

		// make textarea wysiwygable and store editor instance object
		RTE.instance = CKEDITOR.replace('wpTextbox1', RTE.config);

		// load CSS files
		RTE.loadCss();

		//
		// register event handlers
		//

		// editor is loaded
		CKEDITOR.on('instanceReady', RTE.onEditorReady);

		// clean HTML returned by CKeditor
		RTE.instance.on('getData', RTE.filterHtml);

		// CKeditor code is loaded, now it's time to initialize RTE
		GlobalTriggers.fire('rteinit', RTE.instance);
	},

	// load extra CSS files
	loadCss: function() {
		var css = [];

		// load MW:Common.css / MW:Wikia.css (RT #77759)
		css.push(window.RTESiteCss);

		// Bartek - for RT #43217
		if( typeof WikiaEnableAutoPageCreate != "undefined" ) {
			css.push(wgExtensionsPath + '/wikia/AutoPageCreate/AutoPageCreate.css');
		}

		GlobalTriggers.fire('rterequestcss', css);

		for (var n=0; n<css.length; n++) {
			var cb = ( (css[n].indexOf('?') > -1 || css[n].indexOf('__am') > -1) ? '' : ('?' + CKEDITOR.timestamp) );
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

	// final setup of editor's instance
	onEditorReady: function(ev) {
		var editor = ev.editor;

		// base colors: use color / background-color from .color1 CSS class
		RTE.tools.getThemeColors();

		// remove HTML indentation
		editor.dataProcessor.writer.indentationChars = '';
		editor.dataProcessor.writer.lineBreakChars = '';

		// override "Source" button to send AJAX request first, instead of mode switching
		CKEDITOR.plugins.sourcearea.commands.source.exec = function(editor) {
			if (editor.mode == 'wysiwyg') {
				editor.fire('saveSnapshot');
			}

			editor.fire('modeSwitch');
		}

		// ok, we're done!
		RTE.loaded = true;

		// calculate load time
		RTE.loadTime = (new Date() - window.wgNow) / 1000;

		RTE.log('CKEditor v' + CKEDITOR.version +
			(window.RTEDevMode ? ' (in development mode)' : '') +
			' is ready in "' + editor.mode + '" mode (loaded in ' + RTE.loadTime + ' s)');

		// fire custom event for "track" plugin
		editor.fire('RTEready');

		// let extensions do their tasks when RTE is fully loaded
		$(window).trigger('rteready', editor);
		GlobalTriggers.fire('rteready', editor);

		// reposition #RTEStuff
		RTE.repositionRTEStuff();
		$(window).
			add('#EditPage').
			bind('resize', RTE.repositionRTEStuff);

		// preload format dropdown (BugId:4592)
		var formatDropdown = editor.ui.create('Format');
		if (formatDropdown) {
			formatDropdown.createPanel(editor);
		}

		// send custom event "submit" when edit page is being saved (BugId:2947)
		var editform = $(editor.element.$.form);
		editform.bind('submit', $.proxy(function() {
			editor.fire('submit', {form: editform}, editor);
		}, this));

		// remove data-rte-instance attribute when sending HTML to backend
		editor.dataProcessor.htmlFilter.addRules({
			attributes: {
				'data-rte-instance': function(value, element) {
					return false;
				}
			}
		});
	},

	// reposition #RTEStuff div
	repositionRTEStuff: function() {
		RTE.stuffNode.css({left:0,top:0});

		var bodyPadding = RTE.stuffNode.offset();
		var editorPosition = $('#cke_contents_wpTextbox1').offset();

		RTE.stuffNode.css({
			'left': parseInt(editorPosition.left - bodyPadding.left) + 'px',
			'top': parseInt(editorPosition.top - bodyPadding.top) + 'px'
		});
	},

	// get jQuery object wrapping body of editor' iframe
	getEditor: function() {
		return jQuery(RTE.instance.document.$.body);
	},

	// filter HTML returned by CKEditor
	// TODO: implement using htmlFilter
	// @see http://docs.cksource.com/CKEditor_3.x/Developers_Guide/Data_Processor#HTML_Parser_Filters
	filterHtml: function(ev) {
		if (ev.editor.mode == 'wysiwyg') {
			// remove <div> added by Firebug
			ev.data.dataValue = ev.data.dataValue.replace(/<div firebug[^>]+>[^<]+<\/div>/g, '');
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

//
// extend CK core objects
//

// override this method, so we can ignore attributes matching data-rte-*
CKEDITOR.dom.element.prototype.hasAttributesOriginal = CKEDITOR.dom.element.prototype.hasAttributes;

CKEDITOR.dom.element.prototype.hasAttributes = function() {
	var ret = this.hasAttributesOriginal();

	// check for internal RTE attributes
	if (ret == true) {
		var internalAttribs = ['data-rte-washtml', 'data-rte-line-start', 'data-rte-empty-lines-before'];

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
			'&cb=' + window.wgJSMessagesCB;

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

/**
 * @author wladek
 * @constant
 * @description
 * Used in selection.getRanges() as an additional value for the onlyEditables parameter
 */
CKEDITOR.ONLY_FORMATTABLES = 2;
