/* Highlight module for wikiEditor */
( function( $ ) { $.wikiEditor.modules.highlight = {

/**
 * Core Requirements
 */
'req': [ 'iframe' ],
/**
 * Configuration
 */
cfg: {
	'styleVersion': 3
},
/**
 * Internally used event handlers
 */
evt: {
	delayedChange: function( context, event ) {
		/*
		 * Triggered on any of the following events, with the intent on detecting if something was added, deleted or
		 * replaced due to user action.
		 *
		 * The following conditions are indicative that one or more divisions need to be re-scanned/marked:
		 * 		Keypress while something is highlighted
		 * 		Cut
		 * 		Paste
		 * 		Drag+drop selected text
		 * The following conditions are indicative that special handlers need to be consulted to properly parse content
		 * 		Keypress with any of the following characters
		 * 			}	Template or Table handler
		 * 			>	Tag handler
		 * 			]	Link handler
		 * The following conditions are indicative that divisions might be being made which would need encapsulation
		 * 		Keypress with any of the following characters
		 * 			=	Heading
		 * 			#	Ordered
		 * 			*	Unordered
		 * 			;	Definition
		 * 			:	Definition
		 */
		if ( event.data.scope == 'realchange' ) {
			$.wikiEditor.modules.highlight.fn.scan( context, "" );
			$.wikiEditor.modules.highlight.fn.mark( context, "", "" );
		}
	},
	ready: function( context, event ) {
		// Highlight stuff for the first time
		$.wikiEditor.modules.highlight.fn.scan( context, "" );
		$.wikiEditor.modules.highlight.fn.mark( context, "", "" );
	}
},
/**
 * Internally used functions
 */
fn: {
	/**
	 * Creates a highlight module within a wikiEditor
	 * 
	 * @param config Configuration object to create module from
	 */
	create: function( context, config ) {
		context.modules.highlight.markersStr = '';
	},
	/**
	 * Divides text into divisions
	 */
	divide: function( context ) {
		/*
		 * We need to add some markup to the iframe content to encapsulate divisions
		 */
	},
	/**
	 * Isolates division which was affected by most recent change
	 */
	isolate: function( context ) {
		/*
		 * A change just occured, and we need to know which sections were affected
		 */
		return []; // array of sections?
	},
	/**
	 * Strips division of HTML
	 * FIXME: Isn't this done by context.fn.htmlToText() already?
	 * 
	 * @param division
	 */
	strip: function( context, division ) {
		return $( '<div />' ).html( division.html().replace( /\<br[^\>]*\>/g, "\n" ) ).text();
	},
	/**
	 * Scans text division for tokens
	 * 
	 * @param division
	 */
	scan: function( context, division ) {
		/**
		 * Builds a Token object
		 * 
		 * @param offset
		 * @param label
		 */
		function Token( offset, label, tokenStart, match ) {
			this.offset = offset;
			this.label = label;
			this.tokenStart = tokenStart;
			this.match = match;
		}
		// Reset tokens
		var tokenArray = context.modules.highlight.tokenArray = [];
		// We need to look over some text and find interesting areas, then return the positions of those areas as tokens
		var text = context.fn.getContents();
		for ( module in context.modules ) {
			if ( module in $.wikiEditor.modules && 'exp' in $.wikiEditor.modules[module] ) {
			   for ( var i = 0; i < $.wikiEditor.modules[module].exp.length; i++ ) {
					var regex = $.wikiEditor.modules[module].exp[i].regex;
					var label = $.wikiEditor.modules[module].exp[i].label;
					var markAfter = false;
					if ( typeof $.wikiEditor.modules[module].exp[i].markAfter != 'undefined' ) {
						markAfter = true;
					}
					match = text.match( regex );
					var oldOffset = 0;
					while ( match != null ) {
						var markOffset = 0;
						var tokenStart = match.index + oldOffset + markOffset;
						if ( markAfter ) {
							markOffset += match[0].length;
						}
						tokenArray.push( new Token( match.index + oldOffset + markOffset,
							label, tokenStart, match ) );
						oldOffset += match.index + match[0].length;
						newSubstring = text.substring( oldOffset );
						match = newSubstring.match( regex );
					}
				}
			}
		}
		//sort by offset, or if offset same, sort by start
		tokenArray.sort( function( a, b ) {
			return a.offset - b.offset || a.tokenStart - b.tokenStart;
		} );
		context.fn.trigger( 'scan' );
	},
	/**
	 * Marks up text with HTML
	 * 
	 * @param division
	 * @param tokens
	 */
	// FIXME: What do division and tokens do?
	// TODO: Document the scan() and mark() APIs somewhere
	mark: function( context, division, tokens ) {
		// Reset markers
		var markers = context.modules.highlight.markers = [];
		// Get all markers
		context.fn.trigger( 'mark' );
		markers.sort( function( a, b ) { return a.start - b.start || a.end - b.end; } );
		
		// Serialize the markers array to a string and compare it with the one stored in the previous run
		// If they're equal, there's no markers to change
		var markersStr = '';
		for ( var i = 0; i < markers.length; i++ ) {
			markersStr += markers[i].start + ',' + markers[i].end + ',' + markers[i].type + ',';
		}
		if ( context.modules.highlight.markersStr == markersStr ) {
			// No change, bail out
			return;
		}
		context.modules.highlight.markersStr = markersStr;
		
		// Traverse the iframe DOM, inserting markers where they're needed.
		// Store visited markers here so we know which markers should be removed
		var visited = [], v = 0;
		for ( var i = 0; i < markers.length; i++ ) {
			// We want to isolate each marker, so we may need to split textNodes
			// if a marker starts or ends halfway one.
			var start = markers[i].start;
			var s = context.fn.getOffset( start );
			if ( !s ) {
				// This shouldn't happen
				continue;
			}
			var startNode = s.node;
			var startDepth = s.depth;

			// Don't wrap leading BRs, produces undesirable results
			// FIXME: It's also possible that the offset is a bit high because getOffset() has incremented
			// .length to fake the newline caused by startNode being in a P. In this case, prevent
			// the textnode splitting below from making startNode an empty textnode, IE barfs on that
			while ( startNode.nodeName == 'BR' || s.offset == startNode.nodeValue.length ) {
				start++;
				s = context.fn.getOffset( start );
				startNode = s.node;
				startDepth = s.depth;
			}

			// The next marker starts somewhere in this textNode or at this BR
			if ( s.offset > 0 && s.node.nodeName == '#text' ) {
				// Split off the prefix
				// This leaves the prefix in the current node and puts
				// the rest in a new node which is our start node
				startNode = startNode.splitText( s.offset );
				// This also invalidates cached offset objects
				context.fn.purgeOffsets(); // TODO: Optimize better, get end offset object earlier
			}
			// Because we can't put block elements in <p>s, we'll have to split the <p> as well
			// if afterWrap() needs us to
			if ( markers[i].splitPs && startNode.parentNode.nodeName == 'P' ) {
				// Create a new <p> left of startNode, and append startNode's left siblings to it
				var startP = startNode.ownerDocument.createElement( 'p' );
				while ( startNode.parentNode.firstChild != startNode ) {
					startP.appendChild( startNode.parentNode.firstChild );
				}
				if ( startP.firstChild ) {
					startNode.parentNode.insertBefore( startP, startNode );
				}
			}
			
			var end = markers[i].end;
			var e = context.fn.getOffset( end );
			if ( !e ) {
				// This shouldn't happen
				continue;
			}
			var endNode = e.node;
			var endDepth = e.depth;
			if ( e.offset < e.length - 1 && e.node.nodeName == '#text' ) {
				// Split off the suffix. This puts the suffix in a new node and leaves the rest in endNode
				endNode.splitText( e.offset );
				// This also invalidates cached offset objects
				context.fn.purgeOffsets(); // TODO: Optimize better, get end offset object earlier
			}
			// Split <p>s if needed, see above
			if ( markers[i].splitPs && endNode.parentNode.nodeName == 'P' && endNode.parentNode.parentNode ) {
				// Move textnodes preceding endNode out of the wrapping <p>
				var endP = endNode.parentNode;
				while ( endP.firstChild != endNode ) {
					endP.parentNode.insertBefore( endP.firstChild, endP );
				}
				// Move endNode itself out as well
				endP.parentNode.insertBefore( endNode, endP );
				if ( !endP.firstChild ) {
					// endP is empty, remove it
					endP.parentNode.removeChild( endP );
				}
			}
			
			// Don't wrap trailing BRs, doing that causes weird issues
			if ( endNode.nodeName == 'BR' ) {
				endNode = e.lastTextNode;
				endDepth = e.lastTextNodeDepth;
			}
			
			// Now wrap everything between startNode and endNode (may be equal). First find the common ancestor of
			// startNode and endNode. ca1 and ca2 will be children of this common ancestor, such that ca1 is an
			// ancestor of startNode and ca2 of endNode. We also check that startNode and endNode are the leftmost and
			// rightmost leaves in the subtrees rooted at ca1 and ca2 respectively; if this is not the case, we
			// can't cleanly wrap things without misnesting and we silently fail.
			var ca1 = startNode, ca2 = endNode;
			// Correct for startNode and endNode possibly not having the same depth
			if ( startDepth > endDepth ) {
				for ( var j = 0; j < startDepth - endDepth && ca1; j++ ) {
					ca1 = ca1.parentNode.firstChild == ca1 ? ca1.parentNode : null;
				}
			}
			else if ( startDepth < endDepth ) {
				for ( var j = 0; j < endDepth - startDepth && ca2; j++ ) {
					ca2 = ca2.parentNode.lastChild == ca2 ? ca2.parentNode : null;
				}
			}
			// Now that ca1 and ca2 have the same depth, have them walk up the tree simultaneously
			// to find the common ancestor
			while (
				ca1 &&
				ca2 &&
				ca1.parentNode &&
				ca2.parentNode &&
				ca1.parentNode != ca2.parentNode &&
				ca1.parentNode.firstChild &&
				ca2.parentNode.lastChild
			) {
				ca1 = ca1.parentNode.firstChild == ca1 ? ca1.parentNode : null;
				ca2 = ca2.parentNode.lastChild == ca2 ? ca2.parentNode : null;
			}
			if ( ca1 && ca2 && ca1.parentNode ) {
				var anchor = markers[i].getAnchor( ca1, ca2 );
				if ( !anchor ) {
					var commonAncestor = ca1.parentNode;
					if ( markers[i].anchor == 'wrap' ) {
						// We have to store things like .parentNode and .nextSibling because
						// appendChild() changes these properties
						var newNode = ca1.ownerDocument.createElement( 'span' );
						
						var nextNode = ca2.nextSibling;
						// Append all nodes between ca1 and ca2 (inclusive) to newNode
						var n = ca1;
						while ( n != nextNode ) {
							var ns = n.nextSibling;
							newNode.appendChild( n );
							n = ns;
						}
						// Insert newNode in the right place
						if ( nextNode ) {
							commonAncestor.insertBefore( newNode, nextNode );
						} else {
							commonAncestor.appendChild( newNode );
						}
						
						anchor = newNode;
					} else if ( markers[i].anchor == 'tag' ) {
						anchor = commonAncestor;
					}
					$( anchor ).data( 'marker', markers[i] )
						.addClass( 'wikiEditor-highlight' );
					
					// Allow the module adding this marker to manipulate it
					markers[i].afterWrap( anchor, markers[i] );

				} else {
					// Update the marker object
					$( anchor ).data( 'marker', markers[i] );
					markers[i].onSkip( anchor );
				}
				visited[v++] = anchor;
			}
		}
		
		// Remove markers that were previously inserted but weren't passed to this function
		// This function works because visited[] contains the visited elements in order and find() and each()
		// preserve order
		var j = 0;
		context.$content.find( '.wikiEditor-highlight' ).each( function() {
			if ( visited[j] == this ) {
				// This marker is legit, leave it in
				j++;
				return true;
			}
			
			// Remove this marker
			var marker = $(this).data( 'marker' );
			if ( marker && typeof marker.beforeUnwrap == 'function' )
				marker.beforeUnwrap( this );
			if ( ( marker && marker.anchor == 'tag' ) || $(this).is( 'p' ) ) {
				// Remove all classes
				$(this).removeAttr( 'class' );
			} else {
				// Assume anchor == 'wrap'
				if ( $(this).children().size() > 0 ) {
					$(this).replaceWith( $(this).children() );
				} else {
					$(this).replaceWith( $(this).html() );
				}
			}
		});
	}
}

}; })( jQuery );

