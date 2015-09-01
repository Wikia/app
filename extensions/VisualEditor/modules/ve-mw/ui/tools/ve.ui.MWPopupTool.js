/*!
 * VisualEditor MediaWiki UserInterface popup tool classes.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki UserInterface popup tool.
 *
 * @class
 * @abstract
 * @extends OO.ui.PopupTool
 * @constructor
 * @param {string} title Title
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config]
 */
ve.ui.MWPopupTool = function VeUiMWPopupTool( title, toolGroup, config ) {
	// Configuration initialization
	config = ve.extendObject( { popup: { head: true, label: title } }, config );

	// Parent constructor
	ve.ui.MWPopupTool.super.call( this, toolGroup, config );

	this.$element.addClass( 've-ui-mwPopupTool' );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWPopupTool, OO.ui.PopupTool );

/**
 * MediaWiki UserInterface notices popup tool.
 *
 * @class
 * @extends ve.ui.MWPopupTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config]
 */
ve.ui.MWNoticesPopupTool = function VeUiMWNoticesPopupTool( toolGroup, config ) {
	var tool = this,
		items = toolGroup.getToolbar().getTarget().getEditNotices(),
		count = items.length,
		title = ve.msg( 'visualeditor-editnotices-tool', count );

	// Parent constructor
	ve.ui.MWNoticesPopupTool.super.call( this, title, toolGroup, config );

	// Properties
	this.$items = $( '<div>' ).addClass( 've-ui-mwNoticesPopupTool-items' );

	// Initialization
	items.forEach( function ( itemHtml ) {
		var $node = $( '<div>' )
			.addClass( 've-ui-mwNoticesPopupTool-item' )
			.append( $.parseHTML( itemHtml ) );

		$node.find( 'a' ).attr( 'target', '_blank' );

		tool.$items.append( $node );
	} );

	this.popup.$body.append( this.$items );

	if ( !count ) {
		this.$element = $( [] );
	}
};

/* Inheritance */

OO.inheritClass( ve.ui.MWNoticesPopupTool, ve.ui.MWPopupTool );

/* Static Properties */

ve.ui.MWNoticesPopupTool.static.name = 'notices';
ve.ui.MWNoticesPopupTool.static.group = 'utility';
ve.ui.MWNoticesPopupTool.static.icon = 'alert';
ve.ui.MWNoticesPopupTool.static.title = OO.ui.deferMsg( 'visualeditor-editnotices-tooltip' );
ve.ui.MWNoticesPopupTool.static.autoAddToCatchall = false;
ve.ui.MWNoticesPopupTool.static.autoAddToGroup = false;

/* Methods */

/**
 * Get the tool title.
 *
 * @inheritdoc
 */
ve.ui.MWNoticesPopupTool.prototype.getTitle = function () {
	var items = this.toolbar.getTarget().getEditNotices();

	return ve.msg( this.constructor.static.title, items.length );
};

/* Registration */

ve.ui.toolFactory.register( ve.ui.MWNoticesPopupTool );

