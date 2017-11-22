CKEDITOR.plugins.add('rte-link',
{
	init: function(editor) {
		// add commands
		editor.addCommand('link', new CKEDITOR.dialogCommand('link'));
		editor.addCommand('unlink', new CKEDITOR.unlinkCommand());

		// add toolbar buttons
		editor.ui.addButton('Link',{
			label : window.mw.msg('rte-ck-link-add'),//editor.lang.link.add,
			command : 'link'
		});
		editor.ui.addButton('Unlink', {
			label : window.mw.msg('rte-ck-unlink'),//editor.lang.unlink,
			command : 'unlink'
		});

		// register dialog for link command
		CKEDITOR.dialog.add('link', this.path + 'dialogs/link.js');

		// register the menu items.
		if (editor.addMenuItems) {
			editor.addMenuItems({
				link: {
					label : window.mw.msg('rte-ck-link-menu'),//editor.lang.link.menu,
					command : 'link',
					group : 'link',
					order : 1
				},

				unlink:	{
					label : window.mw.msg('rte-ck-unlink'),//editor.lang.unlink,
					command : 'unlink',
					group : 'link',
					order : 5
				}
			});
		}

		// Link icon should show as selected when cursor is on a link
		editor.on('selectionChange', function(ev) {
			var elements = ev.data.path.elements,
				len = elements.length,
				state = false;

			// find <a> in a tree of elements in the current selection
			for (var i = 0, element ; i < len ; i++) {
				if (elements[i].is('a')) {
					state = true;
					break;
				}
			 }

			editor.getCommand('link').setState(state ? CKEDITOR.TRISTATE_ON : CKEDITOR.TRISTATE_OFF);
		});

		// If the "contextmenu" plugin is loaded, register the listeners.
		// added to solve RT #47452
		if ( editor.contextMenu )
		{
			editor.contextMenu.addListener( function( element, selection )
				{
					if ( !element )
						return null;

					var isAnchor = ( element.is( 'img' ) && element.getAttribute( '_cke_real_element_type' ) == 'anchor' );

					if ( !isAnchor )
					{
						if ( !( element = CKEDITOR.plugins.link.getSelectedLink( editor ) ) )
							return null;

						isAnchor = ( element.getAttribute( 'name' ) && !element.getAttribute( 'href' ) );
					}

					return isAnchor ?
							{ anchor : CKEDITOR.TRISTATE_OFF } :
							{ link : CKEDITOR.TRISTATE_OFF, unlink : CKEDITOR.TRISTATE_OFF };
				});
		}

		// handle pasted links from local wiki
		editor.on('afterPaste', function() {
			// get links without meta data attribute
			var pastedLinks = RTE.getEditor().find('a').not('a[data-rte-meta]');

			if (!pastedLinks.exists()) {
				return;
			}

			RTE.log('pasted links');
			RTE.log(pastedLinks);

			pastedLinks.each(function() {
				var link = $(this);
				var href = link.attr('href');

				// link from external site - skip
				if (RTE.tools.isExternalLink(href)) {
					return;
				}

				// get page name from title / href attribute
				var pageName = "";

				if (href.indexOf('&action=edit') == -1) {
					// blue link
					pageName = link.attr('title');
				}
				else {
					// red link
					var matches = href.match('title=(.*)&action=edit');

					if (matches) {
						pageName = matches[1];

						// decode page name
						pageName = decodeURIComponent(pageName);
						pageName = pageName.replace(/_/g, ' ');
					}
				}

				if (pageName == "") {
					return;
				}

				RTE.log('local link pointing to "' + pageName + '" found');

				// set link's meta-data
				var data = {
					type: 'internal',
					link: pageName,
					text: link.text(),
					noforce: true,
					wasblank: false
				};

				link.setData(data);
			});
		});
	}
});

CKEDITOR.plugins.link =
{
	/**
	 *  Get the surrounding link element of current selection.
	 * @param editor
	 * @example CKEDITOR.plugins.link.getSelectedLink( editor );
	 * @since 3.2.1
	 * The following selection will all return the link element.
	 *	 <pre>
	 *  <a href="#">li^nk</a>
	 *  <a href="#">[link]</a>
	 *  text[<a href="#">link]</a>
	 *  <a href="#">li[nk</a>]
	 *  [<b><a href="#">li]nk</a></b>]
	 *  [<a href="#"><b>li]nk</b></a>
	 * </pre>
	 */
	getSelectedLink : function( editor )
	{
		var range;
		try { range  = editor.getSelection().getRanges()[ 0 ]; }
		catch( e ) { return null; }

		range.shrink( CKEDITOR.SHRINK_TEXT );
		var root = range.getCommonAncestor();
		return root.getAscendant( 'a', true );
	}
};

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
			this.removeLink(editor,element,ranges[i]);
		}

		selection.selectBookmarks( bookmarks );
	},

	removeLink : function( editor, element )
	{
		element.remove( true );
	}
};

CKEDITOR.tools.extend( CKEDITOR.config,
{
	linkShowAdvancedTab : true,
	linkShowTargetTab : true
} );
