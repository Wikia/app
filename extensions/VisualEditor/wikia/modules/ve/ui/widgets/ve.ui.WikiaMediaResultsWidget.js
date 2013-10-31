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
	this.results = new ve.ui.WikiaMediaResultsSelectWidget( { '$$': this.$$ } );
	this.size = config.size || 160;

	// Events
	this.results.connect( this, {
		'highlight': 'onResultsHighlight',
		'select': 'onResultsSelect',
		'state': 'onResultsState'
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
 * Handle state change
 *
 * @method
 * @param {ve.ui.WikiaMediaResultWidget} item Item whose state is changing
 */
ve.ui.WikiaMediaResultsWidget.prototype.onResultsState = function ( item ) {
	this.emit( 'state', item.getData() );
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
			new ve.ui.WikiaMediaResultWidget( items[i], { '$$': this.$$, 'size': this.size } )
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

/**
 * Handle selecting results.
 *
 * @method
 * @see {@link ve.ui.SearchWidget.prototype.onResultsSelect}
 */
ve.ui.WikiaMediaResultsWidget.prototype.onResultsSelect =
	ve.ui.SearchWidget.prototype.onResultsSelect;
