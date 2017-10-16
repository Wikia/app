/*!
 * VisualEditor utilities.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * @class ve
 */

/**
 * Checks if an object is an instance of one or more classes.
 *
 * @param {Object} subject Object to check
 * @param {Function[]} classes Classes to compare with
 * @returns {boolean} Object inherits from one or more of the classes
 */
ve.isInstanceOfAny = function ( subject, classes ) {
	var i = classes.length;

	while ( classes[--i] ) {
		if ( subject instanceof classes[i] ) {
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
 * @inheritdoc OO#cloneObject
 */
ve.getObjectValues = OO.getObjectValues;

/**
 * @method
 * @until ES5: Object#keys
 * @inheritdoc Object#keys
 */
ve.getObjectKeys = Object.keys;

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
 * Copy an array of DOM elements, optionally into a different document.
 *
 * @param {HTMLElement[]} domElements DOM elements to copy
 * @param {HTMLDocument} [doc] Document to create the copies in; if unset, simply clone each element
 * @returns {HTMLElement[]} Copy of domElements with copies of each element
 */
ve.copyDomElements = function ( domElements, doc ) {
	return domElements.map( function ( domElement ) {
		return doc ? doc.importNode( domElement, true ) : domElement.cloneNode( true );
	} );
};

/**
 * Check to see if an object is a plain object (created using "{}" or "new Object").
 *
 * @method
 * @source <http://api.jquery.com/jQuery.isPlainObject/>
 * @param {Object} obj The object that will be checked to see if it's a plain object
 * @returns {boolean}
 */
ve.isPlainObject = $.isPlainObject;

/**
 * Check to see if an object is empty (contains no properties).
 *
 * @method
 * @source <http://api.jquery.com/jQuery.isEmptyObject/>
 * @param {Object} obj The object that will be checked to see if it's empty
 * @returns {boolean}
 */
ve.isEmptyObject = $.isEmptyObject;

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
 * @param {Mixed...} [sources] Variadic list of objects containing properties
 * to be merged into the target.
 * @returns {Mixed} Modified version of first or second argument
 */
ve.extendObject = $.extend;

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
 * Includes a replacement for broken implementation of Array.prototype.splice() found in Opera 12.
 *
 * @param {Array|ve.dm.BranchNode} arr Object supporting .splice() to remove from and insert into. Will be modified
 * @param {number} offset Offset in arr to splice at. This may NOT be negative, unlike the
 *  'index' parameter in Array#splice
 * @param {number} remove Number of elements to remove at the offset. May be zero
 * @param {Array} data Array of items to insert at the offset. May not be empty if remove=0
 * @returns {Array} Array of items removed
 */
ve.batchSplice = ( function () {
	var arraySplice;

	// This yields 'true' on Opera 12.15.
	function isSpliceBroken() {
		var n = 256, a = [];
		a[n] = 'a';

		a.splice( n + 1, 0, 'b' );

		return a[n] !== 'a';
	}

	if ( !isSpliceBroken() ) {
		arraySplice = Array.prototype.splice;
	} else {
		// Standard Array.prototype.splice() function implemented using .slice() and .push().
		arraySplice = function ( offset, remove/*, data... */ ) {
			var data, begin, removed, end;

			data = Array.prototype.slice.call( arguments, 2 );

			begin = this.slice( 0, offset );
			removed = this.slice( offset, remove );
			end = this.slice( offset + remove );

			this.length = 0;
			// This polyfill only been discovered to be necessary on Opera
			// and it seems to handle up to 1048575 function parameters.
			this.push.apply( this, begin );
			this.push.apply( this, data );
			this.push.apply( this, end );

			return removed;
		};
	}

	return function ( arr, offset, remove, data ) {
		// We need to splice insertion in in batches, because of parameter list length limits which vary
		// cross-browser - 1024 seems to be a safe batch size on all browsers
		var splice, index = 0, batchSize = 1024, toRemove = remove, spliced, removed = [];

		splice = Array.isArray( arr ) ? arraySplice : arr.splice;

		if ( data.length === 0 ) {
			// Special case: data is empty, so we're just doing a removal
			// The code below won't handle that properly, so we do it here
			return splice.call( arr, offset, remove );
		}

		while ( index < data.length ) {
			// Call arr.splice( offset, remove, i0, i1, i2, ..., i1023 );
			// Only set remove on the first call, and set it to zero on subsequent calls
			spliced = splice.apply(
				arr, [index + offset, toRemove].concat( data.slice( index, index + batchSize ) )
			);
			if ( toRemove > 0 ) {
				removed = spliced;
			}
			index += batchSize;
			toRemove = 0;
		}
		return removed;
	};
}() );

/**
 * Push one array into another.
 *
 * This is the equivalent of arr.push( d1, d2, d3, ... ) except that arguments are
 * specified as an array rather than separate parameters.
 *
 * @param {Array|ve.dm.BranchNode} arr Object supporting .push() to insert at the end of the array. Will be modified
 * @param {Array} data Array of items to insert.
 * @returns {number} length of the new array
 */
ve.batchPush = function ( arr, data ) {
	// We need to push insertion in batches, because of parameter list length limits which vary
	// cross-browser - 1024 seems to be a safe batch size on all browsers
	var length, index = 0, batchSize = 1024;
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
 * Insert one array into another.
 *
 * This just a shortcut for `ve.batchSplice( dst, offset, 0, src )`.
 *
 * @see #batchSplice
 */
ve.insertIntoArray = function ( dst, offset, src ) {
	ve.batchSplice( dst, offset, 0, src );
};

/**
 * Log data to the console.
 *
 * This implementation does nothing, to add a real implementation ve.debug needs to be loaded.
 *
 * @param {Mixed...} [args] Data to log
 */
ve.log = ve.log || function () {
	// don't do anything, this is just a stub
};

/**
 * Log error to the console.
 *
 * This implementation does nothing, to add a real implementation ve.debug needs to be loaded.
 *
 * @param {Mixed...} [args] Data to log
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
 * Return a function, that, as long as it continues to be invoked, will not
 * be triggered. The function will be called after it stops being called for
 * N milliseconds. If `immediate` is passed, trigger the function on the
 * leading edge, instead of the trailing.
 *
 * Ported from: http://underscorejs.org/underscore.js
 *
 * @param {Function} func
 * @param {number} wait
 * @param {boolean} immediate
 * @returns {Function}
 */
ve.debounce = function ( func, wait, immediate ) {
	var timeout;
	return function () {
		var context = this,
			args = arguments,
			later = function () {
				timeout = null;
				if ( !immediate ) {
					func.apply( context, args );
				}
			};
		if ( immediate && !timeout ) {
			func.apply( context, args );
		}
		clearTimeout( timeout );
		timeout = setTimeout( later, wait );
	};
};

/**
 * Select the contents of an element
 *
 * @param {HTMLElement} element Element
 */
ve.selectElement = function ( element ) {
	var nativeRange = OO.ui.Element.static.getDocument( element ).createRange(),
		nativeSelection = OO.ui.Element.static.getWindow( element ).getSelection();
	nativeRange.setStart( element, 0 );
	nativeRange.setEnd( element, element.childNodes.length );
	nativeSelection.removeAllRanges();
	nativeSelection.addRange( nativeRange );
};

/**
 * Move the selection to the end of an input.
 *
 * @param {HTMLElement} element Input element
 */
ve.selectEnd = function ( element ) {
	element.focus();
	if ( element.selectionStart !== undefined ) {
		element.selectionStart = element.selectionEnd = element.value.length;
	} else if ( element.createTextRange ) {
		var textRange = element.createTextRange();
		textRange.collapse( false );
		textRange.select();
	}
};

/**
 * Get a localized message.
 *
 * @param {string} key Message key
 * @param {Mixed...} [params] Message parameters
 */
ve.msg = function () {
	// Avoid using bind because ve.init.platform doesn't exist yet.
	// TODO: Fix dependency issues between ve.js and ve.init.platform
	return ve.init.platform.getMessage.apply( ve.init.platform, arguments );
};

/**
 * Determine if the text consists of only unattached combining marks.
 *
 * @param {string} text Text to test
 * @returns {boolean} The text is unattached combining marks
 */
ve.isUnattachedCombiningMark = function ( text ) {
	return ( /^[\u0300-\u036F]+$/ ).test( text );
};

/**
 * Convert a grapheme cluster offset to a byte offset.
 *
 * @param {string} text Text in which to calculate offset
 * @param {number} clusterOffset Grapheme cluster offset
 * @returns {number} Byte offset
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
 * @returns {number} Grapheme cluster offset
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
 * @returns {string} Substring of text
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
 * This method is basically a copy of `mw.html.escape`.
 *
 * @see #escapeHtml_escapeHtmlCharacter
 * @param {string} value Attribute value to escape
 * @returns {string} Escaped attribute value
 */
ve.escapeHtml = function ( value ) {
	return value.replace( /['"<>&]/g, ve.escapeHtml.escapeHtmlCharacter );
};

/**
 * Helper function for #escapeHtml to escape a character for use in HTML.
 *
 * This is a callback intended to be passed to String#replace.
 *
 * @method escapeHtml_escapeHtmlCharacter
 * @private
 * @param {string} key Property name of value being replaced
 * @returns {string} Escaped character
 */
ve.escapeHtml.escapeHtmlCharacter = function ( value ) {
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
		default:
			return value;
	}
};

/**
 * Generate HTML attributes.
 *
 * This method copies part of `mw.html.element` from MediaWiki.
 *
 * NOTE: While the values of attributes are escaped, the names of attributes (i.e. the keys in
 * the attributes objects) are NOT ESCAPED. The caller is responsible for making sure these are
 * sane tag/attribute names and do not contain unsanitized content from an external source
 * (e.g. from the user or from the web).
 *
 * @param {Object} [attributes] Key-value map of attributes for the tag
 * @returns {string} HTML attributes
 */
ve.getHtmlAttributes = function ( attributes ) {
	var attrName, attrValue,
		parts = [];

	if ( !ve.isPlainObject( attributes ) || ve.isEmptyObject( attributes ) ) {
		return '';
	}

	for ( attrName in attributes ) {
		attrValue = attributes[attrName];
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
 * This method copies part of `mw.html.element` from MediaWiki.
 *
 * NOTE: While the values of attributes are escaped, the tag name and the names of
 * attributes (i.e. the keys in the attributes objects) are NOT ESCAPED. The caller is
 * responsible for making sure these are sane tag/attribute names and do not contain
 * unsanitized content from an external source (e.g. from the user or from the web).
 *
 * @param {string} tag HTML tag name
 * @param {Object} [attributes] Key-value map of attributes for the tag
 * @returns {string} Opening HTML tag
 */
ve.getOpeningHtmlTag = function ( tagName, attributes ) {
	var attr = ve.getHtmlAttributes( attributes );
	return '<' + tagName + ( attr ? ' ' + attr : '' ) + '>';
};

/**
 * Get the attributes of a DOM element as an object with key/value pairs.
 *
 * @param {HTMLElement} element
 * @returns {Object}
 */
ve.getDomAttributes = function ( element ) {
	var result = {}, i;
	for ( i = 0; i < element.attributes.length; i++ ) {
		result[element.attributes[i].name] = element.attributes[i].value;
	}
	return result;
};

/**
 * Set the attributes of a DOM element as an object with key/value pairs.
 *
 * @param {HTMLElement} element DOM element to apply attributes to
 * @param {Object} attributes Attributes to apply
 * @param {string[]} [whitelist] List of attributes to exclusively allow (all lower case names)
 */
ve.setDomAttributes = function ( element, attributes, whitelist ) {
	var key;
	// Duck-typing for attribute setting
	if ( !element.setAttribute || !element.removeAttribute ) {
		return;
	}
	for ( key in attributes ) {
		if ( attributes[key] === undefined || attributes[key] === null ) {
			element.removeAttribute( key );
		} else {
			if ( whitelist && whitelist.indexOf( key.toLowerCase() ) === -1 ) {
				continue;
			}
			element.setAttribute( key, attributes[key] );
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
 * @returns {Object} Summary of element.
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
			summary.attributes[element.attributes[i].name] = element.attributes[i].value;
		}
	}
	// Summarize children
	if ( element.childNodes ) {
		for ( i = 0; i < element.childNodes.length; i++ ) {
			summary.children.push( ve.getDomElementSummary( element.childNodes[i], includeHtml ) );
		}
	}
	return summary;
};

/**
 * Callback for #copy to convert nodes to a comparable summary.
 *
 * @private
 * @param {Object} value Value in the object/array
 * @returns {Object} DOM element summary if value is a node, otherwise just the value
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
 * @returns {boolean} Element is a block element
 */
ve.isBlockElement = function ( element ) {
	var elementName = typeof element === 'string' ? element : element.nodeName;
	return ve.indexOf( elementName.toLowerCase(), ve.elementTypes.block ) !== -1;
};

/**
 * Check whether a given DOM element is a void element (can't have children).
 *
 * @param {HTMLElement|string} element Element or element name
 * @returns {boolean} Element is a void element
 */
ve.isVoidElement = function ( element ) {
	var elementName = typeof element === 'string' ? element : element.nodeName;
	return ve.indexOf( elementName.toLowerCase(), ve.elementTypes.void ) !== -1;
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
 * @returns {HTMLDocument} Document constructed from the HTML string
 */
ve.createDocumentFromHtml = function ( html ) {
	// Try using DOMParser if available. This only works in Firefox 12+ and very modern
	// versions of other browsers (Chrome 30+, Opera 17+, IE10+)
	var newDocument, $iframe, iframe;
	try {
		if ( html === '' ) {
			// IE doesn't like empty strings
			html = '<body></body>';
		}
		newDocument = new DOMParser().parseFromString( html, 'text/html' );
		if ( newDocument ) {
			return newDocument;
		}
	} catch ( e ) { }

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
		newDocument = document.implementation.createHTMLDocument( '' );
		// Carefully unwrap the HTML out of the root node (and doctype, if any).
		// <html> might have some arguments here, but they're apparently not important.
		html = html.replace(/^\s*(?:<!doctype[^>]*>)?\s*<html[^>]*>/i, '' );
		html = html.replace(/<\/html>\s*$/i, '' );
		newDocument.documentElement.innerHTML = html;
	}

	return newDocument;
};

/**
 * Resolve a URL according to a given base.
 *
 * Passing a string for the base parameter causes a throwaway document to be created, which is
 * slow.
 *
 * @param {string} url URL to resolve
 * @param {HTMLDocument|string} base Document whose base URL to use, or base URL as a string
 * @returns {string} Resolved URL
 */
ve.resolveUrl = function ( url, base ) {
	var doc, node;
	if ( typeof base === 'string' ) {
		doc = ve.createDocumentFromHtml( '' );
		node = doc.createElement( 'base' );
		node.setAttribute( 'href', base );
		doc.head.appendChild( node );
	} else {
		doc = base;
	}

	node = doc.createElement( 'a' );
	node.setAttribute( 'href', url );
	// If doc.baseURI isn't set, node.href will be an empty string
	// This is crazy, returning the original URL is better
	return node.href || url;
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
 * @returns {string} Inner HTML
 */
ve.properInnerHtml = function ( element ) {
	return ve.fixupPreBug( element ).innerHTML;
};

/**
 * Get the actual outer HTML of a DOM node.
 *
 * @see ve#properInnerHtml
 * @param {HTMLElement} element HTML element to get outer HTML of
 * @returns {string} Outer HTML
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
 * @returns {HTMLElement} Either element, or a fixed-up clone of it
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
	// semantic one, and handling that is Parsoid's job.
	$element = $( element ).clone();
	$element.find( 'pre, textarea, listing' ).each( function () {
		var matches;
		if ( this.firstChild && this.firstChild.nodeType === Node.TEXT_NODE ) {
			matches = this.firstChild.data.match( /^(\r\n|\r|\n)/ );
			if ( matches && matches[1] ) {
				// Prepend a newline exactly like the one we saw
				this.firstChild.insertData( 0, matches[1] );
			}
		}
	} );
	return $element.get( 0 );
};

/**
 * Helper function for #transformStyleAttributes.
 *
 * Normalize an attribute value. In compliant browsers, this should be
 * a no-op, but in IE style attributes are normalized on all elements and
 * bgcolor attributes are normalized on some elements (like `<tr>`).
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
 * @returns {string} HTML string modified to mask/unmask broken attributes
 */
ve.transformStyleAttributes = function ( html, unmask ) {
	var xmlDoc, fromAttr, toAttr, i, len,
		maskAttrs = [
			'style', // IE normalizes 'color:#ffd' to 'color: rgb(255, 255, 221);'
			'bgcolor' // IE normalizes '#FFDEAD' to '#ffdead'
		];

	// Parse the HTML into an XML DOM
	xmlDoc = new DOMParser().parseFromString( html, 'text/xml' );

	// Go through and mask/unmask each attribute on all elements that have it
	for ( i = 0, len = maskAttrs.length; i < len; i++ ) {
		fromAttr = unmask ? 'data-ve-' + maskAttrs[i] : maskAttrs[i];
		toAttr = unmask ? maskAttrs[i] : 'data-ve-' + maskAttrs[i];
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
 * @param {Array} rects Full list of rectangles
 * @return {Object|null} Object containing two rectangles: start and end, or null if there are no rectangles
 */
ve.getStartAndEndRects = function ( rects ) {
	var i, l, startRect, endRect;
	if ( !rects || !rects.length ) {
		return null;
	}
	for ( i = 0, l = rects.length; i < l; i++ ) {
		if ( !startRect || rects[i].top < startRect.top ) {
			// Use ve.extendObject as ve.copy copies non-plain objects by reference
			startRect = ve.extendObject( {}, rects[i] );
		} else if ( rects[i].top === startRect.top ) {
			// Merge rects with the same top coordinate
			startRect.left = Math.min( startRect.left, rects[i].left );
			startRect.right = Math.max( startRect.right, rects[i].right );
			startRect.width = startRect.right - startRect.left;
		}
		if ( !endRect || rects[i].bottom > endRect.bottom ) {
			// Use ve.extendObject as ve.copy copies non-plain objects by reference
			endRect = ve.extendObject( {}, rects[i] );
		} else if ( rects[i].bottom === endRect.bottom ) {
			// Merge rects with the same bottom coordinate
			endRect.left = Math.min( endRect.left, rects[i].left );
			endRect.right = Math.max( endRect.right, rects[i].right );
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
 * @param {Node...} DOM nodes in the same document
 * @returns {Node|null} Nearest common ancestor node
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
 * Compare two offset paths for position in document
 *
 * @param {number[]} path1 First offset path
 * @param {number[]} path2 Second offset path
 * @return {number} negative, zero or positive number
 */
ve.compareOffsetPaths = function ( path1, path2 ) {
	var i, len;
	for ( i = 0, len = Math.min( path1.length, path2.length ); i < len; i++ ) {
		if ( path1[ i ] !== path2[ i ] ) {
			return path1[ i ] - path2[ i ];
		}
	}
	return path1.length - path2.length;
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
	return ve.compareOffsetPaths(
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
 * @returns {string} Client platform string
 */
ve.getSystemPlatform = function () {
	return ( ve.init.platform && ve.init.platform.constructor || ve.init.Platform ).static.getSystemPlatform();
};
