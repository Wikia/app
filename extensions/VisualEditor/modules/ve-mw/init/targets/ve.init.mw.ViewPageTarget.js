/*!
 * VisualEditor MediaWiki Initialization ViewPageTarget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* global mw, confirm, alert, veTrack */

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
		currentUri = new mw.Uri( location.href ),
		conf = mw.config.get( 'wgVisualEditorConfig' );

	// Parent constructor
	ve.init.mw.Target.call(
		this, $( '#WikiaArticle' ),
		mw.config.get( 'wgRelevantPageName' ),
		currentUri.query.oldid
	);

	// Properties
	this.$spinner = $( '<div class="ve-init-mw-viewPageTarget-loading"></div>' );
	this.toolbarCancelButton = null;
	this.toolbarSaveButton = null;
	this.saveDialog = null;
	this.onBeforeUnloadFallback = null;
	this.onBeforeUnloadHandler = null;
	this.timeout = null;
	this.active = false;
	this.activating = false;
	this.deactivating = false;
	this.edited = false;
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
	this.initialEditSummary = '';
	this.namespaceName = mw.config.get( 'wgCanonicalNamespace' );
	this.viewUri = new mw.Uri( mw.util.getUrl( this.pageName ) );
	this.veEditUri = this.viewUri.clone().extend( { 'veaction': 'edit' } );
	this.isViewPage = (
		mw.config.get( 'wgAction' ) === 'view' &&
		currentUri.query.diff === undefined
	);
	this.originalDocumentTitle = document.title;
	this.tabLayout = mw.config.get( 'wgVisualEditorConfig' ).tabLayout;

	/**
	 * @property {jQuery.Promise|null}
	 */
	this.sanityCheckPromise = null;

	// Add modules specific to desktop (modules shared with mobile go in MWTarget)
	this.modules.push(
		'ext.visualEditor.mwformatting',
		'ext.visualEditor.mwgallery',
		'ext.visualEditor.mwimage',
		'ext.visualEditor.mwmeta',
		'ext.visualEditor.mwtransclusion'
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
		'save': 'onSave',
		'saveErrorEmpty': 'onSaveErrorEmpty',
		'saveErrorSpamBlacklist': 'onSaveErrorSpamBlacklist',
		'saveErrorAbuseFilter': 'onSaveErrorAbuseFilter',
		'saveErrorBadToken': 'onSaveErrorBadToken',
		'saveErrorNewUser': 'onSaveErrorNewUser',
		'saveErrorCaptcha': 'onSaveErrorCaptcha',
		'saveErrorUnknown': 'onSaveErrorUnknown',
		'loadError': 'onLoadError',
		'surfaceReady': 'onSurfaceReady',
		'editConflict': 'onEditConflict',
		'showChanges': 'onShowChanges',
		'showChangesError': 'onShowChangesError',
		'noChanges': 'onNoChanges',
		'serializeError': 'onSerializeError',
		'sanityCheckComplete': 'updateToolbarSaveButtonState'
	} );

	if ( currentUri.query.venotify ) {
		// The following messages can be used here:
		// postedit-confirmation-saved
		// postedit-confirmation-created
		// postedit-confirmation-restored
		mw.hook( 'postEdit' ).fire( {
			'message':
				ve.msg( 'postedit-confirmation-' + currentUri.query.venotify, mw.user )
		} );

		delete currentUri.query.venotify;
	}

	if ( window.history.replaceState ) {
		// This is to stop the back button breaking when it's supposed to take us back out
		// of VE. It used to only be called when venotify is used. FIXME: there should be
		// a much better solution than this.
		window.history.replaceState( this.popState, document.title, currentUri );
	}

	this.setupSkinTabs();

	window.addEventListener( 'popstate', ve.bind( this.onWindowPopState, this ) ) ;
};

/* Inheritance */

OO.inheritClass( ve.init.mw.ViewPageTarget, ve.init.mw.Target );

/* Static Properties */

ve.init.mw.ViewPageTarget.static.actionsToolbarConfig = [
	{ 'include': [ 'help', 'notices' ] },
	{
		'type': 'list',
		'icon': 'menu',
		'include': [ 'meta', 'categories', 'languages', 'editModeSource' ] }
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
	'whitelist': {
		'firefox': [['>=', 15]],
		'iceweasel': [['>=', 10]],
		'safari': [['>=', 6]],
		'chrome': [['>=', 19]],
		'opera': [['>=', 15]]
	}
};

/* Events */

/**
 * @event saveWorkflowBegin
 * Fired when user enters the save workflow
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
ve.init.mw.ViewPageTarget.prototype.setupToolbar = function () {
	var $firstHeading;
	// Parent method
	ve.init.mw.Target.prototype.setupToolbar.call( this );

	this.toolbar.enableFloatable();
	this.toolbar.$element
		.addClass( 've-init-mw-viewPageTarget-toolbar transition' );

	// Move the toolbar to before #firstHeading if it exists
	$firstHeading = $( '#WikiaPageHeader' );
	if ( $firstHeading.length ) {
		this.toolbar.$element.insertAfter( $firstHeading );
	}

	this.surface.getView().emit( 'position' );
	this.surface.getContext().update();
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
 */
ve.init.mw.ViewPageTarget.prototype.activate = function () {
	if ( !this.active && !this.activating ) {
		this.activating = true;

		// User interface changes
		this.transformPage();
		this.showSpinner();
		this.hideReadOnlyContent();
		this.mutePageContent();
		this.mutePageTitle();
		this.setupLocalNoticeMessages();

		this.saveScrollPosition();

		this.load( [ 'site', 'user' ] );
	}
};

/**
 * Determines whether we want to switch to view mode or not (displaying a dialog if necessary)
 * Then, if we do, actually switches to view mode.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.deactivate = function ( override ) {
	var confirmDialog, target = this;
	if ( override || ( this.active && !this.deactivating ) ) {
		if ( override || !this.edited ) {
			this.cancel();
		} else {
			confirmDialog = this.surface.dialogs.getWindow( 'confirm' );
			confirmDialog.open( {
				'prompt': ve.msg( 'visualeditor-viewpage-savewarning' ),
				'okLabel': ve.msg( 'visualeditor-viewpage-savewarning-discard' ),
				'okFlags': [ 'destructive' ],
				'cancelLabel': ve.msg( 'visualeditor-viewpage-savewarning-keep' ),
				'cancelFlags': [ 'secondary' ]
			} ).then( function ( closingPromise ) {
				closingPromise.then( function () {
					target.cancel();
				} );
			} );
		}
	}
};

/**
 * Switch to view mode
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.cancel = function () {
	this.deactivating = true;
	// User interface changes
	if ( this.elementsThatHadOurAccessKey ) {
		this.elementsThatHadOurAccessKey.attr( 'accesskey', ve.msg( 'accesskey-save' ) );
	}
	this.restorePage();
	this.hideSpinner();
	this.showReadOnlyContent();

	if ( this.toolbarCancelButton ) {
		// If deactivate is called before a successful load, then
		// setupToolbarButtons has not been called yet and as such tearDownToolbarButtons
		// would throw an error when trying call methods on the button property (bug 46456)
		this.tearDownToolbarButtons();
		this.detachToolbarButtons();
	}

	// Check we got as far as setting up the surface
	if ( this.active ) {
		// If we got as far as setting up the surface, tear that down
		this.tearDownSurface();
	}

	// Show/restore components that are otherwise handled by tearDownSurface
	this.showPageContent();
	this.restorePageTitle();

	// If there is a load in progress, abort it
	if ( this.loading ) {
		this.loading.abort();
	}

	this.clearState();
	this.docToSave = null;
	this.initialEditSummary = '';

	this.deactivating = false;

	mw.hook( 've.deactivationComplete' ).fire( this.edited );
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
		window.location.href = this.currentUri.toString();
	} else {
		this.activating = false;
		// User interface changes
		this.deactivate( true );
	}
};

/**
 * Once surface is ready ready, init UI
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onSurfaceReady = function () {
	this.activating = false;
	this.surface.getModel().connect( this, {
		'documentUpdate': function () {
			this.wikitextWarning = ve.init.mw.ViewPageTarget.static.checkForWikitextWarning(
				this.surface,
				this.wikitextWarning
			);
		},
		'history': 'updateToolbarSaveButtonState'
	} );
	this.surface.setPasteRules( this.constructor.static.pasteRules );

	// TODO: mwTocWidget should probably live in a ve.ui.MWSurface subclass
	if ( mw.config.get( 'wgVisualEditorConfig' ).enableTocWidget ) {
		this.surface.mwTocWidget = new ve.ui.MWTocWidget( this.surface );
	}

	this.setupToolbarButtons();
	this.attachToolbarButtons();

	// Update UI
	this.hideSpinner();
	if ( this.timeout ) {
		setTimeout( ve.bind( this.afterHideSpinner, this ), this.timeout );
	} else {
		this.afterHideSpinner();
	}
};

ve.init.mw.ViewPageTarget.prototype.afterHideSpinner = function () {
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
		setTimeout( ve.bind( this.afterSpinnerFadeOpacityOut, this ), this.timeout );
	} else {
		this.afterSpinnerFadeOpacityOut();
	}
};

ve.init.mw.ViewPageTarget.prototype.afterSpinnerFadeOpacityOut = function () {
	this.toolbar.$element.removeClass( 'transition' );
	$( '.ve-spinner-fade' ).hide();

	if ( window.veTrack ) {
		veTrack( { action: 've-edit-page-stop' } );
	}
	mw.hook( 've.activationComplete' ).fire();
};

/**
 * Handle successful DOM save event.
 *
 * @method
 * @param {string} html Rendered page HTML from server
 * @param {string} categoriesHtml Rendered categories HTML from server
 * @param {number} [newid] New revision id, undefined if unchanged
 */
ve.init.mw.ViewPageTarget.prototype.onSave = function ( html, categoriesHtml, newid, isRedirect ) {
	var newUrlParams, watchChecked;
	this.saveDeferred.resolve();
	if ( !this.pageExists || this.restoring ) {
		// This is a page creation or restoration, refresh the page
		this.tearDownBeforeUnloadHandler();
		newUrlParams = {
			'venotify': this.restoring ? 'restored' : 'created'
		};
		if ( isRedirect ) {
			newUrlParams.redirect = 'no';
		}
		window.location.href = this.viewUri.extend( newUrlParams );
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
				'wgCurRevisionId': newid,
				'wgRevisionId': newid
			} );
			this.revid = newid;
		}
		this.saveDialog.close();
		this.saveDialog.reset();
		this.replacePageContent( html, categoriesHtml, isRedirect );
		this.setupSectionEditLinks();
		this.tearDownBeforeUnloadHandler();
		this.deactivate( true );
		mw.hook( 'postEdit' ).fire( {
			'message':
				ve.msg( 'postedit-confirmation-saved', mw.user )
		} );
	}
};

/**
 * Update save dialog message on general error
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onSaveErrorEmpty = function () {
	this.showSaveError( ve.msg( 'visualeditor-saveerror', 'Empty server response' ), false /* prevents reapply */ );
	this.events.trackSaveError( 'empty' );
};

/**
 * Update save dialog message on spam blacklist error
 *
 * @method
 * @param {Object} editApi
 */
ve.init.mw.ViewPageTarget.prototype.onSaveErrorSpamBlacklist = function ( editApi ) {
	this.showSaveError(
		// Wikia change: We use Phalanx for spam filtering instead of the SpamBlacklist extension, as well as a
		// modified message. Therefore it's easier to get the i18n message on the back-end and just show it here.
		$( $.parseHTML( editApi.spamblacklist ) ),
		false // prevents reapply
	);
	this.events.trackSaveError( 'spamblacklist' );
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
	this.events.trackSaveError( 'abusefilter' );
};

/**
 * Track when there is a bad edit token on save
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onSaveErrorBadToken = function () {
	this.events.trackSaveError( 'badtoken' );
};

/**
 * Update save dialog when token fetch indicates another user is logged in
 *
 * @method
 * @param {boolean|undefined} isAnon Is newly logged in user anonymous. If
 *  undefined, user is logged in
 */
ve.init.mw.ViewPageTarget.prototype.onSaveErrorNewUser = function ( isAnon ) {
	var badToken, userMsg;
	badToken = document.createTextNode( mw.msg( 'visualeditor-savedialog-error-badtoken' ) + ' ' );
	// mediawiki.jqueryMsg has a bug with [[User:$1|$1]] (bug 51388)
	if ( isAnon ) {
		userMsg = 'visualeditor-savedialog-identify-anon';
	} else {
		userMsg = 'visualeditor-savedialog-identify-user---' + mw.config.get( 'wgUserName' );
	}
	this.showSaveError(
		$( badToken ).add( $.parseHTML( mw.message( userMsg ).parse() ) )
	);
};

