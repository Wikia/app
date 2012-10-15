/**
 * Conversions between HTML DOM and WikiDom
 *
 * @author Gabriel Wicke <gwicke@wikimedia.org>
 * 
 * @class
 * @constructor
 */
function DOMConverter () {
}

/**
 * Convert HTML DOM to WikiDom
 *
 * @method
 * @param {Object} root of HTML DOM (usually the body element)
 * @returns {Object} WikiDom representation
 */
DOMConverter.prototype.HTMLtoWiki = function ( node ) {
	return this._convertHTMLBranch( node, 'document' ).node;
};


/* Private stuff */

/**
 * Map an HTML node name to (handler, wikiDomName [, attribs]). Only
 * non-annotation html elements are handled here. The conversion should thus
 * use this._getWikiDomAnnotationType first to check if the element is actually
 * an annotation.
 *
 * @static
 * @method
 * @param {String} nodeName, the element's nodeName.
 * @returns {Object} with keys 'handler' (one of the _convertHTMLLeaf and
 * _convertHTMLBranch functions), 'type' (the name of this element in WikiDom)
 * and optionally 'attribs', WikiDom-specific attributes implied by the element name.
 */
DOMConverter.prototype._getHTMLtoWikiDomHandlerInfo = function ( nodeName ) {
	var wikiName = '';
	switch ( nodeName.toLowerCase() ) {
		// leaf nodes first, with fall-through to last leaf..
		case 'p':
			return {
				handler: this._convertHTMLLeaf, 
				type: 'paragraph'
			};
		case 'h1':
		case 'h2':
		case 'h3':
		case 'h4':
		case 'h5':
		case 'h6':
			return {
				handler: this._convertHTMLLeaf, 
				type: 'heading',
				attribs: { level: nodeName.substr(1) }
			};
		case 'li':
		case 'dt':
		case 'dd':
			return {
				handler: this._convertHTMLBranch, 
				type: 'listItem'
			};
		case 'pre':
			return {
				handler: this._convertHTMLLeaf, 
				type: 'pre'
			};
		case 'table':
			return {
				handler: this._convertHTMLBranch, 
				type: 'table'
			};
		case 'tbody':
			return {
				handler: this._convertHTMLBranch, 
				type: 'tbody' // not in WikiDom!
			};
		case 'tr':
			return {
				handler: this._convertHTMLBranch, 
				type: 'tableRow'
			};
		case 'th':
			return {
				handler: this._convertHTMLBranch, 
				type: 'tableHeading'
			};
		case 'td':
			return {
				handler: this._convertHTMLBranch, 
				type: 'tableCell'
			};
		case 'caption':
			return {
				handler: this._convertHTMLBranch, 
				type: 'caption'
			};
		case 'hr':
			return {
				handler: this._convertHTMLLeaf, 
				type: 'horizontalRule' // XXX?
			};
		case 'ul':
		case 'ol':
		case 'dl':
			return {
				handler: this._convertHTMLBranch, 
				type: 'list'
			};
		case 'center':
			//XXX: center is block-level in HTML, not sure what it should be
			//in WikiDOM..
			return {
				handler: this._convertHTMLBranch, 
				type: 'center'
			};
		case 'blockquote':
			//XXX: blockquote is block-level in HTML, not sure what it should be
			//in WikiDOM..
			return {
				handler: this._convertHTMLBranch, 
				type: 'blockquote'
			};
		default:
			console.log( 'HTML to Wiki DOM conversion warning: Unknown node name ' +
					nodeName );
			return {
				handler: this._convertHTMLBranch, 
				type: nodeName.toLowerCase()
			};
	}
};

/**
 * Map HTML element names to WikiDom annotation types or undefined.
 *
 * @param {String} nodeName, the HTML element name
 * @param {Boolean} warn (optional), enable warnings for non-annotation
 * element types
 * @returns {String} WikiDom annotation type or undefined if element name does
 * not map to an annotation.
 */
DOMConverter.prototype._getWikiDomAnnotationType = function ( node, warn ) {
	var name = node.nodeName.toLowerCase();
	switch ( name ) {
		case 'i':
			return 'textStyle/italic';
		case 'b':
			return 'textStyle/bold';
		case 'span':
			return 'textStyle/span';
		case 'a':
			var atype = node.getAttribute( 'data-type' );
			if ( atype ) {
				return 'link/' + atype;
			} else {
				return 'link/unknown';
			}
			break; // make JSHint happy
		case 'template':
			return 'object/template';
		case 'ref':
			return 'object/hook';
		case 'includeonly':
			return 'object/includeonly'; // XXX
		default:
			if ( warn ) {
				console.log( 'HTML to Wiki DOM conversion warning: Unsupported html annotation ' + name );
			}
			return undefined;
	}
};


/**
 * Private HTML branch node handler
 *
 * @param {Object} HTML DOM element
 * @param {Int} WikiDom offset within a block
 * @returns {Object} WikiDom object
 */
DOMConverter.prototype._convertHTMLBranch = function ( node, type ) {

	var children = node.childNodes,
		wnode = {
			type: type,
			attributes: this._HTMLPropertiesToWikiAttributes( node ),
			children: [] 
		},
		parNode = null,
		offset = 0,
		res;

	function newPara () {
		offset = 0;
		parNode = { 
			type: 'paragraph', 
			content: {
				text: '',
				annotations: []
			}
		};
		wnode.children.push( parNode );
	}

	for ( var i = 0, l = children.length; i < l; i++ ) {
		var cnode = children[i];
		switch ( cnode.nodeType ) {
			case Node.ELEMENT_NODE:
				// Check if element type is an annotation
				var annotationtype = this._getWikiDomAnnotationType( cnode );
				if ( annotationtype ) {
					if ( !parNode ) {
						newPara();
					}
					res = this._convertHTMLAnnotation( cnode, offset, annotationtype );
					//console.log( 'res leaf: ' + JSON.stringify(res, null, 2));
					offset += res.text.length;
					parNode.content.text += res.text;
					//console.log( 'res annotations: ' + JSON.stringify(res, null, 2));
					parNode.content.annotations = parNode.content.annotations
														.concat( res.annotations );
				} else {
					// Close last paragraph, if still open.
					parNode = null;
					// Call a handler for the particular node type
					var hi = this._getHTMLtoWikiDomHandlerInfo( cnode.nodeName );
					res = hi.handler.call(this, cnode, hi.type );
					if ( hi.attribs ) {
						$.extend( res.node.attributes, hi.attribs );
					}
					wnode.children.push( res.node );
					offset = res.offset;
				}
				break;
			case Node.TEXT_NODE:
				if ( !parNode ) {
					newPara();
				}
				parNode.content.text += cnode.data;
				offset += cnode.data.length;
				break;
			case Node.COMMENT_NODE:
				// add a comment node.
				break;
			default:
				console.log( "HTML to Wiki DOM conversion error. Unhandled node " + 
						cnode.innerHTML );
				break;
		}
	}
	return {
		offset: offset,
		node: wnode
	};
};

/**
 * Private HTML leaf node handler
 *
 * @param {Object} HTML DOM element
 * @param {Int} WikiDom offset within a block
 * @returns {Object} WikiDom object
 */
DOMConverter.prototype._convertHTMLLeaf = function ( node, type ) {
	var offset = 0;

	var children = node.childNodes,
		wnode = {
			type: type,
			attributes: this._HTMLPropertiesToWikiAttributes( node ),
			content: { 
				text: '',
				annotations: []
			}
		};
	//console.log( 'res wnode: ' + JSON.stringify(wnode, null, 2));
	for ( var i = 0, l = children.length; i < l; i++ ) {
		var cnode = children[i];
		switch ( cnode.nodeType ) {
			case Node.ELEMENT_NODE:
				// Call a handler for the particular annotation node type
				var annotationtype = this._getWikiDomAnnotationType( cnode, true );
				if ( annotationtype ) {
					var res = this._convertHTMLAnnotation( cnode, offset, annotationtype );
					//console.log( 'res leaf: ' + JSON.stringify(res, null, 2));
					offset += res.text.length;
					wnode.content.text += res.text;
					//console.log( 'res annotations: ' + JSON.stringify(res, null, 2));
					wnode.content.annotations = wnode.content.annotations
														.concat( res.annotations );
				}
				break;
			case Node.TEXT_NODE:
				// Add text as content, and increment offset
				wnode.content.text += cnode.data;
				offset += cnode.data.length;
				break;
			case Node.COMMENT_NODE:
				// add a comment annotation?
				break;
			default:
				console.log( "HTML to Wiki DOM conversion error. Unhandled node " + 
						cnode.innerHTML );
				break;
		}
	}
	return {
		offset: offset,
		node: wnode
	};
};

/**
 * Private: Convert an HTML element to an annotation
 *
 * @param {Object} HTML element node
 * @offset {Int} plain-text offset within leaf node
 * @type {String} type of annotation returned by _getWikiDomAnnotationType
 * @return {Object} {text: extracted plain text, annotations: {Array} of
 * annotation nodes}
 */
