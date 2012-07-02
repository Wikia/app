/**
 * Useful calls for other plugins (extensions, browser apps, etc.)
 */
( function( $ ) { $.inlineEditor.api = {
	getFullText: function() {
		return $.inlineEditor.getTextById( 'inline-editor-root' );
	},
	
	previewFullText: function( text ) {
		$.inlineEditor.cancel();
		$.inlineEditor.previewTextById( text, 'inline-editor-root' );
	},
	
	openFullEditor: function() {
		$.inlineEditor.show( 'inline-editor-root' );
	},
	
	getFullEditorTextarea: function() {
		$.inlineEditor.api.openFullEditor();
		return $( '#inline-editor-root textarea' );
	}
}; } ) ( jQuery );
