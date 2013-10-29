/*!
 * VisualEditor user interface WikiaMediaInsertDialog class.
 */

/*global mw*/

/**
 * Dialog for inserting MediaWiki media objects.
 *
 * @class
 * @extends ve.ui.MWDialog
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Config options
 */
ve.ui.WikiaMediaInsertDialog = function VeUiMWMediaInsertDialog( surface, config ) {
	// Parent constructor
	ve.ui.MWDialog.call( this, surface, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaInsertDialog, ve.ui.MWDialog );

/* Static Properties */

ve.ui.WikiaMediaInsertDialog.static.name = 'wikiaMediaInsert';

ve.ui.WikiaMediaInsertDialog.static.titleMessage = 'visualeditor-dialog-media-insert-title';

ve.ui.WikiaMediaInsertDialog.static.icon = 'media';

ve.ui.WikiaMediaInsertDialog.static.pages = [ 'search', 'suggestions' ];

/* Methods */

/**
 * Initialize the dialog.
 *
 * @method
 */
ve.ui.WikiaMediaInsertDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWDialog.prototype.initialize.call( this );

	// Properties
	this.cartModel = new ve.dm.WikiaCart();
	this.cart = new ve.ui.WikiaCartWidget( this.cartModel );
	this.insertButton = new ve.ui.ButtonWidget( {
		'$$': this.$$,
		'label': ve.msg( 'visualeditor-wikiamediainsertbuttontool-label' ),
		'flags': ['primary']
	} );
	this.insertionDetails = {};
	this.pages = new ve.ui.PagedLayout( { '$$': this.frame.$$, 'attachPagesPanel': true } );
	this.query = new ve.ui.WikiaMediaQueryWidget( { '$$': this.frame.$$ } );
	this.queryInput = this.query.getInput();
	this.queryUpload = this.query.getUpload();
	this.search = new ve.ui.WikiaMediaResultsWidget( { '$$': this.frame.$$ } );
	this.searchResults = this.search.getResults();
	this.upload = new ve.ui.WikiaUploadWidget( { '$$': this.frame.$$, 'hideIcon': true } );

	this.$cart = this.$$( '<div>' );
	this.$content = this.$$( '<div>' );
	this.$mainPage = this.$$( '<div>' );

	// Events
	this.cartModel.on( 'add', ve.bind( this.onCartAdd, this ) );
	this.cart.on( 'select', ve.bind( this.onCartSelect, this ) );
	this.insertButton.connect( this, { 'click': [ 'close', 'insert' ] } );
	this.pages.on( 'set', ve.bind( this.onPageSet, this ) );
	this.query.connect( this, {
		'requestSearchDone': 'onQueryRequestSearchDone',
		'requestVideoDone': 'onQueryRequestVideoDone'
	} );
	this.queryInput.connect( this, {
		'change': 'onQueryInputChange',
		'enter': 'onQueryInputEnter'
	} );
	this.queryInput.$input.on( 'keydown', ve.bind( this.onQueryInputKeydown, this ) );
	this.search.connect( this, {
		'nearingEnd': 'onSearchNearingEnd',
		'select': 'onSearchSelect'
	} );
	this.upload.on( 'upload', ve.bind( this.onUploadSuccess, this ) );
	this.queryUpload.on( 'upload', ve.bind( this.onUploadSuccess, this ) );

	// Initialization
	this.upload.$.appendTo( this.$mainPage );
	this.pages.addPage( 'main', { '$content': this.$mainPage } );
	this.pages.addPage( 'search', { '$content': this.search.$ } );

	this.$cart
		.addClass( 've-ui-wikiaCartWidget-wrapper' )
		.append( this.cart.$ );
	this.$content
		.addClass( 've-ui-wikiaMediaInsertDialog-content' )
		.append( this.query.$, this.pages.$ );

	this.$body.append( this.$content, this.$cart );
	this.frame.$content.addClass( 've-ui-wikiaMediaInsertDialog' );
	this.$foot.append( this.insertButton.$ );
};

