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
	// TODO: Rename to "remove" to details" when start working seriously on it.
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
	var cartItems, i;
	if ( item === null ) {
		return;
	}
	cartItems = ve.copy( this.cartModel.getItems() );
	for ( i = 0; i < cartItems.length; i++ ) {
		if ( cartItems[i].title === item.title ) {
			this.cartModel.removeItems( [ cartItems[i] ] );
		}
	}
	this.cartModel.addItems( [
		new ve.dm.WikiaCartItem( item.title, item.url, item.type )
	] );
};

ve.ui.WikiaMediaInsertDialog.prototype.onCartSelect = function () {
	if ( this.pagesPanel.getPageName() === 'search' ) {
		this.pagesPanel.setPage( 'remove' );
	} else {
		this.pagesPanel.setPage( 'search' );
	}
};

ve.ui.WikiaMediaInsertDialog.prototype.onRemoveButtonClick = function () {
	this.cartModel.removeItems( [ this.cart.getSelectedItem().getModel() ] );
	this.pagesPanel.setPage( 'search' );
};

ve.ui.WikiaMediaInsertDialog.prototype.onOpen = function () {
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
	this.cartModel.clearItems();
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

/* Registration */

ve.ui.dialogFactory.register( ve.ui.WikiaMediaInsertDialog );
