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
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.WikiaMediaCaptionNode = function VeDmWikiaMediaCaptionNode() {
	ve.dm.WikiaMediaCaptionNode.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.WikiaMediaCaptionNode, ve.dm.MWImageCaptionNode );

/* Static Properties */

ve.dm.WikiaMediaCaptionNode.static.name = 'wikiaMediaCaption';

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaMediaCaptionNode );
