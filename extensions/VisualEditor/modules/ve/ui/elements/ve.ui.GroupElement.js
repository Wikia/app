/*!
 * VisualEditor UserInterface GroupElement class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Group element.
 *
 * @class
 * @abstract
 *
 * @constructor
 * @param {jQuery} $group Group element
 */
ve.ui.GroupElement = function VeUiGroupElement( $group ) {
	// Properties
	this.$group = $group;
	this.items = [];
	this.$items = this.$$( [] );
};

/* Methods */

/**
 * Get items.
 *
 * @method
 * @returns {ve.Element[]} Items
 */
ve.ui.GroupElement.prototype.getItems = function () {
	return this.items.slice( 0 );
};

/**
 * Add items.
 *
 * @method
 * @param {ve.Element[]} items Item
 * @param {number} [index] Index to insert items after
 * @chainable
 */
ve.ui.GroupElement.prototype.addItems = function ( items, index ) {
	var i, len, item, currentIndex,
		$items = $( [] );

	for ( i = 0, len = items.length; i < len; i++ ) {
		item = items[i];

		// Check if item exists then remove it first, effectively "moving" it
		currentIndex = this.items.indexOf( item );
		if ( currentIndex >= 0 ) {
			this.removeItems( [ item ] );
			// Adjust index to compensate for removal
			if ( currentIndex < index ) {
				index--;
			}
		}
		// Add the item
		$items = $items.add( item.$ );
	}

	if ( index === undefined || index < 0 || index >= this.items.length ) {
		this.$group.append( $items );
		this.items.push.apply( this.items, items );
	} else if ( index === 0 ) {
		this.$group.prepend( $items );
		this.items.unshift.apply( this.items, items );
	} else {
		this.$items.eq( index ).before( $items );
		this.items.splice.apply( this.items, [ index, 0 ].concat( items ) );
	}

	this.$items = this.$items.add( $items );

	return this;
};

/**
 * Remove items.
 *
 * Items will be detached, not removed, so they can be used later.
 *
 * @method
 * @param {ve.Element[]} items Items to remove
 * @chainable
 */
ve.ui.GroupElement.prototype.removeItems = function ( items ) {
	var i, len, item, index;
	// Remove specific items
	for ( i = 0, len = items.length; i < len; i++ ) {
		item = items[i];
		index = this.items.indexOf( item );
		if ( index !== -1 ) {
			this.items.splice( index, 1 );
			item.$.detach();
			this.$items = this.$items.not( item.$ );
		}
	}

	return this;
};

/**
 * Clear all items.
 *
 * Items will be detached, not removed, so they can be used later.
 *
 * @method
 * @chainable
 */
ve.ui.GroupElement.prototype.clearItems = function () {
	this.items = [];
	this.$items.detach();
	this.$items = $( [] );

	return this;
};
