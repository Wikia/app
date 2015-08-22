/*!
 * VisualEditor DataModel WikiaVideoCaptionNode class.
 */

/**
 * DataModel Wikia media caption node.
 *
 * @class
 * @extends ve.dm.WikiaMediaCaptionNode
 * @constructor
 * @param {number} [length] Length of content data in document
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.WikiaVideoCaptionNode = function VeDmWikiaVideoCaptionNode( length, element ) {
	ve.dm.WikiaVideoCaptionNode.super.call( this, length, element );
};

/* Inheritance */

OO.inheritClass( ve.dm.WikiaVideoCaptionNode, ve.dm.WikiaMediaCaptionNode );

/* Static Properties */

ve.dm.WikiaVideoCaptionNode.static.name = 'wikiaVideoCaption';

ve.dm.WikiaVideoCaptionNode.static.parentNodeTypes = [ 'wikiaBlockVideo' ];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaVideoCaptionNode );
