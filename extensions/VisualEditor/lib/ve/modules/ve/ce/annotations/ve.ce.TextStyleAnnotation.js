/*!
 * VisualEditor ContentEditable TextStyleAnnotation class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable text style annotation.
 *
 * @class
 * @extends ve.ce.Annotation
 * @constructor
 * @param {ve.dm.TextStyleAnnotation} model Model to observe
 * @param {ve.ce.ContentBranchNode} [parentNode] Node rendering this annotation
 * @param {Object} [config] Configuration options
 */
ve.ce.TextStyleAnnotation = function VeCeTextStyleAnnotation( model, parentNode, config ) {
	// Parent constructor
	ve.ce.Annotation.call( this, model, parentNode, config );

	// DOM changes
	this.$element.addClass( 've-ce-TextStyleAnnotation' );
};

/* Inheritance */

OO.inheritClass( ve.ce.TextStyleAnnotation, ve.ce.Annotation );

/* Static Properties */

ve.ce.TextStyleAnnotation.static.name = 'textStyle';

/* Methods */

ve.ce.TextStyleAnnotation.prototype.getTagName = function () {
	return this.getModel().getAttribute( 'nodeName' ) || this.constructor.static.tagName;
};

/* Registration */

ve.ce.annotationFactory.register( ve.ce.TextStyleAnnotation );

/* Concrete Subclasses */

/**
 * ContentEditable bold annotation.
 *
 * @class
 * @extends ve.ce.TextStyleAnnotation
 * @constructor
 * @param {ve.dm.TextStyleBoldAnnotation} model Model to observe
 * @param {ve.ce.ContentBranchNode} [parentNode] Node rendering this annotation
 * @param {Object} [config] Configuration options
 */
ve.ce.TextStyleBoldAnnotation = function VeCeTextStyleBoldAnnotation( model, parentNode, config ) {
	ve.ce.TextStyleAnnotation.call( this, model, parentNode, config );
	this.$element.addClass( 've-ce-TextStyleBoldAnnotation' );
};
OO.inheritClass( ve.ce.TextStyleBoldAnnotation, ve.ce.TextStyleAnnotation );
ve.ce.TextStyleBoldAnnotation.static.name = 'textStyle/bold';
ve.ce.TextStyleBoldAnnotation.static.tagName = 'b';
ve.ce.annotationFactory.register( ve.ce.TextStyleBoldAnnotation );

/**
 * ContentEditable italic annotation.
 *
 * @class
 * @extends ve.ce.TextStyleAnnotation
 * @constructor
 * @param {ve.dm.TextStyleItalicAnnotation} model Model to observe
 * @param {ve.ce.ContentBranchNode} [parentNode] Node rendering this annotation
 * @param {Object} [config] Configuration options
 */
ve.ce.TextStyleItalicAnnotation = function VeCeTextStyleItalicAnnotation( model, parentNode, config ) {
	ve.ce.TextStyleAnnotation.call( this, model, parentNode, config );
	this.$element.addClass( 've-ce-TextStyleItalicAnnotation' );
};
OO.inheritClass( ve.ce.TextStyleItalicAnnotation, ve.ce.TextStyleAnnotation );
ve.ce.TextStyleItalicAnnotation.static.name = 'textStyle/italic';
ve.ce.TextStyleItalicAnnotation.static.tagName = 'i';
ve.ce.annotationFactory.register( ve.ce.TextStyleItalicAnnotation );

/**
 * ContentEditable underline annotation.
 *
 * @class
 * @extends ve.ce.TextStyleAnnotation
 * @constructor
 * @param {ve.dm.TextStyleUnderlineAnnotation} model Model to observe
 * @param {ve.ce.ContentBranchNode} [parentNode] Node rendering this annotation
 * @param {Object} [config] Configuration options
 */
