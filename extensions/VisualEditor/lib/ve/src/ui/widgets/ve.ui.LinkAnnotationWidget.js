/*!
 * VisualEditor UserInterface LinkAnnotationWidget class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Creates an ve.ui.LinkAnnotationWidget object.
 *
 * @class
 * @extends OO.ui.Widget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.LinkAnnotationWidget = function VeUiLinkAnnotationWidget( config ) {
	// Properties
	this.annotation = null;
	this.text = this.createInputWidget( config );

	// Parent constructor
	// Must be called after this.text is set as parent constructor calls this.setDisabled
	ve.ui.LinkAnnotationWidget.super.apply( this, arguments );

	// Initialization
	this.$element
		.append( this.text.$element )
		.addClass( 've-ui-linkAnnotationWidget' );

	// Events
	this.text.connect( this, { change: 'onTextChange' } );
};

/* Inheritance */

OO.inheritClass( ve.ui.LinkAnnotationWidget, OO.ui.Widget );

/* Events */

/**
 * @event change
 *
 * A change event is emitted when the annotation value of the input changes.
 *
 * @param {ve.dm.LinkAnnotation|null} annotation
 */

/* Static Methods */

/**
 * Get an annotation from the current text value
 *
 * @static
 * @param {string} value Text value
 * @return {ve.dm.LinkAnnotation|null} Link annotation
 */
ve.ui.LinkAnnotationWidget.static.getAnnotationFromText = function ( value ) {
	var href = value.trim();

	// Keep annotation in sync with value
	if ( href === '' ) {
		return null;
	} else {
		return new ve.dm.LinkAnnotation( {
			type: 'link',
			attributes: {
				href: href
			}
		} );
	}
};

/**
 * Get a text value for the current annotation
 *
 * @static
 * @param {ve.dm.LinkAnnotation|null} annotation Link annotation
 */
ve.ui.LinkAnnotationWidget.static.getTextFromAnnotation = function ( annotation ) {
	return annotation ? annotation.getHref() : '';
};

/* Methods */

/**
 * Create a text input widget to be used by the annotation widget
 *
 * @param {Object} [config] Configuration options
 * @return {OO.ui.TextInputWidget} Text input widget
 */
ve.ui.LinkAnnotationWidget.prototype.createInputWidget = function () {
	return new OO.ui.TextInputWidget( { validate: 'non-empty' } );
};

/**
 * @inheritdoc
 */
ve.ui.LinkAnnotationWidget.prototype.setDisabled = function () {
	// Parent method
	ve.ui.LinkAnnotationWidget.super.prototype.setDisabled.apply( this, arguments );

	this.text.setDisabled( this.isDisabled() );
};

/**
 * Handle value-changing events from the text input
 *
 * @method
 */
ve.ui.LinkAnnotationWidget.prototype.onTextChange = function ( value ) {
	var isExt,
		widget = this;

	// RTL/LTR check
	// TODO: Make this work properly
	if ( $( 'body' ).hasClass( 'rtl' ) ) {
		isExt = ve.init.platform.getExternalLinkUrlProtocolsRegExp().test( value.trim() );
		// If URL is external, flip to LTR. Otherwise, set back to RTL
		this.text.setRTL( !isExt );
	}

	this.text.isValid().done( function ( valid ) {
		// Keep annotation in sync with value
		widget.setAnnotation( valid ? widget.constructor.static.getAnnotationFromText( value ) : null, true );
	} );
};

/**
 * Sets the annotation value.
 *
 * The input value will automatically be updated.
 *
 * @method
 * @param {ve.dm.LinkAnnotation|null} annotation Link annotation
 * @param {boolean} [fromText] Annotation was generated from text input
 * @chainable
 */
ve.ui.LinkAnnotationWidget.prototype.setAnnotation = function ( annotation, fromText ) {
	if ( ve.compare(
			annotation ? annotation.getComparableObject() : {},
			this.annotation ? this.annotation.getComparableObject() : {}
	) ) {
		// No change
		return this;
	}

	this.annotation = annotation;

	// If this method was triggered by a change to the text input, leave it alone.
	if ( !fromText ) {
		this.text.setValue( this.constructor.static.getTextFromAnnotation( annotation ) );
	}

	this.emit( 'change', this.annotation );

	return this;
};

/**
 * Gets the annotation value.
 *
 * @method
 * @return {ve.dm.LinkAnnotation} Link annotation
 */
ve.ui.LinkAnnotationWidget.prototype.getAnnotation = function () {
	return this.annotation;
};

/**
 * Get the hyperlink location.
 *
 * @return {string} Hyperlink location
 */
ve.ui.LinkAnnotationWidget.prototype.getHref = function () {
	return this.constructor.static.getTextFromAnnotation( this.annotation );
};
