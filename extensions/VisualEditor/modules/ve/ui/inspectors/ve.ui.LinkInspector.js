/*!
 * VisualEditor UserInterface LinkInspector class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Link inspector.
 *
 * @class
 * @extends ve.ui.AnnotationInspector
 *
 * @constructor
 * @param {ve.ui.WindowSet} windowSet Window set this inspector is part of
 * @param {Object} [config] Configuration options
 */
ve.ui.LinkInspector = function VeUiLinkInspector( windowSet, config ) {
	// Parent constructor
	ve.ui.AnnotationInspector.call( this, windowSet, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.LinkInspector, ve.ui.AnnotationInspector );

/* Static properties */

ve.ui.LinkInspector.static.name = 'link';

ve.ui.LinkInspector.static.icon = 'link';

ve.ui.LinkInspector.static.titleMessage = 'visualeditor-linkinspector-title';

ve.ui.LinkInspector.static.linkTargetInputWidget = ve.ui.LinkTargetInputWidget;

/**
 * Annotation models this inspector can edit.
 *
 * @static
 * @property {Function[]}
 */
ve.ui.LinkInspector.static.modelClasses = [ ve.dm.LinkAnnotation ];

/* Methods */

/**
 * Get the annotation from the input.
 *
 * This override allows AnnotationInspector to request the value from the inspector rather
 * than the widget.
 *
 * @method
 * @returns {ve.dm.LinkAnnotation} Link annotation
 */
ve.ui.LinkInspector.prototype.getAnnotation = function () {
	return this.targetInput.annotation;
};

/**
 * @inheritdoc
 */
ve.ui.LinkInspector.prototype.getAnnotationFromText = function ( text ) {
	return new ve.dm.LinkAnnotation( { 'type': 'link', 'attributes': { 'href': text } } );
};

/**
 * @inheritdoc
 */
ve.ui.LinkInspector.prototype.initialize = function () {
	// Parent method
	ve.ui.AnnotationInspector.prototype.initialize.call( this );

	// Properties
	this.targetInput = new this.constructor.static.linkTargetInputWidget( {
		'$': this.$, '$overlay': this.surface.$localOverlayMenus
	} );

	// Initialization
	this.$form.append( this.targetInput.$element );
};

/**
 * @inheritdoc
 */
ve.ui.LinkInspector.prototype.setup = function ( data ) {
	// Parent method
	ve.ui.AnnotationInspector.prototype.setup.call( this, data );

	// Wait for animation to complete
	this.surface.disable();
};

/**
 * @inheritdoc
 */
ve.ui.LinkInspector.prototype.ready = function () {
	// Parent method
	ve.ui.AnnotationInspector.prototype.ready.call( this );

	// Note: Focus input prior to setting target annotation
	this.targetInput.$input.focus();
	// Setup annotation
	if ( this.initialAnnotation ) {
		this.targetInput.setAnnotation( this.initialAnnotation );
	} else {
		// If an initial annotation couldn't be created (e.g. the text was invalid),
		// just populate the text we tried to create the annotation from
		this.targetInput.setValue( this.initialText );
	}
	this.targetInput.$input.select();
	this.surface.enable();
};

/* Registration */

ve.ui.inspectorFactory.register( ve.ui.LinkInspector );
