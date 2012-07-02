/**
 * jQuery bindings for use with MediaWiki message system.
 * Allows jQuery objects to be passed into parameterized messages, which then can return jQuery objects.
 * 
 * Why you would want this: if you would like to enhance a link within a MediaWiki message with a jQuery binding.
 * It is impractical (sometimes impossible) to find the exact link you should bind to by examining the message 
 * output. So it is better to pass in a jQuery object already bound the way you like.
 *
 * @author Michael Dale <mdale@wikimedia.org>
 * @author Neil Kandalgaonkar <neilk@wikimedia.org>
 */

/**
 * Takes message key and returns jQuery object into the .html() of the selector.
 *
 *   'myMsg' : 'Thanks for the fish, [$1 close dialog] or [$2 new fish window]'
 *
 *   $( 'div#closeLabel' ).mwMessage( 'myMsg', 
 *				      function(){ $dialog.close() },
 *				      $( '<a/>' ).attr( 'target', '_new' )
 *  				    );
 *
 * @param key {String} key for the message
 * @param parameters {Array} parameters for the message (optional, can also be variadic)
 */
jQuery.fn.mwMessage = function( key, parameters ) {

	var needsSpecialSwap = function( o ) {
		return ( typeof o === 'function' || o instanceof jQuery );
	};

	var getSwapId = function( index ) {
		return 'mw_message_swap_index_' + key + '_' + index;
	};

	var doSpecialSwap = false;

	// Support variadic arguments for parameters
	if ( typeof parameters !== 'undefined' && ! $.isArray( parameters ) ) {
		parameters = $.makeArray( arguments );
		parameters.shift();
	} else if( ! $.isArray( parameters ) ){
		parameters = [];
	}

	var text = mediaWiki.msgNoTrans( key );

	// Swap [$1 link text] replacements
	// @@FIXME parsing links should be integrated with the parser
	text = text.replace( /\[(\S+)\s+([^\]]*)\]/g, function( matched, link, linkText ) {
		var indexIdAttribute = '';
		// Check if the link is a swap index or just a string
		if( link[0] == '$' ){
			var index = parseInt( link.replace(/\$/,''), 10 ) - 1;		    		
			// If the parameter is a text string directly replace it 
			if( typeof parameters[ index ] == 'string' ){
				link =  parameters[ index ];
			} else if ( needsSpecialSwap( parameters[ index ] ) ) {
				link = '#';
				indexIdAttribute = ' id="' + getSwapId( index ) + '" ';
				doSpecialSwap = true;
			} else {
				throw new Error( 'Cannot substitute parameter with unrecognized type ' + typeof parameters[index] );
			}
		}
		
		return '<a href="' + link + '" ' + indexIdAttribute + '>' + linkText + '</a>';
	});

	// Swap $1 replacements (not in a link):
	text = text.replace( /\$(\d+)/g, function( matched, indexString ) {
		var index = parseInt( indexString, 10 ) - 1;
		// Check the parameters type
		if( parameters[index] && needsSpecialSwap( parameters[index] ) ) {
			doSpecialSwap = true;
			return '<span id="' + getSwapId( index ) + '></span>';
		} else {
			// directly swap in the index or a missing index indicator ( $1{int}
			return index in parameters ? parameters[index] : '$' + match;
		}
	} );
	

	// Create a parser object with default set of options:
	var parsedText = new mediaWiki.language.parser( text, {} );
	// Get the html representation of wikitext ( all that messages deal with right now ) 
	this.html( parsedText.getHTML() );			

	// If the parameters are jQuery objects or functions, we should now "swap" those objects in.
	if( doSpecialSwap ) {			
		// Add bindings to swap index and return binded html jQuery objects
		for( var index=0; index < parameters.length; index++ ) {
			var parameter = parameters[index];
			var $swapTarget = this.find( '#' + getSwapId( index ) );
			if ( ! $swapTarget.length ) {
				continue;
			}

			// if parameter was a function, simply add it to the click handler
			if( typeof parameter == 'function' ){
				$swapTarget.click( parameter );
			}
	
			// if parameter was a jQuery object, make it "wrap around" the text we have
			if( parameter instanceof jQuery ){			
				// make the jQuery parameter contain the same text as the swap target
				parameter.text( $swapTarget.text() );
				// replace the swap target with the jQuery parameter
				$swapTarget.replaceWith( parameter );
			}
		}
	}

	return this;
};


