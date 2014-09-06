/*!
 * VisualEditor user interface WikiaParameterPage class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* global mw */

/**
 * Wikia transclusion dialog template page.
 *
 * @class
 * @extends ve.ui.MWParameterPage
 *
 * @constructor
 * @param {ve.dm.MWParameterModel} parameter Template parameter
 * @param {string} name Unique symbolic name of page
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaParameterPage = function VeUiWikiaParameterPage( parameter, name, config ) {
	// Parent constructor
	ve.ui.WikiaParameterPage.super.call( this, parameter, name, config );

	// Properties
	this.template = parameter.getTemplate();
	this.templateInfoButton = new OO.ui.ButtonWidget( {
			'$': this.$,
			'frameless': true,
			'icon': 'arrow-circled',
			'label': ve.msg( 'wikia-visualeditor-dialog-transclusion-get-info', this.template.getSpec().getLabel() ),
			'tabIndex': -1,
			'classes': [ 've-ui-mwParameterPage-templateInfoButton' ]
		} )
		.connect( this, { 'click': 'onTemplateInfoButtonClick' } );

	// Initialization
	this.addButton.$element
		.addClass( 've-ui-mwParameterPage-addButton' )
		.after( this.templateInfoButton.$element );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaParameterPage, ve.ui.MWParameterPage );

/* Methods */

/**
 * Handles action when clicking template info button
 */
ve.ui.WikiaParameterPage.prototype.onTemplateInfoButtonClick = function () {
	window.open( new mw.Title( this.template.getTitle() ).getUrl() );
	ve.track( 'wikia', {
		'action': ve.track.actions.CLICK,
		'label': 'dialog-template-get-info'
	} );
};
