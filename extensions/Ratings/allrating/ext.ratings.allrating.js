/**
 * JavasSript for the Ratings extension.
 * @see http://www.mediawiki.org/wiki/Extension:Ratings
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function($) { $( document ).ready( function() {
        
	var canRate = true; // TODO
	
	if ( !canRate && !window.wgRatingsShowDisabled ) {
		// If the user is not allowed to rate and ratings should not be
		// shown disabled for unauthorized users, simply don't bother any setup.
		return;
	}

	/**
	 * Loop over all rating elements for the page and set their value when available.
	 * 
	 * @param {string} page
	 * @param {Array} tagValues
	 */	
	function initRatingElementsForPage( page, tagValues ) {
		$.each($(".allrating"), function(i,v) {
			var self = $(this);
			
			if ( typeof self.attr( 'page' ) != 'undefined' && self.attr( 'page' ) == page ) {
				if ( typeof tagValues[self.attr( 'tag' )] != 'undefined' ) {
					self.allRating( 'setValue', tagValues[self.attr( 'tag' )] );
				}
			}
		});		
	}		
	
	/**
	 * Self executing function to setup the allrating rating elements on the page.
	 */	
	(function setupRatingElements() {
		var ratings = {};
		
		$.each($(".allrating"), function(i,v) {
			var self = $(this); 
			
			self.allRating({
				onClickEvent: function(input) {
					window.ratings.submitRating( self.attr( 'page' ), self.attr( 'tag' ), input.val() );
				},
				showHover: false
			});	
			
			if ( !ratings[self.attr( 'page' )] ) {
				ratings[self.attr( 'page' )] = [];
			}
			
			ratings[self.attr( 'page' )].push( self.attr( 'tag' ) );				
		});
		
		for ( i in ratings ) {
			window.ratings.getRatingsForPage( i, $.unique( ratings[i] ), initRatingElementsForPage );
		}
		
	})();
	
} ); })(jQuery);