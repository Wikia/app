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

	// Events
	this.addListenerMethods( this, {
		'load': 'onLoad',
		'save': 'onSave',
		'loadError': 'onLoadError',
		'saveError': 'onSaveError'
	} );

	// Properties
	this.currentUri = currentUri;
	this.isViewPage = (
		mw.config.get( 'wgAction' ) === 'view' &&
		currentUri.query.diff === undefined
	);
	this.canBeActivated = (
		$.client.test( ve.init.mw.ViewPageTarget.compatibility ) ||
		'vewhitelist' in currentUri.query
	);
	this.active = false;
	this.activating = false;
	this.scrollTop = null;
	this.edited = false;
	this.surfaceOptions = {
		'toolbars': {
			'top': {
				'float': !this.isMobileDevice
			}
		}
	};
	this.$fakeToolbar = null;
	this.$document = null;
	this.surface = null;
	this.proxiedOnSurfaceModelTransact = ve.bind( this.onSurfaceModelTransact, this );
	this.$toolbarSaveButton =
		$( '<div class="ve-init-mw-viewPageTarget-toolbar-saveButton"></div>' );
	this.$toolbarCancelButton =
		$( '<div class="ve-init-mw-viewPageTarget-toolbar-cancelButton secondary"></div>' );
	this.$saveDialog =
		$( '<div class="ve-init-mw-viewPageTarget-saveDialog"></div>' );
	this.editSummaryByteLimit = 255;
	this.section = currentUri.query.vesection || null;
	this.viewUri = new mw.Uri( mw.util.wikiGetlink( this.pageName ) );
	this.veEditUri = this.viewUri.clone().extend( { 'veaction': 'edit' } );

	this.$disabledElements = $( '#WikiHeader, #WikiaPageHeader, #WikiaRail, #WikiaArticleCategories' );

	// Initialization
	if ( this.canBeActivated ) {
		this.setupEditLinks();
		if ( this.isViewPage ) {
			this.setupToolbarCancelButton();
			this.setupToolbarSaveButton();
			this.setupSaveDialog();
			if ( currentUri.query.veaction === 'edit' ) {
				$( ve.bind( this.activate, this ) );
			}
		} else {
			if ( !$.inArray( 'staff', wgUserGroups ) ) {
				$('#wpSave').hide();
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
		msie: false,
		firefox: [['>=', 11]],
		safari: [['>=', 5]],
		chrome: [['>=', 19]],
		opera: false,
		netscape: false,
		blackberry: false
	},
	// Right-to-left languages
	rtl: {
		msie: false,
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
		<button class="ve-init-mw-viewPageTarget-saveDialog-cancelButton secondary">\
			<span class="ve-init-mw-viewPageTarget-saveDialog-cancelButton-label"></span>\
		</button>\
		<div class="ve-init-mw-viewPageTarget-saveDialog-saving"></div>\
		<div style="clear: both;"></div>\
	</div>';

/* Methods */

/**
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.setupEditLinks = function () {
	// Edit button
	$( '#ca-edit' ).unbind('.ve').bind( 'click.ve', ve.bind( this.onEditButtonClick, this ) );

	// Section edit links
	$( '#mw-content-text .editsection a' ).unbind('.ve').bind( 'click.ve', ve.bind( this.onEditSectionLinkClick, this ) );
};

/**
 * Handles clicks on the edit button.
 *
 * @method
 * @param {jQuery.Event} e
 */
ve.init.mw.ViewPageTarget.prototype.onEditButtonClick = function ( e ) {
	this.track({
		action: WikiaTracker.ACTIONS.CLICK,
		label: 'edit-button'
	});

	this.activate();
	// Prevent the edit button's normal behavior
	e.preventDefault();
};

/**
 * Handles clicks on a section edit link.
 *
 * @method
 * @param {jQuery.Event} e
 */
ve.init.mw.ViewPageTarget.prototype.onEditSectionLinkClick = function ( e ) {
	this.track({
		action: WikiaTracker.ACTIONS.CLICK,
		label: 'edit-section-button'
	});

	this.saveEditSection( $( e.target ).closest( 'h1, h2, h3, h4, h5, h6' ).get( 0 ) );
	this.activate();
	// Prevent the edit tab's normal behavior
	e.preventDefault();
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
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.activate = function () {
	if ( !this.active && !this.activating ) {
		this.activating = true;

		GlobalNotification.hide();

		this.$fakeToolbar = $( '<div class="ve-init-mw-viewPageTarget-fakeToolbar"></div>' );
		this.$fakeToolbar.prependTo( '#WikiaArticle' );
		this.$fakeToolbar.slideDown();
		this.$fakeToolbar.startThrobbing();

		$.getResources($.getSassCommonURL('/extensions/VisualEditor/modules/ve/init/mw/styles/ve.init.mw.ViewPageTarget-oasis.scss'));

		this.hideTableOfContents();
		this.mutePageContent();
		this.saveScrollPosition();
		this.load();
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
 * Mutes the page content.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.mutePageContent = function () {
	// TODO: Decide if we need to addClass here - it is also done in hidePageContent()
	$( '#mw-content-text' ).fadeTo( 'fast', 0.35 );
	this.$disabledElements.fadeTo( 'fast', 0.35 ).each(function() {
		$(this).append( '<div class="oasis-interface-shield"></div>' );
	});
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
 * Handles successful DOM load event.
 *
 * @method
 * @param {HTMLElement} dom Parsed DOM from server
 */
ve.init.mw.ViewPageTarget.prototype.onLoad = function ( dom ) {
	this.track({
		action: WikiaTracker.ACTIONS.IMPRESSION,
		label: 'on-load'
	});

	this.edited = false;
	this.setUpSurface( dom );
	this.attachToolbarCancelButton();
	this.attachToolbarSaveButton();
	this.$toolbarWrapper = $( '.ve-ui-toolbar-wrapper' );
	this.attachSaveDialog();
	this.restoreScrollPosition();
	this.restoreEditSection();
	this.$document.focus();
	this.activating = false;

	var _this = this;
	$('.ve-ui-buttonTool, .ve-ui-dropdownTool').unbind( '.ve-tracking' ).bind( 'click.ve-tracking', function() {
		var	$button = $( this ),
			buttonTitle = $button.attr( 'title' );
		if ( buttonTitle ) {
			_this.track({
				action: WikiaTracker.ACTIONS.CLICK,
				label: 'button-' + buttonTitle
			});
		} else {
			_this.track({
				action: WikiaTracker.ACTIONS.IMPRESSION,
				label: 'button-tracking-problem'
			});
		}
	} );
};

/**
 * Switches to editing mode.
 *
 * @method
 * @param {HTMLElement} dom HTML DOM to edit
 */
ve.init.mw.ViewPageTarget.prototype.setUpSurface = function ( dom ) {
	var $contentText = $( '#mw-content-text' );
	this.surface = new ve.Surface( $( '#WikiaArticle' ), dom, this.surfaceOptions );
	this.$document = this.surface.$.find( '.ve-ce-documentNode' );
	this.surface.getModel().on( 'transact', this.proxiedOnSurfaceModelTransact );
	this.hidePageContent();
	this.$fakeToolbar.remove();
	this.$fakeToolbar = null;
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
 * Hides the page content.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.hidePageContent = function () {
	$( '#mw-content-text' ).hide();
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
 * Adds the save button to the user interface.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.attachToolbarSaveButton = function () {
	$( '.ve-ui-toolbar .ve-ui-actions' ).append( this.$toolbarSaveButton );
};

/**
 * Adds the cancel button to the user interface.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.attachToolbarCancelButton = function () {
	$( '.ve-ui-toolbar .ve-ui-actions' ).append( this.$toolbarCancelButton );
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
 * Adds content and event bindings to the cancel button.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.setupToolbarCancelButton = function () {
	this.$toolbarCancelButton
		.append(
			$( '<span class="ve-init-mw-viewPageTarget-toolbar-cancelButton-label"></span>' )
				.text( ve.msg( 'cancel' ) )
		)
		.on( {
			'mousedown': function ( e ) {
				$(this).addClass( 've-init-mw-viewPageTarget-toolbar-cancelButton-down' );
				e.preventDefault();
			},
			'mouseleave mouseup': function ( e ) {
				$(this).removeClass( 've-init-mw-viewPageTarget-toolbar-cancelButton-down' );
				e.preventDefault();
			},
			'click': ve.bind( this.onToolbarCancelButtonClick, this )
		} );
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
 * Handles clicks on the save button in the toolbar.
 *
 * @method
 * @param {jQuery.Event} e
 */
ve.init.mw.ViewPageTarget.prototype.onToolbarSaveButtonClick = function () {
	this.track({
		action: WikiaTracker.ACTIONS.CLICK,
		label: 'toolbar-save-button'
	});

	if ( this.edited ) {
		this.showSaveDialog();
	}
};

/**
 * Handles clicks on the cancel button in the toolbar.
 *
 * @method
 * @param {jQuery.Event} e
 */
ve.init.mw.ViewPageTarget.prototype.onToolbarCancelButtonClick = function () {
	this.track({
		action: WikiaTracker.ACTIONS.CLICK,
		label: 'toolbar-cancel-button'
	});

	this.deactivate();
};

/**
 * Shows the save dialog.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.showSaveDialog = function () {
	var viewPage = this;
	this.unlockSaveDialogSaveButton();
	//this.$saveDialogLoadingIcon.hide();
	this.$saveDialog.fadeIn( 'fast' ).find( 'textarea' ).eq( 0 ).focus();
	/*$( document ).on( 'keydown', function ( e ) {
		if ( e.which === 27 ) {
			viewPage.onSaveDialogCloseButtonClick();
		}
	});*/
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
		.find( '.ve-init-mw-viewPageTarget-saveDialog-cancelButton' )
			.on( {
				'mousedown': function () {
					$(this).addClass( 've-init-mw-viewPageTarget-saveDialog-cancelButton-down' );
				},
				'mouseleave mouseup': function () {
					$(this).removeClass( 've-init-mw-viewPageTarget-saveDialog-cancelButton-down' );
				},
				'click': ve.bind( viewPage.onSaveDialogCancelButtonClick, viewPage )
			} )
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
		.find( '.ve-init-mw-viewPageTarget-saveDialog-cancelButton-label' )
			.text( ve.msg( 'cancel' ) )
			.end()
		.find( '.ve-init-mw-viewPageTarget-saveDialog-saveButton-label' )
			.text( ve.msg( 'savearticle' ) )
			.end();
		/*
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
		*/
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
 * Disables the toolbar save button.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.disableToolbarSaveButton = function () {
	this.$toolbarSaveButton
		.addClass( 've-init-mw-viewPageTarget-toolbar-saveButton-disabled' );
};

/**
 * Handles clicks on the save button in the save dialog.
 *
 * @method
 * @param {jQuery.Event} e
 */
ve.init.mw.ViewPageTarget.prototype.onSaveDialogSaveButtonClick = function () {
	this.track({
		action: WikiaTracker.ACTIONS.CLICK,
		label: 'dialog-save-button'
	});

	this.lockSaveDialogSaveButton();
	//this.$saveDialogLoadingIcon.show();
	this.$saveDialog.startThrobbing();
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
 * Handles clicks on the cancel button in the save dialog.
 *
 * @method
 * @param {jQuery.Event} e
 */
ve.init.mw.ViewPageTarget.prototype.onSaveDialogCancelButtonClick = function () {
	this.track({
		action: WikiaTracker.ACTIONS.CLICK,
		label: 'dialog-cancel-button'
	});

	this.hideSaveDialog();
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
 * Handles successful DOM save event.
 *
 * @method
 * @param {HTMLElement} html Rendered HTML from server
 */
ve.init.mw.ViewPageTarget.prototype.onSave = function ( html ) {
	this.track({
		action: WikiaTracker.ACTIONS.IMPRESSION,
		label: 'on-save'
	});

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
		GlobalNotification.show( ve.msg( 'visualeditor-notification-saved', this.pageName ), "confirm" );
	}
};

/**
 * Hides the save dialog
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.hideSaveDialog = function () {
	this.$saveDialog.fadeOut( 'fast' ).stopThrobbing();
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
 * Replaces the page content with new HTML.
 *
 * @method
 * @param {HTMLElement} html Rendered HTML from server
 */
ve.init.mw.ViewPageTarget.prototype.replacePageContent = function ( html ) {
	$( '#mw-content-text' ).html( html );
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
			this.detachToolbarCancelButton();
			this.detachToolbarSaveButton();
			this.detachSaveDialog();
			this.tearDownSurface();
			this.showTableOfContents();
			this.deactivating = false;
		}
	}
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
 * Removes the cancel button from the user interface.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.detachToolbarCancelButton = function () {
	this.$toolbarCancelButton.detach();
};

/*
 * Removes the save dialog from the user interface.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.detachSaveDialog = function () {
	this.$saveDialog.detach();
};

/**
 * Switches to viewing mode.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.tearDownSurface = function () {
	// Update UI
	this.$document.blur();
	this.$document = null;
	this.surface.$.empty().detach();
	$( '.ve-ui-context' ).remove();
	this.detachToolbar();
	this.showPageContent();
	this.showTableOfContents();
	$('.oasis-interface-shield').remove();
	this.$disabledElements.fadeTo( 'fast', 1 );
	// Remove handler if it's still active
	this.surface.getModel().removeListener( 'transact', this.proxiedOnSurfaceModelTransact );
	// Destroy editor
	this.surface = null;
	this.active = false;
	this.setupEditLinks();
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
 * Shows the page content.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.showPageContent = function () {
	$( '#mw-content-text' ).show().fadeTo( 0, 1 );
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
 * Handles failed DOM load event.
 *
 * @method
 * @param {Object} data HTTP Response object
 * @param {String} status Text status message
 * @param {Mixed} error Thrown exception or HTTP error string
 */
ve.init.mw.ViewPageTarget.prototype.onLoadError = function ( response, status ) {
	this.track({
		action: WikiaTracker.ACTIONS.IMPRESSION,
		label: 'on-load-error'
	});

	if ( confirm( ve.msg( 'visualeditor-loadwarning', status ) ) ) {
		this.load();
	} else {
		this.activating = false;
		this.hideSpinner();
		this.showTableOfContents();
		this.showPageContent();
		$('.oasis-interface-shield').remove();
		this.$disabledElements.fadeTo( 'fast', 1 );
		this.$fakeToolbar.remove();
		this.$fakeToolbar = null;
	}
};

/**
 * Hides the loading spinner.
 *
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.hideSpinner = function () {
	// Not implemented yet
};

ve.init.mw.ViewPageTarget.prototype.track = window.WikiaTracker.buildTrackingFunction({
	category: 'visual-editor',
	trackingMethod: 'both'
});

/* Initialization */

ve.init.mw.targets.push( new ve.init.mw.ViewPageTarget() );
