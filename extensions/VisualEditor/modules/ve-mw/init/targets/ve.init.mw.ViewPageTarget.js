/*!
 * VisualEditor MediaWiki Initialization ViewPageTarget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
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
	var browserWhitelisted,
		currentUri = new mw.Uri( location.href );

	// Parent constructor
	ve.init.mw.Target.call(
		this, $( '#WikiaArticle' ),
		mw.config.get( 'wgRelevantPageName' ),
		currentUri.query.oldid
	);

	// Properties
	this.$document = null;
	this.$spinner = $( '<div class="ve-init-mw-viewPageTarget-loading"></div>' );
	this.$toolbarTracker = $( '<div class="ve-init-mw-viewPageTarget-toolbarTracker"></div>' );
	this.toolbarTrackerFloating = null;
	this.toolbarOffset = null;
	this.toolbarCancelButton = null;
	this.toolbarSaveButton = null;
	this.saveDialog = null;
	this.onBeforeUnloadFallback = null;
	this.onBeforeUnloadHandler = null;
	this.timings = {};
	this.active = false;
	this.edited = false;
	this.sanityCheckFinished = false;
	this.sanityCheckVerified = false;
	this.activating = false;
	this.deactivating = false;
	// If this is true then #transformPage / #restorePage will not call pushState
	// This is to avoid adding a new history entry for the url we just got from onpopstate
	// (which would mess up with the expected order of Back/Forwards browsing)
	this.actFromPopState = false;
	this.scrollTop = null;
	this.currentUri = currentUri;
	this.section = currentUri.query.vesection || null;
	this.sectionPositionRestored = false;
	this.sectionTitleRestored = false;
	this.namespaceName = mw.config.get( 'wgCanonicalNamespace' );
	this.viewUri = new mw.Uri( mw.util.getUrl( this.pageName ) );
	this.veEditUri = this.viewUri.clone().extend( { 'veaction': 'edit' } );
	this.isViewPage = (
		mw.config.get( 'wgAction' ) === 'view' &&
		currentUri.query.diff === undefined
	);
	this.originalDocumentTitle = document.title;
	this.editSummaryByteLimit = 255;
	this.tabLayout = mw.config.get( 'wgVisualEditorConfig' ).tabLayout;

	/**
	 * @property {jQuery.Promise|null}
	 */
	this.sanityCheckPromise = null;

	browserWhitelisted = (
		'vewhitelist' in currentUri.query ||
		$.client.test( ve.init.mw.ViewPageTarget.compatibility.whitelist, null, true )
	);

	// Events
	this.connect( this, {
		'load': 'onLoad',
		'save': 'onSave',
		'loadError': 'onLoadError',
		'tokenError': 'onTokenError',
		'saveError': 'onSaveError',
		'editConflict': 'onEditConflict',
		'showChanges': 'onShowChanges',
		'showChangesError': 'onShowChangesError',
		'noChanges': 'onNoChanges',
		'serializeError': 'onSerializeError'
	} );

	if ( !browserWhitelisted ) {
		// Show warning in unknown browsers that pass the support test
		// Continue at own risk.
		this.localNoticeMessages.push( 'visualeditor-browserwarning' );
	}

	if ( currentUri.query.venotify ) {
		// The following messages can be used here:
		// visualeditor-notification-saved
		// visualeditor-notification-created
		// visualeditor-notification-restored
		mw.hook( 'postEdit' ).fire( {
			'message':
				ve.msg( 'visualeditor-notification-' + currentUri.query.venotify,
					new mw.Title( this.pageName ).toText()
				)
		} );
		if ( window.history.replaceState ) {
			delete currentUri.query.venotify;
			window.history.replaceState( null, document.title, currentUri );
		}
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
		'safari': [['>=', 5]],
		'chrome': [['>=', 19]]
	}
};

/* Methods */

/**
 * Switch to edit mode.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.activate = function () {
	if ( !this.active && !this.activating ) {
		this.activating = true;
		this.timings.activationStart = ve.now();

		// User interface changes
		this.transformPage();
		this.showSpinner();
		this.hideTableOfContents();
		this.mutePageContent();
		this.mutePageTitle();

		this.saveScrollPosition();

		this.load();
	}
};

/**
 * Switch to view mode.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.deactivate = function ( override ) {
	if ( override || ( this.active && !this.deactivating ) ) {
		if (
			override ||
			!this.edited ||
			confirm( ve.msg( 'visualeditor-viewpage-savewarning' ) )
		) {
			this.deactivating = true;
			// User interface changes
			this.restorePage();
			this.hideSpinner();
			this.showTableOfContents();

			if ( this.toolbarCancelButton ) {
				// If deactivate is called before a successful load, then
				// setupToolbarButtons has not been called yet and as such tearDownToolbarButtons
				// would throw an error when trying call methods on the button property (bug 46456)
				this.tearDownToolbarButtons();
				this.detachToolbarButtons();
			}

			if ( this.saveDialog ) {
				// If we got as far as setting up the save dialog, tear it down
				this.saveDialog.reset();
				this.saveDialog.close();
			}
			// Check we got as far as setting up the surface
			if ( this.active ) {
				// If we got as far as setting up the surface, tear that down
				this.tearDownSurface( true );
			}

			// Show/restore components that are otherwise handled by tearDownSurface
			this.showPageContent();
			this.restorePageTitle();

			// If there is a load in progress, abort it
			if ( this.loading ) {
				this.loading.abort();
			}

			this.deactivating = false;
			mw.hook( 've.deactivationComplete' ).fire();
		}
	}
};

/**
 * Handle successful DOM load event.
 *
 * @method
 * @param {HTMLDocument} doc Parsed DOM from server
 */
ve.init.mw.ViewPageTarget.prototype.onLoad = function ( doc ) {
	if ( this.activating ) {
		this.edited = false;
		this.doc = doc;
		this.setUpSurface( doc, ve.bind( function() {
			this.startSanityCheck();
			this.setupToolbarButtons();
			this.setupSaveDialog();
			this.attachToolbarButtons();
			this.restoreScrollPosition();
			this.restoreEditSection();
			this.setupBeforeUnloadHandler();
			this.$document[0].focus();
			this.activating = false;
			if ( mw.config.get( 'wgVisualEditorConfig' ).showBetaWelcome ) {
				this.showBetaWelcome();
			}
			if ( window.veTrack ) {
				veTrack( { action: 've-edit-page-stop' } );
			}
			ve.track( 'performance.system.activation', { 'duration': ve.now() - this.timings.activationStart } );
			mw.hook( 've.activationComplete' ).fire();
		}, this ), true );
	}
};

/**
 * Handle failed DOM load event.
 *
 * @method
 * @param {Object} response HTTP Response object
 * @param {string} status Text status message
 * @param {Mixed} error Thrown exception or HTTP error string
 */
ve.init.mw.ViewPageTarget.prototype.onLoadError = function ( response, status ) {
	// Don't show an error if the load was manually aborted
	if ( status !== 'abort' && confirm( ve.msg( 'visualeditor-loadwarning', status ) ) ) {
		this.load();
	} else {
		this.activating = false;
		// User interface changes
		this.deactivate( true );
	}
};

/**
 * Handle failed token refresh event.
 *
 * @method
 * @param {Object} response Response object
 * @param {string} status Text status message
 * @param {Mixed} error Thrown exception or HTTP error string
 */
ve.init.mw.ViewPageTarget.prototype.onTokenError = function ( response, status ) {
	if ( confirm( ve.msg( 'visualeditor-loadwarning-token', status ) ) ) {
		this.load();
	} else {
		this.activating = false;
		// User interface changes
		this.deactivate( true );
	}
};

/**
 * Handle successful DOM save event.
 *
 * @method
 * @param {HTMLElement} html Rendered HTML from server
 * @param {number} [newid] New revision id, undefined if unchanged
 */
ve.init.mw.ViewPageTarget.prototype.onSave = function ( html, newid ) {
	ve.track( 'performance.user.saveComplete', { 'duration': ve.now() - this.timings.saveDialogSave } );
	if ( !this.pageExists || this.restoring ) {
		// This is a page creation or restoration, refresh the page
		this.tearDownBeforeUnloadHandler();
		window.location.href = this.viewUri.extend( {
			'venotify': this.restoring ? 'restored' : 'created'
		} );
	} else {
		// Update watch link to match 'watch checkbox' in save dialog.
		// User logged in if module loaded.
		// Just checking for mw.page.watch is not enough because in Firefox
		// there is Object.prototype.watch...
		if ( mw.page.watch && mw.page.watch.updateWatchLink ) {
			var watchChecked = this.saveDialog.$saveOptions
				.find( '.ve-ui-mwSaveDialog-checkboxes' )
					.find( '#wpWatchthis' )
					.prop( 'checked' );
			mw.page.watch.updateWatchLink(
				$( '#ca-watch a, #ca-unwatch a' ),
				watchChecked ? 'unwatch': 'watch'
			);
		}

		// If we were explicitly editing an older version, make sure we won't
		// load the same old version again, now that we've saved the next edit
		// will be against the latest version.
		// TODO: What about oldid in the url?
		this.restoring = false;

		if ( newid !== undefined ) {
			mw.config.set( 'wgCurRevisionId', newid );
			this.revid = newid;
		}
		this.saveDialog.close();
		this.saveDialog.reset();
		this.replacePageContent( html );
		this.setupSectionEditLinks();
		this.tearDownBeforeUnloadHandler();
		this.deactivate( true );
		mw.hook( 'postEdit' ).fire( {
			'message':
				ve.msg( 'visualeditor-notification-saved',
					new mw.Title( this.pageName ).toText()
				)
		} );
	}
};

/**
 * Handle failed DOM save event.
 *
 * @method
 * @param {Object} jqXHR
 * @param {string} status Text status message
 * @param {Object|null} data API response data
  */
ve.init.mw.ViewPageTarget.prototype.onSaveError = function ( jqXHR, status, data ) {
	var api, editApi,
		trackData = {
			'duration': ve.now() - this.timings.saveDialogSave,
			'retries': this.timings.saveRetries
		},
		viewPage = this;

	this.saveDialog.saveButton.setDisabled( false );
	this.saveDialog.$loadingIcon.hide();

	this.saveDialog.clearMessage( 'api-save-error' );

	// Handle empty response
	if ( !data ) {
		trackData.type = 'empty';
		ve.track( 'performance.user.saveError', trackData );
		this.saveDialog.showMessage(
			'api-save-error',
			ve.msg( 'visualeditor-saveerror', 'Empty server response' ),
			{
				wrap: 'error'
			}
		);
		this.saveDialog.saveButton.setDisabled( true );
		return;
	}

	editApi = data && data.visualeditoredit && data.visualeditoredit.edit;

	// Handle spam blacklist error (either from core or from Extension:SpamBlacklist)
	if ( editApi && editApi.spamblacklist ) {
		trackData.type = 'spamblacklist';
		ve.track( 'performance.user.saveError', trackData );
		this.saveDialog.showMessage(
			'api-save-error',
			// TODO: Use mediawiki.language equivalant of Language.php::listToText once it exists
			ve.msg( 'spamprotectiontext' ) + ' ' + ve.msg( 'spamprotectionmatch', editApi.spamblacklist.split( '|' ).join( ', ' ) ),
			{
				wrap: 'error'
			}
		);
		this.saveDialog.saveButton.setDisabled( true );
		return;
	}

	// Handle warnings/errors from Extension:AbuseFilter
	// TODO: Move this to a plugin
	if ( editApi && editApi.info && editApi.info.indexOf( 'Hit AbuseFilter:' ) === 0 && editApi.warning ) {
		trackData.type = 'abusefilter';
		ve.track( 'performance.user.saveError', trackData );
		this.saveDialog.showMessage(
			'api-save-error',
			$.parseHTML( editApi.warning ),
			{ wrap:  false }
		);
		// Don't disable the save button. If the action is not disallowed the user may save the
		// edit by pressing Save again. The AbuseFilter API currently has no way to distinguish
		// between filter triggers that are and aren't disallowing the action.
		return;
	}

	// Handle token errors
	if ( data.error && data.error.code === 'badtoken' ) {
		api = new mw.Api();
		viewPage.saveDialog.saveButton.setDisabled( true );
		viewPage.saveDialog.$loadingIcon.show();
		api.get( {
			// action=query&meta=userinfo and action=tokens&type=edit can't be combined
			// but action=query&meta=userinfo and action=query&prop=info can, however
			// that means we have to give it titles and deal with page ids.
			'action': 'query',
			'meta': 'userinfo',
			'prop': 'info',
			// Try to send the normalised form so that it is less likely we get extra data like
			// data.normalised back that we don't need.
			'titles': new mw.Title( viewPage.pageName ).toText(),
			'indexpageids': '',
			'intoken': 'edit'
		} )
			.always( function () {
				viewPage.saveDialog.$loadingIcon.hide();
			} )
			.done( function ( data ) {
				var badTokenText, userMsg,
					userInfo = data.query && data.query.userinfo,
					pageInfo = data.query && data.query.pages && data.query.pageids &&
						data.query.pageids[0] && data.query.pages[ data.query.pageids[0] ],
					editToken = pageInfo && pageInfo.edittoken;

				if ( userInfo && editToken ) {
					viewPage.editToken = editToken;

					if (
						( mw.user.isAnon() && userInfo.anon !== undefined ) ||
							// Comparing id instead of name to pretect against possible
							// normalisation and against case where the user got renamed.
							mw.config.get( 'wgUserId' ) === userInfo.id
					) {
						// New session is the same user still
						this.timings.saveRetries++;
						viewPage.saveDocument();
					} else {
						// The now current session is a different user
						trackData.type = 'badtoken';
						ve.track( 'performance.user.saveError', trackData );
						viewPage.saveDialog.saveButton.setDisabled( false );

						// Trailing space is to separate from the other message.
						badTokenText = document.createTextNode( mw.msg( 'visualeditor-savedialog-error-badtoken' ) + ' ' );

						if ( userInfo.anon !== undefined ) {
							// New session is an anonymous user
							mw.config.set( {
								// wgUserId is unset for anonymous users, not set to null
								'wgUserId': undefined,
								// wgUserName is explicitly set to null for anonymous users,
								// functions like mw.user.isAnon rely on this.
								'wgUserName': null
							} );

							viewPage.saveDialog.showMessage(
								'api-save-error',
								$( badTokenText ).add(
									$.parseHTML( mw.message( 'visualeditor-savedialog-identify-anon' ).parse() )
								),
								{ wrap: 'warning' }
							);
						} else {
							// New session is a different user
							mw.config.set( { 'wgUserId': userInfo.id, 'wgUserName': userInfo.name } );

							// mediawiki.jqueryMsg has a bug with [[User:$1|$1]] (bug 51388)
							userMsg = 'visualeditor-savedialog-identify-user---' + userInfo.name;
							mw.messages.set(
								userMsg,
								mw.messages.get( 'visualeditor-savedialog-identify-user' )
									.replace( /\$1/g, userInfo.name )
							);

							viewPage.saveDialog.showMessage(
								'api-save-error',
								$( badTokenText ).add(
									$.parseHTML( mw.message( userMsg ).parse() )
								),
								{ wrap: 'warning' }
							);
						}
					}

				}
			} );
		return;
	}

	// Handle captcha
	// Captcha "errors" usually aren't errors. We simply don't know about them ahead of time,
	// so we save once, then (if required) we get an error with a captcha back and try again after
	// the user solved the captcha.
	// TODO: ConfirmEdit API is horrible, there is no reliable way to know whether it is a "math",
	// "question" or "fancy" type of captcha. They all expose differently named properties in the
	// API for different things in the UI. At this point we only support the FancyCaptha which we
	// very intuitively detect by the presence of a "url" property.
	if ( editApi && editApi.captcha && editApi.captcha.url ) {
		trackData.type = 'captcha';
		ve.track( 'performance.user.saveError', trackData );
		this.captcha = {
			input: new OO.ui.TextInputWidget(),
			id: editApi.captcha.id
		};
		this.saveDialog.showMessage(
			'api-save-error',
			$( '<div>' ).append(
				// msg: simplecaptcha-edit, fancycaptcha-edit, ..
				$( '<p>' ).append(
					$( '<strong>' ).text( mw.msg( 'captcha-label' ) ),
					document.createTextNode( mw.msg( 'colon-separator' ) ),
					$( $.parseHTML( mw.message( 'fancycaptcha-edit' ).parse() ) )
						.filter( 'a' ).attr( 'target', '_blank' ).end()
				),
				$( '<img>' ).attr( 'src', editApi.captcha.url ),
				this.captcha.input.$element
			),
			{
				wrap: false
			}
		);
		return;
	}

	// Handle (other) unknown and/or unrecoverable errors
	trackData.type = 'unknown';
	ve.track( 'performance.user.saveError', trackData );
	this.saveDialog.showMessage(
		'api-save-error',
		document.createTextNode(
			( editApi && editApi.info ) ||
				( data.error && data.error.info ) ||
				( editApi && editApi.code ) ||
				( data.error && data.error.code ) ||
				'Unknown error'
		),
		{
			wrap: 'error'
		}
	);
	this.saveDialog.saveButton.setDisabled( true );
};

/**
 * Handle Show changes event.
 *
 * @method
 * @param {string} diffHtml
 */
ve.init.mw.ViewPageTarget.prototype.onShowChanges = function ( diffHtml ) {
	ve.track( 'performance.user.reviewComplete', { 'duration': ve.now() - this.timings.saveDialogReview } );
	// Invalidate the viewer diff on next change
	this.surface.getModel().getDocument().connect( this, { 'transact': 'clearSaveDialogDiff' } );
	this.saveDialog.setDiffAndReview( diffHtml );
};

/**
 * Handle Serialize event.
 *
 * @method
 * @param {string} wikitext
 */
ve.init.mw.ViewPageTarget.prototype.onSerialize = function ( wikitext ) {
	ve.track( 'performance.user.reviewComplete', { 'duration': ve.now() - this.timings.saveDialogReview } );
	// Invalidate the viewer wikitext on next change
	this.surface.getModel().getDocument().connect( this, { 'transact': 'clearSaveDialogDiff' } );
	this.saveDialog.setDiffAndReview( $( '<pre>' ).text( wikitext ) );
};

/**
 * Handle failed show changes event.
 *
 * @method
 * @param {Object} jqXHR
 * @param {string} status Text status message
 */
ve.init.mw.ViewPageTarget.prototype.onShowChangesError = function ( jqXHR, status ) {
	ve.track( 'performance.user.reviewError', { 'duration': ve.now() - this.timings.saveDialogReview } );
	alert( ve.msg( 'visualeditor-differror', status ) );
	this.saveDialog.$loadingIcon.hide();
};

/**
 * Called if a call to target.serialize() failed.
 *
 * @method
 * @param {jqXHR|null} jqXHR
 * @param {string} status Text status message
 */
ve.init.mw.ViewPageTarget.prototype.onSerializeError = function ( jqXHR, status ) {
	if ( this.timings.saveDialogOpen ) {
		// This function can be called by the switch to wikitext button as well, so only log
		// reviewError if we actually got here from the save dialog
		ve.track( 'performance.user.reviewError', { 'duration': ve.now() - this.timings.saveDialogReview } );
	}
	alert( ve.msg( 'visualeditor-serializeerror', status ) );
	this.saveDialog.$loadingIcon.hide();
};

/**
 * Handle edit conflict event.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onEditConflict = function () {
	ve.track( 'performance.user.saveError.editconflict', {
		'duration': ve.now() - this.timings.saveDialogSave,
		'retries': this.timings.saveRetries
	} );
	this.saveDialog.$loadingIcon.hide();
	this.saveDialog.swapPanel( 'conflict' );
};

/**
 * Handle failed show changes event.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onNoChanges = function () {
	ve.track( 'performance.user.reviewComplete', { 'duration': ve.now() - this.timings.saveDialogReview } );
	this.saveDialog.$loadingIcon.hide();
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
 * Clear the diff in the save dialog.
 *
 * This method is bound to the 'transact' event on the document model, and unbinds itself the first
 * time it runs. It's bound when the surface is set up and rebound every time a diff is loaded into
 * the save dialog.
 *
 * @method
 * @param {ve.dm.Transaction} tx Processed transaction
 */
ve.init.mw.ViewPageTarget.prototype.clearSaveDialogDiff = function () {
	// Clear the diff
	this.saveDialog.$reviewViewer.empty();
	this.surface.getModel().getDocument().disconnect( this, { 'transact': 'clearSaveDialogDiff' } );
};

/**
 * Record the time of the last transaction in response to a 'transact' event on the document.
 */
ve.init.mw.ViewPageTarget.prototype.recordLastTransactionTime = function () {
	this.timings.lastTransaction = ve.now();
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
 * @param {ve.dm.Transaction} transaction
 */
ve.init.mw.ViewPageTarget.prototype.checkForWikitextWarning = function () {
	var text, doc = this.surface.getView().getDocument(),
		selection = this.surface.getModel().getSelection(),
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
				'onClose': function() {
					ve.track( 'wikia', { 'action': ve.track.actions.CLOSE, 'label': 'modal-wikitext-warning' } );
				},
				'onCreate': function() {
					ve.track( 'wikia', { 'action': ve.track.actions.OPEN, 'label': 'modal-wikitext-warning' } );
				}
			}
		);
		this.surface.getModel().disconnect(
			this, { 'documentUpdate': 'checkForWikitextWarning' }
		);
	}
};

/**
 * Re-evaluate whether the toolbar save button should be disabled or not.
 */
ve.init.mw.ViewPageTarget.prototype.updateToolbarSaveButtonState = function () {
	this.edited = this.surface.getModel().hasPastState() || this.wikitext !== null;
	// Disable the save button if we have no history or if the sanity check is not finished
	this.toolbarSaveButton.setDisabled( ( !this.edited && !this.restoring ) || !this.sanityCheckFinished );
	this.toolbarSaveButton.$element.toggleClass( 've-init-mw-viewPageTarget-waiting', !this.sanityCheckFinished );
};

/**
 * Handle clicks on the review button in the save dialog.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onSaveDialogReview = function () {
	var doc = this.surface.getModel().getDocument();
	this.sanityCheckVerified = true;
	this.saveDialog.setSanityCheck( this.sanityCheckVerified );

	if ( !this.saveDialog.$reviewViewer.find( 'table, pre' ).length ) {
		this.timings.saveDialogReview = ve.now();
		ve.track( 'behavior.saveDialogOpenTillReview', {
			'duration': this.timings.saveDialogReview - this.timings.saveDialogOpen
		} );

		this.saveDialog.reviewGoodButton.setDisabled( true );
		this.saveDialog.$loadingIcon.show();
		if ( this.pageExists ) {
			// Has no callback, handled via target.onShowChanges
			this.showChanges(
				ve.dm.converter.getDomFromData( doc.getFullData(), doc.getStore(), doc.getInternalList(), doc.getInnerWhitespace() )
			);
		} else {
			this.serialize(
				ve.dm.converter.getDomFromData( doc.getFullData(), doc.getStore(), doc.getInternalList(), doc.getInnerWhitespace() ),
				ve.bind( this.onSerialize, this )
			);
		}
	} else {
		this.saveDialog.swapPanel( 'review' );
	}
};

/**
 * Handle clicks on the save button in the save dialog.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onSaveDialogSave = function () {
	this.timings.saveDialogSave = ve.now();
	this.timings.saveRetries = 0;
	ve.track( 'behavior.saveDialogOpenTillSave', {
		'duration': this.timings.saveDialogSave - this.timings.saveDialogOpen
	} );
	this.saveDocument();
};

/**
 * Try to save the current document.
 */
ve.init.mw.ViewPageTarget.prototype.saveDocument = function () {
	var doc = this.surface.getModel().getDocument(),
		saveOptions = this.getSaveOptions();

	// Reset any old captcha data
	if ( this.captcha ) {
		this.saveDialog.clearMessage( 'captcha' );
		delete this.captcha;
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
		this.saveDialog.saveButton.setDisabled( true );
		this.saveDialog.$loadingIcon.show();
		this.save(
			ve.dm.converter.getDomFromData( doc.getFullData(), doc.getStore(), doc.getInternalList(), doc.getInnerWhitespace() ),
			saveOptions
		);
	}
};

/**
 * Switch to edit source mode with the current wikitext
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.editSource = function () {
	var doc = this.surface.getModel().getDocument();

	this.$document.css( 'opacity', 0.5 );

	if ( !confirm( ve.msg( 'visualeditor-mweditmodesource-warning' ) ) ) {
		this.$document.css( 'opacity', 1 );
		return;
	}
	// Get Wikitext from the DOM
	this.serialize(
		ve.dm.converter.getDomFromData( doc.getFullData(), doc.getStore(), doc.getInternalList() ),
		ve.bind( function ( wikitext ) {
			var $form,
				options = this.getSaveOptions(),
				action = new mw.Uri( mw.util.wikiScript() ).extend( { title: this.pageName, action: 'edit' } ).toString();

			this.submitting = true;

			$form = $( '<form method="post" enctype="multipart/form-data" style="display: none;"></form>' )
				.attr( 'action', action )
				.append( $( '<textarea name="wpTextbox1"></textarea>' ).val( wikitext ) )
				.append( $( '<input type="checkbox" name="wpMinoredit" value="1">' ).prop( 'checked', options.minor ) )
				.append( $( '<input type="checkbox" name="wpWatchthis" value="1">' ).prop( 'checked', options.watch ) )
				.append( $( '<input type="hidden" name="wpSummary">' ).val( options.summary ) )
				.append( $( '<input type="hidden" name="wpStarttime">' ).val( this.startTimeStamp ) )
				.append( $( '<input type="hidden" name="wpEditToken">' ).val( this.editToken ) )
				.append( $( '<input type="hidden" name="wpDiff" value="1">' ) )
				.append( $( '<input type="hidden" name="model" value="wikitext">' ) )
				.append( $( '<input type="hidden" name="format" value="text/x-wiki">' ) )
				.append( $( '<input type="hidden" name="wpEdittime">' ) )
			;
			// Firefox requires the form to be attached
			$( 'body' ).append( $form );
			$form.submit();
		}, this )
	);
};

/**
 * Handle clicks on the resolve conflict button in the conflict dialog.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onSaveDialogResolveConflict= function () {
	var doc = this.surface.getModel().getDocument();
	// Get Wikitext from the DOM, and set up a submit call when it's done
	this.serialize(
		ve.dm.converter.getDomFromData( doc.getFullData(), doc.getStore(), doc.getInternalList() ),
		ve.bind( function ( wikitext ) {
			this.submit( wikitext, this.getSaveOptions() );
		}, this )
	);
};

/**
 * Get save options from the save dialog form.
 *
 * @method
 * @returns {Object} Save options, including summary, minor and watch properties
 */
ve.init.mw.ViewPageTarget.prototype.getSaveOptions = function () {
	var options = {
		'summary': this.saveDialog.editSummaryInput.$input.val(),
		'captchaid': this.captcha && this.captcha.id,
		'captchaword': this.captcha && this.captcha.input.getValue()
	};
	if ( this.sanityCheckPromise.state() === 'rejected' ) {
		options.needcheck = 1;
	}
	if ( this.saveDialog.$saveOptions.find( '#wpMinoredit' ).prop( 'checked' ) ) {
		options.minor = 1;
	}
	if ( this.saveDialog.$saveOptions.find( '#wpWatchthis' ).prop( 'checked' ) ) {
		options.watch = 1;
	} else {
		// Firefox has Object.prototype.watch
		options.watch = undefined;
	}
	this.saveDialog.$saveOptions
		.find( '.ve-ui-mwSaveDialog-checkboxes' )
		.find( 'input:not(#wpMinoredit, #wpWatchthis)' )
		.each( function () {
			var $this = $( this );
			// We can't just use $this.val() because .val() always returns the value attribute of
			// a checkbox even when it's unchecked
			if ( $this.prop( 'type') !== 'checkbox' || $this.prop( 'checked' ) ) {
				options[$this.prop( 'name' )] = $this.val();
			}
		} );
	return options;
};

/**
 * Switch to editing mode.
 *
 * @method
 * @param {HTMLDocument} doc HTML DOM to edit
 * @param {Function} [callback] Callback to call when done
 * @param {boolean} animate Should elements like the toolbar animate when hiding and showing.
 */
ve.init.mw.ViewPageTarget.prototype.setUpSurface = function ( doc, callback, animate ) {
	var target = this;
	setTimeout( function () {
		// Build linmod
		var store = new ve.dm.IndexValueStore(),
			internalList = new ve.dm.InternalList(),
			innerWhitespace = new Array( 2 ),
			data = ve.dm.converter.getDataFromDom( doc, store, internalList, innerWhitespace );
		setTimeout( function () {
			// Build DM tree
			var dmDoc = new ve.dm.Document( data, doc, undefined, internalList, innerWhitespace );
			setTimeout( function () {
				// Create ui.Surface (also creates ce.Surface and dm.Surface and builds CE tree)
				target.surface = new ve.ui.Surface( dmDoc, target.surfaceOptions, target );
				target.surface.$element.addClass( 've-init-mw-viewPageTarget-surface' );
				setTimeout( function () {
					// Initialize surface
					target.surface.getContext().hide();
					target.$document = target.surface.$element.find( '.ve-ce-documentNode' );
					target.surface.getModel().getDocument().connect( target, {
						'transact': 'clearSaveDialogDiff'
					} );
					target.surface.getModel().getDocument().connect( target, {
						'transact': 'recordLastTransactionTime'
					} );
					target.surface.getModel().connect( target, {
						'documentUpdate': 'checkForWikitextWarning',
						'history': 'updateToolbarSaveButtonState'
					} );
					target.$element.append( target.surface.$element );
					target.setUpToolbar( animate );
					target.transformPageTitle();
					target.changeDocumentTitle();

					// Update UI
					target.hidePageContent();
					target.hideSpinner();
					target.active = true;
					target.$document.attr( {
						'lang': mw.config.get( 'wgVisualEditor' ).pageLanguageCode,
						'dir': mw.config.get( 'wgVisualEditor' ).pageLanguageDir
					} );

					// Add appropriately mw-content-ltr or mw-content-rtl class
					target.surface.view.$element.addClass(
						'mw-content-' + mw.config.get( 'wgVisualEditor' ).pageLanguageDir
					);

					// Now that the surface is attached to the document and ready,
					// let it initialize itself
					target.surface.initialize();

					setTimeout( callback );
				} );
			} );
		} );
	} );
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
			newDoc = new ve.dm.Document( data, oldDom, undefined, doc.getInternalList(), doc.getInnerWhitespace() ),
			newDom = ve.dm.converter.getDomFromData( newDoc.getFullData(), newDoc.getStore(), newDoc.getInternalList(), newDoc.getInnerWhitespace() );

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
 * @see ve.ui.Toolbar#position
 * @param {jQuery} $bar
 * @param {Object} update
 */
ve.init.mw.ViewPageTarget.prototype.onToolbarPosition = function ( $bar, update ) {
	// It's important that the toolbar tracker always has 0 height, otherwise it will block events
	// on the toolbar (e.g. clicking "Save page") as it would overlap that space. The save dialog
	// will remain visible for the same reason elsewhere: As long as we don't have overflow:hidden,
	// the save dialog will stick out of the tracker in the right place without the tracker itself
	// blocking the toolbar.

	if ( !this.toolbarTrackerFloating && update.floating === true ) {
		// When switching to floating, undo the 'top' position set earlier
		this.$toolbarTracker.css( 'top', '' );
	}

	if ( update.offset ) {
		this.toolbarOffset = update.offset;
	}

	if ( typeof update.floating === 'boolean' ) {
		this.$toolbarTracker.toggleClass(
			've-init-mw-viewPageTarget-toolbarTracker-floating',
			update.floating
		);
		this.toolbarTrackerFloating = update.floating;
	}

	// Switching to non-floating or offset update when already in non-floating
	if ( update.floating === false || this.toolbarTrackerFloating === false && update.offset ) {
		// Don't use update.css in this case since the toolbar is now in its non-floating
		// position (static, in-flow). So make the tracker absolutely postioned matching the
		// offset of the toolbar.
		this.$toolbarTracker.css( {
			'top': this.toolbarOffset.top,
			'left': this.toolbarOffset.left,
			'right': this.toolbarOffset.right
		} );
	} else if ( update.css ) {
		this.$toolbarTracker.css( update.css );
	}
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
	this.restoreDocumentTitle();
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
	this.toolbarCancelButton = new OO.ui.PushButtonWidget( { 'label': ve.msg( 'visualeditor-toolbar-cancel' ) } );
	this.toolbarCancelButton.$element.addClass( 've-ui-toolbar-cancelButton' );
	this.toolbarSaveButton = new OO.ui.PushButtonWidget( {
		'label': ve.msg( 'wikia-visualeditor-toolbar-savedialog' ),
		'flags': ['constructive'],
		'disabled': !this.restoring
	} );
	// TODO (mattflaschen, 2013-06-27): it would be useful to do this in a more general way, such
	// as in the ButtonWidget constructor.
	this.toolbarSaveButton.$element.addClass( 've-ui-toolbar-saveButton' );
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
	var sectionTitle = '';

	this.saveDialog = this.surface.getDialogs().getWindow( 'mwSave' );

	if ( this.section ) {
		sectionTitle = this.$document.find( 'h1, h2, h3, h4, h5, h6' ).eq( this.section - 1 ).text();
		sectionTitle = '/* ' + ve.graphemeSafeSubstring( sectionTitle, 0, 244 ) + ' */ ';
		this.saveDialog.editSummaryInput.$input.val( sectionTitle );
		this.sectionTitleRestored = true;
		if ( this.sectionPositionRestored ) {
			this.onSectionRestored();
		}
	}

	// Connect to save dialog
	this.saveDialog.connect( this, {
		'save': 'onSaveDialogSave',
		'review': 'onSaveDialogReview',
		'resolve': 'onSaveDialogResolveConflict',
		'close': 'onSaveDialogClose'
	} );
	// Setup checkboxes
	this.saveDialog.setupCheckboxes( ve.getObjectValues( this.checkboxes ).join( '\n' ) );
};

/**
 * Show the save dialog.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.showSaveDialog = function () {
	this.saveDialog.setSanityCheck( this.sanityCheckVerified );
	this.saveDialog.swapPanel( 'save' );
	this.surface.getDialogs().getWindow( 'mwSave' ).open();
	this.timings.saveDialogOpen = ve.now();
	ve.track( 'behavior.lastTransactionTillSaveDialogOpen', {
		'duration': this.timings.saveDialogOpen - this.timings.lastTransaction
	} );
};

 /**
 * Respond to the save dialog being closed.
 */
ve.init.mw.ViewPageTarget.prototype.onSaveDialogClose = function () {
	ve.track( 'behavior.saveDialogClose', { 'duration': ve.now() - this.timings.saveDialogOpen } );
	this.timings.saveDialogOpen = null;
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
};

/**
 * Mute the page content.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.mutePageContent = function () {
	$( '#bodyContent > :visible:not(#siteSub, #contentSub)' )
		.addClass( 've-init-mw-viewPageTarget-content' )
		.fadeTo( 'fast', 0.6 );
};

/**
 * Hide the page content.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.hidePageContent = function () {
	$( '#bodyContent > :visible:not(#siteSub, #contentSub)' )
		.addClass( 've-init-mw-viewPageTarget-content' )
		.hide();
};

/**
 * Show the table of contents in the view mode.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.showTableOfContents = function () {
	var $toc = $( '#toc' ),
		$wrap = $toc.parent();
	if ( $wrap.data( 've.hideTableOfContents' ) ) {
		$wrap.slideDown( function () {
			$toc.unwrap();
		} );
	}
};

/**
 * Hide the table of contents in the view mode.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.hideTableOfContents = function () {
	$( '#toc' )
		.wrap( '<div>' )
		.parent()
			.data( 've.hideTableOfContents', true )
			.slideUp();
};

/**
 * Show the toolbar.
 *
 * This also transplants the toolbar to a new location.
 *
 * @param {boolean} animate Whether or not to animate the toolbar's hiding and showing.
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.setUpToolbar = function ( animate ) {
	var setup;

	this.toolbar = new ve.ui.TargetToolbar( this, this.surface, { 'shadow': true, 'actions': true } );
	this.toolbar.connect( this, { 'position': 'onToolbarPosition' } );
	this.toolbar.setup( this.constructor.static.toolbarGroups );
	this.surface.addCommands( this.constructor.static.surfaceCommands );
	if ( !this.isMobileDevice ) {
		this.toolbar.enableFloatable();
	}
	this.toolbar.$element
		.addClass( 've-init-mw-viewPageTarget-toolbar' )
		//.insertBefore( '#firstHeading' );
		.insertAfter( '#WikiaPageHeader' );

	setup = ve.bind( function () {
		// Check the surface wasn't torn down while the toolbar was animating
		if ( this.surface ) {
			this.toolbar.initialize();
			this.surface.emit( 'position' );
			this.surface.getContext().update();
		}
	}, this );

	if ( animate ) {
		this.toolbar.$bar.slideDown( 'fast', setup );
	} else {
		setup();
	}
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
	$( '#contentSub' )
		.addClass( 've-init-mw-viewPageTarget-transform ve-init-mw-viewPageTarget-transform-hidden' );
};

/**
 * Restore the page title to its original style.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.restorePageTitle = function () {
	var $els = $( '#firstHeading, #siteSub, #contentSub' )
		.removeClass( 've-init-mw-viewPageTarget-transform-muted ve-init-mw-viewPageTarget-transform-hidden' );

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
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.transformPage = function () {
	var uri;

	// Put skin tabs in "edit" mode
	$( $( '#p-views' ).length ? '#p-views' : '#p-cactions' )
		.find( 'li.selected' ).removeClass( 'selected' );
	$( '#ca-ve-edit' )
		.addClass( 'selected' );

	// Hide site notice (if present)
	$( '#siteNotice:visible' )
		.addClass( 've-hide' )
		.slideUp( 'fast' );

	// Push veaction=edit url in history (if not already. If we got here by a veaction=edit
	// permalink then it will be there already and the constructor called #activate)
	if ( !this.actFromPopState && window.history.pushState && this.currentUri.query.veaction !== 'edit' ) {
		// Set the veaction query parameter
		uri = this.currentUri;
		uri.query.veaction = 'edit';

		window.history.pushState( null, document.title, uri );
	}
	this.actFromPopState = false;
};

/**
 * Page modifications for switching back to view mode.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.restorePage = function () {
	var uri;

	// Put skin tabs back in "view" mode
	$( $( '#p-views' ).length ? '#p-views' : '#p-cactions' )
		.find( 'li.selected' ).removeClass( 'selected' );
	$( '#ca-view' ).addClass( 'selected' );


	// Make site notice visible again (if present)
	$( '#siteNotice.ve-hide' )
		.slideDown( 'fast' );

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
			window.history.pushState( null, document.title, uri );
		} else {
			window.history.pushState( null, document.title, this.viewUri );
		}
	}
	this.actFromPopState = false;
};

/**
 * @param {Event} e Native event object
 */
ve.init.mw.ViewPageTarget.prototype.onWindowPopState = function () {
	var newUri = this.currentUri = new mw.Uri( document.location.href );
	if ( !this.active && newUri.query.veaction === 'edit' ) {
		this.actFromPopState = true;
		this.activate();
	}
	if ( this.active && newUri.query.veaction !== 'edit' ) {
		this.actFromPopState = true;
		this.deactivate();
	}
};

/**
 * Replace the page content with new HTML.
 *
 * @method
 * @param {HTMLElement} html Rendered HTML from server
 */
ve.init.mw.ViewPageTarget.prototype.replacePageContent = function ( html ) {
	var $content = $( $.parseHTML( html ) );
	mw.hook( 'wikipage.content' ).fire( $( '#mw-content-text' ).empty().append( $content ) );
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
 * Move the cursor in the editor to a given section.
 *
 * @method
 * @param {number} section Section to move cursor to
 */
ve.init.mw.ViewPageTarget.prototype.restoreEditSection = function () {
	if ( this.section !== null ) {
		var offset, offsetNode, nextNode,
			target = this,
			surfaceView = this.surface.getView(),
			surfaceModel = surfaceView.getModel(),
			$section = this.$document.find( 'h1, h2, h3, h4, h5, h6' ).eq( this.section - 1 ),
			headingNode = $section.data( 'view' ),
			lastHeadingLevel = -1;

		if ( headingNode ) {
			// Find next sibling which isn't a heading
			offsetNode = headingNode;
			while ( offsetNode instanceof ve.ce.HeadingNode && offsetNode.getModel().getAttribute( 'level' ) > lastHeadingLevel ) {
				lastHeadingLevel = offsetNode.getModel().getAttribute( 'level' );
				// Next sibling
				nextNode = offsetNode.parent.children[ve.indexOf( offsetNode, offsetNode.parent.children ) + 1];
				if ( !nextNode ) {
					break;
				}
				offsetNode = nextNode;
			}
			offset = surfaceModel.getDocument().data.getNearestContentOffset(
				offsetNode.getModel().getOffset(), 1
			);
			surfaceModel.setSelection( new ve.Range( offset ) );
			// Scroll to heading:
			// Wait for toolbar to animate in so we can account for its height
			setTimeout( function () {
				var $window = $( OO.ui.Element.getWindow( target.$element ) );
				$window.scrollTop( headingNode.$element.offset().top - target.toolbar.$element.height() );
			}, 200 );
		}

		this.sectionPositionRestored = true;
		if ( this.sectionTitleRestored ) {
			this.onSectionRestored();
		}
	}
};

/**
 * Handle restoration of section editing position and title
 */
ve.init.mw.ViewPageTarget.prototype.onSectionRestored = function () {
	this.section = null;
	this.sectionPositionRestored = false;
	this.sectionTitleRestored = false;
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
 * Show beta welcome dialog if first load.
 */
ve.init.mw.ViewPageTarget.prototype.showBetaWelcome = function () {
	if ( $.cookie( 've-beta-welcome-dialog' ) === null ) {
		this.surface.getDialogs().getWindow( 'betaWelcome' ).open();
	}
	$.cookie( 've-beta-welcome-dialog', 1, { 'path': '/', 'expires': 30 } );
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
			return null;
		}
		// Check if there's been an edit
		if ( this.surface && this.edited ) {
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
