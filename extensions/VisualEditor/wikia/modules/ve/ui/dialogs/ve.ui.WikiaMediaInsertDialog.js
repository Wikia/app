/*!
 * VisualEditor user interface WikiaMediaInsertDialog class.
 */

/* global mw */

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

OO.inheritClass( ve.ui.WikiaMediaInsertDialog, ve.ui.MWDialog );

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
	var uploadEvents = {
		'change': 'onUploadChange',
		'upload': 'onUploadSuccess'
	};

	// Parent method
	ve.ui.MWDialog.prototype.initialize.call( this );

	// Properties
	this.cartModel = new ve.dm.WikiaCart();
	this.cart = new ve.ui.WikiaCartWidget( this.cartModel );
	this.insertButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'label': ve.msg( 'wikia-visualeditor-dialog-wikiamediainsert-insert-button' ),
		'flags': ['primary']
	} );
	this.insertionDetails = {};
	this.license = { 'promise': null, 'html': null };
	this.pages = new OO.ui.PagedLayout( { '$': this.$, 'attachPagesPanel': true } );
	this.query = new ve.ui.WikiaMediaQueryWidget( {
		'$': this.$,
		'placeholder': ve.msg( 'wikia-visualeditor-dialog-wikiamediainsert-search-input-placeholder' )
	} );
	this.queryInput = this.query.getInput();
	this.queryUpload = this.query.getUpload();
	this.search = new ve.ui.WikiaMediaResultsWidget( { '$': this.$ } );
	this.searchResults = this.search.getResults();
	this.upload = new ve.ui.WikiaUploadWidget( { '$': this.$, 'hideIcon': true } );

	this.$cart = this.$( '<div>' );
	this.$content = this.$( '<div>' );
	this.$mainPage = this.$( '<div>' );

	// Events
	this.cartModel.connect( this, {
		'add': 'onCartModelAdd',
		'remove': 'onCartModelRemove'
	} );
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
		'check': 'onSearchCheck'
	} );
	this.upload.connect( this, uploadEvents );
	this.queryUpload.connect( this, uploadEvents );

	// Initialization
	this.upload.$element.appendTo( this.$mainPage );
	this.pages.addPage( 'main', { '$content': this.$mainPage } );
	this.pages.addPage( 'search', { '$content': this.search.$element } );

	this.$cart
		.addClass( 've-ui-wikiaCartWidget-wrapper' )
		.append( this.cart.$element );
	this.$content
		.addClass( 've-ui-wikiaMediaInsertDialog-content' )
		.append( this.query.$, this.pages.$element );

	this.$body.append( this.$content, this.$cart );
	this.frame.$content.addClass( 've-ui-wikiaMediaInsertDialog' );
	this.$foot.append( this.insertButton.$element );
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
 * Copied from OO.ui.SearchWidget.js
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
	this.search.addItems( items );
	this.searchResults.setChecked( this.cartModel.getItems(), true );
	this.pages.setPage( 'search' );
};

ve.ui.WikiaMediaInsertDialog.prototype.onQueryRequestVideoDone = function ( data ) {
	var model = new ve.dm.WikiaCartItem(
		data.title,
		data.tempUrl || data.url,
		'video',
		data.tempName,
		data.provider,
		data.videoId
	);
	this.queryInput.setValue( '' );
	this.cartModel.addItems( [ model ] );
	this.setPage( model.getId() );
	this.cart.selectItem( this.cart.getItemFromData( model.getId() ) );
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
 * Handle check/uncheck of items in search results.
 *
 * @method
 * @param {Object} item The search result item data.
 */
ve.ui.WikiaMediaInsertDialog.prototype.onSearchCheck = function ( item ) {
	var cartItem, cartItemModel;

	cartItem = this.cart.getItemFromData( item.title );
	if ( cartItem ) {
		this.cartModel.removeItems( [ cartItem.getModel() ] );
	} else {
		cartItemModel = new ve.dm.WikiaCartItem( item.title, item.url, item.type );
		this.cartModel.addItems( [ cartItemModel ] );
	}
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
		this.setPage( item.getModel().getId() );
	}
};

