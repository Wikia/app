define('SuggestionsClient', ['jquery', 'SuggestionsMatcher', 'wikia.log'], function($, matcher, log) {
	'use strict';
	log('Building client', log.levels.info, 'suggestions');
	var cache = {},
		pending = {},
		errors = 0,
		uid = new Date().getTime(),
		endpointUrl = 'http://search-suggest.wikia.net/web/api/search-suggest';

	function writeToCache(key, data) {
		cache[ key ] = data;
	}
	function getFromCache(key) {
		if(cache[key]) {
			log( key + 'from cache: ', log.levels.info, 'suggestions' );
			return cache[key];
		} else {
			return false;
		}
	}
	function isPending(key) {
		if (pending[key]) {
			return true;
		} else {
			pending[key] = true;
			return false;
		}
	}
	function notPending(key) {
		pending[key] = false;
	}

	return {
		getSuggestions: function( wiki, query, cb ) {
			var cacheKey = wiki + '_' + query,
				data = getFromCache(cacheKey);
			if( data ) {
				cb( data );
			} else {
				if ( !wiki || !query || query === '' ) {
					cb( [] );
					return;
				}
				if ( isPending(cacheKey) ) { return; }
				$.getJSON( endpointUrl,
					{
						q: query,
						wikiId: wiki,
						bid: window.beacon_id,
						user: window.wgUserName,
						page: window.wgPageName,
						uid: uid
					},
					function( response ) {
						var suggestion,
							matchResult,
							i;
						for ( i = 0; i<response.length; i++ ) {
							suggestion = response[i];
							matchResult = matcher.matchSuggestion( suggestion, query );
							if ( !matchResult ) {
								log( 'Match failed for ' + suggestion.title + ' ' + query, log.levels.info, 'suggestions' );
							}
							suggestion.match = matchResult;
						}
						writeToCache(cacheKey, response);
						cb(response);
					}).fail( function() {
						//wait for at least two errors, before switching to old suggestions
						if ( window.Wikia.newSearchSuggestions && ++errors >= 2 ) {
							log('New search suggestions failed, returning to old ones!', log.levels.info, 'suggestions');
							window.Wikia.newSearchSuggestions.setOldSuggestionsOn( 'search' );
						}
					}).always( function() {
						log('Not pending anymore: ' + query, log.levels.info, 'suggestions');
						notPending(cacheKey);
					});
			}
		}
	};
});
