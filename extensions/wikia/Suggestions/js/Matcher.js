define('suggest_matcher', [], function() {
	'use strict';
	function testChar( character ) {
		// todo change regex to match solr logic
		return character.match(/[_\-)(*&^%$#@!\s:"<>(){}\[\]?\/"']+/) !== null;
	}
	function getChar( character ) {
		return testChar( character ) ? '' : character.toLocaleLowerCase();
	}
	function matchStartingFrom( title, pattern, from ) {
		var len = 0, patternPos = 0;

		while( patternPos < pattern.length ) {
			if( title.length <= from+len ) {
				return null;
			}
			if( getChar(title[from+len]) !== getChar(pattern[patternPos]) ) { return null; }
			if( testChar(title[from+len]) ) {
				do { len++; } while( from+len < title.length && testChar(title[from+len]) );
			} else {
				len++;
			}
			if( testChar(pattern[patternPos]) ) {
				do { patternPos++; } while( patternPos < pattern.length && testChar(pattern[patternPos]) );
			} else {
				patternPos++;
			}
		}

		return {
			prefix: title.substr(0, from),
			match: title.substr(from, len),
			suffix: title.substr(from + len)
		};
	}
	return {
		/**
		 * @param title String
		 * @param pattern String
		 * @return {*}
		 */
		match: function( title, pattern ) {
			var prevTest = true,
				match, position;
			if ( title && title.length ) {
				for( position = 0; position < title.length; position++ ) {
					if( testChar( title[position] ) ) {
						prevTest = true;
					} else {
						if ( prevTest ) {
							match = matchStartingFrom( title, pattern, position );
							if ( match ) {
								return match;
							}
						}
						prevTest = false;
					}
				}
			}
			return null;
		},

		/**
		 * returns match and type of match for this suggestion
		 * @param suggestion
		 * @param pattern
		 * @return {*}
		 */
		matchSuggestion: function( suggestion, pattern ) {
			var redirects = suggestion.redirects || [],
				matchResult, i;
			if ( suggestion.title && suggestion.title.length ) {
				if ( ( matchResult = this.match( suggestion.title, pattern ) ) ) {
					matchResult.type = 'title';
					return matchResult;
				}
			}
			if ( redirects && redirects.length ) {
				for ( i = 0; i< redirects.length; i++ ) {
					if ( ( matchResult = this.match( redirects[i], pattern ) ) ) {
						matchResult.type = 'redirect';
						return matchResult;
					}
				}
			}
		}
	};
});
