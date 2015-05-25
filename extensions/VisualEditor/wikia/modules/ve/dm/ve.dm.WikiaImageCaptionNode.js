/*!
 * VisualEditor DataModel WikiaMediaCaptionNode class.
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
ve.dm.WikiaImageCaptionNode = function VeDmWikiaImageCaptionNode() {
	ve.dm.WikiaImageCaptionNode.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.WikiaImageCaptionNode, ve.dm.WikiaMediaCaptionNode );

/* Static Properties */

ve.dm.WikiaImageCaptionNode.static.name = 'wikiaImageCaption';

ve.dm.WikiaImageCaptionNode.static.parentNodeTypes = [ 'wikiaBlockImage' ];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaImageCaptionNode );
