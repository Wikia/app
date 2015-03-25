/*!
 * VisualEditor UserInterface WikiaTemplateSearchWidget class.
 */

/* global mw */

/**
 * @class
 * @extends OO.ui.SearchWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @param {string|jQuery} [config.placeholder] Placeholder text for query input
 * @param {string} [config.value] Initial query input value
 */
ve.ui.WikiaTemplateSearchWidget = function VeUiWikiaTemplateSearchWidget( config ) {
	// Configuration intialization
	config = config || {};

	// Parent constructor
	ve.ui.WikiaTemplateSearchWidget.super.call( this, config );

	// Properties
	this.suggestions = new OO.ui.SelectWidget( { '$': this.$ } );
	this.$suggestions = this.$( '<div>' );
	this.request = null;
	this.timeout = null;
	this.suggestionsOffset = 0;
	this.chunkedResults = 30;

	// Events
	this.$results.on( 'scroll', ve.bind( this.onResultsScroll, this ) );
	this.$suggestions.on( 'scroll', ve.bind( this.onSuggestionsScroll, this ) );
	this.suggestions.connect( this, {
		'highlight': 'onSuggestionsHighlight',
		'select': 'onSuggestionsSelect'
	} );

	// Initialization
	this.$suggestions
		.addClass( 'oo-ui-searchWidget-results ve-ui-wikiaTemplateSearchWidget-suggestions' )
		.append( this.suggestions.$element );
	// The "clearfix" class clears floated elements in order to give the container element
	// a proper height. This allows checking of the container height for the scroll events.
	this.suggestions.$element.addClass( 'clearfix' );
	this.results.$element.addClass( 'clearfix' );
	this.$element.prepend( this.$suggestions );
	// Hide search results in order to show suggestions first
	this.$results.hide();
	this.requestSuggestions();
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaTemplateSearchWidget, OO.ui.SearchWidget );

/* Methods */

ve.ui.WikiaTemplateSearchWidget.prototype.onSuggestionsHighlight = ve.ui.WikiaTemplateSearchWidget.super.prototype.onResultsHighlight;

ve.ui.WikiaTemplateSearchWidget.prototype.onSuggestionsSelect = ve.ui.WikiaTemplateSearchWidget.super.prototype.onResultsSelect;

/**
 * @inheritdoc
 */
ve.ui.WikiaTemplateSearchWidget.prototype.onQueryChange = function () {
	ve.ui.WikiaTemplateSearchWidget.super.prototype.onQueryChange.call( this );
	if ( this.request ) {
		this.request.abort();
	}
	clearTimeout( this.timeout );

	this.allResults = [];
	this.resultsOffset = 0;

	this.value = this.query.getValue();
	if ( this.value.trim().length !== 0 ) {
		this.timeout = setTimeout( ve.bind( this.requestSearch, this ), 200 );
		this.$suggestions.hide();
		this.$results.show();
	} else {
		this.$results.hide();
		this.$suggestions.show();
	}
};

/**
 * Handle results scroll event
 */
ve.ui.WikiaTemplateSearchWidget.prototype.onResultsScroll = function () {
	var position = this.$results.scrollTop() + this.$results.outerHeight(),
		threshold = this.results.$element.outerHeight() - 100;
	if ( !this.query.isPending() && this.resultsOffset < this.allResults.length && position > threshold ) {
		this.displayResults();
	}
};

/**
 * Handle suggestions scroll event
 */
ve.ui.WikiaTemplateSearchWidget.prototype.onSuggestionsScroll = function () {
	var position = this.$suggestions.scrollTop() + this.$suggestions.outerHeight(),
		threshold = this.suggestions.$element.outerHeight() - 100;
	if ( this.suggestionsPending !== true && position > threshold ) {
		this.requestSuggestions();
	}
};

/**
 * Display results
 */
ve.ui.WikiaTemplateSearchWidget.prototype.displayResults = function () {
	var results = this.allResults.slice( this.resultsOffset, this.resultsOffset + this.chunkedResults );
	this.resultsOffset += this.chunkedResults;
	this.results.addItems( this.getOptionsFromData( results ) );
};

/**
 * Display template suggestions
 *
 * @param {Array} data Template info
 */
ve.ui.WikiaTemplateSearchWidget.prototype.displaySuggestions = function ( data ) {
	this.suggestions.addItems( this.getOptionsFromData( data ) );
};

/**
 * Create option widgets from the given template data
 *
 * @param {Array} data Template info
 */
ve.ui.WikiaTemplateSearchWidget.prototype.getOptionsFromData = function ( data ) {
	var i, options = [];

	for ( i = 0; i < data.length; i++ ) {
		options.push(
			new ve.ui.WikiaTemplateOptionWidget(
				data[i],
				{
					'$': this.$,
					'icon': 'template-inverted',
					'label': data[i].title,
					'appears': data[i].uses || null
				}
			)
		);
	}

	return options;
};

/**
 * Make API request for template search query
 */
ve.ui.WikiaTemplateSearchWidget.prototype.requestSearch = function () {
	this.query.pushPending();
	this.request = $.ajax( {
		'url': mw.util.wikiScript( 'api' ),
		'data': {
			'format': 'json',
			'action': 'templatesearch',
			'query': this.value
		}
	} )
		.always( ve.bind( this.onRequestSearchAlways, this ) )
		.done( ve.bind( this.onRequestSearchDone, this ) );
};

/**
 * Make API request for template suggestions
 */
ve.ui.WikiaTemplateSearchWidget.prototype.requestSuggestions = function () {
	this.suggestionsPending = true;
	this.request = $.ajax( {
		'url': mw.util.wikiScript( 'api' ),
		'data': {
			'format': 'json',
			'action': 'templatesuggestions',
			'offset': this.suggestionsOffset
		}
	} )
		.always( ve.bind( this.onRequestSuggestionsAlways, this ) )
		.done( ve.bind( this.onRequestSuggestionsDone, this ) );
};

/**
 * Handle search request promise.always
 */
ve.ui.WikiaTemplateSearchWidget.prototype.onRequestSearchAlways = function () {
	this.request = null;
	this.query.popPending();
};

/**
 * Handle search request promise.done
 *
 * @param {Object} data The response object
 */
ve.ui.WikiaTemplateSearchWidget.prototype.onRequestSearchDone = function ( data ) {
	var i;

	if ( !data.templates ) {
		return;
	}

	for ( i = 0; i < data.templates.length; i++ ) {
		this.allResults.push( {
			'title': data.templates[i]
		} );
	}

	// Track
	ve.track( 'wikia', {
		'action': ve.track.actions.SUCCESS,
		'label': 'template-insert-search'
	} );

	this.displayResults();
};

/**
 * Handle suggestions request promise.always
 */
ve.ui.WikiaTemplateSearchWidget.prototype.onRequestSuggestionsAlways = function () {
	this.request = null;
	this.suggestionsPending = false;
};

/**
 * Handle suggestions request promise.done
 *
 * @param {Object} data The response object
 */
ve.ui.WikiaTemplateSearchWidget.prototype.onRequestSuggestionsDone = function ( data ) {
	if ( !data.templates ) {
		return;
	}

	if ( data['query-continue'] ) {
		this.suggestionsOffset = data['query-continue'];
	} else {
		// Remove the scroll event handler, so that no more suggestions are requested
		this.$suggestions.off( 'scroll' );
	}
	this.displaySuggestions( data.templates );
};

/**
 * Reset the widget to the default view state
 */
ve.ui.WikiaTemplateSearchWidget.prototype.reset = function () {
	// Unselect any selected item in either suggestions or results list
	this.suggestions.selectItem();
	this.results.selectItem();
	// Reset search input value
	this.query.setValue( '' );
	// Scroll to top of suggestions
	this.$suggestions.get( 0 ).scrollTop = 0;
};

/**
 * Set focus on the query input
 */
ve.ui.WikiaTemplateSearchWidget.prototype.focusQuery = function () {
	this.query.focus();
};
