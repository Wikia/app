/**
 * JavaScript for the form inputs of the Semantic Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Semantic_Maps
 * 
 * This jQuery plugin creates a simple interface consisting out of
 * a field with coordinates, a field for geocoding addresses and
 * a map that displays these locations.
 * 
 * jQuery plugins using this one can implement the following methods:
 * - showCoordinate( location { lat, lon } )
 * - geocodeAddress( string address )
 * 
 * @param {string} mapDivId
 * @param {Object} options
 * 
 * @since 1.0
 * @ingroup SemanticMaps
 * 
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */
(function( $, mw ){ $.fn.mapforminput = function( mapDivId, options ) {
	
	var self = this;
	
	/**
	 * Creates a string with the provided coordinates to populate the main input field with.
	 * @param {Array} locations
	 * @return {string}
	 */
	this.buildInputValue = function( locations ) {
		var floats = [];
		
		for ( i in locations ) {
			floats.push( coord.float( locations[i].lat, locations[i].lon ) );
		}
		
		return floats.join( '; ' );
	};	
	
	/**
	 * Populate the main input field with the provided coordinates.
	 * @param {Array} locations
	 */	
	this.updateInput = function( locations ) {
		this.input.attr( 'value', this.buildInputValue( locations ) );
	};
	
	this.input = $( '<input />' ).attr( {
		'type': 'text',
		'name': options.inputname,
		'id': mapDivId + '_values',
		'value': this.buildInputValue( options.locations ),
		'size': options.fieldsize
	} );
	
	var updateButton = $( '<button />' ).text( mw.msg( 'semanticmaps-updatemap' ) );
	
	updateButton.click( function() {
		var locations = coord.split( self.input.attr( 'value' ) );
		var location = coord.parse( locations[0] );
		
		if ( location !== false ) {
			self.showCoordinate( location );
		}
		
		return false;
	} );
	
	this.input.keypress( function( event ) {
		if ( event.which == '13' ) {
			event.preventDefault();
			updateButton.click();
		}
	} );
	
	this.geofield = $( '<input />' ).attr( {
		'type': 'text',
		'id': mapDivId + '_geofield',
		'value': mw.msg( 'semanticmaps_enteraddresshere' ),
		'style': 'color: darkgray',
		'size': options.fieldsize
	} );
	
	this.geofield.focus( function() {
		if ( this.value == mw.msg( 'semanticmaps_enteraddresshere' ) ) {
			this.value = '';
			$( this ).css( 'color', '' );
		}
	} );
	
	this.geofield.blur( function() {
		if ( this.value === '' ) {
			this.value = mw.msg( 'semanticmaps_enteraddresshere' );
			$( this ).css( 'color', 'darkgray' );
		}
	} );
	
	var geoButton = $( '<button />' ).text( mw.msg( 'semanticmaps_lookupcoordinates' ) );
	
	geoButton.click( function() {
		self.geocodeAddress( self.geofield.attr( 'value' ) );
		return false;
	} );
	
	this.geofield.keypress( function( event ) {
		if ( event.which == '13' ) {
			event.preventDefault();
			geoButton.click();
		}
	} );
	
	var mapDiv = $( '<div />' )
		.attr( {
			'id': mapDivId,
			'class': 'ui-widget ui-widget-content'
		} )
		.css( {
			'width': options.width,
			'height': options.height
		} );
	this.mapDiv = mapDiv;
	
	if ( this.showCoordinate ) {
		this.html( $( '<p />' ).append( this.input ).append( updateButton ) );
	}
	
	if ( options.geocodecontrol && this.geocodeAddress ) {
		this.append( $( '<p />' ).append( this.geofield ).append( geoButton ) );			
	}

	this.append( mapDiv );
	
	return this;
	
}; })( jQuery, mediaWiki );