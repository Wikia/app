/*!
 * VisualEditor UserInterface WikiaSingleMediaQueryWidget class.
 */

/**
 * @class
 * @extends OO.ui.Widget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @param {string|jQuery} [config.placeholder] Placeholder text for query input
 * @param {string} [config.value] Initial query input value
 */
ve.ui.WikiaSingleMediaQueryWidget = function VeUiWikiaSingleMediaQueryWidget( config ) {
	// Configuration intialization
	config = config || {};

	// Parent constructor
	ve.ui.WikiaSingleMediaQueryWidget.super.call( this, config );

	// Properties
	this.input = new OO.ui.ClearableTextInputWidget( {
		'$': this.$,
		'icon': 'search',
		'placeholder': config.placeholder,
		'value': config.value
	} );

	// Events

	// Initialization
	this.$element
		.addClass( 've-ui-wikiaSingleMediaQueryWidget' )
		.append( this.input.$element );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaSingleMediaQueryWidget, OO.ui.Widget );

/* Events */

/**
 * @event requestMedia
 * @param {string} value The query input value.
 */

/**
 * @event requestMediaDone
 * @param {Object} data The response Object from the server.
 */

/* Methods */
