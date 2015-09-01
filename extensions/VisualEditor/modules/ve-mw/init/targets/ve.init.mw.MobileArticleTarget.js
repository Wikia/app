/*!
 * VisualEditor MediaWiki Initialization MobileArticleTarget class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki mobile article target.
 *
 * @class
 * @extends ve.init.mw.Target
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {number} [section] Number of the section target should scroll to
 */
ve.init.mw.MobileArticleTarget = function VeInitMwMobileArticleTarget( config ) {
	var currentUri = new mw.Uri();

	config = config || {};
	config.toolbarConfig = $.extend( {
		actions: false
	}, config.toolbarConfig );

	// Parent constructor
	ve.init.mw.MobileArticleTarget.super.call(
		this, mw.config.get( 'wgRelevantPageName' ), currentUri.query.oldid, config
	);

	this.section = config.section;

	// Initialization
	this.$element.addClass( 've-init-mw-mobileArticleTarget' );
};

/* Inheritance */

OO.inheritClass( ve.init.mw.MobileArticleTarget, ve.init.mw.Target );

/* Static Properties */

ve.init.mw.MobileArticleTarget.static.toolbarGroups = [
	// History
	{ include: [ 'undo' ] },
	// Style
	{
		classes: [ 've-test-toolbar-style' ],
		type: 'list',
		icon: 'textStyle',
		indicator: 'down',
		title: OO.ui.deferMsg( 'visualeditor-toolbar-style-tooltip' ),
		include: [ { group: 'textStyle' }, 'language', 'clear' ],
		forceExpand: [ 'bold', 'italic', 'clear' ],
		promote: [ 'bold', 'italic' ],
		demote: [ 'strikethrough', 'code', 'underline', 'language', 'clear' ]
	},
	// Link
	{ include: [ 'link' ] },
	// Cite
	{
		header: OO.ui.deferMsg( 'visualeditor-toolbar-cite-label' ),
		indicator: 'down',
		type: 'list',
		icon: 'reference',
		title: OO.ui.deferMsg( 'visualeditor-toolbar-cite-label' ),
		include: [ { group: 'cite' }, 'reference/existing' ]
	},
	// Done with editing toolbar
	{ include: [ 'done' ] }
];

ve.init.mw.MobileArticleTarget.static.name = 'mobile';

/* Methods */

/**
 * @inheritdoc
 */
ve.init.mw.MobileArticleTarget.prototype.onSurfaceReady = function () {
	var surfaceModel;

	// Parent method
	ve.init.mw.MobileArticleTarget.super.prototype.onSurfaceReady.apply( this, arguments );

	surfaceModel = this.getSurface().getModel();
	surfaceModel.connect( this, {
		blur: 'onSurfaceBlur',
		focus: 'onSurfaceFocus'
	} );
	this[ surfaceModel.getSelection().isNull() ? 'onSurfaceBlur' : 'onSurfaceFocus' ]();

	this.events.trackActivationComplete();
};

/**
 * Handle surface blur events
 */
ve.init.mw.MobileArticleTarget.prototype.onSurfaceBlur = function () {
	var toolbar = this.getToolbar();
	toolbar.$group.addClass( 've-init-mw-mobileArticleTarget-editTools-hidden' );
	this.pageToolbar.$element.removeClass( 've-init-mw-mobileArticleTarget-pageToolbar-hidden' );
};

/**
 * Handle surface focus events
 */
ve.init.mw.MobileArticleTarget.prototype.onSurfaceFocus = function () {
	var toolbar = this.getToolbar();
	toolbar.$group.removeClass( 've-init-mw-mobileArticleTarget-editTools-hidden' );
	this.pageToolbar.$element.addClass( 've-init-mw-mobileArticleTarget-pageToolbar-hidden' );
};

/**
 * @inheritdoc
 */
ve.init.mw.MobileArticleTarget.prototype.createSurface = function ( dmDoc, config ) {
	return new ve.ui.MobileSurface( dmDoc, config );
};

/**
 * @inheritdoc
 */
ve.init.mw.MobileArticleTarget.prototype.setupToolbarSaveButton = function () {
	// Parent method
	ve.init.mw.MobileArticleTarget.super.prototype.setupToolbarSaveButton.call( this, {
		label: ve.msg( 'visualeditor-toolbar-savedialog-short' )
	} );
};

/**
 * @inheritdoc
 */
ve.init.mw.MobileArticleTarget.prototype.setupToolbar = function ( surface ) {
	// Parent method
	ve.init.mw.MobileArticleTarget.super.prototype.setupToolbar.call( this, surface );

	this.toolbar.$element.addClass( 've-init-mw-mobileArticleTarget-toolbar' );
	// Append the context to the toolbar
	this.toolbar.$bar.append( surface.getContext().$element );
};

/**
 * @inheritdoc
 */
ve.init.mw.MobileArticleTarget.prototype.attachToolbar = function () {
	// Move the toolbar to the overlay header
	this.toolbar.$element.appendTo( '.overlay-header > .toolbar' );
	this.toolbar.initialize();
};

/**
 * @inheritdoc
 */
ve.init.mw.MobileArticleTarget.prototype.attachToolbarSaveButton = function () {
	this.pageToolbar = new ve.ui.TargetToolbar( this, { actions: true } );

	this.pageToolbar.setup( [
		// Back
		{ include: [ 'back' ] },
		{
			type: 'list',
			icon: 'advanced',
			indicator: 'down',
			title: ve.msg( 'visualeditor-pagemenu-tooltip' ),
			include: [ 'editModeSource' ]
		}
	], this.getSurface() );

	this.pageToolbar.emit( 'updateState' );

	$( '<div>' ).addClass( 've-init-mw-mobileArticleTarget-title-container' ).append(
		$( '<div>' ).addClass( 've-init-mw-mobileArticleTarget-title' ).text(
			new mw.Title( ve.init.target.pageName ).getMainText()
		)
	)
		// Insert title between 'back' and 'advanced'
		.insertAfter( this.pageToolbar.items[ 0 ].$element );

	this.pageToolbar.$element.addClass( 've-init-mw-mobileArticleTarget-pageToolbar' );
	this.pageToolbar.$actions.append(
		this.toolbarSaveButton.$element
	);

	this.toolbar.$element.append( this.pageToolbar.$element );

	this.pageToolbar.$group.addClass( 've-init-mw-mobileArticleTarget-pageTools' );
	this.toolbar.$group.addClass( 've-init-mw-mobileArticleTarget-editTools' );
};

/**
 * @inheritdoc
 */
ve.init.mw.MobileArticleTarget.prototype.goToHeading = function ( headingNode ) {
	this.scrollToHeading( headingNode );
};

/**
 * @inheritdoc
 */
ve.init.mw.MobileArticleTarget.prototype.scrollToHeading = function ( headingNode ) {
	var position,
		target = this;

	setTimeout( function () {
		if ( ve.init.platform.constructor.static.isIos() ) {
			position = headingNode.$element.offset().top - target.toolbar.$element.height();
			target.surface.$element.closest( '.overlay-content' ).scrollTop( position );
		} else {
			ve.init.mw.MobileArticleTarget.super.prototype.scrollToHeading.call( target, headingNode );
		}
	} );
};

/**
 * Close the mobile editor
 */
ve.init.mw.MobileArticleTarget.prototype.close = function () {
};

/**
 * Done with the editing toolbar
 */
ve.init.mw.MobileArticleTarget.prototype.done = function () {
	this.getSurface().getView().blur();
};

/**
 * Back tool
 */
ve.ui.MWBackTool = function VeUiMwBackTool() {
	// Parent constructor
	ve.ui.MWBackTool.super.apply( this, arguments );
};
OO.inheritClass( ve.ui.MWBackTool, ve.ui.Tool );
ve.ui.MWBackTool.static.name = 'back';
ve.ui.MWBackTool.static.group = 'navigation';
ve.ui.MWBackTool.static.icon = 'previous';
ve.ui.MWBackTool.static.title =
	OO.ui.deferMsg( 'visualeditor-backbutton-tooltip' );
ve.ui.MWBackTool.static.commandName = 'back';

/** */
ve.ui.MWBackTool.prototype.onUpdateState = function () {
	// Parent method
	ve.ui.MWBackTool.super.prototype.onUpdateState.apply( this, arguments );

	this.setActive( false );
	this.setDisabled( false );
};

ve.ui.toolFactory.register( ve.ui.MWBackTool );

/**
 * Back command
 */
ve.ui.MWBackCommand = function VeUiMWBackCommand() {
	// Parent constructor
	ve.ui.MWBackCommand.super.call( this, 'back' );
};
OO.inheritClass( ve.ui.MWBackCommand, ve.ui.Command );
ve.ui.MWBackCommand.prototype.execute = function () {
	ve.init.target.close();
};
ve.ui.commandRegistry.register( new ve.ui.MWBackCommand() );

/**
 * Done tool
 */
ve.ui.MWDoneTool = function VeUiMWDoneTool() {
	// Parent constructor
	ve.ui.MWDoneTool.super.apply( this, arguments );
};
OO.inheritClass( ve.ui.MWDoneTool, ve.ui.Tool );
ve.ui.MWDoneTool.static.name = 'done';
ve.ui.MWDoneTool.static.group = 'navigation';
ve.ui.MWDoneTool.static.icon = 'check';
ve.ui.MWDoneTool.static.title =
	OO.ui.deferMsg( 'visualeditor-donebutton-tooltip' );
ve.ui.MWDoneTool.static.commandName = 'done';
ve.ui.toolFactory.register( ve.ui.MWDoneTool );

/**
 * Done command
 */
ve.ui.MWDoneCommand = function VeUiMwDoneCommand() {
	// Parent constructor
	ve.ui.MWDoneCommand.super.call( this, 'done' );
};
OO.inheritClass( ve.ui.MWDoneCommand, ve.ui.Command );
ve.ui.MWDoneCommand.prototype.execute = function () {
	ve.init.target.done();
};
ve.ui.commandRegistry.register( new ve.ui.MWDoneCommand() );
