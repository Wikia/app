/*!
 * VisualEditor ContentEditable LanguageAnnotation class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable language annotation.
 *
 * @class
 * @extends ve.ce.Annotation
 * @constructor
 * @param {ve.dm.LanguageAnnotation} model Model to observe
 * @param {ve.ce.ContentBranchNode} [parentNode] Node rendering this annotation
 * @param {Object} [config] Configuration options
 */
ve.ce.LanguageAnnotation = function VeCeLanguageAnnotation( model, parentNode, config ) {
	var lang = model.getAttribute( 'lang' ),
		dir = model.getAttribute( 'dir' );

	// Parent constructor
	ve.ce.Annotation.call( this, model, parentNode, config );

	// DOM changes
	this.$element
		.addClass( 've-ce-LanguageAnnotation' )
		.attr( {
			'lang': lang,
			'dir': dir,
			'title': ve.msg( 'visualeditor-languageinspector-block-tooltip' )
		} );
};

/* Inheritance */

OO.inheritClass( ve.ce.LanguageAnnotation, ve.ce.Annotation );

/* Static Properties */

ve.ce.LanguageAnnotation.static.name = 'meta/language';

ve.ce.LanguageAnnotation.static.tagName = 'span';

/* Static Methods */

/**
 * @inheritdoc
 */
ve.ce.LanguageAnnotation.static.getDescription = function ( model ) {
	var lang = model.getAttribute( 'lang' ).toLowerCase(),
		name = ve.init.platform.getLanguageName( lang ),
		dir = ( model.getAttribute( 'dir' ) || '' ).toUpperCase();

	if ( !dir || dir === ve.init.platform.getLanguageDirection( lang ).toUpperCase() ) {
		return ve.msg( 'visualeditor-languageannotation-description', name );
	} else {
		return ve.msg( 'visualeditor-languageannotation-description-with-dir', name, dir );
	}
};

/* Registration */

ve.ce.annotationFactory.register( ve.ce.LanguageAnnotation );
