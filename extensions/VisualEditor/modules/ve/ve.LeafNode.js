/**
 * Creates an ve.LeafNode object.
 * 
 * @class
 * @abstract
 * @constructor
 */
ve.LeafNode = function() {
	//
};

/* Methods */

/**
 * Checks if this node has child nodes.
 * 
 * @method
 * @see {ve.Node.prototype.hasChildren}
 * @returns {Boolean} Whether this node has children
 */
ve.LeafNode.prototype.hasChildren = function() {
	return false;
};
