/**
 * Creates an ve.FormatDropdownTool object.
 * 
 * @class
 * @constructor
 * @extends {ve.ui.DropdownTool}
 * @param {ve.ui.Toolbar} toolbar
 * @param {String} name
 * @param {Object[]} items
 */
ve.FormatDropdownTool = function( toolbar, name, title ) {
	// Inheritance
	ve.ui.DropdownTool.call( this, toolbar, name, title, [
		{ 
			'name': 'paragraph',
			'label': 'Paragraph',
			'type' : 'paragraph'
		},
		{
			'name': 'heading-1',
			'label': 'Heading 1',
			'type' : 'heading',
			'attributes': { 'level': 1 }
		},
		{
			'name': 'heading-2',
			'label': 'Heading 2',
			'type' : 'heading',
			'attributes': { 'level': 2 }
		},
		{
			'name': 'heading-3',
			'label': 'Heading 3',
			'type' : 'heading',
			'attributes': { 'level': 3 }
		},
		{
			'name': 'heading-4',
			'label': 'Heading 4',
			'type' : 'heading',
			'attributes': { 'level': 4 }
		},
		{
			'name': 'heading-5',
			'label': 'Heading 5',
			'type' : 'heading',
			'attributes': { 'level': 5 }
		},
		{
			'name': 'heading-6',
			'label': 'Heading 6',
			'type' : 'heading',
			'attributes': { 'level': 6 }
		},
		{
			'name': 'pre',
			'label': 'Preformatted',
			'type' : 'pre'
		}
	] );
};

/* Methods */

ve.FormatDropdownTool.prototype.onSelect = function( item ) {
	var txs = this.toolbar.surfaceView.model.getDocument().prepareLeafConversion(
		this.toolbar.surfaceView.currentSelection,
		item.type,
		item.attributes
	);
	for ( var i = 0; i < txs.length; i++ ) {
		this.toolbar.surfaceView.model.transact( txs[i] );
	}
};

ve.FormatDropdownTool.prototype.updateState = function( annotations, nodes ) {
	// Get type and attributes of the first node
	var i,
		format = {
			'type': nodes[0].getElementType(),
			'attributes': nodes[0].getElement().attributes
		};
	// Look for mismatches, in which case format should be null
	for ( i = 1; i < nodes.length; i++ ) {
		if ( format.type != nodes[i].getElementType() ||
			!ve.compareObjects( format.attributes, nodes[i].element.attributes ) ) {
			format = null;
			break;
		}
	}
	
	if ( format === null ) {
		this.$label.html( '&nbsp;' );
	} else {
		var items = this.menuView.getItems();
		for ( i = 0; i < items.length; i++ ) {
			if (
				format.type === items[i].type &&
				ve.compareObjects( format.attributes, items[i].attributes )
			) {
				this.$label.text( items[i].label );
				break;
			}
		}
	}
};

/* Registration */

ve.ui.Tool.tools.format = {
	'constructor': ve.FormatDropdownTool,
	'name': 'format',
	'title': 'Change format'
};

/* Inheritance */

ve.extendClass( ve.FormatDropdownTool, ve.ui.DropdownTool );
