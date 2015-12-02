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
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.WikiaBlockMediaNode = function VeDmWikiaBlockMediaNode() {
	// Parent constructor
	ve.dm.WikiaBlockMediaNode.super.apply( this, arguments );
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
