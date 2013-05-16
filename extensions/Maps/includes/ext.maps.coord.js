/**
 * JavasSript for coordinate handling in the Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Maps
 * 
 * @since 1.0
 * @ingroup Maps
 * 
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */
window.coord = new ( function( $ ) {
	
	/**
	 * The separator used between latitude and longitude in a coordinate set.
	 * @const
	 * @type {string}
	 */
	this.SEPARATOR = ',';
	
	/**
	 * The delimiter used between coordinate sets.
	 * @const
	 * @type {string}
	 */
	this.DELIMITER = ';';
	
	/**
	 * Returns a list with coordinates obtained by splitting the provided string.
	 * @param {string} coords The coordinates to split.
	 * @return {Array} The split coordinates.
	 */
	this.split = function( coords ) {
		coords = coords.split( this.DELIMITER );
		for ( i in coords ) coords[i] = coords[i].trim(); 
		return coords;
	}
	
	/**
	 * Returns the provided coordinates joined in a string.
	 * @param {Array} coords The coordinates to join.
	 * @return {string} The joined coordinates.
	 */	
	this.join = function( coords ) {
		return coords.join( this.DELIMITER + ' ' );
	}
	
	/**
	 * Returns a string with the directional DMS representatation of the provided latitude and longitude.
	 * @param {float} lat The latitude.
	 * @param {float} lon The longitude.
	 * @return {string} The string with DMS coordinates.
	 */	
	this.dms = function( lat, lon ) { // TODO: i18n
		return Math.abs( lat ).toString() + '° ' + ( lat < 0 ? 'S' : 'N' ) 
				+ this.SEPARATOR + ' '
				+ Math.abs( lon ).toString() + '° ' + ( lon < 0 ? 'W' : 'E' );
	};
	
	/**
	 * Returns a string with the non-directional float representatation of the provided latitude and longitude.
	 * @param {float} lat The latitude.
	 * @param {float} lon The longitude.
	 * @return {string} The string with float coordinates.
	 */
	this.float = function( lat, lon ) {
		return lat.toString() + this.SEPARATOR + ' ' + lon.toString();
	};
	
	this.parse = function( coord ) {
		coord = coord.split( this.SEPARATOR );
		if ( coord.length != 2 ) return false;
		
		var lat = coord[0].trim();
		var lon = coord[1].trim();
		var parsed;
		
		parsed = this.parseFloat( lat, lon );
		if ( parsed !== false ) return parsed;
		
		parsed = this.parseDMS( lat, lon );
		if ( parsed !== false ) return parsed;		
		
		return false;
	};
	
	this.parseDMS = function( lat, lon ) {
		if ( this.isDMS( lat, lon ) ) {
			// TODO
		}
		else {
			return false;
		}
	};
	
	this.parseFloat = function( lat, lon ) {
		if ( this.isFloat( lat, lon ) ) {
			return { lat: parseFloat( lat ), lon: parseFloat( lon ) };
		}
		else {
			return false;
		}		
	};
	
	this.isFloat = function( lat, lon ) {
		var regex = /(-)?\d{1,3}(\.\d{1,20})?$/;
		return regex.test( lat ) && regex.test( lon );
	};
	
	this.isDMS = function( lat, lon ) {
		var regex = ''; // TODO
		return regex.test( lat ) && regex.test( lon );
	};
	
} )( jQuery );