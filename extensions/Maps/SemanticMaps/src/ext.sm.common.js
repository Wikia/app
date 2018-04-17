/**
 * JavaScript the Semantic Maps extension.
 * @see https://www.mediawiki.org/wiki/Extension:Semantic_Maps
 *
 * @licence GNU GPL v2++
 * @author Peter Grassberger < petertheone@gmail.com >
 */
window.sm = new ( function( $, mw ) {

	this.buildQueryString = function( query, ajaxcoordproperty, top, right, bottom, left ) {
		var isCompoundQuery = query.indexOf( '|' ) > -1;
		var query = query.split( '|' );
		$.each( query, function( index ) {
			query[index] += ' [[' + ajaxcoordproperty + '::+]] ';
			query[index] += '[[' + ajaxcoordproperty + '::>' + bottom + '°, ' + left + '°]] ';
			query[index] += '[[' + ajaxcoordproperty + '::<' + top + '°, ' + right + '°]]';
			if( !isCompoundQuery ) {
				query[index] += '|?' + ajaxcoordproperty;
			} else {
				query[index] += ';?' + ajaxcoordproperty;
			}
		} );
		return query.join( ' | ' );
	};

	/**
	 * Detects semicolons `;` not in square brackets `[]`.
	 *
	 * @param string
	 * @returns {boolean}
	 */
	this.hasCompoundQuerySemicolon = function( string ) {
		return /;(?![^[]*])/g.test( string );
	};

	this.sendQuery = function( query ) {
		var action = this.hasCompoundQuerySemicolon( query ) ? 'compoundquery' : 'ask';
		return $.ajax( {
			method: 'GET',
			url: mw.util.wikiScript( 'api' ),
			data: {
				'action': action,
				'query': query,
				'format': 'json'
			},
			dataType: 'json'
		} );
	};

	this.ajaxUpdateMarker = function( map, query, icon ) {
		return this.sendQuery( query ).done( function( data ) {
			if( !data.hasOwnProperty( 'query' ) ||
				!data.query.hasOwnProperty( 'results' ) ) {
				return;
			}
			// todo: don't remove and recreate all markers..
			// only add new ones.
			map.removeMarkers();
			for( var property in data.query.results ) {
				if( data.query.results.hasOwnProperty( property ) ) {
					var location = data.query.results[property];
					var coordinates = location.printouts[map.options.ajaxcoordproperty][0];
					var markerOptions = {
						lat: coordinates.lat,
						lon: coordinates.lon,
						title: location.fulltext,
						text: '<b><a href="' + location.fullurl + '">' + location.fulltext + '</a></b>',
						icon: icon
					};
					map.addMarker( markerOptions );
				}
			}
		} );
	};

} )( jQuery, mediaWiki );
