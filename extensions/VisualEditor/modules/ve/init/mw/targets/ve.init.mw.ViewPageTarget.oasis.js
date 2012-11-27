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

	// Initialization
	if ( this.canBeActivated ) {
		this.setupEditLinks();
		if ( this.isViewPage ) {
			this.setupToolbarSaveButton();
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
	$( '#mw-content-text' )
		.children()
		.addClass( 've-init-mw-viewPageTarget-content' )
		.fadeTo( 'fast', 0.6 );
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
	$( '#mw-content-text' )
		.children()
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

/* Initialization */

ve.init.mw.targets.push( new ve.init.mw.ViewPageTarget() );
