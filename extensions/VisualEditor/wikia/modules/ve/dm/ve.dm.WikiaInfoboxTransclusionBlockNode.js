/*!
 * VisualEditor DataModel WikiaInfoboxTransclusionBlockNode class.
 */

/**
 * DataModel Wikia infobox transclusion block node.
 *
 * @class
 * @extends ve.dm.MWTransclusionBlockNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.WikiaInfoboxTransclusionBlockNode = function WikiaInfoboxTransclusionBlockNode() {
	// Parent constructor
	ve.dm.WikiaInfoboxTransclusionBlockNode.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.WikiaInfoboxTransclusionBlockNode, ve.dm.MWTransclusionBlockNode );

/* Static members */

ve.dm.WikiaInfoboxTransclusionBlockNode.static.name = 'wikiaInfoboxTransclusionBlock';

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaInfoboxTransclusionBlockNode );
