/*!
 * VisualEditor ContentEditable namespace.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Namespace for all VisualEditor ContentEditable classes, static methods and static properties.
 * @class
 * @singleton
 */
ve.ce = {
	//nodeFactory: Initialized in ve.ce.NodeFactory.js
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

/**
 * Data URI for minimal GIF image.
 */
ve.ce.minImgDataUri = 'data:image/gif;base64,R0lGODdhAQABAADcACwAAAAAAQABAAA';
ve.ce.unicornImgDataUri = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAATCAQAAADly58hAAAAAmJLR0QAAKqNIzIAAAAJcEhZcwAACxMAAAsTAQCanBgAAAAHdElNRQfeChIMMi319aEqAAAAzUlEQVQoz4XSMUoDURAG4K8NIljaeQZrCwsRb5FWL5Daa1iIjQewTycphAQloBEUAoogFmqMsiBmHSzcdfOWlcyU3/+YGXgsqJZMbvv/wLqZDCw1B9rCBSaOmgOHQsfQvVYT7wszIbPSxO9CCF8ebNXx1J2TIvDoxlrKU3mBIYz1U87mMISB3QqXk7e/A4bp1WV/CiE3sFHymZ4X4cO57yLWdVDyjoknr47/MPRcput1k+ljt/O4V1vu2bXViq9qPNW3WfGoxrk37UVfxQ999n1bP+Vh5gAAAABJRU5ErkJggg==';
ve.ce.chimeraImgDataUri = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABMAAAATCAYAAAByUDbMAAAABGdBTUEAALGPC/xhBQAAAThJREFUOMvF088rRFEYxvGpKdnwJ8iStVnMytZ2ipJmI6xmZKEUe5aUULMzCxtlSkzNjCh2lClFSUpDmYj8KBZq6vreetLbrXs5Rjn1aWbuuee575z7nljsH8YkepoNaccsHrGFgWbCWpHCLZb+oroFzKOEbpeFHVp8gitsYltzSRyiqrkKhsKCevGMfWQwor/2ghns4BQTGMMcnlBA3Aa14U5VLeMDnqrq1/cDpHGv35eqrI5pG+Y/qYYp3WiN6zOHs8DcA7IK/BqLWMOuY5inQjwbNqheGnYMO9d+XtiwFu1BQU/y96ooKRO2Yq6vqog3jAbfZgKvuDELfGWFXQeu76GB9bD26MQRNnSMotTVJvGoxs2rx2oR/B47Rtd3pyBv3lCYnEtYWo0Yps8l7F3HKErjJ2G/Hp/F9YtlR3MQiAAAAABJRU5ErkJggg==';

/* Static Methods */

/**
 * Gets the plain text of a DOM element (that is a node canContainContent === true)
 *
 * In the returned string only the contents of text nodes are included, and the contents of
 * non-editable elements are excluded (but replaced with the appropriate number of snowman
 * characters so the offsets match up with the linear model).
 *
 * @method
 * @param {HTMLElement} element DOM element to get text of
 * @returns {string} Plain text of DOM element
 */
ve.ce.getDomText = function ( element ) {
	// Inspired by jQuery.text / Sizzle.getText
	var func = function ( element ) {
		var viewNode,
			nodeType = element.nodeType,
			$element = $( element ),
			text = '';

		if (
			nodeType === Node.ELEMENT_NODE ||
			nodeType === Node.DOCUMENT_NODE ||
			nodeType === Node.DOCUMENT_FRAGMENT_NODE
		) {
			if ( $element.hasClass( 've-ce-branchNode-blockSlug' ) ) {
				// Block slugs are not represented in the model at all, but they do
				// contain a single nbsp/FEFF character in the DOM, so make sure
				// that character isn't counted
				return '';
			} else if ( $element.hasClass( 've-ce-leafNode' ) ) {
				// For leaf nodes, don't return the content, but return
				// the right number of placeholder characters so the offsets match up.
				viewNode = $element.data( 'view' );
				// Only return snowmen for the first element in a sibling group: otherwise
				// we'll double-count this node
				if ( viewNode && element === viewNode.$element[0] ) {
					// \u2603 is the snowman character: ☃
					return new Array( viewNode.getOuterLength() + 1 ).join( '\u2603' );
				}
				// Second or subsequent sibling, don't double-count
				return '';
			} else {
				// Traverse its children
				for ( element = element.firstChild; element; element = element.nextSibling ) {
					text += func( element );
				}
			}
		} else if ( nodeType === Node.TEXT_NODE ) {
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
 * Get the first cursor offset immediately after a node.
 *
 * @param {Node} node DOM node
 * @returns {Object}
 * @returns {Node} return.node
 * @returns {number} return.offset
 */
ve.ce.nextCursorOffset = function ( node ) {
	var nextNode, offset;
	if ( node.nextSibling !== null && node.nextSibling.nodeType === Node.TEXT_NODE ) {
		nextNode = node.nextSibling;
		offset = 0;
	} else {
		nextNode = node.parentNode;
		offset = 1 + Array.prototype.indexOf.call( node.parentNode.childNodes, node );
	}
	return { node: nextNode, offset: offset };
};

/**
 * Get the first cursor offset immediately before a node.
 *
 * @param {Node} node DOM node
 * @returns {Object}
 * @returns {Node} return.node
 * @returns {number} return.offset
 */
ve.ce.previousCursorOffset = function ( node ) {
	var previousNode, offset;
	if ( node.previousSibling !== null && node.previousSibling.nodeType === Node.TEXT_NODE ) {
		previousNode = node.previousSibling;
		offset = previousNode.data.length;
	} else {
		previousNode = node.parentNode;
		offset = Array.prototype.indexOf.call( node.parentNode.childNodes, node );
	}
	return { node: previousNode, offset: offset };
};

/**
 * Gets the linear offset from a given DOM node and offset within it.
 *
 * @method
 * @param {HTMLElement} domNode DOM node
 * @param {number} domOffset DOM offset within the DOM node
 * @returns {number} Linear model offset
 * @throws {Error} domOffset is out of bounds
 * @throws {Error} domNode has no ancestor with a .data( 'view' )
 * @throws {Error} domNode is not in document
 */
ve.ce.getOffset = function ( domNode, domOffset ) {
	var node, view, offset, startNode, maxOffset, lengthSum = 0,
		$domNode = $( domNode );

	if ( $domNode.hasClass( 've-ce-unicorn' ) ) {
		if ( domOffset !== 0 ) {
			throw new Error( 'Non-zero offset in unicorn' );
		}
		return $domNode.data( 'dmOffset' );
	}

	/**
	 * Move to the previous "traversal node" in "traversal sequence".
	 *
	 * - A node is a "traversal node" if it is either a leaf node or a "view node"
	 * - A "view node" is one that has $( n ).data( 'view' ) instanceof ve.ce.Node
	 * - "Traversal sequence" is defined on every node (not just traversal nodes).
	 *   It is like document order, except that each parent node appears
	 *   in the sequence both immediately before and immediately after its child nodes.
	 *
	 * Important properties:
	 * - Non-traversal nodes don't have any width in DM (e.g. bold).
	 * - Certain traversal nodes also have no width (namely, those within an alienated node).
	 * - Both the start and end of a (non-alienated) parent traversal node has width
	 *   (which is one reason why traversal sequence is important).
	 * - In VE-normalized HTML, a text node cannot be a sibling of a non-leaf view node
	 *   (because all non-alienated text nodes are inside a ContentBranchNode).
	 * - Traversal-consecutive non-view nodes are either all alienated or all not alienated.
	 *
	 * @param {Node} n Node to traverse from
	 * @returns {Node} Previous traversal node from n
	 * @throws {Error} domNode has no ancestor with a .data( 'view' )
	 */
	function traverse( n ) {
		while ( !n.previousSibling ) {
			n = n.parentNode;
			if ( !n ) {
				throw new Error( 'domNode has no ancestor with a .data( \'view\' )' );
			}
			if ( $( n ).data( 'view' ) instanceof ve.ce.Node ) {
				return n;
			}
		}
		n = n.previousSibling;
		if ( $( n ).data( 'view' ) instanceof ve.ce.Node ) {
			return n;
		}
		while ( n.lastChild ) {
			n = n.lastChild;
			if ( $( n ).data( 'view' ) instanceof ve.ce.Node ) {
				return n;
			}
		}
		return n;
	}

	// Validate domOffset
	if ( domNode.nodeType === Node.ELEMENT_NODE ) {
		maxOffset = domNode.childNodes.length;
	} else {
		maxOffset = domNode.data.length;
	}
	if ( domOffset < 0 || domOffset > maxOffset) {
		throw new Error( 'domOffset is out of bounds' );
	}

	// Figure out what node to start traversing at (startNode)
	if ( domNode.nodeType === Node.ELEMENT_NODE ) {
		if ( domNode.childNodes.length === 0 ) {
			// domNode has no children, and the offset is inside of it
			// If domNode is a view node, return the offset inside of it
			// Otherwise, start traversing at domNode
			startNode = domNode;
			view = $( startNode ).data( 'view' );
			if ( view instanceof ve.ce.Node ) {
				return view.getOffset() + ( view.isWrapped() ? 1 : 0 );
			}
			node = startNode;
		} else if ( domOffset === domNode.childNodes.length ) {
			// Offset is at the end of domNode, after the last child. Set startNode to the
			// very rightmost descendant node of domNode (i.e. the last child of the last child
			// of the last child, etc.)
			// However, if the last child or any of the last children we encounter on the way
			// is a view node, return the offset after it. This will be the correct return value
			// because non-traversal nodes don't have a DM width.
			startNode = domNode.lastChild;

			view = $( startNode ).data( 'view' );
			if ( view instanceof ve.ce.Node ) {
				return view.getOffset() + view.getOuterLength();
			}
			while ( startNode.lastChild ) {
				startNode = startNode.lastChild;
				view = $( startNode ).data( 'view' );
				if ( view instanceof ve.ce.Node ) {
					return view.getOffset() + view.getOuterLength();
				}
			}
			node = startNode;
		} else {
			// Offset is right before childNodes[domOffset]. Set startNode to this node
			// (i.e. the node right after the offset), then traverse back once.
			startNode = domNode.childNodes[domOffset];
			node = traverse( startNode );
		}
	} else {
		// Text inside of a block slug doesn't count
		if ( !$( domNode.parentNode ).hasClass( 've-ce-branchNode-blockSlug' ) ) {
			lengthSum += domOffset;
		}
		startNode = domNode;
		node = traverse( startNode );
	}

	// Walk the traversal nodes in reverse traversal sequence, until we find a view node.
	// Add the width of each text node we meet. (Non-text node non-view nodes can only be widthless).
	// Later, if it transpires that we're inside an alienated node, then we will throw away all the
	// text node lengths, because the alien's content has no DM width.
	while ( true ) {
		// First node that has a ve.ce.Node, stop
		// Note that annotations have a .data( 'view' ) too, but that's a ve.ce.Annotation,
		// not a ve.ce.Node
		view = $( node ).data( 'view' );
		if ( view instanceof ve.ce.Node ) {
			break;
		}

		// Text inside of a block slug doesn't count
		if ( node.nodeType === Node.TEXT_NODE && !$( node.parentNode ).hasClass( 've-ce-branchNode-blockSlug' ) ) {
			lengthSum += node.data.length;
		}
		// else: non-text nodes that don't have a .data( 'view' ) don't exist in the DM
		node = traverse( node );
	}

	offset = view.getOffset();

	if ( $.contains( node, startNode ) ) {
		// node is an ancestor of startNode
		if ( !view.getModel().isContent() ) {
			// Add 1 to take the opening into account
			offset += view.getModel().isWrapped() ? 1 : 0;
		}
		if ( view.getModel().canContainContent() ) {
			offset += lengthSum;
		}
		// else: we're inside an alienated node: throw away all the text node lengths,
		// because the alien's content has no DM width
	} else if ( view.parent ) {
		// node is not an ancestor of startNode
		// startNode comes after node, so add node's length
		offset += view.getOuterLength();
		if ( view.isContent() ) {
			// view is a leaf node inside of a CBN, so we started inside of a CBN
			// (otherwise we would have hit the CBN when entering it), so the text we summed up
			// needs to be counted.
			offset += lengthSum;
		}
	} else {
		throw new Error( 'Node is not in document' );
	}

	return offset;
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
 * Check if keyboard shortcut modifier key is pressed.
 *
 * @method
 * @param {jQuery.Event} e Key press event
 * @returns {boolean} Modifier key is pressed
 */
ve.ce.isShortcutKey = function ( e ) {
	return !!( e.ctrlKey || e.metaKey );
};
