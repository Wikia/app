/*!
 * VisualEditor UserInterface WikiaCommandHelpDialog class.
 */

/*global mw */

/**
 * Dialog listing all command keyboard shortcuts.
 *
 * @class
 * @extends ve.ui.MWCommandHelpDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaCommandHelpDialog = function VeUiWikiaCommandHelpDialog( config ) {
	// Parent constructor
	ve.ui.WikiaCommandHelpDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaCommandHelpDialog, ve.ui.MWCommandHelpDialog );

/* Static methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaCommandHelpDialog.static.getCommandGroups = function () {
	var commandGroups = ve.ui.WikiaCommandHelpDialog.super.static.getCommandGroups.call( this ),
		accessKeyPrefix = mw.util.tooltipAccessKeyPrefix.toUpperCase().replace( /-/g, ' + ' );

	commandGroups.other.commands.push(
		{
			'shortcuts': [ accessKeyPrefix + '[' ],
			'msg': 'wikia-visualeditor-dialog-wikiasourcemode-title'
		}
	);

	return commandGroups;
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaCommandHelpDialog );
