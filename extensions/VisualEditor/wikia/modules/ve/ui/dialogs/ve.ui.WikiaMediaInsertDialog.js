/*!
 * VisualEditor user interface WikiaMediaInsertDialog class.
 */

/**
 * Dialog for inserting MediaWiki media objects.
 *
 * @class
 * @extends ve.ui.MWDialog
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Config options
 */
ve.ui.WikiaMediaInsertDialog = function VeUiMWMediaInsertDialog( surface, config ) {
	// Parent constructor
	ve.ui.MWDialog.call( this, surface, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaInsertDialog, ve.ui.MWDialog );

/* Static Properties */

ve.ui.WikiaMediaInsertDialog.static.name = 'wikiaMediaInsert';

ve.ui.WikiaMediaInsertDialog.static.icon = 'media';

/* Methods */

ve.ui.WikiaMediaInsertDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWDialog.prototype.initialize.call( this );

	// Properties
	this.contentPanel = new ve.ui.PagedLayout( { '$$': this.frame.$$, 'attachPagesPanel': true } );

	// Initialization
	// TODO: replace with widget
	this.$cart = this.$$( '<div>' )
		.addClass( 've-ui-wikiaMediaInsertDialog-cartWidget' )
		.text( 'Cart' )
		.appendTo( this.$body );

	// TODO: replace with real pages
	this.contentPanel.addPage( 'test', {
		$content: this.$$( '<div>' ).text( 'content' )
	} );

	this.$body.append( this.contentPanel.$ );
	this.frame.$content.addClass( 've-ui-wikiaMediaInsertDialog-content' );
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.WikiaMediaInsertDialog );
