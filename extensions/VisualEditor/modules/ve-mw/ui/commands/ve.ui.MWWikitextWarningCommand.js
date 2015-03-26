/*!
 * VisualEditor UserInterface MediaWiki WikitextWarningCommand class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
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
	this.isOpen = false;
};

/* Inheritance */

OO.inheritClass( ve.ui.MWWikitextWarningCommand, ve.ui.Command );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWWikitextWarningCommand.prototype.execute = function () {
	if ( this.isOpen ) {
		return false;
	}
	$.showModal(
		ve.msg( 'visualeditor-wikitext-warning-title' ),
		$( $.parseHTML( ve.init.platform.getParsedMessage( 'wikia-visualeditor-wikitext-warning' ) ) )
			.filter( 'a' ).attr( 'target', '_blank ' ).end(),
		{
			onClose: function () {
				this.isOpen = false;
				ve.track( 'wikia', { action: ve.track.actions.CLOSE, label: 'modal-wikitext-warning' } );
			}.bind( this ),
			onCreate: function () {
				this.isOpen = true;
				ve.track( 'wikia', { action: ve.track.actions.OPEN, label: 'modal-wikitext-warning' } );
			}.bind( this )
		}
	);
	return true;
};

/* Registration */

ve.ui.commandRegistry.register( new ve.ui.MWWikitextWarningCommand() );
