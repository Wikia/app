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

	// Initialization
	if ( this.canBeActivated ) {
		this.setupEditLinks();
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

		var $fakeToolbar = $( '<div class="ve-init-mw-viewPageTarget-fakeToolbar"></div>' );
		$fakeToolbar.prependTo( '#WikiaArticle' );
		$fakeToolbar.slideDown();

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
	$( '#WikiaArticle > :visible:not(#siteSub, #contentSub)' )
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
	alert(123);
};

/* Initialization */

ve.init.mw.targets.push( new ve.init.mw.ViewPageTarget() );
