/*!
 * VisualEditor MediaWiki Initialization WikiaViewPageTarget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw */

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
	{ 'include': [ 'undo', 'redo' ] },
	{
		'type': 'menu',
		'include': [ { 'group': 'format' } ],
		'promote': [ 'paragraph' ],
		'demote': [ 'preformatted', 'heading1' ]
	},
	{ 'include': [ 'bold', 'italic', 'link', 'clear' ] },
	{ 'include': [ 'number', 'bullet' ] },
	{ 'include': [ 'wikiaMediaInsert' ] },
	{
		'include': '*',
		'exclude': [ 'mediaInsert', 'code', 'wikiaSourceMode' ]
	}
];

ve.init.mw.WikiaViewPageTarget.static.actionsToolbarConfig = [
	{ 'include': [ 'help', 'notices' ] },
	{
		'type': 'list',
		'icon': 'menu',
		'include': [ 'meta', 'categories', 'languages', 'wikiaSourceMode' ]
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

	// Show saving indicator
	var $indicator = $( '<div>' )
			.addClass( 've-indicator visible saving' ),
		$content = $( '<div>' ).addClass( 'content' ),
		$icon = $( '<div>' ).addClass( 'icon loading' ),
		$message = $( '<p>' )
			.addClass( 'message' )
			.text( mw.message( 'wikia-visualeditor-indicator-saving' ).plain() )
			.show();

	$content
		.append( $icon )
		.append( $message );

	$indicator
		.append( $content )
		.appendTo( 'body' )
		/* Fix layer stack. The indicator already has a high z-index, but displays below
		   the Save Dialog iframe. Reapply z-index to move it to the front.
		*/
		.css( { opacity: 1, zIndex: 99999999 } )
		.fadeIn();

	ve.track( 'wikia', {
		'action': ve.track.actions.CLICK,
		'label': 'dialog-save-publish',
		'duration': this.timings.saveDialogSave - this.timings.saveDialogOpen
	} );
};

ve.init.mw.WikiaViewPageTarget.prototype.onSave = function ( args ) {
	ve.init.mw.ViewPageTarget.prototype.onSave.call( this, args );
	// Change "Saving" message to "Saved"
	var $indicator = $( '.ve-indicator.saving' );
	$indicator
		.find( 'p.message' )
			.text( mw.message( 'wikia-visualeditor-indicator-saved' ).plain() );
	$indicator
		.find( 'div.icon' )
			.removeClass( 'loading' )
			.addClass( 've-init-mw-viewPageTarget-checkmark' );
	setTimeout(function() {
		$indicator.fadeOut( 400, function() {
			$indicator.remove();
		} );
	}, 1000 );
};

ve.init.mw.WikiaViewPageTarget.prototype.onSaveError = function ( args ) {
	var $indicator = $( '.ve-indicator.saving' );
	$indicator.fadeOut( 200, function() {
		$indicator.remove();
	} );
	ve.init.mw.ViewPageTarget.prototype.onSaveError.call( this, args );
};

ve.init.mw.WikiaViewPageTarget.prototype.onToolbarCancelButtonClick = function () {
	ve.track( 'wikia', { 'action': ve.track.actions.CLICK, 'label': 'button-cancel' } );
	ve.init.mw.ViewPageTarget.prototype.onToolbarCancelButtonClick.call( this );
};

ve.init.mw.WikiaViewPageTarget.prototype.onToolbarMetaButtonClick = function () {
	ve.track( 'wikia', { 'action': ve.track.actions.CLICK, 'label': 'tool-page-settings' } );
	ve.init.mw.ViewPageTarget.prototype.onToolbarMetaButtonClick.call( this );
};

ve.init.mw.WikiaViewPageTarget.prototype.onToolbarSaveButtonClick = function () {
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

ve.init.mw.WikiaViewPageTarget.prototype.onToolbarCancelButtonClick = function () {
	mw.hook( 've.cancelButton' ).fire();
	ve.init.mw.ViewPageTarget.prototype.onToolbarCancelButtonClick.call( this );
};
