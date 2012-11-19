/**
 * VisualEditor LeafNode mixin.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Mixin for leaf nodes.
 *
 * @mixin
 * @abstract
 * @constructor
 */
ve.LeafNode = function VeLeafNode() {
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
ve.LeafNode.prototype.hasChildren = function () {
	return false;
};
