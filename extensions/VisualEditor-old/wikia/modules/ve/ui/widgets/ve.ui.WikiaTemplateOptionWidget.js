/*!
 * VisualEditor UserInterface WikiaTemplateOptionWidget class.
 */

/**
 * @class
 * @extends OO.ui.DecoratedOptionWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {number} [size] Media thumbnail size
 */
ve.ui.WikiaTemplateOptionWidget = function VeUiWikiaMapOptionWidget( config ) {
	// Parent constructor
	ve.ui.WikiaTemplateOptionWidget.super.call( this, config );

	// Properties
	this.$appears = this.$( '<div>' )
		.addClass( 've-ui-wikiaTemplateOptionWidget-appears' );
	this.$gradient = this.$( '<div>' )
		.addClass( 've-ui-wikiaTemplateOptionWidget-gradient' );

	// Initialization
	if ( config.data.uses ) {
		this.setAppears( config.data.uses );
	}
	this.$element
		.addClass( 've-ui-wikiaTemplateOptionWidget' )
		.append( this.$appears );
	this.$label
		.append( this.$gradient );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaTemplateOptionWidget, OO.ui.DecoratedOptionWidget );

/* Methods */

/**
 * Set the value of the appears element
 *
 * @param {number} value Number of times the template appears
 */
ve.ui.WikiaTemplateOptionWidget.prototype.setAppears = function ( value ) {
	this.$appears.text( ve.msg( 'wikia-visualeditor-wikiatemplateoptionwidget-appears', value ) );
};
