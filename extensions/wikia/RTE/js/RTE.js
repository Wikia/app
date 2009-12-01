window.RTE = {
	// configuration
	config: {
		'alignableElements':  ['p', 'div', 'td' ,'th'],
		'bodyId': 'bodyContent',
		'coreStyles_bold': {element: 'b', overrides: 'strong'},
		'coreStyles_italic': {element: 'i', overrides: 'em'},
		'customConfig': '',
		'dialog_backgroundCoverColor': '#000',
		'disableObjectResizing': true,
		'entities': false,
		'format_tags': 'p;h2;h3;h4;h5;pre',
		'height': 400,
		'language': window.wgUserLanguage,
		'removePlugins': 'about,elementspath,filebrowser,flash,forms,horizontalrule,maximize,newpage,pagebreak,save,wsc,link,justify',
		'resize_enabled': false,
		'startupFocus': true,
		'toolbar': 'Wikia',
		'toolbarCanCollapse': false,
		'theme': 'wikia',
		'skin': 'wikia'
	},

	// refernece to current CK instance
	instance: false,

	// editor instance ID
	instanceId: window.RTEInstanceId,

	// is instance filly loaded?
	loaded: false,

	// time of CK load
	loadTime: false,

	// list of our RTE custom plugins (stored in js/plugins) to be loaded on editor init
	plugins: [
		'comment',
		'entities',
		'image',
		'justify',
		'link',
		'mw-toolbar',
		'paste',
		'placeholder',
		'signature',
		'template',
		'tools',
		'video',
		'widescreen'
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
			RTE.log(data);

			if (typeof callback == 'function') {
				callback(data);
			}
		}, 'json');
	},

	// track events
	// TODO: use GA event tracking
	// @see http://code.google.com/intl/pl-PL/apis/analytics/docs/tracking/eventTrackerGuide.html
	track: function(action, label, value) {
		// get method attributes
		var args = ['ckeditor']; for (i=0; i < arguments.length; i++) args.push(arguments[i]);

		// pageTracker._trackEvent.apply(window, args);
		//RTE.log('track - ' + args.join('/'));

		WET.byStr(args.join('/'));
	},

	// start editor in mode provided
	init : function(mode) {
		// cache buster used by CK when loading CSS/JS
		CKEDITOR.timestamp = window.wgStyleVersion;

		// set startup mode
		RTE.config.startupMode = mode;

		// register and load RTE plugins
		RTE.loadPlugins();

		// add and position wrapper for extra RTE stuff
		var editorPosition = $('#editform').offset();

		$('<div id="RTEStuff" />').appendTo('body').css({
			'left': parseInt(editorPosition.left) + 'px',
			'top': parseInt(editorPosition.top) + 'px'
		});

		// base colors: use color / background-color from .color1 CSS class
		var colorPicker = $('<div>').addClass('color1').appendTo('#RTEStuff').hide();
		RTE.config.baseBackgroundColor = colorPicker.css('backgroundColor');
		RTE.config.baseColor = colorPicker.css('color');

		// make textarea wysiwygable
		CKEDITOR.replace('wpTextbox1', RTE.config);

		// set editor instance
		RTE.instance = CKEDITOR.instances.wpTextbox1;

		// load CSS files
		RTE.loadCss();

		// register event handlers
		CKEDITOR.on('instanceReady', RTE.onEditorReady);

		RTE.instance.on('beforeModeUnload', function() {
			RTE.onBeforeModeSwitch(RTE.instance.mode);
		});

		RTE.instance.on('wysiwygModeReady', RTE.onWysiwygModeReady);

		// event fired when Widescreen button in pressed
		RTE.instance.on('widescreen', RTE.onWidescreen);

		// CK is loading...
		RTE.loading(true);
	},

	// load extra CSS files
	loadCss: function() {
		var css = [
			window.stylepath + '/monobook/main.css',
			CKEDITOR.basePath + '../css/RTEcontent.css'
		];
		for (var n=0; n<css.length; n++) {
			RTE.instance.addCss('@import url(' + css[n] + '?' + CKEDITOR.timestamp + ');');
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
		// remove HTML indentation
		RTE.instance.dataProcessor.writer.indentationChars = '';
		RTE.instance.dataProcessor.writer.lineBreakChars = '';

		// allow <img> (used for placeholders) to be placed inside <pre>
		CKEDITOR.dtd.pre.img = 1;

		// allow <center> to be placed inside <p>
		CKEDITOR.dtd.p.center = 1;

		// set class for body indicating current editor mode
		$('body').addClass('rte_' + RTE.instance.mode);

		// on submit set value of RTEMode hidden field
		$('#editform').bind('submit', function() {
			$('#RTEMode').attr('value', RTE.instance.mode);
		});

		// ok, we're done!
		RTE.loaded = true;
		RTE.loading(false);

		// calculate load time
		RTE.loadTime = ( (new Date()).getTime() - window.wgRTEStart.getTime() ) / 1000;

		RTE.log('CKeditor (' +
			(window.RTEDevMode ? 'in development mode' : CKEDITOR.revision + ' build ' + CKEDITOR.version) +
			') is ready in "' + RTE.instance.mode + '" mode (loaded in ' + RTE.loadTime + ' s)');

		// load time in ms (to be reported to GA)
		var trackingLoadTime = parseInt(RTE.loadTime * 1000);

		// tracking
		switch (RTE.instance.mode) {
			case 'source':
				RTE.track('init', 'sourceMode', trackingLoadTime);

				// add edgecase name (if any)
				if (window.RTEEdgeCase) {
					RTE.track('init', 'edgecase',  window.RTEEdgeCase);
				}

				break;

			case 'wysiwyg':
				RTE.track('init', 'wysiwygMode', trackingLoadTime);
				break;
		}

		// editor resizing
		if (typeof window.EditEnhancements == 'function') {
			EditEnhancements();
		}
	},

	// extra setup of <body> wrapping editing area in wysiwyg mode
	onWysiwygModeReady: function() {
		var body = RTE.getEditor();

		// set ID, so CSS rules from MW can be applied
		body.attr('id', RTE.instance.config.bodyId);

		// setup drag&drop
		RTE.setupDragNDrop();
	},

	// reposition of #RTEStuff div when Widescreen button is pressed
	onWidescreen: function() {
		var editorPosition = $('#editform').offset();

		$('#RTEStuff').appendTo('body').css({
			'left': parseInt(editorPosition.left) + 'px',
			'top': parseInt(editorPosition.top) + 'px'
		});
	},

	// setup drag&drop support
	setupDragNDrop: function() {
		// fire "dropped" custom event when element is drag&drop-ed
		// mark dragged element with _rte_dragged attribute
		RTE.getEditor().unbind('.dnd').bind('dragdrop.dnd', function(ev) {
			setTimeout(function() {
				RTE.log(ev);

				// get dragged element
				var draggedElement = RTE.getEditor().find('[_rte_dragged]');

				RTE.log('drag&drop: dropped');
				RTE.log(draggedElement);

				// get coordinates from "dragdrop" event and send it with "dropped" event
				// @see http://www.quirksmode.org/js/events_properties.html#position
				var extra = {
					pageX: (ev.pageX ? ev.pageX : ev.clientX),
					pageY: (ev.pageY ? ev.pageY : ev.clientY)
				};

				// remove "marking" attribute and trigger event handler
				RTE.log('drag&drop: triggering "dropped" event...');
				draggedElement.removeAttr('_rte_dragged').trigger('dropped', extra);
			}, 500);
		}).bind('mousedown.dnd', function(ev) {
			var target = $(ev.target);

			// "mark" dragged element
			target.attr('_rte_dragged', true);

		}).bind('mouseup.dnd', function(ev) {
			var target = $(ev.target);

			// remove "marking" attribute
			target.removeAttr('_rte_dragged');
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
	onBeforeModeSwitch: function(mode) {
		RTE.log('switching from "' + mode +'" mode');

		// get HTML / wikitext
		var content = RTE.instance.getData();
		//RTE.log(content);

		// show loading indicator
		RTE.loading(true);

		switch (mode) {
			case 'wysiwyg':
				RTE.ajax('html2wiki', {html: content, title: window.wgPageName}, function(data) {
					RTE.instance.setData(data.wikitext);
					RTE.loading(false);

					$('body').addClass('rte_source').removeClass('rte_wysiwyg');
				});
				break;

			case 'source':
				RTE.ajax('wiki2html', {wikitext: content, title: window.wgPageName}, function(data) {
					if (data.edgecases) {
						RTE.log('edgecase found!');

						RTE.tools.alert('&nbsp;', data.edgecaseInfo);

						// stay in source mode
						RTE.loading(false);
						RTE.instance.forceSetMode('source', content);
						return;
					}

					RTE.instance.setData(data.html);

					setTimeout(function() {
						RTE.loading(false);

						$('body').addClass('rte_wysiwyg').removeClass('rte_source');
					}, 150);
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
	['Bold','Italic','Underline','Strike', 'Format'],
	['Outdent','Indent'],
	['JustifyLeft','JustifyCenter','JustifyRight'],
	['BulletedList','NumberedList'],
	['Link','Unlink'],
	['Image','Video'],
	['Table'],
	['Signature'],
	['Template'],
	['Undo','Redo'],
	['Widescreen'],
	['Source']
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

// load CK files from _source subdirectory
CKEDITOR.getUrl = function( resource ) {

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

// forced mode switch (don't send AJAX request, use provided html/wikitext)
CKEDITOR.editor.prototype.forceSetMode = function(mode, data) {
	// following code is based on "editingblock" plugin from CK core
	var modeEditor = this._.modes && this._.modes[ mode || this.mode ];
	var holderElement = this.getThemeSpace('contents');

	modeEditor.load(holderElement, data);
}

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
	json = json.replace(/\x7f-FF/g, '"');

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
	var json = $.toJSON(data).replace(/"/g, "\x7f-FF");

	this.attr('_rte_data', json);

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
