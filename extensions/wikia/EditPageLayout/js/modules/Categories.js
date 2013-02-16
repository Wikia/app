(function( window ) {

var WikiaEditor = window.WikiaEditor,
	wgCategorySelect = window.wgCategorySelect;

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
			$categorySelect = $( '#CategorySelect' ),
			namespace = 'categorySelect',
			editor = WikiaEditor.getInstance();

		// Move to the right rail
		this.el.replaceWith( $categorySelect );

		// Update the reference
		this.el = $categorySelect;

		// Initialize categorySelect
		$categorySelect.categorySelect({
			animations: {
				remove: {
					options: {
						duration: 400
					},
					properties: {
						opacity: 0,
						height: 0
					}
				}
			},
			popover: {
				placement: 'top'
			}

		}).on( 'add.' + namespace, function( event, cs, data ) {
			cs.elements.list.append( data.element );

		}).on( 'update.' + namespace, function( event ) {
			$categories.val( JSON.stringify(
				$categorySelect.data( 'categorySelect' ).getData() )
			);
			editor.fire('markDirty');
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