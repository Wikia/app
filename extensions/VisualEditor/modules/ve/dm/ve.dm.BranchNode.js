/*!
 * VisualEditor DataModel BranchNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel branch node.
 *
 * Branch nodes can have branch or leaf nodes as children.
 *
 * @abstract
 * @extends ve.dm.Node
 * @mixins ve.BranchNode
 * @constructor
 * @param {ve.dm.Node[]} [children] Child nodes to attach
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.BranchNode = function VeDmBranchNode( children, element ) {
	// Mixin constructor
	ve.BranchNode.call( this );

	// Parent constructor
	ve.dm.Node.call( this, 0, element );

	if ( ve.isArray( children ) && children.length ) {
		this.splice.apply( this, [0, 0].concat( children ) );
	}
};

/**
 * @event splice
 * @see #method-splice
 * @param {number} index
 * @param {number} howmany
 * @param {ve.dm.BranchNode} [childModel]
 */

/**
 * @event update
 */

/* Inheritance */

ve.inheritClass( ve.dm.BranchNode, ve.dm.Node );

ve.mixinClass( ve.dm.BranchNode, ve.BranchNode );

/* Methods */

/**
 * Add a child node to the end of the list.
 *
 * @method
 * @param {ve.dm.BranchNode} childModel Item to add
 * @returns {number} New number of children
 * @emits splice
 * @emits update
 */
ve.dm.BranchNode.prototype.push = function ( childModel ) {
	this.splice( this.children.length, 0, childModel );
	return this.children.length;
};

/**
 * Remove a child node from the end of the list.
 *
 * @method
 * @returns {ve.dm.BranchNode} Removed childModel
 * @emits splice
 * @emits update
 */
ve.dm.BranchNode.prototype.pop = function () {
	if ( this.children.length ) {
		var childModel = this.children[this.children.length - 1];
		this.splice( this.children.length - 1, 1 );
		return childModel;
	}
};

/**
 * Add a child node to the beginning of the list.
 *
 * @method
 * @param {ve.dm.BranchNode} childModel Item to add
 * @returns {number} New number of children
 * @emits splice
 * @emits update
 */
ve.dm.BranchNode.prototype.unshift = function ( childModel ) {
	this.splice( 0, 0, childModel );
	return this.children.length;
};

/**
 * Remove a child node from the beginning of the list.
 *
 * @method
 * @returns {ve.dm.BranchNode} Removed childModel
 * @emits splice
 * @emits update
 */
ve.dm.BranchNode.prototype.shift = function () {
	if ( this.children.length ) {
		var childModel = this.children[0];
		this.splice( 0, 1 );
		return childModel;
	}
};

/**
 * Add and/or remove child nodes at an offset.
 *
 * @method
 * @param {number} index Index to remove and or insert nodes at
 * @param {number} howmany Number of nodes to remove
 * @param {ve.dm.BranchNode...} [nodes] Variadic list of nodes to insert
 * @emits splice
 * @returns {ve.dm.BranchNode[]} Removed nodes
 */
ve.dm.BranchNode.prototype.splice = function () {
	var i,
		length,
		removals,
		args = Array.prototype.slice.call( arguments ),
		diff = 0;

	removals = this.children.splice.apply( this.children, args );
	for ( i = 0, length = removals.length; i < length; i++ ) {
		removals[i].detach();
		diff -= removals[i].getOuterLength();
	}

	if ( args.length >= 3 ) {
		length = args.length;
		for ( i = 2; i < length; i++ ) {
			args[i].attach( this );
			diff += args[i].getOuterLength();
		}
	}

	this.adjustLength( diff, true );
	this.emit.apply( this, ['splice'].concat( args ) );
	return removals;
};
