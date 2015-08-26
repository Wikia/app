/*!
 * VisualEditor ContentEditable WikiaInfoboxTransclusionBlockNode class.
 */

/**
 * ContentEditable Wikia infobox transclusion block node.
 *
 * @class
 * @extends ve.ce.MWTransclusionBlockNode
 *
 * @constructor
 * @param {ve.dm.WikiaInfoboxTransclusionBlockNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.WikiaInfoboxTransclusionBlockNode = function VeCeWikiaInfoboxTransclusionBlockNode( model, config ) {
	// Parent constructor
	ve.ce.WikiaInfoboxTransclusionBlockNode.super.call( this, model, config );

	this.$element.addClass( 've-ce-wikiaInfoboxTransclusionBlockNode' );
};

/* Inheritance */

OO.inheritClass( ve.ce.WikiaInfoboxTransclusionBlockNode, ve.ce.MWTransclusionBlockNode );

/* Static Properties */

ve.ce.WikiaInfoboxTransclusionBlockNode.static.name = 'wikiaInfoboxTransclusionBlock';

ve.ce.WikiaInfoboxTransclusionBlockNode.static.primaryCommandName = 'wikiaInfobox';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaInfoboxTransclusionBlockNode );
