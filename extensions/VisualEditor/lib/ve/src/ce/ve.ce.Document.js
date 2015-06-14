/*!
 * VisualEditor ContentEditable Document class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * ContentEditable document.
 *
 * @class
 * @extends ve.Document
 *
 * @constructor
 * @param {ve.dm.Document} model Model to observe
 * @param {ve.ce.Surface} surface Surface document is part of
 */
ve.ce.Document = function VeCeDocument( model, surface ) {
	// Parent constructor
	ve.Document.call( this, new ve.ce.DocumentNode(
		model.getDocumentNode(), surface, { $: surface.$ }
	) );

	this.getDocumentNode().$element.attr( {
		lang: model.getLang(),
		dir: model.getDir()
	} );

	// Properties
	this.model = model;
};

/* Inheritance */

OO.inheritClass( ve.ce.Document, ve.Document );

/* Methods */

/**
 * Get a slug at an offset.
 *
 * @method
 * @param {number} offset Offset to get slug at
 * @returns {HTMLElement} Slug at offset
 */
ve.ce.Document.prototype.getSlugAtOffset = function ( offset ) {
	var node = this.getBranchNodeFromOffset( offset );
	return node ? node.getSlugAtOffset( offset ) : null;
};

/**
 * Get a DOM node and DOM element offset for a document offset.
 *
 * @method
 * @param {number} offset Linear model offset
 * @returns {Object} Object containing a node and offset property where node is an HTML element and
 * offset is the byte position within the element
 * @throws {Error} Offset could not be translated to a DOM element and offset
 */
ve.ce.Document.prototype.getNodeAndOffset = function ( offset ) {
	var nao, currentNode, nextNode, previousNode;
	function getNext( node ) {
		while ( node.nextSibling === null ) {
			node = node.parentNode;
			if ( node === null ) {
				return null;
			}
		}
		node = node.nextSibling;
		while ( node.firstChild ) {
			node = node.firstChild;
		}
		return node;
	}
	function getPrevious( node ) {
		while ( node.previousSibling === null ) {
			node = node.parentNode;
			if ( node === null ) {
				return null;
			}
		}
		node = node.previousSibling;
		while ( node.lastChild ) {
			node = node.lastChild;
		}
		return node;
	}

	nao = this.getNodeAndOffsetUnadjustedForUnicorn( offset );
	currentNode = nao.node;
	nextNode = getNext( currentNode );
	previousNode = getPrevious( currentNode );

	// Adjust for unicorn if necessary, then return
	if (
		( (
			currentNode.nodeType === Node.TEXT_NODE &&
			nao.offset === currentNode.data.length
		) || (
			currentNode.nodeType === Node.ELEMENT_NODE &&
			currentNode.classList.contains( 've-ce-branchNode-inlineSlug' )
		) ) &&
		nextNode &&
		nextNode.nodeType === Node.ELEMENT_NODE &&
		nextNode.classList.contains( 've-ce-pre-unicorn' )
	) {
		// At text offset or slug just before the pre unicorn; return the point just after it
		return ve.ce.nextCursorOffset( nextNode );
	} else if ( currentNode.nodeType === Node.ELEMENT_NODE &&
		currentNode.children.length > nao.offset &&
		currentNode.children[nao.offset].nodeType === Node.ELEMENT_NODE &&
		currentNode.children[nao.offset].classList.contains( 've-ce-pre-unicorn' )
	) {
		// At element offset just before the pre unicorn; return the point just after it
		return { node: nao.node, offset: nao.offset + 1 };
	} else if (
		( (
			currentNode.nodeType === Node.TEXT_NODE &&
			nao.offset === 0
		) || (
			currentNode.nodeType === Node.ELEMENT_NODE &&
			currentNode.classList.contains( 've-ce-branchNode-inlineSlug' )
		) ) &&
		previousNode &&
		previousNode.nodeType === Node.ELEMENT_NODE &&
		previousNode.classList.contains( 've-ce-post-unicorn' )
	) {
		// At text offset or slug just after the post unicorn; return the point just before it
		return ve.ce.previousCursorOffset( previousNode );
	} else if ( currentNode.nodeType === Node.ELEMENT_NODE &&
		nao.offset > 0 &&
		currentNode.children[nao.offset - 1].nodeType === Node.ELEMENT_NODE &&
		currentNode.children[nao.offset - 1].classList.contains( 've-ce-post-unicorn' )
	) {
		// At element offset just after the post unicorn; return the point just before it
		return { node: nao.node, offset: nao.offset - 1 };
	} else {
		return nao;
	}
};

