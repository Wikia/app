/*!
 * VisualEditor UserInterface MWCommandHelpDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog listing all command keyboard shortcuts.
 *
 * @class
 * @extends ve.ui.CommandHelpDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWCommandHelpDialog = function VeUiMWCommandHelpDialog( config ) {
	// Parent constructor
	ve.ui.MWCommandHelpDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWCommandHelpDialog, ve.ui.CommandHelpDialog );

/* Static methods */

/**
 * @inheritdoc
 */
ve.ui.MWCommandHelpDialog.static.getCommandGroups = function () {
	var commandGroups = ve.ui.MWCommandHelpDialog.super.static.getCommandGroups.call( this ),
		accessKeyPrefix = mw.util.tooltipAccessKeyPrefix.toUpperCase().replace( /-/g, ' + ' ),
		save = ve.msg( 'accesskey-save' );

	if ( save !== '-' && save !== '' ) {
		commandGroups.other.commands.push(
			{
				shortcuts: [ accessKeyPrefix + save.toUpperCase() ],
				msg: 'visualeditor-savedialog-label-save'
			}
		);
		commandGroups.other.commands.push(
			{
				shortcuts: [ accessKeyPrefix + '[' ],
				msg: 'wikia-visualeditor-dialog-wikiasourcemode-title'
			}
		);
	}

	return commandGroups;
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.MWCommandHelpDialog );
