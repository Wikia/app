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
			$categorySelect = $( '#CategorySelect' ),
			namespace = 'categorySelect';

		// Move #CategorySelect to the right rail
		this.el.replaceWith( $categorySelect );

		// Update the reference
		this.el = $categorySelect;

		// Initialize categorySelect
		$categorySelect.categorySelect({
			data: JSON.parse( $categories.val() )

		}).on( 'add.' + namespace, function( event, state, data ) {
			data.element.prepend( Mustache.render( data.template.content, data.template.data ) );

		}).on( 'remove.' + namespace, function( event, state, data ) {
			data.element.animate({
				opacity: 0,
				height: 0

			}, 400, function() {
				data.element.remove();
			});

		}).on( 'update.' + namespace, function( event, state ) {
			$categories.val( JSON.stringify( state.categories ) );
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
