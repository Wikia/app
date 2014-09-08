/*!
 * VisualEditor UserInterface WikiaTemplateOptionWidget class.
 */

/**
 * @class
 * @extends OO.ui.OptionWidget
 *
 * @constructor
 * @param {Mixed} data Option data
 * @param {Object} [config] Configuration options
 * @cfg {number} [size] Media thumbnail size
 */
ve.ui.WikiaTemplateOptionWidget = function VeUiWikiaMapOptionWidget( data, config ) {
	// Parent constructor
	ve.ui.WikiaTemplateOptionWidget.super.call( this, data, config );

	// Properties
	this.$appears = this.$( '<div>' )
		.addClass( 've-ui-wikiaTemplateOptionWidget-appears' );

	// Initialization
	if ( config.appears ) {
		this.setAppears( config.appears );
	}
	this.$element
		.addClass( 've-ui-wikiaTemplateOptionWidget' )
		.append( this.$appears );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaTemplateOptionWidget, OO.ui.OptionWidget );

/* Methods */

/**
 * Set the value of the appears element
 *
 * @param {string} value Value to show
 */
ve.ui.WikiaTemplateOptionWidget.prototype.setAppears = function ( value ) {
	this.$appears.text( ve.msg( 'wikia-visualeditor-wikiatemplateoptionwidget-appears', value ) );
};
