/*
 * VisualEditor user interface WikiaInfoboxDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for inserting and editing Wikia Portable Infoboxes.
 *
 * @class
 * @abstract
 * @extends ve.ui.NodeDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaInfoboxDialog = function VeUiWikiaInfoboxDialog( config ) {
	// Parent constructor
	ve.ui.WikiaInfoboxDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaInfoboxDialog, ve.ui.NodeDialog );

/* Static Properties */

ve.ui.WikiaInfoboxDialog.static.name = 'wikiaInfobox';

ve.ui.WikiaInfoboxDialog.static.modelClasses = [ ve.dm.WikiaInfoboxTransclusionBlockNode ];

/* Methods */


/**
 * Intentionally empty. This is provided for Wikia extensibility.
 *
 * @method
 */
//ve.ui.WikiaInfoboxDialog.prototype.initializeTemplateParameters = function () {};

ve.ui.WikiaInfoboxDialog.prototype.getSetupProcess = function ( data ) {

	data = data || {};
	this.data = data;
	console.log(this);

	return ve.ui.WikiaInfoboxDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			this.transclusionModel = new ve.dm.WikiaTransclusionModel();

			// Load existing infobox template
			this.transclusionModel
				.load( ve.copy( this.selectedNode.getAttribute( 'mw' ) ) )
				.done( this.initializeTemplateParameters.bind( this ) );
		}, this);

};

/**
 * Handle the transclusion being ready to use.
 */
ve.ui.WikiaInfoboxDialog.prototype.onTransclusionReady = function () {
	this.loaded = true;
	this.$element.addClass( 've-ui-mwInfoboxDialog-ready' );
	this.popPending();
};

ve.ui.WikiaInfoboxDialog.prototype.initializeTemplateParameters = function () {
	var parts = this.transclusionModel.getParts(),
		infoboxTemplate = parts[0];

	if ( infoboxTemplate instanceof ve.dm.MWTemplateModel ) {
		infoboxTemplate.addPromptedParameters();
	}
	this.fullParamsList = infoboxTemplate.spec.params;
	console.log("this.fullParamsList:", this.fullParamsList);
};

ve.ui.windowFactory.register( ve.ui.WikiaInfoboxDialog );
