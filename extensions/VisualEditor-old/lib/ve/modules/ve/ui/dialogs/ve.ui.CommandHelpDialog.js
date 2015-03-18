/*!
 * VisualEditor UserInterface CommandHelpDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog listing all command keyboard shortcuts.
 *
 * @class
 * @extends ve.ui.Dialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.CommandHelpDialog = function VeUiCommandHelpDialog( config ) {
	// Configuration initialization
	config = ve.extendObject( { 'footless': true }, config );

	// Parent constructor
	ve.ui.Dialog.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.CommandHelpDialog, ve.ui.Dialog );

/* Static Properties */

ve.ui.CommandHelpDialog.static.name = 'commandHelp';

ve.ui.CommandHelpDialog.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-command-help-title' );

ve.ui.CommandHelpDialog.static.icon = 'help';

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.CommandHelpDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.CommandHelpDialog.super.prototype.initialize.call( this );

	var i, j, jLen, k, kLen, triggerList, commands, shortcut,
		platform = ve.init.platform.getSystemPlatform(),
		platformKey = platform === 'mac' ? 'mac' : 'pc',
		$list, $shortcut,
		commandGroups = this.constructor.static.getCommandGroups(),
		contentLayout = new OO.ui.PanelLayout( {
			'$': this.$,
			'scrollable': true,
			'padded': true
		} ),
		$container = this.$( '<div>' ).addClass( 've-ui-commandHelpDialog-container' );

	for ( i in commandGroups ) {
		commands = commandGroups[i].commands;
		$list = this.$( '<dl>' ).addClass( 've-ui-commandHelpDialog-list' );
		for ( j = 0, jLen = commands.length; j < jLen; j++ ) {
			if ( commands[j].trigger ) {
				triggerList = ve.ui.triggerRegistry.lookup( commands[j].trigger );
			} else {
				triggerList = [];
				for ( k = 0, kLen = commands[j].shortcuts.length; k < kLen; k++ ) {
					shortcut = commands[j].shortcuts[k];
					triggerList.push(
						new ve.ui.Trigger(
							ve.isPlainObject( shortcut ) ? shortcut[platformKey] : shortcut,
							true
						)
					);
				}
			}
			$shortcut = this.$( '<dt>' );
			for ( k = 0, kLen = triggerList.length; k < kLen; k++ ) {
				$shortcut.append( this.$( '<kbd>' ).text(
					triggerList[k].getMessage().replace( /\+/g, ' + ' )
				) );
			}
			$list.append(
				$shortcut,
				this.$( '<dd>' ).text( ve.msg( commands[j].msg ) )
			);
		}
		$container.append(
			this.$( '<div>' )
				.addClass( 've-ui-commandHelpDialog-section' )
				.append(
					this.$( '<h3>' ).text( ve.msg( commandGroups[i].title ) ),
					$list
				)
		);
	}

	contentLayout.$element.append( $container );
	this.$body.append( contentLayout.$element );
};

/* Static methods */

/**
 * Get the list of commands, grouped by type
 *
 * @static
 * @returns {Object} Object containing command groups, consiste of a title message and array of commands
 */
ve.ui.CommandHelpDialog.static.getCommandGroups = function () {
	return {
		'textStyle': {
			'title': 'visualeditor-shortcuts-text-style',
			'commands': [
				{ 'trigger': 'bold', 'msg': 'visualeditor-annotationbutton-bold-tooltip' },
				{ 'trigger': 'italic', 'msg': 'visualeditor-annotationbutton-italic-tooltip' },
				{ 'trigger': 'link', 'msg': 'visualeditor-annotationbutton-link-tooltip' },
				{ 'trigger': 'subscript', 'msg': 'visualeditor-annotationbutton-subscript-tooltip' },
				{ 'trigger': 'superscript', 'msg': 'visualeditor-annotationbutton-superscript-tooltip' },
				{ 'trigger': 'underline', 'msg': 'visualeditor-annotationbutton-underline-tooltip' },
				{ 'trigger': 'clear', 'msg': 'visualeditor-clearbutton-tooltip' }
			]
		},
		'formatting': {
			'title': 'visualeditor-shortcuts-formatting',
			'commands': [
				{ 'trigger': 'paragraph', 'msg': 'visualeditor-formatdropdown-format-paragraph' },
				{ 'shortcuts': ['ctrl+(1-6)'], 'msg': 'visualeditor-formatdropdown-format-heading-label' },
				{ 'trigger': 'preformatted', 'msg': 'visualeditor-formatdropdown-format-preformatted' },
				{ 'trigger': 'indent', 'msg': 'visualeditor-indentationbutton-indent-tooltip' },
				{ 'trigger': 'outdent', 'msg': 'visualeditor-indentationbutton-outdent-tooltip' }
			]
		},
		'history': {
			'title': 'visualeditor-shortcuts-history',
			'commands': [
				{ 'trigger': 'undo', 'msg': 'visualeditor-historybutton-undo-tooltip' },
				{ 'trigger': 'redo', 'msg': 'visualeditor-historybutton-redo-tooltip' }
			]
		},
		'clipboard': {
			'title': 'visualeditor-shortcuts-clipboard',
			'commands': [
				{
					'shortcuts': [ {
						'mac': 'cmd+x',
						'pc': 'ctrl+x'
					} ],
					'msg': 'visualeditor-clipboard-cut'
				},
				{
					'shortcuts': [ {
						'mac': 'cmd+c',
						'pc': 'ctrl+c'
					} ],
					'msg': 'visualeditor-clipboard-copy'
				},
				{
					'shortcuts': [ {
						'mac': 'cmd+v',
						'pc': 'ctrl+v'
					} ],
					'msg': 'visualeditor-clipboard-paste'
				},
				{ 'trigger': 'pasteSpecial', 'msg': 'visualeditor-clipboard-paste-special' }
			]
		},
		'other': {
			'title': 'visualeditor-shortcuts-other',
			'commands': [
				{ 'trigger': 'commandHelp', 'msg': 'visualeditor-dialog-command-help-title' }
			]
		}
	};
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.CommandHelpDialog );
