/*global mw, confirm, alert */

/**
 * VisualEditor MediaWiki initialization ViewPageTarget class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki Edit page target.
 *
 * @class
 * @constructor
 * @extends {ve.init.mw.Target}
 */
ve.init.mw.ViewPageTarget = function VeInitMwViewPageTarget() {
	var currentUri = new mw.Uri( window.location.toString() );

	// Parent constructor
	ve.init.mw.Target.call(
		this, mw.config.get( 'wgRelevantPageName' ), currentUri.query.oldid
	);

	// Properties
	this.$document = null;
	this.$spinner = $( '<div class="ve-init-mw-viewPageTarget-loadingSpinner"></div>' );
	this.$toolbarSaveButton =
		$( '<div class="ve-init-mw-viewPageTarget-toolbar-saveButton"></div>' );
	this.$saveDialog =
		$( '<div class="ve-init-mw-viewPageTarget-saveDialog"></div>' );
	this.$saveDialogSaveButton = null;
	this.onBeforeUnloadFallback = null;
	this.proxiedOnBeforeUnload = null;
	this.surface = null;
	this.active = false;
	this.edited = false;
	this.activating = false;
	this.deactivating = false;
	this.scrollTop = null;
	this.proxiedOnSurfaceModelTransact = ve.bind( this.onSurfaceModelTransact, this );
	this.surfaceOptions = {
		'toolbars': {
			'top': {
				'float': !this.isMobileDevice
			}
		}
	};
	this.currentUri = currentUri;
	this.section = currentUri.query.vesection || null;
	this.namespaceName = mw.config.get( 'wgCanonicalNamespace' );
	this.viewUri = new mw.Uri( mw.util.wikiGetlink( this.pageName ) );
	this.veEditUri = this.viewUri.clone().extend( { 'veaction': 'edit' } );
	this.isViewPage = (
		mw.config.get( 'wgAction' ) === 'view' &&
		currentUri.query.diff === undefined
	);
	this.canBeActivated = (
		$.client.test( ve.init.mw.ViewPageTarget.compatibility ) ||
		'vewhitelist' in currentUri.query
	);
	this.editSummaryByteLimit = 255;

	// Events
	this.addListenerMethods( this, {
		'load': 'onLoad',
		'save': 'onSave',
		'loadError': 'onLoadError',
		'saveError': 'onSaveError'
	} );

	// Initialization
	if ( this.canBeActivated ) {
		if ( currentUri.query.venotify ) {
			// The following messages can be used here:
			// visualeditor-notification-saved
			// visualeditor-notification-created
			mw.util.jsMessage(
				ve.msg( 'visualeditor-notification-' + currentUri.query.venotify, this.pageName )
			);
			if ( window.history.replaceState ) {
				delete currentUri.query.venotify;
				window.history.replaceState( null, document.title, currentUri );
			}
		}
		this.setupSkinTabs();
		this.setupSectionEditLinks();
		if ( this.isViewPage ) {
			this.setupToolbarSaveButton();
			this.setupSaveDialog();
			if ( currentUri.query.veaction === 'edit' ) {
				this.activate();
			}
		}
	}
};

/* Inheritance */

ve.inheritClass( ve.init.mw.ViewPageTarget, ve.init.mw.Target );

/* Static Members */

/**
 * Compatibility map used with jQuery.client to black-list incompatible browsers.
 *
 * @static
 * @member
 */
ve.init.mw.ViewPageTarget.compatibility = {
	// Left-to-right languages
	ltr: {
		msie: [['>=', 9]],
		firefox: [['>=', 11]],
		safari: [['>=', 5]],
		chrome: [['>=', 19]],
		opera: false,
		netscape: false,
		blackberry: false
	},
	// Right-to-left languages
	rtl: {
		msie: [['>=', 9]],
		firefox: [['>=', 11]],
		safari: [['>=', 5]],
		chrome: [['>=', 19]],
		opera: false,
		netscape: false,
		blackberry: false
	}
};

/*jshint multistr: true*/
ve.init.mw.ViewPageTarget.saveDialogTemplate = '\
	<div class="ve-init-mw-viewPageTarget-saveDialog-title"></div>\
	<div class="ve-init-mw-viewPageTarget-saveDialog-closeButton"></div>\
	<div class="ve-init-mw-viewPageTarget-saveDialog-body">\
		<div class="ve-init-mw-viewPageTarget-saveDialog-summary">\
			<label class="ve-init-mw-viewPageTarget-saveDialog-editSummary-label"\
				for="ve-init-mw-viewPageTarget-saveDialog-editSummary"></label>\
			<textarea name="editSummary" class="ve-init-mw-viewPageTarget-saveDialog-editSummary"\
				id="ve-init-mw-viewPageTarget-saveDialog-editSummary" type="text"\
				rows="4"></textarea>\
		</div>\
		<div class="ve-init-mw-viewPageTarget-saveDialog-options">\
			<input type="checkbox" name="minorEdit" \
				id="ve-init-mw-viewPageTarget-saveDialog-minorEdit">\
			<label class="ve-init-mw-viewPageTarget-saveDialog-minorEdit-label" \
				for="ve-init-mw-viewPageTarget-saveDialog-minorEdit"></label>\
			<input type="checkbox" name="watchList" \
				id="ve-init-mw-viewPageTarget-saveDialog-watchList">\
			<label class="ve-init-mw-viewPageTarget-saveDialog-watchList-label" \
				for="ve-init-mw-viewPageTarget-saveDialog-watchList"></label>\
			<label class="ve-init-mw-viewPageTarget-saveDialog-editSummaryCount"></label>\
		</div>\
		<button class="ve-init-mw-viewPageTarget-saveDialog-saveButton">\
			<span class="ve-init-mw-viewPageTarget-saveDialog-saveButton-label"></span>\
		</button>\
		<div class="ve-init-mw-viewPageTarget-saveDialog-saving"></div>\
		<div style="clear: both;"></div>\
	</div>\
	<div class="ve-init-mw-viewPageTarget-saveDialog-foot">\
		<p class="ve-init-mw-viewPageTarget-saveDialog-license"></p>\
	</div>';

/* Methods */

/**
 * Switches to edit mode.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.activate = function () {
	if ( !this.active && !this.activating ) {
		this.activating = true;
		// User interface changes
		this.transformSkinTabs();
		this.hideSiteNotice();
		this.showSpinner();
		this.hideTableOfContents();
		this.mutePageContent();
		this.mutePageTitle();
		this.saveScrollPosition();
		this.load();
	}
};

/**
 * Switches to view mode.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.deactivate = function ( override ) {
	if ( this.active && !this.deactivating ) {
		if (
			override ||
			!this.surface.getModel().getHistory().length ||
			confirm( ve.msg( 'visualeditor-viewpage-savewarning' ) )
		) {
			this.deactivating = true;
			// User interface changes
			this.restoreSkinTabs();
			this.restoreSiteNotice();
			this.hideSpinner();
			this.detachToolbarSaveButton();
			this.detachSaveDialog();
			this.tearDownSurface();
			this.showTableOfContents();
			this.deactivating = false;
		}
	}
};

/**
 * Handles successful DOM load event.
 *
 * @method
 * @param {HTMLElement} dom Parsed DOM from server
 */
ve.init.mw.ViewPageTarget.prototype.onLoad = function ( dom ) {
	this.edited = false;
	this.setUpSurface( dom );
	this.attachToolbarSaveButton();
	this.attachSaveDialog();
	this.restoreScrollPosition();
	this.restoreEditSection();
	this.setupBeforeUnloadHandler();
	this.$document.focus();
	this.activating = false;
};

/**
 * Handles failed DOM load event.
 *
 * @method
 * @param {Object} data HTTP Response object
 * @param {String} status Text status message
 * @param {Mixed} error Thrown exception or HTTP error string
 */
ve.init.mw.ViewPageTarget.prototype.onLoadError = function ( response, status ) {
	if ( confirm( ve.msg( 'visualeditor-loadwarning', status ) ) ) {
		this.load();
	} else {
		this.activating = false;
		this.restoreSkinTabs();
		this.hideSpinner();
		this.showTableOfContents();
		this.showPageContent();
		this.restorePageTitle();
	}
};

