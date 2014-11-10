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

ve.ui.WikiaSingleMediaDialog.static.title = OO.ui.deferMsg( 'visualeditor-dialog-media-insert-title' );

ve.ui.WikiaSingleMediaDialog.static.icon = 'media';

/* Methods */

ve.ui.WikiaSingleMediaDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.WikiaSingleMediaDialog.super.prototype.initialize.call( this );

	// Search
	this.query = new ve.ui.WikiaSingleMediaQueryWidget( {
		'$': this.$,
		'placeholder': 'Search for images' //TODO: i18n
	} );

	// Pages
	this.mainLayout = new OO.ui.StackLayout( {
		'$': this.$,
		'continuous': true
	} );
	this.$leftSide = this.$( '<div>' )
		.addClass( 've-ui-wikiaSingleMediaDialog-leftSide' )
		.html('test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test');
	this.$rightSide = this.$( '<div>' )
		.addClass( 've-ui-wikiaSingleMediaDialog-rightSide' )
		.html('test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test');
	this.$cartControls = this.$( '<div>' )
		.addClass( 've-ui-wikiaSingleMediaDialog-cartControls' );
	this.$cartViewButtons = this.$( '<div>' )
		.addClass( 've-ui-wikiaSingleMediaDialog-cartToggle' );
	this.cartGridButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'frameless': true,
		'icon': 'cart-grid',
		'classes': [ 've-ui-wikiaSingleMediaDialog-cartGridButton' ]
	} );
	this.cartListButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'frameless': true,
		'icon': 'cart-list',
		'classes': [ 've-ui-wikiaSingleMediaDialog-cartListButton' ]
	} );
	this.$cartControls.append( this.$cartViewButtons.append( [
		this.cartGridButton.$element,
		this.cartListButton.$element
	] ) );
	this.resultsPage = new OO.ui.PageLayout( 'results', { '$content': this.$leftSide } );
	this.cartPage = new OO.ui.PageLayout( 'cart', { '$content': [ this.$cartControls, this.$rightSide ] } );

	// Foot elements
	this.$policy = this.$( '<div>' )
		.addClass( 've-ui-wikiaSingleMediaDialog-policy' );
	this.$policyInner = this.$( '<div>' )
		.addClass( 've-ui-wikiaSingleMediaDialog-policyInner' )
		.html('This is the image policy that has been decided on by this commmunity. Do not upload any photos of kitties or puppies because that is not what this wiki is about and it is played out anyway.');
	this.insertButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'label': 'Done', //TODO: i18n
		'flags': ['primary']
	} );
	this.cancelButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'label': 'Cancel', //TODO: i18n
		'flags': ['secondary']
	} );

	// Events
	this.cartGridButton.connect( this, { 'click': [ this.setLayout, 'grid' ] } );
	this.cartListButton.connect( this, { 'click': [ this.setLayout, 'list' ] } );

	// Initialization
	this.resultsPage.$element.addClass( 've-ui-wikiaSingleMediaDialog-resultsPage' );
	this.cartPage.$element.addClass( 've-ui-wikiaSingleMediaDialog-cartPage' );
	this.mainLayout.$element.addClass( 've-ui-wikiaSingleMediaDialog-mainLayout' );
	this.frame.$content.addClass( 've-ui-wikiaSingleMediaDialog' );

	this.mainLayout.addItems( [ this.resultsPage, this.cartPage ] );

	this.$policy.append( this.$policyInner );
	this.$body.append( this.query.$element, this.mainLayout.$element );
	this.$foot.append( this.insertButton.$element, this.cancelButton.$element, this.$policy );

	this.setLayout( 'grid' );
};

ve.ui.WikiaSingleMediaDialog.prototype.setLayout = function ( option ) {
	if ( option === 'grid' ) {
		this.mainLayout.$element.css( 'left', 0 );
		this.cartGridButton.setActive( true );
		this.cartListButton.setActive( false );
	} else if ( option === 'list' ) {
		this.mainLayout.$element.css( 'left', -552 );
		this.cartGridButton.setActive( false );
		this.cartListButton.setActive( true );
	}
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaSingleMediaDialog );
