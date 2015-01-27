/*!
 * VisualEditor DataModel WikiaMediaCaptionNode class.
 */

/**
 * DataModel Wikia media caption node.
 *
 * @class
 * @abstract
 * @extends ve.dm.MWImageCaptionNode
 * @constructor
 * @param {number} [length] Length of content data in document
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.WikiaMediaCaptionNode = function VeDmWikiaMediaCaptionNode( length, element ) {
	ve.dm.WikiaMediaCaptionNode.super.call( this, length, element );
};

/* Inheritance */

OO.inheritClass( ve.dm.WikiaMediaCaptionNode, ve.dm.MWImageCaptionNode );

/* Static Properties */

ve.dm.WikiaMediaCaptionNode.static.name = 'wikiaMediaCaption';

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaMediaCaptionNode );
