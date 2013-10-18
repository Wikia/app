/*!
 * VisualEditor LeafNode mixin.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Leaf node mixin.
 *
 * @class
 * @abstract
 * @constructor
 */
ve.LeafNode = function VeLeafNode() {
	//
};

/* Methods */

/**
 * Check if the node has children.
 *
 * @method
 * @returns {boolean} Whether the node has children
 */
ve.LeafNode.prototype.hasChildren = function () {
	return false;
};
