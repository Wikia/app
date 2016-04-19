/*!
 * VisualEditor user interface WikiaMediaInsertDialog class.
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
ve.ui.WikiaMediaInsertDialog = function VeUiMWMediaInsertDialog( config ) {
	// Parent constructor
	ve.ui.WikiaMediaInsertDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaMediaInsertDialog, ve.ui.FragmentDialog );

/* Static Properties */

ve.ui.WikiaMediaInsertDialog.static.name = 'wikiaMediaInsert';

ve.ui.WikiaMediaInsertDialog.static.title = OO.ui.deferMsg( 'visualeditor-dialog-media-insert-title' );

ve.ui.WikiaMediaInsertDialog.static.trackingLabel = 'dialog-media-insert';

// as in OO.ui.WindowManager.static.sizes
ve.ui.WikiaMediaInsertDialog.static.size = '840px';

ve.ui.WikiaMediaInsertDialog.static.actions = [
	{
		action: 'apply',
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-apply' ),
		flags: [ 'progressive', 'primary' ]
	}
];

ve.ui.WikiaMediaInsertDialog.static.pages = [ 'main', 'search' ];

/**
 * Properly format the media policy message
 * Strip all HTML tags except for anchors. Make anchors open in a new window.
 *
 * @method
 * @param {string} html The HTML to format
 * @returns {jQuery}
 */
ve.ui.WikiaMediaInsertDialog.static.formatPolicy = function ( html ) {
	return $( '<div>' )
		.html( html )
		.find( '*' )
			.each( function () {
				if ( this.tagName.toLowerCase() === 'a' ) {
					$( this ).attr( 'target', '_blank' );
				} else {
					$( this ).contents().unwrap();
				}
			} )
			.end();
};

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaMediaInsertDialog.prototype.getBodyHeight = function () {
	return 600;
};

/**
 * @inheritdoc
 */
ve.ui.WikiaMediaInsertDialog.prototype.initialize = function () {
	var uploadEvents = {
		change: 'onUploadChange',
		upload: 'onUploadSuccess'
	};

	// Parent method
	ve.ui.WikiaMediaInsertDialog.super.prototype.initialize.call( this );

	// Properties
	this.cartModel = new ve.dm.WikiaCart();
	this.mediaPreview = new ve.ui.WikiaMediaPreviewWidget();
	this.cart = new ve.ui.WikiaCartWidget( this.cartModel );
	this.dropTarget = new ve.ui.WikiaDropTargetWidget( {
		$: this.$,
		$frame: this.$frame,
		$overlay: this.$overlay
	} );
	this.license = { promise: null, html: null };
	this.pages = new OO.ui.BookletLayout( { $: this.$ } );
	this.query = new ve.ui.WikiaMediaQueryWidget( {
		$: this.$,
		placeholder: ve.msg( 'wikia-visualeditor-dialog-wikiamediainsert-search-input-placeholder' )
	} );
	this.queryInput = this.query.getInput();
	this.queryUpload = this.query.getUpload();
	this.search = new ve.ui.WikiaMediaResultsWidget( { $: this.$ } );
	this.results = this.search.getResults();
	this.timings = {};
	this.upload = new ve.ui.WikiaUploadWidget( { $: this.$ } );

	this.$cart = this.$( '<div>' );
	this.$bodycontent = this.$( '<div>' );
	this.$mainPage = this.$( '<div>' );
	this.$policy = this.$( '<div>' )
		.addClass('ve-ui-wikiaMediaInsertDialog-policy')
		.html(
			this.constructor.static.formatPolicy(
				ve.init.platform.getParsedMessage( 'wikia-visualeditor-dialog-wikiamediainsert-policy-message' )
			)
		);
	this.$policyReadMore = this.$( '<div>' )
		.addClass( 've-ui-wikiaMediaInsertDialog-readMore' );
	this.$policyReadMoreLink = this.$( '<a>' )
		.html( ve.msg( 'wikia-visualeditor-dialog-wikiamediainsert-read-more' ) );
	this.$policyReadMore.append( this.$policyReadMoreLink );

	// Events
	this.cartModel.connect( this, {
		add: 'onCartModelAdd',
		remove: 'onCartModelRemove'
	} );
	this.cart.on( 'select', this.onCartSelect.bind( this ) );
	this.pages.on( 'set', this.onPageSet.bind( this ) );
	this.query.connect( this, {
		requestSearchDone: 'onQueryRequestSearchDone',
		requestVideoDone: 'onQueryRequestVideoDone'
	} );
	this.queryInput.connect( this, {
		change: 'onQueryInputChange',
		enter: 'onQueryInputEnter'
	} );
	this.queryInput.$input.on( 'keydown', this.onQueryInputKeydown.bind( this ) );
	this.search.connect( this, {
		nearingEnd: 'onSearchNearingEnd',
		check: 'onSearchCheck',
		select: 'onMediaPreview'
	} );
	this.upload.connect( this, uploadEvents );
	this.queryUpload.connect( this, uploadEvents );
	this.$policyReadMoreLink.on( 'click', this.onReadMoreLinkClick.bind( this ) );
	this.dropTarget.on( 'drop', this.onFileDropped.bind( this ) );

	// Initialization
	this.$mainPage.append( this.upload.$element, this.$policy, this.$policyReadMore );

	this.mainPage = new OO.ui.PageLayout( 'main', { $content: this.$mainPage } );
	this.searchPage = new OO.ui.PageLayout( 'search', { $content: this.search.$element } );
	this.pages.addPages( [ this.mainPage, this.searchPage ] );

	this.$cart
		.addClass( 've-ui-wikiaCartWidget-wrapper' )
		.append( this.cart.$element );
	this.$bodycontent
		.addClass( 've-ui-wikiaMediaInsertDialog-content' )
		.append( this.query.$element, this.pages.$element );

	this.$body.append( this.$bodycontent, this.$cart );
	this.$content.addClass( 've-ui-wikiaMediaInsertDialog' );
	this.$frame.append( this.dropTarget.$element );
	this.$overlay.append( this.mediaPreview.$element );
};

/**
 * Handle adding items to the cart model.
 *
 * @method
 * @param {ve.dm.WikiaCartItem[]} items Cart models
 */
ve.ui.WikiaMediaInsertDialog.prototype.onCartModelAdd = function ( items ) {
	var config, i, item, page;

	for ( i = 0; i < items.length; i++ ) {
		item = items[i];
		config = { $: this.$ };
		if ( item.isTemporary() ) {
			config.editable = true;
			config.$license = this.$( this.license.html );
		}
		page = new ve.ui.WikiaMediaPageWidget( item, config );
		page.connect( this, {
			remove: 'onMediaPageRemove',
			preview: 'onMediaPreview'
		} );
		this.pages.addPages( [ page ] );
	}
	this.results.setChecked( items, true );
};

/**
 * Handle removing items from the cart model.
 *
 * @method
 * @param {ve.dm.WikiaCartItem[]} items
 */
ve.ui.WikiaMediaInsertDialog.prototype.onCartModelRemove = function ( items ) {
	this.results.setChecked( items, false );
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
 * Handle when a page is set.
 *
 * @method
 */
ve.ui.WikiaMediaInsertDialog.prototype.onPageSet = function () {
	this.queryInput.$input.focus();
	if ( this.pages.getCurrentPageName() === 'main' ) {
		this.query.hideUpload();
	} else {
		this.query.showUpload();
	}
};

/**
 * Handle the resulting data from a query media request.
 *
 * @method
 * @param {Object} items An object containing items to add to the search results
 */
ve.ui.WikiaMediaInsertDialog.prototype.onQueryRequestSearchDone = function ( items ) {
	items.forEach( function ( item ) {
		if ( item.type === 'video' ) {
			item.provider = 'wikia';
		}
	} );
	this.search.addItems( items );
	this.results.setChecked( this.cartModel.getItems(), true );
	this.pages.setPage( 'search' );
};

/**
 * Handle the resulting data from a query video request.
 *
 * @method
 * @param {Object} data An object containing the data for a video
 */
ve.ui.WikiaMediaInsertDialog.prototype.onQueryRequestVideoDone = function ( data ) {
	this.queryInput.setValue( '' );
	//this.addCartItem( model, true );
	this.addCartItem( new ve.dm.WikiaCartItem(
		data.title,
		data.tempUrl || data.url,
		'video',
		data.tempName,
		data.provider,
		data.videoId
	), true );
};

/**
 * Handle query input changes.
 *
 * @method
 * @param {string} value The query input value
 */
ve.ui.WikiaMediaInsertDialog.prototype.onQueryInputChange = function ( value ) {
	this.results.clearItems();
	if ( value.trim().length === 0 ) {
		this.setPage( 'main' );
	}
};

/**
 * Handle pressing the enter key inside the query input.
 *
 * @method
 */
ve.ui.WikiaMediaInsertDialog.prototype.onQueryInputEnter = function () {
	this.results.selectItem( this.results.getHighlightedItem() );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaMediaInsertDialog.prototype.onQueryInputKeydown =
	OO.ui.SearchWidget.prototype.onQueryKeydown;

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
 * @param {Object} item The search result item.
 */
ve.ui.WikiaMediaInsertDialog.prototype.onSearchCheck = function ( item ) {
	var data = item.getData(),
		cartItem = this.cart.getItemFromData( data.title );

	if ( cartItem ) {
		this.cartModel.removeItems( [ cartItem.getModel() ] );
	} else {
		if ( data.type === 'video' ) {
			this.addCartItem( new ve.dm.WikiaCartItem( data.title, data.url, data.type, undefined, 'wikia' ) );
		} else {
			this.addCartItem( new ve.dm.WikiaCartItem( data.title, data.url, data.type ) );
		}
	}
};

/**
 * Handle showing or hiding the media preview
 *
 * @method
 * @param {Object|null} item The item to preview or `null` if closing the preview.
 */
ve.ui.WikiaMediaInsertDialog.prototype.onMediaPreview = function ( item ) {
	var data = item.getData();
	if ( data.type === 'photo' ) {
		this.mediaPreview.openForImage( data.title, data.url );
	} else if ( data.type === 'video' ) {
		this.mediaPreview.openForVideo( data.title, data.provider, data.videoId );
	}
};

/**
 * Handle clicking the media policy read more link.
 *
 * @method
 * @param {jQuery} e The jQuery event
 */
ve.ui.WikiaMediaInsertDialog.prototype.onReadMoreLinkClick = function ( e ) {
	e.preventDefault();
	this.$policyReadMore.hide();
	this.$policy.animate( { 'max-height': this.$policy.children().first().height() } );
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
	if ( !this.license.html ) {
		this.license.promise.done( this.onUploadSuccess.bind( this, data ) );
	} else {
		this.addCartItem( new ve.dm.WikiaCartItem(
			data.title,
			data.tempUrl || data.url,
			'photo',
			data.tempName
		), true );
	}
};

/**
 * Add an item to the cart, optionally selecting it.
 *
 * @method
 * @param {ve.dm.WikiaCartItem} item The cart item's data model.
 * @param {boolean} [select] Whether to select the cart item.
 */
ve.ui.WikiaMediaInsertDialog.prototype.addCartItem = function ( item, select ) {
	this.cartModel.addItems( [ item ] );
	if ( select ) {
		this.cart.selectItem( this.cart.getItemFromData( item.getId() ) );
	}
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
 * Set which page should be visible.
 *
 * @method
 * @param {string} name The name of the page to set as the current page.
 */
ve.ui.WikiaMediaInsertDialog.prototype.setPage = function ( name ) {
	var isStaticPage = ve.indexOf( name, ve.ui.WikiaMediaInsertDialog.static.pages ) > -1,
		isCartItemToggle = this.pages.getCurrentPageName() === name && !isStaticPage;

	if ( isStaticPage || isCartItemToggle ) {
		this.cart.selectItem( null );
	}

	this.pages.setPage( isCartItemToggle ? this.getDefaultPage() : name );
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
 * Handle opening the dialog.
 *
 * @method
 */
ve.ui.WikiaMediaInsertDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.WikiaMediaInsertDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			this.pages.setPage( 'main' );
			// If the policy height (which has a max-height property set) is the same as the first child of the policy
			// then there is no more of the policy to show and the read more link can be hidden.
			if ( this.$policy.height() === this.$policy.children().first().height() ) {
				this.$policyReadMore.hide();
			}
			this.dropTarget.setup();
		}, this );
};

ve.ui.WikiaMediaInsertDialog.prototype.getReadyProcess = function ( data ) {
	return ve.ui.WikiaMediaInsertDialog.super.prototype.getReadyProcess.call( this, data )
		.next( function () {
			this.queryInput.$input.focus();
		}, this );
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
			url: mw.util.wikiScript( 'api' ),
			data: {
				action: 'licenses',
				format: 'json',
				id: 'license',
				name: 'license'
			},
			success: function ( data ) {
				deferred.resolve( this.license.html = data.licenses.html );
			}.bind( this )
		} );
	}

	return this.license.promise;
};

