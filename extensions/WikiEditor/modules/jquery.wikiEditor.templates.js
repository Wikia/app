/* Templates Module for wikiEditor */
( function( $ ) { $.wikiEditor.modules.templates = {

/**
 * Core Requirements
 */
'req': [ 'iframe' ],
/**
 * Object Templates
 */
'tpl': {
	'marker': {
		'type': 'template',
		'anchor': 'wrap',
		'skipDivision': 'realchange',
		'afterWrap': function( node ) {
			$( node ).addClass( 'wikiEditor-template' );
		},
		'getAnchor': function( ca1, ca2 ) {
			return $( ca1.parentNode ).is( '.wikiEditor-template' ) ? ca1.parentNode : null;
		}
	}
},
/**
 * Event handlers
 */
'evt': {
	'mark': function( context, event ) {
		// The markers returned by this function are skipped on realchange, so don't regenerate them in that case
		if ( context.modules.highlight.currentScope == 'realchange' ) {
			return;
		}
		// Get references to the markers and tokens from the current context
		var markers = context.modules.highlight.markers;
		var tokens = context.modules.highlight.tokenArray;
		// Use depth-tracking to extract top-level templates from tokens
		var depth = 0, bias, start;
		for ( var i in tokens ) {
			depth += ( bias = tokens[i].label == 'TEMPLATE_BEGIN' ? 1 : ( tokens[i].label == 'TEMPLATE_END' ? -1 : 0 ) );
			if ( bias > 0 && depth == 1 ) {
				// Top-level opening - use offset as start
				start = tokens[i].offset;
			} else if ( bias < 0 && depth == 0 ) {
				// Top-level closing - use offset as end
				markers[markers.length] = $.extend(
					{ 'context': context, 'start': start, 'end': tokens[i].offset },
					$.wikiEditor.modules.templates.tpl.marker
				);
			}
			if ( depth < 0 ) {
				depth = 0;
			}
		}
	}
},
'exp': [
	{ 'regex': /{{/, 'label': "TEMPLATE_BEGIN" },
	{ 'regex': /}}/, 'label': "TEMPLATE_END", 'markAfter': true }
],
/**
 * Internally used functions
 */
'fn': {
	'create': function( context, config ) {
		// Do some stuff here...
	}
}

}; } ) ( jQuery );
