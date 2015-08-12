/*
 * VisualEditor user interface WikiaInfoboxDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* global mw */

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

	// Properties
	this.transclusionModel = null;
	this.loaded = false;
	this.preventReselection = false;

	this.confirmOverlay = new ve.ui.Overlay( { classes: ['ve-ui-overlay-global'] } );
	this.confirmDialogs = new ve.ui.WindowManager( { factory: ve.ui.windowFactory, isolate: true } );
	this.confirmOverlay.$element.append( this.confirmDialogs.$element );
	$( 'body' ).append( this.confirmOverlay.$element );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaInfoboxDialog, ve.ui.NodeDialog );

/* Static Properties */

ve.ui.WikiaInfoboxDialog.static.name = 'infoboxTemplate';

ve.ui.WikiaInfoboxDialog.static.icon = 'template';

ve.ui.WikiaInfoboxDialog.static.modelClasses = [ ve.dm.MWTransclusionNode ];

ve.ui.WikiaInfoboxDialog.static.actions = [
	{
		action: 'apply',
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-apply' ),
		flags: [ 'progressive', 'primary' ],
		modes: 'edit'
	},
	{
		action: 'insert',
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-insert' ),
		flags: [ 'primary', 'constructive' ],
		modes: 'insert'
	},
	{
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-cancel' ),
		flags: 'safe',
		modes: [ 'insert', 'edit' ]
	}
];

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxDialog.prototype.getBodyHeight = function () {
	return 400;
};

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxDialog.prototype.getSelectedNode = function ( data ) {
	var selectedNode = ve.ui.WikiaInfoboxDialog.super.prototype.getSelectedNode.call( this );

	// Data initialization
	data = data || {};

	// Require template to match if specified
	if ( selectedNode && data.template && !selectedNode.isSingleTemplate( data.template ) ) {
		return null;
	}

	return selectedNode;
};

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.WikiaInfoboxDialog.super.prototype.initialize.call( this );

	// Initialization
	this.$content.addClass( 've-ui-mwInfoboxDialog' );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxDialog.prototype.getActionProcess = function ( action ) {
	if ( action === 'apply' || action === 'insert' ) {
	//return new OO.ui.Process();
	}

	return ve.ui.WikiaInfoboxDialog.super.prototype.getActionProcess.call( this, action );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxDialog.prototype.getSetupProcess = function ( data ) {
	data = data || {};
	return ve.ui.WikiaInfoboxDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			var template, promise;

			// Initialization
			if ( !this.selectedNode ) {
				this.actions.setMode( 'insert' );
				if ( data.template ) {
					// New specified template
					template = ve.dm.MWTemplateModel.newFromName(
						this.transclusionModel, data.template
					);
					promise = this.transclusionModel.addPart( template ).done(
						this.initializeNewTemplateParameters.bind( this )
					);
				} else {
					// New template placeholder
					promise = this.transclusionModel.addPart(
						new ve.dm.MWTemplatePlaceholderModel( this.transclusionModel )
					);
				}
			} else {
				this.actions.setMode( 'edit' );
				// Load existing template
			}
			this.actions.setAbilities( { apply: false, insert: false } );
			//this.pushPending();
			//promise.always( this.onTransclusionReady.bind( this ) );
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxDialog.prototype.getReadyProcess = function ( data ) {
	return ve.ui.MWTemplateDialog.super.prototype.getReadyProcess.call( this, data )
		.next( function () {
			// TODO: Uncomment this when OOUI is updated so .focus() on an empty booklet doesn't crash
			//this.bookletLayout.focus();
		}, this );
};

ve.ui.windowFactory.register( ve.ui.WikiaInfoboxDialog );
