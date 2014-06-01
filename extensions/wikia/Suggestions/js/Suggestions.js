require( [ 'jquery', 'wikia.log', 'SuggestionsView' ], function( $, log, view ) {
	'use strict';
	log('New search suggestions loading...', log.levels.info, 'suggestions');
	$(function() {
		window.Wikia.newSearchSuggestions =  view.init(
			$('#WikiaSearch input[name="search"]'),
			$('#WikiaSearch').nextAll('ul.search-suggest').first(),
			window.wgCityId
		);
		if ( window.Wikia.newSearchSuggestions ) {
			window.Wikia.newSearchSuggestions.setAsMainSuggestions( 'search' );
			log('New search suggestions loaded!', log.levels.info, 'suggestions');
		} else {
			log('New search suggestions failed!', log.levels.info, 'suggestions');
		}
	});
});
