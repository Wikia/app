/*!
 * VisualEditor DataModel LinkAnnotation class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel link annotation.
 *
 * Represents `<a>` tags that don't have a specific type.
 *
 * @class
 * @extends ve.dm.Annotation
 * @constructor
 * @param {Object} element
 */
ve.dm.LinkAnnotation = function VeDmLinkAnnotation( element ) {
	// Parent constructor
	ve.dm.Annotation.call( this, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.LinkAnnotation, ve.dm.Annotation );

/* Static Properties */

ve.dm.LinkAnnotation.static.name = 'link';

ve.dm.LinkAnnotation.static.matchTagNames = ['a'];

ve.dm.LinkAnnotation.static.splitOnWordbreak = true;

ve.dm.LinkAnnotation.static.toDataElement = function ( domElements ) {
	return {
		'type': 'link',
		'attributes': {
			'href': domElements[0].getAttribute( 'href' )
		}
	};
};

ve.dm.LinkAnnotation.static.toDomElements = function ( dataElement, doc ) {
	var domElement = doc.createElement( 'a' );
	domElement.setAttribute( 'href', dataElement.attributes.href );
	return [ domElement ];
};

/* Methods */

/**
 * @returns {Object}
 */
ve.dm.LinkAnnotation.prototype.getComparableObject = function () {
	return {
		'type': this.getType(),
		'href': this.getAttribute( 'href' )
	};
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.LinkAnnotation );
