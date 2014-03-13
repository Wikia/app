/*!
 * VisualEditor ContentEditable LanguageAnnotation class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
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
	// Parent constructor
	ve.ce.Annotation.call( this, model, parentNode, config );

	// DOM changes
	this.$element.addClass( 've-ce-LanguageAnnotation' );

	this.$element.attr( 'lang', model.getAttribute( 'lang' ) );
	this.$element.attr( 'dir', model.getAttribute( 'dir' ) );

	// TODO:
	// When ULS is active, use $.uls.getAutonym(lang) to get the full
	// language name in the tooltip
	// (eg 'he' will be 'Hebrew' and 'en' will be 'English')
	this.$element.attr( 'title', ve.msg( 'visualeditor-languageinspector-block-tooltip', model.getAttribute( 'lang' ) ) );
};

/* Inheritance */

OO.inheritClass( ve.ce.LanguageAnnotation, ve.ce.Annotation );

/* Static Properties */

ve.ce.LanguageAnnotation.static.name = 'meta/language';

ve.ce.LanguageAnnotation.static.tagName = 'span';

/* Registration */

ve.ce.annotationFactory.register( ve.ce.LanguageAnnotation );
