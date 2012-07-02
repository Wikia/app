/**
 * Pixel position.
 * 
 * This can also support an optional bottom field, to represent a vertical line, such as a cursor.
 * 
 * @class
 * @constructor
 * @param left {Integer} Horizontal position
 * @param top {Integer} Vertical top position
 * @param bottom {Integer} Vertical bottom position of bottom (optional, default: top)
 * @property left {Integer} Horizontal position
 * @property top {Integer} Vertical top position
 * @property bottom {Integer} Vertical bottom position of bottom
 */
ve.Position = function( left, top, bottom ) {
	this.left = left || 0;
	this.top = top || 0;
	this.bottom = bottom || this.top;
};

/* Static Methods */

/**
 * Creates position object from the page position of an element.
 * 
 * @static
 * @method
 * @param $element {jQuery} Element to get offset from
 * @returns {ve.Position} Position with element data applied
 */
ve.Position.newFromElementPagePosition = function( $element ) {
	var offset = $element.offset();
	return new ve.Position( offset.left, offset.top );
};

/**
 * Creates position object from the layer position of an element.
 * 
 * @static
 * @method
 * @param $element {jQuery} Element to get position from
 * @returns {ve.Position} Position with element data applied
 */
ve.Position.newFromElementLayerPosition = function( $element ) {
	var position = $element.position();
	return new ve.Position( position.left, position.top );
};

/**
 * Creates position object from the screen position data in an Event object.
 * 
 * @static
 * @method
 * @param event {Event} Event to get position data from
 * @returns {ve.Position} Position with event data applied
 */
ve.Position.newFromEventScreenPosition = function( event ) {
	return new ve.Position( event.screenX, event.screenY );
};

/**
 * Creates position object from the page position data in an Event object.
 * 
 * @static
 * @method
 * @param event {Event} Event to get position data from
 * @returns {ve.Position} Position with event data applied
 */
ve.Position.newFromEventPagePosition = function( event ) {
	return new ve.Position( event.pageX, event.pageY );
};

/**
 * Creates position object from the layer position data in an Event object.
 * 
 * @static
 * @method
 * @param event {Event} Event to get position data from
 * @returns {ve.Position} Position with event data applied
 */
ve.Position.newFromEventLayerPosition = function( event ) {
	return new ve.Position( event.layerX, event.layerY );
};

/* Methods */

/**
 * Adds the values of a given position to this one.
 * 
 * @method
 * @param position {ve.Position} Position to add values from
 */
ve.Position.prototype.add = function( position ) {
	this.top += position.top;
	this.bottom += position.bottom;
	this.left += position.left;
};

/**
 * Subtracts the values of a given position to this one.
 * 
 * @method
 * @param position {ve.Position} Position to subtract values from
 */
ve.Position.prototype.subtract = function( position ) {
	this.top -= position.top;
	this.bottom -= position.bottom;
	this.left -= position.left;
};

/**
 * Checks if this position is the same as another one.
 * 
 * @method
 * @param position {ve.Position} Position to compare with
 * @returns {Boolean} If positions have the same left and top values
 */
ve.Position.prototype.at = function( position ) {
	return this.left === position.left && this.top === position.top;
};

/**
 * Checks if this position perpendicular with another one, sharing either a top or left value.
 * 
 * @method
 * @param position {ve.Position} Position to compare with
 * @returns {Boolean} If positions share a top or a left value
 */
ve.Position.prototype.perpendicularWith = function( position ) {
	return this.left === position.left || this.top === position.top;
};

/**
 * Checks if this position is level with another one, having the same top value.
 * 
 * @method
 * @param position {ve.Position} Position to compare with
 * @returns {Boolean} If positions have the same top value
 */
ve.Position.prototype.levelWith = function( position ) {
	return this.top === position.top;
};

/**
 * Checks if this position is plumb with another one, having the same left value.
 * 
 * @method
 * @param position {ve.Position} Position to compare with
 * @returns {Boolean} If positions have the same left value
 */
ve.Position.prototype.plumbWith = function( position ) {
	return this.left === position.left;
};

/**
 * Checks if this position is nearby another one.
 * 
 * Distance is measured radially.
 * 
 * @method
 * @param position {ve.Position} Position to compare with
 * @param radius {Integer} Pixel distance from this position to consider "near-by"
 * @returns {Boolean} If positions are near-by each other
 */
ve.Position.prototype.near = function( position, radius ) {
	return Math.sqrt(
		Math.pow( this.left - position.left, 2 ),
		Math.pow( this.top - position.top )
	) <= radius;
};

/**
 * Checks if this position is above another one.
 * 
 * This method utilizes the bottom property.
 * 
 * @method
 * @param position {ve.Position} Position to compare with
 * @returns {Boolean} If this position is above the other
 */
ve.Position.prototype.above = function( position ) {
	return this.bottom < position.top;
};

/**
 * Checks if this position is below another one.
 * 
 * This method utilizes the bottom property.
 * 
 * @method
 * @param position {ve.Position} Position to compare with
 * @returns {Boolean} If this position is below the other
 */
ve.Position.prototype.below = function( position ) {
	return this.top > position.bottom;
};

/**
 * Checks if this position is to the left of another one.
 * 
 * @method
 * @param position {ve.Position} Position to compare with
 * @returns {Boolean} If this position is the left the other
 */
ve.Position.prototype.leftOf = function( left ) {
	return this.left < left;
};

/**
 * Checks if this position is to the right of another one.
 * 
 * @method
 * @param position {ve.Position} Position to compare with
 * @returns {Boolean} If this position is the right the other
 */
ve.Position.prototype.rightOf = function( left ) {
	return this.left > left;
};
