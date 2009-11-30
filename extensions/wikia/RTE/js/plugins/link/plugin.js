CKEDITOR.plugins.add('rte-link',
{
	init: function(editor) {
		// add commands
		editor.addCommand('link', new CKEDITOR.dialogCommand('link'));
		editor.addCommand('unlink', new CKEDITOR.unlinkCommand());

		// add toolbar buttons
		editor.ui.addButton('Link',{
			label : editor.lang.link.toolbar,
			command : 'link'
		});
		editor.ui.addButton('Unlink', {
			label : editor.lang.unlink,
			command : 'unlink'
		});

		// register dialog for link command
		CKEDITOR.dialog.add('link', this.path + 'dialogs/link.js');

		// register the menu items.
		if (editor.addMenuItems) {
			editor.addMenuItems({
				link: {
					label : editor.lang.link.menu,
					command : 'link',
					group : 'link',
					order : 1
				},

				unlink:	{
					label : editor.lang.unlink,
					command : 'unlink',
					group : 'link',
					order : 5
				}
			});
		}
	},

	afterInit: function(editor) {
	}
});

CKEDITOR.unlinkCommand = function(){};
CKEDITOR.unlinkCommand.prototype =
{
	/** @ignore */
	exec : function( editor )
	{
		/*
		 * execCommand( 'unlink', ... ) in Firefox leaves behind <span> tags at where
		 * the <a> was, so again we have to remove the link ourselves. (See #430)
		 *
		 * TODO: Use the style system when it's complete. Let's use execCommand()
		 * as a stopgap solution for now.
		 */
		var selection = editor.getSelection(),
			bookmarks = selection.createBookmarks(),
			ranges = selection.getRanges(),
			rangeRoot,
			element;

		for ( var i = 0 ; i < ranges.length ; i++ )
		{
			rangeRoot = ranges[i].getCommonAncestor( true );
			element = rangeRoot.getAscendant( 'a', true );
			if ( !element )
				continue;
			ranges[i].selectNodeContents( element );
		}

		selection.selectRanges( ranges );
		editor.document.$.execCommand( 'unlink', false, null );
		selection.selectBookmarks( bookmarks );
	}
};

CKEDITOR.tools.extend( CKEDITOR.config,
{
	linkShowAdvancedTab : true,
	linkShowTargetTab : true
} );
