/*!
 * VisualEditor DataModel WikiaInlineVideo class.
 */

/**
 * DataModel Wikia video node.
 *
 * @class
 * @extends ve.dm.MWInlineImageNode
 * @constructor
 * @param {number} [length] Length of content data in document
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.WikiaInlineVideoNode = function VeDmWikiaInlineVideoNode( length, element ) {
	ve.dm.MWInlineImageNode.call( this, length, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.WikiaInlineVideoNode, ve.dm.MWInlineImageNode );

/* Static Properties */

ve.dm.WikiaInlineVideoNode.static.rdfaToType = {
	'mw:Video': 'inline',
	'mw:Video/Frameless': 'frameless'
};

ve.dm.WikiaInlineVideoNode.static.name = 'wikiaInlineVideo';

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaInlineVideoNode );
