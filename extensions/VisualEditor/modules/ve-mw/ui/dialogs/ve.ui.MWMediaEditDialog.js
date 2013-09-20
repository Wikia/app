/*!
 * VisualEditor user interface MWMediaEditDialog class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for editing MediaWiki media objects.
 *
 * @class
 * @extends ve.ui.MWDialog
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Config options
 */
ve.ui.MWMediaEditDialog = function VeUiMWMediaEditDialog( surface, config ) {
	// Parent constructor
	ve.ui.MWDialog.call( this, surface, config );

	// Properties
	this.captionNode = null;
};

/* Inheritance */

ve.inheritClass( ve.ui.MWMediaEditDialog, ve.ui.MWDialog );

/* Static Properties */

ve.ui.MWMediaEditDialog.static.name = 'mediaEdit';

ve.ui.MWMediaEditDialog.static.titleMessage = 'visualeditor-dialog-media-title';

ve.ui.MWMediaEditDialog.static.icon = 'picture';

ve.ui.MWMediaEditDialog.static.toolbarGroups = [
	{ 'include': [ 'undo', 'redo' ] },
	{ 'include': [ 'bold', 'italic', 'link', 'clear' ] },
	{
		'include': '*',
		'exclude': [
			{ 'group': 'format' },
			{ 'group': 'structure' },
			'referenceList'
		]
	}
];

ve.ui.MWMediaEditDialog.static.surfaceCommands = [
	'undo', 'redo', 'bold', 'italic', 'link', 'clear'
];

/* Methods */

/** */
ve.ui.MWMediaEditDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWDialog.prototype.initialize.call( this );

	// Properties
	this.editPanel = new ve.ui.PanelLayout( {
		'$$': this.frame.$$,
		'padded': true,
		'scrollable': true
	} );
	this.captionFieldset = new ve.ui.FieldsetLayout( {
		'$$': this.frame.$$,
		'label': ve.msg( 'visualeditor-dialog-media-content-section' ),
		'icon': 'parameter'
	} );
	this.applyButton = new ve.ui.ButtonWidget( {
		'$$': this.$$,
		'label': ve.msg( 'visualeditor-dialog-action-apply' ),
		'flags': ['primary']
	} );

	// Events
	this.applyButton.connect( this, { 'click': [ 'close', 'apply' ] } );

	// Initialization
	this.editPanel.$.append( this.captionFieldset.$ );
	this.$body.append( this.editPanel.$ );
	this.$foot.append( this.applyButton.$ );
};

/** */
ve.ui.MWMediaEditDialog.prototype.onOpen = function () {
	var data, doc = this.surface.getModel().getDocument();

	// Parent method
	ve.ui.MWDialog.prototype.onOpen.call( this );

	// Properties
	this.captionNode = this.surface.getView().getFocusedNode().getModel().getCaptionNode();
	if ( this.captionNode && this.captionNode.getLength() > 0 ) {
		data = doc.getData( this.captionNode.getRange(), true );
	} else {
		data = [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			{ 'type': '/paragraph' }
		];
	}

	this.captionSurface = new ve.ui.SurfaceWidget(
		new ve.dm.ElementLinearData( doc.getStore(), data ),
		{
			'$$': this.frame.$$,
			'tools': this.constructor.static.toolbarGroups,
			'commands': this.constructor.static.surfaceCommands
		}
	);

	// Initialization
	this.captionFieldset.$.append( this.captionSurface.$ );
	this.captionSurface.initialize();
};

/** */
ve.ui.MWMediaEditDialog.prototype.onClose = function ( action ) {
	var data, doc, surfaceModel = this.surface.getModel();

	// Parent method
	ve.ui.MWDialog.prototype.onClose.call( this );

	if ( action === 'apply' ) {
		data = this.captionSurface.getContent();
		doc = surfaceModel.getDocument();
		if ( this.captionNode ) {
			// Replace the contents of the caption
			surfaceModel.getFragment( this.captionNode.getRange(), true ).insertContent( data );
		} else {
			// Insert a new caption at the beginning of the image node
			surfaceModel.getFragment()
				.adjustRange( 1 )
				.collapseRangeToStart()
				.insertContent(
					[ { 'type': 'mwImageCaption' } ]
						.concat( data )
						.concat( [ { 'type': '/mwImageCaption' } ] )
				);
		}
	}

	// Cleanup
	this.captionSurface.destroy();
	this.captionSurface = null;
	this.captionNode = null;
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.MWMediaEditDialog );
