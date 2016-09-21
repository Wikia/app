/*!
 * VisualEditor MediaWiki Initialization WikiaViewPageTarget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw, veTrack, window, grecaptcha */

/**
 * Initialization MediaWiki view page target.
 *
 * @class
 * @extends ve.init.mw.ViewPageTarget
 *
 * @constructor
 */
ve.init.wikia.ViewPageTarget = function VeInitWikiaViewPageTarget() {
	// Parent constructor
	ve.init.wikia.ViewPageTarget.super.call( this );

	// Events
	this.connect( this, { saveWorkflowBegin: 'onSaveWorkflowBegin' } );

	// Properties
	this.toolbarSaveButtonEnableTracked = false;
};

/* Inheritance */

OO.inheritClass( ve.init.wikia.ViewPageTarget, ve.init.mw.ViewPageTarget );

/* Static Properties */

ve.init.wikia.ViewPageTarget.static.toolbarGroups = [
	// History
	{ include: [ 'undo' ] },
	// Format
	{
		type: 'menu',
		indicator: 'down',
		title: OO.ui.deferMsg( 'visualeditor-toolbar-format-tooltip' ),
		include: [ { group: 'format' } ],
		promote: [ 'paragraph' ],
		demote: [ 'preformatted' ],
		exclude: [ 'heading1' ]
	},
	// Style
	{ include: [ 'bold', 'italic', 'link' ] },
	{
		type: 'list',
		icon: 'text-style',
		indicator: 'down',
		title: OO.ui.deferMsg( 'visualeditor-toolbar-style-tooltip' ),
		include: [ 'subscript', 'superscript', 'strikethrough', 'underline', 'indent', 'outdent', 'clear' ]
	},
	{ include: [ 'wikiaVideoInsert', 'wikiaImageInsert', 'wikiaSingleMedia', 'bullet', 'number'] },
	// Insert
	{
		type: 'list',
		label: OO.ui.deferMsg( 'visualeditor-toolbar-insert' ),
		indicator: 'down',
		include: [ 'wikiaInfoboxInsert', 'wikiaMapInsert', 'wikiaTemplateInsert', 'reference', 'referencesList', 'insertTable' ]
	},
	// Table
	{
		header: OO.ui.deferMsg( 'visualeditor-toolbar-table' ),
		type: 'list',
		icon: 'table-insert',
		indicator: 'down',
		include: [ { group: 'table' } ],
		demote: [ 'deleteTable' ]
	}
];

ve.init.wikia.ViewPageTarget.static.actionsToolbarConfig = [
	{
		include: [ 'notices' ]
	},
	{
		type: 'list',
		icon: 'menu',
		indicator: 'down',
		include: [ 'meta', 'categories', 'wikiaHelp', 'commandHelp', 'wikiaSourceMode' ]
	}
];

//ve.init.wikia.ViewPageTarget.static.surfaceCommands.push( 'wikiaSourceMode' );

