/*!
 * VisualEditor DataModel MWNumberedExternalLinkNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki numbered external link node.
 *
 * @class
 * @extends ve.dm.LeafNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.MWNumberedExternalLinkNode = function VeDmMWNumberedExternalLinkNode() {
	// Parent constructor
	ve.dm.LeafNode.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWNumberedExternalLinkNode, ve.dm.LeafNode );

/* Static Properties */

ve.dm.MWNumberedExternalLinkNode.static.name = 'link/mwNumberedExternal';

ve.dm.MWNumberedExternalLinkNode.static.isContent = true;

ve.dm.MWNumberedExternalLinkNode.static.matchTagNames = [ 'a' ];

ve.dm.MWNumberedExternalLinkNode.static.matchRdfaTypes = [ 'mw:ExtLink' ];

ve.dm.MWNumberedExternalLinkNode.static.matchFunction = function ( element ) {
	// Must be empty
	return element.childNodes.length === 0;
};

ve.dm.MWNumberedExternalLinkNode.static.toDataElement = function ( domElements ) {
	return {
		'type': this.name,
		'attributes': {
			'href': domElements[0].getAttribute( 'href' )
		}
	};
};

ve.dm.MWNumberedExternalLinkNode.static.toDomElements = function ( dataElement, doc ) {
	var domElement = doc.createElement( 'a' );
	domElement.setAttribute( 'href', dataElement.attributes.href );
	domElement.setAttribute( 'rel', 'mw:ExtLink' );
	return [ domElement ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWNumberedExternalLinkNode );
