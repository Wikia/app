/*!
 * VisualEditor DataModel WikiaBlockMediaNode class.
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel Wikia media node.
 *
 * @class
 * @abstract
 * @extends ve.dm.MWBlockImageNode
 * @constructor
 * @param {number} [length] Length of content data in document
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.WikiaBlockMediaNode = function VeDmWikiaBlockMediaNode( element ) {
	ve.dm.WikiaBlockMediaNode.super.call( this, element );
};

/* Inheritance */

OO.inheritClass( ve.dm.WikiaBlockMediaNode, ve.dm.MWBlockImageNode );

/* Static Properties */

ve.dm.WikiaBlockMediaNode.static.typeToRdfa = null;

ve.dm.WikiaBlockMediaNode.static.toDataElement = function ( domElements, converter ) {
	var dataElement = ve.dm.MWBlockImageNode.static.toDataElement.call(
			this, domElements, converter
		),
		mwDataJSON = domElements[0].getAttribute( 'data-mw' ),
		mwData = JSON.parse( mwDataJSON );
	dataElement[0].attributes.user = mwData.user;
	return dataElement;
};
