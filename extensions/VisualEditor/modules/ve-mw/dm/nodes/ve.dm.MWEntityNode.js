/*!
 * VisualEditor DataModel MWEntityNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki entitiy node.
 *
 * @class
 * @extends ve.dm.LeafNode
 * @constructor
 *
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.MWEntityNode = function VeDmMWEntityNode() {
	// Parent constructor
	ve.dm.LeafNode.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWEntityNode, ve.dm.LeafNode );

/* Static Properties */

ve.dm.MWEntityNode.static.name = 'mwEntity';

ve.dm.MWEntityNode.static.isContent = true;

ve.dm.MWEntityNode.static.matchTagNames = [ 'span' ];

ve.dm.MWEntityNode.static.matchRdfaTypes = [ 'mw:Entity' ];

ve.dm.MWEntityNode.static.toDataElement = function ( domElements ) {
	return { type: this.name, attributes: { character: domElements[0].textContent } };
};

ve.dm.MWEntityNode.static.toDomElements = function ( dataElement, doc ) {
	var domElement = doc.createElement( 'span' ),
		textNode = doc.createTextNode( dataElement.attributes.character );
	domElement.setAttribute( 'typeof', 'mw:Entity' );
	domElement.appendChild( textNode );
	return [ domElement ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWEntityNode );
