/**
 * Common JavasSript for the Ratings extension.
 * @see http://www.mediawiki.org/wiki/Extension:Ratings
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

window.ratings = new ( function( $ ) {
	
	/**
	 * Obtain the vote values for a set of tags of a single page,
	 * and then find and update the corresponding rating stars.
	 * 
	 * @param {string} page
	 * @param {Array} tags
	 * @param {callback} callback
	 */
	this.getRatingsForPage = function( page, tags, callback ) {
		$.getJSON(
			wgScriptPath + '/api.php',
			{
				'action': 'query',
				'format': 'json',
				'list': 'ratings',
				'qrpage': page,
				'qrtags': tags.join( '|' )
			},
			function( data ) {
				if ( data.userratings ) {
					callback( page, data.userratings );
				}
				else {
					// TODO
				}
			}
		); 		
	};
	
	/**
	 * Submit a rating.
	 * 
	 * @param {string} page
	 * @param {string} tag
	 * @param {integer} value
	 */
	this.submitRating = function( page, tag, value ) {
		$.post(
			wgScriptPath + '/api.php',
			{
				'action': 'dorating',
				'format': 'json',
				'pagename': page,
				'tag': tag,
				'value': value
			},
			function( data ) {
				if ( data.error && data.error.info ) {
					alert( data.error.info );
				}				
				else if ( data.result.success ) {
					// TODO
				}
				else {
					alert( 'Failed to submit rating' ) // TODO
				}
			},
			'json'
		);
	};
	
} )( jQuery );
