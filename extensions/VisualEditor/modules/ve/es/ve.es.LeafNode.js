/**
 * Creates an ve.es.LeafNode object.
 * 
 * @class
 * @abstract
 * @constructor
 * @extends {ve.LeafNode}
 * @extends {ve.es.Node}
 * @param model {ve.ModelNode} Model to observe
 * @param {jQuery} [$element] Element to use as a container
 */
ve.es.LeafNode = function( model, $element ) {
	// Inheritance
	ve.LeafNode.call( this );
	ve.es.Node.call( this, model, $element );

	// Properties
	this.$content = $( '<div class="es-contentView"></div>' ).appendTo( this.$ );
	this.contentView = new ve.es.Content( this.$content, model );

	// Events
	this.contentView.on( 'update', this.emitUpdate );
};

/* Methods */

/**
 * Render content.
 * 
 * @method
 */
ve.es.LeafNode.prototype.renderContent = function() {
	this.contentView.render();
};

/**
 * Draw selection around a given range.
 * 
 * @method
 * @param {ve.Range} range Range of content to draw selection around
 */
ve.es.LeafNode.prototype.drawSelection = function( range ) {
	this.contentView.drawSelection( range );
};

/**
 * Clear selection.
 * 
 * @method
 */
ve.es.LeafNode.prototype.clearSelection = function() {
	this.contentView.clearSelection();
};

/**
 * Gets the nearest offset of a rendered position.
 * 
 * @method
 * @param {ve.Position} position Position to get offset for
 * @returns {Integer} Offset of position
 */
ve.es.LeafNode.prototype.getOffsetFromRenderedPosition = function( position ) {
	return this.contentView.getOffsetFromRenderedPosition( position );
};

/**
 * Gets rendered position of offset within content.
 * 
 * @method
 * @param {Integer} offset Offset to get position for
 * @returns {ve.Position} Position of offset
 */
ve.es.LeafNode.prototype.getRenderedPositionFromOffset = function( offset, leftBias ) {
	var	position = this.contentView.getRenderedPositionFromOffset( offset, leftBias ),
		contentPosition = this.$content.offset();
	position.top += contentPosition.top;
	position.left += contentPosition.left;
	position.bottom += contentPosition.top;
	return position;
};

ve.es.LeafNode.prototype.getRenderedLineRangeFromOffset = function( offset ) {
	return this.contentView.getRenderedLineRangeFromOffset( offset );
};

/* Inheritance */

ve.extendClass( ve.es.LeafNode, ve.LeafNode );
ve.extendClass( ve.es.LeafNode, ve.es.Node );
