(function($, window) {

	/**
	 * Wikia Editor loader for Edit pages
	 */
	var EditPageEditorLoader = $.createClass(Object,{

		element: false,

		constructor: function() {
			this.element = $('#EditPage');
			this.body = $('#wpTextbox1');
		},

		getToolbarsConfig: function() {
			var data = {
				main: !!window.wgEditPageIsWidePage,
				rte: typeof window.RTE != 'undefined',
				wide: false,
				readOnly: window.wgEditPageIsReadOnly
			};

			data.wide = data.rte && data.main;

			window.WikiaEditor.fire('wikiaeditorspacesbeforelayout',this.element,data);

			var layout = {
				tabs: [],
				toolbar: [],
				rail: []
			};

			// mode switcher
			if (data.rte){ layout.tabs.push('ModeSwitch'); }
			// source toolbar
			layout.toolbar.push('ToolbarMediawiki');
			// format toolbars
			if (data.rte) {
				layout.toolbar.push('Format');
				layout.toolbar.push('FormatExpanded');
			}

			// standard modules
			if (data.wide) {
				layout.toolbar.push('ToolbarWidescreen');
			} else if(data.readOnly) {
				layout.rail.push('RailLicense');
			} else {
				layout.rail.push('RailInsert','RailCategories','RailTemplates','RailLicense');
			}

			window.WikiaEditor.fire('wikiaeditorspaceslayout',this.element,layout,data);

			// Wraps all modules in right rail for the plugin "railminimumheight"
			if (layout.rail.length > 0) {
				layout.rail = [{cls:'rail-auto-height',items:layout.rail}];
			}

			return layout;
		},

		isFormatExpanded: function() {
			var ns = window.wgNamespaceNumber;
			return (ns % 2 == 1 /* talk pages */) || (ns == 110/* NS_FORUM */);
		},

		getData: function() {
			var rte = typeof window.RTE != 'undefined', mode = 'source';
			if (rte) {
				mode = window.RTEInitMode || 'wysiwyg';
			}

			var plugins = [ 'wikiacore', rte ? 'ckeditorsuite' : 'mweditorsuite' ];
			var config = {
				// the element being replaced, where text will be entered
				body: this.body,
				// the DOM element wrapper where the editor should be rendered
				element: this.element,
				// toolbars definition
				toolbars: this.getToolbarsConfig(),
				// toolbar types overrides
				toolbarTypes: {
					rail: 'railcontainer'
				},
				// spaces overrides
				spaces: {
					tabs: $('#EditPageTabs')
				},
				// shall format toolbar be expanded by default?
				formatExpanded: this.isFormatExpanded(),
				// default UI elements which should to be registered in the editor
				uiElements: window.wgEditorExtraButtons || {},
				// list of popular templates used by Templates module
				popularTemplates: window.wgEditPagePopularTemplates || [],
				// editor auto resize mode
				autoResizeMode: (window.wgEditPageIsConflict || window.wgEditPageFormType == 'diff') ? 'editpage' : 'editarea',
				// Whether or not CategorySelect is enabled
				categorySelectEnabled: ( typeof window.wgCategorySelect != 'undefined' ),
				// initial state of wide screen mode in source mode
				wideInSourceInitial: window.wgEditPageWideSourceMode,
				// is wide screen mode in source mode disabled?
				wideInSourceDisabled: window.wgEditPageHasEditPermissionError,
				// is the current page wide in view? (adds 300px in preview popup)
				isWidePage: !!window.wgEditPageIsWidePage,
				// extra page width (e.g. in oasis hd) (adds extra width in preview popup)
				extraPageWidth: (window.sassParams && window.sassParams.hd) ? 200 : 0,
				// initial editor mode
				mode: mode
			};

			return { plugins: plugins, config: config };
		},

		initWikiaEditor: function() {
			var data = this.getData();

			window.WikiaEditor.create(data.plugins, data.config);

			$(window).bind('UserLoginSubmit', window.WikiaEditor.storeContent);
		},

		initAceEditor: function() {
			require(['wikia.editpage.ace.editor'], function(aceEditor){
				aceEditor.init();
			});

		},

		launchInfoboxPreview: function() {
			var editorValue = window.wgEnableCodePageEditor ? ace.edit('editarea').getValue() : WikiaEditor.getInstance().getContent(),
				wikiaDomain = mw.config.get('wgServer').split('://')[1],
				templateName = (new mw.Title(mw.config.get('wgPageName'))).getMain(),
				infoboxPreviewURL = mw.config.get('wgInfoboxPreviewURL');

			$('<form>')
				.attr({'action': infoboxPreviewURL, 'method': 'POST', 'target': '_blank'})
				.append(
					$('<textarea>').val(editorValue).attr({'name': 'editor_value'}),
					$('<input>').val(wikiaDomain).attr({'name': 'wikia_domain'}),
					$('<input>').val(templateName).attr({'name': 'template_name'})
				)
				.submit();

			window.Wikia.Tracker.track({
				action: window.Wikia.Tracker.ACTIONS.CLICK,
				category: 'editor-mw',
				label: 'infobox-preview-button',
				trackingMethod: 'analytics'
			});
		},

		init: function() {
			$('.InfoboxPreview').click(this.launchInfoboxPreview);

			if (window.wgEnableCodePageEditor) {
				this.initAceEditor();
			} else {
				this.initWikiaEditor();
			}
		}
	});

	$(function(){
		if (!window.WikiaAutostartDisabled) {
			var editor = new EditPageEditorLoader();
			editor.init();
		}
	});

})(jQuery, this);
