/*!
 * VisualEditor user interface WikiaSourceModeDialog class.
 */

/*global mw*/

/**
 * Dialog for editing wikitext in source mode.
 *
 * @class
 * @extends ve.ui.MWDialog
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Config options
 */
ve.ui.WikiaSourceModeDialog = function VeUiMWSourceModeDialog( surface, config ) {
	// Parent constructor
	ve.ui.MWDialog.call( this, surface, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaSourceModeDialog, ve.ui.MWDialog );

/* Static Properties */

ve.ui.WikiaSourceModeDialog.static.name = 'wikiaSourceMode';

ve.ui.WikiaSourceModeDialog.static.titleMessage = 'visualeditor-dialog-source-mode-title';

ve.ui.WikiaSourceModeDialog.static.icon = 'source';

/* Methods */

ve.ui.WikiaSourceModeDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWDialog.prototype.initialize.call( this );

	this.sourceModeTextarea = new ve.ui.TextInputWidget({
		'$$': this.frame.$$,
		'multiline': true
	});
	this.$body.append( this.sourceModeTextarea.$ );

	this.applytButton = new ve.ui.ButtonWidget( {
		'$$': this.frame.$$,
		'label': ve.msg( 'visualeditor-wikiasourcemode-button-apply' ),
		'flags': ['primary']
	} );
	this.$foot.append( this.applytButton.$ );

	this.frame.$content.addClass( 've-ui-wikiaSourceModeDialog-content' );

};

ve.ui.WikiaSourceModeDialog.prototype.onOpen = function () {
	ve.ui.MWDialog.prototype.onOpen.call( this );
	// TODO: display loading graphic
	// TODO: request wikitext
	// TODO: insert wikitext inside textarea
	// TODO: remove loading graphic
};

ve.ui.dialogFactory.register( ve.ui.WikiaSourceModeDialog );
