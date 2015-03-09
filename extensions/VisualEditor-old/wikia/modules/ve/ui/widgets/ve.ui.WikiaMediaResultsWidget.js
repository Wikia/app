/*!
 * VisualEditor UserInterface WikiaMediaResultsWidget class.
 */

/**
 * @class
 * @extends OO.ui.Widget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @param {number} [size] Vertical size of thumbnails
 */
ve.ui.WikiaMediaResultsWidget = function VeUiWikiaMediaResultsWidget( config ) {
	// Parent constructor
	ve.ui.WikiaMediaResultsWidget.super.call( this, config );

	// Properties
	this.results = new ve.ui.WikiaMediaSelectWidget( { '$': this.$ } );
	this.size = config.size || 158;

	// Events
	this.results.connect( this, {
		'highlight': 'onResultsHighlight',
		'select': 'onResultsSelect'
	} );
	this.$element.on( 'scroll', ve.bind( this.onResultsScroll, this ) );

	// Initialization
	this.$element
		.addClass( 've-ui-wikiaMediaResultsWidget' )
		.append( this.results.$element );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaMediaResultsWidget, OO.ui.Widget );

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
	this.emit( 'check', item );
};

/**
 * Handle metadata event
 *
 * @method
 * @param {ve.ui.WikiaMediaOptionWidget} item Item that fired the event
 * @param {jQuery.Event} event jQuery Event
 */
ve.ui.WikiaMediaResultsWidget.prototype.onResultsMetadata = function ( item, event ) {
	this.emit( 'metadata', item, event );
};

/**
 * Handle label event
 *
 * @method
 * @param {ve.ui.WikiaMediaOptionWidget} item Item that fired the event
 * @param {jQuery.Event} event jQuery Event
 */
ve.ui.WikiaMediaResultsWidget.prototype.onResultsLabel = function ( item, event ) {
	this.emit( 'label', item, event );
};

/**
 * Handle selecting results.
 *
 * @method
 * @param {ve.ui.WikiaMediaOptionWidget} item Item whose state is changing
 */
ve.ui.WikiaMediaResultsWidget.prototype.onResultsSelect = function ( item ) {
	if ( item ) {
		this.results.selectItem( null );
		this.emit( 'select', item );
	}
};

/**
 * Add items to the results.
 *
 * @method
 * @param {Array} items An array of items to add.
 */
ve.ui.WikiaMediaResultsWidget.prototype.addItems = function ( items ) {
	var i, optionWidget,
		results = [];
	for ( i = 0; i < items.length; i++ ) {
		optionWidget = ve.ui.WikiaMediaOptionWidget.newFromData( items[i], { '$': this.$, 'size': this.size } );
		optionWidget.connect( this, {
			'check': 'onResultsCheck',
			'metadata': 'onResultsMetadata',
			'label': 'onResultsLabel'
		} );
		results.push(
			optionWidget
		);
	}
	this.results.addItems( results );
};

/**
 * Get the results.
 *
 * @method
 * @returns {OO.ui.SelectWidget} The results widget.
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
	var position = this.$element.scrollTop() + this.$element.outerHeight(),
		threshold = this.results.$element.outerHeight() - this.size;
	if ( position > threshold ) {
		this.emit( 'nearingEnd' );
	}
};

/**
 * Handle highlighting results.
 *
 * @method
 * @see {@link OO.ui.SearchWidget.prototype.onResultsHighlight}
 */
ve.ui.WikiaMediaResultsWidget.prototype.onResultsHighlight =
	OO.ui.SearchWidget.prototype.onResultsHighlight;