/**
 * Handles successful DOM save event.
 *
 * @method
 * @param {HTMLElement} html Rendered HTML from server
 */
ve.init.mw.ViewPageTarget.prototype.onSave = function ( html ) {
	if ( Number( mw.config.get( 'wgArticleId', 0 ) ) === 0 || this.oldId ) {
		// This is a page creation, refresh the page
		this.teardownBeforeUnloadHandler();
		window.location.href = this.viewUri.extend( {
			'venotify': this.oldId ? 'saved' : 'created'
		} );
	} else {
		// Update watch link to match 'watch checkbox' in save dialog.
		// User logged in if module loaded.
		// Just checking for mw.page.watch is not enough because in Firefox
		// there is Object.prototype.watch...
		if ( mw.page.watch && mw.page.watch.updateWatchLink ) {
			var watchChecked = this.$saveDialog
				.find( '#ve-init-mw-viewPageTarget-saveDialog-watchList')
				.prop( 'checked' );
			mw.page.watch.updateWatchLink(
				$( '#ca-watch a, #ca-unwatch a' ),
				watchChecked ? 'unwatch': 'watch'
			);
		}
		this.hideSaveDialog();
		this.resetSaveDialog();
		this.replacePageContent( html );
		this.teardownBeforeUnloadHandler();
		this.deactivate( true );
		mw.util.jsMessage( ve.msg( 'visualeditor-notification-saved', this.pageName ) );
	}
};

/**
 * Handles failed DOM save event.
 *
 * @method
 * @param {Object} data HTTP Response object
 * @param {String} status Text status message
 * @param {Mixed} error Thrown exception or HTTP error string
 */
ve.init.mw.ViewPageTarget.prototype.onSaveError = function ( response, status ) {
	// TODO: Don't use alert.
	alert( ve.msg( 'visualeditor-saveerror', status ) );
};

/**
 * Handles clicks on the edit tab.
 *
 * @method
 * @param {jQuery.Event} e
 */
ve.init.mw.ViewPageTarget.prototype.onEditTabClick = function ( e ) {
	this.activate();
	// Prevent the edit tab's normal behavior
	e.preventDefault();
};

/**
 * Handles clicks on a section edit link.
 *
 * @method
 * @param {jQuery.Event} e
 */
ve.init.mw.ViewPageTarget.prototype.onEditSectionLinkClick = function ( e ) {
	this.saveEditSection( $( e.target ).closest( 'h1, h2, h3, h4, h5, h6' ).get( 0 ) );
	this.activate();
	// Prevent the edit tab's normal behavior
	e.preventDefault();
};

/**
 * Handles clicks on the view tab.
 *
 * @method
 * @param {jQuery.Event} e
 */
ve.init.mw.ViewPageTarget.prototype.onViewTabClick = function ( e ) {
	if ( this.active ) {
		this.deactivate();
		// Prevent the edit tab's normal behavior
		e.preventDefault();
	}
};

/**
 * Handles clicks on the save button in the toolbar.
 *
 * @method
 * @param {jQuery.Event} e
 */
ve.init.mw.ViewPageTarget.prototype.onToolbarSaveButtonClick = function () {
	if ( this.edited ) {
		this.showSaveDialog();
	}
};

/**
 * Handles the first transaction in the surface model.
 *
 * This handler is removed the first time it's used, but added each time the surface is setup.
 *
 * @method
 * @param {ve.Transaction} tx Processed transaction
 */
ve.init.mw.ViewPageTarget.prototype.onSurfaceModelTransact = function () {
	this.edited = true;
	this.enableToolbarSaveButton();
	this.surface.getModel().removeListener( 'transact', this.proxiedOnSurfaceModelTransact );
};

/**
 * Handles clicks on the save button in the save dialog.
 *
 * @method
 * @param {jQuery.Event} e
 */
ve.init.mw.ViewPageTarget.prototype.onSaveDialogSaveButtonClick = function () {
	this.lockSaveDialogSaveButton();
	this.$saveDialogLoadingIcon.show();
	this.save(
		ve.dm.converter.getDomFromData( this.surface.getDocumentModel().getFullData() ),
		{
			'summary': $( '#ve-init-mw-viewPageTarget-saveDialog-editSummary' ).val(),
			'minor': $( '#ve-init-mw-viewPageTarget-saveDialog-minorEdit' ).prop( 'checked' ),
			'watch': $( '#ve-init-mw-viewPageTarget-saveDialog-watchList' ).prop( 'checked' )
		},
		ve.bind( this.onSave, this )
	);
};

/**
 * Handles clicks on the close button in the save dialog.
 *
 * @method
 * @param {jQuery.Event} e
 */
ve.init.mw.ViewPageTarget.prototype.onSaveDialogCloseButtonClick = function () {
	this.hideSaveDialog();
};

/**
 * Switches to editing mode.
 *
 * @method
 * @param {HTMLElement} dom HTML DOM to edit
 */
ve.init.mw.ViewPageTarget.prototype.setUpSurface = function ( dom ) {
	var $contentText = $( '#mw-content-text' );

	// Initialize surface
	this.surface = new ve.Surface( $( '#content' ), dom, this.surfaceOptions );
	this.$document = this.surface.$.find( '.ve-ce-documentNode' );
	this.surface.getModel().on( 'transact', this.proxiedOnSurfaceModelTransact );
	// Transplant the toolbar
	this.attachToolbar();
	this.transformPageTitle();
	// Update UI
	this.hidePageContent();
	this.hideSpinner();
	if ( !this.currentUri.query.oldid ) {
		this.disableToolbarSaveButton();
	}
	this.active = true;
	this.$document.attr( {
		'lang': $contentText.attr( 'lang' ),
		'dir': $contentText.attr( 'dir' )
	} );
};

/**
 * Switches to viewing mode.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.tearDownSurface = function () {
	// Reset tabs
	this.restoreSkinTabs();
	// Update UI
	this.$document.blur();
	this.$document = null;
	this.surface.$.empty().detach();
	$( '.ve-ui-context' ).remove();
	this.detachToolbar();
	this.hideSpinner();
	this.showPageContent();
	this.restorePageTitle();
	this.showTableOfContents();
	// Remove handler if it's still active
	this.surface.getModel().removeListener( 'transact', this.proxiedOnSurfaceModelTransact );
	// Destroy editor
	this.surface = null;
	this.active = false;
};

/**
 * Modifies tabs in the skin to support in-place editing.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.setupSkinTabs = function () {
	var action, $viewSource, pVeEdit;

	// Only sysop users will have a native edit tab in this namespace
	// If there isn't an edit tab, there's a view source tab we'll move into
	// p-cactions.
	if ( $( '#ca-edit' ).length === 0 ) {

		$viewSource = $( '#ca-viewsource' );
		if ( $viewSource.length > 0 ) {
			// Re-create instead of moving the original one since we don't want to copy
			// over accesskey etc., access+e should trigger VE edit.
			mw.util.addPortletLink(
				'p-cactions',
				$viewSource.find( 'a' ).attr( 'href' ),
				$viewSource.find( 'a' ).text(),
				$viewSource.attr( 'id' )
			);
			$viewSource.remove();
		}

	// For sysops, remove the native edit tab in favour
	// of an editsource link in p-cactions.
	// Re-create instead of moving the original one since we don't want to copy
	// over accesskey etc., access+e should trigger VE edit.
	} else {
		/*
		mw.util.addPortletLink(
			'p-cactions',
			// Use original href to preserve oldid etc. (bug 38125)
			$( '#ca-edit a' ).attr( 'href' ),
			ve.msg( 'visualeditor-ca-editsource' ),
			'ca-editsource'
		);
		$( '#ca-edit' ).remove();
		*/
	}

	// Whether we moved viewsource or transformed edit
	// into editsource, add a new "VisualEditor" Edit tab
	action = mw.config.get( 'wgArticleId', 0 ) === 0 ? 'create' : 'edit';
	pVeEdit = mw.util.addPortletLink(
		$( '#p-views' ).length ? 'p-views' : 'p-cactions',
		// Use url instead of '#'.
		// So that 1) one can always open it in a new tab, even when
		// onEditTabClick is bound.
		// 2) when onEditTabClick is not bound (!isViewPage) it will
		// just work.
		this.veEditUri,
		ve.msg( action ), // 'edit' or 'create'
		'ca-edit',
		ve.msg( 'tooltip-ca-edit' ),
		ve.msg( 'accesskey-ca-edit' ),
		'#ca-history'
	);

	if ( this.isViewPage ) {
		// Allow instant switching to edit mode, without refresh
		$( '#ca-edit' ).click( ve.bind( this.onEditTabClick, this ) );
		// Allow instant switching back to view mode, without refresh
		$( '#ca-view a, #ca-nstab-visualeditor a' )
			.click( ve.bind( this.onViewTabClick, this ) );
	}
	// Source editing shouldn't highlight the edit tab
	if ( mw.config.get( 'wgAction' ) === 'edit' ) {
		$( '#ca-edit' ).removeClass( 'selected' );
	}
	// Fix the URL if there was a veaction param in it
	if ( this.currentUri.query.veaction === 'edit' && window.history.replaceState ) {
		window.history.replaceState( null, document.title, this.viewUri );
	}
};

/**
 * Modifies page content to make section edit links activate the editor.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.setupSectionEditLinks = function () {
	var veEditUri = this.veEditUri,
		$links = $( '#mw-content-text .editsection a' );
	if ( this.isViewPage ) {
		$links.click( ve.bind( this.onEditSectionLinkClick, this ) );
	} else {
		$links.each( function () {
			var veSectionEditUri = new mw.Uri( veEditUri.toString() ),
				sectionEditUri = new mw.Uri( $(this).attr( 'href' ) );
			veSectionEditUri.extend( { 'vesection': sectionEditUri.query.section } );
			$(this).attr( 'href', veSectionEditUri );
		} );
	}
};

/**
 * Adds content and event bindings to the save button.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.setupToolbarSaveButton = function () {
	this.$toolbarSaveButton
		.append(
			$( '<span class="ve-init-mw-viewPageTarget-toolbar-saveButton-label"></span>' )
				.text( ve.msg( 'savearticle' ) )
		)
		.on( {
			'mousedown': function ( e ) {
				$(this).addClass( 've-init-mw-viewPageTarget-toolbar-saveButton-down' );
				e.preventDefault();
			},
			'mouseleave mouseup': function ( e ) {
				$(this).removeClass( 've-init-mw-viewPageTarget-toolbar-saveButton-down' );
				e.preventDefault();
			},
			'click': ve.bind( this.onToolbarSaveButtonClick, this )
		} );
};

/**
 * Adds the save button to the user interface.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.attachToolbarSaveButton = function () {
	$( '.ve-ui-toolbar .ve-ui-actions' ).append( this.$toolbarSaveButton );
};

/**
 * Removes the save button from the user interface.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.detachToolbarSaveButton = function () {
	this.$toolbarSaveButton.detach();
};

/**
 * Adds content and event bindings to the save dialog.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.setupSaveDialog = function () {
	var viewPage = this;
	viewPage.$saveDialog
		.html( ve.init.mw.ViewPageTarget.saveDialogTemplate )
		.find( '.ve-init-mw-viewPageTarget-saveDialog-title' )
			.text( ve.msg( 'tooltip-save' ) )
			.end()
		.find( '.ve-init-mw-viewPageTarget-saveDialog-closeButton' )
			.click( ve.bind( viewPage.onSaveDialogCloseButtonClick, viewPage ) )
			.end()
		.find( '#ve-init-mw-viewPageTarget-saveDialog-editSummary' )
			.attr( {
				'placeholder': ve.msg( 'visualeditor-editsummary' )
			} )
			.placeholder()
			.byteLimit( viewPage.editSummaryByteLimit )
			.on( 'keydown mouseup cut paste change focus blur', function () {
				var $textarea = $(this),
					$editSummaryCount = $textarea
						.closest( '.ve-init-mw-viewPageTarget-saveDialog-body' )
							.find( '.ve-init-mw-viewPageTarget-saveDialog-editSummaryCount' );
				// TODO: This looks a bit weird, there is no unit in the UI, just numbers
				// Users likely assume characters but then it seems to count down quicker
				// than expected. Facing users with the word "byte" is bad? (bug 40035)
				setTimeout( function () {
					$editSummaryCount.text(
						viewPage.editSummaryByteLimit - $.byteLength( $textarea.val() )
					);
				}, 0 );
			} )
			.end()
		.find( '.ve-init-mw-viewPageTarget-saveDialog-editSummaryCount' )
			.text( viewPage.editSummaryByteLimit )
			.end()
		.find( '.ve-init-mw-viewPageTarget-saveDialog-minorEdit-label' )
			.text( ve.msg( 'minoredit' ) )
			.end()
		.find( '#ve-init-mw-viewPageTarget-saveDialog-watchList' )
			.prop( 'checked', mw.config.get( 'wgVisualEditor' ).isPageWatched )
			.end()
		.find( '.ve-init-mw-viewPageTarget-saveDialog-saveButton' )
			.on( {
				'mousedown': function () {
					$(this).addClass( 've-init-mw-viewPageTarget-saveDialog-saveButton-down' );
				},
				'mouseleave mouseup': function () {
					$(this).removeClass( 've-init-mw-viewPageTarget-saveDialog-saveButton-down' );
				},
				'click': ve.bind( viewPage.onSaveDialogSaveButtonClick, viewPage )
			} )
			.end()
		.find( '.ve-init-mw-viewPageTarget-saveDialog-saveButton-label' )
			.text( ve.msg( 'savearticle' ) )
			.end()
		.find( '.ve-init-mw-viewPageTarget-saveDialog-license' )
			// FIXME license text is hardcoded English
			.html(
				'By editing this page, you agree to irrevocably release your \
				contributions under the CC-BY-SA 3.0 License. If you don\'t want your \
				writing to be edited mercilessly and redistrubuted at will, then \
				don\'t submit it here.<br/><br/>You are also confirming that you \
				wrote this yourself, or copied it from a public domain or similar free \
				resource. See Project:Copyright for full details of the licenses \
				used on this site.\
				<b>DO NOT SUBMIT COPYRIGHTED WORK WITHOUT PERMISSION!</b>'
			);
	viewPage.$saveDialogSaveButton = viewPage.$saveDialog
		.find( '.ve-init-mw-viewPageTarget-saveDialog-saveButton' );
	viewPage.$saveDialogLoadingIcon = viewPage.$saveDialog
		.find( '.ve-init-mw-viewPageTarget-saveDialog-saving' );
	// Hook onto the 'watch' event on by mediawiki.page.watch.ajax.js
	// Triggered when mw.page.watch.updateWatchLink(link, action) is called
	$( '#ca-watch, #ca-unwatch' )
		.on(
			'watchpage.mw',
			function ( e, action ) {
				viewPage.$saveDialog
					.find( '#ve-init-mw-viewPageTarget-saveDialog-watchList' )
					.prop( 'checked', ( action === 'watch' ) );
			}
		);
};

/**
 * Adds the save dialog to the user interface.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.attachSaveDialog = function () {
	// Update the minoredit and watchthis messages (which came through the message module)
	this.$saveDialog.find( '.ve-init-mw-viewPageTarget-saveDialog-minorEdit-label' )
		.html( ve.msg( 'minoredit' ) );
	this.$saveDialog.find( '.ve-init-mw-viewPageTarget-saveDialog-watchList-label' )
		.html( ve.msg( 'watchthis' ) );
	this.$toolbarWrapper.find( '.ve-ui-toolbar' ).append( this.$saveDialog );
};

/**
 * Removes the save dialog from the user interface.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.detachSaveDialog = function () {
	this.$saveDialog.detach();
};

/**
 * Remembers the window's scroll position.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.saveScrollPosition = function () {
	this.scrollTop = $( window ).scrollTop();
};

/**
 * Restores the window's scroll position.
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
 * Shows the loading spinner.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.showSpinner = function () {
	$( '#firstHeading' ).prepend( this.$spinner );
};

/**
 * Hides the loading spinner.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.hideSpinner = function () {
	this.$spinner.detach();
};

/**
 * Shows the page content.
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
 * Mutes the page content.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.mutePageContent = function () {
	$( '#bodyContent > :visible:not(#siteSub, #contentSub)' )
		.addClass( 've-init-mw-viewPageTarget-content' )
		.fadeTo( 'fast', 0.6 );
};

/**
 * Hides the page content.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.hidePageContent = function () {
	$( '#bodyContent > :visible:not(#siteSub, #contentSub)' )
		.addClass( 've-init-mw-viewPageTarget-content' )
		.hide();
};

/**
 * Shows the table of contents in the view mode.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.showTableOfContents = function () {
	var $toc = $( '#toc' ),
		$wrap = $toc.parent();
	if ( $wrap.data( 've.hideTableOfContents' ) ) {
		$wrap.slideDown(function () {
			$toc.unwrap();
		});
	}
};

/**
 * Hides the table of contents in the view mode.
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
 * Shows the save dialog.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.showSaveDialog = function () {
	var viewPage = this;
	this.unlockSaveDialogSaveButton();
	this.$saveDialogLoadingIcon.hide();
	this.$saveDialog.fadeIn( 'fast' ).find( 'textarea' ).eq( 0 ).focus();
	$( document ).on( 'keydown', function ( e ) {
		if ( e.which === 27 ) {
			viewPage.onSaveDialogCloseButtonClick();
		}
	});
};

/**
 * Hides the save dialog
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.hideSaveDialog = function () {
	this.$saveDialog.fadeOut( 'fast' );
	this.$document.focus();
	$( document ).off( 'keydown' );
};

/**
 * Resets the fields of the save dialog
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.resetSaveDialog = function () {
	this.$saveDialog
		.find( '#ve-init-mw-viewPageTarget-saveDialog-editSummary' )
			.val( '' )
			.end()
		.find( '#ve-init-mw-viewPageTarget-saveDialog-minorEdit' )
			.prop( 'checked', false );
};

/**
 * Enables the toolbar save button.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.enableToolbarSaveButton = function () {
	this.$toolbarSaveButton
		.removeClass( 've-init-mw-viewPageTarget-toolbar-saveButton-disabled' );
};

/**
 * Disables the toolbar save button.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.disableToolbarSaveButton = function () {
	this.$toolbarSaveButton
		.addClass( 've-init-mw-viewPageTarget-toolbar-saveButton-disabled' );
};

/**
 * Enables the save dialog save button.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.unlockSaveDialogSaveButton = function () {
	this.$saveDialogSaveButton
		.removeClass( 've-init-mw-viewPageTarget-saveDialog-saveButton-saving' );
};

/**
 * Disables the save dialog save button.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.lockSaveDialogSaveButton = function () {
	this.$saveDialogSaveButton
		.addClass( 've-init-mw-viewPageTarget-saveDialog-saveButton-saving' );
};

/**
 * Shows the toolbar.
 *
 * This also transplants the toolbar to a new location.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.attachToolbar = function () {
	this.$toolbarWrapper = $( '.ve-ui-toolbar-wrapper' )
		.insertBefore( $( '#firstHeading' ) )
		.find( '.ve-ui-toolbar' )
			.slideDown( 'fast' )
			.end();
};

/**
 * Hides the toolbar.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.detachToolbar = function () {
	$( '.ve-ui-toolbar' ).slideUp( 'fast', function () {
		$(this).parent().remove();
	} );
};

/**
 * Enables the toolbar save button.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.transformPageTitle = function () {
	$( '#firstHeading' ).addClass( 've-init-mw-viewPageTarget-pageTitle' );
};

/**
 * Enables the toolbar save button.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.mutePageTitle = function () {
	$( '#firstHeading, #siteSub:visible, #contentSub:visible' ).fadeTo( 'fast', 0.6 );
};

/**
 * Disables the toolbar save button.
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
 * Modifies page tabs to show that editing is taking place.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.transformSkinTabs = function () {
	$( $( '#p-views' ).length ? '#p-views' : '#p-cactions' )
		.find( 'li.selected' ).removeClass( 'selected' );
	$( '#ca-edit' ).addClass( 'selected' );
};

/**
 * Modifies page tabs to show that viewing is taking place.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.restoreSkinTabs = function () {
	$( $( '#p-views' ).length ? '#p-views' : '#p-cactions' )
		.find( 'li.selected' ).removeClass( 'selected' );
	$( '#ca-view' ).addClass( 'selected' );
};

/**
 * Hides site notice on page if present.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.hideSiteNotice = function () {
	$( '#siteNotice:visible' )
		.addClass( 've-hide' )
		.slideUp( 'fast' );
};

/**
 * Show site notice on page if present.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.restoreSiteNotice = function () {
	$(' #siteNotice.ve-hide' )
		.slideDown( 'fast' );
};

/**
 * Replaces the page content with new HTML.
 *
 * @method
 * @param {HTMLElement} html Rendered HTML from server
 */
