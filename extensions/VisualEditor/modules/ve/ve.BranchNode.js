/**
 * VisualEditor BranchNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Mixin for branch nodes.
 * Extenders are expected to inherit from ve.Node.
 *
 * Branch nodes are immutable, which is why there are no methods for adding or removing children.
 * DataModel classes will add this functionality, and other subclasses will implement behavior that
 * mimcs changes made to data model nodes.
 *
 * @mixin
 * @abstract
 * @constructor
 * @param {ve.Node[]} children Array of children to add
 */
ve.BranchNode = function VeBranchNode( children ) {
	this.children = ve.isArray( children ) ? children : [];
};

/* Methods */

/**
 * Checks if this node has child nodes.
 *
 * @method
 * @see {ve.Node.prototype.hasChildren}
 * @returns {Boolean} Whether this node has children
 */
ve.BranchNode.prototype.hasChildren = function () {
	return true;
};

/**
 * Gets a list of child nodes.
 *
 * @method
 * @returns {ve.Node[]} List of child nodes
 */
ve.BranchNode.prototype.getChildren = function () {
	return this.children;
};

/**
 * Gets the index of a given child node.
 *
 * @method
 * @param {ve.dm.Node} node Child node to find index of
 * @returns {Number} Index of child node or -1 if node was not found
 */
ve.BranchNode.prototype.indexOf = function ( node ) {
	return ve.indexOf( node, this.children );
};

/**
 * Sets the root node this node is a descendent of.
 *
 * @method
 * @see {ve.Node.prototype.setRoot}
 * @param {ve.Node} root Node to use as root
 */
ve.BranchNode.prototype.setRoot = function ( root ) {
	if ( root === this.root ) {
		// Nothing to do, don't recurse into all descendants
		return;
	}
	this.root = root;
	for ( var i = 0; i < this.children.length; i++ ) {
		this.children[i].setRoot( root );
	}
};

/**
 * Sets the document this node is a part of.
 *
 * @method
 * @see {ve.Node.prototype.setDocument}
 * @param {ve.Document} root Node to use as root
 */
ve.BranchNode.prototype.setDocument = function ( doc ) {
	if ( doc === this.doc ) {
		// Nothing to do, don't recurse into all descendants
		return;
	}
	this.doc = doc;
	for ( var i = 0; i < this.children.length; i++ ) {
		this.children[i].setDocument( doc );
	}
};

/**
 * Gets the node at a given offset.
 *
 * This method is pretty expensive. If you need to get different slices of the same content, get
 * the content first, then slice it up locally.
 *
 * TODO: Rewrite this method to not use recursion, because the function call overhead is expensive
 *
 * @method
 * @param {Number} offset Offset get node for
 * @param {Boolean} [shallow] Do not iterate into child nodes of child nodes
 * @returns {ve.Node|null} Node at offset, or null if non was found
 */
ve.BranchNode.prototype.getNodeFromOffset = function ( offset, shallow ) {
	if ( offset === 0 ) {
		return this;
	}
	// TODO a lot of logic is duplicated in selectNodes(), abstract that into a traverser or something
	if ( this.children.length ) {
		var i, length, nodeLength, childNode,
			nodeOffset = 0;
		for ( i = 0, length = this.children.length; i < length; i++ ) {
			childNode = this.children[i];
			if ( offset === nodeOffset ) {
				// The requested offset is right before childNode,
				// so it's not inside any of this's children, but inside this
				return this;
			}
			nodeLength = childNode.getOuterLength();
			if ( offset >= nodeOffset && offset < nodeOffset + nodeLength ) {
				if ( !shallow && childNode.hasChildren() && childNode.getChildren().length ) {
					return this.getNodeFromOffset.call( childNode, offset - nodeOffset - 1 );
				} else {
					return childNode;
				}
			}
			nodeOffset += nodeLength;
		}
		if ( offset === nodeOffset ) {
			// The requested offset is right before this.children[i],
			// so it's not inside any of this's children, but inside this
			return this;
		}
	}
	return null;
};

/**
 * Gets the content offset of a node.
 *
 * TODO: Rewrite this method to not use recursion, because the function call overhead is expensive
 *
 * @method
 * @param {ve.Node} node Node to get offset of
 * @returns {Number} Offset of node or -1 of node was not found
 */
ve.BranchNode.prototype.getOffsetFromNode = function ( node ) {
	if ( node === this ) {
		return 0;
	}
	if ( this.children.length ) {
		var i, length, childOffset, childNode,
			offset = 0;
		for ( i = 0, length = this.children.length; i < length; i++ ) {
			childNode = this.children[i];
			if ( childNode === node ) {
				return offset;
			}
			if ( childNode.canHaveChildren() && childNode.getChildren().length ) {
				childOffset = this.getOffsetFromNode.call( childNode, node );
				if ( childOffset !== -1 ) {
					return offset + 1 + childOffset;
				}
			}
			offset += childNode.getOuterLength();
		}
	}
	return -1;
};
