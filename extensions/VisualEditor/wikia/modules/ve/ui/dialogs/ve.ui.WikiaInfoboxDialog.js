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
	var parts = this.transclusionModel.getParts();
	this.infoboxTemplate = parts[0];

	if ( this.infoboxTemplate instanceof ve.dm.MWTemplateModel ) {
		this.infoboxTemplate.addPromptedParameters();
	}
	this.fullParamsList = this.infoboxTemplate.spec.params;
	console.log("this.fullParamsList:", this.fullParamsList);
	this.showItem();
};

ve.ui.WikiaInfoboxDialog.prototype.showItem = function () {
	var param,
		page,
		template,
		key,
		val;
	key = 'dianaaaa';
	this.initializeLayout();
	template = new ve.dm.WikiaTemplateModel( this.transclusionModel, this.infoboxTemplate.target );
	// Get param value with fallback to default. Is there a ready method to do it?
	val = this.fullParamsList[ key ].wt ? this.fullParamsList[ key ].wt : this.fullParamsList[ key ].default;
	param = new ve.dm.MWParameterModel( template, key, val );

	page = new ve.ui.WikiaParameterPage( param, param.getId(), { $: this.$ } );

	this.bookletLayout.addPages( [ page ], this.transclusionModel.getIndex( param ) );
}

ve.ui.WikiaInfoboxDialog.prototype.initializeLayout = function () {
	this.panels = new OO.ui.StackLayout( { $: this.$ } );

	this.bookletLayout = new OO.ui.BookletLayout(
		ve.extendObject(
			{ $: this.$ },
			this.constructor.static.bookletLayoutConfig
		)
	);

	this.$body.append( this.panels.$element );
	this.panels.addItems( [ this.bookletLayout ] );

}

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxDialog.prototype.getBodyHeight = function () {
	return 400;
};

ve.ui.windowFactory.register( ve.ui.WikiaInfoboxDialog );
