/*!
 * VisualEditor user interface WikiaSingleMediaDialog class.
 */

/**
 * Dialog for inserting MediaWiki media objects.
 *
 * @class
 * @extends ve.ui.FragmentDialog
 *
 * @constructor
 * @param {Object} [config] Config options
 */
ve.ui.WikiaSingleMediaDialog = function VeUiWikiaSingleMediaDialog( config ) {
	// Parent constructor
	ve.ui.WikiaSingleMediaDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaSingleMediaDialog, ve.ui.FragmentDialog );

/* Static Properties */

ve.ui.WikiaSingleMediaDialog.static.name = 'wikiaSingleMedia';

ve.ui.WikiaSingleMediaDialog.static.title = OO.ui.deferMsg( 'wikia-visualeditor-dialog-wikiasinglemedia-title' );

// as in OO.ui.WindowManager.static.sizes
ve.ui.WikiaSingleMediaDialog.static.size = '712px';

ve.ui.WikiaSingleMediaDialog.static.actions = [
	{
		action: 'apply',
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-apply' ),
		flags: [ 'progressive', 'primary' ]
	}
];

/* Methods */

ve.ui.WikiaSingleMediaDialog.prototype.getActionProcess = function ( action ) {
	if ( action === 'apply' ) {
		return new OO.ui.Process( function () {
			if ( mw.config.get( 'wgEnableMediaGalleryExt' ) ) {
				this.insertWikiaGallery();
			} else {
				this.insertMWGallery();
			}
			this.close( { action: action } );
		}, this );
	}
	return ve.ui.WikiaSingleMediaDialog.super.prototype.getActionProcess.call( this, action );
};

ve.ui.WikiaSingleMediaDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.WikiaSingleMediaDialog.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			this.cartModel.clearItems();
			this.queryInput.setValue( '' );
		}, this );
};

ve.ui.WikiaSingleMediaDialog.prototype.insertMWGallery = function () {
	var i, mwData, wt = [], items = this.cartModel.getItems();

	mwData = {
		name: 'gallery',
		attrs: {},
		body: {}
	};

	for ( i = 0; i < items.length; i++ ) {
		wt.push( items[i].title );
	}

	mwData.body.extsrc = '\n' + wt.join( '\n' ) + '\n';

	this.fragment.collapseToEnd().insertContent( [
		{
			type: 'mwGallery',
			attributes: {
				mw: mwData
			}
		},
		{ type: '/mwGallery' }
	] );
};

ve.ui.WikiaSingleMediaDialog.prototype.insertWikiaGallery = function () {
	var i, linmod = [], items = this.cartModel.getItems();

	// Gallery opening
	linmod.push( {
		type: 'wikiaGallery',
		attributes: {
			expand: false,
			mw: {
				name: 'gallery'
			}
		}
	} );

	if ( items.length > 0 ) {
		linmod.push( {
			type: 'alien',
			attributes: {
				domElements: $( '<meta typeof="mw:Placeholder" data-parsoid="{&quot;src&quot;:&quot;&quot;}" />' ).toArray()
			}
		} );
		linmod.push( { type: '/alien' } );

		for ( i = 0; i < items.length; i++ ) {
			linmod.push( {
				type: 'wikiaGalleryItem',
				attributes: {
					type: 'thumb',
					align: 'none',
					href: './' + 'File:' + items[i].title,
					src: items[i].url,
					resource: './' + 'File:' + items[i].title,
					defaultSize: true
				}
			} );
			linmod.push( {
				type: '/wikiaGalleryItem'
			} );
		}

		linmod.push( {
			type: 'alien',
			attributes: {
				domElements: $( '<meta typeof="mw:Placeholder" data-parsoid="{&quot;src&quot;:&quot;&quot;}" />' ).toArray()
			}
		} );
		linmod.push( { type: '/alien' } );
	}

	// Gallery closing
	linmod.push( {
		type: '/wikiaGallery'
	} );

	this.fragment.collapseToEnd().insertContent( linmod );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaSingleMediaDialog.prototype.getBodyHeight = function () {
	return 600;
};

/**
 * @inheritdoc
 */
ve.ui.WikiaSingleMediaDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.WikiaSingleMediaDialog.super.prototype.initialize.call( this );

	// Properties
	this.mode = {
		action: 'insert',
		type: 'photo'
	};
	this.query = new ve.ui.WikiaSingleMediaQueryWidget( {
		$: this.$,
		placeholder: ve.msg( 'wikia-visualeditor-dialog-wikiasinglemedia-search' )
	} );
	this.queryInput = this.query.getInput();
	this.$main = this.$( '<div>' )
		.addClass( 've-ui-wikiaSingleMediaDialog-main' );
	this.search = new ve.ui.WikiaMediaResultsWidget( { $: this.$ } );
	this.results = this.search.getResults();
	this.cartModel = new ve.dm.WikiaCart();
	this.cart = new ve.ui.WikiaSingleMediaCartWidget( this.cartModel, this );
	this.mediaPreview = new ve.ui.WikiaMediaPreviewWidget();

	// Events
	this.cart.connect( this, { layout: 'setLayout' } );
	this.cartModel.connect( this, {
		add: 'onCartModelAdd',
		remove: 'onCartModelRemove'
	} );
	this.query.connect( this, {
		requestMediaDone: 'onQueryRequestMediaDone'
	} );
	this.search.connect( this, {
		nearingEnd: 'onSearchNearingEnd',
		check: 'handleChoose',
		select: 'handleChoose',
		metadata: 'handlePreview',
		label: 'handlePreview'
	} );
	this.queryInput.connect( this, {
		change: 'onQueryInputChange'
	} );
	this.queryInput.$input.on( 'keydown', this.onQueryInputKeydown.bind( this ) );

	// Initialization
	this.$content.addClass( 've-ui-wikiaSingleMediaDialog ve-ui-wikiaSingleMediaDialog-hide-cart-controls' );
	this.$main.append( this.search.$element, this.cart.$element );
	this.$body.append( this.query.$element, this.$main );
	this.$overlay.append( this.mediaPreview.$element );

	this.setLayout( 'grid' );
};

ve.ui.WikiaSingleMediaDialog.prototype.onQueryInputKeydown =
	OO.ui.SearchWidget.prototype.onQueryKeydown;

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

ve.ui.windowFactory.register( ve.ui.WikiaSingleMediaDialog );
