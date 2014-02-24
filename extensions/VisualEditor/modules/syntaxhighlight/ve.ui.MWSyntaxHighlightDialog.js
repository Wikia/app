/*!
 * VisualEditor user interface MWSyntaxHighlightDialog class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Document dialog.
 *
 * @class
 * @extends ve.ui.MWDialog
 *
 * @constructor
 * @param {OO.ui.WindowSet} windowSet Window set this dialog is part of
 * @param {Object} [config] Config options
 */
ve.ui.MWSyntaxHighlightDialog = function VeUiMWSyntaxHighlightDialog( windowSet, config ) {
	// Parent constructor
	ve.ui.MWDialog.call( this, windowSet, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWSyntaxHighlightDialog, ve.ui.MWDialog );

/* Static Properties */

ve.ui.MWSyntaxHighlightDialog.static.titleMessage = 'visualeditor-dialog-syntaxhighlight-title';

ve.ui.MWSyntaxHighlightDialog.static.icon = 'syntaxHighlight';

ve.ui.MWSyntaxHighlightDialog.static.name = 'mwSyntaxHighlight';

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWSyntaxHighlightDialog.prototype.initialize = function () {
	// Call parent method
	ve.ui.MWDialog.prototype.initialize.call( this );
	this.editPanel = new OO.ui.PanelLayout( {
		'$': this.$, 'scrollable': false, 'padded': false
	} );
	this.applyButton = new OO.ui.PushButtonWidget( {
		'$': this.$, 'label': ve.msg( 'visualeditor-dialog-action-apply' ), 'flags': ['primary']
	} );
	this.applyButton.connect( this, { 'click': [ 'close', { 'action': 'apply' } ] } );
	this.$body.append( this.editPanel.$element );
	this.$foot.append( this.applyButton.$element );
};

/**
 * @inheritdoc
 */
ve.ui.MWSyntaxHighlightDialog.prototype.setup = function ( data ) {
	// Parent method
	ve.ui.MWDialog.prototype.setup.call( this, data );

	// Properties
	this.sourceNode = this.surface.getView().getFocusedNode();
	this.sourceText = this.sourceNode.getModel().getAttribute( 'body' );
	this.sourceLang = this.sourceNode.getModel().getAttribute( 'lang' );
	this.editSurface = new ve.ui.MWSyntaxHighlightSimpleSurface( this.sourceText, this.sourceLang );

	// Initialization
	this.editPanel.$element.append( this.editSurface.$element );
	this.editSurface.initialize();
};

/**
 * @inheritdoc
 */
ve.ui.MWSyntaxHighlightDialog.prototype.teardown = function ( data ) {
	// Data initialization
	data = data || {};

	var tx,
		doc = this.surface.getModel().getDocument();

	// Save changes via Transaction
	if ( data.action === 'apply' ) {
		tx = ve.dm.Transaction.newFromAttributeChanges(
			doc,
			this.sourceNode.getModel().getOffset(),
			{
				'body':this.editSurface.getModel(),
				'lang':this.editSurface.getLang()
			}
		);
		this.surface.getModel().change( tx );
	}

	// Cleanup
	this.editSurface.destroy();

	// Parent method
	ve.ui.MWDialog.prototype.teardown.call( this, data );
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.MWSyntaxHighlightDialog );
