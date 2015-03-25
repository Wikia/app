/*!
 * VisualEditor DataModel WikiaMediaCaptionNode class.
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
ve.dm.WikiaImageCaptionNode = function VeDmWikiaImageCaptionNode( length, element ) {
	ve.dm.WikiaImageCaptionNode.super.call( this, length, element );
};

/* Inheritance */

OO.inheritClass( ve.dm.WikiaImageCaptionNode, ve.dm.WikiaMediaCaptionNode );

/* Static Properties */

ve.dm.WikiaImageCaptionNode.static.name = 'wikiaImageCaption';

ve.dm.WikiaImageCaptionNode.static.parentNodeTypes = [ 'wikiaBlockImage' ];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaImageCaptionNode );
