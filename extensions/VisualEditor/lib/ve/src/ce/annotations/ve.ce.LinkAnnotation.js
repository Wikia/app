/*!
 * VisualEditor ContentEditable LinkAnnotation class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * ContentEditable link annotation.
 *
 * @class
 * @extends ve.ce.Annotation
 * @constructor
 * @param {ve.dm.LinkAnnotation} model Model to observe
 * @param {ve.ce.ContentBranchNode} [parentNode] Node rendering this annotation
 * @param {Object} [config] Configuration options
 */
ve.ce.LinkAnnotation = function VeCeLinkAnnotation() {
	// Parent constructor
	ve.ce.LinkAnnotation.super.apply( this, arguments );

	// DOM changes
	this.$element
		.addClass( 've-ce-linkAnnotation' )
		.attr( 'href', ve.resolveUrl( this.model.getHref(), this.getModelHtmlDocument() ) )
		.attr( 'title', this.constructor.static.getDescription( this.model ) )
		// Some browsers will try to let links do their thing
		// (e.g. iOS Safari when the keyboard is closed)
		.on( 'click', function ( e ) {
			// Don't prevent a modified click which in some browsers deliberately opens the link
			if ( !e.altKey && !e.ctrlKey && !e.metaKey && !e.shiftKey ) {
				e.preventDefault();
			}
		} );
};

/* Inheritance */

OO.inheritClass( ve.ce.LinkAnnotation, ve.ce.Annotation );

/* Static Properties */

ve.ce.LinkAnnotation.static.name = 'link';

ve.ce.LinkAnnotation.static.tagName = 'a';

ve.ce.LinkAnnotation.static.forceContinuation = true;

/* Static Methods */

/**
 * @inheritdoc
 */
ve.ce.LinkAnnotation.static.getDescription = function ( model ) {
	return model.getHref();
};

/* Registration */

ve.ce.annotationFactory.register( ve.ce.LinkAnnotation );
