/*!
 * VisualEditor ContentEditable MWNowikiAnnotation class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki nowiki annotation.
 *
 * @class
 * @extends ve.ce.Annotation
 * @constructor
 * @param {ve.dm.MWNowikiAnnotation} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWNowikiAnnotation = function VeCeMWInternalLinkAnnotation( model, config ) {
	// Parent constructor
	ve.ce.Annotation.call( this, model, config );

	// DOM changes
	this.$.addClass( 've-ce-mwNowikiAnnotation' );
};

/* Inheritance */

ve.inheritClass( ve.ce.MWNowikiAnnotation, ve.ce.Annotation );

/* Static Properties */

ve.ce.MWNowikiAnnotation.static.name = 'mwNowiki';

ve.ce.MWNowikiAnnotation.static.tagName = 'span';

/* Registration */

ve.ce.annotationFactory.register( ve.ce.MWNowikiAnnotation );