ve.ui.WikiaMediaInsertDialog.prototype.getActionProcess = function ( action ) {
	if ( action === 'apply' ) {
		return new OO.ui.Process( function () {
			this.insertMedia( ve.copy( this.cartModel.getItems() ), this.fragment );
			this.close( { action: action } );
		}, this );
	}
	return ve.ui.WikiaMediaInsertDialog.super.prototype.getActionProcess.call( this, action );
};

ve.ui.WikiaMediaInsertDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.WikiaMediaInsertDialog.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			this.cartModel.clearItems();
			this.queryInput.setValue( '' );
			this.dropTarget.teardown();
		}, this );
};

/**
 * @method
 * @param {ve.dm.WikiaCartItem[]} cartItems Items to add
 * @param {ve.dm.SurfaceFragment} fragment
 */
ve.ui.WikiaMediaInsertDialog.prototype.insertMedia = function ( cartItems, fragment ) {
	var i, promises = [];

	this.timings.insertStart = ve.now();

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
					temporaryToPermanentCallback.bind( this, cartItems[i] )
				)
			);
		}
	}

	$.when.apply( $, promises ).done( function () {
		this.insertPermanentMedia( cartItems, fragment );
	}.bind( this ) );
};

/**
 * @method
 * @param {Object} cartItems Cart items to insert.
 * @param {ve.dm.SurfaceFragment} fragment
 */
ve.ui.WikiaMediaInsertDialog.prototype.insertPermanentMedia = function ( cartItems, fragment ) {
	var items = {},
		promises = [],
		types = { photo: [], video: [] },
		cartItem,
		i;

	// Populates attributes, items.video and items.photo
	for ( i = 0; i < cartItems.length; i++ ) {
		cartItem = cartItems[i];
		cartItem.title = 'File:' + cartItem.title;
		items[ cartItem.title ] = {
			title: cartItem.title,
			type: cartItem.type
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
				updateImageinfo.bind( this )
			)
		);
	}

	// Imageinfo for videos request
	if ( types.video.length ) {
		promises.push(
			this.getImageInfo( types.video, 330 ).done(
				updateImageinfo.bind( this )
			)
		);
	}

	// When all ajax requests are finished, insert media
	$.when.apply( $, promises ).done(
		this.insertPermanentMediaCallback.bind( this, items, fragment )
	);
};

/**
 * Inserts media items into the document
 *
 * @method
 * @param {Object} items Items to insert
 * @param {ve.dm.SurfaceFragment} fragment
 */
ve.ui.WikiaMediaInsertDialog.prototype.insertPermanentMediaCallback = function ( items, fragment ) {
	var count, item, title, type, captionType,
		typeCount = { photo: 0, video: 0 },
		linmod = [],
		label = this.constructor.static.trackingLabel;

	for ( title in items ) {
		item = items[title];
		type = 'wikiaBlock' + ( item.type === 'photo' ? 'Image' : 'Video' );
		captionType = ( item.type === 'photo' ) ? 'wikiaImageCaption' : 'wikiaVideoCaption';
		typeCount[item.type]++;
		linmod.push(
			{
				type: type,
				attributes: {
					type: 'thumb',
					align: 'default',
					href: './' + item.title,
					src: item.url,
					width: item.width,
					height: item.height,
					resource: './' + item.title,
					user: item.username
				}
			},
			{ type: captionType },
			{ type: '/' + captionType },
			{ type: '/' + type }
		);
	}

	for ( type in typeCount ) {
		count = typeCount[type];
		if ( type === 'photo' ) {
			type = 'image';
		}
		if ( count ) {
			ve.track( 'wikia', {
				action: ve.track.actions.ADD,
				label: label + '-' + type,
				value: count
			} );
		}
	}

	if ( count.image && count.video ) {
		ve.track( 'wikia', {
			action: ve.track.actions.ADD,
			label: label + '-multiple'
		} );
	}

	fragment.collapseToEnd().insertContent( linmod );

	ve.track( 'wikia', {
		action: ve.track.actions.SUCCESS,
		label: label,
		value: ve.now() - this.timings.insertStart
	} );
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
		url: mw.util.wikiScript( 'api' ),
		data: {
			action: 'query',
			format: 'json',
			prop: 'imageinfo',
			iiurlwidth: width,
			iiprop: 'url',
			indexpageids: 'true',
			titles: titles.join( '|' )
		},
		success: this.onGetImageInfoSuccess.bind( this, deferred )
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
			title: 'File:' + ( new mw.Title( item.title ) ).getMainText(),
			height: item.imageinfo[0].thumbheight,
			width: item.imageinfo[0].thumbwidth,
			url: item.imageinfo[0].thumburl
		} );
	}
	deferred.resolve( results );
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
			action: 'addmediapermanent',
			format: 'json',
			title: cartItem.title,
			token: mw.user.tokens.get( 'editToken' )
		};
	if ( cartItem.provider ) {
		data.provider = cartItem.provider;
		data.videoId = cartItem.videoId;
	} else {
		data.license = cartItem.license;
		data.tempName = cartItem.temporaryFileName;
	}
	$.post( mw.util.wikiScript( 'api' ), data )
		.then( function ( data ) {
			deferred.resolve( data.addmediapermanent.title );
		} );

	return deferred.promise();
};

/**
 * Handle drag & drop file uploaded
 *
 * @method
 * @param {Object} file instance of file
 */
ve.ui.WikiaMediaInsertDialog.prototype.onFileDropped = function ( file ) {
	this.upload.$file.trigger( 'change', file );
};

ve.ui.WikiaMediaInsertDialog.prototype.onDocumentKeyDown = function ( e ) {
	if ( e.which === OO.ui.Keys.ESCAPE && this.mediaPreview.isOpen() ) {
		this.mediaPreview.close();
		return false; // stop propagation
	}
	ve.ui.WikiaMediaInsertDialog.super.prototype.onDocumentKeyDown.call( this, e );
};

ve.ui.windowFactory.register( ve.ui.WikiaMediaInsertDialog );
