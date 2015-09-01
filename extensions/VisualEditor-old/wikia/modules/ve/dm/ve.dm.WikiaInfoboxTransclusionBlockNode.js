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

ve.dm.WikiaInfoboxTransclusionBlockNode.static.matchTagNames = [ 'aside' ];

ve.dm.WikiaInfoboxTransclusionBlockNode.static.matchRdfaTypes = [ 'mw:Transclusion' ];

ve.dm.WikiaInfoboxTransclusionBlockNode.static.matchFunction = function ( domElement ) {
	var portableInfoboxClass = 'portable-infobox';

	return ve.indexOf( portableInfoboxClass,
			( domElement.getAttribute( 'class' ) || '' ).split( ' ' )
		) !== -1;
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaInfoboxTransclusionBlockNode );
