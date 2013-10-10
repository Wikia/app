/*!
 * VisualEditor user interface WikiaMediaInsertDialog class.
 */

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

/* Methods */

ve.ui.WikiaMediaInsertDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWDialog.prototype.initialize.call( this );

	// Properties
	this.cartModel = new ve.dm.WikiaCart();
	this.cart = new ve.ui.WikiaCartWidget( this.cartModel );
	this.$cart = this.$$( '<div>' );
	this.search = new ve.ui.WikiaMediaSearchWidget( { '$$': this.frame.$$ } );
	this.pagesPanel = new ve.ui.PagedLayout( { '$$': this.frame.$$, 'attachPagesPanel': true } );
	this.$removePage = this.$$( '<div>' );
	this.removeButton = new ve.ui.ButtonWidget( {
		'$$': this.frame.$$,
		'label': 'Remove from the cart', //TODO: i18n
		'flags': ['destructive']
	} );
	this.removeButton.$.appendTo( this.$removePage );
	this.insertButton = new ve.ui.ButtonWidget( {
		'$$': this.$$,
		'label': ve.msg( 'visualeditor-wikiamediainsertbuttontool-label' ),
		'flags': ['primary']
	} );
	this.insertionDetails = {};

	// Events
	this.search.connect( this, { 'select': 'onSearchSelect' } );
	this.cart.connect( this, { 'select': 'onCartSelect' } );
	this.pagesPanel.connect( this, { 'set': 'onPagesPanelSet' } );
	this.removeButton.connect( this, { 'click': 'onRemoveButtonClick' } );
	this.insertButton.connect( this, { 'click': [ 'close', 'insert' ] } );

	// Initialization
	this.pagesPanel.addPage( 'remove', { '$content': this.$removePage } );
	this.pagesPanel.addPage( 'search', { '$content': this.search.$ } );
	this.$cart
		.addClass( 've-ui-wikiaCartWidget-wrapper' )
		.append( this.cart.$ );
	this.$body.append( this.$cart, this.pagesPanel.$ );
	this.frame.$content.addClass( 've-ui-wikiaMediaInsertDialog-content' );
	this.$foot.append( this.insertButton.$ );
};

ve.ui.WikiaMediaInsertDialog.prototype.onSearchSelect = function ( item ) {
	if ( item === null ) {
		return;
	}
	this.cartModel.addItems( [
		new ve.dm.WikiaCartItem( item.title, item.url, item.type )
	] );
};

ve.ui.WikiaMediaInsertDialog.prototype.onCartSelect = function ( item ) {
	if ( this.pagesPanel.getPageName() === 'search' ) {
		this.pagesPanel.setPage( 'remove' );
	} else {
		this.pagesPanel.setPage( 'search' );
	}
};

ve.ui.WikiaMediaInsertDialog.prototype.onRemoveButtonClick = function () {
	this.cartModel.removeItems( [ this.cart.getSelectedItem().getModel() ] )
	this.pagesPanel.setPage( 'search' );
};

ve.ui.WikiaMediaInsertDialog.prototype.onOpen = function ( page ) {
	ve.ui.MWDialog.prototype.onOpen.call( this );
	this.pagesPanel.setPage( 'search' );
};

ve.ui.WikiaMediaInsertDialog.prototype.onPagesPanelSet = function ( page ) {
	page.$.find( ':input:first' ).focus();
};

ve.ui.WikiaMediaInsertDialog.prototype.onClose = function ( action ) {
	if ( action === 'insert' ) {
		this.insertMedia( ve.copy( this.cartModel.getItems() ) );
	}
};

/**
 * Collects extra data about cart items before inserting
 *
 * @method
 * @param {Object} [cartItems] Items to insert
 */
ve.ui.WikiaMediaInsertDialog.prototype.insertMedia = function ( cartItems ) {
	var i,
		cartPhotos = [],
		cartVideos = [],
		deferreds = [];

	// Populate insertionDetails, cartPhotos and cartVideos
	for ( i = 0; i < cartItems.length; i++ ) {
		var item = cartItems[i];

		this.insertionDetails[ item.title ] = {
			'title': item.title,
			'type': item.type
		};

		if ( cartItems[i].type == 'photo' ) {
			cartPhotos.push( cartItems[i].title );
		} else if (cartItems[i].type == 'video' ) {
			cartVideos.push( cartItems[i].title );
		}
	}

	function updateDetails( results ) {
		for ( i = 0; i < results.length; i++ ) {
			var result = results[i];
			this.insertionDetails[result.title]['height'] = result.height;
			this.insertionDetails[result.title]['width'] = result.width;
			this.insertionDetails[result.title]['url'] = result.url;
		}
	};

	// Photo request
	if ( cartPhotos.length ) {
		var photosPromise = this.getImageInfo( cartPhotos, 220 );
		photosPromise.done( ve.bind( updateDetails, this ) );
		deferreds.push( photosPromise );
	}
	// Video request
	if ( cartVideos.length ) {
		var videosPromise = this.getImageInfo( cartVideos, 330 );
		videosPromise.done( ve.bind( updateDetails, this ) );
		deferreds.push( videosPromise );
	}
	// Attribution request
	for ( title in this.insertionDetails ) {
		var attributionPromise = this.getPhotoAttribution( title );
		attributionPromise.done( ve.bind( function( result) {
			this.insertionDetails[result.title]['avatar'] = result.avatar;
			this.insertionDetails[result.title]['username'] = result.username;
		}, this ) );
		deferreds.push( attributionPromise );
	}

	// When all ajax requests are finished, insert media
	$.when.apply( $, deferreds ).done(
		ve.bind( this.insertMediaCallback, this, cartItems )
	);
};

/**
 * Inserts media items from cart into the document
 *
 * @method
 * @param {Object} [cartItems] Items to insert
 */
ve.ui.WikiaMediaInsertDialog.prototype.insertMediaCallback = function ( cartItems ) {
	var items = [],
		item,
		insertionType;

	for ( i = 0; i < cartItems.length; i++ ) {
		item = this.insertionDetails[ cartItems[i].title ];

		if ( item.type == 'photo' ) {
			insertionType = 'wikiaBlockImage';
		} else if ( item.type == 'video' ) {
			insertionType = 'wikiaBlockVideo';
		}

		items.push(
			{
				'type': insertionType,
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
			{ 'type': '/' + insertionType }
		)
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
		'success': ve.bind( this.onGetPhotoAttributionSuccess, this, deferred )
	} );
	return deferred.promise();
};

/**
 * Responds to getPhotoAttribution success
 *
 * @method
 * @param {jQuery.Deferred} deferred
 * @param {JSON} data Response from API
 */
ve.ui.WikiaMediaInsertDialog.prototype.onGetPhotoAttributionSuccess = function ( deferred, data ) {
	deferred.resolve( data );
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
 * @param {JSON} data Response from API
 */
ve.ui.WikiaMediaInsertDialog.prototype.onGetImageInfoSuccess = function ( deferred, data ) {
	var results = [];

	for ( i = 0; i < data.query.pageids.length; i++ ) {
		var item = data.query.pages[ data.query.pageids[i] ];
		results.push( {
			'title': item.title,
			'height': item.imageinfo[0].thumbheight,
			'width': item.imageinfo[0].thumbwidth,
			'url': item.imageinfo[0].thumburl
		} )
	}

	deferred.resolve( results );
}

/* Registration */

ve.ui.dialogFactory.register( ve.ui.WikiaMediaInsertDialog );
