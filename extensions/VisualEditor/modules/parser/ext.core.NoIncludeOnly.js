/**
 * Simple noinclude / onlyinclude implementation. Strips all tokens in
 * noinclude sections.
 *
 * @author Gabriel Wicke <gwicke@wikimedia.org>
 */

var TokenCollector = require( './ext.util.TokenCollector.js' ).TokenCollector;

function NoInclude( manager, isInclude ) {
	new TokenCollector( 
			manager,
			function ( tokens ) { 
				if ( isInclude ) {
					manager.env.tp( 'noinclude stripping' );
					return {};
				} else {
					tokens.shift();
					if ( tokens.length &&
						tokens[tokens.length - 1].type !== 'END' ) {
						tokens.pop();
					}
					return { tokens: tokens };
				}
			}, // just strip it all..
			true, // match the end-of-input if </noinclude> is missing
			0.01, // very early in stage 1, to avoid any further processing.
			'tag',
			'noinclude'
			);
}

function IncludeOnly( manager, isInclude ) {
	new TokenCollector( 
			manager,
			function ( tokens ) { 
				if ( isInclude ) {
					tokens.shift();
					if ( tokens.length &&
						tokens[tokens.length - 1].type !== 'END' ) {
							tokens.pop();
					}
					return { tokens: tokens };
				} else {
					manager.env.tp( 'includeonly stripping' );
					return {};
				}
			},
			true, // match the end-of-input if </noinclude> is missing
			0.01, // very early in stage 1, to avoid any further processing.
			'tag',
			'includeonly'
			);
}


if (typeof module == "object") {
	module.exports.NoInclude = NoInclude;
	module.exports.IncludeOnly = IncludeOnly;
}
