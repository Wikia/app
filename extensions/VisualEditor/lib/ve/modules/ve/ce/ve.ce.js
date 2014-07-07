/*!
 * VisualEditor ContentEditable namespace.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Namespace for all VisualEditor ContentEditable classes, static methods and static properties.
 * @class
 * @singleton
 */
ve.ce = {
	//'nodeFactory': Initialized in ve.ce.NodeFactory.js
};

/* Static Properties */

/**
 * RegExp pattern for matching all whitespaces in HTML text.
 *
 * \u0020 (32) space
 * \u00A0 (160) non-breaking space
 *
 * @property
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
 * @method
 * @param {HTMLElement} element DOM element to get text of
 * @returns {string} Plain text of DOM element
 */
ve.ce.getDomText = function ( element ) {
	// Inspired by jQuery.text / Sizzle.getText
	var func = function ( element ) {
		var nodeType = element.nodeType,
			text = '',
			numChars,
			$element = $( element );

		// Node.ELEMENT_NODE = 1
		// Node.DOCUMENT_NODE = 9
		// Node.DOCUMENT_FRAGMENT_NODE = 11
		if ( nodeType === 1 || nodeType === 9 || nodeType === 11 ) {
			if ( $element.hasClass( 've-ce-branchNode-slug' ) ) {
				// Slugs are not represented in the model at all, but they do
				// contain a single nbsp/FEFF character in the DOM, so make sure
				// that character isn't counted
				return '';
			} else if ( $element.hasClass( 've-ce-leafNode' ) ) {
				// For leaf nodes, don't return the content, but return
				// the right amount of characters so the offsets match up
				numChars = $element.data( 'view' ).getOuterLength();
				return new Array( numChars + 1 ).join( '\u2603' );
			} else {
				// Traverse its children
				for ( element = element.firstChild; element; element = element.nextSibling ) {
					text += func( element );
				}
			}
		// Node.TEXT_NODE = 3
		// Node.CDATA_SECTION_NODE = 4 (historical, unused in HTML5)
		} else if ( nodeType === 3 || nodeType === 4 ) {
			return element.data;
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
 * @method
 * @param {HTMLElement} element DOM element to get hash of
 * @returns {string} Hash of DOM element
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
		for ( element = element.firstChild; element; element = element.nextSibling ) {
			hash += ve.ce.getDomHash( element );
		}
		hash += '</' + nodeName + '>';
		// Merge adjacent text node representations
		hash = hash.replace( /##+/g, '#' );
	}
	return hash;
};

/**
 * Gets the linear offset from a given DOM node and offset within it.
 *
 * @method
 * @param {HTMLElement} domNode DOM node
 * @param {number} domOffset DOM offset within the DOM node
 * @returns {number} Linear model offset
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
 * @param {HTMLElement} domNode DOM node
 * @param {number} domOffset DOM offset within the DOM Element
 * @returns {number} Linear model offset
 */
ve.ce.getOffsetFromTextNode = function ( domNode, domOffset ) {
	var $node, nodeModel, current, stack, item, offset, $item;

	$node = $( domNode ).closest(
		'.ve-ce-branchNode, .ve-ce-leafNode'
	);
	nodeModel = $node.data( 'view' ).getModel();

	// IE sometimes puts the cursor in a text node inside ce="false". BAD!
	if ( $node[0].contentEditable === 'false' ) {
		return nodeModel.getOffset() + nodeModel.getOuterLength();
	}

	if ( !$node.hasClass( 've-ce-branchNode' ) ) {
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
			if ( $item.hasClass( 've-ce-branchNode-slug' ) ) {
				if ( $item.contents()[0] === domNode ) {
					break;
				}
			} else if ( $item.hasClass( 've-ce-leafNode' ) ) {
				offset += 2;
			} else if ( $item.hasClass( 've-ce-branchNode' ) ) {
				offset += $item.data( 'view' ).getOuterLength();
			} else {
				stack.push( [ $item.contents(), 0 ] );
				current[1]++;
				current = stack[ stack.length - 1 ];
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
 * @param {HTMLElement} domNode DOM node
 * @param {number} domOffset DOM offset within the DOM Element
 * @param {number} [direction] Which direction we are searching in (+/-1), not changed by recursive calls
 * @returns {number} Linear model offset
 */
ve.ce.getOffsetFromElementNode = function ( domNode, domOffset, direction ) {
	var nodeModel, node,
		$domNode = $( domNode );

	if ( $domNode.hasClass( 've-ce-branchNode-slug' ) ) {
		if ( $domNode.prev().length ) {
			nodeModel = $domNode.prev().data( 'view' ).getModel();
			return nodeModel.getOffset() + nodeModel.getOuterLength();
		}
		if ( $domNode.next().length ) {
			nodeModel = $domNode.next().data( 'view' ).getModel();
			return nodeModel.getOffset();
		}
	}

	// IE sometimes puts the cursor in a text node inside ce="false". BAD!
	if ( !direction && !domNode.isContentEditable ) {
		nodeModel = $domNode.closest( '.ve-ce-branchNode, .ve-ce-leafNode' ).data( 'view' ).getModel();
		return nodeModel.getOffset() + nodeModel.getOuterLength();
	}

	if ( domOffset === 0 || domOffset === domNode.childNodes.length ) {
		node = $domNode.data( 'view' );
		if ( node && node instanceof ve.ce.Node ) {
			nodeModel = $domNode.data( 'view' ).getModel();
			if ( direction === -1 ) {
				return nodeModel.getOffset() + nodeModel.getOuterLength();
			} else if ( direction === 1 ) {
				return nodeModel.getOffset();
			} else {
				if ( domOffset === 0 ) {
					return nodeModel.getOffset() + ( nodeModel.isWrapped() ? 1 : 0 );
				} else {
					return nodeModel.getOffset() + nodeModel.getOuterLength() - ( nodeModel.isWrapped() ? 1 : 0 );
				}
			}
		} else {
			if ( domOffset === 0 ) {
				node = $domNode.contents().first()[0];
				direction = direction || 1;
			} else {
				node = $domNode.contents().last()[0];
				direction = direction || -1;
			}
		}
	} else {
		node = $domNode.contents()[ domOffset - 1 ];
		direction = direction || -1;
	}

	if ( node.nodeType === Node.TEXT_NODE ) {
		return ve.ce.getOffsetFromTextNode( node, direction > 0 ? 0 : node.length );
	} else {
		return ve.ce.getOffsetFromElementNode( node, direction > 0 ? 0 : node.childNodes.length, direction );
	}
};

/**
 * Gets the linear offset of a given slug
 *
 * @method
 * @param {jQuery} $node jQuery slug selection
 * @returns {number} Linear model offset
 * @throws {Error}
 */
ve.ce.getOffsetOfSlug = function ( $node ) {
	var model;
	if ( $node.index() === 0 ) {
		model = $node.parent().data( 'view' ).getModel();
		return model.getOffset() + ( model.isWrapped() ? 1 : 0 );
	} else if ( $node.prev().length ) {
		model = $node.prev().data( 'view' ).getModel();
		return model.getOffset() + model.getOuterLength();
	} else {
		throw new Error( 'Incorrect slug location' );
	}
};

/**
 * Check if the key code represents a left or right arrow key
 * @param {number} keyCode Key code
 * @returns {boolean} Key code represents a left or right arrow key
 */
ve.ce.isLeftOrRightArrowKey = function ( keyCode ) {
	return keyCode === OO.ui.Keys.LEFT || keyCode === OO.ui.Keys.RIGHT;
};

/**
 * Check if the key code represents an up or down arrow key
 * @param {number} keyCode Key code
 * @returns {boolean} Key code represents an up or down arrow key
 */
ve.ce.isUpOrDownArrowKey = function ( keyCode ) {
	return keyCode === OO.ui.Keys.UP || keyCode === OO.ui.Keys.DOWN;
};

/**
 * Check if the key code represents an arrow key
 * @param {number} keyCode Key code
 * @returns {boolean} Key code represents an arrow key
 */
ve.ce.isArrowKey = function ( keyCode ) {
	return ve.ce.isLeftOrRightArrowKey( keyCode ) || ve.ce.isUpOrDownArrowKey( keyCode );
};

/**
 * Check if keyboard shortcut modifier key is pressed.
 *
 * @method
 * @param {jQuery.Event} e Key press event
 * @returns {boolean} Modifier key is pressed
 */
ve.ce.isShortcutKey = function ( e ) {
	return !!( e.ctrlKey || e.metaKey );
};
