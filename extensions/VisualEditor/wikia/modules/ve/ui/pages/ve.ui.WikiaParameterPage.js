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
	var paramName = parameter.getName(),
		paramType;

	// Parent constructor
	ve.ui.WikiaParameterPage.super.call( this, parameter, name, config );

	paramType = this.spec.params && this.spec.params[paramName] && this.spec.params[paramName]['type'];

	if (paramType === 'image') {
		this.uploadImageButton = new OO.ui.ButtonWidget( {
			$: this.$,
			framed: true,
			icon: 'upload',
			label: ve.msg( 'visualeditor-dialog-transclusion-upload-image' )
		} )
			.connect( this, { click: function () {
				ve.ui.commandRegistry.registry.wikiaImageInsert.execute(ve.init.target.getSurface());
			} } );

		this.$field
			.append(this.uploadImageButton.$element);
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
