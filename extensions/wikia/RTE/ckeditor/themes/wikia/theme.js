CKEDITOR.editor.prototype.getThemeSpace = function( spaceName )
{
	var elementId = WikiaEditor.instanceId,
		getSpaceId = function(editorName, editorId) {
			switch (spaceName) {
				case 'tabs':
					return elementId + 'Tabs';
				case 'toolbar':
					return elementId + 'Toolbar';
				case 'contents':
					return editorId + "_contents";
				case 'rail':
					return elementId + 'Rail';
			}
		};

	var editorId = CKEDITOR.instances.wpTextbox1.id;
	var space = this._[ editorId ] ||
		( this._[ editorId ] = CKEDITOR.document.getById( getSpaceId(this.name, editorId) ) );
	return space;
};

CKEDITOR.editor.prototype.resize = function( width, height, isContentHeight, resizeInner )
{
	var numberRegex = /^\d+$/;
	if ( numberRegex.test( width ) ) {
		width += 'px';
	}

	var contents = CKEDITOR.document.getById( 'cke_contents_' + this.name );
	var outer = resizeInner ? contents.getAscendant( 'table' ).getParent()
		: contents.getAscendant( 'table' ).getParent().getParent().getParent();

	// Resize the width first.
	// WEBKIT BUG: Webkit requires that we put the editor off from display when we
	// resize it. If we don't, the browser crashes!
	CKEDITOR.env.webkit && outer.setStyle( 'display', 'none' );
	outer.setStyle( 'width', width );
	if ( CKEDITOR.env.webkit )
	{
		outer.$.offsetWidth;
		outer.setStyle( 'display', '' );
	}

	// Get the height delta between the outer table and the content area.
	// If we're setting the content area's height, then we don't need the delta.
	var delta = isContentHeight ? 0 : ( outer.$.offsetHeight || 0 ) - ( contents.$.clientHeight || 0 );
	contents.setStyle( 'height', Math.max( height - delta, 0 ) + 'px' );

	// Emit a resize event.
	this.fire( 'resize' );
};

CKEDITOR.editor.prototype.getResizable = function()
{
	return this.container.getChild( [ 0, 0 ] );
};