ve.init.mw.ViewPageTarget.prototype.replacePageContent = function ( html ) {
	$( '#mw-content-text' ).html( html );
};

/**
 * Gets the numeric index of a section in the page.
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
 * Gets the numeric index of a section in the page.
 *
 * @method
 * @param {HTMLElement} heading Heading element of section
 */
ve.init.mw.ViewPageTarget.prototype.saveEditSection = function ( heading ) {
	this.section = this.getEditSection( heading );
};

/**
 * Moves the cursor in the editor to a given section.
 *
 * @method
 * @param {Number} section Section to move cursor to
 */
ve.init.mw.ViewPageTarget.prototype.restoreEditSection = function () {
	if ( this.section !== null ) {
		var offset,
			surfaceView = this.surface.getView(),
			surfaceModel = surfaceView.getModel();
		this.$document.find( 'h1, h2, h3, h4, h5, h6' ).eq( this.section - 1 ).each( function () {
			var headingNode = $(this).data( 'node' );
			if ( headingNode ) {
				offset = surfaceModel.getDocument().getNearestContentOffset(
					headingNode.getModel().getOffset()
				);
				surfaceModel.change( null, new ve.Range( offset, offset ) );
				surfaceView.showSelection( surfaceModel.getSelection() );
			}
		} );
		this.section = null;
	}
};

