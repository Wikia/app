/*!
 * VisualEditor user interface WikiaTemplateGetInfoPage class.
 */

/* global mw */

/**
 * Wikia template get info page.
 *
 * @class
 * @extends OO.ui.PageLayout
 *
 * @constructor
 */
ve.ui.WikiaTemplateGetInfoPage = function VeUiWikiaTemplateGetInfoPage( spec, name, config ) {
	// Parent constructor
	ve.ui.WikiaTemplateGetInfoPage.super.call( this, name, config );

	// Properties
	this.spec = spec;
	this.templateInfoButton = new OO.ui.ButtonWidget( {
			'$': this.$,
			'frameless': true,
			'icon': 'arrow-circled',
			'label': ve.msg( 'wikia-visualeditor-dialog-transclusion-get-info', name ),
			'tabIndex': -1,
			'classes': [ 've-ui-mwParameterPage-templateInfoButton' ]
		} )
		.connect( this, { 'click': 'onTemplateInfoButtonClick' } );

	// Initialization
	this.$element
		.addClass( 've-ui-wikiaTemplateGetInfoPage' )
		.append( this.templateInfoButton.$element );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaTemplateGetInfoPage, OO.ui.PageLayout );

/* Methods */

/**
 * Handles action when clicking template info button
 */
ve.ui.WikiaTemplateGetInfoPage.prototype.onTemplateInfoButtonClick = function () {
	window.open( new mw.Title( this.spec.getTemplate().getTitle() ).getUrl() );
	ve.track( 'wikia', {
		'action': ve.track.actions.CLICK,
		'label': 'dialog-template-get-info'
	} );
};
