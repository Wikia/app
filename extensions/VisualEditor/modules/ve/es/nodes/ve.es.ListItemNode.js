/**
 * Creates an ve.es.ListItemNode object.
 * 
 * @class
 * @constructor
 * @extends {ve.es.LeafNode}
 * @param {ve.dm.ListItemNode} model List item model to view
 */
ve.es.ListItemNode = function( model ) {
	// Inheritance
	ve.es.BranchNode.call( this, model );

	// Properties
	this.$icon = $( '<div class="es-listItemView-icon"></div>' ).prependTo( this.$ );
	this.currentStylesHash = null;
	
	// DOM Changes
	this.$.addClass( 'es-listItemView' );

	// Events
	var _this = this;
	this.model.on( 'update', function() {
		_this.setClasses();
	} );

	// Initialization
	this.setClasses();
};

/* Methods */

ve.es.ListItemNode.prototype.setClasses = function() {
	var styles = this.model.getElementAttribute( 'styles' ),
		stylesHash = styles.join( '|' );
	if ( this.currentStylesHash !== stylesHash ) {
		this.currentStylesHash = stylesHash;
		var classes = this.$.attr( 'class' );
		this.$
			// Remove any existing level classes
			.attr(
				'class',
				classes
					.replace( / ?es-listItemView-level[0-9]+/, '' )
					.replace( / ?es-listItemView-(bullet|number|term|definition)/, '' )
			)
			// Set the list style class from the style on top of the stack
			.addClass( 'es-listItemView-' + styles[styles.length - 1] )
			// Set the list level class from the length of the stack
			.addClass( 'es-listItemView-level' + ( styles.length - 1 ) );
	}
};

/* Registration */

ve.es.DocumentNode.splitRules.listItem = {
	'self': true,
	'children': false
};

/* Inheritance */

ve.extendClass( ve.es.ListItemNode, ve.es.BranchNode );
