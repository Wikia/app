/*!
 * VisualEditor MediaWiki Initialization DesktopArticleTarget class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global confirm, alert */

/**
 * MediaWiki desktop article target.
 *
 * @class
 * @extends ve.init.mw.Target
 *
 * @constructor
 * @param {Object} config Configuration options
 */
ve.init.mw.DesktopArticleTarget = function VeInitMwDesktopArticleTarget( config ) {
	// A workaround, as default URI does not get updated after pushState (bug 72334)
	var currentUri = new mw.Uri( location.href );

	// Parent constructor
	ve.init.mw.DesktopArticleTarget.super.call(
		this, mw.config.get( 'wgRelevantPageName' ), currentUri.query.oldid, config
	);

	// Parent constructor bound key event handlers, but we don't want them bound until
	// we activate; so unbind them again
	this.unbindHandlers();

	this.onWatchToggleHandler = this.onWatchToggle.bind( this );

	// Properties
	this.onBeforeUnloadFallback = null;
	this.onUnloadHandler = this.onUnload.bind( this );
	this.active = false;
	this.activating = false;
	this.deactivating = false;
	this.edited = false;
	this.recreating = false;
	this.activatingDeferred = null;
	this.toolbarSetupDeferred = null;
	this.welcomeDialog = null;
	this.welcomeDialogPromise = null;
	this.checkboxFields = null;
	this.checkboxesByName = null;
	this.$otherFields = null;

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

	// Initialization
	this.$element.addClass( 've-init-mw-desktopArticleTarget' );

	if ( history.replaceState ) {
		// We replace the current state with one that's marked with our tag. This way, when users
		// use the Back button to exit the editor we can restore Read mode. This is because we want
		// to ignore foreign states in onWindowPopState. Without this, the Read state is foreign.
		// FIXME: There should be a much better solution than this.
		history.replaceState( this.popState, document.title, currentUri );
	}

	this.setupSkinTabs();

	window.addEventListener( 'popstate', this.onWindowPopState.bind( this ) );
};

/* Inheritance */

OO.inheritClass( ve.init.mw.DesktopArticleTarget, ve.init.mw.Target );

/* Events */

/**
 * @event deactivate
 */

/* Static Properties */

/**
 * Compatibility map used with jQuery.client to black-list incompatible browsers.
 *
 * @static
 * @property
 */