DOMConverter.prototype._convertHTMLAnnotation = function ( node, offset, type ) {
	var children = node.childNodes,
		text = '',
		annotations = [
				{
					type: type,
					data: this._HTMLPropertiesToWikiData( node ),
					range: {
						start: offset,
						end: offset
					}
				}
		];
	for ( var i = 0, l = children.length; i < l; i++ ) {
		var cnode = children[i];
		switch ( cnode.nodeType ) {
			case Node.ELEMENT_NODE:
				// Call a handler for the particular annotation node type
				var annotationtype = this._getWikiDomAnnotationType(cnode, true);
				if ( annotationtype ) {
					var res = this._convertHTMLAnnotation( cnode, offset, annotationtype );
					//console.log( 'res annotations 2: ' + JSON.stringify(res, null, 2));
					text += res.text;
					offset += res.text.length;
					annotations = annotations.concat( res.annotations );
				}
				break;
			case Node.TEXT_NODE:
				// Add text as content, and increment offset
				text += cnode.data;
				offset += cnode.data.length;
				break;
			case Node.COMMENT_NODE:
				// add a comment annotation?
				break;
			default:
				console.log( "HTML to Wiki DOM conversion error. Unhandled node " + 
						cnode.innerHTML );
				break;
		}
	}
	// Insert one char if no text was returned to satisfy WikiDom's
	// 1-char-minimum width for annotations. Feels a bit icky, but likely
	// simplifies editor internals.
	if ( text === '' ) {
		text = ' ';
		offset++;
	}
	annotations[0].range.end = offset;
	return	{
		text: text,
		annotations: annotations
	};
};

DOMConverter.prototype._HTMLPropertiesToWikiAttributes = function ( elem ) {
	var attribs = elem.attributes,
		out = {};
	for ( var i = 0, l = attribs.length; i < l; i++ ) {
		var attrib = attribs.item(i),
			key = attrib.name;
		if ( key.match( /^data-json-/ ) ) {
			// strip data- prefix and decode
			out[key.replace( /^data-json-/, '' )] = JSON.parse(attrib.value);
		} else if ( key.match( /^data-/ ) ) {
			// strip data- prefix
			out[key.replace( /^data-/, '' )] = attrib.value;
		} else {
			// prefix html properties with html/
			out['html/' + key] = attrib.value;
		}
	}
	return out;
};

/**
 * Convert HTML element attributes into WikiDom annotation data attributes.
 *
 * @param {Object} DOM node
 * @return {Object} data object
 */
DOMConverter.prototype._HTMLPropertiesToWikiData = function ( elem ) {
	var attribs = elem.attributes,
		name = elem.tagName.toLowerCase();
		out = {};
	for ( var i = 0, l = attribs.length; i < l; i++ ) {
		var attrib = attribs.item(i),
			key = attrib.name;
		
		if ( this._HTMLPropertiesToWikiAttributesMap[name] &&
				this._HTMLPropertiesToWikiAttributesMap[name][key] ) {
			out[this._HTMLPropertiesToWikiAttributesMap[name][key]] = attrib.value;
		} else if ( key.match( /^data-json-/ ) ) {
			// strip data-json- prefix and decode
			out[key.replace( /^data-json-/, '' )] = JSON.parse(attrib.value);
		} else if ( key.match( /^data-/ ) ) {
			// strip data- prefix
			out[key.replace( /^data-/, '' )] = attrib.value;
		} else {
			// pass through a few whitelisted keys
			// XXX: This subsets html DOM
			if ( ['title'].indexOf(key) != -1 ) {
				out[key] = attrib.value;
			} else {
				// prefix key with 'html/'
				out['html/' + key] = attrib.value;
			}
		}
	}
	return out;
};

// Map HTML (tagName, attributeName) pairs to WikiDom names for the same
// element
DOMConverter.prototype._HTMLPropertiesToWikiAttributesMap = {
	a: { 
		href: 'title'
	}
};


// Quick HACK: define Node constants locally
// https://developer.mozilla.org/en/nodeType
var Node = {
	ELEMENT_NODE: 1,
    ATTRIBUTE_NODE: 2,
    TEXT_NODE: 3,
    CDATA_SECTION_NODE: 4,
    ENTITY_REFERENCE_NODE: 5,
    ENTITY_NODE: 6,
    PROCESSING_INSTRUCTION_NODE: 7,
    COMMENT_NODE: 8,
    DOCUMENT_NODE: 9,
    DOCUMENT_TYPE_NODE: 10,
    DOCUMENT_FRAGMENT_NODE: 11,
    NOTATION_NODE: 12
};


if (typeof module == "object") {
	module.exports.DOMConverter = DOMConverter;
}
