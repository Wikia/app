/*!
 * VisualEditor ContentEditable MWInternalLinkAnnotation class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki internal link annotation.
 *
 * @class
 * @extends ve.ce.LinkAnnotation
 * @constructor
 * @param {ve.dm.MWInternalLinkAnnotation} model Model to observe
 * @param {ve.ce.ContentBranchNode} [parentNode] Node rendering this annotation
 * @param {Object} [config] Configuration options
 */
ve.ce.MWInternalLinkAnnotation = function VeCeMWInternalLinkAnnotation() {
	var annotation = this;
	// Parent constructor
	ve.ce.MWInternalLinkAnnotation.super.apply( this, arguments );

	// DOM changes
	this.$element.addClass( 've-ce-mwInternalLinkAnnotation' );

	// Style based on link cache information
	ve.init.platform.linkCache.styleElement( this.model.getAttribute( 'lookupTitle' ), annotation.$element );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWInternalLinkAnnotation, ve.ce.LinkAnnotation );

/* Static Properties */

ve.ce.MWInternalLinkAnnotation.static.name = 'link/mwInternal';

/* Static Methods */

/**
 * @inheritdoc
 */
ve.ce.MWInternalLinkAnnotation.static.getDescription = function ( model ) {
	return model.getAttribute( 'title' );
};

/* Registration */

ve.ce.annotationFactory.register( ve.ce.MWInternalLinkAnnotation );
