/*
Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/**
 * @file Justify commands.
 */

(function()
{
	var alignRemoveRegex = /(-moz-|-webkit-|start|auto)/i;

	function getState( editor, path )
	{
		var firstBlock = path.block || path.blockLimit;

		// Wikia: disable alignment feature on elements not included in this list
		var alignableElements = (typeof editor.config.alignableElements == 'object') ? editor.config.alignableElements : [];

		if ( !firstBlock || (alignableElements.length > 1 &&  alignableElements.indexOf(firstBlock.getName()) == -1) ) {
			return CKEDITOR.TRISTATE_DISABLED;
		}

		var currentAlign = firstBlock.getComputedStyle( 'text-align' ).replace( alignRemoveRegex, '' );

		if ( ( !currentAlign && this.isDefaultAlign ) || currentAlign == this.value ) {
			return CKEDITOR.TRISTATE_ON;
		}

		return CKEDITOR.TRISTATE_OFF;
	}

	function onSelectionChange( evt )
	{
		var command = evt.editor.getCommand( this.name );
		command.state = getState.call( this, evt.editor, evt.data.path );
		command.fire( 'state' );
	}

	function justifyCommand( editor, name, value )
	{
		this.name = name;
		this.value = value;

		var contentDir = editor.config.contentsLangDirection;
		this.isDefaultAlign = ( value == 'left' && contentDir == 'ltr' ) ||
			( value == 'right' && contentDir == 'rtl' );


	}

	justifyCommand.prototype = {
		exec : function( editor )
		{
			var selection = editor.getSelection();
			if ( !selection )
				return;

			var bookmarks = selection.createBookmarks(),
				ranges = selection.getRanges();

			var iterator,
				block;
			for ( var i = ranges.length - 1 ; i >= 0 ; i-- )
			{
				iterator = ranges[ i ].createIterator();
				while ( ( block = iterator.getNextParagraph() ) )
				{
					block.removeAttribute( 'align' );

					// Wikia: remove internal RTE attributes
					block.removeAttribute('data-rte-style');
					block.removeAttribute('data-rte-attribs');

					// Wikia: render paragraphs as wikitext
					if (block.getName() == 'p') {
						block.removeAttribute('data-rte-washtml');
					}

					// Wikia: <th> is centre aligned by default
					if (block.getName() == 'th') {
						this.isDefaultAlign = (this.value == 'center');
					}

					if ( this.state == CKEDITOR.TRISTATE_OFF && !this.isDefaultAlign ) {
						block.setStyle( 'text-align', this.value );
					}
					else {
						block.removeStyle( 'text-align' );
					}
				}

			}

			editor.focus();
			editor.forceNextSelectionCheck();
			selection.selectBookmarks( bookmarks );
		}
	};

	CKEDITOR.plugins.add( 'rte-justify',
	{
		init : function( editor )
		{
			var left = new justifyCommand( editor, 'justifyleft', 'left' ),
				center = new justifyCommand( editor, 'justifycenter', 'center' ),
				right = new justifyCommand( editor, 'justifyright', 'right' ),
				justify = new justifyCommand( editor, 'justifyblock', 'justify' );

			editor.addCommand( 'justifyleft', left );
			editor.addCommand( 'justifycenter', center );
			editor.addCommand( 'justifyright', right );
			editor.addCommand( 'justifyblock', justify );

			editor.ui.addButton( 'JustifyLeft',
				{
					label : editor.lang.justify.left,
					command : 'justifyleft'
				} );
			editor.ui.addButton( 'JustifyCenter',
				{
					label : editor.lang.justify.center,
					command : 'justifycenter'
				} );
			editor.ui.addButton( 'JustifyRight',
				{
					label : editor.lang.justify.right,
					command : 'justifyright'
				} );
			editor.ui.addButton( 'JustifyBlock',
				{
					label : editor.lang.justify.block,
					command : 'justifyblock'
				} );

			editor.on( 'selectionChange', CKEDITOR.tools.bind( onSelectionChange, left ) );
			editor.on( 'selectionChange', CKEDITOR.tools.bind( onSelectionChange, right ) );
			editor.on( 'selectionChange', CKEDITOR.tools.bind( onSelectionChange, center ) );
			editor.on( 'selectionChange', CKEDITOR.tools.bind( onSelectionChange, justify ) );
		},

		requires : [ 'domiterator' ]
	});
})();

CKEDITOR.tools.extend( CKEDITOR.config,
	{
		// list of elements which can be aligned
		alignableElements : null
	} );
