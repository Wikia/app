/**
 * JavaSript for SRF sparkline format
 * @see http://www.semantic-mediawiki.org/wiki/Help:Sparkline format
 *
 * @since 1.8
 * @release 0.2
 *
 * @file
 * @ingroup SRF
 *
 * @licence GNU GPL v2 or later
 * @author mwjames
 */
( function( srf, $ ) {
	'use strict';

	/*global mw:true semanticFormats:true*/

	////////////////////////// PUBLIC METHODS ////////////////////////

	srf.formats = srf.formats || {};

	/**
	 * Constructor
	 * @var Object
	 */
	srf.formats.sparkline = function( settings ) {
		$.extend( this, settings );
		this.init();
	};

	srf.formats.sparkline.prototype = {

		init: function() {
			return this.context.each( function() {
				var chart = $( this ).find( '.container' ),
					chartID = chart.attr( 'id' ),
					json = mw.config.get( chartID );

				// Parse json string and convert it back
				var data = typeof json === 'string' ? jQuery.parseJSON( json ) : json;

				// Release graph and bottom text
				util.spinner.hide( { context: $( this ) } );

				// Release chart/graph
				chart.show();
				chart.sparkline( data.value , {
					type: data.charttype,
					tooltipFormat: '{{value}}{{y}} ({{offset:offset}})',
					tooltipValueLookups: {
						offset: data.label
					}
				} );
		} );
		}
	};

	/**
	 * Implementation and representation of the sparkline instance
	 * @since 1.8
	 * @type Object
	 */
	var util = new srf.util();

	$( document ).ready( function() {
		$( '.srf-sparkline' ).each( function() {
			new srf.formats.sparkline( { context: $( this ) } );
		} );
	} );
} )( semanticFormats, jQuery );