ve.init.mw.DesktopArticleTarget.static.compatibility = {
	// The key is the browser name returned by jQuery.client
	// The value is either null (match all versions) or a list of tuples
	// containing an inequality (<,>,<=,>=) and a version number
	whitelist: {
		firefox: [ [ '>=', 15 ] ],
		iceweasel: [ [ '>=', 10 ] ],
		safari: [ [ '>=', 7 ] ],
		chrome: [ [ '>=', 19 ] ],
		opera: [ [ '>=', 15 ] ]
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
ve.init.mw.DesktopArticleTarget.prototype.verifyPopState = function ( popState ) {
	return popState && popState.tag === 'visualeditor';
};

/**
 * @inheritdoc
 */
ve.init.mw.DesktopArticleTarget.prototype.setupToolbar = function ( surface ) {
	var toolbar,
		wasSetup = !!this.toolbar,
		target = this;

	ve.track( 'trace.setupToolbar.enter' );

	// Parent method
	ve.init.mw.DesktopArticleTarget.super.prototype.setupToolbar.call( this, surface );

	toolbar = this.getToolbar();

	ve.track( 'trace.setupToolbar.exit' );
	if ( !wasSetup ) {
		setTimeout( function () {
			var height = toolbar.$bar.outerHeight();
			toolbar.$element.css( 'height', height );
			toolbar.$element.one( 'transitionend', function () {
				// Clear to allow growth during use and when resizing window
				toolbar.$element.css( 'height', '' );
				target.toolbarSetupDeferred.resolve();
			} );
		} );

		this.toolbarSetupDeferred.done( function () {
			var surface = target.getSurface();
			// Check the surface wasn't torn down while the toolbar was animating
			if ( surface ) {
				ve.track( 'trace.initializeToolbar.enter' );
				target.getToolbar().initialize();
				surface.getView().emit( 'position' );
				surface.getContext().updateDimensions();
				ve.track( 'trace.initializeToolbar.exit' );
				ve.track( 'trace.activate.exit' );
			}
		} );
	}
};

/**
 * @inheritdoc
 */
ve.init.mw.DesktopArticleTarget.prototype.attachToolbar = function () {
	// Move the toolbar to top of target, before heading etc.
	// Avoid re-attaching as it breaks CSS animations
	if ( !this.toolbar.$element.parent().is( this.$element ) ) {
		this.toolbar.$element
			// Set 0 before attach (expanded in #setupToolbar)
			.css( 'height', '0' )
			.addClass( 've-init-mw-desktopArticleTarget-toolbar' );
		this.$element.prepend( this.toolbar.$element );
	}
};

/**
 * Set up notices for things like unknown browsers.
 * Needs to be done on each activation because localNoticeMessages is cleared in clearState.
 */
ve.init.mw.DesktopArticleTarget.prototype.setupLocalNoticeMessages = function () {
	if ( mw.config.get( 'wgTranslatePageTranslation' ) === 'source' ) {
		// Warn users if they're on a source of the Page Translation feature
		this.localNoticeMessages.push( 'visualeditor-pagetranslationwarning' );
	}

	if ( !(
		'vewhitelist' in this.currentUri.query ||
		$.client.test( this.constructor.static.compatibility.whitelist, null, true )
	) ) {
		// Show warning in unknown browsers that pass the support test
		// Continue at own risk.
		this.localNoticeMessages.push( 'visualeditor-browserwarning' );
	}
};

/**
 * @inheritdoc
 */
ve.init.mw.DesktopArticleTarget.prototype.loadSuccess = function ( response ) {
	var $checkboxes, defaults, data,
		target = this;

	// Parent method
	ve.init.mw.DesktopArticleTarget.super.prototype.loadSuccess.apply( this, arguments );

	data = response ? response.visualeditor : {};

	this.checkboxFields = [];
	this.checkboxesByName = {};
	this.$otherFields = $( [] );

	if ( data.checkboxes ) {
		defaults = {
			wpMinoredit: !!mw.user.options.get( 'minordefault' ),
			wpWatchthis: !!mw.user.options.get( 'watchdefault' ) ||
				( !!mw.user.options.get( 'watchcreations' ) && !this.pageExists ) ||
				data.watched === ''
		};

		$checkboxes = $( '<div>' ).html( ve.getObjectValues( data.checkboxes ).join( '' ) );
		$checkboxes.find( 'input[type=checkbox]' ).each( function () {
			var $label, title, checkbox,
				$this = $( this ),
				name = $this.attr( 'name' ),
				id = $this.attr( 'id' );

			if ( !name ) {
				// This really shouldn't happen..
				return;
			}

			// Label with for=id
			if ( id ) {
				$label = $checkboxes.find( 'label[for=' + id + ']' );
			}
			// Label wrapped input
			if ( !$label ) {
				$label = $this.closest( 'label' );
			}
			if ( $label ) {
				title = $label.attr( 'title' );
				$label.find( 'a' ).attr( 'target', '_blank' );
			}
			checkbox = new OO.ui.CheckboxInputWidget( {
				value: $this.attr( 'value' ),
				selected: name && defaults[ name ]
			} );
			// HACK: CheckboxInputWidget doesn't support access keys
			checkbox.$input.attr( 'accesskey', $( this ).attr( 'accesskey' ) );
			target.checkboxFields.push(
				new OO.ui.FieldLayout( checkbox, {
					align: 'inline',
					label: $label ? $label.contents() : undefined,
					title: title
				} )
			);
			target.checkboxesByName[ name ] = checkbox;
		} );
		this.$otherFields = $checkboxes.find( 'input[type!=checkbox]' );
	}
};

/**
 * Handle the watch button being toggled on/off.
 *
 * @param {jQuery.Event} e Event object whih triggered the event
 * @param {string} actionPerformed 'watch' or 'unwatch'
 */
ve.init.mw.DesktopArticleTarget.prototype.onWatchToggle = function ( e, actionPerformed ) {
	if ( !this.active && !this.activating ) {
		return;
	}
	if ( this.checkboxesByName.wpWatchthis ) {
		this.checkboxesByName.wpWatchthis.setSelected(
			!!mw.user.options.get( 'watchdefault' ) ||
			( !!mw.user.options.get( 'watchcreations' ) && !this.pageExists ) ||
			actionPerformed === 'watch'
		);
	}
};

/**
 * @inheritdoc
 */
ve.init.mw.DesktopArticleTarget.prototype.bindHandlers = function () {
	ve.init.mw.DesktopArticleTarget.super.prototype.bindHandlers.call( this );
	if ( this.onWatchToggleHandler ) {
		$( '#ca-watch, #ca-unwatch' ).on( 'watchpage.mw', this.onWatchToggleHandler );
	}
};

/**
 * @inheritdoc
 */
ve.init.mw.DesktopArticleTarget.prototype.unbindHandlers = function () {
	ve.init.mw.DesktopArticleTarget.super.prototype.unbindHandlers.call( this );
	if ( this.onWatchToggleHandler ) {
		$( '#ca-watch, #ca-unwatch' ).off( 'watchpage.mw', this.onWatchToggleHandler );
	}
};

/**
 * Switch to edit mode.
 *
 * @param {jQuery.Promise} [dataPromise] Promise for pending request from
 *   mw.libs.ve.targetLoader#requestPageData, if any
 * @return {jQuery.Promise}
 */
ve.init.mw.DesktopArticleTarget.prototype.activate = function ( dataPromise ) {
	var surface,
		target = this;

	if ( !this.active && !this.activating ) {
		this.activating = true;
		this.activatingDeferred = $.Deferred();
		this.toolbarSetupDeferred = $.Deferred();

		this.maybeShowWelcomeDialog();

		$( 'html' ).removeClass( 've-loading' ).addClass( 've-activating' );
		$.when( this.activatingDeferred, this.toolbarSetupDeferred ).done( function () {
			$( 'html' ).removeClass( 've-activating' ).addClass( 've-active' );
			// We have to focus the page after hiding the original content, otherwise
			// in firefox the contentEditable container was below the view page, and
			// 'focus' scrolled the screen down.
			target.getSurface().getView().focus();
		} ).fail( function () {
			$( 'html' ).removeClass( 've-activating' );
		} );

		this.bindHandlers();

		this.originalEditondbclick = mw.user.options.get( 'editondblclick' );
		mw.user.options.set( 'editondblclick', 0 );

		// User interface changes
		this.transformPage();
		this.setupLocalNoticeMessages();

		this.saveScrollPosition();

		// Create dummy surface to show toolbar while loading
		surface = this.addSurface( [] );
		surface.disable();
		// setSurface creates dummy toolbar
		this.setSurface( surface );
		// Disconnect the tool factory listeners so the toolbar
		// doesn't start showing new tools as they load, too
		// much flickering
		this.getToolbar().getToolFactory().off( 'register' );
		// Disable all the tools
		this.getToolbar().updateToolState();

		this.load( dataPromise );
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
ve.init.mw.DesktopArticleTarget.prototype.deactivate = function ( noDialog, trackMechanism ) {
	var target = this;
	if ( this.deactivating || ( !this.active && !this.activating ) ) {
		return;
	}

	// Just in case this wasn't closed before
	if ( this.welcomeDialog ) {
		this.welcomeDialog.close();
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
ve.init.mw.DesktopArticleTarget.prototype.cancel = function ( trackMechanism ) {
	var abortType,
		target = this,
		promises = [];

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
	$( 'html' ).addClass( 've-deactivating' ).removeClass( 've-activated ve-active' );
	// User interface changes
	if ( this.elementsThatHadOurAccessKey ) {
		this.elementsThatHadOurAccessKey.attr( 'accesskey', ve.msg( 'accesskey-save' ) );
	}
	this.restorePage();

	this.unbindHandlers();

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
		this.teardownUnloadHandlers();
		// If we got as far as setting up the surface, tear that down
		promises.push( this.teardownSurface() );
	} else if ( this.toolbar ) {
		// If a dummy toolbar was created, destroy it
		this.toolbar.destroy();
	}

	$.when.apply( null, promises ).done( function () {
		// If there is a load in progress, abort it
		if ( target.loading ) {
			target.loading.abort();
		}

		target.clearState();
		target.docToSave = null;
		target.initialEditSummary = new mw.Uri().query.summary;

		target.deactivating = false;
		target.activating = false;
		target.activatingDeferred.reject();
		$( 'html' ).removeClass( 've-deactivating' );

		// Move remaining elements back out of the target
		target.$element.parent().append( target.$element.children() );

		mw.hook( 've.deactivationComplete' ).fire( target.edited );
	} );
};

/**
 * @inheritdoc
 */
ve.init.mw.DesktopArticleTarget.prototype.loadFail = function ( errorText, error ) {
	// Parent method
	ve.init.mw.DesktopArticleTarget.super.prototype.loadFail.apply( this, arguments );

	// Don't show an error if the load was manually aborted
	// The response.status check here is to catch aborts triggered by navigation away from the page
	if (
		error &&
		Object.prototype.hasOwnProperty.call( error, 'error' ) &&
		Object.prototype.hasOwnProperty.call( error.error, 'info' )
	) {
		error = error.error.info;
	}

	if (
		errorText === 'http' &&
		( error.statusText !== 'abort' || error.xhr.status !== 504 ) &&
		confirm( ve.msg( 'visualeditor-loadwarning', 'HTTP ' + error.xhr.status ) )
	) {
		this.load();
	} else if (
		errorText === 'http' && error.xhr.status === 504 &&
		confirm( ve.msg( 'visualeditor-timeout' ) )
	) {
		if ( 'veaction' in this.currentUri.query ) {
			delete this.currentUri.query.veaction;
		}
		this.currentUri.query.action = 'edit';
		location.href = this.currentUri.toString();
	} else if (
		errorText !== 'http' &&
		typeof error === 'string' &&
		confirm( ve.msg( 'visualeditor-loadwarning', errorText + ': ' + error ) )
	) {
		this.load();
	} else {
		// Something weird happened? Deactivate
		// Not passing trackMechanism because we don't know what happened
		// and this is not a user action
		this.deactivate( true );
	}
};

/**
 * @inheritdoc
 */
ve.init.mw.DesktopArticleTarget.prototype.onSurfaceReady = function () {
	var surfaceReadyTime = ve.now(),
		target = this;

	if ( !this.activating ) {
		// Activation was aborted before we got here. Do nothing
		// TODO are there things we need to clean up?
		return;
	}

	this.activating = false;

	// TODO: mwTocWidget should probably live in a ve.ui.MWSurface subclass
	if ( mw.config.get( 'wgVisualEditorConfig' ).enableTocWidget ) {
		this.getSurface().mwTocWidget = new ve.ui.MWTocWidget( this.getSurface() );
	}

	// Track how long it takes for the first transaction to happen
	this.surface.getModel().getDocument().once( 'transact', function () {
		ve.track( 'mwtiming.behavior.firstTransaction', {
			duration: ve.now() - surfaceReadyTime,
			targetName: target.constructor.static.name
		} );
	} );

	// Update UI
	this.changeDocumentTitle();
	this.restoreScrollPosition();

	// Parent method
	ve.init.mw.DesktopArticleTarget.super.prototype.onSurfaceReady.apply( this, arguments );

	this.setupUnloadHandlers();
	this.maybeShowMetaDialog();

	this.activatingDeferred.resolve();
	this.events.trackActivationComplete();

	mw.hook( 've.activationComplete' ).fire();
};

/**
 * Handle Escape key presses.
 *
 * @param {jQuery.Event} e Keydown event
 */
ve.init.mw.DesktopArticleTarget.prototype.onDocumentKeyDown = function ( e ) {
	var target = this;

	// Parent method
	ve.init.mw.DesktopArticleTarget.super.prototype.onDocumentKeyDown.apply( this, arguments );

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
ve.init.mw.DesktopArticleTarget.prototype.onViewTabClick = function ( e ) {
	if ( ( e.which && e.which !== 1 ) || e.shiftKey || e.altKey || e.ctrlKey || e.metaKey ) {
		return;
	}
	this.deactivate( false, 'navigate-read' );
	e.preventDefault();
};

/**
 * @inheritdoc
 */
ve.init.mw.DesktopArticleTarget.prototype.saveComplete = function (
	html, categoriesHtml, newid, isRedirect, displayTitle, lastModified, contentSub, modules, jsconfigvars
) {
	var newUrlParams, watchChecked;

	// Parent method
	ve.init.mw.DesktopArticleTarget.super.prototype.saveComplete.apply( this, arguments );

	if ( !this.pageExists || this.restoring ) {
		// This is a page creation or restoration, refresh the page
		this.teardownUnloadHandlers();
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
		if ( mw.page.hasOwnProperty( 'watch' ) ) {
			watchChecked = this.checkboxesByName.wpWatchthis && this.checkboxesByName.wpWatchthis.isSelected();
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

		// Update module JS config values and notify ResourceLoader of any new
		// modules needed to be added to the page
		mw.config.set( jsconfigvars );
		mw.loader.load( modules );

		this.saveDialog.reset();
		this.replacePageContent(
			html,
			categoriesHtml,
			displayTitle,
			lastModified,
			contentSub
		);

		if ( newid !== undefined ) {
			$( '#t-permalink a, #coll-download-as-rl a' ).each( function () {
				var uri = new mw.Uri( $( this ).attr( 'href' ) );
				uri.query.oldid = newid;
				$( this ).attr( 'href', uri.toString() );
			} );
		}

		// ve-upstream-sync - review - @author: Paul Oslund
		// this.setupSectionEditLinks();

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
ve.init.mw.DesktopArticleTarget.prototype.showChangesDiff = function ( diffHtml ) {
	// Parent method
	ve.init.mw.DesktopArticleTarget.super.prototype.showChangesDiff.apply( this, arguments );

	// Invalidate the viewer diff on next change
	this.getSurface().getModel().getDocument().once( 'transact',
		this.saveDialog.clearDiff.bind( this.saveDialog )
	);
	this.saveDialog.setDiffAndReview( diffHtml );
};

/**
 * @inheritdoc
 */
ve.init.mw.DesktopArticleTarget.prototype.showChangesFail = function ( jqXHR, status ) {
	// Parent method
	ve.init.mw.DesktopArticleTarget.super.prototype.showChangesFail.apply( this, arguments );

	alert( ve.msg( 'visualeditor-differror', status ) );
	this.saveDialog.popPending();
};

/**
 * @inheritdoc
 */
ve.init.mw.DesktopArticleTarget.prototype.serializeFail = function ( jqXHR, status ) {
	// Parent method
	ve.init.mw.DesktopArticleTarget.super.prototype.serializeFail.apply( this, arguments );

	alert( ve.msg( 'visualeditor-serializeerror', status ) );

	this.getSurface().getDialogs().closeWindow( 'wikitextswitchconfirm' );

	// It's possible to get here while the save dialog has never been opened (if the user uses
	// the switch to source mode option)
	if ( this.saveDialog ) {
		this.saveDialog.popPending();
	}
};

/**
 * @inheritdoc
 */
ve.init.mw.DesktopArticleTarget.prototype.editConflict = function () {
	this.saveDialog.popPending();
	this.saveDialog.swapPanel( 'conflict' );
};

/**
 * @inheritdoc
 */
ve.init.mw.DesktopArticleTarget.prototype.noChanges = function () {
	this.saveDialog.popPending();
	this.saveDialog.swapPanel( 'nochanges' );
	this.saveDialog.getActions().setAbilities( { approve: true } );
};

/**
 * Handle clicks on the MwMeta button in the toolbar.
 *
 * @method
 * @param {jQuery.Event} e Mouse click event
 */
ve.init.mw.DesktopArticleTarget.prototype.onToolbarMetaButtonClick = function () {
	this.getSurface().getDialogs().openWindow( 'meta' );
};

/**
 * Open the dialog to switch to edit source mode with the current wikitext, or just do it straight
 * away if the document is unmodified. If we open the dialog, the document opacity will be set to
 * half, which can be reset with the resetDocumentOpacity function.
 *
 * @inheritdoc
 */
ve.init.mw.DesktopArticleTarget.prototype.editSource = function () {
	if ( !this.getSurface().getModel().hasBeenModified() ) {
		this.switchToWikitextEditor( true );
		return;
	}

	this.getSurface().getView().getDocument().getDocumentNode().$element.css( 'opacity', 0.5 );

	this.getSurface().getDialogs().openWindow( 'wikitextswitchconfirm', { target: this } );
};

/**
 * @inheritdoc
 */
ve.init.mw.DesktopArticleTarget.prototype.getSaveFields = function () {
	var name, fieldValues = {};

	for ( name in this.checkboxesByName ) {
		if ( this.checkboxesByName[ name ].isSelected() ) {
			fieldValues[ name ] = this.checkboxesByName[ name ].getValue();
		}
	}
	this.$otherFields.each( function () {
		var $this = $( this ),
			name = $this.prop( 'name' );
		if ( name ) {
			fieldValues[ name ] = $this.val();
		}
	} );

	return ve.extendObject(
		fieldValues,
		ve.init.mw.DesktopArticleTarget.super.prototype.getSaveFields.call( this )
	);
};

/**
 * Switch to viewing mode.
 *
 * @param {boolean} [noAnimate] Don't animate toolbar teardown
 * @return {jQuery.Promise} Promise resolved when surface is torn down
 */
ve.init.mw.DesktopArticleTarget.prototype.teardownSurface = function ( noAnimate ) {
	var target = this,
		promises = [];

	// Update UI
	promises.push( this.teardownToolbar( noAnimate ), this.teardownDebugBar() );
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

	return $.when.apply( null, promises ).then( function () {
		// Destroy surface
		while ( target.surfaces.length ) {
			target.surfaces.pop().destroy();
		}
		target.active = false;
	} );
};

/**
 * Modify tabs in the skin to support in-place editing.
 * Edit tab is bound outside the module in mw.DesktopArticleTarget.init.
 *
 * @method
 */
ve.init.mw.DesktopArticleTarget.prototype.setupSkinTabs = function () {
	var target = this;
	if ( this.isViewPage ) {
		// Allow instant switching back to view mode, without refresh
		$( '#ca-view a, #ca-nstab-visualeditor a' )
			.click( this.onViewTabClick.bind( this ) );

		$( '#ca-viewsource, #ca-edit' ).click( function ( e ) {
			if ( !target.active || e.which !== 1 || e.shiftKey || e.altKey || e.ctrlKey || e.metaKey ) {
				return;
			}

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
 * Dummy replaced by init.js so that we can call it again from #saveSuccess after
 * replacing the page contents with the new html.
 */
ve.init.mw.DesktopArticleTarget.prototype.setupSectionEditLinks = null;

/**
 * @inheritdoc
 */
ve.init.mw.DesktopArticleTarget.prototype.attachToolbarSaveButton = function () {
	this.actionsToolbar = new ve.ui.TargetToolbar( this );

	this.actionsToolbar.setup( [
		{ include: [ 'help', 'notices' ] },
		{
			type: 'list',
			icon: 'menu',
			title: ve.msg( 'visualeditor-pagemenu-tooltip' ),
			include: [ 'meta', 'settings', 'advancedSettings', 'categories', 'languages', 'editModeSource', 'findAndReplace' ]
		}
	], this.getSurface() );

	this.toolbar.$actions.append( this.actionsToolbar.$element, this.toolbarSaveButton.$element );
	// Make the toolbar recalculate its sizes for narrow/wide switching.
	// This really should not be necessary.
	this.toolbar.narrowThreshold = this.toolbar.$group.width() + this.toolbar.$actions.width();
};

/**
 * @inheritdoc
 */
ve.init.mw.DesktopArticleTarget.prototype.openSaveDialog = function () {
	var windowAction = ve.ui.actionFactory.create( 'window', this.getSurface() );

	// Open the dialog
	windowAction.open( 'mwSave', {
		target: this,
		editSummary: this.initialEditSummary,
		checkboxFields: this.checkboxFields,
		checkboxesByName: this.checkboxesByName
	} );
	this.initialEditSummary = undefined;
};

/**
 * Remember the window's scroll position.
 */
ve.init.mw.DesktopArticleTarget.prototype.saveScrollPosition = function () {
	this.scrollTop = $( window ).scrollTop();
};

/**
 * Restore the window's scroll position.
 */
ve.init.mw.DesktopArticleTarget.prototype.restoreScrollPosition = function () {
	if ( this.scrollTop ) {
		$( window ).scrollTop( this.scrollTop );
		this.scrollTop = null;
	}
};

/**
 * Hide the toolbar.
 *
 * @param {boolean} [noAnimate] Don't animate toolbar teardown
 * @return {jQuery.Promise} Promise which resolves when toolbar is hidden
 */
ve.init.mw.DesktopArticleTarget.prototype.teardownToolbar = function ( noAnimate ) {
	var target = this,
		deferred = $.Deferred(),
		tearDownToolbar = function () {
			target.toolbar.destroy();
			target.toolbar = null;
			deferred.resolve();
		};

	if ( noAnimate ) {
		tearDownToolbar();
	} else {
		this.toolbar.$element.css( 'height', this.toolbar.$bar.outerHeight() );
		setTimeout( function () {
			target.toolbar.$element.css( 'height', '0' );
			target.toolbar.$element.one( 'transitionend', tearDownToolbar );
		} );
	}

	return deferred.promise();
};

/**
 * Hide the debug bar.
 *
 * @return {jQuery.Promise} Promise which resolves when debug bar is hidden
 */
ve.init.mw.DesktopArticleTarget.prototype.teardownDebugBar = function () {
	var target = this;
	if ( this.debugBar ) {
		return this.debugBar.$element.slideUp( 'fast' ).promise().then( function () {
			target.debugBar.$element.remove();
			target.debugBar = null;
		} );
	}
	return $.Deferred().resolve().promise();
};

/**
 * Change the document title to state that we are now editing.
 */
ve.init.mw.DesktopArticleTarget.prototype.changeDocumentTitle = function () {
	var pageName = mw.config.get( 'wgPageName' ),
		title = mw.Title.newFromText( pageName );
	if ( title ) {
		pageName = title.getPrefixedText();
	}
	document.title = ve.msg(
		this.pageExists ? 'editing' : 'creating',
		pageName
	) + ' - ' + mw.config.get( 'wgSiteName' );
};

/**
 * Restore the original document title.
 */
ve.init.mw.DesktopArticleTarget.prototype.restoreDocumentTitle = function () {
	document.title = this.originalDocumentTitle;
};

/**
 * Page modifications for switching to edit mode.
 */
ve.init.mw.DesktopArticleTarget.prototype.transformPage = function () {
	var uri;

	// Deselect current mode (e.g. "view" or "history"). In skins like monobook that don't have
	// separate tab sections for content actions and namespaces the below is a no-op.
	$( '#p-views' ).find( 'li.selected' ).removeClass( 'selected' );
	$( '#ca-ve-edit' ).addClass( 'selected' );

	mw.hook( 've.activate' ).fire();

	// Move all native content inside the target
	this.$element.append( this.$element.siblings() );

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
ve.init.mw.DesktopArticleTarget.prototype.restorePage = function () {
	var uri, keys;

	// Skins like monobook don't have a tab for view mode and instead just have the namespace tab
	// selected. We didn't deselect the namespace tab, so we're ready after deselecting #ca-ve-edit.
	// In skins having #ca-view (like Vector), select that.
	$( '#ca-ve-edit' ).removeClass( 'selected' );
	$( '#ca-view' ).addClass( 'selected' );

	mw.hook( 've.deactivate' ).fire();
	this.emit( 'deactivate' );

	// Push article url into history
	if ( !this.actFromPopState && history.pushState ) {
		// Remove the VisualEditor query parameters
		uri = this.currentUri;
		if ( 'veaction' in uri.query ) {
			delete uri.query.veaction;
		}
		if ( 'vesection' in uri.query ) {
			delete uri.query.vesection;
		}

		// If there are any other query parameters left, re-use that uri object.
		// Otherwise use the canonical style view url (T44553, T102363).
		keys = Object.keys( uri.query );
		if ( !keys.length || ( keys.length === 1 && keys[ 0 ] === 'title' ) ) {
			history.pushState( this.popState, document.title, this.viewUri );
		} else {
			history.pushState( this.popState, document.title, uri );
		}
	}
	this.actFromPopState = false;
};

/**
 * @param {Event} e Native event object
 */
ve.init.mw.DesktopArticleTarget.prototype.onWindowPopState = function ( e ) {
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
 * @param {string} displayTitle HTML to show as the page title
 * @param {Object} lastModified Object containing user-formatted date
 *  and time strings, or undefined if we made no change.
 * @param {string} contentSub HTML to show as the content subtitle
 */
ve.init.mw.DesktopArticleTarget.prototype.replacePageContent = function (
	html, categoriesHtml, displayTitle, lastModified, contentSub
) {
	var $editableContent, $imgContent,
		$content = $( $.parseHTML( html ) );

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

	$imgContent = $( '#mw-imagepage-content' );
	if ( $imgContent.length ) {
		// On file pages, we only want to replace the (local) description.
		$editableContent = $imgContent;
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
ve.init.mw.DesktopArticleTarget.prototype.getEditSection = function ( heading ) {
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
ve.init.mw.DesktopArticleTarget.prototype.saveEditSection = function ( heading ) {
	this.section = this.getEditSection( heading );
};

/**
 * Add onunload and onbeforeunload handlers.
 *
 * @method
 */
ve.init.mw.DesktopArticleTarget.prototype.setupUnloadHandlers = function () {
	// Remember any already set beforeunload handler
	this.onBeforeUnloadFallback = window.onbeforeunload;
	// Attach our handlers
	window.onbeforeunload = this.onBeforeUnload.bind( this );
	window.addEventListener( 'unload', this.onUnloadHandler );
};
/**
 * Remove onunload and onbeforunload handlers.
 *
 * @method
 */
ve.init.mw.DesktopArticleTarget.prototype.teardownUnloadHandlers = function () {
	// Restore whatever previous onbeforeunload hook existed
	window.onbeforeunload = this.onBeforeUnloadFallback;
	this.onBeforeUnloadFallback = null;
	window.removeEventListener( 'unload', this.onUnloadHandler );
};

/**
 * Show the beta dialog as needed
 */
ve.init.mw.DesktopArticleTarget.prototype.maybeShowWelcomeDialog = function () {
	var usePrefs, prefSaysShow, urlSaysHide, windowManager,
		target = this;

	this.welcomeDialogPromise = $.Deferred();

	if ( mw.config.get( 'wgVisualEditorConfig' ).showBetaWelcome ) {
		// Set up a temporary window manager
		windowManager = new OO.ui.WindowManager( {
			classes: [
				've-init-mw-desktopArticleTarget-windowManager',
				've-init-mw-desktopArticleTarget-windowManager-welcome'
			]
		} );
		$( 'body' ).append( windowManager.$element );
		this.welcomeDialog = new ve.ui.MWBetaWelcomeDialog();
		windowManager.addWindows( [ this.welcomeDialog ] );

		// Only use the preference value if the user is logged-in.
		// If the user is anonymous, we can't save the preference
		// after showing the dialog. And we don't intend to use this
		// preference to influence anonymous users (use the config
		// variable for that; besides the pref value would be stale if
		// the wiki uses static html caching).
		usePrefs = !mw.user.isAnon();
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
			windowManager.openWindow( this.welcomeDialog )
				.then( function ( opened ) {
					return opened;
				} )
				.then( function ( closing ) {
					return closing;
				} )
				.then( function () {
					// Detach the temporary window manager
					windowManager.destroy();
					target.welcomeDialogPromise.resolve();
				} );
		} else {
			this.welcomeDialogPromise.resolve();
		}

		if ( prefSaysShow ) {
			new mw.Api().postWithToken( 'options', {
				action: 'options',
				change: 'visualeditor-hidebetawelcome=1'
			} );

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
	} else {
		this.welcomeDialogPromise.reject();
	}
};

/**
 * Show the meta dialog as needed on load.
 */
ve.init.mw.DesktopArticleTarget.prototype.maybeShowMetaDialog = function () {
	var target = this;

	this.welcomeDialogPromise
		.always( function () {
			// Pop out the notices when the welcome dialog is closed
			target.actionsToolbar.tools.notices.getPopup().toggle( true );
		} );

	if ( this.getSurface().getModel().metaList.getItemsInGroup( 'mwRedirect' ).length ) {
		this.getSurface().getDialogs().openWindow( 'meta', {
			page: 'settings',
			fragment: this.getSurface().getModel().getFragment()
		} );
	}
};

/**
 * Handle before unload event.
 *
 * @method
 */
ve.init.mw.DesktopArticleTarget.prototype.onBeforeUnload = function () {
	var fallbackResult;
	// Check if someone already set on onbeforeunload hook
	if ( this.onBeforeUnloadFallback ) {
		// Get the result of their onbeforeunload hook
		fallbackResult = this.onBeforeUnloadFallback();
		// If it returned something, exit here and return their message
		if ( fallbackResult !== undefined ) {
			return fallbackResult;
		}
	}
	// Check if there's been an edit
	if ( this.getSurface() && this.edited && !this.submitting && mw.user.options.get( 'useeditwarning' ) ) {
		// Return our message
		return ve.msg( 'visualeditor-viewpage-savewarning' );
	}
};

/**
 * Handle unload event.
 *
 * @method
 */
ve.init.mw.DesktopArticleTarget.prototype.onUnload = function () {
	if ( !this.submitting ) {
		ve.track( 'mwedit.abort', {
			type: this.edited ? 'unknown-edited' : 'unknown',
			mechanism: 'navigate'
		} );
	}
};

/**
 * Switches to the wikitext editor, either keeping (default) or discarding changes.
 *
 * @param {boolean} [discardChanges] Whether to discard changes or not.
 */
ve.init.mw.DesktopArticleTarget.prototype.switchToWikitextEditor = function ( discardChanges ) {
	var target = this;
	if ( discardChanges ) {
		ve.track( 'mwedit.abort', { type: 'switchwithout', mechanism: 'navigate' } );
		this.submitting = true;
		location.href = this.viewUri.clone().extend( {
			action: 'edit',
			veswitched: 1
		} ).toString();
	} else {
		this.serialize(
			this.docToSave || this.getSurface().getDom(),
			function ( wikitext ) {
				ve.track( 'mwedit.abort', { type: 'switchwith', mechanism: 'navigate' } );
				target.submitWithSaveFields( { wpDiff: 1, veswitched: 1 }, wikitext );
			}
		);
	}
};

/**
 * Resets the document opacity when we've decided to cancel switching to the wikitext editor.
 */
ve.init.mw.DesktopArticleTarget.prototype.resetDocumentOpacity = function () {
	this.getSurface().getView().getDocument().getDocumentNode().$element.css( 'opacity', 1 );
};
