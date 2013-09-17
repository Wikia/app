/*!
 * VisualEditor DataModel WikiaMediaCaptionNode class.
 */

/**
 * DataModel Wikia media caption node.
 *
 * @class
 * @extends ve.dm.MWImageCaptionNode
 * @constructor
 * @param {number} [length] Length of content data in document
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.WikiaMediaCaptionNode = function VeDmWikiaMediaCaptionNode( length, element ) {
	ve.dm.MWImageCaptionNode.call( this, length, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.WikiaMediaCaptionNode, ve.dm.MWImageCaptionNode );

/* Static Properties */

ve.dm.WikiaMediaCaptionNode.static.name = 'wikiaMediaCaption';

ve.dm.WikiaMediaCaptionNode.static.parentNodeTypes = [
	'wikiaBlockImage',
	'wikiaBlockVideo'
];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaMediaCaptionNode );
