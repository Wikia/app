/**
 * VisualEditor content editable namespace.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Namespace for all VisualEditor content editable classes, static methods and static properties.
 */
ve.ce = {
	//'nodeFactory': Initialized in ve.ce.NodeFactory.js
};

/* Static Members */

/**
 * RegExp pattern for matching all whitespaces in HTML text.
 *
 * \u0020 (32) space
 * \u00A0 (160) non-breaking space
 *
 * @static
 * @member
 */
ve.ce.whitespacePattern = /[\u0020\u00A0]/g;

/* Static Methods */

/**
 * Gets the plain text of a DOM element (that is a node canContainContent === true)
 *
 * In the returned string only the contents of text nodes are included, and the contents of
 * non-editable elements are excluded (but replaced with the appropriate number of characters
 * so the offsets match up with the linear model).
 *
 * @static
 * @member
 * @param {DOMElement} element DOM element to get text of
 * @returns {String} Plain text of DOM element
 */
ve.ce.getDomText = function ( element ) {
	var func = function ( element ) {
		var nodeType = element.nodeType,
			text = '',
			numChars,
			$element = $( element );

		if ( nodeType === 1 || nodeType === 9 || nodeType === 11 ) {
			if ( $element.hasClass( 've-ce-slug' ) ) {
				// Slugs are not represented in the model at all, but they do
				// contain a single nbsp/FEFF character in the DOM, so make sure
				// that character isn't counted
				return '';
			} else if ( $element.hasClass( 've-ce-leafNode' ) ) {
				// For leaf nodes, don't return the content, but return
				// the right amount of characters so the offsets match up
				numChars = $element.data( 'node' ).getOuterLength();
				return new Array( numChars + 1 ).join( '\u2603' );
			} else {
				// Traverse its children
				for ( element = element.firstChild; element; element = element.nextSibling ) {
					text += func( element );
				}
			}
		} else if ( nodeType === 3 || nodeType === 4 ) {
			return element.nodeValue;
		}
		return text;
	};
	// Return the text, replacing spaces and non-breaking spaces with spaces?
	// TODO: Why are we replacing spaces (\u0020) with spaces (' ')
	return func( element ).replace( ve.ce.whitespacePattern, ' ' );
};

/**
 * Gets a hash of a DOM element's structure.
 *
 * In the returned string text nodes are represented as "#" and elements are represented as "<type>"
 * and "</type>" where "type" is their element name. This effectively generates an HTML
 * serialization without any attributes or text contents. This can be used to observe structural
 * changes.
 *
 * @static
 * @member
 * @param {DOMElement} element DOM element to get hash of
 * @returns {String} Hash of DOM element
 */
ve.ce.getDomHash = function ( element ) {
	var nodeType = element.nodeType,
		nodeName = element.nodeName,
		hash = '';

	if ( nodeType === 3 || nodeType === 4 ) {
		return '#';
	} else if ( nodeType === 1 || nodeType === 9 ) {
		hash += '<' + nodeName + '>';
		// Traverse its children
		for ( element = element.firstChild; element; element = element.nextSibling) {
			hash += ve.ce.getDomHash( element );
		}
		hash += '</' + nodeName + '>';
	}
	return hash;
};

/**
 * Gets the linear offset from a given DOM node and offset within it.
 *
 * @static
 * @member
 * @param {DOM Node} domNode DOM node
 * @param {Integer} domOffset DOM offset within the DOM node
 * @returns {Number} Linear model offset
 */
ve.ce.getOffset = function ( domNode, domOffset ) {
	if ( domNode.nodeType === Node.TEXT_NODE ) {
		return ve.ce.getOffsetFromTextNode( domNode, domOffset );
	} else {
		return ve.ce.getOffsetFromElementNode( domNode, domOffset );
	}
};

/**
 * Gets the linear offset from a given text node and offset within it.
 *
 * @method
 * @param {DOMElement} domNode DOM node
 * @param {Number} domOffset DOM offset within the DOM Element
 * @returns {Number} Linear model offset
 */
ve.ce.getOffsetFromTextNode = function ( domNode, domOffset ) {
	var $node, nodeModel, current, stack, item, offset, $item;

	$node = $( domNode ).closest(
		'.ve-ce-branchNode, .ve-ce-alienBlockNode, .ve-ce-alienInlineNode'
	);
	nodeModel = $node.data( 'node' ).getModel();

	if ( ! $node.hasClass( 've-ce-branchNode' ) ) {
		return nodeModel.getOffset();
	}

	current = [$node.contents(), 0];
	stack = [current];
	offset = 0;

	while ( stack.length > 0 ) {
		if ( current[1] >= current[0].length ) {
			stack.pop();
			current = stack[ stack.length - 1 ];
			continue;
		}
		item = current[0][current[1]];
		if ( item.nodeType === Node.TEXT_NODE ) {
			if ( item === domNode ) {
				offset += domOffset;
				break;
			} else {
				offset += item.textContent.length;
			}
		} else if ( item.nodeType === Node.ELEMENT_NODE ) {
			$item = current[0].eq( current[1] );
			if ( $item.hasClass( 've-ce-slug' ) ) {
				if ( $item.contents()[0] === domNode ) {
					break;
				}
			} else if ( $item.hasClass( 've-ce-leafNode' ) ) {
				offset += 2;
			} else if ( $item.hasClass( 've-ce-branchNode' ) ) {
				offset += $item.data( 'node' ).getOuterLength();
			} else {
				stack.push( [$item.contents(), 0 ] );
				current[1]++;
				current = stack[stack.length-1];
				continue;
			}
		}
		current[1]++;
	}
	return offset + nodeModel.getOffset() + ( nodeModel.isWrapped() ? 1 : 0 );
};

/**
 * Gets the linear offset from a given element node and offset within it.
 *
 * @method
 * @param {DOMElement} domNode DOM node
 * @param {Number} domOffset DOM offset within the DOM Element
 * @param {Boolean} [addOuterLength] Use outer length, which includes wrappers if any exist
 * @returns {Number} Linear model offset
 */
ve.ce.getOffsetFromElementNode = function ( domNode, domOffset, addOuterLength ) {
	var $domNode = $( domNode ),
		nodeModel,
		node;

	if ( $domNode.hasClass( 've-ce-slug' ) ) {
		if ( $domNode.prev().length ) {
			nodeModel = $domNode.prev().data( 'node' ).getModel();
			return nodeModel.getOffset() + nodeModel.getOuterLength();
		}
		if ( $domNode.next().length ) {
			nodeModel = $domNode.next().data( 'node' ).getModel();
			return nodeModel.getOffset();
		}
	}

	if ( domOffset === 0 ) {
		node = $domNode.data( 'node' );
		if ( node ) {
			nodeModel = $domNode.data( 'node' ).getModel();
			if ( addOuterLength === true ) {
				return nodeModel.getOffset() + nodeModel.getOuterLength();
			} else {
				return nodeModel.getOffset();
			}
		} else {
			node = $domNode.contents().last()[0];
		}
	} else {
		node = $domNode.contents()[ domOffset - 1 ];
	}

	if ( node.nodeType === Node.TEXT_NODE ) {
		return ve.ce.getOffsetFromTextNode( node, node.length );
	} else {
		return ve.ce.getOffsetFromElementNode( node, 0, true );
	}
};

/**
 * Gets the linear offset of a given slug
 *
 * @static
 * @member
 * @param {jQuery} $node jQuery slug selection
 * @returns {Integer} Linear model offset
 * @throws Error
 */
ve.ce.getOffsetOfSlug  = function ( $node ) {
	var model;
	if ( $node.index() === 0 ) {
		model = $node.parent().data( 'node' ).getModel();
		return model.getOffset() + ( model.isWrapped() ? 1 : 0 );
	} else if ( $node.prev().length ) {
		model = $node.prev().data( 'node' ).getModel();
		return model.getOffset() + model.getOuterLength();
	} else {
		throw new Error( 'Incorrect slug location' );
	}
};
