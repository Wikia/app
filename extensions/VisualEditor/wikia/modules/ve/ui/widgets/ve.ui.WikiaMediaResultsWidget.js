/*!
 * VisualEditor UserInterface WikiaMediaResultsWidget class.
 */

/**
 * @class
 * @extends ve.ui.Widget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @param {number} [size] Vertical size of thumbnails
 */
ve.ui.WikiaMediaResultsWidget = function VeUiWikiaMediaResultsWidget( config ) {
	// Parent constructor
	ve.ui.Widget.call( this, config );

	// Properties
	this.results = new ve.ui.WikiaMediaSelectWidget( { '$$': this.$$ } );
	this.size = config.size || 160;

	// Events
	this.results.connect( this, {
		'highlight': 'onResultsHighlight',
		'select': 'onResultsSelect',
		'check': 'onResultsCheck'
	} );
	this.$.on( 'scroll', ve.bind( this.onResultsScroll, this ) );

	// Initialization
	this.$
		.addClass( 've-ui-wikiaMediaResultsWidget' )
		.append( this.results.$ );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaResultsWidget, ve.ui.Widget );

/* Events */

/**
 * @event nearingEnd
 */

/* Methods */

/**
 * Handle check/uncheck of items in search results.
 *
 * @method
 * @param {ve.ui.WikiaMediaOptionWidget} item Item whose state is changing
 */
ve.ui.WikiaMediaResultsWidget.prototype.onResultsCheck = function ( item ) {
	this.emit( 'check', item.getModel() );
};

/**
 * Handle selecting results.
 *
 * @method
 * @param {ve.ui.WikiaMediaOptionWidget} item Item whose state is changing
 */
ve.ui.WikiaMediaResultsWidget.prototype.onResultsSelect = function ( item ) {
	if ( item && !this.mediaPreview ) {
 		this.mediaPreview = new ve.ui.WikiaMediaPreviewWidget( item.model );
		this.mediaPreview.on( 'remove', ve.bind( function() {
			this.mediaPreview = null;
		}, this ) );
 	}

	//Parent
	ve.ui.SearchWidget.prototype.onResultsSelect;
};

/**
 * Add items to the results.
 *
 * @method
 * @param {Array} items An array of items to add.
 */
ve.ui.WikiaMediaResultsWidget.prototype.addItems = function ( items ) {
	var i,
		results = [];

	for ( i = 0; i < items.length; i++ ) {
		results.push(
			new ve.ui.WikiaMediaOptionWidget( items[i], { '$$': this.$$, 'size': this.size } )
		);
	}

	this.results.addItems( results );
};

/**
 * Get the results.
 *
 * @method
 * @returns {ve.ui.SelectWidget} The results widget.
 */
ve.ui.WikiaMediaResultsWidget.prototype.getResults = function () {
	return this.results;
};

/**
 * Handle scrolling the results.
 *
 * @method
 * @fires nearingEnd
 */
ve.ui.WikiaMediaResultsWidget.prototype.onResultsScroll = function () {
	var position = this.$.scrollTop() + this.$.outerHeight(),
		threshold = this.results.$.outerHeight() - this.size;
	if ( position > threshold ) {
		this.emit( 'nearingEnd' );
	}
};

/**
 * Handle highlighting results.
 *
 * @method
 * @see {@link ve.ui.SearchWidget.prototype.onResultsHighlight}
 */
ve.ui.WikiaMediaResultsWidget.prototype.onResultsHighlight =
	ve.ui.SearchWidget.prototype.onResultsHighlight;
