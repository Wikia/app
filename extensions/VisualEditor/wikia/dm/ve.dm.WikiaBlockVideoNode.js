/*!
 * VisualEditor DataModel WikiaBlockVideoNode class.
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel Wikia video node.
 *
 * @class
 * @extends ve.dm.WikiaBlockMediaNode
 * @constructor
 * @param {number} [length] Length of content data in document
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.WikiaBlockVideoNode = function VeDmWikiaBlockVideoNode( length, element ) {
	ve.dm.MWBlockImageNode.call( this, 0, element );
	console.log('AHAHAHAHAH ve.dm.WikiaBlockVideoNode', this);
	alert(1);

};

/* Inheritance */

ve.inheritClass( ve.dm.WikiaBlockVideoNode, ve.dm.MWBlockImageNode );

/* Static Properties */

ve.dm.WikiaBlockVideoNode.static.matchRdfaTypes = [
	'mw:Video',
	'mw:Video/Thumb',
	'mw:Video/Frame',
	'mw:Video/Frameless'
];

ve.dm.WikiaBlockVideoNode.static.name = 'wikiaBlockVideo';

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaBlockVideoNode );
