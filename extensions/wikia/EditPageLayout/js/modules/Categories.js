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
			var introText = this.editor.config.categoriesIntroText
			if (introText) {
				this.el.append($('<div>').addClass('info-text').text(introText));
			}
		},
		
		afterAttach: function() {
			this.el.append($('#csMainContainer').show());
			if (typeof initCatSelectForEdit == 'function') {
				csType = "module";
				initCatSelectForEdit();
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
		label: 'categories',
		title: 'Categories',
		module: 'RailCategories',
		autorenderpanel: true
	};

})(this);