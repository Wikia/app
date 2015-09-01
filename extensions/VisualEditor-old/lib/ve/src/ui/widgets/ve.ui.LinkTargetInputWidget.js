/*!
 * VisualEditor UserInterface LinkTargetInputWidget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Creates an ve.ui.LinkTargetInputWidget object.
 *
 * @class
 * @extends OO.ui.TextInputWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.LinkTargetInputWidget = function VeUiLinkTargetInputWidget( config ) {
	// Parent constructor
	OO.ui.TextInputWidget.call( this, $.extend( {
		validate: /^(https?:\/\/)?[\w-]+(\.[\w-]+)+\.?(:\d+)?(\/\S*)?/gi
	}, config ) );

	// Properties
	this.annotation = null;

	// Initialization
	this.$element.addClass( 've-ui-linkTargetInputWidget' );

	// Default RTL/LTR check
	// Has to use global $() instead of this.$() because only the main document's <body> has
	// the 'rtl' class; inspectors and dialogs have oo-ui-rtl instead.
	if ( $( 'body' ).hasClass( 'rtl' ) ) {
		this.$input.addClass( 'oo-ui-rtl' );
	}
};

/* Inheritance */

OO.inheritClass( ve.ui.LinkTargetInputWidget, OO.ui.TextInputWidget );

/* Methods */

/**
 * Handle value-changing events
 *
 * Overrides onEdit to perform RTL test based on the typed URL
 *
 * @method
 */
ve.ui.LinkTargetInputWidget.prototype.onEdit = function () {
	var widget = this;
	if ( !this.disabled ) {

		// Allow the stack to clear so the value will be updated
		setTimeout( function () {
			// RTL/LTR check
			// Has to use global $() instead of this.$() because only the main document's <body> has
			// the 'rtl' class; inspectors and dialogs have oo-ui-rtl instead.
			if ( $( 'body' ).hasClass( 'rtl' ) ) {
				var isExt = ve.init.platform.getExternalLinkUrlProtocolsRegExp()
					.test( widget.$input.val() );
				// If URL is external, flip to LTR. Otherwise, set back to RTL
				widget.setRTL( !isExt );
			}
			widget.setValue( widget.$input.val() );
		} );
	}
};

/**
 * Set the value of the input.
 *
 * Overrides setValue to keep annotations in sync.
 *
 * @method
 * @param {string} value New value
 */
ve.ui.LinkTargetInputWidget.prototype.setValue = function ( value ) {
	// Keep annotation in sync with value
	value = this.cleanUpValue( value );
	if ( value === '' ) {
		this.annotation = null;
	} else {
		this.setAnnotation( new ve.dm.LinkAnnotation( {
			type: 'link',
			attributes: {
				href: value
			}
		} ) );
	}

	// Parent method
	OO.ui.TextInputWidget.prototype.setValue.call( this, value );
};

/**
 * Sets the annotation value.
 *
 * The input value will automatically be updated.
 *
 * @method
 * @param {ve.dm.LinkAnnotation} annotation Link annotation
 * @chainable
 */
ve.ui.LinkTargetInputWidget.prototype.setAnnotation = function ( annotation ) {
	this.annotation = annotation;

	// Parent method
	OO.ui.TextInputWidget.prototype.setValue.call(
		this, this.getTargetFromAnnotation( annotation )
	);

	return this;
};

/**
 * Gets the annotation value.
 *
 * @method
 * @returns {ve.dm.LinkAnnotation} Link annotation
 */
ve.ui.LinkTargetInputWidget.prototype.getAnnotation = function () {
	return this.annotation;
};

/**
 * Get the hyperlink location.
 *
 * @return {string} Hyperlink location
 */
ve.ui.LinkTargetInputWidget.prototype.getHref = function () {
	return this.getValue();
};

/**
 * Gets a target from an annotation.
 *
 * @method
 * @param {ve.dm.LinkAnnotation} annotation Link annotation
 * @returns {string} Target
 */
ve.ui.LinkTargetInputWidget.prototype.getTargetFromAnnotation = function ( annotation ) {
	if ( annotation instanceof ve.dm.LinkAnnotation ) {
		return annotation.getAttribute( 'href' );
	}
	return '';
};
