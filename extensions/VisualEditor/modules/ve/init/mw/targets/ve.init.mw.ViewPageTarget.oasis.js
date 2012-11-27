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
	this.$saveDialog =
		$( '<div class="ve-init-mw-viewPageTarget-saveDialog"></div>' );
	this.editSummaryByteLimit = 255;

	// Initialization
	if ( this.canBeActivated ) {
		this.setupEditLinks();
		if ( this.isViewPage ) {
			this.setupToolbarSaveButton();
			this.setupSaveDialog();
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
		<div class="ve-init-mw-viewPageTarget-saveDialog-saving"></div>\
		<div style="clear: both;"></div>\
	</div>\
	<div class="ve-init-mw-viewPageTarget-saveDialog-foot">\
		<p class="ve-init-mw-viewPageTarget-saveDialog-license"></p>\
	</div>';

/* Methods */

/**
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.setupEditLinks = function () {
	$( '#ca-edit' ).click( ve.bind( this.onEditButtonClick, this ) );
};

/**
 * Handles clicks on the edit button.
 *
 * @method
 * @param {jQuery.Event} e
 */
ve.init.mw.ViewPageTarget.prototype.onEditButtonClick = function ( e ) {
	this.activate();
	// Prevent the edit button's normal behavior
	e.preventDefault();
};

/**
 * @method
 */
ve.init.mw.ViewPageTarget.prototype.activate = function () {
	if ( !this.active && !this.activating ) {
		this.activating = true;

		this.$fakeToolbar = $( '<div class="ve-init-mw-viewPageTarget-fakeToolbar"></div>' );
		this.$fakeToolbar.prependTo( '#WikiaArticle' );
		this.$fakeToolbar.slideDown();

		$.getResources($.getSassCommonURL('/extensions/VisualEditor/modules/ve/init/mw/styles/ve.init.mw.ViewPageTarget-oasis.scss'));

		// TODO: show spinner

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
	$( '#mw-content-text' )
		.addClass( 've-init-mw-viewPageTarget-content' )
		.fadeTo( 'fast', 0.6 );
	$( '#WikiHeader, #WikiaPageHeader, #WikiaRail' ).fadeTo( 'fast', 0.6 ).each(function() {
		var shield = $('<div class="oasis-interface-shield"></div>');
		shield.offset( $(this).offset() );
		shield.css({
			'height': $(this).outerHeight(),
			'width': $(this).outerWidth()
		});
		$('body').append(shield);
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
	this.edited = false;
	this.setUpSurface( dom );
	this.attachToolbarSaveButton();
	this.$toolbarWrapper = $( '.ve-ui-toolbar-wrapper' );
	this.attachSaveDialog();
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
	// TODO: Decide if we need to addClass here - it is also done in mutePageContent()
	$( '#mw-content-text' )
		.addClass( 've-init-mw-viewPageTarget-content' )
		.hide();
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
	if ( this.edited ) {
		this.showSaveDialog();
	}
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
	this.lockSaveDialogSaveButton();
	//this.$saveDialogLoadingIcon.show();
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

/* Initialization */

ve.init.mw.targets.push( new ve.init.mw.ViewPageTarget() );
