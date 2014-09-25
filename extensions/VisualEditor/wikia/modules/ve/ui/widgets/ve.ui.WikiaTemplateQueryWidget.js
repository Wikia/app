/*!
 * VisualEditor UserInterface WikiaTemplateQueryWidget class.
 */

/* global mw */

/**
 * @class
 * @extends OO.ui.Widget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @param {string|jQuery} [config.placeholder] Placeholder text for query input
 * @param {string} [config.value] Initial query input value
 */
ve.ui.WikiaTemplateQueryWidget = function VeUiWikiaTemplateQueryWidget( config ) {
	// Configuration intialization
	config = config || {};

	// Parent constructor
	ve.ui.WikiaTemplateQueryWidget.super.call( this, config );

	// Properties
	this.batch = 1;
	this.input = new OO.ui.ClearableTextInputWidget( {
		'$': this.$,
		'icon': 'search',
		'placeholder': config.placeholder
	} );
	this.request = null;
	this.requestCallback = ve.bind( this.requestMedia, this );
	this.timeout = null;
	this.$outerWrapper = this.$( '<div>' );
	this.$inputWrapper = this.$( '<div>' );

	// Events
	this.input.connect( this, { 'change': 'onInputChange' } );

	// Initialization
	this.$inputWrapper
		.addClass( 've-ui-wikiaTemplateQueryWidget-queryWrapper' )
		.append( this.input.$element );
	this.$outerWrapper
		.addClass( 've-ui-wikiaTemplateQueryWidget-wrapper' )
		.append( this.$inputWrapper );
	this.$element
		.addClass( 've-ui-wikiaTemplateQueryWidget' )
		.append( this.$outerWrapper );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaTemplateQueryWidget, OO.ui.Widget );

/* Methods */

/**
 * Get the query input.
 *
 * @method
 * @returns {OO.ui.TextInputWidget} Query input
 */
ve.ui.WikiaTemplateQueryWidget.prototype.getInput = function () {
	return this.input;
};

/**
 * @method
 */
ve.ui.WikiaTemplateQueryWidget.prototype.search = function () {
	this.input.pushPending();
	this.request = $.ajax( {
		'url': mw.util.wikiScript( 'api' ),
		'data': {
			'format': 'json',
			'action': 'templatesearch',
			'query': this.value
		}
	} )
		.always( ve.bind( this.onSearchAlways, this ) )
		.done( ve.bind( this.onSearchDone, this ) );
};

/**
 * Handle query input changes.
 *
 * @method
 */
ve.ui.WikiaTemplateQueryWidget.prototype.onInputChange = function () {
	if ( this.request ) {
		this.request.abort();
	}
	clearTimeout( this.timeout );
	this.batch = 1;
	this.value = this.input.getValue();
	if ( this.value.trim().length !== 0 ) {
		this.timeout = setTimeout( ve.bind( this.search, this ), 200 );
	}
};

/**
 * Handle search request promise.always
 *
 * @method
 */
ve.ui.WikiaTemplateQueryWidget.prototype.onSearchAlways = function () {
	this.request = null;
	this.input.popPending();
};

/**
 * Handle search request promise.done
 *
 * @method
 * @param {Object} data The response Object from the server.
 * @fires requestSearchDone
 */
ve.ui.WikiaTemplateQueryWidget.prototype.onSearchDone = function ( data ) {
	if ( !data.templates ) {
		return;
	}

	this.batch++;
	this.emit( 'searchDone', data.templates );
};
