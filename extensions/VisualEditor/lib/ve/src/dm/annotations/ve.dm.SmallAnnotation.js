/*!
 * VisualEditor DataModel SmallAnnotation class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel small annotation.
 *
 * Represents `<small>` tags.
 *
 * @class
 * @extends ve.dm.TextStyleAnnotation
 * @constructor
 * @param {Object} element
 */
ve.dm.SmallAnnotation = function VeDmSmallAnnotation() {
	// Parent constructor
	ve.dm.SmallAnnotation.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.SmallAnnotation, ve.dm.TextStyleAnnotation );

/* Static Properties */

ve.dm.SmallAnnotation.static.name = 'textStyle/small';

ve.dm.SmallAnnotation.static.matchTagNames = [ 'small' ];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.SmallAnnotation );
