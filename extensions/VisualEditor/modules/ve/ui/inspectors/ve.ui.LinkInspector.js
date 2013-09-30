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
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 */
ve.ui.LinkInspector = function VeUiLinkInspector( surface, config ) {
	// Parent constructor
	ve.ui.AnnotationInspector.call( this, surface, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.LinkInspector, ve.ui.AnnotationInspector );

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
 * Handle frame ready events.
 *
 * @method
 */
ve.ui.LinkInspector.prototype.initialize = function () {
	// Parent method
	ve.ui.AnnotationInspector.prototype.initialize.call( this );

	// Properties
	this.targetInput = new this.constructor.static.linkTargetInputWidget( {
		'$$': this.frame.$$, '$overlay': this.surface.$localOverlayMenus
	} );

	// Initialization
	this.$form.append( this.targetInput.$ );
};

/**
 * Handle the inspector being opened.
 */
ve.ui.LinkInspector.prototype.onOpen = function () {
	// Parent method
	ve.ui.AnnotationInspector.prototype.onOpen.call( this );

	// Wait for animation to complete
	this.surface.disable();
	setTimeout( ve.bind( function () {
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
	}, this ), 200 );
};

/**
 * Get the annotation from the input (so AnnotationInspector can request the value
 * from the inspector rather than the widget)
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

/* Registration */

ve.ui.inspectorFactory.register( ve.ui.LinkInspector );