/**
 * MediaWiki UserInterface help popup tool.
 *
 * @class
 * @extends ve.ui.MWPopupTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.MWHelpPopupTool = function VeUiMWHelpPopupTool( toolGroup, config ) {
	// Parent constructor
	ve.ui.MWHelpPopupTool.super.call( this, ve.msg( 'visualeditor-help-tool' ), toolGroup, config );

	// Properties
	this.$items = $( '<div>' );
	this.feedbackPromise = null;
	this.helpButton = new OO.ui.ButtonWidget( {
		framed: false,
		icon: 'help',
		title: ve.msg( 'visualeditor-help-title' ),
		href: new mw.Title( ve.msg( 'visualeditor-help-link' ) ).getUrl(),
		target: '_blank',
		label: ve.msg( 'visualeditor-help-label' )
	} );
	this.keyboardShortcutsButton = new OO.ui.ButtonWidget( {
		framed: false,
		icon: 'help',
		label: ve.msg( 'visualeditor-dialog-command-help-title' )
	} );
	this.feedbackButton = new OO.ui.ButtonWidget( {
		framed: false,
		icon: 'comment',
		label: ve.msg( 'visualeditor-feedback-tool' )
	} );

	// Events
	this.feedbackButton.connect( this, { click: 'onFeedbackClick' } );
	this.keyboardShortcutsButton.connect( this, { click: 'onKeyboardShortcutsClick' } );

	// Initialization
	this.$items
		.addClass( 've-ui-mwHelpPopupTool-items' )
		.append(
			$( '<div>' )
				.addClass( 've-ui-mwHelpPopupTool-item' )
				.text( ve.msg( 'visualeditor-beta-warning' ) )
		)
		.append(
			$( '<div>' )
				.addClass( 've-ui-mwHelpPopupTool-item' )
				.append( this.helpButton.$element )
				.append( this.keyboardShortcutsButton.$element )
				.append( this.feedbackButton.$element )
		);
	if ( ve.version.id !== false ) {
		this.$items
			.append( $( '<div>' )
				.addClass( 've-ui-mwHelpPopupTool-item' )
				.append( $( '<span>' )
					.addClass( 've-ui-mwHelpPopupTool-version-label' )
					.text( ve.msg( 'visualeditor-version-label' ) )
				)
				.append( ' ' )
				.append( $( '<a>' )
					.addClass( 've-ui-mwHelpPopupTool-version-link' )
					.attr( 'target', '_blank' )
					.attr( 'href', ve.version.url )
					.text( ve.version.id )
				)
				.append( ' ' )
				.append( $( '<span>' )
					.addClass( 've-ui-mwHelpPopupTool-version-date' )
					.text( ve.version.dateString )
				)
			);
	}
	this.$items.find( 'a' ).attr( 'target', '_blank' );
	this.popup.$body.append( this.$items );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWHelpPopupTool, ve.ui.MWPopupTool );

/* Static Properties */

ve.ui.MWHelpPopupTool.static.name = 'help';
ve.ui.MWHelpPopupTool.static.group = 'utility';
ve.ui.MWHelpPopupTool.static.icon = 'help';
ve.ui.MWHelpPopupTool.static.title = OO.ui.deferMsg( 'visualeditor-help-tool' );
ve.ui.MWHelpPopupTool.static.autoAddToCatchall = false;
ve.ui.MWHelpPopupTool.static.autoAddToGroup = false;

/* Methods */

/**
 * Handle clicks on the feedback button.
 */
ve.ui.MWHelpPopupTool.prototype.onFeedbackClick = function () {
	this.popup.toggle( false );
	if ( !this.feedbackPromise ) {
		this.feedbackPromise = mw.loader.using( 'mediawiki.feedback' ).then( function () {
			// This can't be constructed until the editor has loaded as it uses special messages
			return new mw.Feedback( {
				title: new mw.Title( ve.msg( 'visualeditor-feedback-link' ) ),
				bugsLink: new mw.Uri( 'https://phabricator.wikimedia.org/maniphest/task/create/?projects=VisualEditor' ),
				bugsListLink: new mw.Uri( 'https://phabricator.wikimedia.org/maniphest/query/eSHgNozkIsuv/' ),
				showUseragentCheckbox: true,
				useragentCheckboxMandatory: true
			} );
		} );
	}
	this.feedbackPromise.done( function ( feedback ) {
		feedback.launch( {
			message: ve.msg( 'visualeditor-feedback-defaultmessage', location.toString() )
		} );
	} );
};

/**
 * Handle clicks on the keyboard shortcuts button.
 */
ve.ui.MWHelpPopupTool.prototype.onKeyboardShortcutsClick = function () {
	this.popup.toggle( false );
	ve.init.target.commandRegistry.lookup( 'commandHelp' ).execute( this.toolbar.getSurface() );
};

/* Registration */

ve.ui.toolFactory.register( ve.ui.MWHelpPopupTool );