ve.init.wikia.ViewPageTarget.prototype.getNonEditableUIElements = function () {
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

ve.init.wikia.ViewPageTarget.prototype.onSaveWorkflowBegin = function () {
	var script = document.createElement( 'script' );
	script.src = 'https://www.google.com/recaptcha/api.js';
	document.getElementsByTagName( 'head' )[0].appendChild( script );
};

ve.init.wikia.ViewPageTarget.prototype.hidePageContent = function () {
	this.getNonEditableUIElements()
		.addClass( 've-init-mw-viewPageTarget-content' )
		.hide();

	$( 'body' ).addClass( 've' );
};

ve.init.wikia.ViewPageTarget.prototype.mutePageContent = function () {
	// Intentionally left empty
};

ve.init.wikia.ViewPageTarget.prototype.onSaveDialogReview = function () {
	ve.init.mw.ViewPageTarget.prototype.onSaveDialogReview.call( this );
	ve.track( 'wikia', {
		action: ve.track.actions.CLICK,
		label: 'dialog-save-review-changes-button',
		value: ve.track.normalizeDuration( this.events.timings.saveReview - this.events.timings.saveWorkflowBegin )
	} );
};

ve.init.wikia.ViewPageTarget.prototype.onToolbarCancelButtonClick = function () {
	if ( window.veTrack ) {
		veTrack( {
			action: 've-cancel-button-click',
			isDirty: !this.toolbarSaveButton.isDisabled() ? 'yes' : 'no'
		} );
	}
	ve.track( 'wikia', {
		action: ve.track.actions.CLICK,
		label: 'button-cancel',
		value: ve.track.normalizeDuration( ve.now() - this.events.timings.surfaceReady )
	} );
	mw.hook( 've.cancelButton' ).fire();

	this.deactivate();
};

ve.init.wikia.ViewPageTarget.prototype.onToolbarMetaButtonClick = function () {
	ve.track( 'wikia', { action: ve.track.actions.CLICK, label: 'tool-page-settings' } );
	ve.init.mw.ViewPageTarget.prototype.onToolbarMetaButtonClick.call( this );
};

ve.init.wikia.ViewPageTarget.prototype.onToolbarSaveButtonClick = function () {
	if ( window.veTrack ) {
		veTrack( { action: 've-save-button-click' } );
	}

	if ( window.veSourceEntryPoint ) {
		window.optimizely = window.optimizely || [];
		window.optimizely.push( ['trackEvent', 've-save-button-click'] );
	}

	ve.track( 'wikia', {
		action: ve.track.actions.CLICK,
		label: 'button-publish',
		value: ve.track.normalizeDuration( ve.now() - this.events.timings.surfaceReady )
	} );
	ve.init.mw.ViewPageTarget.prototype.onToolbarSaveButtonClick.call( this );
};

ve.init.wikia.ViewPageTarget.prototype.setupSkinTabs = function () {
	// Intentionally left empty
};

ve.init.wikia.ViewPageTarget.prototype.showPageContent = function () {
	$( '.ve-init-mw-viewPageTarget-content' )
		.removeClass( 've-init-mw-viewPageTarget-content' )
		.show()
		.fadeTo( 0, 1 );
	$( 'body' ).removeClass( 've' );
};

ve.init.wikia.ViewPageTarget.prototype.setupToolbarCancelButton = function () {
	this.toolbarCancelButton = new OO.ui.ButtonWidget( {
		label: ve.msg( 'visualeditor-dialog-action-cancel' ),
		flags: [ 'secondary' ]
	} );
	this.toolbarCancelButton.$element.addClass( 've-ui-toolbar-cancelButton' );
	this.toolbarCancelButton.connect( this, { click: 'onToolbarCancelButtonClick' } );
};

ve.init.wikia.ViewPageTarget.prototype.attachToolbarCancelButton = function () {
	$( '.ve-init-mw-viewPageTarget-toolbar-actions' ).prepend( this.toolbarCancelButton.$element );
};

ve.init.wikia.ViewPageTarget.prototype.updateToolbarSaveButtonState = function () {
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
			action: ve.track.actions.ENABLE,
			label: 'button-publish',
			value: ve.track.normalizeDuration( ve.now() - this.events.timings.surfaceReady )
		} );
	}
};

/**
 * @inheritdoc
 */
ve.init.wikia.ViewPageTarget.prototype.hideSpinner = function () {
	var $spinner = $( '.ve-spinner[data-type="loading"]' ),
		$throbber = $spinner.children(),
		$fade = $( '.ve-spinner-fade' );

	if ( $spinner.is( ':visible' ) ) {
		$throbber.hide();
		$fade.css( 'opacity', 1 );

		if ( this.timeout ) {
			setTimeout ( this.afterSpinnerFadeOpacityIn.bind( this, $spinner, $throbber ), this.timeout );
		} else {
			this.afterSpinnerFadeOpacityIn( $spinner, $throbber );
		}
	}
};

ve.init.wikia.ViewPageTarget.prototype.afterSpinnerFadeOpacityIn = function ( $spinner, $throbber ) {
	$spinner.hide();
	$throbber.show();
};

/**
 * @inheritdoc
 */
