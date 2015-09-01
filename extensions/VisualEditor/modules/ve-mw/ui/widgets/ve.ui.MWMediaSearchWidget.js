/*!
 * VisualEditor UserInterface MWMediaSearchWidget class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MWMediaSearchWidget object.
 *
 * @class
 * @extends OO.ui.SearchWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @param {number} [size] Vertical size of thumbnails
 */
ve.ui.MWMediaSearchWidget = function VeUiMWMediaSearchWidget( config ) {
	// Configuration initialization
	config = ve.extendObject( {
		placeholder: ve.msg( 'visualeditor-media-input-placeholder' )
	}, config );

	// Parent constructor
	OO.ui.SearchWidget.call( this, config );

	// Properties
	this.providers = {};
	this.searchValue = '';
	this.resourceQueue = new ve.dm.MWMediaResourceQueue( {
		limit: 20,
		threshold: 10
	} );

	this.queryTimeout = null;
	this.itemCache = {};
	this.promises = [];
	this.lang = config.lang || 'en';
	this.$panels = config.$panels;

	// Masonry fit properties
	this.rows = [];
	this.rowHeight = config.rowHeight || 200;
	this.queryMediaQueueCallback = this.queryMediaQueue.bind( this );
	this.layoutQueue = [];
	this.numItems = 0;
	this.currentItemCache = [];

	this.resultsSize = {};

	this.selected = null;

	this.noItemsMessage = new OO.ui.LabelWidget( {
		label: ve.msg( 'visualeditor-dialog-media-noresults' ),
		classes: [ 've-ui-mwMediaSearchWidget-noresults' ]
	} );
	this.noItemsMessage.toggle( false );

	// Events
	this.$results.on( 'scroll', this.onResultsScroll.bind( this ) );
	this.$query.append( this.noItemsMessage.$element );
	this.results.connect( this, {
		add: 'onResultsAdd',
		remove: 'onResultsRemove'
	} );

	this.resizeHandler = ve.debounce( this.afterResultsResize.bind( this ), 500 );

	// Initialization
	this.$element.addClass( 've-ui-mwMediaSearchWidget' );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWMediaSearchWidget, OO.ui.SearchWidget );

/* Methods */

/**
 * Respond to window resize and check if the result display should
 * be updated.
 */
ve.ui.MWMediaSearchWidget.prototype.afterResultsResize = function () {
	var items = this.currentItemCache,
		value = this.query.getValue();

	if (
		items.length > 0 &&
		(
			this.resultsSize.width !== this.$results.width() ||
			this.resultsSize.height !== this.$results.height()
		)
	) {
		this.resetRows();
		this.itemCache = {};
		this.processQueueResults( items, value );
		if ( this.results.getItems().length > 0 ) {
			this.lazyLoadResults();
		}

		// Cache the size
		this.resultsSize = {
			width: this.$results.width(),
			height: this.$results.height()
		};
	}
};

/**
 * Teardown the widget; disconnect the window resize event.
 */
ve.ui.MWMediaSearchWidget.prototype.teardown = function () {
	$( window ).off( 'resize', this.resizeHandler );
};

/**
 * Setup the widget; activate the resize event.
 */
ve.ui.MWMediaSearchWidget.prototype.setup = function () {
	$( window ).on( 'resize', this.resizeHandler );
};
/**
 * Query all sources for media.
 *
 * @method
 */
ve.ui.MWMediaSearchWidget.prototype.queryMediaQueue = function () {
	var search = this,
		value = this.query.getValue();

	if ( value === '' ) {
		return;
	}

	this.query.pushPending();
	search.noItemsMessage.toggle( false );

	this.resourceQueue.setParams( { gsrsearch: value } );
	this.resourceQueue.get( 20 )
		.then( function ( items ) {
			if ( items.length > 0 ) {
				search.processQueueResults( items, value );
				search.currentItemCache = search.currentItemCache.concat( items );
			}

			search.query.popPending();
			search.noItemsMessage.toggle( search.results.getItems().length === 0 );
			if ( search.results.getItems().length > 0 ) {
				search.lazyLoadResults();
			}

		} );
};

/**
 * Process the media queue giving more items
 *
 * @method
 * @param {Object[]} items Given items by the media queue
 */
ve.ui.MWMediaSearchWidget.prototype.processQueueResults = function ( items ) {
	var i, len, title,
		resultWidgets = [],
		inputSearchQuery = this.query.getValue(),
		queueSearchQuery = this.resourceQueue.getSearchQuery();

	if ( inputSearchQuery === '' || queueSearchQuery !== inputSearchQuery ) {
		return;
	}

	for ( i = 0, len = items.length; i < len; i++ ) {
		title = new mw.Title( items[ i ].title ).getMainText();
		// Do not insert duplicates
		if ( !Object.prototype.hasOwnProperty.call( this.itemCache, title ) ) {
			this.itemCache[ title ] = true;
			resultWidgets.push(
				new ve.ui.MWMediaResultWidget( {
					data: items[ i ],
					rowHeight: this.rowHeight,
					maxWidth: this.results.$element.width() / 3,
					minWidth: 30,
					rowWidth: this.results.$element.width()
				} )
			);
		}
	}
	this.results.addItems( resultWidgets );

};

/**
 * Handle search value change
 *
 * @param {string} value New value
 */
ve.ui.MWMediaSearchWidget.prototype.onQueryChange = function ( value ) {
	var trimmed = $.trim( value );

	if ( trimmed === this.searchValue ) {
		return;
	}
	this.searchValue = trimmed;

	// Parent method
	OO.ui.SearchWidget.prototype.onQueryChange.apply( this, arguments );

	// Reset
	this.itemCache = {};
	this.currentItemCache = [];
	this.resetRows();

	// Empty the results queue
	this.layoutQueue = [];

	// Change resource queue query
	this.resourceQueue.setParams( { gsrsearch: this.searchValue } );

	// Queue
	clearTimeout( this.queryTimeout );
	this.queryTimeout = setTimeout( this.queryMediaQueueCallback, 350 );
};

/**
 * Handle results scroll events.
 *
 * @param {jQuery.Event} e Scroll event
 */
ve.ui.MWMediaSearchWidget.prototype.onResultsScroll = function () {
	var position = this.$results.scrollTop() + this.$results.outerHeight(),
		threshold = this.results.$element.outerHeight() - this.rowHeight * 3;

	// Check if we need to ask for more results
	if ( !this.query.isPending() && position > threshold ) {
		this.queryMediaQueue();
	}

	this.lazyLoadResults();
};

/**
 * Lazy-load the images that are visible.
 */
ve.ui.MWMediaSearchWidget.prototype.lazyLoadResults = function () {
	var i, elementTop,
		items = this.results.getItems(),
		resultsScrollTop = this.$results.scrollTop(),
		position = resultsScrollTop + this.$results.outerHeight();

	// Lazy-load results
	for ( i = 0; i < items.length; i++ ) {
		elementTop = items[ i ].$element.position().top;
		if ( elementTop <= position && !items[ i ].hasSrc() ) {
			// Load the image
			items[ i ].lazyLoad();
		}
	}
};

/**
 * Reset all the rows; destroy the jQuery elements and reset
 * the rows array.
 */
ve.ui.MWMediaSearchWidget.prototype.resetRows = function () {
	var i, len;

	for ( i = 0, len = this.rows.length; i < len; i++ ) {
		this.rows[ i ].$element.remove();
	}

	this.rows = [];
	this.itemCache = {};
};

/**
 * Find an available row at the end. Either we will need to create a new
 * row or use the last available row if it isn't full.
 *
 * @return {number} Row index
 */
ve.ui.MWMediaSearchWidget.prototype.getAvailableRow = function () {
	var row;

	if ( this.rows.length === 0 ) {
		row = 0;
	} else {
		row = this.rows.length - 1;
	}

	if ( !this.rows[ row ] ) {
		// Create new row
		this.rows[ row ] = {
			isFull: false,
			width: 0,
			items: [],
			$element: $( '<div>' )
					.addClass( 've-ui-mwMediaResultWidget-row' )
					.css( {
						overflow: 'hidden'
					} )
					.data( 'row', row )
					.attr( 'data-full', false )
		};
		// Append to results
		this.results.$element.append( this.rows[ row ].$element );
	} else if ( this.rows[ row ].isFull ) {
		row++;
		// Create new row
		this.rows[ row ] = {
			isFull: false,
			width: 0,
			items: [],
			$element: $( '<div>' )
				.addClass( 've-ui-mwMediaResultWidget-row' )
				.css( {
					overflow: 'hidden'
				} )
				.data( 'row', row )
				.attr( 'data-full', false )
		};
		// Append to results
		this.results.$element.append( this.rows[ row ].$element );
	}

	return row;
};

/**
 * Respond to add results event in the results widget.
 * Override the way SelectWidget and GroupElement append the items
 * into the group so we can append them in groups of rows.
 *
 * @param {ve.ui.MWMediaResultWidget[]} items An array of item elements
 */
ve.ui.MWMediaSearchWidget.prototype.onResultsAdd = function ( items ) {
	var search = this;

	// Add method to a queue; this queue will only run when the widget
	// is visible
	this.layoutQueue.push( function () {
		var i, j, ilen, jlen, itemWidth, row, effectiveWidth,
			resizeFactor,
			maxRowWidth = search.results.$element.width() - 15;

		// Go over the added items
		row = search.getAvailableRow();
		for ( i = 0, ilen = items.length; i < ilen; i++ ) {
			itemWidth = items[ i ].$element.outerWidth( true );

			// Add items to row until it is full
			if ( search.rows[ row ].width + itemWidth >= maxRowWidth ) {
				// Mark this row as full
				search.rows[ row ].isFull = true;
				search.rows[ row ].$element.attr( 'data-full', true );

				// Find the resize factor
				effectiveWidth = search.rows[ row ].width;
				resizeFactor = maxRowWidth / effectiveWidth;

				search.rows[ row ].$element.attr( 'data-effectiveWidth', effectiveWidth );
				search.rows[ row ].$element.attr( 'data-resizeFactor', resizeFactor );
				search.rows[ row ].$element.attr( 'data-row', row );

				// Resize all images in the row to fit the width
				for ( j = 0, jlen = search.rows[ row ].items.length; j < jlen; j++ ) {
					search.rows[ row ].items[ j ].resizeThumb( resizeFactor );
				}

				// find another row
				row = search.getAvailableRow();
			}

			// Add the commulative
			search.rows[ row ].width += itemWidth;

			// Store reference to the item and to the row
			search.rows[ row ].items.push( items[ i ] );
			items[ i ].setRow( row );

			// Append the item
			search.rows[ row ].$element.append( items[ i ].$element );
		}

		// If we have less than 4 rows, call for more images
		if ( search.rows.length < 4 ) {
			search.queryMediaQueue();
		}
	} );
	this.runLayoutQueue();
};

/**
 * Run layout methods from the queue only if the element is visible.
 */
ve.ui.MWMediaSearchWidget.prototype.runLayoutQueue = function () {
	var i, len;

	if ( this.$element.is( ':visible' ) ) {
		for ( i = 0, len = this.layoutQueue.length; i < len; i++ ) {
			this.layoutQueue.pop()();
		}
	}
};

/**
 * Respond to removing results event in the results widget.
 * Clear the relevant rows.
 *
 * @param {OO.ui.OptionWidget[]} items Removed items
 */
ve.ui.MWMediaSearchWidget.prototype.onResultsRemove = function ( items ) {
	if ( items.length > 0 ) {
		// In the case of the media search widget, if any items are removed
		// all are removed (new search)
		this.resetRows();
		this.currentItemCache = [];
	}
};

/**
 * Set language for the search results.
 *
 * @param {string} lang Language
 */
ve.ui.MWMediaSearchWidget.prototype.setLang = function ( lang ) {
	this.lang = lang;
};

/**
 * Get language for the search results.
 *
 * @return {string} lang Language
 */
ve.ui.MWMediaSearchWidget.prototype.getLang = function () {
	return this.lang;
};
