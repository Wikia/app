/*!
 * VisualEditor MediaWiki Initialization WikiaViewPageTarget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw, veTrack, window */

/**
 * Initialization MediaWiki view page target.
 *
 * @class
 * @extends ve.init.mw.ViewPageTarget
 *
 * @constructor
 */
ve.init.mw.WikiaViewPageTarget = function VeInitMwWikiaViewPageTarget() {
	var boldItalicLink, toolbarDropdown, wikiaSourceMode;

	if ( window.veSourceEntryPoint ) {
		if ( window.veSourceEntryPoint.hideBoldItalicLink ) {
			boldItalicLink = ve.init.mw.WikiaViewPageTarget.static.toolbarGroups.splice( 2, 1 );
			ve.init.mw.WikiaViewPageTarget.static.toolbarGroups[ 2 ].include = [].concat(
				boldItalicLink[ 0 ].include,
				ve.init.mw.WikiaViewPageTarget.static.toolbarGroups[ 2 ].include
			);
		}
		if ( window.veSourceEntryPoint.sourceButtonInToolbar ) {
			toolbarDropdown = ve.init.mw.WikiaViewPageTarget.static.actionsToolbarConfig.pop();
			wikiaSourceMode = toolbarDropdown.include.pop();
			ve.init.mw.WikiaViewPageTarget.static.toolbarGroups.push( toolbarDropdown );
			ve.init.mw.WikiaViewPageTarget.static.actionsToolbarConfig.push( { 'include': [ wikiaSourceMode ] } );
		}
	}

	// Parent constructor
	ve.init.mw.WikiaViewPageTarget.super.call( this );

	// Properties
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
		'include': [ 'wikiaMediaInsert', 'wikiaSingleMedia', 'wikiaMapInsert', 'number', 'bullet', 'wikiaTemplateInsert', 'reference', 'referenceList' ]
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
		'include': [ 'wikiaMeta', 'categories', 'wikiaHelp', 'wikiaCommandHelp', 'wikiaSourceMode' ]
	}
];

ve.init.mw.WikiaViewPageTarget.static.surfaceCommands.push( 'wikiaSourceMode' );

ve.init.mw.WikiaViewPageTarget.prototype.getNonEditableUIElements = function () {
	var $elements,
		ns = mw.config.get( 'wgNamespaceNumber' );

	if ( ns === 14 ) {
		// Category
		$elements = $( '#mw-content-text' ).children().filter( function () {
			var $this = $( this );
			return !(
				// Category thumbs
				$this.hasClass( 'category-gallery' ) ||
				// Category exhibition
				$this.is( '#mw-pages' ) ||
				// Category list
				$this.children( '#mw-pages' ).length
			);
		} );
	} else {
		$elements = $( '#mw-content-text' );
	}

	$elements = $elements.add( '.article-categories' );

	return $elements;
};

ve.init.mw.WikiaViewPageTarget.prototype.hidePageContent = function () {
	this.getNonEditableUIElements()
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
		'value': ve.track.normalizeDuration( this.events.timings.saveReview - this.events.timings.saveWorkflowBegin )
	} );
};

ve.init.mw.WikiaViewPageTarget.prototype.onToolbarCancelButtonClick = function () {
	if ( window.veTrack ) {
		veTrack( {
			action: 've-cancel-button-click',
			isDirty: !this.toolbarSaveButton.isDisabled() ? 'yes' : 'no'
		} );
	}
	ve.track( 'wikia', {
		'action': ve.track.actions.CLICK,
		'label': 'button-cancel',
		'value': ve.track.normalizeDuration( ve.now() - this.events.timings.surfaceReady )
	} );
	mw.hook( 've.cancelButton' ).fire();
	/*
	// Trigger Qualaroo survey for anonymous users abandoning edit
	if ( mw.user.anonymous() && window._kiq ) {
		_kiq.push( ['set', { 'event': 'abandon_ve_cancel' } ] );
	}
	*/
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

	if ( window.veSourceEntryPoint ) {
		window.optimizely = window.optimizely || [];
		window.optimizely.push( ['trackEvent', 've-save-button-click'] );
	}

	ve.track( 'wikia', {
		'action': ve.track.actions.CLICK,
		'label': 'button-publish',
		'value': ve.track.normalizeDuration( ve.now() - this.events.timings.surfaceReady )
	} );
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
		if ( window.veSourceEntryPoint !== undefined ) {
			window.optimizely = window.optimizely || [];
			window.optimizely.push( ['trackEvent', 've-save-button-enable'] );
		}
		ve.track( 'wikia', {
			'action': ve.track.actions.ENABLE,
			'label': 'button-publish',
			'value': ve.track.normalizeDuration( ve.now() - this.events.timings.surfaceReady )
		} );
	}
};

ve.init.mw.WikiaViewPageTarget.prototype.getToolbar = function () {
	return this.toolbar;
};

/**
 * @inheritdoc
 */
