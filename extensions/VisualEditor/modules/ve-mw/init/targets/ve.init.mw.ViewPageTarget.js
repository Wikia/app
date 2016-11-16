/*!
 * VisualEditor MediaWiki Initialization ViewPageTarget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global confirm, alert, veTrack */

/**
 * Initialization MediaWiki view page target.
 *
 * @class
 * @extends ve.init.mw.Target
 *
 * @constructor
 */
ve.init.mw.ViewPageTarget = function VeInitMwViewPageTarget() {
	var prefName,
		prefValue,
		// A workaround, as default URI does not get updated after pushState (bug 72334)
		currentUri = new mw.Uri( location.href ),
		conf = mw.config.get( 'wgVisualEditorConfig' );

	// Parent constructor
	ve.init.mw.Target.call( this, mw.config.get( 'wgRelevantPageName' ), currentUri.query.oldid );

	// Properties
	this.toolbarSaveButton = null;
	this.saveDialog = null;
	this.onBeforeUnloadFallback = null;
	this.onBeforeUnloadHandler = null;
	this.active = false;
	this.activating = false;
	this.deactivating = false;
	this.edited = false;
	this.recreating = false;
	// If this is true then #transformPage / #restorePage will not call pushState
	// This is to avoid adding a new history entry for the url we just got from onpopstate
	// (which would mess up with the expected order of Back/Forwards browsing)
	this.actFromPopState = false;
	this.popState = {
		tag: 'visualeditor'
	};
	this.scrollTop = null;
	this.currentUri = currentUri;
	this.section = currentUri.query.vesection;
	this.initialEditSummary = currentUri.query.summary;
	this.namespaceName = mw.config.get( 'wgCanonicalNamespace' );
	this.viewUri = new mw.Uri( mw.util.getUrl( this.pageName ) );
	this.veEditUri = this.viewUri.clone().extend( { veaction: 'edit' } );
	this.isViewPage = (
		mw.config.get( 'wgAction' ) === 'view' &&
		currentUri.query.diff === undefined
	);
	this.originalDocumentTitle = document.title;
	this.tabLayout = mw.config.get( 'wgVisualEditorConfig' ).tabLayout;

	// Add modules specific to desktop (modules shared with mobile go in MWTarget)
	this.modules.push(
		'ext.visualEditor.mwformatting',
		'ext.visualEditor.mwgallery',
		'ext.visualEditor.mwimage',
		'ext.visualEditor.mwmeta'
	);

	// Load preference modules
	for ( prefName in conf.preferenceModules ) {
		prefValue = mw.config.get( 'wgUserName' ) === null ?
			conf.defaultUserOptions[prefName] :
			mw.user.options.get( prefName, conf.defaultUserOptions[prefName] );
		if ( prefValue && prefValue !== '0' ) {
			this.modules.push( conf.preferenceModules[prefName] );
		}
	}

	// Events
	this.connect( this, {
		save: 'onSave',
		saveErrorEmpty: 'onSaveErrorEmpty',
		saveErrorSpamBlacklist: 'onSaveErrorSpamBlacklist',
		saveErrorAbuseFilter: 'onSaveErrorAbuseFilter',
		saveErrorNewUser: 'onSaveErrorNewUser',
		saveErrorCaptcha: 'onSaveErrorCaptcha',
		saveErrorUnknown: 'onSaveErrorUnknown',
		saveErrorPageDeleted: 'onSaveErrorPageDeleted',
		loadError: 'onLoadError',
		surfaceReady: 'onSurfaceReady',
		editConflict: 'onEditConflict',
		showChanges: 'onShowChanges',
		showChangesError: 'onShowChangesError',
		noChanges: 'onNoChanges',
		serializeError: 'onSerializeError',
		sanityCheckComplete: 'updateToolbarSaveButtonState'
	} );

	if ( currentUri.query.venotify ) {
		// The following messages can be used here:
		// postedit-confirmation-saved
		// postedit-confirmation-created
		// postedit-confirmation-restored
		mw.hook( 'postEdit' ).fire( {
			message: ve.msg( 'postedit-confirmation-' + currentUri.query.venotify, mw.user )
		} );

		delete currentUri.query.venotify;
	}

	if ( history.replaceState ) {
		// This is to stop the back button breaking when it's supposed to take us back out
		// of VE. It used to only be called when venotify is used. FIXME: there should be
		// a much better solution than this.
		history.replaceState( this.popState, document.title, currentUri );
	}

	this.setupSkinTabs();

	window.addEventListener( 'popstate', this.onWindowPopState.bind( this ) );
};

/* Inheritance */

OO.inheritClass( ve.init.mw.ViewPageTarget, ve.init.mw.Target );

/* Static Properties */

ve.init.mw.ViewPageTarget.static.actionsToolbarConfig = [
	{ include: [ 'help', 'notices' ] },
	{
		type: 'list',
		icon: 'menu',
		title: ve.msg( 'visualeditor-pagemenu-tooltip' ),
		include: [ 'meta', 'settings', 'advancedSettings', 'categories', 'languages', 'editModeSource', 'findAndReplace' ]
	}
];

/**
 * Compatibility map used with jQuery.client to black-list incompatible browsers.
 *
 * @static
 * @property
 */
ve.init.mw.ViewPageTarget.compatibility = {
	// The key is the browser name returned by jQuery.client
	// The value is either null (match all versions) or a list of tuples
	// containing an inequality (<,>,<=,>=) and a version number
	whitelist: {
		firefox: [['>=', 15]],
		iceweasel: [['>=', 10]],
		safari: [['>=', 6]],
		chrome: [['>=', 19]],
		opera: [['>=', 15]]
	}
};

/* Events */

/**
 * @event saveWorkflowBegin
 * Fired when user clicks the button to open the save dialog.
 */

/**
 * @event saveWorkflowEnd
 * Fired when user exits the save workflow
 */

/**
 * @event saveReview
 * Fired when user initiates review changes in save workflow
 */

/**
 * @event saveInitiated
 * Fired when user initiates saving of the document
 */

/* Methods */

/**
 * Verify that a PopStateEvent correlates to a state we created.
 *
 * @param {Mixed} popState From PopStateEvent#state
 * @return {boolean}
 */
ve.init.mw.ViewPageTarget.prototype.verifyPopState = function ( popState ) {
	return popState && popState.tag === 'visualeditor';
};

/**
 * @inheritdoc
 */
ve.init.mw.ViewPageTarget.prototype.setupToolbar = function ( surface ) {
	var $firstHeading;
	// Parent method
	ve.init.mw.Target.prototype.setupToolbar.call( this, surface );

	// Keep it hidden so that we can slide it down smoothly (avoids sudden
	// offset flash when original content is hidden, and replaced in-place with a
	// similar-looking surface).
	// FIXME: This is not ideal, the parent class creates it and appends
	// to target (visibly), only for us to hide it again 0ms later.
	// Though we can't hide it by default because it needs visible dimensions
	// to compute stuff during setup.
	this.getToolbar().$bar.hide();

	this.getToolbar().$element
		.addClass( 've-init-mw-viewPageTarget-toolbar' );

	// Wikia change - #WikiaPageHeader instead of #firstHeading and after instead of before
	// Move the toolbar to before #firstHeading if it exists
	$firstHeading = $( '#WikiaPageHeader' );
	if ( $firstHeading.length ) {
		this.getToolbar().$element.insertAfter( $firstHeading );
	}

	this.getToolbar().$bar.slideDown( 'fast', function () {
		// Check the surface wasn't torn down while the toolbar was animating
		if ( this.getSurface() ) {
			this.getToolbar().initialize();
			this.getSurface().getView().emit( 'position' );
			this.getSurface().getContext().updateDimensions();
		}
	}.bind( this ) );
};

/**
 * Set up notices for things like unknown browsers.
 * Needs to be done on each activation because localNoticeMessages is cleared in clearState
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.setupLocalNoticeMessages = function () {
	if ( mw.config.get( 'wgTranslatePageTranslation' ) === 'source' ) {
		// Warn users if they're on a source of the Page Translation feature
		this.localNoticeMessages.push( 'visualeditor-pagetranslationwarning' );
	}

	if ( !(
		'vewhitelist' in this.currentUri.query ||
		$.client.test( ve.init.mw.ViewPageTarget.compatibility.whitelist, null, true )
	) ) {
		// Show warning in unknown browsers that pass the support test
		// Continue at own risk.
		this.localNoticeMessages.push( 'visualeditor-browserwarning' );
	}
};

/**
 * Switch to edit mode.
 *
 * @method
 * @return {jQuery.Promise}
 */
ve.init.mw.ViewPageTarget.prototype.activate = function () {
	var extraModules = [ 'user' ];
	if ( !this.active && !this.activating ) {
		this.activating = true;
		this.activatingDeferred = $.Deferred();

		this.originalEditondbclick = mw.user.options.get( 'editondblclick' );
		mw.user.options.set( 'editondblclick', 0 );

		this.onDocumentKeyDownHandler = this.onDocumentKeyDown.bind( this );
		$( document ).on( 'keydown', this.onDocumentKeyDownHandler );

		// User interface changes
		this.transformPage();
		this.hideReadOnlyContent();
		this.mutePageContent();
		this.mutePageTitle();
		this.setupLocalNoticeMessages();

		this.saveScrollPosition();

		// Only ensure site JS is loaded if it is enabled (SEC-73)
		if ( mw.config.get( 'wgUseSiteJs' ) ) {
			extraModules[extraModules.length] = 'site';
		}

		this.load( extraModules );
	}
	return this.activatingDeferred.promise();
};

/**
 * Determines whether we want to switch to view mode or not (displaying a dialog if necessary)
 * Then, if we do, actually switches to view mode.
 *
 * A dialog will not be shown if deactivate() is called while activation is still in progress,
 * or if the noDialog parameter is set to true. If deactivate() is called while the target
 * is deactivating, or while it's not active and not activating, nothing happens.
 *
 * @param {boolean} [noDialog] Do not display a dialog
 * @param {string} [trackMechanism] Abort mechanism; used for event tracking if present
 */
ve.init.mw.ViewPageTarget.prototype.deactivate = function ( noDialog, trackMechanism ) {
	var target = this;
	if ( this.deactivating || ( !this.active && !this.activating ) ) {
		return;
	}

	if ( noDialog || this.activating || !this.edited ) {
		this.cancel( trackMechanism );
	} else {
		this.getSurface().dialogs.openWindow( 'cancelconfirm' ).then( function ( opened ) {
			opened.then( function ( closing ) {
				closing.then( function ( data ) {
					if ( data && data.action === 'discard' ) {
						target.cancel( trackMechanism );
					}
				} );
			} );
		} );
	}
};

/**
 * Switch to view mode
 *
 * @param {string} [trackMechanism] Abort mechanism; used for event tracking if present
 */
ve.init.mw.ViewPageTarget.prototype.cancel = function ( trackMechanism ) {
	var abortType, promises = [];

	// Event tracking
	if ( trackMechanism ) {
		if ( this.activating ) {
			abortType = 'preinit';
		} else if ( !this.edited ) {
			abortType = 'nochange';
		} else if ( this.saving ) {
			abortType = 'abandonMidsave';
		} else {
			// switchwith and switchwithout do not go through this code path,
			// they go through switchToWikitextEditor() instead
			abortType = 'abandon';
		}
		ve.track( 'mwedit.abort', {
			type: abortType,
			mechanism: trackMechanism
		} );
	}

	this.deactivating = true;
	// User interface changes
	if ( this.elementsThatHadOurAccessKey ) {
		this.elementsThatHadOurAccessKey.attr( 'accesskey', ve.msg( 'accesskey-save' ) );
	}
	this.restorePage();
	this.hideSpinner();
	this.showReadOnlyContent();

	$( document ).off( 'keydown', this.onDocumentKeyDownHandler );

	mw.user.options.set( 'editondblclick', this.originalEditondbclick );
	this.originalEditondbclick = undefined;

	if ( this.toolbarSaveButton ) {
		// If deactivate is called before a successful load, then the save button has not yet been
		// fully set up so disconnecting it would throw an error when trying call methods on the
		// button property (bug 46456)
		this.toolbarSaveButton.disconnect( this );
		this.toolbarSaveButton.$element.detach();
		this.getToolbar().$actions.empty();
	}

	// Check we got as far as setting up the surface
	if ( this.active ) {
		this.tearDownBeforeUnloadHandler();
		// If we got as far as setting up the surface, tear that down
		promises.push( this.tearDownSurface() );
	}

	$.when.apply( $, promises ).then( function () {
		// Show/restore components that are otherwise handled by tearDownSurface
		this.showPageContent();
		this.restorePageTitle();

		// If there is a load in progress, abort it
		if ( this.loading ) {
			this.loading.abort();
		}

		this.clearState();
		this.docToSave = null;
		this.initialEditSummary = new mw.Uri().query.summary;

		this.deactivating = false;
		this.activating = false;
		this.activatingDeferred.reject();

		mw.hook( 've.deactivationComplete' ).fire( this.edited );
	}.bind( this ) );
};

/**
 * Handle failed DOM load event.
 *
 * @method
 * @param {jqXHR|null} jqXHR jQuery XHR object
 * @param {string} status Text status message
 * @param {Mixed|null} error Thrown exception or HTTP error string
 */
ve.init.mw.ViewPageTarget.prototype.onLoadError = function ( jqXHR, status ) {
	// Don't show an error if the load was manually aborted
	// The response.status check here is to catch aborts triggered by navigation away from the page
	if (
		status !== 'abort' &&
		( !jqXHR || ( jqXHR.status !== 0 && jqXHR.status !== 504 ) ) &&
		confirm( ve.msg( 'visualeditor-loadwarning', status ) )
	) {
		this.load();
	} else if (
		jqXHR && jqXHR.status === 504 &&
		confirm( ve.msg( 'visualeditor-timeout' ) )
	) {
		if ( 'veaction' in this.currentUri.query ) {
			delete this.currentUri.query.veaction;
		}
		this.currentUri.query.action = 'edit';
		location.href = this.currentUri.toString();
	} else {
		// Something weird happened? Deactivate
		// TODO: how does this handle load errors triggered from
		// calling this.loading.abort()?
		// this.activating = false;
		// Not passing trackMechanism because we don't know what happened
		// and this is not a user action
		this.deactivate( true );
	}
};

/**
 * Once surface is ready ready, init UI
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onSurfaceReady = function () {
	var surfaceReadyTime = ve.now();
	if ( !this.activating ) {
		// Activation was aborted before we got here. Do nothing
		// TODO are there things we need to clean up?
		return;
	}
	this.activating = false;
	this.getSurface().getModel().connect( this, {
		history: 'updateToolbarSaveButtonState'
	} );

	// TODO: mwTocWidget should probably live in a ve.ui.MWSurface subclass
	if ( mw.config.get( 'wgVisualEditorConfig' ).enableTocWidget ) {
		this.getSurface().mwTocWidget = new ve.ui.MWTocWidget( this.getSurface() );
	}

	this.setupToolbarSaveButton();
	this.attachToolbarSaveButton();

	// Wikia change - add Cancel button
	this.setupToolbarCancelButton();
	this.attachToolbarCancelButton();

	// Update UI
	this.hideSpinner();
	if ( this.timeout ) {
		setTimeout( this.afterHideSpinner.bind( this, surfaceReadyTime ), this.timeout );
	} else {
		this.afterHideSpinner( surfaceReadyTime );
	}
};

ve.init.mw.ViewPageTarget.prototype.afterHideSpinner = function ( surfaceReadyTime ) {
	this.transformPageTitle();
	this.changeDocumentTitle();
	this.hidePageContent();

	this.toolbar.initialize();
	this.surface.getFocusWidget().$element.show();

	this.surface.getView().focus();

	this.restoreScrollPosition();
	this.restoreEditSection();
	this.setupBeforeUnloadHandler();
	this.maybeShowDialogs();

	$( '.ve-spinner-fade' ).css( 'opacity', 0 );
	if ( this.timeout ) {
		setTimeout( this.afterSpinnerFadeOpacityOut.bind( this, surfaceReadyTime ), this.timeout );
	} else {
		this.afterSpinnerFadeOpacityOut( surfaceReadyTime );
	}
};

ve.init.mw.ViewPageTarget.prototype.afterSpinnerFadeOpacityOut = function ( surfaceReadyTime ) {
	this.toolbar.$element.removeClass( 'transition' );
	$( '.ve-spinner-fade' ).hide();

	if ( window.veTrack ) {
		veTrack( { action: 've-edit-page-stop' } );
	}

	// Track how long it takes for the first transaction to happen
	this.surface.getModel().getDocument().once( 'transact', function () {
		ve.track( 'mwtiming.behavior.firstTransaction', { duration: ve.now() - surfaceReadyTime } );
	} );

	this.activatingDeferred.resolve();
	mw.hook( 've.activationComplete' ).fire();
};

/**
 * Handle Escape key presses.
 * @param {jQuery.Event} e Keydown event
 */
ve.init.mw.ViewPageTarget.prototype.onDocumentKeyDown = function ( e ) {
	var target = this;
	if ( e.which === OO.ui.Keys.ESCAPE ) {
		setTimeout( function () {
			// Listeners should stopPropagation if they handle the escape key, but
			// also check they didn't fire after this event, as would be the case if
			// they were bound to the document.
			if ( !e.isPropagationStopped() ) {
				target.deactivate( false, 'navigate-read' );
			}
		} );
		e.preventDefault();
	}
};

/**
 * Handle clicks on the view tab.
 *
 * @method
 * @param {jQuery.Event} e Mouse click event
 */
ve.init.mw.ViewPageTarget.prototype.onViewTabClick = function ( e ) {
	if ( ( e.which && e.which !== 1 ) || e.shiftKey || e.altKey || e.ctrlKey || e.metaKey ) {
		return;
	}
	this.deactivate( false, 'navigate-read' );
	e.preventDefault();
};

/**
 * Handle successful DOM save event.
 *
 * @method
 * @param {string} html Rendered page HTML from server
 * @param {string} categoriesHtml Rendered categories HTML from server
 * @param {number} newid New revision id, undefined if unchanged
 * @param {boolean} isRedirect Whether this page is a redirect or not
 * @param {string} displayTitle What HTML to show as the page title
 * @param {Object} lastModified Object containing user-formatted date
    and time strings, or undefined if we made no change.
 */
ve.init.mw.ViewPageTarget.prototype.onSave = function (
	html, categoriesHtml, newid, isRedirect, displayTitle, lastModified, contentSub
) {
	var newUrlParams, watchChecked;
	this.saveDeferred.resolve();
	if ( !this.pageExists || this.restoring ) {
		// This is a page creation or restoration, refresh the page
		this.tearDownBeforeUnloadHandler();
		newUrlParams = newid === undefined ? {} : { venotify: this.restoring ? 'restored' : 'created' };

		if ( isRedirect ) {
			newUrlParams.redirect = 'no';
		}
		location.href = this.viewUri.extend( newUrlParams );
	} else {
		// Update watch link to match 'watch checkbox' in save dialog.
		// User logged in if module loaded.
		// Just checking for mw.page.watch is not enough because in Firefox
		// there is Object.prototype.watch...
		if ( mw.page.watch && mw.page.watch.updateWatchLink ) {
			watchChecked = this.saveDialog.$saveOptions
				.find( '.ve-ui-mwSaveDialog-checkboxes' )
					.find( '#wpWatchthis' )
					.prop( 'checked' );
			mw.page.watch.updateWatchLink(
				$( '#ca-watch a, #ca-unwatch a' ),
				watchChecked ? 'unwatch' : 'watch'
			);
		}

		// If we were explicitly editing an older version, make sure we won't
		// load the same old version again, now that we've saved the next edit
		// will be against the latest version.
		// TODO: What about oldid in the url?
		this.restoring = false;

		if ( newid !== undefined ) {
			mw.config.set( {
				wgCurRevisionId: newid,
				wgRevisionId: newid
			} );
			this.revid = newid;
		}
		this.saveDialog.reset();
		this.replacePageContent(
			html,
			categoriesHtml,
			displayTitle,
			lastModified,
			contentSub
		);
		this.setupSectionEditLinks();
		// Tear down the target now that we're done saving
		// Not passing trackMechanism because this isn't an abort action
		this.deactivate( true );
		if ( newid !== undefined ) {
			mw.hook( 'postEdit' ).fire( {
				message: ve.msg( 'postedit-confirmation-saved', mw.user )
			} );
		}
	}
};

/**
 * @inheritdoc
 */
ve.init.mw.ViewPageTarget.prototype.onSaveError = function () {
	this.pageDeletedWarning = false;
	ve.init.mw.ViewPageTarget.super.prototype.onSaveError.apply( this, arguments );
};

/**
 * Update save dialog message on general error
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onSaveErrorEmpty = function () {
	this.showSaveError( ve.msg( 'visualeditor-saveerror', 'Empty server response' ), false /* prevents reapply */ );
};

/**
 * Update save dialog message on spam blacklist error
 *
 * @method
 * @param {Object} editApi
 */
ve.init.mw.ViewPageTarget.prototype.onSaveErrorSpamBlacklist = function ( editApi ) {
	this.showSaveError(
		ve.msg( 'spamprotectiontext' ) + ' ' +
			ve.msg(
				'spamprotectionmatch', mw.language.listToText( editApi.spamblacklist.split( '|' ) )
			),
		false // prevents reapply
	);
};

/**
 * Update save dialog message on spam blacklist error
 *
 * @method
 * @param {Object} editApi
 */
ve.init.mw.ViewPageTarget.prototype.onSaveErrorAbuseFilter = function ( editApi ) {
	this.showSaveError( $( $.parseHTML( editApi.warning ) ) );
	// Don't disable the save button. If the action is not disallowed the user may save the
	// edit by pressing Save again. The AbuseFilter API currently has no way to distinguish
	// between filter triggers that are and aren't disallowing the action.
};

/**
 * Update save dialog when token fetch indicates another user is logged in
 *
 * @method
 * @param {string|null} username Name of newly logged-in user, or null if anonymous
 */
ve.init.mw.ViewPageTarget.prototype.onSaveErrorNewUser = function ( username ) {
	var badToken, userMsg;
	badToken = document.createTextNode( mw.msg( 'visualeditor-savedialog-error-badtoken' ) + ' ' );
	// mediawiki.jqueryMsg has a bug with [[User:$1|$1]] (bug 51388)
	if ( username === null ) {
		userMsg = 'visualeditor-savedialog-identify-anon';
	} else {
		userMsg = 'visualeditor-savedialog-identify-user---' + username;
	}
	this.showSaveError(
		$( badToken ).add( $.parseHTML( mw.message( userMsg ).parse() ) )
	);
};

/**
 * Update save dialog on captcha error
 *
 * @method
 * @param {Object} editApi
 */
ve.init.mw.ViewPageTarget.prototype.onSaveErrorCaptcha = function ( editApi ) {
	var $captchaDiv = $( '<div>' ), $captchaParagraph = $( '<p>' );

	this.captcha = {
		input: new OO.ui.TextInputWidget(),
		id: editApi.captcha.id
	};
	$captchaDiv.append( $captchaParagraph );
	$captchaParagraph.append(
		$( '<strong>' ).text( mw.msg( 'captcha-label' ) ),
		document.createTextNode( mw.msg( 'colon-separator' ) )
	);
	if ( editApi.captcha.url ) { // FancyCaptcha
		$captchaParagraph.append(
			$( $.parseHTML( mw.message( 'fancycaptcha-edit' ).parse() ) )
				.filter( 'a' ).attr( 'target', '_blank' ).end()
		);
		$captchaDiv.append(
			$( '<img>' ).attr( 'src', editApi.captcha.url )
		);
	} else if ( editApi.captcha.type === 'simple' || editApi.captcha.type === 'math' ) {
		// SimpleCaptcha and MathCaptcha
		$captchaParagraph.append(
			mw.message( 'captcha-edit' ).parse(),
			'<br>',
			document.createTextNode( editApi.captcha.question )
		);
	} else if ( editApi.captcha.type === 'question' ) {
		// QuestyCaptcha
		$captchaParagraph.append(
			mw.message( 'questycaptcha-edit' ).parse(),
			'<br>',
			editApi.captcha.question
		);
	}

	$captchaDiv.append( this.captcha.input.$element );

	// ProcessDialog's error system isn't great for this yet.
	this.saveDialog.clearMessage( 'api-save-error' );
	this.saveDialog.showMessage( 'api-save-error', $captchaDiv );
	this.saveDialog.popPending();
};

/**
 * Update save dialog message on unknown error
 *
 * @method
 * @param {Object} editApi
 * @param {Object|null} data API response data
 */
ve.init.mw.ViewPageTarget.prototype.onSaveErrorUnknown = function ( editApi, data ) {
	this.showSaveError(
		$( document.createTextNode(
			( editApi && editApi.info ) ||
			( data.error && data.error.info ) ||
			( editApi && editApi.code ) ||
			( data.error && data.error.code ) ||
			'Unknown error'
		) ),
		false // prevents reapply
	);
};

/**
 * Update save dialog message on page deleted error
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onSaveErrorPageDeleted = function () {
	var continueLabel = mw.msg( 'ooui-dialog-process-continue' );

	this.pageDeletedWarning = true;
	this.showSaveError( mw.msg( 'visualeditor-recreate', continueLabel ), true, true );
};

/**
 * Handle MWSaveDialog retry events
 * So we can handle trying to save again after page deletion warnings
 */
ve.init.mw.ViewPageTarget.prototype.onSaveRetry = function () {
	if ( this.pageDeletedWarning ) {
		this.recreating = true;
		this.pageExists = false;
	}
};

/**
 * Update save dialog api-save-error message
 *
 * @method
 * @param {string|jQuery|Node[]} msg Message content (string of HTML, jQuery object or array of
 *  Node objects)
 * @param {boolean} [allowReapply=true] Whether or not to allow the user to reapply.
 *  Reset when swapping panels. Assumed to be true unless explicitly set to false.
 * @param {boolean} [warning=false] Whether or not this is a warning.
 */
ve.init.mw.ViewPageTarget.prototype.showSaveError = function ( msg, allowReapply, warning ) {
	this.saveDeferred.reject( [ new OO.ui.Error( msg, { recoverable: allowReapply, warning: warning } ) ] );
};

/**
 * Handle Show changes event.
 *
 * @method
 * @param {string} diffHtml
 */
ve.init.mw.ViewPageTarget.prototype.onShowChanges = function ( diffHtml ) {
	// Invalidate the viewer diff on next change
	this.getSurface().getModel().getDocument().once( 'transact',
		this.saveDialog.clearDiff.bind( this.saveDialog )
	);
	this.saveDialog.setDiffAndReview( diffHtml );
};

/**
 * Handle failed show changes event.
 *
 * @method
 * @param {Object} jqXHR
 * @param {string} status Text status message
 */
ve.init.mw.ViewPageTarget.prototype.onShowChangesError = function ( jqXHR, status ) {
	alert( ve.msg( 'visualeditor-differror', status ) );
	this.saveDialog.popPending();
};

/**
 * Called if a call to target.serialize() failed.
 *
 * @method
 * @param {jqXHR|null} jqXHR
 * @param {string} status Text status message
 */
ve.init.mw.ViewPageTarget.prototype.onSerializeError = function ( jqXHR, status ) {
	alert( ve.msg( 'visualeditor-serializeerror', status ) );

	// It's possible to get here while the save dialog has never been opened (if the user uses
	// the switch to source mode option)
	if ( this.saveDialog ) {
		this.saveDialog.popPending();
	}
};

/**
 * Handle edit conflict event.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onEditConflict = function () {
	this.saveDialog.popPending();
	this.saveDialog.swapPanel( 'conflict' );
};

/**
 * Handle failed show changes event.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onNoChanges = function () {
	this.saveDialog.popPending();
	this.saveDialog.swapPanel( 'nochanges' );
	this.saveDialog.getActions().setAbilities( { approve: true } );
};

/**
 * Handle clicks on the save button in the toolbar.
 *
 * @method
 * @param {jQuery.Event} e Mouse click event
 */
ve.init.mw.ViewPageTarget.prototype.onToolbarSaveButtonClick = function () {
	if ( this.edited || this.restoring ) {
		this.showSaveDialog();
	}
};

/**
 * Handle clicks on the MwMeta button in the toolbar.
 *
 * @method
 * @param {jQuery.Event} e Mouse click event
 */
ve.init.mw.ViewPageTarget.prototype.onToolbarMetaButtonClick = function () {
	this.getSurface().getDialogs().openWindow( 'meta' );
};

/**
 * Re-evaluate whether the toolbar save button should be disabled or not.
 */
ve.init.mw.ViewPageTarget.prototype.updateToolbarSaveButtonState = function () {
	var isDisabled;

	this.edited = this.getSurface().getModel().hasBeenModified() || this.wikitext !== null;
	// Disable the save button if we have no history or if the sanity check is not finished
	isDisabled = ( !this.edited && !this.restoring ) || !this.sanityCheckFinished;
	this.toolbarSaveButton.setDisabled( isDisabled );
	this.toolbarSaveButton.$element.toggleClass( 've-init-mw-viewPageTarget-waiting', !this.sanityCheckFinished );
	mw.hook( 've.toolbarSaveButton.stateChanged' ).fire( isDisabled );
};

/**
 * Handle clicks on the review button in the save dialog.
 *
 * @method
 * @fires saveReview
 */
ve.init.mw.ViewPageTarget.prototype.onSaveDialogReview = function () {
	this.sanityCheckVerified = true;
	this.saveDialog.setSanityCheck( this.sanityCheckVerified );

	if ( !this.saveDialog.$reviewViewer.find( 'table, pre' ).length ) {
		this.emit( 'saveReview' );
		this.saveDialog.getActions().setAbilities( { approve: false } );
		this.saveDialog.pushPending();
		if ( this.pageExists ) {
			// Has no callback, handled via target.onShowChanges
			this.showChanges( this.docToSave );
		} else {
			this.serialize( this.docToSave, this.onSaveDialogReviewComplete.bind( this ) );
		}
	} else {
		this.saveDialog.swapPanel( 'review' );
	}
};

/**
 * Handle completed serialize request for diff views for new page creations.
 *
 * @method
 * @param {string} wikitext
 */
ve.init.mw.ViewPageTarget.prototype.onSaveDialogReviewComplete = function ( wikitext ) {
	// Invalidate the viewer wikitext on next change
	this.getSurface().getModel().getDocument().once( 'transact',
		this.saveDialog.clearDiff.bind( this.saveDialog )
	);
	this.saveDialog.setDiffAndReview( $( '<pre>' ).text( wikitext ) );
};

/**
 * Try to save the current document.
 * @fires saveInitiated
 * @param {jQuery.Deferred} saveDeferred Deferred object to resolve/reject when the save
 *  succeeds/fails.
 */
ve.init.mw.ViewPageTarget.prototype.saveDocument = function ( saveDeferred ) {
	if ( this.deactivating ) {
		return false;
	}

	var saveOptions = this.getSaveOptions();
	this.emit( 'saveInitiated' );

	// Reset any old captcha data
	if ( this.captchaResponse ) {
		this.captchaResponse = null;
	}

	if (
		+mw.user.options.get( 'forceeditsummary' ) &&
		saveOptions.summary === '' &&
		!this.saveDialog.messages.missingsummary
	) {
		this.saveDialog.showMessage(
			'missingsummary',
			// Wrap manually since this core message already includes a bold "Warning:" label
			$( '<p>' ).append( ve.init.platform.getParsedMessage( 'missingsummary' ) ),
			{ wrap: false }
		);
		this.saveDialog.popPending();
	} else {
		this.save( this.docToSave, saveOptions );
		this.saveDeferred = saveDeferred;
	}
};

/**
 * Open the dialog to switch to edit source mode with the current wikitext, or just do it straight
 * away if the document is unmodified. If we open the dialog, the document opacity will be set to
 * half, which can be reset with the resetDocumentOpacity function.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.editSource = function () {
	if ( !this.getSurface().getModel().hasBeenModified() ) {
		this.switchToWikitextEditor( true );
		return;
	}

	this.getSurface().getView().getDocument().getDocumentNode().$element.css( 'opacity', 0.5 );

	this.getSurface().getDialogs().openWindow( 'wikitextswitchconfirm', { target: this } );
};

/**
 * Handle clicks on the resolve conflict button in the conflict dialog.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onSaveDialogResolveConflict = function () {
	// Get Wikitext from the DOM, and set up a submit call when it's done
	this.serialize(
		this.docToSave,
		this.submitWithSaveFields.bind( this, { wpSave: 1 } )
	);
};

/**
 * Get save form fields from the save dialog form.
 * @returns {Object} Form data for submission to the MediaWiki action=edit UI
 */
ve.init.mw.ViewPageTarget.prototype.getSaveFields = function () {
	var fields = {};
	this.$checkboxes
		.each( function () {
			var $this = $( this );
			// We can't just use $this.val() because .val() always returns the value attribute of
			// a checkbox even when it's unchecked
			if ( $this.prop ( 'name' ) && ( $this.prop( 'type' ) !== 'checkbox' || $this.prop( 'checked' ) ) ) {
				fields[$this.prop( 'name' )] = $this.val();
			}
		} );
	ve.extendObject( fields, {
		wpSummary: this.saveDialog ? this.saveDialog.editSummaryInput.getValue() : this.initialEditSummary,
		wpCaptchaClass: this.saveDialog.$( '#wpCaptchaClass' ).val(),
		wpCaptchaId: this.saveDialog.$( '#wpCaptchaId' ).val(),
		wpCaptchaWord: this.saveDialog.$( '#wpCaptchaWord' ).val(),
		'g-recaptcha-response': this.captchaResponse
	} );
	if ( this.recreating ) {
		fields.wpRecreate = true;
	}
	return fields;
};

/**
 * Invoke #submit with the data from #getSaveFields
 * @param {Object} fields Fields to add in addition to those from #getSaveFields
 * @param {string} wikitext Wikitext to submit
 * @returns {boolean} Whether submission was started
 */
ve.init.mw.ViewPageTarget.prototype.submitWithSaveFields = function ( fields, wikitext ) {
	return this.submit( wikitext, $.extend( this.getSaveFields(), fields ) );
};

/**
 * Get edit API options from the save dialog form.
 * @returns {Object} Save options for submission to the MediaWiki API
 */
ve.init.mw.ViewPageTarget.prototype.getSaveOptions = function () {
	var key, options = this.getSaveFields(),
		fieldMap = {
			wpSummary: 'summary',
			wpMinoredit: 'minor',
			wpWatchthis: 'watch',
			wpCaptchaId: 'captchaid',
			wpCaptchaWord: 'captchaword'
		};

	for ( key in fieldMap ) {
		if ( options[key] !== undefined ) {
			options[fieldMap[key]] = options[key];
			delete options[key];
		}
	}

	if ( this.sanityCheckPromise.state() === 'rejected' ) {
		options.needcheck = 1;
	}

	return options;
};

/**
 * Switch to viewing mode.
 *
 * @method
 * @param {boolean} [noAnimate] Don't animate toolbar teardown
 * @return {jQuery.Promise} Promise resolved when surface is torn down
 */
ve.init.mw.ViewPageTarget.prototype.tearDownSurface = function ( noAnimate ) {
	var promises = [];

	// Update UI
	this.tearDownToolbar( noAnimate );
	this.tearDownDebugBar();
	this.restoreDocumentTitle();
	if ( this.getSurface().mwTocWidget ) {
		this.getSurface().mwTocWidget.teardown();
	}

	if ( this.saveDialog ) {
		if ( this.saveDialog.isOpened() ) {
			// If the save dialog is still open (from saving) close it
			promises.push( this.saveDialog.close() );
		}
		// Release the reference
		this.saveDialog = null;
	}

	return $.when.apply( $, promises ).then( function () {
		// Destroy surface
		while ( this.surfaces.length ) {
			this.surfaces.pop().destroy();
		}
		this.active = false;
	}.bind( this ) );
};

/**
 * Modify tabs in the skin to support in-place editing.
 * Edit tab is bound outside the module in mw.ViewPageTarget.init.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.setupSkinTabs = function () {
	var target = this;
	if ( this.isViewPage ) {
		// Allow instant switching back to view mode, without refresh
		$( '#ca-view a, #ca-nstab-visualeditor a' )
			.click( this.onViewTabClick.bind( this ) );

		$( '#ca-viewsource, #ca-edit' ).click( function ( e ) {
			if ( target.getSurface() && !target.deactivating ) {
				target.editSource();

				if ( target.getSurface().getModel().hasBeenModified() ) {
					e.preventDefault();
				}
			}
		} );
	}

	mw.hook( 've.skinTabSetupComplete' ).fire();
};

/**
 * Modify page content to make section edit links activate the editor.
 * Dummy replaced by init.js so that we can call it again from #onSave after
 * replacing the page contents with the new html.
 */
ve.init.mw.ViewPageTarget.prototype.setupSectionEditLinks = null;

/**
 * Add content and event bindings to toolbar save button.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.setupToolbarSaveButton = function () {
	this.toolbarSaveButton = new OO.ui.ButtonWidget( {
		label: ve.msg( 'visualeditor-toolbar-savedialog' ),
		flags: [ 'constructive', 'primary' ],
		disabled: !this.restoring
	} );

	// NOTE (phuedx, 2014-08-20): This class is used by the firsteditve guided
	// tour to attach a guider to the "Save page" button.
	this.toolbarSaveButton.$element.addClass( 've-ui-toolbar-saveButton' );

	if ( ve.msg( 'accesskey-save' ) !== '-' && ve.msg( 'accesskey-save' ) !== '' ) {
		// FlaggedRevs tries to use this - it's useless on VE pages because all that stuff gets hidden, but it will still conflict so get rid of it
		this.elementsThatHadOurAccessKey = $( '[accesskey="' + ve.msg( 'accesskey-save' ) + '"]' ).removeAttr( 'accesskey' );
		this.toolbarSaveButton.$button.attr( 'accesskey', ve.msg( 'accesskey-save' ) );
	}

	this.updateToolbarSaveButtonState();

	this.toolbarSaveButton.connect( this, { click: 'onToolbarSaveButtonClick' } );
};

/**
 * Add the save button to the user interface.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.attachToolbarSaveButton = function () {
	var $actionTools = $( '<div>' ),
		$pushButtons = $( '<div>' ),
		actions = new ve.ui.TargetToolbar( this );

	actions.setup( this.constructor.static.actionsToolbarConfig, this.getSurface() );

	$actionTools
		.addClass( 've-init-mw-viewPageTarget-toolbar-utilities' )
		.append( actions.$element );

	$pushButtons
		.addClass( 've-init-mw-viewPageTarget-toolbar-actions' )
		.append( this.toolbarSaveButton.$element );

	this.toolbar.$actions.append( $actionTools, $pushButtons );
};

ve.init.mw.ViewPageTarget.prototype.setupToolbarCancelButton = function () {
	// Must implement in subclass
};

ve.init.mw.ViewPageTarget.prototype.attachToolbarCancelButton = function () {
	// Must implement in subclass
};

/**
 * Show the save dialog.
 *
 * @method
 * @fires saveWorkflowBegin
 */
ve.init.mw.ViewPageTarget.prototype.showSaveDialog = function () {
	this.emit( 'saveWorkflowBegin' );
	this.getSurface().getDialogs().getWindow( 'mwSave' ).then( function ( win ) {
		var currentWindow = this.getSurface().getContext().getInspectors().getCurrentWindow(),
			target = this;
		this.origSelection = this.getSurface().getModel().getSelection();

		// Make sure any open inspectors are closed
		if ( currentWindow ) {
			currentWindow.close();
		}

		// Preload the serialization
		if ( !this.docToSave ) {
			this.docToSave = ve.dm.converter.getDomFromModel( this.getSurface().getModel().getDocument() );
		}
		this.prepareCacheKey( this.docToSave );

		if ( !this.saveDialog ) {
			this.saveDialog = win;

			// Connect to save dialog
			this.saveDialog.connect( this, {
				save: 'saveDocument',
				review: 'onSaveDialogReview',
				resolve: 'onSaveDialogResolveConflict',
				retry: 'onSaveRetry'
			} );
			// Setup edit summary and checkboxes
			this.saveDialog.setEditSummary( this.initialEditSummary );
			this.saveDialog.setupCheckboxes( this.$checkboxes );
		}

		this.saveDialog.setSanityCheck( this.sanityCheckVerified );
		this.getSurface().getDialogs().openWindow(
			this.saveDialog,
			{ dir: this.getSurface().getModel().getDocument().getLang() }
		)
			// Call onSaveDialogClose() when the save dialog starts closing
			.done( function ( opened ) {
				opened.always( target.onSaveDialogClose.bind( target ) );
			} );
	}.bind( this ) );
};

/**
 * Handle dialog close events.
 *
 * @fires saveWorkflowEnd
 */
ve.init.mw.ViewPageTarget.prototype.onSaveDialogClose = function () {
	// Clear the cached HTML and cache key once the document changes
	var clear = function () {
		this.docToSave = null;
		this.clearPreparedCacheKey();
	}.bind( this );
	if ( this.getSurface() ) {
		this.getSurface().getModel().getDocument().once( 'transact', clear );
	} else {
		clear();
	}
	this.getSurface().getModel().setSelection( this.origSelection );
	this.emit( 'saveWorkflowEnd' );
};

/**
 * Remember the window's scroll position.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.saveScrollPosition = function () {
	this.scrollTop = $( window ).scrollTop();
};

/**
 * Restore the window's scroll position.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.restoreScrollPosition = function () {
	if ( this.scrollTop ) {
		$( window ).scrollTop( this.scrollTop );
		this.scrollTop = null;
	}
};

/**
 * Show the page content.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.showPageContent = function () {
	$( '#bodyContent > .ve-init-mw-viewPageTarget-content' )
		.removeClass( 've-init-mw-viewPageTarget-content' )
		.show()
		.fadeTo( 0, 1 );
	$( '#t-print, #t-permalink, #p-coll-print_export, #t-cite' ).show();
};

/**
 * Mute the page content.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.mutePageContent = function () {
	$( '#bodyContent > :visible:not(#siteSub)' )
		.addClass( 've-init-mw-viewPageTarget-content' )
		.fadeTo( 'fast', 0.6 );
};

/**
 * Hide the page content.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.hidePageContent = function () {
	$( '#bodyContent > :visible:not(#siteSub,.ve-ui-mwTocWidget)' )
		.addClass( 've-init-mw-viewPageTarget-content' )
		.hide();
	$( '#t-print, #t-permalink, #p-coll-print_export, #t-cite' ).hide();
};

/**
 * Show elements that didn't have a counter-part in the edit view.
 */
ve.init.mw.ViewPageTarget.prototype.showReadOnlyContent = function () {
	var $toc = $( '#toc' ),
		$wrap = $toc.parent();
	if ( $wrap.data( 've.hideTableOfContents' ) ) {
		$wrap.show( function () {
			$toc.unwrap();
		} );
	}

	$( '#contentSub' ).show();
};

/**
 * Hide elements that don't have a counter-part in the edit view.
 *
 * Call this when puting the page content, so that when we replace the
 * muted content with the edit surface, everything aligns in the same
 * place. If things like contentSub and TOC remain visible in mute mode,
 * there is an additional visual shift that is unpleasant to the user.
 */
ve.init.mw.ViewPageTarget.prototype.hideReadOnlyContent = function () {
	$( '#toc' )
		.wrap( '<div>' )
		.parent()
			.data( 've.hideTableOfContents', true )
			.hide();

	$( '#contentSub' ).hide();
};

/**
 * Hide the toolbar.
 *
 * @method
 * @param {boolean} [noAnimate] Don't animate
 */
ve.init.mw.ViewPageTarget.prototype.tearDownToolbar = function ( noAnimate ) {
	var tearDownToolbar = function () {
		this.toolbar.destroy();
		this.toolbar = null;
	}.bind( this );

	if ( noAnimate ) {
		tearDownToolbar();
	} else {
		this.toolbar.$bar.slideUp( 'fast', tearDownToolbar );
	}
};

/**
 * Hide the debug bar.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.tearDownDebugBar = function () {
	if ( this.debugBar ) {
		this.debugBar.$element.slideUp( 'fast', function () {
			this.debugBar.$element.remove();
			this.debugBar = null;
		}.bind( this ) );
	}
};

/**
 * Transform the page title into a VE-style title.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.transformPageTitle = function () {
	$( '#firstHeading' ).addClass( 've-init-mw-viewPageTarget-pageTitle' );
};

/**
 * Fade the page title to indicate it is not editable.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.mutePageTitle = function () {
	$( '#firstHeading, #siteSub' )
		.addClass( 've-init-mw-viewPageTarget-transform ve-init-mw-viewPageTarget-transform-muted' );
};

/**
 * Restore the page title to its original style.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.restorePageTitle = function () {
	var $els = $( '#firstHeading, #siteSub' )
		.removeClass( 've-init-mw-viewPageTarget-transform-muted' );

	setTimeout( function () {
		$els.removeClass( 've-init-mw-viewPageTarget-transform' );
		$( '#firstHeading' ).removeClass( 've-init-mw-viewPageTarget-pageTitle' );
	}, 1000 );
};

/**
 * Change the document title to state that we are now editing.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.changeDocumentTitle = function () {
	document.title = ve.msg(
		this.pageExists ? 'editing' : 'creating',
		mw.config.get( 'wgTitle' )
	) + ' - ' + mw.config.get( 'wgSiteName' );
};

/**
 * Restore the original document title.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.restoreDocumentTitle = function () {
	document.title = this.originalDocumentTitle;
};

/**
 * Page modifications for switching to edit mode.
 */
ve.init.mw.ViewPageTarget.prototype.transformPage = function () {
	var uri;

	// Deselect current mode (e.g. "view" or "history"). In skins like monobook that don't have
	// separate tab sections for content actions and namespaces the below is a no-op.
	$( '#p-views' ).find( 'li.selected' ).removeClass( 'selected' );
	$( '#ca-ve-edit' ).addClass( 'selected' );

	mw.hook( 've.activate' ).fire();

	// Hide site notice (if present)
	$( '#siteNotice:visible' )
		.addClass( 've-hide' )
		.slideUp( 'fast' );
	// Hide page status indicators (if present)
	$( '.mw-indicators' )
		.addClass( 've-hide' )
		.fadeOut( 'fast' );

	// Add class to document
	$( 'html' ).addClass( 've-activated' );

	// Push veaction=edit url in history (if not already. If we got here by a veaction=edit
	// permalink then it will be there already and the constructor called #activate)
	if ( !this.actFromPopState && history.pushState && this.currentUri.query.veaction !== 'edit' ) {
		// Set the current URL
		uri = this.currentUri;
		uri.query.veaction = 'edit';

		history.pushState( this.popState, document.title, uri );
	}
	this.actFromPopState = false;
};

/**
 * Page modifications for switching back to view mode.
 */
ve.init.mw.ViewPageTarget.prototype.restorePage = function () {
	var uri;

	// Skins like monobook don't have a tab for view mode and instead just have the namespace tab
	// selected. We didn't deselect the namespace tab, so we're ready after deselecting #ca-ve-edit.
	// In skins having #ca-view (like Vector), select that.
	$( '#ca-ve-edit' ).removeClass( 'selected' );
	$( '#ca-view' ).addClass( 'selected' );

	mw.hook( 've.deactivate' ).fire();

	// Make site notice visible again (if present)
	$( '#siteNotice.ve-hide' )
		.slideDown( 'fast' );
	// Make page status indicators visible again (if present)
	$( '.mw-indicators.ve-hide' )
		.fadeIn( 'fast' );

	// Remove class from document
	$( 'html' ).removeClass( 've-activated' );

	// Push non-veaction=edit url in history
	if ( !this.actFromPopState && history.pushState ) {
		// Remove the veaction query parameter
		uri = this.currentUri;
		if ( 'veaction' in uri.query ) {
			delete uri.query.veaction;
		}
		if ( 'vesection' in uri.query ) {
			delete uri.query.vesection;
		}

		// If there are other query parameters, set the url to the current url (with veaction removed).
		// Otherwise use the canonical style view url (bug 42553).
		if ( ve.getObjectValues( uri.query ).length ) {
			history.pushState( this.popState, document.title, uri );
		} else {
			history.pushState( this.popState, document.title, this.viewUri );
		}
	}
	this.actFromPopState = false;
};

/**
 * @param {Event} e Native event object
 */
ve.init.mw.ViewPageTarget.prototype.onWindowPopState = function ( e ) {
	var newUri;

	if ( !this.verifyPopState( e.state ) ) {
		// Ignore popstate events fired for states not created by us
		// This also filters out the initial fire in Chrome (bug 57901).
		return;
	}

	newUri = this.currentUri = new mw.Uri( location.href );

	if ( !this.active && newUri.query.veaction === 'edit' ) {
		this.actFromPopState = true;
		this.activate();
	}
	if ( this.active && newUri.query.veaction !== 'edit' ) {
		this.actFromPopState = true;
		this.deactivate( false, 'navigate-back' );
	}
};

/**
 * Replace the page content with new HTML.
 *
 * @method
 * @param {string} html Rendered HTML from server
 * @param {string} categoriesHtml Rendered categories HTML from server
 * @param {string} displayTitle What HTML to show as the page title
 * @param {Object} lastModified Object containing user-formatted date
    and time strings, or undefined if we made no change.
 * @param {string} contentSub What HTML to show as the content subtitle
 */
ve.init.mw.ViewPageTarget.prototype.replacePageContent = function (
	html, categoriesHtml, displayTitle, lastModified, contentSub
) {
	var $content = $( $.parseHTML( html ) ), $editableContent;

	if ( lastModified ) {
		// If we were not viewing the most recent revision before (a requirement
		// for lastmod to have been added by MediaWiki), we will be now.
		if ( !$( '#footer-info-lastmod' ).length ) {
			$( '#footer-info' ).prepend(
				$( '<li>' ).attr( 'id', 'footer-info-lastmod' )
			);
		}

		$( '#footer-info-lastmod' ).html( ' ' + mw.msg(
			'lastmodifiedat',
			lastModified.date,
			lastModified.time
		) );
	}

	if ( $( '#mw-imagepage-content' ).length ) {
		// On file pages, we only want to replace the (local) description.
		$editableContent = $( '#mw-imagepage-content' );
	} else if ( $( '#mw-pages' ).length ) {
		// It would be nice if MW core did this for us...
		if ( !$( '#ve-cat-description' ).length ) {
			$( '#mw-content-text > :not(div:has(#mw-pages))' ).wrapAll(
				$( '<div>' )
					.attr( 'id', 've-cat-description' )
			);
		}
		$editableContent = $( '#ve-cat-description' );
	} else {
		$editableContent = $( '#mw-content-text' );
	}

	mw.hook( 'wikipage.content' ).fire( $editableContent.empty().append( $content ) );
	if ( displayTitle ) {
		$( '#content > #firstHeading > span:first' ).html( displayTitle );
	}
	$( '#catlinks' ).replaceWith( categoriesHtml );
	$( '#contentSub' ).html( contentSub );
};

/**
 * Get the numeric index of a section in the page.
 *
 * @method
 * @param {HTMLElement} heading Heading element of section
 */
ve.init.mw.ViewPageTarget.prototype.getEditSection = function ( heading ) {
	var $page = $( '#mw-content-text' ),
		section = 0;
	$page.find( 'h1, h2, h3, h4, h5, h6' ).not( '#toc h2' ).each( function () {
		section++;
		if ( this === heading ) {
			return false;
		}
	} );
	return section;
};

/**
 * Store the section for which the edit link has been triggered.
 *
 * @method
 * @param {HTMLElement} heading Heading element of section
 */
ve.init.mw.ViewPageTarget.prototype.saveEditSection = function ( heading ) {
	this.section = this.getEditSection( heading );
};

/**
 * Add onbeforeunload handler.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.setupBeforeUnloadHandler = function () {
	// Remember any already set on before unload handler
	this.onBeforeUnloadFallback = window.onbeforeunload;
	// Attach before unload handler
	window.onbeforeunload = this.onBeforeUnloadHandler = this.onBeforeUnload.bind( this );
	// Attach page show handlers
	if ( window.addEventListener ) {
		window.addEventListener( 'pageshow', this.onPageShow.bind( this ), false );
	} else if ( window.attachEvent ) {
		window.attachEvent( 'pageshow', this.onPageShow.bind( this ) );
	}
};

/**
 * Remove onbeforunload handler.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.tearDownBeforeUnloadHandler = function () {
	// Restore whatever previous onbeforeload hook existed
	window.onbeforeunload = this.onBeforeUnloadFallback;
};

/**
 * Show dialogs as needed on load.
 */
ve.init.mw.ViewPageTarget.prototype.maybeShowDialogs = function () {
	var usePrefs, prefSaysShow, urlSaysHide;
	if ( mw.config.get( 'wgVisualEditorConfig' ).showBetaWelcome ) {

		// Only use the preference value if the user is logged-in.
		// If the user is anonymous, we can't save the preference
		// after showing the dialog. And we don't intend to use this
		// preference to influence anonymous users (use the config
		// variable for that; besides the pref value would be stale if
		// the wiki uses static html caching).
		usePrefs = !mw.user.anonymous();
		prefSaysShow = usePrefs && !mw.user.options.get( 'visualeditor-hidebetawelcome' );
		urlSaysHide = 'vehidebetadialog' in this.currentUri.query;

		if (
				!urlSaysHide &&
				(
					prefSaysShow ||
					(
						!usePrefs &&
						localStorage.getItem( 've-beta-welcome-dialog' ) === null &&
						$.cookie( 've-beta-welcome-dialog' ) === null
					)
				)
			) {
			this.getSurface().getDialogs().openWindow( 'betaWelcome' );
		}

		if ( prefSaysShow ) {
			ve.init.target.constructor.static.apiRequest( {
				action: 'options',
				token: mw.user.tokens.get( 'editToken' ),
				change: 'visualeditor-hidebetawelcome=1'
			}, { type: 'POST' } );

		// No need to set a cookie every time for logged-in users that have already
		// set the hidebetawelcome=1 preference, but only if this isn't a one-off
		// view of the page via the hiding GET parameter.
		} else if ( !usePrefs && !urlSaysHide ) {
			try {
				localStorage.setItem( 've-beta-welcome-dialog', 1 );
			} catch ( e ) {
				$.cookie( 've-beta-welcome-dialog', 1, { path: '/', expires: 30 } );
			}
		}
	}

	if ( this.getSurface().getModel().metaList.getItemsInGroup( 'mwRedirect' ).length ) {
		this.getSurface().getDialogs().openWindow( 'meta', {
			page: 'settings',
			fragment: this.getSurface().getModel().getFragment()
		} );
	}
};

/**
 * Handle page show event.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onPageShow = function () {
	// Re-add onbeforeunload handler
	window.onbeforeunload = this.onBeforeUnloadHandler;
};

/**
 * Handle before unload event.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onBeforeUnload = function () {
	var fallbackResult,
		message,
		onBeforeUnloadHandler = this.onBeforeUnloadHandler;
	// Check if someone already set on onbeforeunload hook
	if ( this.onBeforeUnloadFallback ) {
		// Get the result of their onbeforeunload hook
		fallbackResult = this.onBeforeUnloadFallback();
	}
	// Check if their onbeforeunload hook returned something
	if ( fallbackResult !== undefined ) {
		// Exit here, returning their message
		message = fallbackResult;
	} else {
		// Override if submitting
		if ( this.submitting ) {
			return undefined;
		}
		// Check if there's been an edit
		if ( this.getSurface() && this.edited && mw.user.options.get( 'useeditwarning' ) ) {
			// Return our message
			message = ve.msg( 'visualeditor-viewpage-savewarning' );
		}
	}
	// Unset the onbeforeunload handler so we don't break page caching in Firefox
	window.onbeforeunload = null;
	if ( message !== undefined ) {
		// ...but if the user chooses not to leave the page, we need to rebind it
		setTimeout( function () {
			window.onbeforeunload = onBeforeUnloadHandler;
		} );
		return message;
	}
};

/**
 * Switches to the wikitext editor, either keeping (default) or discarding changes.
 *
 * @param {boolean} [discardChanges] Whether to discard changes or not.
 */
ve.init.mw.ViewPageTarget.prototype.switchToWikitextEditor = function ( discardChanges ) {
	if ( discardChanges ) {
		ve.track( 'mwedit.abort', { type: 'switchwithout', mechanism: 'navigate' } );
		this.submitting = true;
		location.href = this.viewUri.clone().extend( {
			action: 'edit',
			veswitched: 1
		} ).toString();
	} else {
		this.serialize(
			this.docToSave || ve.dm.converter.getDomFromModel( this.getSurface().getModel().getDocument() ),
			function ( wikitext ) {
				ve.track( 'mwedit.abort', { type: 'switchwith', mechanism: 'navigate' } );
				this.submitWithSaveFields( { wpDiff: 1, veswitched: 1 }, wikitext );
			}.bind( this )
		);
	}
};

/**
 * Resets the document opacity when we've decided to cancel switching to the wikitext editor.
 */
ve.init.mw.ViewPageTarget.prototype.resetDocumentOpacity = function () {
	this.getSurface().getView().getDocument().getDocumentNode().$element.css( 'opacity', 1 );
};
