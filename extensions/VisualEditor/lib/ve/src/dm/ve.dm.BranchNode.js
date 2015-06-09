/*!
 * VisualEditor DataModel BranchNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel branch node.
 *
 * Branch nodes can have branch or leaf nodes as children.
 *
 * @abstract
 * @extends ve.dm.Node
 * @mixins ve.BranchNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children] Child nodes to attach
 */
ve.dm.BranchNode = function VeDmBranchNode( element, children ) {
	// Mixin constructor
	ve.BranchNode.call( this );

	// Parent constructor
	ve.dm.Node.call( this, element );

	// Properties
	this.slugPositions = {};

	// TODO: children is only ever used in tests
	if ( Array.isArray( children ) && children.length ) {
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

OO.inheritClass( ve.dm.BranchNode, ve.dm.Node );

OO.mixinClass( ve.dm.BranchNode, ve.BranchNode );

/* Methods */

/**
 * Add a child node to the end of the list.
 *
 * @method
 * @param {ve.dm.BranchNode} childModel Item to add
 * @returns {number} New number of children
 * @fires splice
 * @fires update
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
 * @fires splice
 * @fires update
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
 * @fires splice
 * @fires update
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
 * @fires splice
 * @fires update
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
 * @fires splice
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
	this.setupSlugs();
	this.emit.apply( this, ['splice'].concat( args ) );

	return removals;
};

/**
 * Setup a sparse array of booleans indicating where to place slugs
 */
ve.dm.BranchNode.prototype.setupSlugs = function () {
	var i, len,
		isBlock = this.canHaveChildrenNotContent();

	this.slugPositions = {};

	if ( isBlock && !this.isAllowedChildNodeType( 'paragraph' ) ) {
		// Don't put slugs in nodes which can't contain paragraphs
		return;
	}

	// If this content branch no longer has any non-internal items, insert a slug to keep the node
	// from becoming invisible/unfocusable. In Firefox, backspace after Ctrl+A leaves the document
	// completely empty, so this ensures DocumentNode gets a slug.
	if (
		this.getLength() === 0 ||
		( this.children.length === 1 && this.children[0].isInternal() )
	) {
		this.slugPositions[0] = true;
	} else {
		// Iterate over all children of this branch and add slugs in appropriate places
		for ( i = 0, len = this.children.length; i < len; i++ ) {
			// Don't put slugs after internal nodes
			if ( this.children[i].isInternal() ) {
				continue;
			}
			// First sluggable child (left side)
			if ( i === 0 && this.children[i].canHaveSlugBefore() ) {
				this.slugPositions[i] = true;
			}
			if ( this.children[i].canHaveSlugAfter() ) {
				if (
					// Last sluggable child (right side)
					i === this.children.length - 1 ||
					// Sluggable child followed by another sluggable child (in between)
					( this.children[i + 1] && this.children[i + 1].canHaveSlugBefore() )
				) {
					this.slugPositions[i + 1] = true;
				}
			}
		}
	}
};

/**
 * Check in the branch node has a slug at a particular offset
 *
 * @method
 * @param {number} offset Offset to check for a slug at
 * @returns {boolean} There is a slug at the offset
 */
ve.dm.BranchNode.prototype.hasSlugAtOffset = function ( offset ) {
	var i,
		startOffset = this.getOffset() + ( this.isWrapped() ? 1 : 0 );

	if ( offset === startOffset ) {
		return !!this.slugPositions[0];
	}
	for ( i = 0; i < this.children.length; i++ ) {
		startOffset += this.children[i].getOuterLength();
		if ( offset === startOffset ) {
			return !!this.slugPositions[i + 1];
		}
	}
	return false;
};