ve.ce.TextStyleUnderlineAnnotation = function VeCeTextStyleUnderlineAnnotation( model, parentNode, config ) {
	ve.ce.TextStyleAnnotation.call( this, model, parentNode, config );
	this.$element.addClass( 've-ce-TextStyleUnderlineAnnotation' );
};
OO.inheritClass( ve.ce.TextStyleUnderlineAnnotation, ve.ce.TextStyleAnnotation );
ve.ce.TextStyleUnderlineAnnotation.static.name = 'textStyle/underline';
ve.ce.TextStyleUnderlineAnnotation.static.tagName = 'u';
ve.ce.annotationFactory.register( ve.ce.TextStyleUnderlineAnnotation );

/**
 * ContentEditable strike annotation.
 *
 * @class
 * @extends ve.ce.TextStyleAnnotation
 * @constructor
 * @param {ve.dm.TextStyleStrikeAnnotation} model Model to observe
 * @param {ve.ce.ContentBranchNode} [parentNode] Node rendering this annotation
 * @param {Object} [config] Configuration options
 */
ve.ce.TextStyleStrikeAnnotation = function VeCeTextStyleStrikeAnnotation( model, parentNode, config ) {
	ve.ce.TextStyleAnnotation.call( this, model, parentNode, config );
	this.$element.addClass( 've-ce-TextStyleStrikeAnnotation' );
};
OO.inheritClass( ve.ce.TextStyleStrikeAnnotation, ve.ce.TextStyleAnnotation );
ve.ce.TextStyleStrikeAnnotation.static.name = 'textStyle/strike';
ve.ce.TextStyleStrikeAnnotation.static.tagName = 's';
ve.ce.annotationFactory.register( ve.ce.TextStyleStrikeAnnotation );

/**
 * ContentEditable small annotation.
 *
 * @class
 * @extends ve.ce.TextStyleAnnotation
 * @constructor
 * @param {ve.dm.TextStyleSmallAnnotation} model Model to observe
 * @param {ve.ce.ContentBranchNode} [parentNode] Node rendering this annotation
 * @param {Object} [config] Configuration options
 */
ve.ce.TextStyleSmallAnnotation = function VeCeTextStyleSmallAnnotation( model, parentNode, config ) {
	ve.ce.TextStyleAnnotation.call( this, model, parentNode, config );
	this.$element.addClass( 've-ce-TextStyleSmallAnnotation' );
};
OO.inheritClass( ve.ce.TextStyleSmallAnnotation, ve.ce.TextStyleAnnotation );
ve.ce.TextStyleSmallAnnotation.static.name = 'textStyle/small';
ve.ce.TextStyleSmallAnnotation.static.tagName = 'small';
ve.ce.annotationFactory.register( ve.ce.TextStyleSmallAnnotation );

/**
 * ContentEditable big annotation.
 *
 * @class
 * @extends ve.ce.TextStyleAnnotation
 * @constructor
 * @param {ve.dm.TextStyleBigAnnotation} model Model to observe
 * @param {ve.ce.ContentBranchNode} [parentNode] Node rendering this annotation
 * @param {Object} [config] Configuration options
 */
ve.ce.TextStyleBigAnnotation = function VeCeTextStyleBigAnnotation( model, parentNode, config ) {
	ve.ce.TextStyleAnnotation.call( this, model, parentNode, config );
	this.$element.addClass( 've-ce-TextStyleBigAnnotation' );
};
OO.inheritClass( ve.ce.TextStyleBigAnnotation, ve.ce.TextStyleAnnotation );
ve.ce.TextStyleBigAnnotation.static.name = 'textStyle/big';
ve.ce.TextStyleBigAnnotation.static.tagName = 'big';
ve.ce.annotationFactory.register( ve.ce.TextStyleBigAnnotation );

/**
 * ContentEditable span annotation.
 *
 * @class
 * @extends ve.ce.TextStyleAnnotation
 * @constructor
 * @param {ve.dm.TextStyleSpanAnnotation} model Model to observe
 * @param {ve.ce.ContentBranchNode} [parentNode] Node rendering this annotation
 * @param {Object} [config] Configuration options
 */
