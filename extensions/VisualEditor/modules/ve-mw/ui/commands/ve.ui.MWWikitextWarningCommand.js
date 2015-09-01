/*!
 * VisualEditor UserInterface MediaWiki WikitextWarningCommand class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Wikitext warning command.
 *
 * @class
 * @extends ve.ui.Command
 *
 * @constructor
 */
ve.ui.MWWikitextWarningCommand = function VeUiMWWikitextWarningCommand() {
	// Parent constructor
	ve.ui.MWWikitextWarningCommand.super.call(
		this, 'mwWikitextWarning'
	);
	this.warning = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.MWWikitextWarningCommand, ve.ui.Command );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWWikitextWarningCommand.prototype.execute = function () {
	var command = this;
	if ( this.warning && this.warning.isOpen ) {
		return false;
	}
	mw.notify(
		$( $.parseHTML( ve.init.platform.getParsedMessage( 'visualeditor-wikitext-warning' ) ) )
			.filter( 'a' ).attr( 'target', '_blank' ).end(),
		{
			title: ve.msg( 'visualeditor-wikitext-warning-title' ),
			tag: 'visualeditor-wikitext-warning'
		}
	).then( function ( message ) {
		command.warning = message;
	} );
	return true;
};

/* Registration */

ve.ui.commandRegistry.register( new ve.ui.MWWikitextWarningCommand() );
