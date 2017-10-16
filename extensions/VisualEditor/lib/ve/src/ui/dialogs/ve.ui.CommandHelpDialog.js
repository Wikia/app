/*!
 * VisualEditor UserInterface CommandHelpDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Dialog for listing all command keyboard shortcuts.
 *
 * @class
 * @extends OO.ui.ProcessDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.CommandHelpDialog = function VeUiCommandHelpDialog( config ) {
	// Parent constructor
	ve.ui.CommandHelpDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.CommandHelpDialog, OO.ui.ProcessDialog );

/* Static Properties */

ve.ui.CommandHelpDialog.static.name = 'commandHelp';

ve.ui.CommandHelpDialog.static.size = 'large';

ve.ui.CommandHelpDialog.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-command-help-title' );

ve.ui.CommandHelpDialog.static.actions = [
	{
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-done' ),
		flags: 'safe'
	}
];

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.CommandHelpDialog.prototype.getBodyHeight = function () {
	return Math.round( this.contentLayout.$element[0].scrollHeight );
};

/**
 * @inheritdoc
 */
ve.ui.CommandHelpDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.CommandHelpDialog.super.prototype.initialize.call( this );

	var i, j, jLen, k, kLen, triggerList, commands, shortcut,
		platform = ve.getSystemPlatform(),
		platformKey = platform === 'mac' ? 'mac' : 'pc',
		$list, $shortcut,
		commandGroups = this.constructor.static.getCommandGroups();

	this.contentLayout = new OO.ui.PanelLayout( {
		$: this.$,
		scrollable: true,
		padded: true,
		expanded: false
	} );
	this.$container = this.$( '<div>' ).addClass( 've-ui-commandHelpDialog-container' );

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
		this.$container.append(
			this.$( '<div>' )
				.addClass( 've-ui-commandHelpDialog-section' )
				.append(
					this.$( '<h3>' ).text( ve.msg( commandGroups[i].title ) ),
					$list
				)
		);
	}

	this.contentLayout.$element.append( this.$container );
	this.$body.append( this.contentLayout.$element );
};

/* Static methods */

/**
 * Get the list of commands, grouped by type
 *
 * @static
 * @returns {Object} Object containing command groups, consist of a title message and array of commands
 */
ve.ui.CommandHelpDialog.static.getCommandGroups = function () {
	return {
		textStyle: {
			title: 'visualeditor-shortcuts-text-style',
			commands: [
				{ trigger: 'bold', msg: 'visualeditor-annotationbutton-bold-tooltip' },
				{ trigger: 'italic', msg: 'visualeditor-annotationbutton-italic-tooltip' },
				{ trigger: 'link', msg: 'visualeditor-annotationbutton-link-tooltip' },
				{ trigger: 'superscript', msg: 'visualeditor-annotationbutton-superscript-tooltip' },
				{ trigger: 'subscript', msg: 'visualeditor-annotationbutton-subscript-tooltip' },
				{ trigger: 'underline', msg: 'visualeditor-annotationbutton-underline-tooltip' },
				{ trigger: 'code', msg: 'visualeditor-annotationbutton-code-tooltip' },
				{ trigger: 'strikethrough', msg: 'visualeditor-annotationbutton-strikethrough-tooltip' },
				{ trigger: 'clear', msg: 'visualeditor-clearbutton-tooltip' }
			]
		},
		history: {
			title: 'visualeditor-shortcuts-history',
			commands: [
				{ trigger: 'undo', msg: 'visualeditor-historybutton-undo-tooltip' },
				{ trigger: 'redo', msg: 'visualeditor-historybutton-redo-tooltip' }
			]
		},
		formatting: {
			title: 'visualeditor-shortcuts-formatting',
			commands: [
				{ trigger: 'paragraph', msg: 'visualeditor-formatdropdown-format-paragraph' },
				{ shortcuts: ['ctrl+(1-6)'], msg: 'visualeditor-formatdropdown-format-heading-label' },
				{ trigger: 'preformatted', msg: 'visualeditor-formatdropdown-format-preformatted' },
				{ trigger: 'blockquote', msg: 'visualeditor-formatdropdown-format-blockquote' },
				{ trigger: 'indent', msg: 'visualeditor-indentationbutton-indent-tooltip' },
				{ trigger: 'outdent', msg: 'visualeditor-indentationbutton-outdent-tooltip' }
			]
		},
		clipboard: {
			title: 'visualeditor-shortcuts-clipboard',
			commands: [
				{
					shortcuts: [ {
						mac: 'cmd+x',
						pc: 'ctrl+x'
					} ],
					msg: 'visualeditor-clipboard-cut'
				},
				{
					shortcuts: [ {
						mac: 'cmd+c',
						pc: 'ctrl+c'
					} ],
					msg: 'visualeditor-clipboard-copy'
				},
				{
					shortcuts: [ {
						mac: 'cmd+v',
						pc: 'ctrl+v'
					} ],
					msg: 'visualeditor-clipboard-paste'
				},
				{ trigger: 'pasteSpecial', msg: 'visualeditor-clipboard-paste-special' }
			]
		},
		other: {
			title: 'visualeditor-shortcuts-other',
			commands: [
				{ trigger: 'findAndReplace', msg: 'visualeditor-find-and-replace-title' },
				{ trigger: 'selectAll', msg: 'visualeditor-content-select-all' },
				{ trigger: 'commandHelp', msg: 'visualeditor-dialog-command-help-title' }
			]
		}
	};
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.CommandHelpDialog );
