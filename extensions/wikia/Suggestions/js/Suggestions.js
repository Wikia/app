require( [ 'jquery', 'wikia.log', 'SuggestionsView' ], function( $, log, view ) {
	'use strict';
	log('New search suggestions loading...', log.levels.info, 'suggestions');
	$(function() {
		window.Wikia.newSearchSuggestions =  view.init(
			$('#WikiaSearch input[name="search"]'),
			$('#WikiaSearch').find('ul.search-suggest').first(),
			window.wgCityId
		);
		log('New search suggestions loaded!', log.levels.info, 'suggestions');
		window.Wikia.newSearchSuggestions.setAsMainSuggestions( 'search' );
	});
});
