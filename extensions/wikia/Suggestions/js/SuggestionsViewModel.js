define('SuggestionsViewModel', ['jquery', 'SuggestionsMatcher', 'wikia.log', 'SuggestionsClient'],
	function($, matcher, log, client) {
	'use strict';
	var inUse = true,
		_ev = [],
		wiki, query, displayResults;
	function sendQuery() {
		var sentQuery = query;
		client.getSuggestions( wiki, query, function(res) {
			setResults(res, sentQuery);
		} );
	}
	function setResults( results, sentQuery ) {
		//trigger only for the last sent query
		if ( sentQuery === query ) {
			log('result set for: ' + sentQuery, log.levels.info, 'suggestions');
			setDisplayResults( results );
			trigger( 'results changed', results );
		}
	}
	function setDisplayResults( results ) {
		results = results || [];
		displayResults = results.slice(0, 5);
		trigger( 'displayResults changed', results );
	}
	function trigger( ev, value ) {
		var handlers = _ev[ev] || {},
			i;
		for( i in handlers ) {
			try {
				handlers[i](value);
			} catch(ex) {
				log(ex, log.levels.info, 'suggestions');
			}
		}
	}
	return {
		setUse: function( value ) {
			inUse = value;
		},
		getUse: function() {
			return inUse;
		},
		setQuery: function( q ) {
			if (!q && query === q || !inUse) { return; }
			query = q;
			sendQuery();
			trigger( 'query changed', query );
		},
		setWiki: function( wid ) {
			wiki = wid;
			sendQuery();
			trigger( 'wiki changed', wiki );
		},
		getDisplayResults: function( ) {
			return displayResults;
		},
		// event emitter pattern
		on: function( event, cb ) {
			_ev = _ev || {};
			_ev[event] = _ev[event] || [];
			_ev[event].push( cb );
		}
	};
});
