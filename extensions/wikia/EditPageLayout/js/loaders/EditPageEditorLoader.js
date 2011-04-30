(function(window,$){
	var EditPageEditorLoader = $.createClass(Object,{

		element: false,

		constructor: function() {
			this.element = $('#EditPage');
		},

		getToolbarsConfig: function() {
			var WE = window.WikiaEditor;

			var data = {
				main: typeof window.wgEditPageIsWidePage != 'undefined' && window.wgEditPageIsWidePage,
				rte: typeof window.RTE != 'undefined',
				wide: false
			};
			data.wide = data.rte && data.main;

			WE.fire('wikiaeditorspacesbeforelayout',this.element,data);

			var layout = {
				tabs: [],
				toolbar: [],
				rail: []
			};

			// mode switcher
			if (data.rte) layout.tabs.push('ModeSwitch');
			// source toolbar
			layout.toolbar.push('ToolbarMediawiki');
			// format toolbars
			if (data.rte) {
				layout.toolbar.push('Format');
				layout.toolbar.push('FormatExpanded');
			}

			// page controls
			//layout.rail.push('PageControls');
			// standard modules
			if (data.wide) {
				layout.toolbar.push('ToolbarWidescreen');
				//layout.toolbar.push('RailInsert','ToolbarCategories','ToolbarTemplates','ToolbarLicense');
			} else {
				layout.rail.push('RailInsert','RailCategories','RailTemplates','RailLicense');
			}

			WE.fire('wikiaeditorspaceslayout',this.element,layout,data);

			return layout;
		},

		getData: function() {
			var rte = typeof window.RTE != 'undefined', mode = 'source';
			if (rte) {
				mode = window.RTEInitMode || 'wysiwyg';
			}

			var plugins = [ 'wikiacore', rte ? 'ckeditorsuite' : 'mweditorsuite' ];
			var config = {
				element: this.element,
				toolbars: this.getToolbarsConfig(),
				toolbarTypes: {
					rail: 'railcontainer'
				},
				spaces: {
					tabs: $('#EditPageTabs')
				},
				formatExpanded: window.wgNamespaceNumber >= 0 && window.wgNamespaceNumber % 2 == 1, // talk namespaces
				uiElements: window.wgEditorExtraButtons || {},
				popularTemplates: window.wgEditPagePopularTemplates || [],
				autoResizeMode: (window.wgEditPageIsConflict || window.wgEditPageFormType == 'diff') ? 'editpage' : 'editarea',
				categoriesDisabled: (typeof window.initCatSelectForEdit != 'function'),
				wideInSourceDisabled: window.wgEditPageHasEditPermissionError,
				mode: mode
			};
			
			return { plugins: plugins, config: config };
		},
		
		init: function() {
			var data = this.getData();
			var e = window.editorInstance = window.WikiaEditor.create(data.plugins,data.config);
			this.element.data('wikiaeditor',e);
		}
	});
	

	$(function(){
		if (!window.WikiaAutostartDisabled) {
			editor = new EditPageEditorLoader();
			editor.init();
		}
	});

})(this,jQuery);