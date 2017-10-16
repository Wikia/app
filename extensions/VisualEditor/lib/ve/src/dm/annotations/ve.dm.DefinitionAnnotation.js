/*!
 * VisualEditor DataModel DefinitionAnnotation class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel definition annotation.
 *
 * Represents `<dfn>` tags.
 *
 * @class
 * @extends ve.dm.TextStyleAnnotation
 * @constructor
 * @param {Object} element
 */
ve.dm.DefinitionAnnotation = function VeDmDefinitionAnnotation() {
	// Parent constructor
	ve.dm.DefinitionAnnotation.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.DefinitionAnnotation, ve.dm.TextStyleAnnotation );

/* Static Properties */

ve.dm.DefinitionAnnotation.static.name = 'textStyle/definition';

ve.dm.DefinitionAnnotation.static.matchTagNames = [ 'dfn' ];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.DefinitionAnnotation );