/**
 * Handle query input changes.
 *
 * @method
 * @param {string} value The query input value
 */
ve.ui.WikiaMediaInsertDialog.prototype.onQueryInputChange = function ( value ) {
	this.searchResults.clearItems();
	if ( value.trim().length === 0 ) {
		this.pages.setPage( 'main' );
	}
};

/**
 * Handle pressing the enter key inside the query input.
 *
 * @method
 */
ve.ui.WikiaMediaInsertDialog.prototype.onQueryInputEnter = function () {
	this.searchResults.selectItem( this.searchResults.getHighlightedItem() );
};

/**
 * Handle key up/down for selecting result items.
 * Copied from ve.ui.SearchWidget.js
 *
 * @method
 * @param {jQuery.Event} e The jQuery event Object.
 */
ve.ui.WikiaMediaInsertDialog.prototype.onQueryInputKeydown = function ( e ) {
	var highlightedItem, nextItem,
		dir = e.which === ve.Keys.DOWN ? 1 : ( e.which === ve.Keys.UP ? -1 : 0 );

	if ( dir ) {
		highlightedItem = this.searchResults.getHighlightedItem();
		if ( !highlightedItem ) {
			highlightedItem = this.searchResults.getSelectedItem();
		}
		nextItem = this.searchResults.getRelativeSelectableItem( highlightedItem, dir );
		this.searchResults.highlightItem( nextItem );
		nextItem.scrollElementIntoView();
	}
};

/**
 * Handle the resulting data from a query media request.
 *
 * @method
 * @param {Object} items An object containing items to add to the search results
 */
ve.ui.WikiaMediaInsertDialog.prototype.onQueryRequestSearchDone = function ( items ) {
	// TODO: handle filtering search results to show what's in the cart already
	this.search.addItems( items );
	this.pages.setPage( 'search' );
};

ve.ui.WikiaMediaInsertDialog.prototype.onQueryRequestVideoDone = function ( data ) {
	this.queryInput.setValue( '' );
	this.cartModel.addItems( [
		new ve.dm.WikiaCartItem( data.title, data.temporaryThumbUrl, 'video', data.temporaryFileName )
	] );
	this.setPage( data.title );
};

/**
 * Handle nearing the end of search results.
 *
 * @method
 */
ve.ui.WikiaMediaInsertDialog.prototype.onSearchNearingEnd = function () {
	if ( !this.queryInput.isPending() ) {
		this.query.requestMedia();
	}
};

/**
 * Handle clicking on search result items.
 *
 * @method
 * @param {Object} item The search result item data.
 */
ve.ui.WikiaMediaInsertDialog.prototype.onSearchSelect = function ( item ) {
	var cartItemModel, cartItems, i;
	if ( item === null ) {
		return;
	}

	// Remove item from cart if it already exists
	// TODO: why is this necessary? Can't we just not add?
	cartItems = ve.copy( this.cartModel.getItems() );
	for ( i = 0; i < cartItems.length; i++ ) {
		if ( cartItems[i].title === item.title ) {
			this.cartModel.removeItems( [ cartItems[i] ] );
		}
	}

	// Add item to cart
	cartItemModel = new ve.dm.WikiaCartItem( item.title, item.url, item.type );
	this.cartModel.addItems( [ cartItemModel ] );
};

/**
 * Handle clicking on cart items.
 *
 * @method
 * @param {ve.ui.WikiaCartItemWidget|null} item The selected cart item, or `null` if none are
 * selected.
 */
ve.ui.WikiaMediaInsertDialog.prototype.onCartSelect = function ( item ) {
	if ( item !== null ) {
		this.setPage( item.getModel().title );
	}
};

/**
 * @method
 * @param {ve.dm.WikiaCartItem|null} items
 */
ve.ui.WikiaMediaInsertDialog.prototype.onCartAdd = function ( items ) {
	var i, page;
	for ( i = 0; i < items.length; i++ ) {
		// Add item media page
		page = new ve.ui.WikiaMediaPageWidget( items[i], {
			'$$': this.frame.$$,
			'editable': false
		} );
		page.connect( this, { 'remove': 'onMediaPageRemove' } );
		this.pages.addPage( items[i].title, { '$content': page.$ } );
	}
};

/**
 * Set which page should be visible.
 *
 * @method
 * @param {string} name The name of the page to set as the current page.
 */
ve.ui.WikiaMediaInsertDialog.prototype.setPage = function ( name ) {
	if ( this.pages.getPageName() === name ) {
		// Toggle cart item
		if ( ve.indexOf( name, ve.ui.WikiaMediaInsertDialog.static.pages ) === -1 ) {
			this.pages.setPage( this.getDefaultPage() );
		}
	} else {
		this.pages.setPage( name );
	}
};

/**
 * Gets the page to use as default when a cart item is not selected.
 *
 * @method
 */
ve.ui.WikiaMediaInsertDialog.prototype.getDefaultPage = function () {
	return this.queryInput.getValue().trim().length === 0 ? 'main' : 'search';
};

/**
 * Handle clicks on the file page remove item button.
 *
 * @method
 * @param {ve.dm.WikiaCartItem} item The cart item model
 */
ve.ui.WikiaMediaInsertDialog.prototype.onMediaPageRemove = function ( item ) {
	this.cartModel.removeItems( [ item ] );
	this.setPage( this.getDefaultPage() );
};

/**
 * Handle opening the dialog.
 *
 * @method
 */
ve.ui.WikiaMediaInsertDialog.prototype.onOpen = function () {
	ve.ui.MWDialog.prototype.onOpen.call( this );
	this.pages.setPage( 'main' );
};

/**
 * Handle when a page is set.
 *
 * @method
 */
ve.ui.WikiaMediaInsertDialog.prototype.onPageSet = function () {
	this.queryInput.$input.focus();
	if ( this.pages.getPageName() === 'main' ) {
		this.query.hideUpload();
	} else {
		this.query.showUpload();
	}
};

/**
 * Handle closing the dialog.
 *
 * @method
 * @param {string} action Which action is being performed on close.
 */
ve.ui.WikiaMediaInsertDialog.prototype.onClose = function ( action ) {
	if ( action === 'insert' ) {
		this.insertMedia( ve.copy( this.cartModel.getItems() ) );
	}
	this.cartModel.clearItems();
	this.queryInput.setValue( '' );
};

/**
 * @method
 * @param {ve.dm.WikiaCartItem[]} cartItems Items to add
 */
ve.ui.WikiaMediaInsertDialog.prototype.insertMedia = function ( cartItems ) {
	var attributes = {},
		promises = [],
		items = {
			'photo': [],
			'video': []
		},
		cartItem,
		i,
		title;

	// Populates attributes, items.video and items.photo
	for ( i = 0; i < cartItems.length; i++ ) {
		cartItem = cartItems[i];
		attributes[ cartItem.title ] = {
			'title': cartItem.title,
			'type': cartItem.type
		};
		items[ cartItem.type ].push( cartItem.title );
	}

	function updateImageinfo( results ) {
		var i, result;
		for ( i = 0; i < results.length; i++ ) {
			result = results[i];
			attributes[result.title].height = result.height;
			attributes[result.title].width = result.width;
			attributes[result.title].url = result.url;
		}
	}

	// Imageinfo for photos request
	if ( items.photo.length ) {
		promises.push(
			this.getImageInfo( items.photo, 220 ).done(
				ve.bind( updateImageinfo, this )
			)
		);
	}

	// Imageinfo for videos request
	if ( items.video.length ) {
		promises.push(
			this.getImageInfo( items.video, 330 ).done(
				ve.bind( updateImageinfo, this )
			)
		);
	}

	function updateAvatar( result ) {
		attributes[result.title].avatar = result.avatar;
		attributes[result.title].username = result.username;
	}

	// Attribution request
	for ( title in attributes ) {
		promises.push(
			this.getPhotoAttribution( title ).done(
				ve.bind( updateAvatar, this )
			)
		);
	}

	// When all ajax requests are finished, insert media
	$.when.apply( $, promises ).done(
		ve.bind( this.insertMediaCallback, this, attributes )
	);
};

/**
 * Inserts media items into the document
 *
 * @method
 * @param {Object} attributes Items to insert
 */
ve.ui.WikiaMediaInsertDialog.prototype.insertMediaCallback = function ( attributes ) {
	var title, type, item, items = [];
	for ( title in attributes ) {
		item = attributes[title];
		if ( item.type === 'photo' ) {
			type = 'wikiaBlockImage';
		} else if ( item.type === 'video' ) {
			type = 'wikiaBlockVideo';
		}
		items.push(
			{
				'type': type,
				'attributes': {
					'type': 'thumb',
					'align': 'default',
					'href': './' + item.title,
					'src': item.url,
					'width': item.width,
					'height': item.height,
					'resource': './' + item.title,
					'attribution': {
						'username': item.username,
						'avatar': item.avatar
					}
				}
			},
			{ 'type': 'wikiaMediaCaption' },
			{ 'type': '/wikiaMediaCaption' },
			{ 'type': '/' + type }
		);
	}
	this.surface.getModel().getFragment().collapseRangeToEnd().insertContent( items );
};

/**
 * Gets photo attribution information
 *
 * @method
 * @param {string} title Title of the file
 * @returns {jQuery.Promise}
 */
ve.ui.WikiaMediaInsertDialog.prototype.getPhotoAttribution = function ( title ) {
	var deferred = $.Deferred();
	$.ajax( {
		'url': mw.util.wikiScript( 'api' ),
		'data': {
			'action': 'apiphotoattribution',
			'format': 'json',
			'file': title
		},
		'success': function( data ) {
			deferred.resolve( data );
		}
	} );
	return deferred.promise();
};

/**
 * Gets imageinfo for titles
 *
 * @method
 * @param {Object} [titles] Array of titles
 * @param {integer} width The requested width
 * @returns {jQuery.Promise}
 */
ve.ui.WikiaMediaInsertDialog.prototype.getImageInfo = function ( titles, width ) {
	var deferred = $.Deferred();
	$.ajax( {
		'url': mw.util.wikiScript( 'api' ),
		'data': {
			'action': 'query',
			'format': 'json',
			'prop': 'imageinfo',
			'iiurlwidth': width,
			'iiprop': 'url',
			'indexpageids': 'true',
			'titles': titles.join('|'),
		},
		'success': ve.bind( this.onGetImageInfoSuccess, this, deferred )
	} );
	return deferred.promise();
};

/**
 * Responds to getImageInfo success
 *
 * @method
 * @param {jQuery.Deferred} deferred
 * @param {Object} data Response from API
 */
ve.ui.WikiaMediaInsertDialog.prototype.onGetImageInfoSuccess = function ( deferred, data ) {
	var results = [], item, i;
	for ( i = 0; i < data.query.pageids.length; i++ ) {
		item = data.query.pages[ data.query.pageids[i] ];
		results.push( {
			'title': item.title,
			'height': item.imageinfo[0].thumbheight,
			'width': item.imageinfo[0].thumbwidth,
			'url': item.imageinfo[0].thumburl
		} );
	}
	deferred.resolve( results );
};

/**
 * Handle successful file uploads.
 *
 * @method
 * @param {Object} data The uploaded file information
 */
ve.ui.WikiaMediaInsertDialog.prototype.onUploadSuccess = function ( data ) {
	this.cartModel.addItems( [
		new ve.dm.WikiaCartItem( data.title, data.temporaryThumbUrl, 'photo', data.temporaryFileName )
	] );
	this.setPage( data.title );
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.WikiaMediaInsertDialog );
