/*!
 * VisualEditor utilities.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * @class ve
 */

/**
 * Checks if an object is an instance of one or more classes.
 *
 * @param {Object} subject Object to check
 * @param {Function[]} classes Classes to compare with
 * @return {boolean} Object inherits from one or more of the classes
 */
ve.isInstanceOfAny = function ( subject, classes ) {
	var i = classes.length;

	while ( classes[ --i ] ) {
		if ( subject instanceof classes[ i ] ) {
			return true;
		}
	}
	return false;
};

/**
 * @method
 * @inheritdoc OO#getProp
 */
ve.getProp = OO.getProp;

/**
 * @method
 * @inheritdoc OO#setProp
 */
ve.setProp = OO.setProp;

/**
 * @method
 * @inheritdoc OO#cloneObject
 */
ve.cloneObject = OO.cloneObject;

/**
 * @method
 * @inheritdoc OO#getObjectValues
 */
ve.getObjectValues = OO.getObjectValues;

/**
 * @method
 * @inheritdoc OO#compare
 */
ve.compare = OO.compare;

/**
 * @method
 * @inheritdoc OO#copy
 */
ve.copy = OO.copy;

/**
 * @method
 * @inheritdoc OO.ui#debounce
 */
ve.debounce = OO.ui.debounce;

/**
 * @method
 * @inheritdoc OO.ui.Element#scrollIntoView
 */
ve.scrollIntoView = OO.ui.Element.static.scrollIntoView.bind( OO.ui.Element.static );

/**
 * Copy an array of DOM elements, optionally into a different document.
 *
 * @param {HTMLElement[]} domElements DOM elements to copy
 * @param {HTMLDocument} [doc] Document to create the copies in; if unset, simply clone each element
 * @return {HTMLElement[]} Copy of domElements with copies of each element
 */
ve.copyDomElements = function ( domElements, doc ) {
	return domElements.map( function ( domElement ) {
		return doc ? doc.importNode( domElement, true ) : domElement.cloneNode( true );
	} );
};

/**
 * Check if two arrays of DOM elements are equal (according to .isEqualNode())
 *
 * @param {HTMLElement[]} domElements1 First array of DOM elements
 * @param {HTMLElement[]} domElements2 Second array of DOM elements
 * @return {boolean} All elements are pairwise equal
 */
ve.isEqualDomElements = function ( domElements1, domElements2 ) {
	var i = 0,
		len = domElements1.length;
	if ( len !== domElements2.length ) {
		return false;
	}
	for ( ; i < len; i++ ) {
		if ( !domElements1[ i ].isEqualNode( domElements2[ i ] ) ) {
			return false;
		}
	}
	return true;
};

/**
 * Compare two class lists, either whitespace separated strings or arrays
 *
 * Class lists are equivalent if they contain the same members,
 * excluding duplicates and ignoring order.
 *
 * @param {string[]|string} classList1 First class list
 * @param {string[]|string} classList2 Second class list
 * @return {boolean} Class lists are equivalent
 */
ve.compareClassLists = function ( classList1, classList2 ) {
	var removeEmpty = function ( c ) {
		return c !== '';
	};

	classList1 = Array.isArray( classList1 ) ? classList1 : classList1.trim().split( /\s+/ );
	classList2 = Array.isArray( classList2 ) ? classList2 : classList2.trim().split( /\s+/ );

	classList1 = classList1.filter( removeEmpty );
	classList2 = classList2.filter( removeEmpty );

	return ve.compare( OO.unique( classList1 ).sort(), OO.unique( classList2 ).sort() );
};

/**
 * Check to see if an object is a plain object (created using "{}" or "new Object").
 *
 * @method
 * @source <http://api.jquery.com/jQuery.isPlainObject/>
 * @param {Object} obj The object that will be checked to see if it's a plain object
 * @return {boolean}
 */
ve.isPlainObject = $.isPlainObject;

/**
 * Check to see if an object is empty (contains no properties).
 *
 * @method
 * @source <http://api.jquery.com/jQuery.isEmptyObject/>
 * @param {Object} obj The object that will be checked to see if it's empty
 * @return {boolean}
 */
ve.isEmptyObject = $.isEmptyObject;

/**
 * Merge properties of one or more objects into another.
 * Preserves original object's inheritance (e.g. Array, Object, whatever).
 * In case of array or array-like objects only the indexed properties
 * are copied over.
 * Beware: If called with only one argument, it will consider
 * 'target' as 'source' and 'this' as 'target'. Which means
 * ve.extendObject( { a: 1 } ); sets ve.a = 1;
 *
 * @method
 * @source <http://api.jquery.com/jQuery.extend/>
 * @param {boolean} [recursive=false]
 * @param {Mixed} [target] Object that will receive the new properties
 * @param {...Mixed} [sources] Variadic list of objects containing properties
 * to be merged into the target.
 * @return {Mixed} Modified version of first or second argument
 */
ve.extendObject = $.extend;

/**
 * @private
 * @property {boolean}
 */
ve.supportsSplice = ( function () {
	var a, n;

	// This returns false in Safari 8
	a = new Array( 100000 );
	a.splice( 30, 0, 'x' );
	a.splice( 20, 1 );
	if ( a.indexOf( 'x' ) !== 29 ) {
		return false;
	}

	// This returns false in Opera 12.15
	a = [];
	n = 256;
	a[ n ] = 'a';
	a.splice( n + 1, 0, 'b' );
	if ( a[ n ] !== 'a' ) {
		return false;
	}

	// Splice is supported
	return true;
} )();

/**
 * Splice one array into another.
 *
 * This is the equivalent of arr.splice( offset, remove, d1, d2, d3, ... ) except that arguments are
 * specified as an array rather than separate parameters.
 *
 * This method has been proven to be faster than using slice and concat to create a new array, but
 * performance tests should be conducted on each use of this method to verify this is true for the
 * particular use. Also, browsers change fast, never assume anything, always test everything.
 *
 * Includes a replacement for broken implementations of Array.prototype.splice().
 *
 * @param {Array|ve.dm.BranchNode} arr Target object (must have `splice` method, object will be modified)
 * @param {number} offset Offset in arr to splice at. This may NOT be negative, unlike the
 *  'index' parameter in Array#splice.
 * @param {number} remove Number of elements to remove at the offset. May be zero
 * @param {Array} data Array of items to insert at the offset. Must be non-empty if remove=0
 * @return {Array} Array of items removed
 */
ve.batchSplice = function ( arr, offset, remove, data ) {
	// We need to splice insertion in in batches, because of parameter list length limits which vary
	// cross-browser - 1024 seems to be a safe batch size on all browsers
	var splice, spliced,
		index = 0,
		batchSize = 1024,
		toRemove = remove,
		removed = [];

	if ( !Array.isArray( arr ) ) {
		splice = arr.splice;
	} else {
		if ( ve.supportsSplice ) {
			splice = Array.prototype.splice;
		} else {
			// Standard Array.prototype.splice() function implemented using .slice() and .push().
			splice = function ( offset, remove/*, data... */ ) {
				var data, begin, removed, end;

				data = Array.prototype.slice.call( arguments, 2 );

				begin = this.slice( 0, offset );
				removed = this.slice( offset, offset + remove );
				end = this.slice( offset + remove );

				this.length = 0;
				ve.batchPush( this, begin );
				ve.batchPush( this, data );
				ve.batchPush( this, end );

				return removed;
			};
		}
	}

	if ( data.length === 0 ) {
		// Special case: data is empty, so we're just doing a removal
		// The code below won't handle that properly, so we do it here
		return splice.call( arr, offset, remove );
	}

	while ( index < data.length ) {
		// Call arr.splice( offset, remove, i0, i1, i2, ..., i1023 );
		// Only set remove on the first call, and set it to zero on subsequent calls
		spliced = splice.apply(
			arr, [ index + offset, toRemove ].concat( data.slice( index, index + batchSize ) )
		);
		if ( toRemove > 0 ) {
			removed = spliced;
		}
		index += batchSize;
		toRemove = 0;
	}
	return removed;
};

/**
 * Insert one array into another.
 *
 * Shortcut for `ve.batchSplice( arr, offset, 0, src )`.
 *
 * @see #batchSplice
 * @param {Array|ve.dm.BranchNode} arr Target object (must have `splice` method)
 * @param {number} offset Offset in arr where items will be inserted
 * @param {Array} src Items to insert at offset
 */
ve.insertIntoArray = function ( arr, offset, src ) {
	ve.batchSplice( arr, offset, 0, src );
};

/**
 * Push one array into another.
 *
 * This is the equivalent of arr.push( d1, d2, d3, ... ) except that arguments are
 * specified as an array rather than separate parameters.
 *
 * @param {Array|ve.dm.BranchNode} arr Object supporting .push() to insert at the end of the array. Will be modified
 * @param {Array} data Array of items to insert.
 * @return {number} length of the new array
 */
ve.batchPush = function ( arr, data ) {
	// We need to push insertion in batches, because of parameter list length limits which vary
	// cross-browser - 1024 seems to be a safe batch size on all browsers
	var length,
		index = 0,
		batchSize = 1024;
	while ( index < data.length ) {
		// Call arr.push( i0, i1, i2, ..., i1023 );
		length = arr.push.apply(
			arr, data.slice( index, index + batchSize )
		);
		index += batchSize;
	}
	return length;
};

/**
 * Use binary search to locate an element in a sorted array.
 *
 * searchFunc is given an element from the array. `searchFunc(elem)` must return a number
 * above 0 if the element we're searching for is to the right of (has a higher index than) elem,
 * below 0 if it is to the left of elem, or zero if it's equal to elem.
 *
 * To search for a specific value with a comparator function (a `function cmp(a,b)` that returns
 * above 0 if `a > b`, below 0 if `a < b`, and 0 if `a == b`), you can use
 * `searchFunc = cmp.bind( null, value )`.
 *
 * @param {Array} arr Array to search in
 * @param {Function} searchFunc Search function
 * @param {boolean} [forInsertion] If not found, return index where val could be inserted
 * @return {number|null} Index where val was found, or null if not found
 */
ve.binarySearch = function ( arr, searchFunc, forInsertion ) {
	var mid, cmpResult,
		left = 0,
		right = arr.length;
	while ( left < right ) {
		// Equivalent to Math.floor( ( left + right ) / 2 ) but much faster
		/*jshint bitwise:false */
		mid = ( left + right ) >> 1;
		cmpResult = searchFunc( arr[ mid ] );
		if ( cmpResult < 0 ) {
			right = mid;
		} else if ( cmpResult > 0 ) {
			left = mid + 1;
		} else {
			return mid;
		}
	}
	return forInsertion ? right : null;
};

/**
 * Log data to the console.
 *
 * This implementation does nothing, to add a real implementation ve.debug needs to be loaded.
 *
 * @param {...Mixed} [args] Data to log
 */
ve.log = ve.log || function () {
	// don't do anything, this is just a stub
};

/**
 * Log error to the console.
 *
 * This implementation does nothing, to add a real implementation ve.debug needs to be loaded.
 *
 * @param {...Mixed} [args] Data to log
 */
ve.error = ve.error || function () {
	// don't do anything, this is just a stub
};

/**
 * Log an object to the console.
 *
 * This implementation does nothing, to add a real implementation ve.debug needs to be loaded.
 *
 * @param {Object} obj
 */
ve.dir = ve.dir || function () {
	// don't do anything, this is just a stub
};

/**
 * Select the contents of an element
 *
 * @param {HTMLElement} element Element
 */
ve.selectElement = function ( element ) {
	var win = OO.ui.Element.static.getWindow( element ),
		nativeRange = win.document.createRange(),
		nativeSelection = win.getSelection();
	nativeRange.setStart( element, 0 );
	nativeRange.setEnd( element, element.childNodes.length );
	nativeSelection.removeAllRanges();
	nativeSelection.addRange( nativeRange );
};

/**
 * Get a localized message.
 *
 * @param {string} key Message key
 * @param {...Mixed} [params] Message parameters
 * @return {string} Localized message
 */
ve.msg = function () {
	// Avoid using bind because ve.init.platform doesn't exist yet.
	// TODO: Fix dependency issues between ve.js and ve.init.platform
	return ve.init.platform.getMessage.apply( ve.init.platform, arguments );
};

/**
 * Get platform config value(s)
 *
 * @param {string|string[]} key Config key, or list of keys
 * @return {Mixed|Object} Config value, or keyed object of config values if list of keys provided
 */
ve.config = function () {
	return ve.init.platform.getConfig.apply( ve.init.platform, arguments );
};

/**
 * Get or set a user config value.
 *
 * @param {string|string[]|Object} key Config key, list of keys or object mapping keys to values
 * @param {Mixed} [value] Value to set, if setting and key is a string
 * @return {Mixed|Object|boolean} Config value, keyed object of config values if list of keys provided,
 *  or success boolean if setting.
 */
ve.userConfig = function ( key ) {
	if ( arguments.length <= 1 && ( typeof key === 'string' || Array.isArray( key ) ) ) {
		// get( string key )
		// get( Array keys )
		return ve.init.platform.getUserConfig.apply( ve.init.platform, arguments );
	} else {
		// set( Object values )
		// set( key, value )
		return ve.init.platform.setUserConfig.apply( ve.init.platform, arguments );
	}
};

/**
 * Determine if the text consists of only unattached combining marks.
 *
 * @param {string} text Text to test
 * @return {boolean} The text is unattached combining marks
 */
ve.isUnattachedCombiningMark = function ( text ) {
	return ( /^[\u0300-\u036F]+$/ ).test( text );
};

/**
 * Convert a grapheme cluster offset to a byte offset.
 *
 * @param {string} text Text in which to calculate offset
 * @param {number} clusterOffset Grapheme cluster offset
 * @return {number} Byte offset
 */
ve.getByteOffset = function ( text, clusterOffset ) {
	return unicodeJS.graphemebreak.splitClusters( text )
		.slice( 0, clusterOffset )
		.join( '' )
		.length;
};

/**
 * Convert a byte offset to a grapheme cluster offset.
 *
 * @param {string} text Text in which to calculate offset
 * @param {number} byteOffset Byte offset
 * @return {number} Grapheme cluster offset
 */
ve.getClusterOffset = function ( text, byteOffset ) {
	return unicodeJS.graphemebreak.splitClusters( text.slice( 0, byteOffset ) ).length;
};

/**
 * Get a text substring, taking care not to split grapheme clusters.
 *
 * @param {string} text Text to take the substring from
 * @param {number} start Start offset
 * @param {number} end End offset
 * @param {boolean} [outer=false] Include graphemes if the offset splits them
 * @return {string} Substring of text
 */
ve.graphemeSafeSubstring = function ( text, start, end, outer ) {
	// TODO: improve performance by incrementally inspecting characters around the offsets
	var unicodeStart = ve.getByteOffset( text, ve.getClusterOffset( text, start ) ),
		unicodeEnd = ve.getByteOffset( text, ve.getClusterOffset( text, end ) );

	// If the selection collapses and we want an inner, then just return empty
	// otherwise we'll end up crossing over start and end
	if ( unicodeStart === unicodeEnd && !outer ) {
		return '';
	}

	// The above calculations always move to the right of a multibyte grapheme.
	// Depending on the outer flag, we may want to move to the left:
	if ( unicodeStart > start && outer ) {
		unicodeStart = ve.getByteOffset( text, ve.getClusterOffset( text, start ) - 1 );
	}
	if ( unicodeEnd > end && !outer ) {
		unicodeEnd = ve.getByteOffset( text, ve.getClusterOffset( text, end ) - 1 );
	}
	return text.slice( unicodeStart, unicodeEnd );
};

/**
 * Escape non-word characters so they can be safely used as HTML attribute values.
 *
 * @param {string} value Attribute value to escape
 * @return {string} Escaped attribute value
 */
ve.escapeHtml = ( function () {
	function escape( value ) {
		switch ( value ) {
			case '\'':
				return '&#039;';
			case '"':
				return '&quot;';
			case '<':
				return '&lt;';
			case '>':
				return '&gt;';
			case '&':
				return '&amp;';
		}
	}

	return function ( value ) {
		return value.replace( /['"<>&]/g, escape );
	};
}() );

/**
 * Generate HTML attributes.
 *
 * NOTE: While the values of attributes are escaped, the names of attributes (i.e. the keys in
 * the attributes objects) are NOT ESCAPED. The caller is responsible for making sure these are
 * sane tag/attribute names and do not contain unsanitized content from an external source
 * (e.g. from the user or from the web).
 *
 * @param {Object} [attributes] Key-value map of attributes for the tag
 * @return {string} HTML attributes
 */
ve.getHtmlAttributes = function ( attributes ) {
	var attrName, attrValue,
		parts = [];

	if ( !ve.isPlainObject( attributes ) || ve.isEmptyObject( attributes ) ) {
		return '';
	}

	for ( attrName in attributes ) {
		attrValue = attributes[ attrName ];
		if ( attrValue === true ) {
			// Convert name=true to name=name
			attrValue = attrName;
		} else if ( attrValue === false ) {
			// Skip name=false
			continue;
		}
		parts.push( attrName + '="' + ve.escapeHtml( String( attrValue ) ) + '"' );
	}

	return parts.join( ' ' );
};

/**
 * Generate an opening HTML tag.
 *
 * NOTE: While the values of attributes are escaped, the tag name and the names of
 * attributes (i.e. the keys in the attributes objects) are NOT ESCAPED. The caller is
 * responsible for making sure these are sane tag/attribute names and do not contain
 * unsanitized content from an external source (e.g. from the user or from the web).
 *
 * @param {string} tagName HTML tag name
 * @param {Object} [attributes] Key-value map of attributes for the tag
 * @return {string} Opening HTML tag
 */
ve.getOpeningHtmlTag = function ( tagName, attributes ) {
	var attr = ve.getHtmlAttributes( attributes );
	return '<' + tagName + ( attr ? ' ' + attr : '' ) + '>';
};

/**
 * Get the attributes of a DOM element as an object with key/value pairs.
 *
 * @param {HTMLElement} element
 * @return {Object}
 */
ve.getDomAttributes = function ( element ) {
	var i,
		result = {};
	for ( i = 0; i < element.attributes.length; i++ ) {
		result[ element.attributes[ i ].name ] = element.attributes[ i ].value;
	}
	return result;
};

/**
 * Set the attributes of a DOM element as an object with key/value pairs.
 *
 * Use the `null` or `undefined` value to ensure an attribute's absence.
 *
 * @param {HTMLElement} element DOM element to apply attributes to
 * @param {Object} attributes Attributes to apply
 * @param {string[]} [whitelist] List of attributes to exclusively allow (all lowercase names)
 */
ve.setDomAttributes = function ( element, attributes, whitelist ) {
	var key;
	// Duck-typing for attribute setting
	if ( !element.setAttribute || !element.removeAttribute ) {
		return;
	}
	for ( key in attributes ) {
		if ( whitelist && whitelist.indexOf( key.toLowerCase() ) === -1 ) {
			continue;
		}
		if ( attributes[ key ] === undefined || attributes[ key ] === null ) {
			element.removeAttribute( key );
		} else {
			element.setAttribute( key, attributes[ key ] );
		}
	}
};

/**
 * Build a summary of an HTML element.
 *
 * Summaries include node name, text, attributes and recursive summaries of children.
 * Used for serializing or comparing HTML elements.
 *
 * @private
 * @param {HTMLElement} element Element to summarize
 * @param {boolean} [includeHtml=false] Include an HTML summary for element nodes
 * @return {Object} Summary of element.
 */
ve.getDomElementSummary = function ( element, includeHtml ) {
	var i,
		summary = {
			type: element.nodeName.toLowerCase(),
			text: element.textContent,
			attributes: {},
			children: []
		};

	if ( includeHtml && element.nodeType === Node.ELEMENT_NODE ) {
		summary.html = element.outerHTML;
	}

	// Gather attributes
	if ( element.attributes ) {
		for ( i = 0; i < element.attributes.length; i++ ) {
			summary.attributes[ element.attributes[ i ].name ] = element.attributes[ i ].value;
		}
	}
	// Summarize children
	if ( element.childNodes ) {
		for ( i = 0; i < element.childNodes.length; i++ ) {
			summary.children.push( ve.getDomElementSummary( element.childNodes[ i ], includeHtml ) );
		}
	}
	return summary;
};

/**
 * Callback for #copy to convert nodes to a comparable summary.
 *
 * @private
 * @param {Object} value Value in the object/array
 * @return {Object} DOM element summary if value is a node, otherwise just the value
 */
ve.convertDomElements = function ( value ) {
	// Use duck typing rather than instanceof Node; the latter doesn't always work correctly
	if ( value && value.nodeType ) {
		return ve.getDomElementSummary( value );
	}
	return value;
};

/**
 * Check whether a given DOM element has a block element type.
 *
 * @param {HTMLElement|string} element Element or element name
 * @return {boolean} Element is a block element
 */
ve.isBlockElement = function ( element ) {
	var elementName = typeof element === 'string' ? element : element.nodeName;
	return ve.elementTypes.block.indexOf( elementName.toLowerCase() ) !== -1;
};

/**
 * Check whether a given DOM element is a void element (can't have children).
 *
 * @param {HTMLElement|string} element Element or element name
 * @return {boolean} Element is a void element
 */
ve.isVoidElement = function ( element ) {
	var elementName = typeof element === 'string' ? element : element.nodeName;
	return ve.elementTypes.void.indexOf( elementName.toLowerCase() ) !== -1;
};

ve.elementTypes = {
	block: [
		'div', 'p',
		// tables
		'table', 'tbody', 'thead', 'tfoot', 'caption', 'th', 'tr', 'td',
		// lists
		'ul', 'ol', 'li', 'dl', 'dt', 'dd',
		// HTML5 heading content
		'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hgroup',
		// HTML5 sectioning content
		'article', 'aside', 'body', 'nav', 'section', 'footer', 'header', 'figure',
		'figcaption', 'fieldset', 'details', 'blockquote',
		// other
		'hr', 'button', 'canvas', 'center', 'col', 'colgroup', 'embed',
		'map', 'object', 'pre', 'progress', 'video'
	],
	void: [
		'area', 'base', 'br', 'col', 'command', 'embed', 'hr', 'img',
		'input', 'keygen', 'link', 'meta', 'param', 'source', 'track', 'wbr'
	]
};

/**
 * Create an HTMLDocument from an HTML string.
 *
 * The html parameter is supposed to be a full HTML document with a doctype and an `<html>` tag.
 * If you pass a document fragment, it may or may not work, this is at the mercy of the browser.
 *
 * To create an empty document, pass the empty string.
 *
 * If your input is both valid HTML and valid XML, and you need to work around style
 * normalization bugs in Internet Explorer, use #parseXhtml and #serializeXhtml.
 *
 * @param {string} html HTML string
 * @return {HTMLDocument} Document constructed from the HTML string
 */
ve.createDocumentFromHtml = function ( html ) {
	var newDocument;

	newDocument = ve.createDocumentFromHtmlUsingDomParser( html );
	if ( newDocument ) {
		return newDocument;
	}

	newDocument = ve.createDocumentFromHtmlUsingIframe( html );
	if ( newDocument ) {
		return newDocument;
	}

	return ve.createDocumentFromHtmlUsingInnerHtml( html );
};

/**
 * Private method for creating an HTMLDocument using the DOMParser
 *
 * @private
 * @param {string} html HTML string
 * @return {HTMLDocument|undefined} Document constructed from the HTML string or undefined if it failed
 */
ve.createDocumentFromHtmlUsingDomParser = function ( html ) {
	var newDocument;

	// IE doesn't like empty strings
	html = html || '<body></body>';

	try {
		newDocument = new DOMParser().parseFromString( html, 'text/html' );
		if ( newDocument ) {
			return newDocument;
		}
	} catch ( e ) { }
};

/**
 * Private fallback for browsers which don't support DOMParser
 *
 * @private
 * @param {string} html HTML string
 * @return {HTMLDocument|undefined} Document constructed from the HTML string or undefined if it failed
 */
ve.createDocumentFromHtmlUsingIframe = function ( html ) {
	var newDocument, $iframe, iframe;
	// Here's what this fallback code should look like:
	//
	//     var newDocument = document.implementation.createHtmlDocument( '' );
	//     newDocument.open();
	//     newDocument.write( html );
	//     newDocument.close();
	//     return newDocument;
	//
	// Sadly, it's impossible:
	// * On IE 9, calling open()/write() on such a document throws an "Unspecified error" (sic).
	// * On Firefox 20, calling open()/write() doesn't actually do anything, including writing.
	//   This is reported as Firefox bug 867102.
	// * On Opera 12, calling open()/write() behaves as if called on window.document, replacing the
	//   entire contents of the page with new HTML. This is reported as Opera bug DSK-384486.
	//
	// Funnily, in all of those browsers it's apparently perfectly legal and possible to access the
	// newly created document's DOM itself, including modifying documentElement's innerHTML, which
	// would achieve our goal. But that requires some nasty magic to strip off the <html></html> tag
	// itself, so we're not doing that. (We can't use .outerHTML, either, as the spec disallows
	// assigning to it for the root element.)
	//
	// There is one more way - create an <iframe>, append it to current document, and access its
	// contentDocument. The only browser having issues with that is Opera (sometimes the accessible
	// value is not actually a Document, but something which behaves just like an empty regular
	// object...), so we're detecting that and using the innerHTML hack described above.

	html = html || '<body></body>';

	// Create an invisible iframe
	$iframe = $( '<iframe frameborder="0" width="0" height="0" />' );
	iframe = $iframe.get( 0 );
	// Attach it to the document. We have to do this to get a new document out of it
	document.documentElement.appendChild( iframe );
	// Write the HTML to it
	newDocument = ( iframe.contentWindow && iframe.contentWindow.document ) || iframe.contentDocument;
	newDocument.open();
	newDocument.write( html ); // Party like it's 1995!
	newDocument.close();
	// Detach the iframe
	// FIXME detaching breaks access to newDocument in IE
	iframe.parentNode.removeChild( iframe );

	if ( !newDocument.documentElement || newDocument.documentElement.cloneNode( false ) === undefined ) {
		// Surprise! The document is not a document! Only happens on Opera.
		// (Or its nodes are not actually nodes, while the document
		// *is* a document. This only happens when debugging with Dragonfly.)
		return;
	}

	return newDocument;
};

/**
 * Private fallback for browsers which don't support iframe technique
 *
 * @private
 * @param {string} html HTML string
 * @return {HTMLDocument} Document constructed from the HTML string
 */
ve.createDocumentFromHtmlUsingInnerHtml = function ( html ) {
	var i, htmlAttributes, wrapper, attributes,
		newDocument = document.implementation.createHTMLDocument( '' );

	html = html || '<body></body>';

	// Carefully unwrap the HTML out of the root node (and doctype, if any).
	newDocument.documentElement.innerHTML = html
		.replace( /^\s*(?:<!doctype[^>]*>)?\s*<html[^>]*>/i, '' )
		.replace( /<\/html>\s*$/i, '' );

	// Preserve <html> attributes, if any
	htmlAttributes = html.match( /<html([^>]*>)/i );
	if ( htmlAttributes && htmlAttributes[ 1 ] ) {
		wrapper = document.createElement( 'div' );
		wrapper.innerHTML = '<div ' + htmlAttributes[ 1 ] + '></div>';
		attributes = wrapper.firstChild.attributes;
		for ( i = 0; i < attributes.length; i++ ) {
			newDocument.documentElement.setAttribute(
				attributes[ i ].name,
				attributes[ i ].value
			);
		}
	}

	return newDocument;
};

/**
 * Resolve a URL relative to a given base.
 *
 * @param {string} url URL to resolve
 * @param {HTMLDocument} base Document whose base URL to use
 * @return {string} Resolved URL
 */
ve.resolveUrl = function ( url, base ) {
	var node = base.createElement( 'a' );
	node.setAttribute( 'href', url );
	// If doc.baseURI isn't set, node.href will be an empty string
	// This is crazy, returning the original URL is better
	return node.href || url;
};

/**
 * Modify a set of DOM elements to resolve attributes in the context of another document.
 *
 * This performs node.setAttribute( 'attr', nodeInDoc[attr] ); for every node.
 *
 * @param {jQuery} $elements Set of DOM elements to modify
 * @param {HTMLDocument} doc Document to resolve against (different from $elements' .ownerDocument)
 * @param {string[]} attrs Attributes to resolve
 */
ve.resolveAttributes = function ( $elements, doc, attrs ) {
	var i, len, attr;

	/**
	 * Callback for jQuery.fn.each that resolves the value of attr to the computed
	 * property value. Called in the context of an HTMLElement.
	 *
	 * @private
	 */
	function resolveAttribute() {
		var nodeInDoc = doc.createElement( this.nodeName );
		nodeInDoc.setAttribute( attr, this.getAttribute( attr ) );
		if ( nodeInDoc[ attr ] ) {
			this.setAttribute( attr, nodeInDoc[ attr ] );
		}
	}

	for ( i = 0, len = attrs.length; i < len; i++ ) {
		attr = attrs[ i ];
		$elements.find( '[' + attr + ']' ).each( resolveAttribute );
		$elements.filter( '[' + attr + ']' ).each( resolveAttribute );
	}
};

/**
 * Take a target document with a possibly relative base URL, and modify it to be absolute.
 * The base URL of the target document is resolved using the base URL of the source document.
 *
 * Note that the the fallbackBase parameter will be used if there is no <base> tag, even if
 * the document does have a valid base URL: this is to work around Firefox's behavior of having
 * documents created by DOMParser inherit the base URL of the main document.
 *
 * @param {HTMLDocument} targetDoc Document whose base URL should be resolved
 * @param {HTMLDocument} sourceDoc Document whose base URL should be used for resolution
 * @param {string} [fallbackBase] Base URL to use if resolving the base URL fails or there is no <base> tag
 */
ve.fixBase = function ( targetDoc, sourceDoc, fallbackBase ) {
	var baseNode = targetDoc.getElementsByTagName( 'base' )[ 0 ];
	if ( baseNode ) {
		if ( !targetDoc.baseURI ) {
			// <base> tag present but not valid, try resolving its URL
			baseNode.setAttribute( 'href', ve.resolveUrl( baseNode.getAttribute( 'href' ), sourceDoc ) );
			if ( !targetDoc.baseURI && fallbackBase ) {
				// That didn't work, use the fallback
				baseNode.setAttribute( 'href', fallbackBase );
			}
		}
		// else: <base> tag present and valid, do nothing
	} else if ( fallbackBase ) {
		// No <base> tag, add one
		baseNode = targetDoc.createElement( 'base' );
		baseNode.setAttribute( 'href', fallbackBase );
		targetDoc.head.appendChild( baseNode );
	}
};

/**
 * Check if a string is a valid URI component.
 *
 * A URI component is considered invalid if decodeURIComponent() throws an exception.
 *
 * @param {string} s String to test
 * @return {boolean} decodeURIComponent( s ) did not throw an exception
 * @see #safeDecodeURIComponent
 */
ve.isUriComponentValid = function ( s ) {
	try {
		decodeURIComponent( s );
	} catch ( e ) {
		return false;
	}
	return true;
};

/**
 * Safe version of decodeURIComponent() that doesn't throw exceptions.
 *
 * If the native decodeURIComponent() call threw an exception, the original string
 * will be returned.
 *
 * @param {string} s String to decode
 * @return {string} Decoded string, or same string if decoding failed
 * @see #isUriComponentValid
 */
ve.safeDecodeURIComponent = function ( s ) {
	try {
		s = decodeURIComponent( s );
	} catch ( e ) {}
	return s;
};

/**
 * Get the actual inner HTML of a DOM node.
 *
 * In most browsers, .innerHTML is broken and eats newlines in `<pre>` elements, see
 * https://bugzilla.mozilla.org/show_bug.cgi?id=838954 . This function detects this behavior
 * and works around it, to the extent possible. `<pre>\nFoo</pre>` will become `<pre>Foo</pre>`
 * if the browser is broken, but newlines are preserved in all other cases.
 *
 * @param {HTMLElement} element HTML element to get inner HTML of
 * @return {string} Inner HTML
 */
ve.properInnerHtml = function ( element ) {
	return ve.fixupPreBug( element ).innerHTML;
};

/**
 * Get the actual outer HTML of a DOM node.
 *
 * @see ve#properInnerHtml
 * @param {HTMLElement} element HTML element to get outer HTML of
 * @return {string} Outer HTML
 */
ve.properOuterHtml = function ( element ) {
	return ve.fixupPreBug( element ).outerHTML;
};

/**
 * Helper function for #properInnerHtml, #properOuterHtml and #serializeXhtml.
 *
 * Detect whether the browser has broken `<pre>` serialization, and if so return a clone
 * of the node with extra newlines added to make it serialize properly. If the browser is not
 * broken, just return the original node.
 *
 * @param {HTMLElement} element HTML element to fix up
 * @return {HTMLElement} Either element, or a fixed-up clone of it
 */
ve.fixupPreBug = function ( element ) {
	var div, $element;
	if ( ve.isPreInnerHtmlBroken === undefined ) {
		// Test whether newlines in `<pre>` are serialized back correctly
		div = document.createElement( 'div' );
		div.innerHTML = '<pre>\n\n</pre>';
		ve.isPreInnerHtmlBroken = div.innerHTML === '<pre>\n</pre>';
	}

	if ( !ve.isPreInnerHtmlBroken ) {
		return element;
	}

	// Workaround for bug 42469: if a `<pre>` starts with a newline, that means .innerHTML will
	// screw up and stringify it with one fewer newline. Work around this by adding a newline.
	// If we don't see a leading newline, we still don't know if the original HTML was
	// `<pre>Foo</pre>` or `<pre>\nFoo</pre>`, but that's a syntactic difference, not a
	// semantic one, and handling that is the integration target's job.
	$element = $( element ).clone();
	$element.find( 'pre, textarea, listing' ).each( function () {
		var matches;
		if ( this.firstChild && this.firstChild.nodeType === Node.TEXT_NODE ) {
			matches = this.firstChild.data.match( /^(\r\n|\r|\n)/ );
			if ( matches && matches[ 1 ] ) {
				// Prepend a newline exactly like the one we saw
				this.firstChild.insertData( 0, matches[ 1 ] );
			}
		}
	} );
	return $element.get( 0 );
};

/**
 * Helper function for #transformStyleAttributes.
 *
 * Normalize an attribute value. In compliant browsers, this should be
 * a no-op, but in IE style attributes are normalized on all elements,
 * color and bgcolor attributes are normalized on some elements (like `<tr>`),
 * and width and height attributes are normalized on some elements( like `<table>`).
 *
 * @param {string} name Attribute name
 * @param {string} value Attribute value
 * @param {string} [nodeName='div'] Element name
 * @return {string} Normalized attribute value
 */
ve.normalizeAttributeValue = function ( name, value, nodeName ) {
	var node = document.createElement( nodeName || 'div' );
	node.setAttribute( name, value );
	// IE normalizes invalid CSS to empty string, then if you normalize
	// an empty string again it becomes null. Return an empty string
	// instead of null to make this function idempotent.
	return node.getAttribute( name ) || '';
};

/**
 * Helper function for #parseXhtml and #serializeXhtml.
 *
 * Map attributes that are broken in IE to attributes prefixed with data-ve-
 * or vice versa.
 *
 * @param {string} html HTML string. Must also be valid XML
 * @param {boolean} unmask Map the masked attributes back to their originals
 * @return {string} HTML string modified to mask/unmask broken attributes
 */
ve.transformStyleAttributes = function ( html, unmask ) {
	var xmlDoc, fromAttr, toAttr, i, len,
		maskAttrs = [
			'style', // IE normalizes 'color:#ffd' to 'color: rgb(255, 255, 221);'
			'bgcolor', // IE normalizes '#FFDEAD' to '#ffdead'
			'color', // IE normalizes 'Red' to 'red'
			'width', // IE normalizes '240px' to '240'
			'height', // Same as width
			'rowspan', // IE and Firefox normalize rowspan="02" to rowspan="2"
			'colspan' // Same as rowspan
		];

	// Parse the HTML into an XML DOM
	xmlDoc = new DOMParser().parseFromString( html, 'text/xml' );

	// Go through and mask/unmask each attribute on all elements that have it
	for ( i = 0, len = maskAttrs.length; i < len; i++ ) {
		fromAttr = unmask ? 'data-ve-' + maskAttrs[ i ] : maskAttrs[ i ];
		toAttr = unmask ? maskAttrs[ i ] : 'data-ve-' + maskAttrs[ i ];
		/*jshint loopfunc:true */
		$( xmlDoc ).find( '[' + fromAttr + ']' ).each( function () {
			var toAttrValue, fromAttrNormalized,
				fromAttrValue = this.getAttribute( fromAttr );

			if ( unmask ) {
				this.removeAttribute( fromAttr );

				// If the data-ve- version doesn't normalize to the same value,
				// the attribute must have changed, so don't overwrite it
				fromAttrNormalized = ve.normalizeAttributeValue( toAttr, fromAttrValue, this.nodeName );
				// toAttr can't not be set, but IE returns null if the value was ''
				toAttrValue = this.getAttribute( toAttr ) || '';
				if ( toAttrValue !== fromAttrNormalized ) {
					return;
				}
			}

			this.setAttribute( toAttr, fromAttrValue );
		} );
	}

	// HACK: Inject empty text nodes into empty non-void tags to prevent
	// things like <a></a> from being serialized as <a /> and wreaking havoc
	$( xmlDoc ).find( ':empty:not(' + ve.elementTypes.void.join( ',' ) + ')' ).each( function () {
		this.appendChild( xmlDoc.createTextNode( '' ) );
	} );

	// Serialize back to a string
	return new XMLSerializer().serializeToString( xmlDoc );
};

/**
 * Parse an HTML string into an HTML DOM, while masking attributes affected by
 * normalization bugs if a broken browser is detected.
 * Since this process uses an XML parser, the input must be valid XML as well as HTML.
 *
 * @param {string} html HTML string. Must also be valid XML
 * @return {HTMLDocument} HTML DOM
 */
ve.parseXhtml = function ( html ) {
	// Feature-detect style attribute breakage in IE
	if ( ve.isStyleAttributeBroken === undefined ) {
		ve.isStyleAttributeBroken = ve.normalizeAttributeValue( 'style', 'color:#ffd' ) !== 'color:#ffd';
	}
	if ( ve.isStyleAttributeBroken ) {
		html = ve.transformStyleAttributes( html, false );
	}
	return ve.createDocumentFromHtml( html );
};

/**
 * Serialize an HTML DOM created with #parseXhtml back to an HTML string, unmasking any
 * attributes that were masked.
 *
 * @param {HTMLDocument} doc HTML DOM
 * @return {string} Serialized HTML string
 */
ve.serializeXhtml = function ( doc ) {
	var xml;
	// Feature-detect style attribute breakage in IE
	if ( ve.isStyleAttributeBroken === undefined ) {
		ve.isStyleAttributeBroken = ve.normalizeAttributeValue( 'style', 'color:#ffd' ) !== 'color:#ffd';
	}
	if ( !ve.isStyleAttributeBroken ) {
		// Use outerHTML if possible because in Firefox, XMLSerializer URL-encodes
		// hrefs but outerHTML doesn't
		return ve.properOuterHtml( doc.documentElement );
	}

	xml = new XMLSerializer().serializeToString( ve.fixupPreBug( doc.documentElement ) );
	// HACK: strip out xmlns
	xml = xml.replace( '<html xmlns="http://www.w3.org/1999/xhtml"', '<html' );
	return ve.transformStyleAttributes( xml, true );
};

/**
 * Wrapper for node.normalize(). The native implementation is broken in IE,
 * so we use our own implementation in that case.
 *
 * @param {Node} node Node to normalize
 */
ve.normalizeNode = function ( node ) {
	var p, nodeIterator, textNode;
	if ( ve.isNormalizeBroken === undefined ) {
		// Feature-detect IE11's broken .normalize() implementation.
		// We know that it fails to remove the empty text node at the end
		// in this example, but for mysterious reasons it also fails to merge
		// text nodes in other cases and we don't quite know why. So if we detect
		// that .normalize() is broken, fall back to a completely manual version.
		p = document.createElement( 'p' );
		p.appendChild( document.createTextNode( 'Foo' ) );
		p.appendChild( document.createTextNode( 'Bar' ) );
		p.appendChild( document.createTextNode( '' ) );
		p.normalize();
		ve.isNormalizeBroken = p.childNodes.length !== 1;
	}

	if ( ve.isNormalizeBroken ) {
		// Perform normalization manually
		nodeIterator = node.ownerDocument.createNodeIterator(
			node,
			NodeFilter.SHOW_TEXT,
			function () { return NodeFilter.FILTER_ACCEPT; },
			false
		);
		while ( ( textNode = nodeIterator.nextNode() ) ) {
			// Remove if empty
			if ( textNode.data === '' ) {
				textNode.parentNode.removeChild( textNode );
				continue;
			}
			// Merge in any adjacent text nodes
			while ( textNode.nextSibling && textNode.nextSibling.nodeType === Node.TEXT_NODE ) {
				textNode.appendData( textNode.nextSibling.data );
				textNode.parentNode.removeChild( textNode.nextSibling );
			}
		}
	} else {
		// Use native implementation
		node.normalize();
	}
};

/**
 * Translate rect by some fixed vector and return a new offset object
 *
 * @param {Object} rect Offset object containing all or any of top, left, bottom, right, width & height
 * @param {number} x Horizontal translation
 * @param {number} y Vertical translation
 * @return {Object} Translated rect
 */
ve.translateRect = function ( rect, x, y ) {
	var translatedRect = {};
	if ( rect.top !== undefined ) {
		translatedRect.top = rect.top + y;
	}
	if ( rect.bottom !== undefined ) {
		translatedRect.bottom = rect.bottom + y;
	}
	if ( rect.left !== undefined ) {
		translatedRect.left = rect.left + x;
	}
	if ( rect.right !== undefined ) {
		translatedRect.right = rect.right + x;
	}
	if ( rect.width !== undefined ) {
		translatedRect.width = rect.width;
	}
	if ( rect.height !== undefined ) {
		translatedRect.height = rect.height;
	}
	return translatedRect;
};

/**
 * Get the start and end rectangles (in a text flow sense) from a list of rectangles
 *
 * @param {Array} rects Full list of rectangles
 * @return {Object|null} Object containing two rectangles: start and end, or null if there are no rectangles
 */
ve.getStartAndEndRects = function ( rects ) {
	var i, l, startRect, endRect;
	if ( !rects || !rects.length ) {
		return null;
	}
	for ( i = 0, l = rects.length; i < l; i++ ) {
		if ( !startRect || rects[ i ].top < startRect.top ) {
			// Use ve.extendObject as ve.copy copies non-plain objects by reference
			startRect = ve.extendObject( {}, rects[ i ] );
		} else if ( rects[ i ].top === startRect.top ) {
			// Merge rects with the same top coordinate
			startRect.left = Math.min( startRect.left, rects[ i ].left );
			startRect.right = Math.max( startRect.right, rects[ i ].right );
			startRect.width = startRect.right - startRect.left;
		}
		if ( !endRect || rects[ i ].bottom > endRect.bottom ) {
			// Use ve.extendObject as ve.copy copies non-plain objects by reference
			endRect = ve.extendObject( {}, rects[ i ] );
		} else if ( rects[ i ].bottom === endRect.bottom ) {
			// Merge rects with the same bottom coordinate
			endRect.left = Math.min( endRect.left, rects[ i ].left );
			endRect.right = Math.max( endRect.right, rects[ i ].right );
			endRect.width = startRect.right - startRect.left;
		}
	}
	return {
		start: startRect,
		end: endRect
	};
};

/**
 * Find the nearest common ancestor of DOM nodes
 *
 * @param {...Node} DOM nodes in the same document
 * @return {Node|null} Nearest common ancestor node
 */
ve.getCommonAncestor = function () {
	var i, j, nodeCount, chain, node,
		minHeight = null,
		chains = [],
		args = Array.prototype.slice.call( arguments );
	nodeCount = args.length;
	if ( nodeCount === 0 ) {
		throw new Error( 'Need at least one node' );
	}
	// Build every chain
	for ( i = 0; i < nodeCount; i++ ) {
		chain = [];
		node = args[ i ];
		while ( node !== null ) {
			chain.unshift( node );
			node = node.parentNode;
		}
		if ( chain.length === 0 ) {
			return null;
		}
		if ( i > 0 && chain[ 0 ] !== chains[ chains.length - 1 ][ 0 ] ) {
			return null;
		}
		if ( minHeight === null || minHeight > chain.length ) {
			minHeight = chain.length;
		}
		chains.push( chain );
	}

	// Step through chains in parallel, until they differ
	// All chains are guaranteed to start with documentNode
	for ( i = 1; i < minHeight; i++ ) {
		node = chains[ 0 ][ i ];
		for ( j = 1; j < nodeCount; j++ ) {
			if ( node !== chains[ j ][ i ] ) {
				return chains[ 0 ][ i - 1 ];
			}
		}
	}
	return chains[ 0 ][ minHeight - 1 ];
};

/**
 * Get the offset path from ancestor to offset in descendant
 *
 * @param {Node} ancestor The ancestor node
 * @param {Node} node The descendant node
 * @param {number} nodeOffset The offset in the descendant node
 * @return {number[]} The offset path
 */
ve.getOffsetPath = function ( ancestor, node, nodeOffset ) {
	var path = [ nodeOffset ];
	while ( node !== ancestor ) {
		if ( node.parentNode === null ) {
			ve.log( node, 'is not a descendant of', ancestor );
			throw new Error( 'Not a descendant' );
		}
		path.unshift(
			Array.prototype.indexOf.call( node.parentNode.childNodes, node )
		);
		node = node.parentNode;
	}
	return path;
};

/**
 * Compare two tuples in lexicographical order.
 *
 * This function first compares `a[0]` with `b[0]`, then `a[1]` with `b[1]`, etc.
 * until it encounters a pair where `a[k] != b[k]`; then returns `a[k] - b[k]`.
 *
 * If `a[k] == b[k]` for every `k`, this function returns 0.
 *
 * If a and b are of unequal length, but `a[k] == b[k]` for all `k` that exist in both a and b, then
 * this function returns `Infinity` (if a is longer) or `-Infinity` (if b is longer).
 *
 * @param {number[]} a First tuple
 * @param {number[]} b Second tuple
 * @return {number} `a[k] - b[k]` where k is the lowest k such that `a[k] != b[k]`
 */
ve.compareTuples = function ( a, b ) {
	var i, len;
	for ( i = 0, len = Math.min( a.length, b.length ); i < len; i++ ) {
		if ( a[ i ] !== b[ i ] ) {
			return a[ i ] - b[ i ];
		}
	}
	if ( a.length > b.length ) {
		return Infinity;
	}
	if ( a.length < b.length ) {
		return -Infinity;
	}
	return 0;
};

/**
 * Compare two nodes for position in document
 *
 * @param {Node} node1 First node
 * @param {number} offset1 First offset
 * @param {Node} node2 Second node
 * @param {number} offset2 Second offset
 * @return {number} negative, zero or positive number
 */
ve.compareDocumentOrder = function ( node1, offset1, node2, offset2 ) {
	var commonAncestor = ve.getCommonAncestor( node1, node2 );
	if ( commonAncestor === null ) {
		throw new Error( 'No common ancestor' );
	}
	return ve.compareTuples(
		ve.getOffsetPath( commonAncestor, node1, offset1 ),
		ve.getOffsetPath( commonAncestor, node2, offset2 )
	);
};

/**
 * Get the client platform string from the browser.
 *
 * HACK: This is a wrapper for calling getSystemPlatform() on the current platform
 * except that if the platform hasn't been constructed yet, it falls back to using
 * the base class implementation in {ve.init.Platform}. A proper solution would be
 * not to need this information before the platform is constructed.
 *
 * @see ve.init.Platform#getSystemPlatform
 * @return {string} Client platform string
 */
ve.getSystemPlatform = function () {
	return ( ve.init.platform && ve.init.platform.constructor || ve.init.Platform ).static.getSystemPlatform();
};

/**
 * Highlight text where a substring query matches
 *
 * @param {string} text Text
 * @param {string} query Query to find
 * @return {jQuery} Text with query substring wrapped in highlighted span
 */
ve.highlightQuery = function ( text, query ) {
	var $result = $( '<span>' ),
		offset = text.toLowerCase().indexOf( query.toLowerCase() );

	if ( !query.length || offset === -1 ) {
		return $result.text( text );
	}
	$result.append(
		document.createTextNode( text.slice( 0, offset ) ),
		$( '<span>' )
			.addClass( 've-ui-query-highlight' )
			.text( text.slice( offset, offset + query.length ) ),
		document.createTextNode( text.slice( offset + query.length ) )
	);
	return $result.contents();
};

/**
 * Get the closest matching DOM position in document order (forward or reverse)
 *
 * A DOM position is represented as an object with "node" and "offset" properties. The noDescend
 * option can be used to exclude the positions inside certain element nodes; it is a jQuery
 * selector/function ( used as a test by $node.is() - see http://api.jquery.com/is/ ); it defaults
 * to ve.rejectsCursor. Void elements (those matching ve.isVoidElement) are always excluded.
 *
 * If the skipSoft option is true (default), positions cursor-equivalent to the start position are
 * stepped over and the nearest non-equivalent position is returned. Cursor-equivalent positions
 * include just before/just after the boundary of a text element or an annotation element. So in
 * &lt;#text&gt;X&lt;/#text&gt;&lt;b&gt;&lt;#text&gt;y&lt;/#text&gt;&lt;/b&gt; there are four
 * cursor-equivalent positions between X and Y.
 * Chromium normalizes cursor focus/offset, when they are set, to the start-most equivalent
 * position in document order. Firefox does not normalize, but jumps when cursoring over positions
 * that are equivalent to the start position.
 *
 * As well as the end position, an array of the steps taken is returned. This will have length 1
 * unless skipSoft is true. Each step gives the node, the type of crossing (which can be
 * "enter", "leave", or "cross" for any node, or "internal" for a step over a
 * character in a text node), and the offset (defined for "internal" steps only).
 *
 * Limitation: skipSoft treats the interior of grapheme clusters as non-equivalent, but in fact
 * browser cursoring does skip over most grapheme clusters e.g. 'x\u0301' (though not all e.g.
 * '\u062D\u0627').
 *
 * Limitation: some DOM positions cannot actually hold the cursor; e.g. the start of the interior
 * of a table node.
 *
 * @param {Object} position Start position
 * @param {Node} position.node Start node
 * @param {Node} position.offset Start offset
 * @param {number} direction +1 for forward, -1 for reverse
 * @param {Object} [options]
 * @param {Function|string} [options.noDescend] Selector or function: nodes to skip over
 * @param {boolean} [options.skipSoft] Skip tags that don't expend a cursor press (default: true)
 * @return {Object} The adjacent DOM position encountered
 * @return {Node|null} return.node The node, or null if we stepped past the root node
 * @return {number|null} return.offset The offset, or null if we stepped past the root node
 * @return {Object[]} return.steps Steps taken {node: x, type: leave|cross|enter|internal, offset: n}
 */
ve.adjacentDomPosition = function ( position, direction, options ) {
	var forward, childNode, isHard, noDescend, skipSoft,
		node = position.node,
		offset = position.offset,
		steps = [];

	options = options || {};
	noDescend = options.noDescend || ve.rejectsCursor;
	skipSoft = 'skipSoft' in options ? options.skipSoft : true;

	direction = direction < 0 ? -1 : 1;
	forward = ( direction === 1 );

	while ( true ) {
		// If we're at the node's leading edge, move to the adjacent position in the parent node
		if ( offset === ( forward ? node.length || node.childNodes.length : 0 ) ) {
			steps.push( {
				node: node,
				type: 'leave'
			} );
			isHard = ve.hasHardCursorBoundaries( node );
			if ( node.parentNode === null ) {
				return {
					node: null,
					offset: null,
					steps: steps
				};
			}
			offset = Array.prototype.indexOf.call( node.parentNode.childNodes, node ) +
				( forward ? 1 : 0 );
			node = node.parentNode;
			if ( !skipSoft || isHard ) {
				return {
					node: node,
					offset: offset,
					steps: steps
				};
			}
			// Else take another step
			continue;
		}
		// Else we're in the interior of a node

		// If we're in a text node, move to the position in this node at the next offset
		if ( node.nodeType === Node.TEXT_NODE ) {
			steps.push( {
				node: node,
				type: 'internal',
				offset: offset - ( forward ? 0 : 1 )
			} );
			return {
				node: node,
				offset: offset + direction,
				steps: steps
			};
		}
		// Else we're in the interior of an element node

		childNode = node.childNodes[ forward ? offset : offset - 1 ];

		// If the child is uncursorable, or is an element matching noDescend, do not
		// descend into it: instead, return the position just beyond it in the current node
		if (
			childNode.nodeType === Node.ELEMENT_NODE &&
			( ve.isVoidElement( childNode ) || $( childNode ).is( noDescend ) )
		) {
			steps.push( {
				node: childNode,
				type: 'cross'
			} );
			return {
				node: node,
				offset: offset + ( forward ? 1 : -1 ),
				steps: steps
			};
		}

		// Go to the closest offset inside the child node
		isHard = ve.hasHardCursorBoundaries( childNode );
		node = childNode;
		offset = forward ? 0 : node.length || node.childNodes.length;
		steps.push( {
			node: node,
			type: 'enter'
		} );
		if ( !skipSoft || isHard ) {
			return {
				node: node,
				offset: offset,
				steps: steps
			};
		}
	}
};

/**
 * Test whether crossing a node's boundaries uses up a cursor press
 *
 * Essentially, this is true unless the node is a text node or an annotation node
 *
 * @param {Node} node Element node or text node
 * @return {boolean} Whether crossing the node's boundaries uses up a cursor press
 */
ve.hasHardCursorBoundaries = function ( node ) {
	return node.nodeType === node.ELEMENT_NODE && (
		ve.isBlockElement( node ) || ve.isVoidElement( node )
	);
};

/**
 * Tests whether an adjacent cursor would be prevented from entering the node
 *
 * @param {Node} [node] Element node or text node; defaults to "this" if a Node
 * @return {boolean} Whether an adjacent cursor would be prevented from entering
 */
ve.rejectsCursor = function ( node ) {
	if ( !node && this instanceof Node ) {
		node = this;
	}
	if ( node.nodeType === node.TEXT_NODE ) {
		return false;
	}
	if ( ve.isVoidElement( node ) ) {
		return true;
	}
	// We don't need to check whether the ancestor-nearest contenteditable tag is
	// false, because if so then there can be no adjacent cursor.
	return node.contentEditable === 'false';
};

// ve-upstream-sync - review - @author: Paul Oslund
// Brought back in for older browser support
/**
 * Wrapper for Array#indexOf.
 *
 * Values are compared without type coercion.
 *
 * @method
 * @source <http://api.jquery.com/jQuery.inArray/>
 * @until ES5: Array#indexOf
 * @param {Mixed} value Element to search for
 * @param {Array} array Array to search in
 * @param {number} [fromIndex=0] Index to being searching from
 * @returns {number} Index of value in array, or -1 if not found
 */
ve.indexOf = $.inArray;
