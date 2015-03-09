/*!
 * VisualEditor DataModel InlineImageNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel inline image node.
 *
 * @class
 * @extends ve.dm.LeafNode
 * @mixins ve.dm.ImageNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.InlineImageNode = function VeDmImageNode() {
	// Parent constructor
	ve.dm.InlineImageNode.super.apply( this, arguments );

	// Mixin constructor
	ve.dm.ImageNode.call( this );
};

/* Inheritance */

OO.inheritClass( ve.dm.InlineImageNode, ve.dm.LeafNode );

OO.mixinClass( ve.dm.InlineImageNode, ve.dm.ImageNode );

/* Static Properties */

ve.dm.InlineImageNode.static.name = 'inlineImage';

ve.dm.InlineImageNode.static.isContent = true;

ve.dm.InlineImageNode.static.matchTagNames = [ 'img' ];

ve.dm.InlineImageNode.static.toDataElement = function ( domElements ) {
	var $node = $( domElements[0] ),
		alt = $node.attr( 'alt' ),
		width = $node.attr( 'width' ),
		height = $node.attr( 'height' );

	return {
		type: this.name,
		attributes: {
			src: $node.attr( 'src' ),
			alt: alt !== undefined ? alt : null,
			width: width !== undefined && width !== '' ? Number( width ) : null,
			height: height !== undefined && height !== '' ? Number( height ) : null
		}
	};
};

ve.dm.InlineImageNode.static.toDomElements = function ( dataElement, doc ) {
	var domElement = doc.createElement( 'img' );
	ve.setDomAttributes( domElement, dataElement.attributes, [ 'alt', 'src', 'width', 'height' ] );
	return [ domElement ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.InlineImageNode );
