/*!
 * VisualEditor DataModel WikiaMapNode class.
 */

/**
 * DataModel Wikia map node.
 *
 * @class
 * @extends ve.dm.MWBlockExtensionNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.WikiaMapNode = function VeDmWikiaMapNode() {
	// Parent constructor
	ve.dm.WikiaMapNode.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.WikiaMapNode, ve.dm.MWBlockExtensionNode );

/* Static members */

ve.dm.WikiaMapNode.static.name = 'wikiaMap';

ve.dm.WikiaMapNode.static.extensionName = 'imap';

ve.dm.WikiaMapNode.static.tagName = 'figure';

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaMapNode );
