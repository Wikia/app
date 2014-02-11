/*global mw */

/*!
 * VisualEditor MediaWiki UserInterface popup tool classes.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
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
	this.$items = this.$( '<div>' );

	// Initialization
	for ( key in items ) {
		this.$items.append( items[key] );
	}
	this.$items
		.addClass( 've-ui-mwNoticesPopupTool-items' )
		.children()
			.addClass( 've-ui-mwNoticesPopupTool-item' )
			.find( 'a' )
				.attr( 'target', '_blank' );
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
ve.ui.MWNoticesPopupTool.static.titleMessage = 'visualeditor-editnotices-tool';
ve.ui.MWNoticesPopupTool.static.autoAdd = false;

/* Methods */

/**
 * Get the tool title.
 *
 * @inheritdoc
 */
ve.ui.MWNoticesPopupTool.prototype.getTitle = function () {
	var items = this.toolbar.getTarget().getEditNotices(),
		count = ve.getObjectKeys( items ).length;

	return ve.msg( this.constructor.static.titleMessage, count );
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
	this.helpButton = new OO.ui.IconButtonWidget( {
		'icon': 'help',
		'title': ve.msg( 'visualeditor-help-title' ),
		'href': new mw.Title( ve.msg( 'wikia-visualeditor-help-link' ) ).getUrl(),
		'target': '_blank',
		'label': ve.msg( 'visualeditor-help-label' )
	} );

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

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWHelpPopupTool.prototype.onSelect = function () {
	ve.track( 'tool.mw.helppopup.select', { name: this.constructor.static.name } );
	return OO.ui.PopupTool.prototype.onSelect.call( this );
};

/* Static Properties */

ve.ui.MWHelpPopupTool.static.name = 'help';
ve.ui.MWHelpPopupTool.static.group = 'utility';
ve.ui.MWHelpPopupTool.static.icon = 'help';
ve.ui.MWHelpPopupTool.static.titleMessage = 'visualeditor-help-tool';
ve.ui.MWHelpPopupTool.static.autoAdd = false;

/* Methods */

/* Registration */

ve.ui.toolFactory.register( ve.ui.MWHelpPopupTool );
