define("client", ["jquery", "suggest_matcher", "wikia.log"], function($, matcher, log) {
	log("Building client", log.levels.info, "suggestions");
	var cache = {},
		pending = {},
		errors = 0,
		uid = new Date().getTime();
	return {
		getSuggestions: function( wiki, query, cb ) {
			var cacheKey = wiki + "_" + query;
			if ( cache[cacheKey] ) {
				log( cacheKey + "from cache: ", log.levels.info, "suggestions" );
				cb( cache[cacheKey] );
			} else {
				if ( !wiki || !query || query == '' ) {
					cb( [] );
					return;
				}
				if ( pending[cacheKey] ) return;
				pending[cacheKey] = true;
				$.getJSON( "http://db-sds-s1/web/api/search-suggest",
					{
						q: query,
						wikiId: wiki,
						bid: window.beacon_id,
						user: wgUserName,
						page: wgPageName,
						uid: uid
					},
					function( response ) {
						for ( var i = 0; i<response.length; i++ ) {
							var suggestion = response[i];
							var matchResult = matcher.matchSuggestion( suggestion, query );
							if ( !matchResult ) {
								log( "match failed for " + suggestion.title + " " + query, log.levels.info, "suggestions" );
							}
							suggestion.match = matchResult;
						}
						cache[cacheKey] = response;
						cb(response);
					}).fail( function() {
						//wait for at least two errors, before switching to old suggestions
						if ( window.Wikia.newSearchSuggestions && ++errors >= 2 ) {
							log("New search suggestions failed, returning to old ones!", log.levels.info, "suggestions");
							window.Wikia.newSearchSuggestions.setOldSuggestionsOn( 'search' );
						}
					}).always( function() {
						log("Not pending anymore: " + query, log.levels.info, "suggestions");
						pending[cacheKey] = false;
					});
			}
		}
	};
});
