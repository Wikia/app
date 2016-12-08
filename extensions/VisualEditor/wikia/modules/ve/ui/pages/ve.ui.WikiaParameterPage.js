/*!
 * VisualEditor user interface WikiaParameterPage class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

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

	if (this.spec.params && this.spec.params[name] && this.spec.params[name]['type'] === 'image') {
		// TODO display something nice
		this.statusIndicator
			.setIndicator( 'alert' )
			.setIndicatorTitle(
				'This is an image'
			);
	}

	// Properties
	this.templateGetInfoWidget = new ve.ui.WikiaTemplateGetInfoWidget( { template: parameter.getTemplate() } );

	// Initialization
	this.addButton.$element
		.addClass( 've-ui-mwParameterPage-addButton' )
		.after( this.templateGetInfoWidget.$element );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaParameterPage, ve.ui.MWParameterPage );
