(function(window){

	var WE = window.WikiaEditor;

	WE.modules.Categories = $.createClass(WE.modules.base,{

		modes: true,

		headerClass: 'categories',
		headerTextId: 'categories-title',

		template: '<div></div>',
		data: {},

		init: function() {
			WE.modules.Categories.superclass.init.call(this);
			if (this.editor.config.categoriesDisabled) {
				this.enabled = false;
			}
		},

		afterRender: function() {
			var introText = this.editor.config.categoriesIntroText;
			if (introText) {
				this.el.append($('<div>').addClass('info-text').text(introText));
			}
		},

		afterAttach: function() {
			this.el.append($('#csMainContainer').show());
			if (typeof window.initCatSelectForEdit === 'function') {
				window.csType = "module";
				window.initCatSelectForEdit();
			}

			// tracking
			this.el.bind({
				categorySelectAdd: this.proxy(function(ev) {this.track('add');}),
				categorySelectMove: this.proxy(function(ev) {this.track('move');}),
				categorySelectEdit: this.proxy(function(ev) {this.track('edit');}),
				categorySelectDelete: this.proxy(function(ev) {this.track('delete');})
			});

			// save
			this.editor.on('state', this.proxy(this.onStateChange));

			// switch module mode when switching editing mode (BugId:10257)
			this.editor.on('mode', this.proxy(this.onModeChanged));

			// start in source mode when using MW editor (useeditor=mediawiki)
			if (this.editor.mode === 'source') {
				this.onModeChanged();
			}
		},

		onStateChange: function(editor, state) {
			if (state == editor.states.SAVING) {
				// track number of categories when saving the article
				var categoriesCount = this.el.find('.CSitem').length;
				this.track('saveNumber', categoriesCount);
			}
		},

		track: function(ev, param) {
			this.editor.track(this.editor.getTrackerMode(), 'categories', ev, param);
		},

		onModeChanged: function() {
			if (this.editor.mode /* editor mode */ != window.csMode /* CategorySelect module mode */) {
				window.toggleCodeView();
			}
		}
	});

	WE.modules.ToolbarCategories = $.createClass(WE.modules.ButtonsList,{

		modes: true,

		headerClass: 'categories_button',

		init: function() {
			WE.modules.ToolbarCategories.superclass.init.call(this);
			if (this.editor.config.categoriesDisabled) {
				this.enabled = false;
			}
		},

		items: [
			'CategoriesButton'
		]

	});

	WE.modules.RailCategories = WE.modules.Categories;

	window.wgEditorExtraButtons['CategoriesButton'] = {
		type: 'modulebutton',
		label: $.msg('wikia-editor-modules-categories-title'),
		title: $.msg('wikia-editor-modules-categories-title'),
		module: 'RailCategories',
		autorenderpanel: true
	};

})(this);