(function( window ) {

var WikiaEditor = window.WikiaEditor;

WikiaEditor.modules.Categories = $.createClass( WikiaEditor.modules.base,{
	modes: true,
	headerClass: 'categories',
	headerTextId: 'categories-title',
	template: '<div></div>',
	data: {},

	init: function() {
		WikiaEditor.modules.Categories.superclass.init.call( this );
		this.enabled = this.editor.config.categorySelectEnabled;
	},

	afterAttach: function() {
		var $categories = $( '#categories' ),
			$categorySelect = $( '#CategorySelect' );

		// Move #CategorySelect to the right rail
		this.el.replaceWith( $categorySelect );

		// Update the reference
		this.el = $categorySelect;

		// Initialize categorySelect
		$categorySelect.categorySelect({
			categories: JSON.parse( $categories.val() )

		// Update categories metadata when categories change
		}).on( 'update', function( event, data ) {
			$categories.val( JSON.stringify( data.categories ) );
		});
	}
});

WikiaEditor.modules.ToolbarCategories = $.createClass( WikiaEditor.modules.ButtonsList, {
	modes: true,
	headerClass: 'categories_button',

	init: function() {
		WikiaEditor.modules.ToolbarCategories.superclass.init.call( this );
		this.enabled = this.editor.config.categorySelectEnabled;
	},

	items: [ 'CategoriesButton' ]
});

WikiaEditor.modules.RailCategories = WikiaEditor.modules.Categories;

window.wgEditorExtraButtons[ 'CategoriesButton' ] = {
	type: 'modulebutton',
	label: $.msg( 'wikia-editor-modules-categories-title' ),
	title: $.msg( 'wikia-editor-modules-categories-title' ),
	module: 'RailCategories',
	autorenderpanel: true
};

})( window );
