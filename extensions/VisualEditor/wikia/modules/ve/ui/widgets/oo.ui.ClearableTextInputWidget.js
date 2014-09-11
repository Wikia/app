/**
 * Text input widget with clear button.
 *
 * @class
 * @abstract
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {string} [placeholder] Placeholder text
 * @cfg {string} [icon] Symbolic name of icon
 * @throws Will throw an error if a multi-line config option is passed
 */
OO.ui.ClearableTextInputWidget = function OoUiClearableTextInputWidget( config ) {
	// Config intialization
	config = config || {};
	if ( config.multiline ) {
		throw 'Multi-line input not supported';
	}

	// Parent constructor
	OO.ui.ClearableTextInputWidget.super.call( this, config );

	// Properties
	this.$clearButton = this.$( '<div>' )
		.addClass( 'oo-ui-clearableTextInputWidget-clearButton' );

	// Events
	this.$clearButton.on( {
		'click': OO.ui.bind( this.onClearButtonClick, this )
	} );
	this.connect( this, { 'change': 'onClearableTextInputChange' } );

	// Initialization
	this.$element
		.addClass( 'oo-ui-clearableTextInputWidget' )
		.append( this.$clearButton );
};

/* Inheritance */

OO.inheritClass( OO.ui.ClearableTextInputWidget, OO.ui.TextInputWidget );

/* Methods */

/**
 * Handle clear button click event.
 */
OO.ui.ClearableTextInputWidget.prototype.onClearButtonClick = function () {
	this.setValue( '' );
	this.$clearButton.hide();
};

/**
 * Handle input change event.
 */
OO.ui.ClearableTextInputWidget.prototype.onClearableTextInputChange = function () {
	if ( this.getValue().length > 0 ) {
		this.$clearButton.show();
	} else {
		this.$clearButton.hide();
	}
};
