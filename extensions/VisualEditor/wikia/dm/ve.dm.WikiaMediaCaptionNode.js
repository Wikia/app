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
ve.dm.VeDmWikiaMediaCaptionNode = function VeDmWikiaMediaCaptionNode( length, element ) {
	ve.dm.MWImageCaptionNode.call( this, length, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.VeDmWikiaMediaCaptionNode, ve.dm.MWImageCaptionNode );

/* Static Properties */

ve.dm.VeDmWikiaMediaCaptionNode.static.name = 'wikiaMediaCaption';

ve.dm.VeDmWikiaMediaCaptionNode.static.parentNodeTypes = [
	'wikiaBlockImage',
	'wikiaBlockVideo'
];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.VeDmWikiaMediaCaptionNode );
