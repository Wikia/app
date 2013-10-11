define("client", ["jquery", "suggest_matcher", "wikia.log" ], function($, matcher, log) {
	log("Building client", log.levels.info, "suggestions");
	return {
		getSuggestions: function( wiki, query, cb ) {
			if ( !wiki || !query || query == '' ) cb( [], false );
			$.getJSON( "http://db-sds-s1:13000/api/wiki/" + wiki + "/suggest/" + query, function( response ) {
				for ( var i = 0; i<response.length; i++ ) {
					var suggestion = response[i];
					var matchResult = matcher.matchSuggestion( suggestion, query );
					if ( !matchResult ) {
						log( "match failed for " + suggestion.title + " " + query, log.levels.info, "suggestions" );
					}
					suggestion.match = matchResult;
				}
				cb(response, false);
			} )
		}
	};
});