/**
 * @private
 */
ve.ce.Document.prototype.getNodeAndOffsetUnadjustedForUnicorn = function ( offset ) {
	var node, startOffset, current, stack, item, $item, length, model,
		countedNodes = [],
		slug = this.getSlugAtOffset( offset );
	// Check for a slug that is empty (apart from a chimera)
	if ( slug && ( !slug.firstChild || $( slug.firstChild ).hasClass( 've-ce-chimera' ) ) ) {
		return { node: slug, offset: 0 };
	}
	node = this.getBranchNodeFromOffset( offset );
	startOffset = node.getOffset() + ( ( node.isWrapped() ) ? 1 : 0 );
	current = [node.$element.contents(), 0];
	stack = [current];
	while ( stack.length > 0 ) {
		if ( current[1] >= current[0].length ) {
			stack.pop();
			current = stack[ stack.length - 1 ];
			continue;
		}
		item = current[0][current[1]];
		if ( item.nodeType === Node.TEXT_NODE ) {
			length = item.textContent.length;
			if ( offset >= startOffset && offset <= startOffset + length ) {
				return {
					node: item,
					offset: offset - startOffset
				};
			} else {
				startOffset += length;
			}
		} else if ( item.nodeType === Node.ELEMENT_NODE ) {
			$item = current[0].eq( current[1] );
			if ( $item.hasClass( 've-ce-unicorn' ) ) {
				if ( offset === startOffset ) {
					return {
						node: $item[0].parentNode,
						offset: offset - startOffset
					};
				}
			} else if ( $item.is( '.ve-ce-branchNode, .ve-ce-leafNode' ) ) {
				model = $item.data( 'view' ).model;
				// DM nodes can render as multiple elements in the view, so check
				// we haven't already counted it.
				if ( ve.indexOf( model, countedNodes ) === -1 ) {
					length = model.getOuterLength();
					countedNodes.push( model );
					if ( offset >= startOffset && offset < startOffset + length ) {
						stack.push( [$item.contents(), 0] );
						current[1]++;
						current = stack[stack.length - 1];
						continue;
					} else {
						startOffset += length;
					}
				}
			} else {
				// Maybe ve-ce-branchNode-slug
				stack.push( [$item.contents(), 0] );
				current[1]++;
				current = stack[stack.length - 1];
				continue;
			}
		}
		current[1]++;
	}
	throw new Error( 'Offset could not be translated to a DOM element and offset: ' + offset );
};

/**
 * Get the directionality of some selection.
 *
 * @method
 * @param {ve.dm.Selection} selection Selection
 * @returns {string|null} 'rtl', 'ltr' or null if unknown
 */
ve.ce.Document.prototype.getDirectionFromSelection = function ( selection ) {
	var effectiveNode, range, selectedNodes;

	if ( selection instanceof ve.dm.LinearSelection ) {
		range = selection.getRange();
	} else if ( selection instanceof ve.dm.TableSelection ) {
		range = selection.tableRange;
	} else {
		return null;
	}

	selectedNodes = this.selectNodes( range, 'covered' );

	if ( selectedNodes.length > 1 ) {
		// Selection of multiple nodes
		// Get the common parent node
		effectiveNode = this.selectNodes( range, 'siblings' )[0].node.getParent();
	} else {
		// selection of a single node
		effectiveNode = selectedNodes[0].node;

		while ( effectiveNode.isContent() ) {
			// This means that we're in a leaf node, like TextNode
			// those don't read the directionality properly, we will
			// have to climb up the parentage chain until we find a
			// wrapping node like paragraph or list item, etc.
			effectiveNode = effectiveNode.parent;
		}
	}

	return effectiveNode.$element.css( 'direction' );
};
