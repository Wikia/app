/*!
 * VisualEditor DataModel ImageNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel image node.
 *
 * @class
 * @extends ve.dm.LeafNode
 * @constructor
 * @param {number} [length] Length of content data in document
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.ImageNode = function VeDmImageNode( length, element ) {
	// Parent constructor
	ve.dm.LeafNode.call( this, 0, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.ImageNode, ve.dm.LeafNode );

/* Static Properties */

ve.dm.ImageNode.static.name = 'image';

ve.dm.ImageNode.static.isContent = true;

ve.dm.ImageNode.static.matchTagNames = [ 'img' ];

ve.dm.ImageNode.static.toDataElement = function ( domElements ) {
	var $node = $( domElements[0] ),
		width = $node.attr( 'width' ),
		height = $node.attr( 'height' );

	return {
		'type': 'image',
		'attributes': {
			'src': $node.attr( 'src' ),
			'width': width !== undefined && width !== '' ? Number( width ) : null,
			'height': height !== undefined && height !== '' ? Number( height ) : null
		}
	};
};

ve.dm.ImageNode.static.toDomElements = function ( dataElement, doc ) {
	var domElement = doc.createElement( 'img' );
	ve.setDomAttributes( domElement, dataElement.attributes, [ 'src', 'width', 'height' ] );
	return [ domElement ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.ImageNode );
