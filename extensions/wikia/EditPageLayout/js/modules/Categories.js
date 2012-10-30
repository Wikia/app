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
		this.el.replaceWith( $( "#CategorySelect" ).categorySelect() );

		//this.editor.on( 'mode', this.proxy( this.onModeChanged ) );

		// start in source mode when using MW editor (useeditor=mediawiki)
		/*if ( this.editor.mode === 'source' ) {
			this.onModeChanged();
		}*/
	},

	onModeChanged: function() {
		if (this.editor.mode != window.csMode /* CategorySelect module mode */) {
			window.toggleCodeView();
		}
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