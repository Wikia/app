/*!
 * VisualEditor DataModel Resizable node.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * A mixin class for resizable nodes. This class is mostly a base
 * interface for resizable nodes to be able to produce scalable
 * objects for further calculation.
 *
 * @class
 * @abstract
 * @constructor
 */
ve.dm.ResizableNode = function VeDmResizableNode() {
	this.scalable = null;
};

/* Inheritance */

OO.initClass( ve.dm.ResizableNode );

/**
 * Get a scalable object for this node.
 *
 * #createScalable is called if one doesn't already exist.
 *
 * @returns {ve.dm.Scalable} Scalable object
 */
ve.dm.ResizableNode.prototype.getScalable = function () {
	if ( !this.scalable ) {
		this.scalable = this.createScalable();
	}
	return this.scalable;
};

/**
 * Create a scalable object based on the current object's width and height.
 *
 * @abstract
 * @returns {ve.dm.Scalable} Scalable object
 */
ve.dm.ResizableNode.prototype.createScalable = function () {
	throw new Error( 've.dm.ResizableNode subclass must implement createScalable' );
};
