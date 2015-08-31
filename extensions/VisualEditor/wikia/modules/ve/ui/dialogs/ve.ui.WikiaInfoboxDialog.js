/*
 * VisualEditor user interface WikiaInfoboxDialog class.
 */

/**
 * Dialog for inserting and editing Wikia Infobox templates.
 *
 * @class
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
			this.transclusionModel.updateTransclusionNode( surfaceModel, this.selectedNode );
			this.close( { action: action } );
		}, this );
	}

	return ve.ui.WikiaInfoboxDialog.super.prototype.getActionProcess.call( this, action );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxDialog.prototype.getSetupProcess = function ( data ) {
	data = data || {};
	this.data = data;

	return ve.ui.WikiaInfoboxDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			this.transclusionModel = new ve.dm.WikiaTransclusionModel();
			this.transclusionModel.setIsInfobox( true );

			// Load existing infobox template
			this.transclusionModel
				.load( ve.copy( this.selectedNode.getAttribute( 'mw' ) ) )
				.done( this.initializeTemplateParameters.bind( this ) );
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.WikiaInfoboxDialog.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			// Cleanup
			this.$element.removeClass( 've-ui-mwInfoboxDialog-ready' );
			this.transclusionModel.disconnect( this );
			this.transclusionModel.abortRequests();
			this.transclusionModel = null;
			this.bookletLayout.clearPages();
			this.content = null;
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

/**
 * Make sure all infobox template params will be shown
 */
ve.ui.WikiaInfoboxDialog.prototype.initializeTemplateParameters = function () {
	var parts = this.transclusionModel.getParts();
	this.infoboxTemplate = parts[0];

	this.infoboxTemplate.addUnusedParameters();
	this.fullParamsList = this.infoboxTemplate.spec.params;
	this.showItems();
};

/**
 * Prepare layout and show list of all infobox params on it
 */
ve.ui.WikiaInfoboxDialog.prototype.showItems = function () {
	var key,
		obj,
		templateGetInfoWidget,
		zeroStatePage,
		tab = [];

	this.initializeLayout();
	if ( Object.keys( this.fullParamsList ).length > 0 ) {
		for ( key in this.fullParamsList ) {
			if ( this.fullParamsList.hasOwnProperty( key ) ) {
				obj = this.fullParamsList[key];
				//TODO: add displaying different inputs according to type eg.data, image, group element
				tab.push( this.showDataItem( obj ) );
			}
		}
		this.bookletLayout.addPages( tab, 0 );
	} else {
		this.$content.addClass( 've-ui-wikiaInfoboxDialog-zeroState' );

		// Content
		zeroStatePage = new OO.ui.PageLayout( 'zeroState', {} );
		templateGetInfoWidget = new ve.ui.WikiaTemplateGetInfoWidget( { template: this.infoboxTemplate } );
		zeroStatePage.$element
			.text( ve.msg( 'wikia-visualeditor-dialog-transclusion-zerostate') )
			.append( templateGetInfoWidget.$element );
		this.bookletLayout.addPages( [zeroStatePage] );

		ve.track( 'wikia', {
			action: ve.track.actions.OPEN,
			label: 'dialog-infobox-no-parameters'
		} );
	}
};

/**
 * Show a single infobox param element
 *
 * @param {Object} obj item to show
 */
ve.ui.WikiaInfoboxDialog.prototype.showDataItem = function ( obj ) {
	var template = this.transclusionModel.getParts()[0],
		param = template.getParameter( obj.name );

	return new ve.ui.WikiaParameterPage( param, param.name, { $: this.$ } );
};

/**
 * Initialize booklet layout and add to dialog body
 */
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
