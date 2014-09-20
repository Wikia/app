/*global mw */

/*!
 * VisualEditor MediaWiki UserInterface popup tool classes.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki UserInterface notices popup tool.
 *
 * @class
 * @extends OO.ui.PopupTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup Tool group. Must belong to a ve.ui.TargetToolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.MWNoticesPopupTool = function VeUiMWNoticesPopupTool( toolGroup, config ) {
	var key,
		items = toolGroup.getToolbar().getTarget().getEditNotices(),
		count = ve.getObjectKeys( items ).length,
		title = ve.msg( 'visualeditor-editnotices-tool', count );

	// Configuration initialization
	config = ve.extendObject( true, { 'popup': { 'head': true, 'label': title } }, config );

	// Parent constructor
	OO.ui.PopupTool.call( this, toolGroup, config );

	// Properties
	this.$items = this.$( '<div>' ).addClass( 've-ui-mwNoticesPopupTool-items' );

	// Initialization
	for ( key in items ) {
		$( items[key] )
			.addClass( 've-ui-mwNoticesPopupTool-item' )
			.find( 'a' )
				.attr( 'target', '_blank' );

		this.$items.append( items[key] );
	}

	this.popup.$body.append( this.$items );

	// Automatically show/hide
	if ( count ) {
		setTimeout( ve.bind( function () {
			this.showPopup();
		}, this ), 500 );
	} else {
		this.$element.hide();
	}
};

/* Inheritance */

OO.inheritClass( ve.ui.MWNoticesPopupTool, OO.ui.PopupTool );

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
	var items = this.toolbar.getTarget().getEditNotices(),
		count = ve.getObjectKeys( items ).length;

	return ve.msg( this.constructor.static.title, count );
};

/**
 * @inheritdoc
 */
ve.ui.MWNoticesPopupTool.prototype.onSelect = function () {
	ve.track( 'tool.mw.noticespopup.select', { name: this.constructor.static.name } );
	return OO.ui.PopupTool.prototype.onSelect.call( this );
};

/* Registration */

ve.ui.toolFactory.register( ve.ui.MWNoticesPopupTool );

/**
 * MediaWiki UserInterface help popup tool.
 *
 * @class
 * @extends OO.ui.PopupTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.MWHelpPopupTool = function VeUiMWHelpPopupTool( toolGroup, config ) {
	var title = ve.msg( 'visualeditor-help-tool' );

	// Configuration initialization
	config = ve.extendObject( true, { 'popup': { 'head': true, 'label': title } }, config );

	// Parent constructor
	OO.ui.PopupTool.call( this, toolGroup, config );

	// Properties
	this.$items = this.$( '<div>' );
	this.helpButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'frameless': true,
		'icon': 'help',
		'title': ve.msg( 'visualeditor-help-title' ),
		'href': new mw.Title( ve.msg( 'wikia-visualeditor-help-link' ) ).getUrl(),
		'target': '_blank',
		'label': ve.msg( 'visualeditor-help-label' )
	} );
	this.keyboardShortcutsButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'frameless': true,
		'icon': 'help',
		'label': ve.msg( 'visualeditor-dialog-command-help-title' )
	} );
	this.feedbackButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'frameless': true,
		'icon': 'comment',
		'label': ve.msg( 'visualeditor-feedback-tool' )
	} );

	// Events
	this.feedbackButton.connect( this, { 'click': 'onFeedbackClick' } );
	this.keyboardShortcutsButton.connect( this, { 'click': 'onKeyboardShortcutsClick' } );

	// Initialization
	this.$items
		.addClass( 've-ui-mwHelpPopupTool-items' )
		.append(
			this.$( '<div>' )
				.addClass( 've-ui-mwHelpPopupTool-item' )
				.text( ve.msg( 'wikia-visualeditor-beta-warning' ) )
		)
		.append(
			this.$( '<div>' )
				.addClass( 've-ui-mwHelpPopupTool-item' )
				.append( this.helpButton.$element )
				.append( this.keyboardShortcutsButton.$element )
				.append( this.feedbackButton.$element )
		);
	if ( ve.version.id !== false ) {
		this.$items
			.append( this.$( '<div>' )
				.addClass( 've-ui-mwHelpPopupTool-item' )
				.append( this.$( '<span>' )
					.addClass( 've-ui-mwHelpPopupTool-version-label' )
					.text( ve.msg( 'visualeditor-version-label' ) )
				)
				.append( ' ' )
				.append( this.$( '<a>' )
					.addClass( 've-ui-mwHelpPopupTool-version-link' )
					.attr( 'target', '_blank' )
					.attr( 'href', ve.version.url )
					.text( ve.version.id )
				)
				.append( ' ' )
				.append( this.$( '<span>' )
					.addClass( 've-ui-mwHelpPopupTool-version-date' )
					.text( ve.version.dateString )
				)
			);
	}
	this.$items.find( 'a' ).attr( 'target', '_blank' );
	this.popup.$body.append( this.$items );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWHelpPopupTool, OO.ui.PopupTool );

/* Static Properties */

ve.ui.MWHelpPopupTool.static.name = 'help';
ve.ui.MWHelpPopupTool.static.group = 'utility';
ve.ui.MWHelpPopupTool.static.icon = 'help';
ve.ui.MWHelpPopupTool.static.title = OO.ui.deferMsg( 'visualeditor-help-tool' );
ve.ui.MWHelpPopupTool.static.autoAddToCatchall = false;
ve.ui.MWHelpPopupTool.static.autoAddToGroup = false;

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWHelpPopupTool.prototype.onSelect = function () {
	ve.track( 'tool.mw.helppopup.select', { name: this.constructor.static.name } );
	return OO.ui.PopupTool.prototype.onSelect.call( this );
};

/**
 * Handle clicks on the keyboard shortcuts button.
 *
 * @method
 */
ve.ui.MWHelpPopupTool.prototype.onKeyboardShortcutsClick = function () {
	this.hidePopup();
	ve.ui.commandRegistry.lookup( 'commandHelp' ).execute( this.toolbar.getSurface() );
};

/* Registration */

ve.ui.toolFactory.register( ve.ui.MWHelpPopupTool );
