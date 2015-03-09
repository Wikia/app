/*!
 * VisualEditor user interface WikiaSingleMediaDialog class.
 */

/* global mw */

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

ve.ui.WikiaSingleMediaDialog.static.title = OO.ui.deferMsg( 'wikia-visualeditor-dialog-wikiasinglemedia-title' );

ve.ui.WikiaSingleMediaDialog.static.icon = 'gallery';

/* Methods */

ve.ui.WikiaSingleMediaDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.WikiaSingleMediaDialog.super.prototype.initialize.call( this );

	// Properties
	this.mode = {
		'action': 'insert',
		'type': 'photo'
	};
	this.query = new ve.ui.WikiaSingleMediaQueryWidget( {
		'$': this.$,
		'placeholder': ve.msg( 'wikia-visualeditor-dialog-wikiasinglemedia-search' )
	} );
	this.queryInput = this.query.getInput();
	this.$main = this.$( '<div>' )
		.addClass( 've-ui-wikiaSingleMediaDialog-main' );
	this.search = new ve.ui.WikiaMediaResultsWidget( { '$': this.$ } );
	this.results = this.search.getResults();
	this.cartModel = new ve.dm.WikiaCart();
	this.cart = new ve.ui.WikiaSingleMediaCartWidget( this.cartModel, this );
	this.mediaPreview = new ve.ui.WikiaMediaPreviewWidget();

	// Foot elements
	this.$policy = this.$( '<div>' )
		.addClass( 've-ui-wikiaSingleMediaDialog-policy' );
	this.$policyInner = this.$( '<div>' )
		.addClass( 've-ui-wikiaSingleMediaDialog-policyInner' )
		.html( ve.msg( 'wikia-visualeditor-media-' + this.mode.type + '-policy' ) );
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
	this.cartModel.connect( this, {
		'add': 'onCartModelAdd',
		'remove': 'onCartModelRemove',
		'change': 'onCartModelChange'
	} );
	this.query.connect( this, {
		'requestMediaDone': 'onQueryRequestMediaDone'
	} );
	this.search.connect( this, {
		'nearingEnd': 'onSearchNearingEnd',
		'check': 'handleChoose',
		'select': 'handleChoose',
		'metadata': 'handlePreview',
		'label': 'handlePreview'
	} );
	this.queryInput.connect( this, {
		'change': 'onQueryInputChange'
	} );
	this.insertButton.connect( this, { 'click': [ 'close', { 'action': 'insert' } ] } );
	this.queryInput.$input.on( 'keydown', ve.bind( this.onQueryInputKeydown, this ) );
	this.cancelButton.connect( this, { 'click': 'onCancelButtonClick' } );

	// Initialization
	this.frame.$content.addClass( 've-ui-wikiaSingleMediaDialog ve-ui-wikiaSingleMediaDialog-hide-cart-controls' );
	this.$main.append( this.search.$element, this.cart.$element );

	this.$policy.append( this.$policyInner );
	this.$body.append( this.query.$element, this.$main );
	this.$foot.append( this.insertButton.$element, this.cancelButton.$element, this.$policy );
	this.surface.getGlobalOverlay().append( this.mediaPreview.$element );

	this.setLayout( 'grid' );
};

ve.ui.WikiaSingleMediaDialog.prototype.onQueryInputKeydown =
	OO.ui.SearchWidget.prototype.onQueryKeydown;

/**
 * @inheritdoc
 */
ve.ui.WikiaSingleMediaDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.WikiaSingleMediaDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			// TODO: Ultimetly this should work without setTimeout. It seems to be fixed in the
			// upstream so should be revisited after upstream sync.
			this.insertButton.setDisabled( true );
			setTimeout( ve.bind( function () {
				this.query.input.focus().select();
			}, this ), 100 );
		}, this );
};

/**
 * Handle closing the dialog.
 *
 * @method
 * @param {string} action Which action is being performed on close.
 */
ve.ui.WikiaSingleMediaDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.WikiaSingleMediaDialog.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			if ( data.action === 'insert' ) {
				if ( mw.config.get( 'wgEnableMediaGalleryExt' ) ) {
					this.insertWikiaGallery();
				} else {
					this.insertMWGallery();
				}

				// Tracking
				ve.track( 'wikia', {
					'action': ve.track.actions.ADD,
					'label': 'dialog-wikia-single-media-insert-' + this.mode.type,
					'value': this.cartModel.getItems().length
				} );
			}
			this.cartModel.clearItems();
			this.queryInput.setValue( '' );
		}, this );
};

ve.ui.WikiaSingleMediaDialog.prototype.insertMWGallery = function () {
	var i, mwData, wt = [], items = this.cartModel.getItems();

	mwData = {
		'name': 'gallery',
		'attrs': {},
		'body': {}
	};

	for ( i = 0; i < items.length; i++ ) {
		wt.push( items[i].title );
	}

	mwData.body.extsrc = '\n' + wt.join( '\n' ) + '\n';

	this.fragment.collapseRangeToEnd().insertContent( [
		{
			'type': 'mwGallery',
			'attributes': {
				'mw': mwData
			}
		},
		{ 'type': '/mwGallery' }
	] );
};

ve.ui.WikiaSingleMediaDialog.prototype.insertWikiaGallery = function () {
	var i, linmod = [], items = this.cartModel.getItems();

	// Gallery opening
	linmod.push( {
		'type': 'wikiaGallery',
		'attributes': {
			'expand': false,
			'mw': {
				'name': 'gallery'
			}
		}
	} );

	if ( items.length > 0 ) {
		linmod.push( {
			'type': 'alien',
			'attributes': {
				'domElements': $( '<meta typeof="mw:Placeholder" data-parsoid="{&quot;src&quot;:&quot;&quot;}" />' ).toArray()
			}
		} );
		linmod.push( { 'type': '/alien' } );

		for ( i = 0; i < items.length; i++ ) {
			linmod.push( {
				'type': 'wikiaGalleryItem',
				'attributes': {
					'type': 'thumb',
					'align': 'none',
					'href': './' + 'File:' + items[i].title,
					'src': items[i].url,
					'resource': './' + 'File:' + items[i].title,
					'defaultSize': true
				}
			} );
			linmod.push( {
				'type': '/wikiaGalleryItem'
			} );
		}

		linmod.push( {
			'type': 'alien',
			'attributes': {
				'domElements': $( '<meta typeof="mw:Placeholder" data-parsoid="{&quot;src&quot;:&quot;&quot;}" />' ).toArray()
			}
		} );
		linmod.push( { 'type': '/alien' } );
	}

	// Gallery closing
	linmod.push( {
		'type': '/wikiaGallery'
	} );

	this.fragment.collapseRangeToEnd().insertContent( linmod );
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
	this.layout = layout;
	this.emit( 'layout', layout );
};

/*
 * Gets value of this.layout
 */
ve.ui.WikiaSingleMediaDialog.prototype.getLayout = function () {
	return this.layout;
};

/**
 * Handle the resulting data from a query media request.
 *
 * @method
 * @param {Object} items An object containing items to add to the search results
 */
ve.ui.WikiaSingleMediaDialog.prototype.onQueryRequestMediaDone = function ( items ) {
	this.search.addItems( items );
	this.results.setChecked( this.cartModel.getItems(), true );
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

/**
 * Handle choice of items in search results.
 *
 * @method
 * @param {Object} item The search result item.
 */
ve.ui.WikiaSingleMediaDialog.prototype.handleChoose = function ( item ) {
	var data = item.getData(),
		items = this.cartModel.getItems(),
		i;
	for ( i = 0; i < items.length; i++ ) {
		if ( data.title === items[i].getId() ) {
			this.cartModel.removeItems( [ items[i] ] );
			return;
		}
	}
	this.cartModel.addItems( [ new ve.dm.WikiaImageCartItem(
		data.title,
		data.url
	) ], 0 );
};

/**
 * Handle showing the media preview
 *
 * @method
 * @param {ve.ui.WikiaMediaOptionWidget} item Item to preview
 * @param {jQuery.Event} event jQuery Event
 */
ve.ui.WikiaSingleMediaDialog.prototype.handlePreview = function ( item, event ) {
	var data = item.getData();

	if ( data.type === 'photo' ) {
		this.mediaPreview.openForImage( data.title, data.url );
	}

	event.stopPropagation();
};

/**
 * Handle query input changes.
 *
 * @method
 */
ve.ui.WikiaSingleMediaDialog.prototype.onQueryInputChange = function () {
	this.results.clearItems();
	if ( this.getLayout() === 'list' ) {
		this.setLayout( 'grid' );
	}
};

/**
 * Handle adding items to the cart model.
 *
 * @method
 * @param {ve.dm.WikiaCartItem[]} items Cart models
 */
ve.ui.WikiaSingleMediaDialog.prototype.onCartModelAdd = function ( items ) {
	this.results.setChecked( items, true );
};

/**
 * Handle removing items from the cart model.
 *
 * @method
 * @param {ve.dm.WikiaCartItem[]} items
 */
ve.ui.WikiaSingleMediaDialog.prototype.onCartModelRemove = function ( items ) {
	this.results.setChecked( items, false );
};

/**
 * Handle any change to the cart model
 *
 * @method
 */
ve.ui.WikiaSingleMediaDialog.prototype.onCartModelChange = function () {
	this.insertButton.setDisabled( ( this.cartModel.getItems().length ) ? false : true );
};

/**
 * Handles action when clicking cancel button
 *
 * @method
 */
ve.ui.WikiaSingleMediaDialog.prototype.onCancelButtonClick = function () {
	this.close( { 'action': 'cancel' } );

	ve.track( 'wikia', {
		'action': ve.track.actions.CLICK,
		'label': 'dialog-wikia-single-media-button-cancel'
	} );
};

/**
 * Overrides parent method in order to handle escape key differently
 *
 * @method
 * @param {jQuery.Event} e The jQuery event Object.
 */
ve.ui.WikiaSingleMediaDialog.prototype.onFrameDocumentKeyDown = function ( e ) {
	if ( e.which === OO.ui.Keys.ESCAPE && this.mediaPreview.isOpen() ) {
		this.mediaPreview.close();
		return false; // stop propagation
	}
	ve.ui.Dialog.prototype.onFrameDocumentKeyDown.call( this, e );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaSingleMediaDialog );
