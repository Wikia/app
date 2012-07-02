(function( $, mw, undefined ) {

var MobileFrontend2 = mf2 = {
	/**
	 * Timer for updating search suggestions
	 */
	searchTimer: undefined,

	/**
	 * mw.Api object for accessing the API
	 *
	 * @var api {mw.Api}
	 */
	api: undefined,

	/**
	 * Run to set up the page
	 */
	init: function() {
		// Create our API object
		mf2.api = new mw.Api();

		// Hook the section toggle
		$( '.mf2-section-container h2' ).click( mf2.toggleSection );

		// Listen for searches
		$( '#search' ).keyup( mf2.searchKeyUp );

		// Setup the width for search
		// TODO: Only worry about this if we have the search element
		mf2.updateSearchWidth();
	},

	/**
	 * Toggles page section visibility
	 */
	toggleSection: function() {
		var $header = $( this ),
			$contentDiv = $header.next(),
			buttonMsg;

		// Toggle the div
		$contentDiv.toggle();

		// Change the button text
		buttonMsg = $contentDiv.css( 'display' ) === 'block' ? 'mobile-frontend2-hide-button' : 'mobile-frontend2-show-button';
		$header.find( 'button' ).html( mw.msg( buttonMsg ) );
	},

	/**
	 * Schedules an update of search suggestions
	 *
	 * Fired when data is entered into the search box
	 */
	searchKeyUp: function() {
		clearTimeout( mf2.searchTimer );

		if ( this.value.length < 1 ) {
			$( '#results' ).html( '' );
		} else {
			// TODO: Config
			mf2.searchTimer = setTimeout( mf2.search, 500 );
		}
	},

	/**
	 * Fires off the request to the API to get search results
	 */
	search: function() {
		mf2.api.get( {
			action: 'opensearch',
			limit: 5,
			namespace: 0,
			search: $( '#search' ).val()
		}, mf2.searchResults );
	},

	/**
	 * Update the search suggestions with API results
	 *
	 * @param data
	 */
	searchResults: function( data ) {
		var results = data[1], // Second element has the results, fuck standards
			$results = $( '#results' );

		$results.show();
		if ( results.length < 1 ) {
			$results.text( 'No results' ); // TRANSLATE
			return;
		}

		$r = $( '<div class="suggestions-results">' );

		$.each( results, function( i, title ) {
			$( '<div class="suggestions-result">' )
				.attr( 'title', title )
				.attr( 'rel', i + 1 ) // ?
				.append(
					$( '<a class="sq-val-update">' )
						.text( '+' ) // Translate?
						.click( mf2.updateSearchValue )
				)
				.append(
					$( '<a class="search-result-item">' )
						.attr( 'href', mw.util.wikiGetlink( title ) )
						.text( title )
				)
				.appendTo( $r );
		} );

		$results.html( $r );
	},

	/**
	 * Update the value of the search box with the selected suggestion
	 *
	 * Fire when the plus symbol is clicked
	 */
	updateSearchValue: function () {
		var title = $( this ).parent().attr( 'title' );

		$( '#search' )
			.val( title + ' ' )
			.focus();

		// Reload suggestions
		mf2.search();
	},

	/**
	 * Updates the width of the header and search box
	 *
	 * Fired when the screen orientation changes
	 */
	updateSearchWidth: function () {
		var clientWidth = $( window ).width(),
			$sq = $( '#sq' ),
			sqOffset = $sq.offset();

		// TODO: ew. This should be CSS
		$( '#searchbox' ).width( clientWidth - 30 );
		$sq.width( clientWidth - 110 );
		$( '#search' ).width( clientWidth - 130 );
		$( '#results' ).css({
			width: $sq.width() - 2,
			left: sqOffset.left,
			top: sqOffset.top + $sq.height()
		});
	}
};

$( mf2.init );

})( Zepto, MediaWiki );