ve.ce.TextStyleSpanAnnotation = function VeCeTextStyleSpanAnnotation( model, parentNode, config ) {
	ve.ce.TextStyleAnnotation.call( this, model, parentNode, config );
	this.$element.addClass( 've-ce-TextStyleSpanAnnotation' );
};
OO.inheritClass( ve.ce.TextStyleSpanAnnotation, ve.ce.TextStyleAnnotation );
ve.ce.TextStyleSpanAnnotation.static.name = 'textStyle/span';
ve.ce.TextStyleSpanAnnotation.static.tagName = 'span';
ve.ce.annotationFactory.register( ve.ce.TextStyleSpanAnnotation );

/**
 * ContentEditable superscript annotation.
 *
 * @class
 * @extends ve.ce.TextStyleAnnotation
 * @constructor
 * @param {ve.dm.TextStyleSuperscriptAnnotation} model Model to observe
 * @param {ve.ce.ContentBranchNode} [parentNode] Node rendering this annotation
 * @param {Object} [config] Configuration options
 */
ve.ce.TextStyleSuperscriptAnnotation = function VeCeTextStyleSuperscriptAnnotation( model, parentNode, config ) {
	ve.ce.TextStyleAnnotation.call( this, model, parentNode, config );
	this.$element.addClass( 've-ce-TextStyleSuperscriptAnnotation' );
};
OO.inheritClass( ve.ce.TextStyleSuperscriptAnnotation, ve.ce.TextStyleAnnotation );
ve.ce.TextStyleSuperscriptAnnotation.static.name = 'textStyle/superscript';
ve.ce.TextStyleSuperscriptAnnotation.static.tagName = 'sup';
ve.ce.annotationFactory.register( ve.ce.TextStyleSuperscriptAnnotation );

/**
 * ContentEditable subscript annotation.
 *
 * @class
 * @extends ve.ce.TextStyleAnnotation
 * @constructor
 * @param {ve.dm.TextStyleSubscriptAnnotation} model Model to observe
 * @param {ve.ce.ContentBranchNode} [parentNode] Node rendering this annotation
 * @param {Object} [config] Configuration options
 */
ve.ce.TextStyleSubscriptAnnotation = function VeCeTextStyleSubscriptAnnotation( model, parentNode, config ) {
	ve.ce.TextStyleAnnotation.call( this, model, parentNode, config );
	this.$element.addClass( 've-ce-TextStyleSubscriptAnnotation' );
};
OO.inheritClass( ve.ce.TextStyleSubscriptAnnotation, ve.ce.TextStyleAnnotation );
ve.ce.TextStyleSubscriptAnnotation.static.name = 'textStyle/subscript';
ve.ce.TextStyleSubscriptAnnotation.static.tagName = 'sub';
ve.ce.annotationFactory.register( ve.ce.TextStyleSubscriptAnnotation );

/**
 * ContentEditable code annotation.
 *
 * @class
 * @extends ve.ce.TextStyleAnnotation
 * @constructor
 * @param {ve.dm.TextStyleCodeAnnotation} model Model to observe
 * @param {ve.ce.ContentBranchNode} [parentNode] Node rendering this annotation
 * @param {Object} [config] Configuration options
 */
ve.ce.TextStyleCodeAnnotation = function VeCeTextStyleCodeAnnotation( model, parentNode, config ) {
	ve.ce.TextStyleAnnotation.call( this, model, parentNode, config );
	this.$element.addClass( 've-ce-TextStyleCodeAnnotation' );
};
OO.inheritClass( ve.ce.TextStyleCodeAnnotation, ve.ce.TextStyleAnnotation );
ve.ce.TextStyleCodeAnnotation.static.name = 'textStyle/code';
ve.ce.TextStyleCodeAnnotation.static.tagName = 'code';
ve.ce.annotationFactory.register( ve.ce.TextStyleCodeAnnotation );