/**
 * Adds onbeforunload handler.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.setupBeforeUnloadHandler = function () {
	// Remember any already set on before unload handler
	this.onBeforeUnloadFallback = window.onbeforeunload;
	// Attach before unload handler
	window.onbeforeunload = this.proxiedOnBeforeUnload = ve.bind( this.onBeforeUnload, this );
	// Attach page show handlers
	if ( window.addEventListener ) {
		window.addEventListener( 'pageshow', ve.bind( this.onPageShow, this ), false );
	} else if ( window.attachEvent ) {
		window.attachEvent( 'pageshow', ve.bind( this.onPageShow, this ) );
	}
};

/**
 * Removes onbeforunload handler.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.teardownBeforeUnloadHandler = function () {
	// Restore whatever previous onbeforeload hook existed
	window.onbeforeunload = this.onBeforeUnloadFallback;
};

/**
 * Responds to page show event.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onPageShow = function () {
	// Re-add onbeforeunload handler
	window.onbeforeunload = this.proxiedOnBeforeUnload;
};

/**
 * Responds to before unload event.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.onBeforeUnload = function () {
	var fallbackResult,
		message,
		proxiedOnBeforeUnload = this.proxiedOnBeforeUnload;
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
		// Check if there's been an edit
		if ( this.surface && this.surface.getModel().getHistory().length ) {
			// Return our message
			message = ve.msg( 'visualeditor-viewpage-savewarning' );
		}
	}
	// Unset the onbeforeunload handler so we don't break page caching in Firefox
	window.onbeforeunload = null;
	if ( message !== undefined ) {
		// ...but if the user chooses not to leave the page, we need to rebind it
		setTimeout( function () {
			window.onbeforeunload = proxiedOnBeforeUnload;
		}, 1 );
		return message;
	}
};

/* Initialization */

ve.init.mw.targets.push( new ve.init.mw.ViewPageTarget() );
