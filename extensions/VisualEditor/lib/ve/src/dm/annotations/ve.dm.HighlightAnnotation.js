/*!
 * VisualEditor DataModel HighlightAnnotation class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel highlight annotation.
 *
 * Represents `<mark>` tags.
 *
 * @class
 * @extends ve.dm.TextStyleAnnotation
 * @constructor
 * @param {Object} element
 */
ve.dm.HighlightAnnotation = function VeDmHighlightAnnotation() {
	// Parent constructor
	ve.dm.HighlightAnnotation.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.HighlightAnnotation, ve.dm.TextStyleAnnotation );

/* Static Properties */

ve.dm.HighlightAnnotation.static.name = 'textStyle/highlight';

ve.dm.HighlightAnnotation.static.matchTagNames = [ 'mark' ];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.HighlightAnnotation );
