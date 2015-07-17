/*!
 * VisualEditor DataModel WikiaInlineVideo class.
 */

/**
 * DataModel Wikia video node.
 *
 * @class
 * @extends ve.dm.MWInlineImageNode
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.WikiaInlineVideoNode = function VeDmWikiaInlineVideoNode() {
	ve.dm.WikiaInlineVideoNode.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.WikiaInlineVideoNode, ve.dm.MWInlineImageNode );

/* Static Properties */

ve.dm.WikiaInlineVideoNode.static.rdfaToType = {
	'mw:Video': 'inline',
	'mw:Video/Frameless': 'frameless'
};

ve.dm.WikiaInlineVideoNode.static.name = 'wikiaInlineVideo';

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaInlineVideoNode );
