(function($, window, undefined) {
	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	// Rich Text Editor
	// See also: RTE.preferences.js
	var RTE = {

		// configuration
		// @see http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html
		config: {
			alignableElements: {
				div: true,
				p: true,
				td: true,
				th: true
			},
			baseFloatZIndex: 5000101, // $zTop + 1 from _layout.scss
			bodyClass: 'WikiaArticle',
			bodyId: 'bodyContent',
			contentsCss: [$.getSassLocalURL('extensions/wikia/RTE/css/content.scss'), window.RTESiteCss],
			coreStyles_bold: {element: 'b', overrides: 'strong'},
			coreStyles_italic: {element: 'i', overrides: 'em'},
			customConfig: '',
			dialog_backgroundCoverColor: '#000',
			dialog_backgroundCoverOpacity: 0.8,
			disableDragDrop: false,
			disableObjectResizing: true,
			entities: false,
			format_tags: 'p;h2;h3;h4;h5;pre',
			height: 400, // default height when "auto resizing" is not applied
			indentOffset: 24, // match WikiaArticle styles (BugId:25379)
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
				'tab,' +
				'table,' +
				'tabletools,' +
				'undo,' +
				'wysiwygarea',

			// Custom RTE plugins for CKEDITOR
			// Used to be built in RTE.loadPlugins()
			extraPlugins:
				'rte-accesskey,' +
				'rte-comment,' +
				'rte-dialog,' +
				'rte-dragdrop,' +
				'rte-entities,' +
				'rte-gallery,' +
				'rte-justify,' +
				'rte-link,' +
				'rte-linksuggest,' +
				'rte-media,' +
				'rte-modeswitch,' +
				'rte-overlay,' +
				'rte-paste,' +
				'rte-placeholder,' +
				'rte-signature,' +
				'rte-spellchecker,' +
				'rte-template,' +
				'rte-temporary-save,' +
				'rte-toolbar,' +
				'rte-tools',
			// TODO: Too buggy. Try to use this after we update to 3.6.2 (BugId:23061)
			//readOnly: true,
			resize_enabled: false,
			richcomboCss: $.getSassCommonURL('extensions/wikia/RTE/css/richcombo.scss'),
			skin: 'wikia',
			startupFocus: true, // Also used for determining wether to focus after modeswitch (BugId:19807)
			theme: 'wikia'
		},

		// Unique editor instance Id, set on modeswitch
		// See RTE::getInstanceID() for details
		instanceId: null,

		// array of fully loaded editor instances.
		loaded: [],

		// CK loading time
		loadTime: false,

		// Used for image tools (modify/remove)
        overlayNode: $('<div id="RTEOverlay" class="rte-overlay">'),

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

		// Cache contents css so we don't have to load it every time mode switches (BugId:5654)
		getContentsCss: function(editor) {

			// Bartek - for RT #43217
			if (typeof WikiaEnableAutoPageCreate != 'undefined') {
				RTE.config.contentsCss.push(wgServer + '/extensions/wikia/AutoPageCreate/AutoPageCreate.css'); // local path needs to be used here
			}

			var contentsCss = '',
				index = 0,
				length = RTE.config.contentsCss.length;

			(function load() {
				$.get(RTE.config.contentsCss[index], function(css) {
					contentsCss += css, index++;

					if (index < length) {
						load();

					// Done loading
					} else {
						RTE.config.contentsCss = contentsCss;
						RTE.initCk(editor);
					}
				});
			}());
		},

		init: function(editor) {

			// Don't re-initialize the same instance
			if (CKEDITOR.instances[editor.instanceId]) {
				return;
			}

			// Load and cache contents CSS on the first initialization
			if ($.isArray(RTE.config.contentsCss)) {
				RTE.getContentsCss(editor);

			} else {
				RTE.initCk(editor);
			}
		},

		initCk: function(editor) {
			if (editor.config.minHeight) {
				RTE.config.height = editor.config.minHeight;
			}

			if (typeof editor.config.tabIndex != 'undefined') {
				RTE.config.tabIndex = editor.config.tabIndex;
			}

			if (typeof editor.config.startupFocus != 'undefined') {
				RTE.config.startupFocus = editor.config.startupFocus;
			}

			RTE.config.startupMode = editor.config.mode;

			// This call creates a new CKE instance which replaces the textarea with the applicable ID
			editor.ck = CKEDITOR.replace(editor.instanceId, RTE.config);

			// load CSS files
			RTE.loadExtraCss(editor.ck);

			// clean HTML returned by CKeditor
			editor.ck.on('getData', RTE.filterHtml);

			// CKeditor code is loaded, now it's time to initialize RTE
			GlobalTriggers.fire('rteinit', editor.ck);
		},

		// load extra CSS - modstly for PLB at this point.
		// TODO: work this into getContentsCss()
		loadExtraCss: function(editor) {
			var css = [];

			GlobalTriggers.fire('rterequestcss', css);

			for (var n=0; n<css.length; n++) {
				if( typeof(css[n]) != 'undefined' ) {
					var cb = ( (css[n].indexOf('?') > -1 || css[n].indexOf('__am') > -1) ? '' : ('?' + CKEDITOR.timestamp) );
					editor.addCss('@import url(' + css[n] + cb + ');');
				}
			}

			// disable object resizing in IE. IMPORTANT! use local path
			if (CKEDITOR.env.ie && RTE.config.disableObjectResizing) {
				editor.addCss('img {behavior:url(' + RTE.constants.localPath + '/css/behaviors/disablehandles.htc)}');
			}
		},

		// final setup of editor's instance
		onEditorReady: function(event) {
			var editor = event.editor,
				instanceId = editor.instanceId;

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
			RTE.loaded.push(editor);

			// calculate load time
			RTE.loadTime = (new Date() - window.wgNow) / 1000;

			RTE.log('CKEditor v' + CKEDITOR.version +
				(window.RTEDevMode ? ' (in development mode)' : '') +
				' is ready in "' + editor.mode + '" mode (loaded in ' + RTE.loadTime + ' s)');

			// let extensions do their tasks when RTE is fully loaded
			$(window).trigger('rteready', editor);
			GlobalTriggers.fire('rteready', editor);

			// preload format dropdown (BugId:4592)
			var formatDropdown = editor.ui.create('Format');
			if (formatDropdown) {
				formatDropdown.createPanel(editor);
			}

			// send custom event "submit" when edit page is being saved (BugId:2947)
			var editform = $(editor.element.$.form).bind('submit', $.proxy(function() {
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

			$(window).resize(RTE.repositionRTEOverlay).resize();
		},

		// reposition #RTEOverlay div
		repositionRTEOverlay: function() {
			RTE.overlayNode.css({left:0,top:0});

			var wikiaEditor = WikiaEditor.getInstance(),
				editorWrapper =  wikiaEditor.getEditboxWrapper(),
				bodyPadding = RTE.overlayNode.offset(),
				editorPosition = editorWrapper.offset();

			RTE.overlayNode.css({
				'left': parseInt(editorPosition.left - bodyPadding.left) + 'px',
				'top': parseInt(editorPosition.top - bodyPadding.top) + 'px'
			});
		},

		// get jQuery object wrapping body of editor' iframe
		getEditor: function(instanceId) {
			return $(RTE.getInstance(instanceId).document.$.body);
		},

		// Returns the CKE instance that belongs to ID (or the current instance if no ID is given)
		getInstance: function(instanceId) {
			return CKEDITOR.instances[instanceId || WE.instanceId];
		},

		// Returns the wikiaEditor instance that belongs to ID (or the current instance if no ID is given)
		getInstanceEditor: function(instanceId) {
			return WE.instances[instanceId || WE.instanceId];
		},

		// Returns the element associated with an instance ID (or the current element if no ID is given)
		getInstanceElement: function(instanceId) {
			return $('#' + instanceId || WE.instanceId);
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

	// Create overlayNode when the DOM is ready
	$(function() {
		RTE.overlayNode.appendTo('body');
	});

	// Exports
	window.RTE = RTE;

})(jQuery, window);

// Hack for IE with allinone mode turned off
// Due to asynchronous script loading issues in WSL, things are executed out of order
// which causes CKEDITOR to think plugins haven't been loaded yet, so it attempts to load
// them again. In order for CKEDITOR to find our plugins, we must use addExternal here
if ($.browser.msie && typeof RTEDevMode != 'undefined') {
	CKEDITOR.on('loaded', function(event) {
		var i, l, plugin, extraPlugins = RTE.config.extraPlugins.split(',');
		for (var plugin, i = 0, l = extraPlugins.length; i < l, plugin = extraPlugins[i]; i++ ) {
			CKEDITOR.plugins.addExternal(plugin, RTE.constants.localPath + '/js/plugins/' + plugin.replace('rte-', '') + '/');
		}
	});
}

// Pass the newly created CKE instances to wikiaEditor
CKEDITOR.on('instanceCreated', function(event) {

	// event.editor.name stores the elementId of the textarea CKE was attached to
	// this ensures we are firing the event on the correct editor
	WikiaEditor.instances[event.editor.name].fire('ckInstanceCreated', event.editor);
});

// editor is loaded
CKEDITOR.on('instanceReady', RTE.onEditorReady);

//
// CKEDITOR.dtd fixes
//

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

// RT #69635: disable media drag&drop in Firefox 3.6.9+ (fixed in Firefox 3.6.11)
RTE.config.disableDragDrop = (CKEDITOR.env.gecko && (CKEDITOR.env.geckoRelease == "1.9.2.9" || CKEDITOR.env.geckoRelease == "1.9.2.10"));

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
		var url = window.wgServer + '/wikia.php?controller=RTE&method=i18n&uselang=' + lang +
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

// cache buster used by CK when loading CSS/JS
CKEDITOR.timestamp = window.wgStyleVersion;

/**
 * @author wladek
 * @constant
 * @description
 * Used in selection.getRanges() as an additional value for the onlyEditables parameter
 */
CKEDITOR.ONLY_FORMATTABLES = 2;
