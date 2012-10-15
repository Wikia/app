/**
 * Creates an es.DocumentViewLeafNode object.
 * 
 * @class
 * @abstract
 * @constructor
 * @extends {es.DocumentLeafNode}
 * @extends {es.DocumentViewNode}
 * @param model {es.ModelNode} Model to observe
 * @param {jQuery} [$element] Element to use as a container
 */
es.DocumentViewLeafNode = function( model, $element ) {
	// Inheritance
	es.DocumentLeafNode.call( this );
	es.DocumentViewNode.call( this, model, $element );

	this.$.data('view', this);
	this.$.addClass('ce-leafNode');

	// Properties
	this.$content = this.$;
	this.contentView = new es.ContentView( this.$content, model );

	// Events
	this.contentView.on( 'update', this.emitUpdate );
};

/* Methods */

/**
 * Render content.
 * 
 * @method
 */
es.DocumentViewLeafNode.prototype.renderContent = function() {
	this.contentView.render();
};

/**
 * Draw selection around a given range.
 * 
 * @method
 * @param {es.Range} range Range of content to draw selection around
 */
es.DocumentViewLeafNode.prototype.drawSelection = function( range ) {
	this.contentView.drawSelection( range );
};

/**
 * Clear selection.
 * 
 * @method
 */
es.DocumentViewLeafNode.prototype.clearSelection = function() {
	this.contentView.clearSelection();
};

/**
 * Gets the nearest offset of a rendered position.
 * 
 * @method
 * @param {es.Position} position Position to get offset for
 * @returns {Integer} Offset of position
 */
es.DocumentViewLeafNode.prototype.getOffsetFromRenderedPosition = function( position ) {
	return this.contentView.getOffsetFromRenderedPosition( position );
};

/**
 * Gets rendered position of offset within content.
 * 
 * @method
 * @param {Integer} offset Offset to get position for
 * @returns {es.Position} Position of offset
 */
es.DocumentViewLeafNode.prototype.getRenderedPositionFromOffset = function( offset, leftBias ) {
	var	position = this.contentView.getRenderedPositionFromOffset( offset, leftBias ),
		contentPosition = this.$content.offset();
	position.top += contentPosition.top;
	position.left += contentPosition.left;
	position.bottom += contentPosition.top;
	return position;
};

es.DocumentViewLeafNode.prototype.getRenderedLineRangeFromOffset = function( offset ) {
	return this.contentView.getRenderedLineRangeFromOffset( offset );
};

/* Inheritance */

es.extendClass( es.DocumentViewLeafNode, es.DocumentLeafNode );
es.extendClass( es.DocumentViewLeafNode, es.DocumentViewNode );
