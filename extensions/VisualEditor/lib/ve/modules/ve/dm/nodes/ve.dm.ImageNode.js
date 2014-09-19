/*!
 * VisualEditor DataModel ImageNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel image node.
 *
 * @class
 * @extends ve.dm.LeafNode
 * @mixins ve.dm.ResizableNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.ImageNode = function VeDmImageNode() {
	// Parent constructor
	ve.dm.LeafNode.apply( this, arguments );

	// Mixin constructor
	ve.dm.ResizableNode.call( this );
};

/* Inheritance */

OO.inheritClass( ve.dm.ImageNode, ve.dm.LeafNode );

OO.mixinClass( ve.dm.ImageNode, ve.dm.ResizableNode );

/* Static Properties */

ve.dm.ImageNode.static.name = 'image';

ve.dm.ImageNode.static.isContent = true;

ve.dm.ImageNode.static.matchTagNames = [ 'img' ];

ve.dm.ImageNode.static.toDataElement = function ( domElements ) {
	var $node = $( domElements[0] ),
		alt = $node.attr( 'alt' ),
		width = $node.attr( 'width' ),
		height = $node.attr( 'height' );

	return {
		'type': this.name,
		'attributes': {
			'src': $node.attr( 'src' ),
			'alt': alt !== undefined ? alt : null,
			'width': width !== undefined && width !== '' ? Number( width ) : null,
			'height': height !== undefined && height !== '' ? Number( height ) : null
		}
	};
};

ve.dm.ImageNode.static.toDomElements = function ( dataElement, doc ) {
	var domElement = doc.createElement( 'img' );
	ve.setDomAttributes( domElement, dataElement.attributes, [ 'alt', 'src', 'width', 'height' ] );
	return [ domElement ];
};

/**
 * @inheritdoc
 */
ve.dm.ImageNode.prototype.createScalable = function () {
	return new ve.dm.Scalable( {
		'currentDimensions': {
			'width': this.getAttribute( 'width' ),
			'height': this.getAttribute( 'height' )
		},
		'minDimensions': {
			'width': 1,
			'height': 1
		}
	} );
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.ImageNode );
