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
	this.results = new ve.ui.SelectWidget( { '$$': this.$$ } );
	this.size = config.size || 160;

	// Events
	this.results.connect( this, {
		'highlight': 'onResultsHighlight',
		'select': 'onResultsSelect'
	} );
	this.$.on( 'scroll', ve.bind( this.onResultsScroll, this ) );

	// Initialization
	this.$
		.addClass( 've-ui-wikiaMediaResultsWidget' )
		.append( this.results.$ );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaResultsWidget, ve.ui.Widget );

/* Methods */

ve.ui.WikiaMediaResultsWidget.prototype.addResults = function ( items ) {
	var i,
		results = [];

	for ( i = 0; i < items.length; i++ ) {
		results.push(
			new ve.ui.WikiaMediaResultWidget( items[i], { '$$': this.$$, 'size': this.size } )
		);
	}

	this.results.addItems( results );
};

ve.ui.WikiaMediaResultsWidget.prototype.getResults = function () {
	return this.results;
};

ve.ui.WikiaMediaResultsWidget.prototype.onResultsScroll = function () {
	var position = this.$.scrollTop() + this.$.outerHeight(),
		threshold = this.results.$.outerHeight() - this.size;
	if ( position > threshold ) {
		this.emit( 'end' );
	}
};

ve.ui.WikiaMediaResultsWidget.prototype.onResultsHighlight =
	ve.ui.SearchWidget.prototype.onResultsHighlight;

ve.ui.WikiaMediaResultsWidget.prototype.onResultsSelect =
	ve.ui.SearchWidget.prototype.onResultsSelect;
