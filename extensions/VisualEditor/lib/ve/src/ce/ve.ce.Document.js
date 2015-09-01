/*!
 * VisualEditor ContentEditable Document class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
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
	ve.Document.call( this, new ve.ce.DocumentNode( model.getDocumentNode(), surface ) );

	this.getDocumentNode().$element.prop( {
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
 * @return {HTMLElement} Slug at offset
 */
ve.ce.Document.prototype.getSlugAtOffset = function ( offset ) {
	var node = this.getBranchNodeFromOffset( offset );
	return node ? node.getSlugAtOffset( offset ) : null;
};

/**
 * Calculate the DOM location corresponding to a DM offset
 *
 * @param {number} offset Linear model offset
 * @return {Object} DOM location
 * @return {Node} return.node location node
 * @return {number} return.offset location offset within the node
 * @throws {Error} Offset could not be translated to a DOM element and offset
 */
ve.ce.Document.prototype.getNodeAndOffset = function ( offset ) {
	var nao, currentNode, nextNode, previousNode;

	// Get the un-unicorn-adjusted result. If it is:
	// - just before pre unicorn, then return the cursor location just after it
	// - just after the post unicorn, then return the cursor location just before it
	// - anywhere else, then return the result unmodified

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
		currentNode.childNodes.length > nao.offset &&
		currentNode.childNodes[ nao.offset ].nodeType === Node.ELEMENT_NODE &&
		currentNode.childNodes[ nao.offset ].classList.contains( 've-ce-pre-unicorn' )
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
		currentNode.childNodes[ nao.offset - 1 ].nodeType === Node.ELEMENT_NODE &&
		currentNode.childNodes[ nao.offset - 1 ].classList.contains( 've-ce-post-unicorn' )
	) {
		// At element offset just after the post unicorn; return the point just before it
		return { node: nao.node, offset: nao.offset - 1 };
	} else {
		return nao;
	}
};

/**
 * Calculate the DOM location corresponding to a DM offset (without unicorn adjustments)
 *
 * @private
 * @param {number} offset Linear model offset
 * @return {Object} location
 * @return {Node} return.node location node
 * @return {number} return.offset location offset within the node
 */
ve.ce.Document.prototype.getNodeAndOffsetUnadjustedForUnicorn = function ( offset ) {
	var node, startOffset, current, stack, item, $item, length, model,
		countedNodes = [],
		slug = this.getSlugAtOffset( offset );

	// If we're a block slug, or an empty inline slug, return its location
	// Start at the current branch node; get its start offset
	// Walk the tree, summing offsets until the sum reaches the desired offset value
	// - If a whole branch is entirely before the offset, then don't descend into it
	// - If the desired offset is in a text node, return that node and the correct remainder offset
	// - If the desired offset is between an empty unicorn pair, return inter-unicorn location
	// - Assume no other outcome is possible (because we would be inside a slug)

	// Check for a slug that is empty (apart from a chimera) or a block slug
	if ( slug && (
		!slug.firstChild ||
		$( slug ).hasClass( 've-ce-branchNode-blockSlug' ) ||
		$( slug.firstChild ).hasClass( 've-ce-chimera' )
	) ) {
		return { node: slug, offset: 0 };
	}
	node = this.getBranchNodeFromOffset( offset );
	startOffset = node.getOffset() + ( ( node.isWrapped() ) ? 1 : 0 );
	current = [ node.$element.contents(), 0 ];
	stack = [ current ];
	while ( stack.length > 0 ) {
		if ( current[ 1 ] >= current[ 0 ].length ) {
			stack.pop();
			current = stack[ stack.length - 1 ];
			continue;
		}
		item = current[ 0 ][ current[ 1 ] ];
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
			$item = current[ 0 ].eq( current[ 1 ] );
			if ( $item.hasClass( 've-ce-unicorn' ) ) {
				if ( offset === startOffset ) {
					// Return if empty unicorn pair at the correct offset
					if ( $( $item[ 0 ].previousSibling ).hasClass( 've-ce-unicorn' ) ) {
						return {
							node: $item[ 0 ].parentNode,
							offset: current[ 1 ] - 1
						};
					} else if ( $( $item[ 0 ].nextSibling ).hasClass( 've-ce-unicorn' ) ) {
						return {
							node: $item[ 0 ].parentNode,
							offset: current[ 1 ] + 1
						};
					}
					// Else algorithm will/did descend into unicorned range
				}
				// Else algorithm will skip this unicorn
			} else if ( $item.is( '.ve-ce-branchNode, .ve-ce-leafNode' ) ) {
				model = $item.data( 'view' ).model;
				// DM nodes can render as multiple elements in the view, so check
				// we haven't already counted it.
				if ( countedNodes.indexOf( model ) === -1 ) {
					length = model.getOuterLength();
					countedNodes.push( model );
					if ( offset >= startOffset && offset < startOffset + length ) {
						stack.push( [ $item.contents(), 0 ] );
						current[ 1 ]++;
						current = stack[ stack.length - 1 ];
						continue;
					} else {
						startOffset += length;
					}
				}
			} else if ( $item.hasClass( 've-ce-branchNode-blockSlug' ) ) {
				// This is unusual: generated wrappers usually mean that the return
				// value of getBranchNodeFromOffset will not have block slugs or
				// block slug ancestors before the offset position. However, there
				// are some counterexamples; e.g., if the DM offset is just before
				// the internalList then the start node will be the document node.
				//
				// Skip contents without incrementing offset.
				current[ 1 ]++;
				continue;
			} else {
				// Any other type of node (e.g. b, inline slug, img): descend
				stack.push( [ $item.contents(), 0 ] );
				current[ 1 ]++;
				current = stack[ stack.length - 1 ];
				continue;
			}
		}
		current[ 1 ]++;
	}
	throw new Error( 'Offset could not be translated to a DOM element and offset: ' + offset );
};

/**
 * Get the directionality of some selection.
 *
 * @method
 * @param {ve.dm.Selection} selection Selection
 * @return {string|null} 'rtl', 'ltr' or null if unknown
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
		effectiveNode = this.selectNodes( range, 'siblings' )[ 0 ].node.getParent();
	} else {
		// selection of a single node
		effectiveNode = selectedNodes[ 0 ].node;

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
