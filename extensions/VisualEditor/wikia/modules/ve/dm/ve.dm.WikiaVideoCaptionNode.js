/*!
 * VisualEditor DataModel WikiaVideoCaptionNode class.
 */

/**
 * DataModel Wikia media caption node.
 *
 * @class
 * @extends ve.dm.WikiaMediaCaptionNode
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.WikiaVideoCaptionNode = function VeDmWikiaVideoCaptionNode() {
	ve.dm.WikiaVideoCaptionNode.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.WikiaVideoCaptionNode, ve.dm.WikiaMediaCaptionNode );

/* Static Properties */

ve.dm.WikiaVideoCaptionNode.static.name = 'wikiaVideoCaption';

ve.dm.WikiaVideoCaptionNode.static.parentNodeTypes = [ 'wikiaBlockVideo' ];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaVideoCaptionNode );
