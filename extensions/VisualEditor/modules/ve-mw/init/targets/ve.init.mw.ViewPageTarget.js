/*!
 * VisualEditor MediaWiki Initialization ViewPageTarget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw, confirm, alert */

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
	this.saveDialogSlideHistory = [];
	this.saveDialogSaveButton = null;
	this.saveDialogReviewGoodButton = null;

	this.$toolbarEditNotices = $( '<div>' )
		.addClass( 've-init-mw-viewPageTarget-toolbar-editNotices' );
	this.$toolbarEditNoticesTool = $( '<div>' )
		.addClass( 've-init-mw-viewPageTarget-tool' );

	this.$toolbarFeedbackTool = $( '<div>' )
		.addClass( 've-init-mw-viewPageTarget-tool' );

	this.$toolbarBetaNotice = $( '<div>' )
		.addClass( 've-init-mw-viewPageTarget-toolbar-betaNotice' );
	this.$toolbarBetaNoticeTool = $( '<div>' )
		.addClass( 've-init-mw-viewPageTarget-tool' );

	this.$toolbarMwMetaButton = $( '<div>' )
		.addClass( 've-init-mw-viewPageTarget-tool' );
	this.$saveDialog = $( '<div>' )
		.addClass( 've-init-mw-viewPageTarget-saveDialog' );

	this.onBeforeUnloadFallback = null;
	this.onBeforeUnloadHandler = null;
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
	this.messages = {};
	this.section = currentUri.query.vesection || null;
	this.sectionPositionRestored = false;
	this.sectionTitleRestored = false;
	this.namespaceName = mw.config.get( 'wgCanonicalNamespace' );
	this.viewUri = new mw.Uri( mw.util.wikiGetlink( this.pageName ) );
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

ve.inheritClass( ve.init.mw.ViewPageTarget, ve.init.mw.Target );

/* Static Properties */

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

// TODO: Accessibility tooltips and logical tab order for prevButton and closeButton.
ve.init.mw.ViewPageTarget.static.saveDialogTemplate = '\
	<div class="ve-init-mw-viewPageTarget-saveDialog-head">\
		<div class="ve-init-mw-viewPageTarget-saveDialog-prevButton"></div>\
		<div class="ve-init-mw-viewPageTarget-saveDialog-closeButton"></div>\
		<div class="ve-init-mw-viewPageTarget-saveDialog-title"></div>\
	</div>\
	<div class="ve-init-mw-viewPageTarget-saveDialog-body">\
		<div class="ve-init-mw-viewPageTarget-saveDialog-slide ve-init-mw-viewPageTarget-saveDialog-slide-save">\
			<label class="ve-init-mw-viewPageTarget-saveDialog-editSummary-label"\
				for="ve-init-mw-viewPageTarget-saveDialog-editSummary"\
				id="ve-init-mw-viewPageTarget-saveDialog-editSummary-label"></label>\
			<div class="ve-init-mw-viewPageTarget-saveDialog-summary">\
				<textarea name="editSummary" class="ve-init-mw-viewPageTarget-saveDialog-editSummary"\
					id="ve-init-mw-viewPageTarget-saveDialog-editSummary" type="text"\
					rows="4"></textarea>\
			</div>\
			<div class="ve-init-mw-viewPageTarget-saveDialog-options">\
				<div class="ve-init-mw-viewPageTarget-saveDialog-checkboxes">\
				</div>\
				<label class="ve-init-mw-viewPageTarget-saveDialog-editSummaryCount"></label>\
			</div>\
			<div class="ve-init-mw-viewPageTarget-saveDialog-messages"></div>\
			<div class="ve-init-mw-viewPageTarget-saveDialog-actions">\
				<div class="ve-init-mw-viewPageTarget-saveDialog-dirtymsg"></div>\
				<div class="ve-init-mw-viewPageTarget-saveDialog-working"></div>\
			</div>\
			<div style="clear: both;"></div>\
			<div class="ve-init-mw-viewPageTarget-saveDialog-foot">\
				<p class="ve-init-mw-viewPageTarget-saveDialog-license"></p>\
			</div>\
		</div>\
		<div class="ve-init-mw-viewPageTarget-saveDialog-slide ve-init-mw-viewPageTarget-saveDialog-slide-review">\
			<div class="ve-init-mw-viewPageTarget-saveDialog-viewer"></div>\
			<div class="ve-init-mw-viewPageTarget-saveDialog-actions">\
				<div class="ve-init-mw-viewPageTarget-saveDialog-working"></div>\
			</div>\
			<div style="clear: both;"></div>\
		</div>\
		<div class="ve-init-mw-viewPageTarget-saveDialog-slide ve-init-mw-viewPageTarget-saveDialog-slide-conflict">\
			<div class="ve-init-mw-viewPageTarget-saveDialog-conflict">\
			</div>\
			<div class="ve-init-mw-viewPageTarget-saveDialog-actions">\
				<div class="ve-init-mw-viewPageTarget-saveDialog-working"></div>\
			</div>\
			<div style="clear: both;"></div>\
		</div>\
		<div class="ve-init-mw-viewPageTarget-saveDialog-slide ve-init-mw-viewPageTarget-saveDialog-slide-nochanges">\
			<div class="ve-init-mw-viewPageTarget-saveDialog-nochanges">\
			</div>\
		</div>\
	</div>';

/* Methods */

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

			if ( this.toolbarCancelButton ) {
				// If deactivate is called before a successful load, then
				// setupToolbarButtons has not been called yet and as such tearDownToolbarButtons
				// would throw an error when trying call methods on the button property (bug 46456)
				this.tearDownToolbarButtons();
				this.detachToolbarButtons();
			}

			this.resetSaveDialog();
			this.hideSaveDialog();
			this.detachSaveDialog();
			// Check we got as far as setting up the surface
			if ( this.active ) {
				this.tearDownSurface();
			} else {
				this.showPageContent();
			}
			// If there is a load in progress, abort it
			if ( this.loading ) {
				this.loading.abort();
			}
			this.showTableOfContents();
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
		ve.track( 'Edit', { action: 'page-edit-impression' } );
		this.edited = false;
		this.doc = doc;
		this.setUpSurface( doc, ve.bind( function() {
			this.startSanityCheck();
			this.setupToolbarEditNotices();
			this.setupToolbarBetaNotice();
			this.setupToolbarButtons();
			this.setupSaveDialog();
			this.attachToolbarButtons();
			this.attachSaveDialog();
			this.restoreScrollPosition();
			this.restoreEditSection();
			this.setupBeforeUnloadHandler();
			this.$document[0].focus();
			this.activating = false;
			if ( mw.config.get( 'wgVisualEditorConfig' ).showBetaWelcome ) {
				this.showBetaWelcome();
			}
			mw.hook( 've.activationComplete' ).fire();
		}, this ) );
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
	ve.track( 'Edit', {
		action: 'page-save-success',
		latency: this.saveStart ? ve.now() - this.saveStart : 0
	} );
	delete this.saveStart;

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
			var watchChecked = this.$saveDialog
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

		this.hideSaveDialog();
		this.resetSaveDialog();
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
		viewPage = this;

	this.saveDialogSaveButton.setDisabled( false );
	this.$saveDialogLoadingIcon.hide();

	this.clearMessage( 'api-save-error' );

	// Handle empty response
	if ( !data ) {
		this.showMessage(
			'api-save-error',
			ve.msg( 'visualeditor-saveerror', 'Empty server response' ),
			{
				wrap: 'error'
			}
		);
		this.saveDialogSaveButton.setDisabled( true );
		return;
	}

	editApi = data && data.visualeditoredit && data.visualeditoredit.edit;

	// Handle spam blacklist error (either from core or from Extension:SpamBlacklist)
	if ( editApi && editApi.spamblacklist ) {
		this.showMessage(
			'api-save-error',
			// TODO: Use mediawiki.language equivalant of Language.php::listToText once it exists
			ve.msg( 'spamprotectiontext' ) + ' ' + ve.msg( 'spamprotectionmatch', editApi.spamblacklist.split( '|' ).join( ', ' ) ),
			{
				wrap: 'error'
			}
		);
		this.saveDialogSaveButton.setDisabled( true );
		return;
	}

	// Handle warnings/errors from Extension:AbuseFilter
	// TODO: Move this to a plugin
	if ( editApi && editApi.info && editApi.info.indexOf( 'Hit AbuseFilter:' ) === 0 && editApi.warning ) {
		this.showMessage(
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
		viewPage.saveDialogSaveButton.setDisabled( true );
		viewPage.$saveDialogLoadingIcon.show();
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
				viewPage.$saveDialogLoadingIcon.hide();
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
						viewPage.saveDocument();
					} else {
						// The now current session is a different user
						viewPage.saveDialogSaveButton.setDisabled( false );

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

							viewPage.showMessage(
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

							viewPage.showMessage(
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
		this.captcha = {
			input: new ve.ui.TextInputWidget(),
			id: editApi.captcha.id
		};
		this.showMessage(
			'api-save-error',
			$( '<div>').append(
				// msg: simplecaptcha-edit, fancycaptcha-edit, ..
				$( '<p>' ).append(
					$( '<strong>' ).text( mw.msg( 'captcha-label' ) ),
					document.createTextNode( mw.msg( 'colon-separator' ) ),
					$( $.parseHTML( mw.message( 'fancycaptcha-edit' ).parse() ) )
						.filter( 'a' ).attr( 'target', '_blank ' ).end()
				),
				$( '<img>' ).attr( 'src', editApi.captcha.url ),
				this.captcha.input.$
			),
			{
				wrap: false
			}
		);
		return;
	}

	// Handle (other) unknown and/or unrecoverable errors
	this.showMessage(
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
	this.saveDialogSaveButton.setDisabled( true );
};

/**
 * Handle Show changes event.
 *
 * @method
 * @param {string} diffHtml
 */
ve.init.mw.ViewPageTarget.prototype.onShowChanges = function ( diffHtml ) {
	// Invalidate the viewer diff on next change
	this.surface.getModel().connect( this, { 'transact': 'onSurfaceModelTransact' } );

	mw.loader.using( 'mediawiki.action.history.diff', ve.bind( function () {
		this.$saveDialog
			.find( '.ve-init-mw-viewPageTarget-saveDialog-viewer' )
				.empty().append( diffHtml );

		this.$saveDialogLoadingIcon.hide();
		this.saveDialogReviewGoodButton.setDisabled( false );

	}, this ), ve.bind( function () {
		this.onSaveError( null, 'Module load failed' );
	}, this ) );
};

/**
 * Handle Serialize event.
 *
 * @method
 * @param {string} wikitext
 */
ve.init.mw.ViewPageTarget.prototype.onSerialize = function ( wikitext ) {
	// Invalidate the viewer wikitext on next change
	this.surface.getModel().connect( this, { 'transact': 'onSurfaceModelTransact' } );

	this.$saveDialog
		.find( '.ve-init-mw-viewPageTarget-saveDialog-viewer' )
			.empty().append( $( '<pre>' ).text( wikitext ) );

		this.$saveDialogLoadingIcon.hide();
		this.saveDialogReviewGoodButton.setDisabled( false );
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
	this.$saveDialogLoadingIcon.hide();
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
	this.$saveDialogLoadingIcon.hide();
};

/**
 * Handle edit conflict event.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onEditConflict = function () {
	this.$saveDialogLoadingIcon.hide();
	this.swapSaveDialog( 'conflict' );
};

/**
 * Handle failed show changes event.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onNoChanges = function () {
	this.$saveDialogLoadingIcon.hide();
	this.swapSaveDialog( 'nochanges' );
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
	ve.track( 'Edit', { action: 'page-save-attempt' } );
	if ( this.edited || this.restoring ) {
		this.showSaveDialog();
	}
};

/**
 * Handle clicks on the save button in the toolbar.
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
ve.init.mw.ViewPageTarget.prototype.onToolbarMwMetaButtonClick = function () {
	this.surface.getDialogs().open( 'meta' );
};


/**
 * Handle clicks on the edit notices tool in the toolbar.
 *
 * @method
 * @param {jQuery.Event} e Mouse click event
 */
ve.init.mw.ViewPageTarget.prototype.onToolbarEditNoticesToolClick = function () {
	this.$toolbarEditNotices.fadeToggle( 'fast' );
	this.$toolbarBetaNotice.fadeOut( 'fast' );
	this.$document[0].focus();
};

/**
 * Handle clicks on the beta notices tool in the toolbar.
 *
 * @method
 * @param {jQuery.Event} e Mouse click event
 */
ve.init.mw.ViewPageTarget.prototype.onToolbarBetaNoticeToolClick = function () {
	this.$toolbarBetaNotice.fadeToggle( 'fast' );
	this.$toolbarEditNotices.fadeOut( 'fast' );
	this.$document[0].focus();
};

/**
 * Handle clicks on the feedback tool in the toolbar.
 *
 * @method
 * @param {jQuery.Event} e Mouse click event
 */
ve.init.mw.ViewPageTarget.prototype.onToolbarFeedbackToolClick = function () {
	this.$toolbarEditNotices.fadeOut( 'fast' );
	if ( !this.feedback ) {
		// This can't be constructed until the editor has loaded as it uses special messages
		this.feedback = new mw.Feedback( {
			'title': new mw.Title( ve.msg( 'visualeditor-feedback-link' ) ),
			'bugsLink': new mw.Uri( 'https://bugzilla.wikimedia.org/enter_bug.cgi?product=VisualEditor&component=General' ),
			'bugsListLink': new mw.Uri( 'https://bugzilla.wikimedia.org/buglist.cgi?query_format=advanced&resolution=---&resolution=LATER&resolution=DUPLICATE&product=VisualEditor&list_id=166234' )
		} );
	}
	this.feedback.launch();
};

/**
 * Handle the first transaction in the surface model.
 *
 * This handler is removed the first time it's used, but added each time the surface is set up.
 *
 * @method
 * @param {ve.dm.Transaction} tx Processed transaction
 */
ve.init.mw.ViewPageTarget.prototype.onSurfaceModelTransact = function () {
	// Clear the diff
	this.$saveDialog
		.find( '.ve-init-mw-viewPageTarget-saveDialog-slide-review .ve-init-mw-viewPageTarget-saveDialog-viewer' )
			.empty();

	this.surface.getModel().disconnect( this, { 'transact': 'onSurfaceModelTransact' } );
};

/**
 * Handle changes to the surface model.
 *
 * This is used to trigger notifications when the user starts entering wikitext
 *
 * @param {ve.dm.Transaction} tx
 * @param {ve.Range} range
 */
ve.init.mw.ViewPageTarget.prototype.onSurfaceModelChange = function ( tx, range ) {
	if ( !range ) {
		return;
	}
	var text, doc = this.surface.getView().getDocument(),
		node = doc.getNodeFromOffset( range.start );
	if ( !( node instanceof ve.ce.ContentBranchNode ) ) {
		return;
	}
	text = ve.ce.getDomText( node.$[0] );

	if ( text.match( /\[\[|\{\{|''|<nowiki|~~~|^==|^\*|^\#/ ) ) {
		$.showModal(
			ve.msg( 'visualeditor-wikitext-warning-title' ),
			$( $.parseHTML( ve.init.platform.getParsedMessage( 'visualeditor-wikitext-warning' ) ) )
				.filter( 'a' ).attr( 'target', '_blank ' ).end()
		);
		this.surface.getModel().disconnect( this, { 'change': 'onSurfaceModelChange' } );
	}
};

/**
 * Re-evaluate whether the toolbar save button should be disabled or not.
 */
ve.init.mw.ViewPageTarget.prototype.updateToolbarSaveButtonState = function () {
	this.edited = this.surface.getModel().hasPastState();
	// Disable the save button if we have no history or if the sanity check is not finished
	this.toolbarSaveButton.setDisabled( ( !this.edited && !this.restoring ) || !this.sanityCheckFinished );
	this.toolbarSaveButton.$.toggleClass( 've-init-mw-viewPageTarget-waiting', !this.sanityCheckFinished );
};

/**
 * Handle clicks on the review button in the save dialog.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onSaveDialogReviewButtonClick = function () {
	this.swapSaveDialog( 'review' );
};

/**
 * Handle clicks on the save button in the save dialog.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onSaveDialogSaveButtonClick = function () {
	this.saveDocument();
};

/**
 * Try to save the current document.
 */
ve.init.mw.ViewPageTarget.prototype.saveDocument = function () {
	var doc = this.surface.getModel().getDocument(),
		saveOptions = this.getSaveOptions();

	// Once we've retrieved the save options,
	// reset save start and any old captcha data
	this.saveStart = ve.now();
	if ( this.captcha ) {
		this.clearMessage( 'captcha' );
		delete this.captcha;
	}

	if (
		+mw.user.options.get( 'forceeditsummary' ) &&
		saveOptions.summary === '' &&
		!this.messages.missingsummary
	) {
		this.showMessage(
			'missingsummary',
			// Wrap manually since this core message already includes a bold "Warning:" label
			$( '<p>' ).append( ve.init.platform.getParsedMessage( 'missingsummary' ) ),
			{ wrap: false }
		);
	} else {
		this.saveDialogSaveButton.setDisabled( true );
		this.$saveDialogLoadingIcon.show();
		this.save(
			ve.dm.converter.getDomFromData( doc.getFullData(), doc.getStore(), doc.getInternalList() ),
			saveOptions
		);
	}
};

/**
 * Handle clicks on the review "Good" button in the save dialog.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onSaveDialogReviewGoodButtonClick = function () {
	this.swapSaveDialog( 'save' );
};

/**
 * Handle clicks on the resolve conflict button in the conflict dialog.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onSaveDialogResolveConflictButtonClick = function () {
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
		'summary': this.$saveDialog.find( '#ve-init-mw-viewPageTarget-saveDialog-editSummary' ).val(),
		'captchaid': this.captcha && this.captcha.id,
		'captchaword': this.captcha && this.captcha.input.getValue()
	};
	if ( this.sanityCheckPromise.state() === 'rejected' ) {
		options.needcheck = 1;
	}
	if ( this.$saveDialog.find( '#wpMinoredit' ).prop( 'checked' ) ) {
		options.minor = 1;
	}
	if ( this.$saveDialog.find( '#wpWatchthis' ).prop( 'checked' ) ) {
		options.watch = 1;
	}
	this.$saveDialog
		.find( '.ve-init-mw-viewPageTarget-saveDialog-checkboxes' )
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
 * Handle clicks on the close button in the save dialog.
 *
 * @method
 * @param {jQuery.Event} e Mouse click event
 */
ve.init.mw.ViewPageTarget.prototype.onSaveDialogCloseButtonClick = function () {
	this.hideSaveDialog();
};

/**
 * Handle clicks on the previous view button in the save dialog.
 *
 * @method
 * @param {jQuery.Event} e Mouse click event
 */
ve.init.mw.ViewPageTarget.prototype.onSaveDialogPrevButtonClick = function () {
	var history = this.saveDialogSlideHistory;
	if ( history.length < 2  ) {
		throw new Error( 'PrevButton was triggered without a history' );
	}
	// Pop off current slide
	history.pop();
	// Navigate to last slide
	this.swapSaveDialog( history[ history.length -1 ], { fromHistory: true } );
};

/**
 * Set up the list of edit notices.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.setupToolbarEditNotices = function () {
	var key;
	this.$toolbarEditNotices.empty();
	for ( key in this.editNotices ) {
		this.$toolbarEditNotices.append( this.editNotices[key] );
	}
	this.$toolbarEditNotices.find( 'a' ).attr( 'target', '_blank' );
};

/**
 * Set up the beta notices panel.
 *
 * @method
 * @returns {string[]} HTML strings for each edit notice
 */
ve.init.mw.ViewPageTarget.prototype.setupToolbarBetaNotice = function () {
	this.$toolbarBetaNotice.empty();
	this.$toolbarBetaNotice
		.append( $( '<span>' )
			.text( ve.msg( 'visualeditor-beta-warning' ) )
		)
		.append( $( '<div>' )
			.addClass( 've-init-mw-viewPageTarget-tool' )
			.append( $( '<span>' )
				.addClass( 've-init-mw-viewPageTarget-subtool-label' )
				.append( $( '<a>' )
					.attr( 'title', ve.msg( 'visualeditor-help-title' ) )
					.attr( 'target', '_blank' )
					.attr( 'href', new mw.Title( ve.msg( 'visualeditor-help-link' ) ).getUrl() )
					.text( ve.msg( 'visualeditor-help-label' ) )
		) ) );
	if ( ve.version.id !== false ) {
		this.$toolbarBetaNotice
			.append( $( '<div>' )
				.append( $( '<span>' )
					.addClass( 've-init-mw-ViewPageTarget-version-label' )
					.text( ve.msg( 'visualeditor-version-label' ) )
				)
				.append( ' ' )
				.append( $( '<a>' )
					.addClass( 've-init-mw-ViewPageTarget-version-link' )
					.attr( 'target', '_blank' )
					.attr( 'href', ve.version.url )
					.text( ve.version.id )
				)
				.append( ' ' )
				.append( $( '<span>' )
					.addClass( 've-init-mw-ViewPageTarget-version-date' )
					.text( ve.version.dateString )
				)
			);
	}
};

/**
 * Switch to editing mode.
 *
 * @method
 * @param {HTMLDocument} doc HTML DOM to edit
 * @param {Function} [callback] Callback to call when done
 */
ve.init.mw.ViewPageTarget.prototype.setUpSurface = function ( doc, callback ) {
	var target = this;
	setTimeout( function () {
		// Build linmod
		var store = new ve.dm.IndexValueStore(),
			internalList = new ve.dm.InternalList(),
			data = ve.dm.converter.getDataFromDom( doc, store, internalList );
		setTimeout( function () {
			// Build DM tree
			var dmDoc = new ve.dm.Document( data, undefined, internalList );
			setTimeout( function () {
				// Create ui.Surface (also creates ce.Surface and dm.Surface and builds CE tree)
				target.surface = new ve.ui.Surface( dmDoc, target.surfaceOptions );
				target.surface.$.addClass( 've-init-mw-viewPageTarget-surface' );
				setTimeout( function () {
					// Initialize surface
					target.surface.getContext().hide();
					target.$document = target.surface.$.find( '.ve-ce-documentNode' );
					target.surface.getModel().connect( target, {
						'transact': 'onSurfaceModelTransact',
						'change': 'onSurfaceModelChange',
						'history': 'updateToolbarSaveButtonState'
					} );
					target.$.append( target.surface.$ );
					target.setUpToolbar();
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
					target.surface.view.$.addClass(
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
		data = new ve.dm.ElementLinearData( doc.getStore().clone(), ve.copy( doc.getFullData() ) ),
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
			newDoc = new ve.dm.Document( data, undefined, doc.getInternalList() ),
			newDom = ve.dm.converter.getDomFromData( newDoc.getFullData(), newDoc.getStore(), newDoc.getInternalList() );

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
 * @see ve.ui.SurfaceToolbar#position
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
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.tearDownSurface = function () {
	// Update UI
	if ( this.$document ) {
		this.$document.blur();
		this.$document = null;
	}
	this.tearDownToolbar();
	this.hideSpinner();
	this.showPageContent();
	this.restorePageTitle();
	this.restoreDocumentTitle();
	this.showTableOfContents();
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
	var editNoticeCount = ve.getObjectKeys( this.editNotices ).length;

	this.toolbarCancelButton = new ve.ui.ButtonWidget( { 'label': ve.msg( 'visualeditor-toolbar-cancel' ) } );
	this.toolbarCancelButton.$.addClass( 've-ui-toolbar-cancelButton' );
	this.toolbarSaveButton = new ve.ui.ButtonWidget( {
		'label': ve.msg( 'visualeditor-toolbar-savedialog' ),
		'flags': ['constructive'],
		'disabled': !this.restoring
	} );
	// TODO (mattflaschen, 2013-06-27): it would be useful to do this in a more general way, such
	// as in the ButtonWidget constructor.
	this.toolbarSaveButton.$.addClass( 've-ui-toolbar-saveButton' );
	this.updateToolbarSaveButtonState();

	this.toolbarCancelButton.connect( this, { 'click': 'onToolbarCancelButtonClick' } );
	this.toolbarSaveButton.connect( this, { 'click': 'onToolbarSaveButtonClick' } );

	this.$toolbarMwMetaButton
		.addClass( 've-ui-icon-settings' )
		.append(
			$( '<span>' )
				.addClass( 've-init-mw-viewPageTarget-tool-label' )
				.text( ve.msg( 'visualeditor-meta-tool' ) )
		)
		.click( ve.bind( this.onToolbarMwMetaButtonClick, this ) );


	if ( editNoticeCount ) {
		this.$toolbarEditNoticesTool
			.addClass( 've-ui-icon-alert' )
			.append(
				$( '<span>' )
					.addClass( 've-init-mw-viewPageTarget-tool-label' )
					.text( ve.msg( 'visualeditor-editnotices-tool', editNoticeCount ) )
			)
			.append( this.$toolbarEditNotices )
			.click( ve.bind( this.onToolbarEditNoticesToolClick, this ) );
		this.$toolbarEditNotices.fadeIn( 'fast' );
	}

	this.$toolbarBetaNoticeTool
		.addClass( 've-ui-icon-help' )
		.append(
			$( '<span>' )
				.addClass( 've-init-mw-viewPageTarget-tool-label ve-init-mw-viewPageTarget-tool-beta-label' )
				.text( ve.msg( 'visualeditor-beta-label' ) )
		)
		.append( this.$toolbarBetaNotice )
		.click( ve.bind( this.onToolbarBetaNoticeToolClick, this ) );

	this.$toolbarFeedbackTool
		.addClass( 've-ui-icon-comment' )
		.append(
			$( '<span>' )
				.addClass( 've-init-mw-viewPageTarget-tool-label' )
				.text( ve.msg( 'visualeditor-feedback-tool' ) )
		)
		.click( ve.bind( this.onToolbarFeedbackToolClick, this ) );
};

/**
 * Remove content and event bindings from toolbar buttons.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.tearDownToolbarButtons = function () {
	this.toolbarCancelButton.disconnect( this );
	this.toolbarSaveButton.disconnect( this );
	this.$toolbarMwMetaButton.empty().off( 'click' );
	this.$toolbarEditNoticesTool.empty().off( 'click' );
	this.$toolbarBetaNoticeTool.empty().off( 'click' );
	this.$toolbarFeedbackTool.empty().off( 'click' );
};

/**
 * Add the save button to the user interface.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.attachToolbarButtons = function () {
	var $target = this.toolbar.$actions;
	$target.append( this.$toolbarBetaNoticeTool );
	this.$toolbarBetaNotice.append( this.$toolbarFeedbackTool );

	if ( !ve.isEmptyObject( this.editNotices ) ) {
		$target.append( this.$toolbarEditNoticesTool );
	}
	$target.append(
		this.$toolbarMwMetaButton,
		this.toolbarCancelButton.$,
		this.toolbarSaveButton.$
	);
};

/**
 * Remove the save button from the user interface.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.detachToolbarButtons = function () {
	this.toolbarCancelButton.$.detach();
	this.toolbarSaveButton.$.detach();
	this.$toolbarMwMetaButton.detach();
	this.$toolbarEditNoticesTool.detach();
	this.$toolbarFeedbackTool.detach();
	this.$toolbarBetaNoticeTool.detach();
};

/**
 * Add content and event bindings to the save dialog.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.setupSaveDialog = function () {
	var sectionTitle = '', viewPage = this;

	// Save button on "save" slide
	this.saveDialogSaveButton = new ve.ui.ButtonWidget( {
		'label': ve.msg(
			 // visualeditor-savedialog-label-restore, visualeditor-savedialog-label-save
			'visualeditor-savedialog-label-' + ( viewPage.restoring ? 'restore' : 'save' )
		),
		'flags': ['constructive']
	} );
	this.saveDialogSaveButton.connect( this, { 'click': 'onSaveDialogSaveButtonClick' } );

	// Review button on "save" slide
	this.saveDialogReviewButton = new ve.ui.ButtonWidget( {
		'label': ve.msg(
			'visualeditor-savedialog-label-review'
		)
	} );
	this.saveDialogReviewButton.connect( this, { 'click': 'onSaveDialogReviewButtonClick' } );

	this.saveDialogReviewGoodButton = new ve.ui.ButtonWidget( {
		'label': ve.msg( 'visualeditor-savedialog-label-review-good' ),
		'flags': ['constructive']
	} );
	this.saveDialogReviewGoodButton.connect(
		this, { 'click': 'onSaveDialogReviewGoodButtonClick' }
	);

	this.saveDialogResolveConflictButton = new ve.ui.ButtonWidget( {
		'label': ve.msg( 'visualeditor-savedialog-label-resolve-conflict' ),
		'flags': ['constructive']
	} );
	this.saveDialogResolveConflictButton.connect( this, { 'click': 'onSaveDialogResolveConflictButtonClick' } );


	if ( viewPage.section ) {
		sectionTitle = viewPage.$document.find( 'h1, h2, h3, h4, h5, h6' ).eq( viewPage.section - 1 ).text();
		sectionTitle = '/* ' + ve.graphemeSafeSubstring( sectionTitle, 0, 244 ) + ' */ ';
		viewPage.sectionTitleRestored = true;
		if ( viewPage.sectionPositionRestored ) {
			viewPage.onSectionRestored();
		}
	}
	viewPage.$saveDialog
		// Must not use replaceWith because that can't be used on fragement roots,
		// plus, we want to preserve the reference and class names of the wrapper.
		.empty().append( this.constructor.static.saveDialogTemplate )
		// Attach buttons
		.find( '.ve-init-mw-viewPageTarget-saveDialog-slide-save' )
			.find( '.ve-init-mw-viewPageTarget-saveDialog-actions' )
				.prepend( viewPage.saveDialogSaveButton.$, viewPage.saveDialogReviewButton.$ )
				.end()
		.end()
		.find( '.ve-init-mw-viewPageTarget-saveDialog-slide-review' )
			.find( '.ve-init-mw-viewPageTarget-saveDialog-actions' )
				.prepend( viewPage.saveDialogReviewGoodButton.$ )
				.end()
		.end()
		.find( '.ve-init-mw-viewPageTarget-saveDialog-slide-conflict' )
			.find( '.ve-init-mw-viewPageTarget-saveDialog-actions' )
				.prepend( viewPage.saveDialogResolveConflictButton.$ )
				.end()
		.end()
		.find( '.ve-init-mw-viewPageTarget-saveDialog-closeButton' )
			.click( ve.bind( viewPage.onSaveDialogCloseButtonClick, viewPage ) )
			.end()
		.find( '.ve-init-mw-viewPageTarget-saveDialog-prevButton' )
			.click( ve.bind( viewPage.onSaveDialogPrevButtonClick, viewPage ) )
			.end()
		// Attach contents
		.find( '#ve-init-mw-viewPageTarget-saveDialog-editSummary-label' )
			.html( ve.init.platform.getParsedMessage( 'summary' ) )
			.end()
		.find( '#ve-init-mw-viewPageTarget-saveDialog-editSummary' )
			.attr( {
				'placeholder': ve.msg( 'visualeditor-editsummary' )
			} )
			.val( sectionTitle )
			.placeholder()
			.byteLimit( viewPage.editSummaryByteLimit )
			.on( {
				'focus': function () {
					$( this ).parent().addClass(
						've-init-mw-viewPageTarget-saveDialog-summary-focused'
					);
				},
				'blur': function () {
					$( this ).parent().removeClass(
						've-init-mw-viewPageTarget-saveDialog-summary-focused'
					);
				},
				'keyup keydown mouseup cut paste change focus blur': function () {
					var $textarea = $( this ),
						$editSummaryCount = $textarea
							.closest( '.ve-init-mw-viewPageTarget-saveDialog-slide-save' )
								.find( '.ve-init-mw-viewPageTarget-saveDialog-editSummaryCount' );
					// TODO: This looks a bit weird, there is no unit in the UI, just numbers
					// Users likely assume characters but then it seems to count down quicker
					// than expected. Facing users with the word "byte" is bad? (bug 40035)
					setTimeout( function () {
						$editSummaryCount.text(
							viewPage.editSummaryByteLimit - $.byteLength( $textarea.val() )
						);
					} );
				}
			} )
			.end()
		.find( '.ve-init-mw-viewPageTarget-saveDialog-editSummaryCount' )
			.text( viewPage.editSummaryByteLimit )
			.end()
		.find( '.ve-init-mw-viewPageTarget-saveDialog-checkboxes' )
			.html( ve.getObjectValues( viewPage.checkboxes ).join( '\n' ) )
			.find( 'a' )
				.attr( 'target', '_blank' )
				.end()
			.find( '#wpMinoredit' )
				.prop( 'checked', +mw.user.options.get( 'minordefault' ) )
				.end()
			.find( '#wpWatchthis' )
				.prop( 'checked',
					mw.user.options.get( 'watchdefault' ) ||
					( mw.user.options.get( 'watchcreations' ) && !viewPage.pageExists ) ||
					mw.config.get( 'wgVisualEditor' ).isPageWatched
				)
				.end()
			.end()
		.find( '.ve-init-mw-viewPageTarget-saveDialog-license' )
			.html( ve.init.platform.getParsedMessage( 'copyrightwarning' ) )
			.end()
		.find( '.ve-init-mw-viewPageTarget-saveDialog-conflict' )
			.html( ve.init.platform.getParsedMessage( 'visualeditor-editconflict' ) )
			.end()
		.find( '.ve-init-mw-viewPageTarget-saveDialog-nochanges' )
			.html( ve.init.platform.getParsedMessage( 'visualeditor-diff-nochanges' ) )
	;

	// Get reference to loading icon
	viewPage.$saveDialogLoadingIcon = viewPage.$saveDialog
		.find( '.ve-init-mw-viewPageTarget-saveDialog-working' );

	// Hook onto the 'watch' event on by mediawiki.page.watch.ajax.js
	// Triggered when mw.page.watch.updateWatchLink(link, action) is called
	$( '#ca-watch, #ca-unwatch' )
		.on(
			'watchpage.mw',
			function ( e, action ) {
				viewPage.$saveDialog
					.find( '#wpWatchthis' )
					.prop( 'checked', ( action === 'watch' ) );
			}
		);
};

/**
 * Show the save dialog.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.showSaveDialog = function () {
	var viewPage = this;

	viewPage.surface.disable();
	viewPage.$document.css( 'opacity', 0.5 );

	viewPage.$toolbarBetaNotice.fadeOut( 'fast' );
	viewPage.$toolbarEditNotices.fadeOut( 'fast' );

	viewPage.swapSaveDialog( 'save' );

	viewPage.$saveDialog.fadeIn( 'fast', function () {
		// Initial size
		viewPage.onResizeSaveDialog();
	} );

	$( document ).on( 'keydown.ve-savedialog', function ( e ) {
		// Escape
		if ( e.which === ve.Keys.ESCAPE ) {
			viewPage.onSaveDialogCloseButtonClick();
		}
	} );

	$( window ).on( 'resize.ve-savedialog', ve.bind( viewPage.onResizeSaveDialog, viewPage ) );
};

/**
 * Update window-size related aspects of the save dialog
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onResizeSaveDialog = function () {
	var $d = this.$saveDialog, $w = $( window );

	// Available space for css-height is window height,
	// without the space between the dialog and the window top,
	// without the space above/below between css-height and outerHeight.
	$d.css( 'max-height',
		$w.height() -
			( $d.offset().top - $w.scrollTop() ) -
			( $d.outerHeight( true ) - $d.height() ) -
			20 // shadow
	);
};

/**
 * Hide the save dialog
 */
ve.init.mw.ViewPageTarget.prototype.hideSaveDialog = function () {
	// Reset history on close (bug 49481)
	this.saveDialogSlideHistory.length = 0;
	this.$saveDialog.fadeOut( 'fast' );
	if ( this.$document ) {
		this.$document.focus();
	}
	$( document ).off( 'keydown.ve-savedialog' );
	$( window ).off( 'resize', this.onResizeSaveDialog );

	if ( this.surface ) {
		this.surface.enable();
		this.$document.css( 'opacity', '' );
	}
};

/**
 * Reset the fields of the save dialog.
 *
 * TODO: Maybe call this more cleverly only when the document changes, so that closing and
 * re-opening the saveDialog doesn't remove the user input and the diff cache.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.resetSaveDialog = function () {
	this.$saveDialog
		.find( '#ve-init-mw-viewPageTarget-saveDialog-editSummary' )
			.val( '' )
			.end()
		.find( '#wpMinoredit' )
			.prop( 'checked', false )
			.end()
		// Clear the diff
		.find( '.ve-init-mw-viewPageTarget-saveDialog-viewer' )
			.empty();
};

/**
 * Swap state in the save dialog.
 *
 * @method
 * @param {string} slide One of 'save', 'review', 'conflict' or 'nochanges'
 * @param {Object} [options]
 * @param {boolean} [options.fromHistory] Whether this swap was triggered from interaction
 *  with the slide history (e.g. surpresses pushing of target slide in the history again).
 * @returns {jQuery} The now active slide.
 * @throws {Error} Unknown saveDialog slide
 */
ve.init.mw.ViewPageTarget.prototype.swapSaveDialog = function ( slide, options ) {
	var $slide, $viewer,
		doc = this.surface.getModel().getDocument();

	if ( ve.indexOf( slide, [ 'save', 'review', 'conflict', 'nochanges' ] ) === -1 ) {
		throw new Error( 'Unknown saveDialog slide: ' + slide );
	}

	options = options || {};

	if ( !options.fromHistory ) {
		this.saveDialogSlideHistory.push( slide );
	}

	$slide = this.$saveDialog.find( '.ve-init-mw-viewPageTarget-saveDialog-slide-' + slide );

	this.$saveDialog
		// Hide "prev" button when (back) on the first slide
		.find( '.ve-init-mw-viewPageTarget-saveDialog-prevButton' )
			.toggle( this.saveDialogSlideHistory.length >= 2 )
			.end()
		// Update title to one of:
		// - visualeditor-savedialog-title-save
		// - visualeditor-savedialog-title-review
		// - visualeditor-savedialog-title-conflict
		// - visualeditor-savedialog-title-nochanges
		.find( '.ve-init-mw-viewPageTarget-saveDialog-title' )
			.text( ve.msg( 'visualeditor-savedialog-title-' + slide ) )
			.end()
		// Hide other slides
		.find( '.ve-init-mw-viewPageTarget-saveDialog-slide' )
			.not( $slide )
				.hide();

	// Old messages should not persist after slide changes
	this.clearAllMessages();
	// Reset save button if we disabled it for e.g. unrecoverable spam error
	this.saveDialogSaveButton.setDisabled( false );

	if ( slide === 'save' ) {
		if ( !this.sanityCheckVerified ) {
			this.showMessage( 'dirtywarning', mw.msg( 'visualeditor-savedialog-warning-dirty' ) );
		}
	}

	if ( slide === 'review' ) {
		this.sanityCheckVerified = true;
		$viewer = $slide.find( '.ve-init-mw-viewPageTarget-saveDialog-viewer' );
		if ( !$viewer.find( 'table, pre' ).length ) {
			this.saveDialogReviewGoodButton.setDisabled( true );
			this.$saveDialogLoadingIcon.show();
			if ( this.pageExists ) {
				// Has no callback, handled via target.onShowChanges
				this.showChanges(
					ve.dm.converter.getDomFromData( doc.getFullData(), doc.getStore(), doc.getInternalList() )
				);
			} else {
				this.serialize(
					ve.dm.converter.getDomFromData( doc.getFullData(), doc.getStore(), doc.getInternalList() ),
					ve.bind( this.onSerialize, this )
				);
			}
		}
		this.$saveDialog.css( 'width', '100%' );
	} else {
		this.$saveDialog.css( 'width', '' );
	}

	// Show the target slide
	$slide.show();

	mw.hook( 've.saveDialog.stateChanged' ).fire();

	if ( slide === 'save' ) {
		setTimeout( function () {
			var $textarea = $slide.find( '#ve-init-mw-viewPageTarget-saveDialog-editSummary' );
			$textarea.focus();
			// If message has be pre-filled (e.g. section edit), move cursor to end
			if ( $textarea.val() !== '' ) {
				ve.selectEnd( $textarea[0] );
			}
		} );
	}

	return $slide;
};

/**
 * Add the save dialog to the user interface.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.attachSaveDialog = function () {
	this.surface.$globalOverlay.append(
		this.$toolbarTracker.append(
			this.$saveDialog
		)
	);
};

/**
 * Remove the save dialog from the user interface.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.detachSaveDialog = function () {
	this.$saveDialog.detach();
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
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.setUpToolbar = function () {
	this.toolbar = new ve.ui.TargetToolbar( this, this.surface, { 'shadow': true, 'actions': true } );
	this.toolbar.connect( this, { 'position': 'onToolbarPosition' } );
	this.toolbar.setup( this.constructor.static.toolbarGroups );
	this.surface.addCommands( this.constructor.static.surfaceCommands );
	if ( !this.isMobileDevice ) {
		this.toolbar.enableFloatable();
	}
	this.toolbar.$
		.addClass( 've-init-mw-viewPageTarget-toolbar' )
		//.insertBefore( '#firstHeading' );
		.insertAfter( '#WikiaPageHeader' );
	this.toolbar.$bar.slideDown( 'fast', ve.bind( function () {
		// Check the surface wasn't torn down while the toolbar was animating
		if ( this.surface ) {
			this.toolbar.initialize();
			this.surface.emit( 'position' );
			this.surface.getContext().update();
		}
	}, this ) );
};

/**
 * Hide the toolbar.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.tearDownToolbar = function () {
	this.toolbar.$bar.slideUp( 'fast', ve.bind( function () {
		this.toolbar.destroy();
		this.toolbar = null;
	}, this ) );
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
	$( '#firstHeading, #siteSub:visible' ).fadeTo( 'fast', 0.6 );
	$( '#contentSub:visible' ).fadeTo( 'fast', 0 );
};

/**
 * Restore the page title to its original style.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.restorePageTitle = function () {
	$( '#firstHeading, #siteSub:visible, #contentSub:visible' ).fadeTo( 'fast', 1 );
	setTimeout( function () {
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
		var offset,
			target = this,
			surfaceView = this.surface.getView(),
			surfaceModel = surfaceView.getModel();
		this.$document.find( 'h1, h2, h3, h4, h5, h6' ).eq( this.section - 1 ).each( function () {
			var offsetNode, nextNode,
				headingNode = $( this ).data( 'view' ),
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
				surfaceModel.change( null, new ve.Range( offset ) );
				// Scroll to heading:
				// Wait for toolbar to animate in so we can account for its height
				setTimeout( function () {
					var $window = $( ve.Element.getWindow( target.$ ) );
					$window.scrollTop( headingNode.$.offset().top - target.toolbar.$.height() );
				}, 200 );
			}
		} );
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
 * Show a message in the save dialog.
 *
 * @param {string} name Message's unique name
 * @param {string|jQuery|Array} message Message content (string of HTML, jQuery object or array of
 *  Node objects)
 * @param {Object} [options]
 * @param {boolean} [options.wrap="warning"] Whether to wrap the message in a paragraph and if
 *  so, how. One of "warning", "error" or false.
 */
ve.init.mw.ViewPageTarget.prototype.showMessage = function ( name, message, options ) {
	var $message;
	if ( !this.messages[name] ) {
		options = options || {};
		if ( options.wrap === undefined ) {
			options.wrap = 'warning';
		}
		$message = $( '<div class="ve-init-mw-viewPageTarget-saveDialog-message"></div>' );
		if ( options.wrap !== false ) {
			$message.append( $( '<p>').append(
				 // visualeditor-savedialog-label-error
				 // visualeditor-savedialog-label-warning
				$( '<strong>' ).text( mw.msg( 'visualeditor-savedialog-label-' + options.wrap ) ),
				document.createTextNode( mw.msg( 'colon-separator' ) ),
				message
			) );
		} else {
			$message.append( message );
		}
		this.$saveDialog.find( '.ve-init-mw-viewPageTarget-saveDialog-messages' )
			.append( $message );

		this.messages[name] = $message;
	}
};

/**
 * Remove a message from the save dialog.
 * @param {string} name Message's unique name
 */
ve.init.mw.ViewPageTarget.prototype.clearMessage = function ( name ) {
	if ( this.messages[name] ) {
		this.messages[name].remove();
		delete this.messages[name];
	}
};

/**
 * Remove all messages from the save dialog.
 */
ve.init.mw.ViewPageTarget.prototype.clearAllMessages = function () {
	this.$saveDialog
		.find( '.ve-init-mw-viewPageTarget-saveDialog-messages' )
			.empty();
	this.messages = {};
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
		this.surface.getDialogs().open( 'betaWelcome' );
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