ve.init.wikia.ViewPageTarget.prototype.onLoadError = function ( jqXHR, status, error ) {
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
ve.init.wikia.ViewPageTarget.prototype.replacePageContent = function ( html, categoriesHtml ) {
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
ve.init.wikia.ViewPageTarget.prototype.onSerializeError = function ( jqXHR, status ) {
	if ( window.veTrack ) {
		veTrack( {
			action: 'parsoid-serialize-error',
			status: status
		} );
	}
	ve.init.wikia.ViewPageTarget.super.prototype.onSerializeError.call( this, jqXHR, status );
};

/**
 * Handle failure when retrieving diff
 *
 * @method
 * @param {object} jqXHR
 * @param {string} status Text status message
 */
ve.init.wikia.ViewPageTarget.prototype.onShowChangesError = function ( jqXHR, status ) {
	if ( window.veTrack ) {
		veTrack( {
			action: 'parsoid-diff-error',
			status: status
		} );
	}
	ve.init.wikia.ViewPageTarget.super.prototype.onShowChangesError.call( this, jqXHR, status );
};

/**
 * @inheritdoc
 */
ve.init.wikia.ViewPageTarget.prototype.changeDocumentTitle = function () {
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
ve.init.wikia.ViewPageTarget.prototype.onSaveError = function ( doc, saveData, jqXHR, status, data ) {
	if ( window.veTrack ) {
		veTrack( {
			action: 'parsoid-save-error',
			status: status,
			apiresponsedata: data
		} );
	}
	ve.init.wikia.ViewPageTarget.super.prototype.onSaveError.call( this, doc, saveData, jqXHR, status, data );
};

/**
 * @inheritdoc
 */
ve.init.wikia.ViewPageTarget.prototype.maybeShowDialogs = function () {
	// Parent method
	ve.init.wikia.ViewPageTarget.super.prototype.maybeShowDialogs.call( this );
	if ( parseInt( mw.config.get( 'showVisualEditorTransitionDialog' ) ) === 1 ) {
		this.surface.getDialogs().getWindow( 'wikiaPreference' ).open( null, null, this.surface );
	}
	//this.surface.getDialogs().getWindow( 'wikiaSingleMedia' ).open( null, null, this.surface );
};

/**
 * @inheritdoc
 */
ve.init.wikia.ViewPageTarget.prototype.onSaveErrorCaptcha = function () {
	var $captchaDiv = $( '<div>' ).addClass( 've-ui-mwSaveDialog-captcha' );

	if ( grecaptcha ) {
		this.captchaResponse = null;
		this.renderReCaptcha( $captchaDiv );
	} else {
		this.loadAndRenderFancyCaptcha( $captchaDiv );
	}

	this.saveDialog.clearMessage( 'api-save-error' );
	this.saveDialog.showMessage( 'api-save-error', $captchaDiv, { wrap: false } );
	this.saveDialog.popPending();
	this.events.trackSaveError( 'captcha' );
};

/**
 * Render reCaptcha
 *
 * @method
 * @param {jQuery} $container
 */
ve.init.mw.ViewPageTarget.prototype.renderReCaptcha = function ( $container ) {
	grecaptcha.render( $container[0], {
		sitekey: mw.config.get( 'reCaptchaPublicKey' ),
		theme: 'light',
		callback: function ( response ) {
			this.captchaResponse = response;
		}.bind( this )
	} );
};

/**
 * Render Fancy Captcha
 *
 * @method
 * @param {jQuery} $container
 */
ve.init.mw.ViewPageTarget.prototype.loadAndRenderFancyCaptcha = function ( $container ) {
	var getFancyCaptchaDeferred = $.Deferred();

	$.nirvana.sendRequest( {
		controller: 'CaptchaController',
		method: 'getFancyCaptcha',
		type: 'GET',
		callback: function ( data ) {
			getFancyCaptchaDeferred.resolve( data );
		}
	} );

	$.when(
		getFancyCaptchaDeferred,
		$.getResources( [ $.getSassCommonURL('extensions/wikia/Captcha/styles/FancyCaptcha.scss') ] )
	).done( function ( getFancyCaptchaResolved ) {
		$container.append( getFancyCaptchaResolved.form );
	} );
};
