/*!
 * VisualEditor DataModel TextStyleAnnotation class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel text style annotation.
 *
 * Should not be instantiated directly, only use this for subclassing.
 *
 * @class
 * @extends ve.dm.Annotation
 * @constructor
 * @param {Object} element
 */
ve.dm.TextStyleAnnotation = function VeDmTextStyleAnnotation( element ) {
	ve.dm.Annotation.call( this, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.TextStyleAnnotation, ve.dm.Annotation );

/* Static Properties */

ve.dm.TextStyleAnnotation.static.name = 'textStyle';

ve.dm.TextStyleAnnotation.static.matchTagNames = [];

ve.dm.TextStyleAnnotation.static.toDataElement = function ( domElements ) {
	var nodeName = domElements[0].nodeName.toLowerCase(),
		types = {
			'b': 'bold',
			'i': 'italic',
			'u': 'underline',
			's': 'strike',
			'small': 'small',
			'big': 'big',
			'span': 'span',
			'strong': 'strong',
			'em': 'emphasize',
			'sup': 'superscript',
			'sub': 'subscript',
			'code': 'code',
			'tt': 'code'
		};
	return {
		'type': 'textStyle/' + types[nodeName],
		'attributes': {
			'nodeName': nodeName
		}
	};
};

ve.dm.TextStyleAnnotation.static.toDomElements = function ( dataElement, doc ) {
	var nodeNames,
		nodeName = ve.getProp( dataElement, 'attributes', 'nodeName' );

	if ( nodeName ) {
		return [ doc.createElement( nodeName ) ];
	} else {
		nodeNames = {
			'bold': 'b',
			'italic': 'i',
			'underline': 'u',
			'strike': 's',
			'small': 'small',
			'big': 'big',
			'span': 'span',
			'strong': 'strong',
			'emphasize': 'em',
			'superscript': 'sup',
			'subscript': 'sub',
			'code': 'code'
		};
		return [ doc.createElement( nodeNames[ dataElement.type.substring( 10 ) ] ) ];
	}
};

/* Methods */

/**
 * @returns {Object}
 */
ve.dm.TextStyleAnnotation.prototype.getComparableObject = function () {
	return {
		'type': this.getType()
	};
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.TextStyleAnnotation );

/* Concrete Subclasses */

/**
 * DataModel bold annotation.
 *
 * @class
 * @extends ve.dm.TextStyleAnnotation
 * @constructor
 * @param {Object} element
 */
ve.dm.TextStyleBoldAnnotation = function VeDmTextStyleBoldAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleBoldAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleBoldAnnotation.static.name = 'textStyle/bold';
ve.dm.TextStyleBoldAnnotation.static.matchTagNames = ['b'];
ve.dm.modelRegistry.register( ve.dm.TextStyleBoldAnnotation );

/**
 * DataModel italic annotation.
 *
 * @class
 * @extends ve.dm.TextStyleAnnotation
 * @constructor
 * @param {Object} element
 */
ve.dm.TextStyleItalicAnnotation = function VeDmTextStyleItalicAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleItalicAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleItalicAnnotation.static.name = 'textStyle/italic';
ve.dm.TextStyleItalicAnnotation.static.matchTagNames = ['i'];
ve.dm.modelRegistry.register( ve.dm.TextStyleItalicAnnotation );

/**
 * DataModel underline annotation.
 *
 * @class
 * @extends ve.dm.TextStyleAnnotation
 * @constructor
 * @param {Object} element
 */
ve.dm.TextStyleUnderlineAnnotation = function VeDmTextStyleUnderlineAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleUnderlineAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleUnderlineAnnotation.static.name = 'textStyle/underline';
ve.dm.TextStyleUnderlineAnnotation.static.matchTagNames = ['u'];
ve.dm.modelRegistry.register( ve.dm.TextStyleUnderlineAnnotation );

/**
 * DataModel strike annotation.
 *
 * @class
 * @extends ve.dm.TextStyleAnnotation
 * @constructor
 * @param {Object} element
 */
ve.dm.TextStyleStrikeAnnotation = function VeDmTextStyleStrikeAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleStrikeAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleStrikeAnnotation.static.name = 'textStyle/strike';
ve.dm.TextStyleStrikeAnnotation.static.matchTagNames = ['s'];
ve.dm.modelRegistry.register( ve.dm.TextStyleStrikeAnnotation );

/**
 * DataModel small annotation.
 *
 * @class
 * @extends ve.dm.TextStyleAnnotation
 * @constructor
 * @param {Object} element
 */
ve.dm.TextStyleSmallAnnotation = function VeDmTextStyleSmallAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleSmallAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleSmallAnnotation.static.name = 'textStyle/small';
ve.dm.TextStyleSmallAnnotation.static.matchTagNames = ['small'];
ve.dm.modelRegistry.register( ve.dm.TextStyleSmallAnnotation );

/**
 * DataModel big annotation.
 *
 * @class
 * @extends ve.dm.TextStyleAnnotation
 * @constructor
 * @param {Object} element
 */
ve.dm.TextStyleBigAnnotation = function VeDmTextStyleBigAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleBigAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleBigAnnotation.static.name = 'textStyle/big';
ve.dm.TextStyleBigAnnotation.static.matchTagNames = ['big'];
ve.dm.modelRegistry.register( ve.dm.TextStyleBigAnnotation );

/**
 * DataModel span annotation.
 *
 * @class
 * @extends ve.dm.TextStyleAnnotation
 * @constructor
 * @param {Object} element
 */
ve.dm.TextStyleSpanAnnotation = function VeDmTextStyleSpanAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleSpanAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleSpanAnnotation.static.name = 'textStyle/span';
ve.dm.TextStyleSpanAnnotation.static.matchTagNames = ['span'];
ve.dm.modelRegistry.register( ve.dm.TextStyleSpanAnnotation );

/**
 * DataModel strong annotation.
 *
 * @class
 * @extends ve.dm.TextStyleAnnotation
 * @constructor
 * @param {Object} element
 */
ve.dm.TextStyleStrongAnnotation = function VeDmTextStyleStrongAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleStrongAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleStrongAnnotation.static.name = 'textStyle/strong';
ve.dm.TextStyleStrongAnnotation.static.matchTagNames = ['strong'];
ve.dm.modelRegistry.register( ve.dm.TextStyleStrongAnnotation );

/**
 * DataModel emphasis annotation.
 *
 * @class
 * @extends ve.dm.TextStyleAnnotation
 * @constructor
 * @param {Object} element
 */
ve.dm.TextStyleEmphasizeAnnotation = function VeDmTextStyleEmphasizeAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleEmphasizeAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleEmphasizeAnnotation.static.name = 'textStyle/emphasize';
ve.dm.TextStyleEmphasizeAnnotation.static.matchTagNames = ['em'];
ve.dm.modelRegistry.register( ve.dm.TextStyleEmphasizeAnnotation );

/**
 * DataModel super script annotation.
 *
 * @class
 * @extends ve.dm.TextStyleAnnotation
 * @constructor
 * @param {Object} element
 */
ve.dm.TextStyleSuperscriptAnnotation = function VeDmTextStyleSuperscriptAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleSuperscriptAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleSuperscriptAnnotation.static.name = 'textStyle/superscript';
ve.dm.TextStyleSuperscriptAnnotation.static.matchTagNames = ['sup'];
ve.dm.modelRegistry.register( ve.dm.TextStyleSuperscriptAnnotation );

/**
 * DataModel sub script annotation.
 *
 * @class
 * @extends ve.dm.TextStyleAnnotation
 * @constructor
 * @param {Object} element
 */
ve.dm.TextStyleSubscriptAnnotation = function VeDmTextStyleSubscriptAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleSubscriptAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleSubscriptAnnotation.static.name = 'textStyle/subscript';
ve.dm.TextStyleSubscriptAnnotation.static.matchTagNames = ['sub'];
ve.dm.modelRegistry.register( ve.dm.TextStyleSubscriptAnnotation );

/**
 * DataModel code script annotation.
 *
 * @class
 * @extends ve.dm.TextStyleAnnotation
 * @constructor
 * @param {Object} element
 */
ve.dm.TextStyleCodeAnnotation = function VeDmTextStyleCodeAnnotation( element ) {
	ve.dm.TextStyleAnnotation.call( this, element );
};
ve.inheritClass( ve.dm.TextStyleCodeAnnotation, ve.dm.TextStyleAnnotation );
ve.dm.TextStyleCodeAnnotation.static.name = 'textStyle/code';
ve.dm.TextStyleCodeAnnotation.static.matchTagNames = ['code', 'tt'];
ve.dm.modelRegistry.register( ve.dm.TextStyleCodeAnnotation );
