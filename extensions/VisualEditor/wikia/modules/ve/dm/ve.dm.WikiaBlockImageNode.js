/*!
 * VisualEditor DataModel WikiaBlockImageNode class.
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel Wikia image node.
 *
 * @class
 * @extends ve.dm.WikiaBlockMediaNode
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.WikiaBlockImageNode = function VeDmWikiaBlockImageNode() {
	// Parent constructor
	ve.dm.WikiaBlockImageNode.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.WikiaBlockImageNode, ve.dm.WikiaBlockMediaNode );

/* Static Properties */

ve.dm.WikiaBlockImageNode.static.name = 'wikiaBlockImage';

ve.dm.WikiaBlockImageNode.static.childNodeTypes = [ 'wikiaImageCaption' ];

ve.dm.WikiaBlockImageNode.static.captionNodeType = 'wikiaImageCaption';

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaBlockImageNode );
