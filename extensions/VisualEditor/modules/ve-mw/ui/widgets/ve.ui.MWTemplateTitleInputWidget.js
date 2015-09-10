/*!
 * VisualEditor UserInterface MWTemplateTitleInputWidget class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MWTemplateTitleInputWidget object.
 *
 * @class
 * @extends mw.widgets.TitleInputWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {number} [namespace] Namespace to prepend to queries. Defaults to template namespace.
 */
ve.ui.MWTemplateTitleInputWidget = function VeUiMWTemplateTitleInputWidget( config ) {
	config = ve.extendObject( {},  {
		namespace: mw.config.get( 'wgNamespaceIds' ).template
	}, config );

	// Parent constructor
	ve.ui.MWTemplateTitleInputWidget.super.call( this, config );

	this.showTemplateDescriptions = this.showDescriptions;
	// Clear the showDescriptions flag for subsequent requests as we implement
	// description fetch ourselves
	this.showDescriptions = false;

	// Properties
	this.descriptions = {};

	// Initialization
	this.$element.addClass( 've-ui-mwTemplateTitleInputWidget' );
};

/* Inheritance */
// ve-upstream-sync - review - @author: Inez Korczyński
OO.inheritClass( ve.ui.MWTemplateTitleInputWidget, OO.ui.TextInputWidget );

/* Methods */

/**
 * See the parent documentation at <https://doc.wikimedia.org/mediawiki-core/master/js/#!/api/mw.widgets.TitleInputWidget>
 */
ve.ui.MWTemplateTitleInputWidget.prototype.getLookupRequest = function () {
	var widget = this,
		originalResponse,
		promise = ve.ui.MWTemplateTitleInputWidget.super.prototype.getLookupRequest.call( this );

	if ( this.showTemplateDescriptions ) {
		return promise
			// Also get descriptions
			.then( function ( response ) {
				var xhr, index, params,
					pages = ( response.query && response.query.pages ) || {},
					titles = [];

				for ( index in pages ) {
					titles.push( pages[ index ].title );
				}

				originalResponse = response;

				if ( titles.length > 0 ) {
					params = {
						action: 'templatedata',
						titles: titles.join( '|' ),
						lang: mw.config.get( 'wgUserLanguage' )
					};
					if ( widget.showRedirects ) {
						params.redirects = '1';
					}
					xhr = new mw.Api().get( params );
					return xhr.promise( { abort: xhr.abort } );
				}
			} )
			.then( function ( templateDataResponse ) {
				var index, page,
					pages = ( templateDataResponse && templateDataResponse.pages ) || {};
				// Look for descriptions and cache them
				for ( index in pages ) {
					page = pages[ index ];
					// Cache descriptions
					widget.descriptions[ page.title ] = page.description;
				}
				// Return the original response
				return originalResponse;
			} )
			.promise( { abort: function () {} } );

	}

	return promise;
};

/**
 * See the parent documentation at <https://doc.wikimedia.org/mediawiki-core/master/js/#!/api/mw.widgets.TitleInputWidget>
 */
ve.ui.MWTemplateTitleInputWidget.prototype.getOptionWidgetData = function ( title ) {
	return ve.extendObject(
		ve.ui.MWTemplateTitleInputWidget.super.prototype.getOptionWidgetData.apply( this, arguments ),
		{ description: this.descriptions[ title ] }
	);
};
