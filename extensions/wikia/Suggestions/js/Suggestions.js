require( [ 'jquery', 'wikia.log', 'SuggestionsView' ], function( $, log, view ) {
	'use strict';
	log('New search suggestions loading...', log.levels.info, 'suggestions');
	$(function() {
		window.Wikia.newSearchSuggestions =  view.init(
			$('#WikiaSearch input[name="search"]'),
			$('ul.search-suggest'),
			window.wgCityId
		);
		log('New search suggestions loaded!', log.levels.info, 'suggestions');
		window.Wikia.newSearchSuggestions.setAsMainSuggestions( 'search' );
	});
});
