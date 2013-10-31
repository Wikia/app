/*!
 * VisualEditor UserInterface TextInputWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.TextInputWidget object.
 *
 * @class
 * @extends ve.ui.InputWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {string} [placeholder] Placeholder text
 * @cfg {string} [icon] Symbolic name of icon
 * @cfg {boolean} [multiline=false] Allow multiple lines of text
 */
ve.ui.TextInputWidget = function VeUiTextInputWidget( config ) {
	config = config || {};

	// Parent constructor
	ve.ui.InputWidget.call( this, config );

	// Properties
	this.pending = 0;
	this.multiline = !!config.multiline;

	// Events
	this.$input.on( 'keypress', ve.bind( this.onKeyPress, this ) );

	// Initialization
	this.$.addClass( 've-ui-textInputWidget' );
	if ( config.icon ) {
		this.$.addClass( 've-ui-textInputWidget-decorated' );
		this.$.append(
			$( '<span>' )
				.addClass( 've-ui-textInputWidget-icon ve-ui-icon-' + config.icon )
				.mousedown( ve.bind( function () {
					this.$input.focus();
					return false;
				}, this ) )
		);
	}
	if ( config.placeholder ) {
		this.$input.attr( 'placeholder', config.placeholder );
	}
};

/* Inheritance */

ve.inheritClass( ve.ui.TextInputWidget, ve.ui.InputWidget );

/* Events */

/**
 * User presses enter inside the text box.
 *
 * Not called if input is multiline.
 *
 * @event enter
 */

/* Methods */

/**
 * Handles key press events.
 *
 * @param {jQuery.Event} e Key press event
 * @emits enter If enter key is pressed and input is not multiline
 */
ve.ui.TextInputWidget.prototype.onKeyPress = function ( e ) {
	if ( e.which === ve.Keys.ENTER && !this.multiline ) {
		this.emit( 'enter' );
	}
};

/**
 * Get input element.
 *
 * @method
 * @param {Object} [config] Configuration options
 * @returns {jQuery} Input element
 */
ve.ui.TextInputWidget.prototype.getInputElement = function ( config ) {
	return config.multiline ? this.$$( '<textarea>' ) : this.$$( '<input>' ).attr( 'type', 'text' );
};

/* Methods */

/**
 * Checks if input is pending.
 *
 * @method
 * @returns {boolean} Input is pending
 */
ve.ui.TextInputWidget.prototype.isPending = function () {
	return !!this.pending;
};

/**
 * Increases the pending stack.
 *
 * @method
 * @chainable
 */
ve.ui.TextInputWidget.prototype.pushPending = function () {
	this.pending++;
	this.$.addClass( 've-ui-textInputWidget-pending' );
	this.$input.addClass( 've-ui-texture-pending' );
	return this;
};

/**
 * Reduces the pending stack.
 *
 * Clamped at zero.
 *
 * @method
 * @chainable
 */
ve.ui.TextInputWidget.prototype.popPending = function () {
	this.pending = Math.max( 0, this.pending - 1 );
	if ( !this.pending ) {
		this.$.removeClass( 've-ui-textInputWidget-pending' );
		this.$input.removeClass( 've-ui-texture-pending' );
	}
	return this;
};
