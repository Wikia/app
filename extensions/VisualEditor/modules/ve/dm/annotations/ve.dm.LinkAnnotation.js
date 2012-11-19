/**
 * VisualEditor data model LinkAnnotation class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Generic link annotation.
 *
 * Represents <a> tags that don't have a specific type.
 *
 * @class
 * @constructor
 * @extends {ve.dm.Annotation}
 * @param {HTMLElement} element
 */
ve.dm.LinkAnnotation = function VeDmLinkAnnotation( element ) {
	// Parent constructor
	ve.dm.Annotation.call( this, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.LinkAnnotation, ve.dm.Annotation );

/* Static Members */

ve.dm.LinkAnnotation.static.name = 'link';

ve.dm.LinkAnnotation.static.matchTagNames = ['a'];

/* Methods */

/**
 * Get annotation data, especially the href of the link.
 *
 * @method
 * @param {HTMLElement} element
 * @returns {Object} Annotation data, containing href property
 */
ve.dm.LinkAnnotation.prototype.getAnnotationData = function( element ) {
	return { 'href': element.getAttribute( 'href' ) };
};

/**
 * Convert to an object with HTML element information.
 *
 * @method
 * @returns {Object} HTML element information, including tag and attributes properties
 */
ve.dm.LinkAnnotation.prototype.toHTML = function () {
	var parentResult = ve.dm.Annotation.prototype.toHTML.call( this );
	parentResult.tag = 'a';
	parentResult.attributes.href = this.data.href;
	return parentResult;
};

/* Registration */

ve.dm.annotationFactory.register( 'link', ve.dm.LinkAnnotation );
