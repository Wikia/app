/*!
 * VisualEditor UserInterface WikiaTemplateGetInfoWidget class.
 */

/* global mw */

/**
 * @class
 * @extends OO.ui.Widget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaTemplateGetInfoWidget = function VeUiWikiaTemplateGetInfoWidget( config ) {

	// Parent constructor
	ve.ui.WikiaTemplateGetInfoWidget.super.call( this, config );

	// Properties
	this.template = config.template;
	this.templateInfoButton = new OO.ui.ButtonWidget( {
			'$': this.$,
			'frameless': true,
			'icon': 'arrow-circled',
			'label': ve.msg( 'wikia-visualeditor-dialog-transclusion-get-info', this.template.getSpec().getLabel() ),
			'tabIndex': -1,
			'classes': [ 've-ui-wikiaTemplateGetInfoWidget-templateInfoButton' ]
		} )
		.connect( this, { 'click': 'onTemplateInfoButtonClick' } );

	// Events

	// Initialization
	this.$element.append( this.templateInfoButton.$element );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaTemplateGetInfoWidget, OO.ui.Widget );

/* Methods */

/**
 * Handles action when clicking template info button
 */
ve.ui.WikiaTemplateGetInfoWidget.prototype.onTemplateInfoButtonClick = function () {
	window.open( new mw.Title( this.template.getTitle() ).getUrl() );
	ve.track( 'wikia', {
		'action': ve.track.actions.CLICK,
		'label': 'dialog-template-get-info'
	} );
};
