/*!
 * VisualEditor UserInterface InputWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.InputWidget object.
 *
 * @class
 * @abstract
 * @extends ve.ui.Widget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {string} [name=''] HTML input name
 * @cfg {string} [value=''] Input value
 * @cfg {boolean} [readOnly=false] Prevent changes
 */
ve.ui.InputWidget = function VeUiInputWidget( config ) {
	// Config intialization
	config = ve.extendObject( { 'readOnly': false }, config );

	// Parent constructor
	ve.ui.Widget.call( this, config );

	// Properties
	this.$input = this.getInputElement( config );
	this.value = '';
	this.readonly = false;

	// Events
	this.$input.on( 'keydown mouseup cut paste change input select', ve.bind( this.onEdit, this ) );

	// Initialization
	this.$input.attr( 'name', config.name );
	this.setReadOnly( config.readOnly );
	this.$.addClass( 've-ui-inputWidget' ).append( this.$input );
	this.setValue( config.value );
};

/* Inheritance */

ve.inheritClass( ve.ui.InputWidget, ve.ui.Widget );

/* Events */

/**
 * @event change
 * @param value
 */

/* Methods */

/**
 * Get input element.
 *
 * @method
 * @param {Object} [config] Configuration options
 * @returns {jQuery} Input element
 */
ve.ui.InputWidget.prototype.getInputElement = function () {
	return this.$$( '<input>' );
};

/**
 * Handle potentially value-changing events.
 *
 * @method
 * @param {jQuery.Event} e Key down, mouse up, cut, paste, change, input, or select event
 */
ve.ui.InputWidget.prototype.onEdit = function () {
	if ( !this.disabled ) {
		// Allow the stack to clear so the value will be updated
		setTimeout( ve.bind( function () {
			this.setValue( this.$input.val() );
		}, this ) );
	}
};

/**
 * Get the value of the input.
 *
 * @method
 * @returns {string} Input value
 */
ve.ui.InputWidget.prototype.getValue = function () {
	return this.value;
};

/**
 * Sets the direction of the current input, either RTL or LTR
 *
 * @method
 * @param {boolean} isRTL
 */
ve.ui.InputWidget.prototype.setRTL = function ( isRTL ) {
	if ( isRTL ) {
		this.$input.removeClass( 've-ui-ltr' );
		this.$input.addClass( 've-ui-rtl' );
	} else {
		this.$input.removeClass( 've-ui-rtl' );
		this.$input.addClass( 've-ui-ltr' );
	}
};

/**
 * Set the value of the input.
 *
 * @method
 * @param {string} value New value
 * @emits change
 * @chainable
 */
ve.ui.InputWidget.prototype.setValue = function ( value ) {
	var domValue = this.$input.val();
	value = this.sanitizeValue( value );
	if ( this.value !== value ) {
		this.value = value;
		// Only update the DOM if we must
		if ( domValue !== this.value ) {
			this.$input.val( value );
		}
		this.emit( 'change', this.value );
	}
	return this;
};

/**
 * Sanitize incoming value.
 *
 * Ensures value is a string, and converts undefined and null to empty strings.
 *
 * @method
 * @param {string} value Original value
 * @returns {string} Sanitized value
 */
ve.ui.InputWidget.prototype.sanitizeValue = function ( value ) {
	return value === undefined || value === null ? '' : String( value );
};

/**
 * Check if the widget is read-only.
 *
 * @method
 * @param {boolean} Input is read-only
 */
ve.ui.InputWidget.prototype.isReadOnly = function () {
	return this.readOnly;
};

/**
 * Set the read-only state of the widget.
 *
 * This should probably change the widgets's appearance and prevent it from being used.
 *
 * @method
 * @param {boolean} state Make input read-only
 * @chainable
 */
ve.ui.InputWidget.prototype.setReadOnly = function ( state ) {
	this.readOnly = !!state;
	this.$input.prop( 'readonly', this.readOnly );
	return this;
};