ve.init.mw.WikiaViewPageTarget.prototype.hideSpinner = function () {
	var $spinner = $( '.ve-spinner[data-type="loading"]' ),
		$throbber = $spinner.children(),
		$fade = $( '.ve-spinner-fade' );

	if ( $spinner.is( ':visible' ) ) {
		$throbber.hide();
		$fade.css( 'opacity', 1 );

		if ( this.timeout ) {
			setTimeout ( ve.bind( this.afterSpinnerFadeOpacityIn, this, $spinner, $throbber ), this.timeout );
		} else {
			this.afterSpinnerFadeOpacityIn( $spinner, $throbber );
		}
	}
};

ve.init.mw.WikiaViewPageTarget.prototype.afterSpinnerFadeOpacityIn = function ( $spinner, $throbber ) {
	$spinner.hide();
	$throbber.show();
};

/**
 * @inheritdoc
 */
ve.init.mw.WikiaViewPageTarget.prototype.onLoadError = function ( jqXHR, status, error ) {
	ve.init.mw.ViewPageTarget.prototype.onLoadError.call( this, jqXHR, status, error );
	if ( window.veTrack ) {
		veTrack( {
			action: 've-load-error',
			status: status
		} );
	}
};

/**
 * @inheritdoc
 */
ve.init.mw.WikiaViewPageTarget.prototype.replacePageContent = function ( html, categoriesHtml ) {
	var insertTarget,
		$mwContentText = $( '#mw-content-text' ),
		$content = $( $.parseHTML( html ) );

	if ( mw.config.get( 'wgNamespaceNumber' ) === 14 /* NS_CATEOGRY */ ) {
		$mwContentText.children().filter( function () {
			var $this = $( this );
			return !(
				// Category form
				$this.hasClass( 'category-gallery-form' ) ||
				// Category thumbs
				$this.hasClass( 'category-gallery' ) ||
				// Category exhibition
				$this.is( '#mw-pages' ) ||
				// Category list
				$this.children( '#mw-pages' ).length
			);
		} ).remove();

		insertTarget = window.CategoryExhibition ? '#mw-pages' : '.category-gallery';
		$content.insertBefore( insertTarget );
	} else {
		$mwContentText.empty().append( $content );
	}

	mw.hook( 'wikipage.content' ).fire( $mwContentText );
	$( '#catlinks' ).replaceWith( categoriesHtml );
};

/**
 * Handle failure from serialization
 *
 * @method
 * @param {object} jqXHR
 * @param {string} status Text status message
 */
ve.init.mw.WikiaViewPageTarget.prototype.onSerializeError = function ( jqXHR, status ) {
	if ( window.veTrack ) {
		veTrack( {
			action: 'parsoid-serialize-error',
			status: status
		} );
	}
	ve.init.mw.WikiaViewPageTarget.super.prototype.onSerializeError.call( this, jqXHR, status );
};

/**
 * Handle failure when retrieving diff
 *
 * @method
 * @param {object} jqXHR
 * @param {string} status Text status message
 */
ve.init.mw.WikiaViewPageTarget.prototype.onShowChangesError = function ( jqXHR, status ) {
	if ( window.veTrack ) {
		veTrack( {
			action: 'parsoid-diff-error',
			status: status
		} );
	}
	ve.init.mw.WikiaViewPageTarget.super.prototype.onShowChangesError.call( this, jqXHR, status );
};

/**
 * @inheritdoc
 */
ve.init.mw.WikiaViewPageTarget.prototype.changeDocumentTitle = function () {
	// TODO: If Wikia ever has a different message for article creating vs. editing - then use it.
	document.title = ve.msg( 'editing', mw.config.get( 'wgTitle' ) ) +
		' - ' + mw.config.get( 'wgSiteName' );
};

/**
 * Handle failure when saving changes
 *
 * @method
 * @param {HTMLDocument} doc HTML document we tried to save
 * @param {object} saveData Options that were used
 * @param {object} jqXHR
 * @param {string} status Text status message
 * @param {object|null} data API response data
 */
ve.init.mw.WikiaViewPageTarget.prototype.onSaveError = function ( doc, saveData, jqXHR, status, data ) {
	if ( window.veTrack ) {
		veTrack( {
			action: 'parsoid-save-error',
			status: status
		} );
	}
	ve.init.mw.WikiaViewPageTarget.super.prototype.onSaveError.call( this, doc, saveData, jqXHR, status, data );
};

/**
 * @inheritdoc
 */
ve.init.mw.WikiaViewPageTarget.prototype.maybeShowDialogs = function () {
	// Parent method
	ve.init.mw.WikiaViewPageTarget.super.prototype.maybeShowDialogs.call( this );
	if ( parseInt( mw.config.get( 'showVisualEditorTransitionDialog' ) ) === 1 ) {
		this.surface.getDialogs().getWindow( 'wikiaPreference' ).open( null, null, this.surface );
	}
	//this.surface.getDialogs().getWindow( 'wikiaSingleMedia' ).open( null, null, this.surface );
};
