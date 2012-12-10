/**
 * VisualEditor data model MWExternalLinkAnnotation class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki external link annotation.
 *
 * Example HTML sources:
 *     <a rel="mw:ExtLink">
 *     <a rel="mw:ExtLink/Numbered">
 *     <a rel="mw:ExtLink/URL">
 *
 * Each example is semantically slightly different, but don't need special treatment (yet).
 *
 * @class
 * @constructor
 * @extends {ve.dm.LinkAnnotation}
 * @param {HTMLElement} element
 */
ve.dm.MWExternalLinkAnnotation = function VeDmMWExternalLinkAnnotation( element ) {
	// Parent constructor
	ve.dm.LinkAnnotation.call( this, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.MWExternalLinkAnnotation, ve.dm.LinkAnnotation );

/* Static Members */

ve.dm.MWExternalLinkAnnotation.static.name = 'link/MWexternal';

ve.dm.MWExternalLinkAnnotation.static.matchRdfaTypes = [
	'mw:ExtLink', 'mw:ExtLink/Numbered', 'mw:ExtLink/URL'
];

/**
 * Convert to an object with HTML element information.
 *
 * @method
 * @returns {Object} HTML element information, including tag and attributes properties
 */
ve.dm.MWExternalLinkAnnotation.prototype.toHTML = function () {
	var parentResult = ve.dm.LinkAnnotation.prototype.toHTML.call( this );
	parentResult.attributes.rel = parentResult.attributes.rel || 'mw:ExtLink';
	return parentResult;
};

/* Registration */

ve.dm.annotationFactory.register( 'link/MWexternal', ve.dm.MWExternalLinkAnnotation );
