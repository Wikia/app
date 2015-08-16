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

ve.ui.WikiaInfoboxDialog.static.actions = [
	{
		action: 'apply',
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-apply' ),
		flags: 'primary'
	},
	{
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-cancel' ),
		flags: 'safe'
	}
];

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxDialog.prototype.getActionProcess = function ( action ) {
	if ( action === 'apply' ) {
		return new OO.ui.Process( function () {
			var surfaceModel = this.getFragment().getSurface();

			//check to be sure, user clicked on infobox so it always has to be an instance of MWTransclusionNode
			if ( this.selectedNode instanceof ve.dm.MWTransclusionNode ) {
				this.transclusionModel.updateTransclusionNode( surfaceModel, this.selectedNode );
			}

			this.close( { action: action } );
		}, this );
	}

	return ve.ui.WikiaInfoboxDialog.super.prototype.getActionProcess.call( this, action );
};

ve.ui.WikiaInfoboxDialog.prototype.getSetupProcess = function ( data ) {

	data = data || {};
	this.data = data;

	return ve.ui.WikiaInfoboxDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			this.transclusionModel = new ve.dm.WikiaTransclusionModel();

			// Load existing infobox template
			this.transclusionModel
				.load( ve.copy( this.selectedNode.getAttribute( 'mw' ) ) )
				.done( this.initializeTemplateParameters.bind( this ) );
		}, this );

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

	this.infoboxTemplate.addUnusedParameters();
	this.fullParamsList = this.infoboxTemplate.spec.params;
	this.showItems();
};

ve.ui.WikiaInfoboxDialog.prototype.showItems = function () {
	var key,
		obj,
		tab = [];

	this.initializeLayout();
	for ( key in this.fullParamsList ) {
		if ( this.fullParamsList.hasOwnProperty( key ) ) {
			obj = this.fullParamsList[key];
			if ( obj.type === 'data' ) {
				tab.push(this.showDataItem( obj ));
			}
		}
	}

	this.bookletLayout.addPages( tab, 0);
}

ve.ui.WikiaInfoboxDialog.prototype.showDataItem = function ( obj ) {
	var param,
		template;

	template = this.transclusionModel.getParts()[0];
	param = template.getParameter(obj.name);

	return new ve.ui.WikiaParameterPage( param, param.name, { $: this.$ } );
};

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

};

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxDialog.prototype.getBodyHeight = function () {
	return 400;
};

/**
 * Configuration for booklet layout.
 *
 * @static
 * @property {Object}
 * @inheritable
 */
ve.ui.WikiaInfoboxDialog.static.bookletLayoutConfig = {
	continuous: true,
	outlined: false,
	autoFocus: false
};

ve.ui.windowFactory.register( ve.ui.WikiaInfoboxDialog );
