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
 * @extends ve.ui.Dialog
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Config options
 */
ve.ui.MWSyntaxHighlightDialog = function VeUiMWSyntaxHighlightDialog( surface, config ) {
	// Parent constructor
	ve.ui.MWDialog.call( this, surface, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWSyntaxHighlightDialog, ve.ui.MWDialog );

/* Static Properties */

ve.ui.MWSyntaxHighlightDialog.static.titleMessage = 'visualeditor-dialog-syntaxhighlight-title';

ve.ui.MWSyntaxHighlightDialog.static.icon = 'syntaxHighlight';

ve.ui.MWSyntaxHighlightDialog.static.name = 'mwSyntaxHighlight';

/* Methods */

/**
 * Handle frame ready events.
 *
 * @method
 */
ve.ui.MWSyntaxHighlightDialog.prototype.initialize = function () {
	// Call parent method
	ve.ui.Dialog.prototype.initialize.call( this );
	this.editPanel = new ve.ui.PanelLayout( {
		'$$': this.frame.$$, 'scrollable': false, 'padded': false
	} );
	this.applyButton = new ve.ui.ButtonWidget( {
		'$$': this.frame.$$, 'label': ve.msg( 'visualeditor-dialog-action-apply' ), 'flags': ['primary']
	} );
	this.applyButton.connect( this, { 'click': [ 'close', 'apply' ] } );
	this.$body.append( this.editPanel.$ );
	this.$foot.append( this.applyButton.$ );
};

/**
 * Handle frame ready events.
 *
 * @method
 */
ve.ui.MWSyntaxHighlightDialog.prototype.onOpen = function () {
	// Parent method
	ve.ui.Dialog.prototype.onOpen.call( this );
	// Properties
	this.sourceNode = this.surface.getView().getFocusedNode();
	this.sourceText = this.sourceNode.getModel().getAttribute( 'body' );
	this.sourceLang = this.sourceNode.getModel().getAttribute( 'lang' );
	this.editSurface = new ve.ui.MWSyntaxHighlightSimpleSurface( this.sourceText, this.sourceLang );
	// Initialization
	this.editPanel.$.append( this.editSurface.$ );
	this.editSurface.initialize();
};

/**
 * Handle frame ready events.
 *
 * @method
 * @param {string} action Action that caused the window to be closed
 */
ve.ui.MWSyntaxHighlightDialog.prototype.onClose = function ( action ) {
	var tx,
		doc = this.surface.getModel().getDocument();
	// Parent method
	ve.ui.Dialog.prototype.onClose.call( this );
	// Save changes via Transaction
	if ( action === 'apply' ) {
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
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.MWSyntaxHighlightDialog );
