/*!
 * VisualEditor ContentEditable MWResizableNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki resizable node.
 *
 * @class
 * @abstract
 * @extends {ve.ce.ResizableNode}
 *
 * @constructor
 * @param {jQuery} [$resizable=this.$] Resizable DOM element
 */
ve.ce.MWResizableNode = function VeCeMWResizableNode( $resizable ) {
	ve.ce.ResizableNode.call( this, $resizable );
};

/* Inheritance */

ve.inheritClass( ve.ce.MWResizableNode, ve.ce.ResizableNode );

/**
 * Generate an object of attributes changes from the new width and height.
 *
 * If either property changes, clear the defaultSize flag.
 *
 * @param {number} width New image width
 * @param {number} height New image height
 * @returns {Object} Attribute changes
 */
ve.ce.MWResizableNode.prototype.getAttributeChanges = function ( width, height ) {
	var attrChanges = ve.ce.ResizableNode.prototype.getAttributeChanges.call( this, width, height );
	if ( !ve.isEmptyObject( attrChanges ) ) {
		attrChanges.defaultSize = false;
	}
	return attrChanges;
};