/**
 * Handle adding items to the cart model.
 *
 * @method
 * @param {ve.dm.WikiaCartItem[]} items Cart models
 */
ve.ui.WikiaMediaInsertDialog.prototype.onCartModelAdd = function ( items ) {
	var config, i, isTemporary, item, page;

	for ( i = 0; i < items.length; i++ ) {
		item = items[i];
		isTemporary = item.isTemporary();
		config = {
			'$': this.$,
			'editable': ( isTemporary && item.provider !== 'wikia' )
		};
		if ( isTemporary ) {
			config.$license = this.$( this.license.html );
		}
		page = new ve.ui.WikiaMediaPageWidget( item, config );
		page.connect( this, { 'remove': 'onMediaPageRemove' } );
		this.pages.addPage( item.getId(), { '$content': page.$element } );
	}

	this.searchResults.setChecked( items, true );
};

/**
 * Handle removing items from the cart model.
 *
 * @method
 * @param {ve.dm.WikiaCartItem[]} items
 */
ve.ui.WikiaMediaInsertDialog.prototype.onCartModelRemove = function ( items ) {
	this.searchResults.setChecked( items, false );
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
			this.cart.selectItem( null );
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
 * Converts temporary cart item into permanent.
 *
 * @method
 * @param {ve.dm.WikiaCartItem} cartItem Cart item to convert.
 */
ve.ui.WikiaMediaInsertDialog.prototype.convertTemporaryToPermanent = function ( cartItem ) {
	var deferred = $.Deferred(),
		data = {
			'action': 'addmediapermanent',
			'format': 'json',
			'title': cartItem.title
		};
	if ( cartItem.provider ) {
		data.provider = cartItem.provider;
		data.videoId = cartItem.videoId;
	} else {
		data.license = cartItem.license;
		data.tempName = cartItem.temporaryFileName;
	}
	$.ajax( {
		'url': mw.util.wikiScript( 'api' ),
		'data': data,
		'success': function ( data ) {
			deferred.resolve( data.addmediapermanent.title );
		}
	} );

	return deferred.promise();
};

/**
 * @method
 * @param {ve.dm.WikiaCartItem[]} cartItems Items to add
 */
ve.ui.WikiaMediaInsertDialog.prototype.insertMedia = function ( cartItems ) {
	var i, promises = [];

	// TODO: consider encapsulating this so it doesn't get created on every function call
	function temporaryToPermanentCallback( cartItem, name ) {
		cartItem.temporaryFileName = null;
		cartItem.url = null;
		cartItem.title = name;
	}

	for ( i = 0; i < cartItems.length; i++ ) {
		if ( cartItems[i].isTemporary() ) {
			promises.push(
				this.convertTemporaryToPermanent( cartItems[i] ).done(
					ve.bind( temporaryToPermanentCallback, this, cartItems[i] )
				)
			);
		}
	}

	$.when.apply( $, promises ).done( ve.bind( function() {
		this.insertPermanentMedia( cartItems );
	}, this ) );
};

/**
 * @method
 * @param {Object} cartItems Cart items to insert.
 */
ve.ui.WikiaMediaInsertDialog.prototype.insertPermanentMedia = function ( cartItems ) {
	var items = {},
		promises = [],
		types = {
			'photo': [],
			'video': []
		},
		cartItem,
		i,
		title;

	// Populates attributes, items.video and items.photo
	for ( i = 0; i < cartItems.length; i++ ) {
		cartItem = cartItems[i];
		cartItem.title = 'File:' + cartItem.title;
		items[ cartItem.title ] = {
			'title': cartItem.title,
			'type': cartItem.type
		};
		types[ cartItem.type ].push( cartItem.title );
	}

	function updateImageinfo( results ) {
		var i, result;
		for ( i = 0; i < results.length; i++ ) {
			result = results[i];
			items[result.title].height = result.height;
			items[result.title].width = result.width;
			items[result.title].url = result.url;
		}
	}

	// Imageinfo for photo request
	if ( types.photo.length ) {
		promises.push(
			this.getImageInfo( types.photo, 220 ).done(
				ve.bind( updateImageinfo, this )
			)
		);
	}

	// Imageinfo for videos request
	if ( types.video.length ) {
		promises.push(
			this.getImageInfo( types.video, 330 ).done(
				ve.bind( updateImageinfo, this )
			)
		);
	}

	function updateAvatar( result ) {
		items[result.title].avatar = result.avatar;
		items[result.title].username = result.username;
	}

	// Attribution request
	for ( title in items ) {
		promises.push(
			this.getPhotoAttribution( title ).done(
				ve.bind( updateAvatar, this )
			)
		);
	}

	// When all ajax requests are finished, insert media
	$.when.apply( $, promises ).done(
		ve.bind( this.insertPermanentMediaCallback, this, items )
	);
};

/**
 * Inserts media items into the document
 *
 * @method
 * @param {Object} items Items to insert
 */
ve.ui.WikiaMediaInsertDialog.prototype.insertPermanentMediaCallback = function ( items ) {
	var count, item, title, type,
		typeCount = { 'photo': 0, 'video': 0 },
		linmod = [];

	for ( title in items ) {
		item = items[title];
		type = 'wikiaBlock' + ( item.type === 'photo' ? 'Image' : 'Video' );
		typeCount[item.type]++;
		linmod.push(
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

	for ( type in typeCount ) {
		count = typeCount[type];
		if ( type === 'photo' ) {
			type = 'image';
		}
		if ( count ) {
			ve.track( 'wikia', {
				'action': ve.track.actions.ADD,
				'label': 'dialog-media-insert-' + type,
				'value': count
			} );
		}
	}

	if ( count.image && count.video ) {
		ve.track( 'wikia', {
			'action': ve.track.actions.ADD,
			'label': 'dialog-media-insert-multiple'
		} );
	}

	this.surface.getModel().getFragment().collapseRangeToEnd().insertContent( linmod );
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
		'success': function ( data ) {
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
			'titles': titles.join( '|' )
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
 * Gets media license dropdown HTML template.
 *
 * @method
 * @returns {jQuery.Deferred} The AJAX API request promise
 */
ve.ui.WikiaMediaInsertDialog.prototype.getLicense = function () {
	var deferred;

	if ( !this.license.promise ) {
		deferred = $.Deferred();
		this.license.promise = deferred.promise();
		$.ajax( {
			'url': mw.util.wikiScript( 'api' ),
			'data': {
				'action': 'licenses',
				'format': 'json',
				'id': 'license',
				'name': 'license'
			},
			'success': ve.bind( function ( data ) {
				deferred.resolve( this.license.html = data.licenses.html );
			}, this )
		} );
	}

	return this.license.promise;
};

/**
 * Handle file input changes.
 *
 * @method
 */
ve.ui.WikiaMediaInsertDialog.prototype.onUploadChange = function () {
	this.getLicense();
};

/**
 * Handle successful file uploads.
 *
 * @method
 * @param {Object} data The uploaded file information
 */
ve.ui.WikiaMediaInsertDialog.prototype.onUploadSuccess = function ( data ) {
	var model;
	if ( !this.license.html ) {
		this.license.promise.done( ve.bind( this.onUploadSuccess, this, data ) );
	} else {
		model = new ve.dm.WikiaCartItem(
			data.title,
			data.tempUrl || data.url,
			'photo',
			data.tempName
		);
		this.cartModel.addItems( [ model ] );
		this.cart.selectItem( this.cart.getItemFromData( model.getId() ) );
	}
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.WikiaMediaInsertDialog );