/**
 * Update save dialog on captcha error
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onSaveErrorCaptcha = function () {
	// Wikia change: Only support reCAPTCHA and FancyCaptcha
	this.captchaResponse = null;
	this.saveDialog.$captcha.empty();

	// reCaptcha loaded without any problems
	if (this.saveDialog.frame.$element[0].contentWindow.grecaptcha !== undefined) {
		this.renderReCaptcha();
	} else {
		this.loadAndRenderFancyCaptcha();
	}

	this.saveDialog.$frame.addClass( 'oo-ui-window-frame-captcha' );
	this.saveDialog.popPending();

	this.events.trackSaveError( 'captcha' );
};

/**
 * Render reCaptcha
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.renderReCaptcha = function () {
	this.saveDialog.frame.$element[0].contentWindow.grecaptcha.render(
		've-ui-mwSaveDialog-captcha',
		{
			'sitekey': mw.config.get( 'reCaptchaPublicKey' ),
			'theme': 'light',
			'callback': function ( response ) {
				this.captchaResponse = response;
			}.bind( this )
		});
};

/**
 * If reCaptcha failed to load (eg, the user is in China and google is blocked),
 * load Fancy Captcha and render it instead.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.loadAndRenderFancyCaptcha = function () {
	$.when(
		$.getResources([
			$.getSassCommonURL('extensions/wikia/Captcha/styles/FancyCaptcha.scss')
		])
	).done(
		$.nirvana.sendRequest({
			controller: 'CaptchaController',
			method: 'getFancyCaptcha',
			type: 'GET',
			callback: function ( data ) {
				this.saveDialog.$captcha.append( data.form );
			}.bind( this )
		})
	);
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
	this.events.trackSaveError( 'unknown' );
};

/**
 * Update save dialog api-save-error message
 *
 * @method
 * @param {string|jQuery|Node[]} msg Message content (string of HTML, jQuery object or array of
 *  Node objects)
 * @param {boolean} [allowReapply=true] Whether or not to allow the user to reapply.
 *  Reset when swapping panels. Assumed to be true unless explicitly set to false.
 */
ve.init.mw.ViewPageTarget.prototype.showSaveError = function ( msg, allowReapply ) {
	this.saveDeferred.reject( [ msg ], allowReapply );
};

/**
 * Handle Show changes event.
 *
 * @method
 * @param {string} diffHtml
 */
ve.init.mw.ViewPageTarget.prototype.onShowChanges = function ( diffHtml ) {
	// Invalidate the viewer diff on next change
	this.surface.getModel().getDocument().once( 'transact',
		ve.bind( this.saveDialog.clearDiff, this.saveDialog )
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
	this.saveDialog.reviewGoodButton.setDisabled( false );
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
	if ( this.active ) {
		this.deactivate();
		// Prevent the edit tab's normal behavior
		e.preventDefault();
	} else if ( this.activating ) {
		this.deactivate( true );
		this.activating = false;
		e.preventDefault();
	}
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
 * Handle clicks on the cancel button in the toolbar.
 *
 * @method
 * @param {jQuery.Event} e Mouse click event
 */
ve.init.mw.ViewPageTarget.prototype.onToolbarCancelButtonClick = function () {
	this.deactivate();
};

/**
 * Handle clicks on the MwMeta button in the toolbar.
 *
 * @method
 * @param {jQuery.Event} e Mouse click event
 */
ve.init.mw.ViewPageTarget.prototype.onToolbarMetaButtonClick = function () {
	this.surface.getDialogs().getWindow( 'meta' ).open();
};

/**
 * Check if the user is entering wikitext, and show a notification if they are.
 *
 * This check is fairly simplistic: it checks whether the content branch node the selection is in
 * looks like wikitext, so it can trigger if the user types in a paragraph that has pre-existing
 * wikitext-like content.
 *
 * This method is bound to the 'documentUpdate' event on the surface model, and unbinds itself when
 * the wikitext notification is displayed.
 *
 * @param {ve.ui.Surface} surface
 * @param {Object} [wikitextWarning] MediaWiki notification object
 */
ve.init.mw.ViewPageTarget.static.checkForWikitextWarning = function ( surface, wikitextWarning ) {
	var text, node, doc = surface.getView().getDocument(),
		selection = surface.getModel().getSelection();
	if ( !selection ) {
		return;
	}
	node = doc.getNodeFromOffset( selection.start );
	if ( !( node instanceof ve.ce.ContentBranchNode ) ) {
		return;
	}
	text = ve.ce.getDomText( node.$element[0] );

	if ( text.match( /\[\[|\{\{|''|<nowiki|<ref|~~~|^==|^\*|^\#/ ) ) {
		$.showModal(
			ve.msg( 'visualeditor-wikitext-warning-title' ),
			$( $.parseHTML( ve.init.platform.getParsedMessage( 'wikia-visualeditor-wikitext-warning' ) ) )
				.filter( 'a' ).attr( 'target', '_blank ' ).end(),
			{
				'onClose': function () {
					ve.track( 'wikia', { 'action': ve.track.actions.CLOSE, 'label': 'modal-wikitext-warning' } );
				},
				'onCreate': function () {
					ve.track( 'wikia', { 'action': ve.track.actions.OPEN, 'label': 'modal-wikitext-warning' } );
				}
			}
		);
	}
	return wikitextWarning;
};

/**
 * Re-evaluate whether the toolbar save button should be disabled or not.
 */
ve.init.mw.ViewPageTarget.prototype.updateToolbarSaveButtonState = function () {
	var isDisabled;

	this.edited = this.surface.getModel().hasBeenModified() || this.wikitext !== null;
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
		this.saveDialog.reviewGoodButton.setDisabled( true );
		this.saveDialog.pushPending();
		if ( this.pageExists ) {
			// Has no callback, handled via target.onShowChanges
			this.showChanges( this.docToSave );
		} else {
			this.serialize( this.docToSave, ve.bind( this.onSaveDialogReviewComplete, this ) );
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
	this.surface.getModel().getDocument().once( 'transact',
		ve.bind( this.saveDialog.clearDiff, this.saveDialog )
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
	} else {
		this.save( this.docToSave, saveOptions );
		this.saveDeferred = saveDeferred;
	}
};

/**
 * Switch to edit source mode with the current wikitext
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.editSource = function () {
	var confirmDialog = this.surface.dialogs.getWindow( 'confirm' ),
		$documentNode = this.surface.getView().getDocument().getDocumentNode().$element,
		target = this;

	$documentNode.css( 'opacity', 0.5 );

	confirmDialog.open( {
		'prompt': ve.msg( 'visualeditor-mweditmodesource-warning' ),
		'okLabel': ve.msg( 'visualeditor-mweditmodesource-warning-switch' ),
		'okFlags': [ 'primary' ],
		'cancelLabel': ve.msg( 'visualeditor-mweditmodesource-warning-cancel' ),
		'cancelFlags': []
	} ).then( function ( closingPromise ) {
		closingPromise.then( function () {
			// Get Wikitext from the DOM
			target.serialize(
				target.docToSave || ve.dm.converter.getDomFromModel( target.surface.getModel().getDocument() ),
				ve.bind( target.submitWithSaveFields, target, { 'wpDiff': 1, 'veswitched': 1 } )
			);
		}, function () {
			// Undo the opacity change
			$documentNode.css( 'opacity', 1 );
		} );
	} );
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
		ve.bind( this.submitWithSaveFields, this, { 'wpSave': 1 } )
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
		'wpSummary': this.saveDialog ? this.saveDialog.editSummaryInput.getValue() : this.initialEditSummary,
		'g-recaptcha-response': this.captchaResponse, // reCaptcha
		'wpCaptchaClass': this.saveDialog.$( '#wpCaptchaClass' ).val(), // FancyCaptcha (fallback if reCaptcha fails to load)
		'wpCaptchaId': this.saveDialog.$( '#wpCaptchaId' ).val(), // FancyCaptcha (fallback if reCaptcha fails to load)
		'wpCaptchaWord': this.saveDialog.$( '#wpCaptchaWord' ).val() // FancyCaptcha (fallback if reCaptcha fails to load)
	} );
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
			'wpSummary': 'summary',
			'wpMinoredit': 'minor',
			'wpWatchthis': 'watch',
			'wpCaptchaId': 'captchaid',
			'wpCaptchaWord': 'captchaword'
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
 * Fire off the sanity check. Must be called before the surface is activated.
 *
 * To access the result, check whether #sanityCheckPromise has been resolved or rejected
 * (it's asynchronous, so it may still be pending when you check).
 */
ve.init.mw.ViewPageTarget.prototype.startSanityCheck = function () {
	// We have to get a copy of the data now, before we unlock the surface and let the user edit,
	// but we can defer the actual conversion and comparison
	var viewPage = this,
		doc = viewPage.surface.getModel().getDocument(),
		data = new ve.dm.FlatLinearData( doc.getStore().clone(), ve.copy( doc.getFullData() ) ),
		oldDom = viewPage.doc,
		d = $.Deferred();

	// Reset
	viewPage.sanityCheckFinished = false;
	viewPage.sanityCheckVerified = false;

	setTimeout( function () {
		// We can't compare oldDom.body and newDom.body directly, because the attributes on the
		// <body> were ignored in the conversion. So compare each child separately.
		var i,
			len = oldDom.body.childNodes.length,
			newDoc = new ve.dm.Document( data, oldDom, undefined, doc.getInternalList(), doc.getInnerWhitespace(), doc.getLang(), doc.getDir() ),
			newDom = ve.dm.converter.getDomFromModel( newDoc );

		// Explicitly unlink our full copy of the original version of the document data
		data = undefined;

		if ( len !== newDom.body.childNodes.length ) {
			// Different number of children, so they're definitely different
			d.reject();
			return;
		}
		for ( i = 0; i < len; i++ ) {
			if ( !oldDom.body.childNodes[i].isEqualNode( newDom.body.childNodes[i] ) ) {
				d.reject();
				return;
			}
		}
		d.resolve();
	} );

	viewPage.sanityCheckPromise = d.promise()
		.done( function () {
			// If we detect no roundtrip errors,
			// don't emphasize "review changes" to the user.
			viewPage.sanityCheckVerified = true;
		})
		.always( function () {
			viewPage.sanityCheckFinished = true;
			viewPage.updateToolbarSaveButtonState();
		} );
};

/**
 * Switch to viewing mode.
 *
 * @param {boolean} animate Should elements like the toolbar animate when hiding and showing.
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.tearDownSurface = function ( animate ) {
	// Update UI
	if ( this.$document ) {
		this.$document.blur();
		this.$document = null;
	}
	this.tearDownToolbar( animate );
	this.tearDownDebugBar( animate );
	this.restoreDocumentTitle();
	if ( this.surface.mwTocWidget ) {
		this.surface.mwTocWidget.teardown();
	}
	if ( this.saveDialog ) {
		// If we got as far as setting up the save dialog, tear it down
		this.saveDialog.close();
		this.saveDialog = null;
	}
	// Destroy surface
	if ( this.surface ) {
		this.surface.destroy();
		this.surface = null;
	}
	this.active = false;
};

/**
 * Modify tabs in the skin to support in-place editing.
 * Edit tab is bound outside the module in mw.ViewPageTarget.init.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.setupSkinTabs = function () {
	if ( this.isViewPage ) {
		// Allow instant switching back to view mode, without refresh
		$( '#ca-view a, #ca-nstab-visualeditor a' )
			.click( ve.bind( this.onViewTabClick, this ) );
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
 * Add content and event bindings to toolbar buttons.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.setupToolbarButtons = function () {
	this.toolbarCancelButton = new OO.ui.ButtonWidget( {
		'label': ve.msg( 'visualeditor-toolbar-cancel' ),
		'flags': [ 'secondary' ]
	} );
	this.toolbarCancelButton.$element.addClass( 've-ui-toolbar-cancelButton' );
	this.toolbarSaveButton = new OO.ui.ButtonWidget( {
		'label': ve.msg( 'wikia-visualeditor-toolbar-savedialog' ),
		'flags': [ 'constructive' ],
		'disabled': !this.restoring
	} );
	// TODO (mattflaschen, 2013-06-27): it would be useful to do this in a more general way, such
	// as in the ButtonWidget constructor.
	this.toolbarSaveButton.$element.addClass( 've-ui-toolbar-saveButton' );

	if ( ve.msg( 'accesskey-save' ) !== '-' && ve.msg( 'accesskey-save' ) !== '' ) {
		// FlaggedRevs tries to use this - it's useless on VE pages because all that stuff gets hidden, but it will still conflict so get rid of it
		this.elementsThatHadOurAccessKey = $( '[accesskey="' + ve.msg( 'accesskey-save' ) + '"]' ).removeAttr( 'accesskey' );
		this.toolbarSaveButton.$button.attr( 'accesskey', ve.msg( 'accesskey-save' ) );
	}

	this.updateToolbarSaveButtonState();

	this.toolbarCancelButton.connect( this, { 'click': 'onToolbarCancelButtonClick' } );
	this.toolbarSaveButton.connect( this, { 'click': 'onToolbarSaveButtonClick' } );
};

/**
 * Remove content and event bindings from toolbar buttons.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.tearDownToolbarButtons = function () {
	this.toolbarCancelButton.disconnect( this );
	this.toolbarSaveButton.disconnect( this );
};

/**
 * Add the save button to the user interface.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.attachToolbarButtons = function () {
	var $actionTools = $( '<div>' ),
		$pushButtons = $( '<div>' ),
		actions = new ve.ui.TargetToolbar( this, this.surface );

	actions.setup( this.constructor.static.actionsToolbarConfig );

	$actionTools
		.addClass( 've-init-mw-viewPageTarget-toolbar-utilites' )
		.append( actions.$element );

	$pushButtons
		.addClass( 've-init-mw-viewPageTarget-toolbar-actions' )
		.append(
			this.toolbarCancelButton.$element,
			this.toolbarSaveButton.$element
		);

	this.toolbar.$actions.append( $actionTools, $pushButtons );
};

/**
 * Remove the save button from the user interface.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.detachToolbarButtons = function () {
	this.toolbarCancelButton.$element.detach();
	this.toolbarSaveButton.$element.detach();
	this.toolbar.$actions.empty();
};

/**
 * Add content and event bindings to the save dialog.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.setupSaveDialog = function () {
	var dialogFrame, dialogDocument, script;
	this.saveDialog = this.surface.getDialogs().getWindow( 'mwSave' );
	// Connect to save dialog
	this.saveDialog.connect( this, {
		'save': 'saveDocument',
		'review': 'onSaveDialogReview',
		'resolve': 'onSaveDialogResolveConflict'
	} );
	// Setup edit summary and checkboxes
	this.saveDialog.setEditSummary( this.initialEditSummary );
	this.saveDialog.setupCheckboxes( this.$checkboxes );

	// Add Recaptcha script
	dialogFrame = this.saveDialog.frame.$element[0];
	dialogDocument = dialogFrame.contentDocument;
	$( dialogFrame ).on( 'load', function () {
		script = dialogDocument.createElement( 'script' );
		script.src = 'https://www.google.com/recaptcha/api.js';
		dialogDocument.getElementsByTagName( 'head' )[0].appendChild( script );
	} );
};

/**
 * Show the save dialog.
 *
 * @method
 * @fires saveWorkflowBegin
 */
ve.init.mw.ViewPageTarget.prototype.showSaveDialog = function () {
	// Make sure any open inspectors are closed
	this.surface.getContext().closeCurrentInspector();

	// Preload the serialization
	if ( !this.docToSave ) {
		this.docToSave = ve.dm.converter.getDomFromModel( this.surface.getModel().getDocument() );
	}
	this.prepareCacheKey( this.docToSave );

	if ( !this.saveDialog ) {
		this.setupSaveDialog();
	}

	this.saveDialog.setSanityCheck( this.sanityCheckVerified );
	this.saveDialog.open(
		this.surface.getModel().getFragment(),
		{ 'dir': this.surface.getModel().getDocument().getLang() }
	)
		// Call onSaveDialogClose() when the save dialog starts closing
		.always( ve.bind( function ( opened ) {
			opened.always( ve.bind( this.onSaveDialogClose, this ) );
		}, this ) );
	this.emit( 'saveWorkflowBegin' );
};

/**
 * Handle dialog close events.
 * @fires saveWorkflowEnd
 */
ve.init.mw.ViewPageTarget.prototype.onSaveDialogClose = function () {
	// Clear the cached HTML and cache key once the document changes
	var clear = ve.bind( function () {
		this.docToSave = null;
		this.clearPreparedCacheKey();
	}, this );
	if ( this.surface ) {
		this.surface.getModel().getDocument().once( 'transact', clear );
	} else {
		clear();
	}
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
 * Show the loading spinner.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.showSpinner = function () {
	$( '#firstHeading' ).prepend( this.$spinner );
};

/**
 * Hide the loading spinner.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.hideSpinner = function () {
	this.$spinner.detach();
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
 *
 * @method
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
 * @param {boolean} animate Whether or not to animate the toolbar's hiding and showing.
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.tearDownToolbar = function ( animate ) {
	var tearDown = ve.bind( function () {
		this.toolbar.destroy();
		this.toolbar = null;
	}, this );

	if ( animate ) {
		this.toolbar.$bar.slideUp( 'fast', tearDown );
	} else {
		tearDown();
	}
};

/**
 * Hide the debug bar.
 *
 * @param {boolean} animate Whether or not to animate the toolbar's hiding and showing.
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.tearDownDebugBar = function ( animate ) {
	var tearDown = ve.bind( function () {
		this.debugBar.$element.remove();
		this.debugBar = null;
	}, this );
	if ( this.debugBar ) {
		if ( animate ) {
			this.debugBar.$element.slideUp( 'fast', tearDown );
		} else {
			tearDown();
		}
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

	// Add class to document
	$( 'html' ).addClass( 've-activated' );

	// Push veaction=edit url in history (if not already. If we got here by a veaction=edit
	// permalink then it will be there already and the constructor called #activate)
	if ( !this.actFromPopState && window.history.pushState && this.currentUri.query.veaction !== 'edit' ) {
		// Set the veaction query parameter
		uri = this.currentUri;
		uri.query.veaction = 'edit';

		window.history.pushState( this.popState, document.title, uri );
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

	// Remove class from document
	$( 'html' ).removeClass( 've-activated' );

	// Push non-veaction=edit url in history
	if ( !this.actFromPopState && window.history.pushState ) {
		// Remove the veaction query parameter
		uri = this.currentUri;
		if ( 'veaction' in uri.query ) {
			delete uri.query.veaction;
		}

		// If there are other query parameters, set the url to the current url (with veaction removed).
		// Otherwise use the canonical style view url (bug 42553).
		if ( ve.getObjectValues( uri.query ).length ) {
			window.history.pushState( this.popState, document.title, uri );
		} else {
			window.history.pushState( this.popState, document.title, this.viewUri );
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

	newUri = this.currentUri = new mw.Uri( document.location.href );

	if ( !this.active && newUri.query.veaction === 'edit' ) {
		this.actFromPopState = true;
		this.activate();
		this.emit( 'popStateActivated' );
	}
	if ( this.active && newUri.query.veaction !== 'edit' ) {
		this.actFromPopState = true;
		this.deactivate();
		this.emit( 'popStateDeactivated' );
		// Trigger Qualaroo survey for anonymous users abandoning edit
		/*
		if ( mw.user.anonymous() && window._kiq ) {
			_kiq.push( ['set', { 'event': 'abandon_ve_back' } ] );
		}
		*/
	}
};

/**
 * Replace the page content with new HTML.
 *
 * @method
 * @param {string} html Rendered HTML from server
 * @param {string} categoriesHtml Rendered categories HTML from server
 */
ve.init.mw.ViewPageTarget.prototype.replacePageContent = function ( html, categoriesHtml, isRedirect ) {
	var $content = $( $.parseHTML( html ) ), $editableContent;

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
	$( '#catlinks' ).replaceWith( categoriesHtml );
	if ( isRedirect ) {
		$( '#contentSub' ).text( ve.msg( 'redirectpagesub' ) );
	} else {
		$( '#contentSub' ).text( '' );
	}
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
 * Add onbeforunload handler.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.setupBeforeUnloadHandler = function () {
	// Remember any already set on before unload handler
	this.onBeforeUnloadFallback = window.onbeforeunload;
	// Attach before unload handler
	window.onbeforeunload = this.onBeforeUnloadHandler = ve.bind( this.onBeforeUnload, this );
	// Attach page show handlers
	if ( window.addEventListener ) {
		window.addEventListener( 'pageshow', ve.bind( this.onPageShow, this ), false );
	} else if ( window.attachEvent ) {
		window.attachEvent( 'pageshow', ve.bind( this.onPageShow, this ) );
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
					( !usePrefs && $.cookie( 've-beta-welcome-dialog' ) === null )
				)
			) {
			this.surface.getDialogs().getWindow( 'betaWelcome' ).open();
		}

		if ( prefSaysShow ) {
			ve.init.target.constructor.static.apiRequest( {
				'action': 'options',
				'token': mw.user.tokens.get( 'editToken' ),
				'change': 'visualeditor-hidebetawelcome=1'
			}, { 'type': 'POST' } );

		// No need to set a cookie every time for logged-in users that have already
		// set the hidebetawelcome=1 preference, but only if this isn't a one-off
		// view of the page via the hiding GET parameter.
		} else if ( !usePrefs && !urlSaysHide ) {
			$.cookie( 've-beta-welcome-dialog', 1, { 'path': '/', 'expires': 30 } );
		}
	}

	if ( this.surface.getModel().metaList.getItemsInGroup( 'mwRedirect' ).length ) {
		this.surface.getDialogs().getWindow( 'meta' ).open(
			this.surface.getModel().getFragment(),
			{ 'page': 'settings' }
		);
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

	this.emit( 'beforeUnload' );
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
			return null;
		}
		// Check if there's been an edit
		if ( this.surface && this.edited && mw.user.options.get( 'useeditwarning' ) ) {
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
