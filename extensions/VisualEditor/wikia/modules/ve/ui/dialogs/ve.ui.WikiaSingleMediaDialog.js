/*!
 * VisualEditor user interface WikiaSingleMediaDialog class.
 */

/**
 * Dialog for inserting MediaWiki media objects.
 *
 * @class
 * @extends ve.ui.Dialog
 *
 * @constructor
 * @param {Object} [config] Config options
 */
ve.ui.WikiaSingleMediaDialog = function VeUiWikiaSingleMediaDialog( config ) {
	config =  $.extend( config, {
		width: '712px'
	} );

	// Parent constructor
	ve.ui.WikiaSingleMediaDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaSingleMediaDialog, ve.ui.Dialog );

/* Static Properties */

ve.ui.WikiaSingleMediaDialog.static.name = 'wikiaSingleMedia';

ve.ui.WikiaSingleMediaDialog.static.title = OO.ui.deferMsg( 'visualeditor-dialog-wikiasinglemedia-title' );

ve.ui.WikiaSingleMediaDialog.static.icon = 'gallery';

/* Methods */

ve.ui.WikiaSingleMediaDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.WikiaSingleMediaDialog.super.prototype.initialize.call( this );

	// Properties
	this.query = new ve.ui.WikiaSingleMediaQueryWidget( {
		'$': this.$,
		'placeholder': ve.msg( 'visualeditor-dialog-wikiasinglemedia-search' )
	} );
	this.queryInput = this.query.getInput();
	this.search = new ve.ui.WikiaMediaResultsWidget( { '$': this.$ } );
	this.results = this.search.getResults();

	// Main panels
	this.$main = this.$( '<div>' )
		.addClass( 've-ui-wikiaSingleMediaDialog-main' );
	this.$leftSide = this.$( '<div>' )
		.addClass( 've-ui-wikiaSingleMediaDialog-leftSide' )
		.append( this.search.$element );
	this.cart = new ve.ui.WikiaSingleMediaCartWidget( { 'dialog': this } );

	// Foot elements
	this.$policy = this.$( '<div>' )
		.addClass( 've-ui-wikiaSingleMediaDialog-policy' );
	this.$policyInner = this.$( '<div>' )
		.addClass( 've-ui-wikiaSingleMediaDialog-policyInner' )
		.html('This is the image policy that has been decided on by this commmunity. Do not upload any photos of kitties or puppies because that is not what this wiki is about and it is played out anyway.');
	this.insertButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'label': ve.msg( 'wikia-visualeditor-dialog-done-button' ),
		'flags': ['primary']
	} );
	this.cancelButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'label': ve.msg( 'wikia-visualeditor-dialog-cancel-button' ),
		'flags': ['secondary']
	} );

	// Events
	this.cart.connect( this, { 'layout': 'setLayout' } );
	this.query.connect( this, {
		'requestMediaDone': 'onQueryRequestMediaDone'
	} );
	this.search.connect( this, {
		'nearingEnd': 'onSearchNearingEnd',
	} );

	// Initialization
	this.frame.$content.addClass( 've-ui-wikiaSingleMediaDialog' );
	this.$main.append( this.$leftSide, this.cart.$element );

	this.$policy.append( this.$policyInner );
	this.$body.append( this.query.$element, this.$main );
	this.$foot.append( this.insertButton.$element, this.cancelButton.$element, this.$policy );

	this.setLayout( 'grid' );
};

/*
 * Sets layout between list and grid.
 *
 * @param {string} layout Either 'list' or 'grid'.
 */
ve.ui.WikiaSingleMediaDialog.prototype.setLayout = function ( layout ) {
	if ( layout === 'grid' ) {
		this.$main.css( 'left', 0 );
	} else if ( layout === 'list' ) {
		this.$main.css( 'left', -552 );
	}
	this.emit( 'layout', layout );
};

/**
 * Handle the resulting data from a query media request.
 *
 * @method
 * @param {Object} items An object containing items to add to the search results
 */
ve.ui.WikiaSingleMediaDialog.prototype.onQueryRequestMediaDone = function ( items ) {
	this.search.addItems( items );
};

/**
 * Handle nearing the end of search results.
 *
 * @method
 */
ve.ui.WikiaSingleMediaDialog.prototype.onSearchNearingEnd = function () {
	if ( !this.queryInput.isPending() ) {
		this.query.requestMedia();
	}
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaSingleMediaDialog );
