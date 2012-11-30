/**
 * VisualEditor data model TextStyleAnnotation class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * TextStyle annotation.
 *
 * Should not be instantiated directly, only use this for subclassing.
 *
 * @class
 * @constructor
 * @extends {ve.dm.Annotation}
 * @param {HTMLElement} element
 */
ve.dm.TextStyleAnnotation = function VeDmTextStyleAnnotation( element ) {
	ve.dm.Annotation.call( this, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.TextStyleAnnotation, ve.dm.Annotation );

/* Static Members */

ve.dm.TextStyleAnnotation.static.name = 'textStyle';
ve.dm.TextStyleAnnotation.static.matchTagNames = [];

/**
 * Convert to an object with HTML element information.
 *
 * @method
 * @returns {Object} HTML element information, including tag and attributes properties
 */
ve.dm.TextStyleAnnotation.prototype.toHTML = function () {
	var parentResult = ve.dm.Annotation.prototype.toHTML.call( this );
	parentResult.tag = parentResult.tag || this.constructor.static.matchTagNames[0];
	return parentResult;
};

/* Registration */

ve.dm.annotationFactory.register( 'textStyle', ve.dm.TextStyleAnnotation );

/* Concrete Subclasses */

/**
 * Bold annotation.
 *
 * @class
 * @constructor
 * @extends {ve.dm.TextStyleAnnotation}
 * @param {HTMLElement} element
 */
ve.dm.TextStyleBoldAnnotation = function VeDmTextStyleBoldAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleBoldAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleBoldAnnotation.static.name = 'textStyle/bold';
ve.dm.TextStyleBoldAnnotation.static.matchTagNames = ['b'];
ve.dm.annotationFactory.register( 'textStyle/bold', ve.dm.TextStyleBoldAnnotation );

/**
 * Italic annotation.
 *
 * @class
 * @constructor
 * @extends {ve.dm.TextStyleAnnotation}
 * @param {HTMLElement} element
 */
ve.dm.TextStyleItalicAnnotation = function VeDmTextStyleItalicAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleItalicAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleItalicAnnotation.static.name = 'textStyle/italic';
ve.dm.TextStyleItalicAnnotation.static.matchTagNames = ['i'];
ve.dm.annotationFactory.register( 'textStyle/italic', ve.dm.TextStyleItalicAnnotation );

/**
 * Underline annotation.
 *
 * @class
 * @constructor
 * @extends {ve.dm.TextStyleAnnotation}
 * @param {HTMLElement} element
 */
ve.dm.TextStyleUnderlineAnnotation = function VeDmTextStyleUnderlineAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleUnderlineAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleUnderlineAnnotation.static.name = 'textStyle/underline';
ve.dm.TextStyleUnderlineAnnotation.static.matchTagNames = ['u'];
ve.dm.annotationFactory.register( 'textStyle/underline', ve.dm.TextStyleUnderlineAnnotation );

/**
 * Strike annotation.
 *
 * @class
 * @constructor
 * @extends {ve.dm.TextStyleAnnotation}
 * @param {HTMLElement} element
 */
ve.dm.TextStyleStrikeAnnotation = function VeDmTextStyleStrikeAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleStrikeAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleStrikeAnnotation.static.name = 'textStyle/strike';
ve.dm.TextStyleStrikeAnnotation.static.matchTagNames = ['s'];
ve.dm.annotationFactory.register( 'textStyle/strike', ve.dm.TextStyleStrikeAnnotation );

/**
 * Small annotation.
 *
 * @class
 * @constructor
 * @extends {ve.dm.TextStyleAnnotation}
 * @param {HTMLElement} element
 */
ve.dm.TextStyleSmallAnnotation = function VeDmTextStyleSmallAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleSmallAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleSmallAnnotation.static.name = 'textStyle/small';
ve.dm.TextStyleSmallAnnotation.static.matchTagNames = ['small'];
ve.dm.annotationFactory.register( 'textStyle/small', ve.dm.TextStyleSmallAnnotation );

/**
 * Big annotation.
 *
 * @class
 * @constructor
 * @extends {ve.dm.TextStyleAnnotation}
 * @param {HTMLElement} element
 */
ve.dm.TextStyleBigAnnotation = function VeDmTextStyleBigAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleBigAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleBigAnnotation.static.name = 'textStyle/big';
ve.dm.TextStyleBigAnnotation.static.matchTagNames = ['big'];
ve.dm.annotationFactory.register( 'textStyle/big', ve.dm.TextStyleBigAnnotation );

/**
 * Span annotation.
 *
 * @class
 * @constructor
 * @extends {ve.dm.TextStyleAnnotation}
 * @param {HTMLElement} element
 */
ve.dm.TextStyleSpanAnnotation = function VeDmTextStyleSpanAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleSpanAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleSpanAnnotation.static.name = 'textStyle/span';
ve.dm.TextStyleSpanAnnotation.static.matchTagNames = ['span'];
ve.dm.annotationFactory.register( 'textStyle/span', ve.dm.TextStyleSpanAnnotation );

/**
 * Strong annotation.
 *
 * @class
 * @constructor
 * @extends {ve.dm.TextStyleAnnotation}
 * @param {HTMLElement} element
 */
ve.dm.TextStyleStrongAnnotation = function VeDmTextStyleStrongAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleStrongAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleStrongAnnotation.static.name = 'textStyle/strong';
ve.dm.TextStyleStrongAnnotation.static.matchTagNames = ['strong'];
ve.dm.annotationFactory.register( 'textStyle/strong', ve.dm.TextStyleStrongAnnotation );

/**
 * Emphasis annotation.
 *
 * @class
 * @constructor
 * @extends {ve.dm.TextStyleAnnotation}
 * @param {HTMLElement} element
 */
ve.dm.TextStyleEmphasizeAnnotation = function VeDmTextStyleEmphasizeAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleEmphasizeAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleEmphasizeAnnotation.static.name = 'textStyle/emphasize';
ve.dm.TextStyleEmphasizeAnnotation.static.matchTagNames = ['em'];
ve.dm.annotationFactory.register( 'textStyle/emphasize', ve.dm.TextStyleEmphasizeAnnotation );

/**
 * SuperScript annotation.
 *
 * @class
 * @constructor
 * @extends {ve.dm.TextStyleAnnotation}
 * @param {HTMLElement} element
 */
ve.dm.TextStyleSuperScriptAnnotation = function VeDmTextStyleSuperScriptAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleSuperScriptAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleSuperScriptAnnotation.static.name = 'textStyle/superScript';
ve.dm.TextStyleSuperScriptAnnotation.static.matchTagNames = ['sup'];
ve.dm.annotationFactory.register( 'textStyle/superScript', ve.dm.TextStyleSuperScriptAnnotation );

/**
 * SubScript annotation.
 *
 * @class
 * @constructor
 * @extends {ve.dm.TextStyleAnnotation}
 * @param {HTMLElement} element
 */
ve.dm.TextStyleSubScriptAnnotation = function VeDmTextStyleSubScriptAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleSubScriptAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleSubScriptAnnotation.static.name = 'textStyle/subScript';
ve.dm.TextStyleSubScriptAnnotation.static.matchTagNames = ['sub'];
ve.dm.annotationFactory.register( 'textStyle/subScript', ve.dm.TextStyleSubScriptAnnotation );
