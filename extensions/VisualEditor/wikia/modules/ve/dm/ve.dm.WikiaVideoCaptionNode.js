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
ve.dm.WikiaVideoCaptionNode = function VeDmWikiaVideoCaptionNode( length, element ) {
	ve.dm.WikiaMediaCaptionNode.call( this, length, element );
};

/* Inheritance */

OO.inheritClass( ve.dm.WikiaVideoCaptionNode, ve.dm.WikiaMediaCaptionNode );

/* Static Properties */

ve.dm.WikiaMediaCaptionNode.static.name = 'wikiaVideoCaption';

ve.dm.WikiaMediaCaptionNode.static.parentNodeTypes = [
	'wikiaBlockVideo'
];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaMediaCaptionNode );
