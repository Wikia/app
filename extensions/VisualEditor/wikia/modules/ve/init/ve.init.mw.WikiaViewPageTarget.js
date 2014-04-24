/*!
 * VisualEditor MediaWiki Initialization WikiaViewPageTarget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw, veTrack */

/**
 * Initialization MediaWiki view page target.
 *
 * @class
 * @extends ve.init.mw.ViewPageTarget
 *
 * @constructor
 */
ve.init.mw.WikiaViewPageTarget = function VeInitMwWikiaViewPageTarget() {
	// Parent constructor
	ve.init.mw.ViewPageTarget.call( this );

	this.toolbarSaveButtonEnableTracked = false;
};

/* Inheritance */

OO.inheritClass( ve.init.mw.WikiaViewPageTarget, ve.init.mw.ViewPageTarget );

/* Static Properties */

ve.init.mw.WikiaViewPageTarget.static.toolbarGroups = [
	// History
	{ 'include': [ 'undo' ] },
	// Format
	{
		'type': 'menu',
		'indicator': 'down',
		'title': OO.ui.deferMsg( 'visualeditor-toolbar-format-tooltip' ),
		'include': [ { 'group': 'format' } ],
		'promote': [ 'paragraph' ],
		'demote': [ 'preformatted' ],
		'exclude': [ 'heading1' ]
	},
	// Style
	{ 'include': [ 'bold', 'italic', 'link' ] },
	{
		'type': 'list',
		'icon': 'text-style',
		'indicator': 'down',
		'title': OO.ui.deferMsg( 'visualeditor-toolbar-style-tooltip' ),
		'include': [ 'subscript', 'superscript', 'strikethrough', 'underline', 'indent', 'outdent', 'clear' ]
	},
	// Insert
	{
		'type': 'list',
		'label': OO.ui.deferMsg( 'visualeditor-toolbar-insert' ),
		'indicator': 'down',
		'include': [ 'wikiaMediaInsert', 'number', 'bullet', 'transclusion', 'reference', 'referenceList' ]
	}
];

ve.init.mw.WikiaViewPageTarget.static.actionsToolbarConfig = [
	{
		'include': [ 'notices' ]
	},
	{
		'type': 'list',
		'icon': 'menu',
		'indicator': 'down',
		'include': [ 'wikiaMeta', 'categories', 'wikiaSourceMode', 'wikiaHelp', 'commandHelp' ]
	}
];

ve.init.mw.WikiaViewPageTarget.prototype.hidePageContent = function () {
	$( '#mw-content-text, .WikiaArticleCategories' )
		.addClass( 've-init-mw-viewPageTarget-content' )
		.hide();

	$( 'body' ).addClass( 've' );
};

ve.init.mw.WikiaViewPageTarget.prototype.mutePageContent = function () {
	// Intentionally left empty
};

ve.init.mw.WikiaViewPageTarget.prototype.onSaveDialogReview = function () {
	ve.init.mw.ViewPageTarget.prototype.onSaveDialogReview.call( this );
	ve.track( 'wikia', {
		'action': ve.track.actions.CLICK,
		'label': 'dialog-save-review-changes-button',
		'duration': this.timings.saveDialogReview - this.timings.saveDialogOpen
	} );
};

ve.init.mw.WikiaViewPageTarget.prototype.onSaveDialogSave = function () {
	ve.init.mw.ViewPageTarget.prototype.onSaveDialogSave.call( this );
	ve.track( 'wikia', {
		'action': ve.track.actions.CLICK,
		'label': 'dialog-save-publish',
		'duration': this.timings.saveDialogSave - this.timings.saveDialogOpen
	} );
};

ve.init.mw.WikiaViewPageTarget.prototype.onToolbarCancelButtonClick = function () {
	if ( window.veTrack ) {
		veTrack( {
			action: 've-cancel-button-click',
			isDirty: !this.toolbarSaveButton.isDisabled() ? 'yes' : 'no'
		} );
	}
	ve.track( 'wikia', { 'action': ve.track.actions.CLICK, 'label': 'button-cancel' } );
	mw.hook( 've.cancelButton' ).fire();
	ve.init.mw.ViewPageTarget.prototype.onToolbarCancelButtonClick.call( this );
};

ve.init.mw.WikiaViewPageTarget.prototype.onToolbarMetaButtonClick = function () {
	ve.track( 'wikia', { 'action': ve.track.actions.CLICK, 'label': 'tool-page-settings' } );
	ve.init.mw.ViewPageTarget.prototype.onToolbarMetaButtonClick.call( this );
};

ve.init.mw.WikiaViewPageTarget.prototype.onToolbarSaveButtonClick = function () {
	if ( window.veTrack ) {
		veTrack( { action: 've-save-button-click' } );
	}
	ve.track( 'wikia', { 'action': ve.track.actions.CLICK, 'label': 'button-publish' } );
	ve.init.mw.ViewPageTarget.prototype.onToolbarSaveButtonClick.call( this );
};

ve.init.mw.WikiaViewPageTarget.prototype.setupSkinTabs = function () {
	// Intentionally left empty
};

ve.init.mw.WikiaViewPageTarget.prototype.showPageContent = function () {
	$( '.ve-init-mw-viewPageTarget-content' )
		.removeClass( 've-init-mw-viewPageTarget-content' )
		.show()
		.fadeTo( 0, 1 );
	$( 'body' ).removeClass( 've' );
};

ve.init.mw.WikiaViewPageTarget.prototype.updateToolbarSaveButtonState = function () {
	ve.init.mw.ViewPageTarget.prototype.updateToolbarSaveButtonState.call( this );
	if (
		!this.toolbarSaveButtonEnableTracked &&
		( this.toolbarSaveButtonEnableTracked = !this.toolbarSaveButton.isDisabled() )
	) {
		ve.track( 'wikia', { 'action': ve.track.actions.ENABLE, 'label': 'button-publish' } );
	}
};

