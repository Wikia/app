/*!
 * VisualEditor DataModel LanguageAnnotation class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel language annotation.
 *
 * Represents `<span>` tags with 'lang' and 'dir' properties.
 *
 * @class
 * @extends ve.dm.Annotation
 * @constructor
 * @param {Object} element
 */
ve.dm.LanguageAnnotation = function VeDmLanguageAnnotation( element ) {
	// Parent constructor
	ve.dm.Annotation.call( this, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.LanguageAnnotation, ve.dm.Annotation );

/* Static Properties */

ve.dm.LanguageAnnotation.static.name = 'meta/language';

ve.dm.LanguageAnnotation.static.matchTagNames = [ 'span' ];

ve.dm.LanguageAnnotation.static.matchFunction = function( domElement ) {
	return ( domElement.getAttribute( 'lang' ) || domElement.getAttribute( 'dir' ) );
};

ve.dm.LanguageAnnotation.static.applyToAppendedContent = false;

ve.dm.LanguageAnnotation.static.toDataElement = function ( domElements ) {
	return {
		'type': 'meta/language',
		'attributes': {
			'lang': domElements[0].getAttribute( 'lang' ),
			'dir': domElements[0].getAttribute( 'dir' )
		}
	};
};

ve.dm.LanguageAnnotation.static.toDomElements = function ( dataElement, doc ) {
	var domElement = doc.createElement( 'span' );
	if ( dataElement.attributes.lang ) {
		domElement.setAttribute( 'lang', dataElement.attributes.lang );
	}
	if ( dataElement.attributes.dir ) {
		domElement.setAttribute( 'dir', dataElement.attributes.dir );
	}

	return [ domElement ];
};

/* Methods */

/**
 * @returns {Object}
 */
ve.dm.LanguageAnnotation.prototype.getComparableObject = function () {
	return {
		'type': 'meta/language',
		'lang': this.getAttribute( 'lang' )
	};
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.LanguageAnnotation );
