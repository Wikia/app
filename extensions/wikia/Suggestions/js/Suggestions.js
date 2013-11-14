require( [ 'jquery', 'wikia.log', 'SuggestionsView' ], function( $, log, view ) {
	'use strict';
	log('New search suggestions loading...', log.levels.info, 'suggestions');
	$(function() {
		//get suggestions box
		//main page
		var handle = $('#WikiaMainContent ul.search-suggest');
		//other pages
		if ( !handle.length ) {
			handle = $('#WikiaRail ul.search-suggest');
		}
		window.Wikia.newSearchSuggestions =  view.init(
			$('#WikiaSearch input[name="search"]'),
			handle,
			window.wgCityId
		);
		log('New search suggestions loaded!', log.levels.info, 'suggestions');
		window.Wikia.newSearchSuggestions.setAsMainSuggestions( 'search' );
	});
});
