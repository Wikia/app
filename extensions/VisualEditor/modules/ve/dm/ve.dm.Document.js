/*!
 * VisualEditor DataModel Document class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel document.
 *
 * WARNING: The data parameter is passed by reference. Do not modify a data array after passing
 * it to this constructor, and do not construct multiple Documents with the same data array. If you
 * need to do these things, make a deep copy (ve#copy) of the data array and operate on the
 * copy.
 *
 * @class
 * @extends ve.Document
 * @constructor
 * @param {HTMLDocument|Array|ve.dm.LinearData} documentOrData HTML document, raw linear model data or LinearData to start with
 * @param {ve.dm.Document} [parentDocument] Document to use as root for created nodes
 * @param {ve.dm.InternalList} [internalList] Internal list to clone; passed when creating a document slice
 */
ve.dm.Document = function VeDmDocument( documentOrData, parentDocument, internalList ) {
	// Parent constructor
	ve.Document.call( this, new ve.dm.DocumentNode() );

	// Initialization
	/*
	 * Build a tree of nodes and nodes that will be added to them after a full scan is complete,
	 * then from the bottom up add nodes to their potential parents. This avoids massive length
	 * updates being broadcast upstream constantly while building is underway.
	 */
	var i, node, children, meta,
		doc = parentDocument || this,
		root = this.getDocumentNode(),
		textLength = 0,
		inTextNode = false,
		// Stack of stacks, each containing a
		stack = [[this.documentNode], []],
		currentStack = stack[1],
		parentStack = stack[0],
		currentNode = this.documentNode;
	this.documentNode.setRoot( root );
	this.documentNode.setDocument( doc );
	this.internalList = internalList ? internalList.clone( this ) : new ve.dm.InternalList( this );

	// Properties
	this.parentDocument = parentDocument;
	this.completeHistory = [];

	if ( documentOrData instanceof ve.dm.LinearData ) {
		this.data = documentOrData;
	} else if ( !ve.isArray( documentOrData ) && typeof documentOrData === 'object' ) {
		this.data = ve.dm.converter.getDataFromDom( documentOrData, new ve.dm.IndexValueStore(), this.getInternalList() );
	} else {
		this.data = new ve.dm.ElementLinearData(
			new ve.dm.IndexValueStore(),
			ve.isArray( documentOrData ) ? documentOrData : []
		);
	}
	this.store = this.data.getStore();

	// Sparse array containing the metadata for each offset
	// Each element is either undefined, or an array of metadata elements
	// Because the indexes in the metadata array represent offsets in the data array, the
	// metadata array has one element more than the data array.
	this.metadata = new ve.dm.MetaLinearData( this.getStore(), [] );

	// extract metadata and build node tree
	// NB: this.data.getLength() will change as data is spliced out
	for ( i = 0; i < this.data.getLength(); i++ ) {
		// Infer that if an item in the linear model has a type attribute than it must be an element
		if ( !this.data.isElementData( i ) ) {
			// Text node opening
			if ( !inTextNode ) {
				// Create a lengthless text node
				node = new ve.dm.TextNode();
				node.setDocument( doc );
				// Put the node on the current inner stack
				currentStack.push( node );
				currentNode = node;
				// Set a flag saying we're inside a text node
				inTextNode = true;
			}
			// Track the length
			textLength++;
		} else {
			// Element data
			if ( !this.data.isCloseElementData( i ) &&
				ve.dm.metaItemFactory.lookup( this.data.getData( i ).type )
			) {
				// Metadata
				// Splice the meta element and its closing out of the linmod
				meta = this.data.getData( i );
				this.data.splice( i, 2 );
				// Put the metadata in the meta-linmod
				if ( !this.metadata.getData( i ) ) {
					this.metadata.setData( i, [] );
				}
				this.metadata.getData( i ).push( meta );
				// Make sure the loop doesn't skip the next element
				i--;
				continue;
			}

			// Text node closing
			if ( inTextNode ) {
				// Finish the text node by setting the length
				currentNode.setLength( textLength );
				// Put the state variables back as they were
				currentNode = parentStack[parentStack.length - 1];
				inTextNode = false;
				textLength = 0;
			}
			// Element open/close
			if ( !this.data.isCloseElementData( i ) ) {
				// Branch or leaf node opening
				// Create a childless node
				node = ve.dm.nodeFactory.create(
					this.data.getData( i ).type, [], this.data.getData( i )
				);
				node.setDocument( doc );
				// Put the childless node on the current inner stack
				currentStack.push( node );
				if ( ve.dm.nodeFactory.canNodeHaveChildren( node.getType() ) ) {
					// Create a new inner stack for this node
					parentStack = currentStack;
					currentStack = [];
					stack.push( currentStack );
				}
				currentNode = node;
			} else {
				// Branch or leaf node closing
				if ( ve.dm.nodeFactory.canNodeHaveChildren( currentNode.getType() ) ) {
					// Pop this node's inner stack from the outer stack. It'll have all of the
					// node's child nodes fully constructed
					children = stack.pop();
					currentStack = parentStack;
					parentStack = stack[stack.length - 2];
					if ( !parentStack ) {
						// This can only happen if we got unbalanced data
						throw new Error( 'Unbalanced input passed to document' );
					}
					// Attach the children to the node
					ve.batchSplice( currentNode, 0, 0, children );
				}
				currentNode = parentStack[parentStack.length - 1];
			}
		}
	}
	// pad out the metadata array
	if ( this.metadata.getLength() < this.data.getLength() + 1 ) {
		this.metadata.data = this.metadata.data.concat(
			new Array( 1 + this.data.getLength() - this.metadata.getLength() )
		);
	}

	if ( inTextNode ) {
		// Text node ended by end-of-input rather than by an element
		currentNode.setLength( textLength );
		// Don't bother updating currentNode et al, we don't use them below
	}

	// State variable that allows nodes to know that they are being
	// appended in order. Used by ve.dm.InternalList.
	this.buildingNodeTree = true;

	// The end state is stack = [ [this.documentNode] [ array, of, its, children ] ]
	// so attach all nodes in stack[1] to the root node
	ve.batchSplice( this.documentNode, 0, 0, stack[1] );

	this.buildingNodeTree = false;
};

/* Inheritance */

ve.inheritClass( ve.dm.Document, ve.Document );

/* Events */

/**
 * @event transact
 * @param {ve.dm.Transaction} tx Transaction that was just processed
 */

/* Static methods */

/**
 * Apply annotations to content data.
 *
 * This method modifies data in place.
 *
 * @method
 * @param {Array} data Data to apply annotations to
 * @param {ve.dm.AnnotationSet} annotationSet Annotations to apply
 */
ve.dm.Document.addAnnotationsToData = function ( data, annotationSet ) {
	var i, length, newAnnotationSet, store = annotationSet.getStore();
	if ( annotationSet.isEmpty() ) {
		// Nothing to do
		return;
	}
	// Apply annotations to data
	for ( i = 0, length = data.length; i < length; i++ ) {
		if ( data[i].type ) {
			// Element
			continue;
		} else if ( !ve.isArray( data[i] ) ) {
			// Wrap in array
			data[i] = [data[i]];
			newAnnotationSet = annotationSet.clone();
		} else {
			// Add to existing array
			newAnnotationSet = new ve.dm.AnnotationSet( store, data[i][1] );
			newAnnotationSet.addSet( annotationSet.clone() );
		}
		data[i][1] = newAnnotationSet.getIndexes();
	}
};

/* Methods */

/**
 * Apply a transaction's effects on the content data.
 *
 * @method
 * @param {ve.dm.Transaction} transaction Transaction to apply
 * @emits transact
 * @throws {Error} Cannot commit a transaction that has already been committed
 */
ve.dm.Document.prototype.commit = function ( transaction ) {
	if ( transaction.hasBeenApplied() ) {
		throw new Error( 'Cannot commit a transaction that has already been committed' );
	}
	new ve.dm.TransactionProcessor( this, transaction ).process();
	this.completeHistory.push( transaction );
	this.emit( 'transact', transaction );
};

/**
 * Get a slice or copy of the document data.
 *
 * @method
 * @param {ve.Range} [range] Range of data to get, all data will be given by default
 * @param {boolean} [deep=false] Whether to return a deep copy (WARNING! This may be very slow)
 * @returns {Array} Slice or copy of document data
 */
ve.dm.Document.prototype.getData = function ( range, deep ) {
	return this.data.getDataSlice( range, deep );
};

/**
 * Get a slice or copy of the document metadata.
 *
 * @method
 * @param {ve.Range} [range] Range of metadata to get, all metadata will be given by default
 * @param {boolean} [deep=false] Whether to return a deep copy (WARNING! This may be very slow)
 * @returns {Array} Slice or copy of document metadata
 */
ve.dm.Document.prototype.getMetadata = function ( range, deep ) {
	return this.metadata.getDataSlice( range, deep );
};

/**
 * Get the document's index-value store
 *
 * @method
 * @returns {ve.dm.IndexValueStore} The document's index-value store
 */
ve.dm.Document.prototype.getStore = function () {
	return this.store;
};

/**
 * Get the document's internal list
 * @returns {ve.dm.InternalList} The document's internal list
 */
ve.dm.Document.prototype.getInternalList = function () {
	return this.internalList;
};

/**
 * Clone a sub-document from a range in this document. The new document's store and internal list will be
 * clones of the ones in this document.
 *
 * @param {ve.Range} range Range of data to clone
 * @returns {ve.dm.Document} New document
 */
ve.dm.Document.prototype.cloneFromRange = function ( range ) {
	var data, newDoc,
		store = this.store.clone(),
		listRange = this.internalList.getListNode().getOuterRange();

	data = ve.copy( this.getFullData( range, true ) );
	if ( range.start > listRange.start || range.end < listRange.end ) {
		// The range does not include the entire internal list, so add it
		data = data.concat( this.getFullData( listRange ) );
	}
	newDoc = new this.constructor(
		new ve.dm.ElementLinearData( store, data ),
		undefined, this.internalList
	);
	// Record the length of the internal list at the time the slice was created so we can
	// reconcile additions properly
	newDoc.origDoc = this;
	newDoc.origInternalListLength = this.internalList.getItemNodeCount();
	return newDoc;
};

/**
 * Splice metadata into and/or out of the linear model.
 *
 * `this.metadata` will be updated accordingly.
 *
 * @method
 * @see ve#batchSplice
 * @param offset
 * @param index
 * @param remove
 * @param insert
 * @returns {Array}
 */
ve.dm.Document.prototype.spliceMetadata = function ( offset, index, remove, insert ) {
	var elements = this.metadata.getData( offset );
	if ( !elements ) {
		elements = [];
		this.metadata.setData( offset, elements );
	}
	insert = insert || [];
	return ve.batchSplice( elements, index, remove, insert );
};

/**
 * Get the full document data including metadata.
 *
 * Metadata will be into the document data to produce the "full data" result. If a range is passed,
 * metadata at the edges of the range won't be included unless edgeMetadata is set to true. If
 * no range is passed, the entire document's data is returned and metadata at the edges is
 * included.
 *
 * @param {ve.Range} [range] Range to get full data for. If omitted, all data will be returned
 * @param {boolean} [edgeMetadata=false] Include metadata at the edges of the range
 * @returns {Array} Data with metadata interleaved
 */
ve.dm.Document.prototype.getFullData = function ( range, edgeMetadata ) {
	var j, jLen,
		i = range ? range.start : 0,
		iLen = range ? range.end : this.data.getLength(),
		result = [];
	if ( edgeMetadata === undefined ) {
		edgeMetadata = !range;
	}
	while ( i <= iLen ) {
		if ( this.metadata.getData( i ) && ( edgeMetadata || ( i !== range.start && i !== range.end ) ) ) {
			for ( j = 0, jLen = this.metadata.getData( i ).length; j < jLen; j++ ) {
				result.push( this.metadata.getData( i )[j] );
				result.push( { 'type': '/' + this.metadata.getData( i )[j].type } );
			}
		}
		if ( i < iLen ) {
			result.push( this.data.getData( i ) );
		}
		i++;
	}
	return result;
};

/**
 * Get a node from an offset.
 *
 * @method
 * @param offset
 */
ve.dm.Document.prototype.getNodeFromOffset = function ( offset ) {
	// FIXME duplicated from ve.ce.Document
	if ( offset < 0 || offset > this.data.getLength() ) {
		throw new Error( 've.dm.Document.getNodeFromOffset(): offset ' + offset + ' is out of bounds' );
	}
	var node = this.documentNode.getNodeFromOffset( offset );
	if ( !node.canHaveChildren() ) {
		node = node.getParent();
	}
	return node;
};

/**
 * Get the content data of a node.
 *
 * @method
 * @param {ve.dm.Node} node Node to get content data for
 * @returns {Array|null} List of content and elements inside node or null if node is not found
 */
ve.dm.Document.prototype.getDataFromNode = function ( node ) {
	var length = node.getLength(),
		offset = node.getOffset();
	if ( offset >= 0 ) {
		// XXX: If the node is wrapped in an element than we should increment the offset by one so
		// we only return the content inside the element.
		if ( node.isWrapped() ) {
			offset++;
		}
		return this.data.slice( offset, offset + length );
	}
	return null;
};

/**
 * Get plain text of a range.
 *
 * @method
 * @param {ve.Range} [range] Range of data to get the text of
 * @returns {string|''} Selected text or an empty string
 */
ve.dm.Document.prototype.getText = function ( range ) {
	var data = this.getData( range ),
		str = '',
		i;
	for ( i = 0; i < data.length; i++ ) {
		if ( typeof data[i] === 'string' ) {
			str += data[i];
		} else if ( ve.isArray( data[i] ) ) {
			str += data[i][0];
		}
	}
	return str;
};

/**
 * Rebuild one or more nodes following a change in document data.
 *
 * The data provided to this method may contain either one node or multiple sibling nodes, but it
 * must be balanced and valid. Data provided to this method also may not contain any content at the
 * top level. The tree is updated during this operation.
 *
 * Process:
 *
 *  1. Nodes between {index} and {index} + {numNodes} in {parent} will be removed
 *  2. Data will be retrieved from this.data using {offset} and {newLength}
 *  3. A document fragment will be generated from the retrieved data
 *  4. The document fragment's nodes will be inserted into {parent} at {index}
 *
 * Use cases:
 *
 *  1. Rebuild old nodes and offset data after a change to the linear model.
 *  2. Insert new nodes and offset data after a insertion in the linear model.
 *
 * @param {ve.dm.Node} parent Parent of the node(s) being rebuilt
 * @param {number} index Index within parent to rebuild or insert nodes
 *
 *  - If {numNodes} == 0: Index to insert nodes at
 *  - If {numNodes} >= 1: Index of first node to rebuild
 * @param {number} numNodes Total number of nodes to rebuild
 *
 *  - If {numNodes} == 0: Nothing will be rebuilt, but the node(s) built from data will be
 *    inserted before {index}. To insert nodes at the end, use number of children in 'parent'
 *  - If {numNodes} == 1: Only the node at {index} will be rebuilt
 *  - If {numNodes} > 1: The node at {index} and the next {numNodes-1} nodes will be rebuilt
 * @param {number} offset Linear model offset to rebuild from
 * @param {number} newLength Length of data in linear model to rebuild or insert nodes for
 * @returns {ve.dm.Node[]} Array containing the rebuilt/inserted nodes
 */
ve.dm.Document.prototype.rebuildNodes = function ( parent, index, numNodes, offset, newLength ) {
	var // Get a slice of the document where it's been changed
		data = this.data.sliceObject( offset, offset + newLength ),
		// Build document fragment from data
		fragment = new ve.dm.Document( data, this ),
		// Get generated child nodes from the document fragment
		nodes = fragment.getDocumentNode().getChildren();
	// Replace nodes in the model tree
	ve.batchSplice( parent, index, numNodes, nodes );
	// Return inserted nodes
	return nodes;
};

/**
 * Fix up data so it can safely be inserted into the document data at an offset.
 *
 * TODO: this function needs more work but it seems to work, mostly
 *
 * @method
 * @param {Array} data Snippet of linear model data to insert
 * @param {number} offset Offset in the linear model where the caller wants to insert data
 * @returns {Object} A (possibly modified) copy of data, a (possibly modified) offset
 * and a number of elements to remove
 */
ve.dm.Document.prototype.fixupInsertion = function ( data, offset ) {
	var
		// Array where we build the return value
		newData = [],

		// Temporary variables for handling combining marks
		insert, annotations,
		// An unattached combining mark may require the insertion to remove a character,
		// so we send this counter back in the result
		remove = 0,

		// *** Stacks ***
		// Array of element openings (object). Openings in data are pushed onto this stack
		// when they are encountered and popped off when they are closed
		openingStack = [],
		// Array of node objects. Closings in data that close nodes that were
		// not opened in data (i.e. were already in the document) are pushed onto this stack
		// and popped off when balanced out by an opening in data
		closingStack = [],

		// Pointer to this document for private methods
		doc = this,

		// *** State persisting across iterations of the outer loop ***
		// The node (from the document) we're currently in. When in a node that was opened
		// in data, this is set to its first ancestor that is already in the document
		parentNode,
		// The type of the node we're currently in, even if that node was opened within data
		parentType,
		// Whether we are currently in a text node
		inTextNode,
		// Whether this is the first child of its parent
		// The test for last child isn't a loop so we don't need to cache it
		isFirstChild,

		// *** Temporary variables that do not persist across iterations ***
		// The type of the node we're currently inserting. When the to-be-inserted node
		// is wrapped, this is set to the type of the outer wrapper.
		childType,
		// Stores the return value of getParentNodeTypes( childType )
		allowedParents,
		// Stores the return value of getChildNodeTypes( parentType )
		allowedChildren,
		// Whether parentType matches allowedParents
		parentsOK,
		// Whether childType matches allowedChildren
		childrenOK,
		// Array of opening elements to insert (for wrapping the to-be-inserted element)
		openings,
		// Array of closing elements to insert (for splitting nodes)
		closings,
		// Array of opening elements matching the elements in closings (in the same order)
		reopenElements,

		// *** Other variables ***
		// Used to store values popped from various stacks
		popped,
		// Loop variables
		i, j;

	/**
	 * Append a linear model element to newData and update the state.
	 *
	 * This function updates parentNode, parentType, openingStack and closingStack.
	 *
	 * @private
	 * @method
	 * @param {Object|Array|string} element Linear model element
	 * @param {number} index Index in data that the element came from (for error reporting only)
	 */
	function writeElement( element, index ) {
		var expectedType;

		if ( element.type !== undefined ) {
			// Content, do nothing
			if ( element.type.charAt( 0 ) !== '/' ) {
				// Opening
				// Check if this opening balances an earlier closing of a node that was already in
				// the document. This is only the case if openingStack is empty (otherwise we still
				// have unclosed nodes from within data) and if this opening matches the top of
				// closingStack
				if ( openingStack.length === 0 && closingStack.length > 0 &&
					closingStack[closingStack.length - 1].getType() === element.type
				) {
					// The top of closingStack is now balanced out, so remove it
					// Also restore parentNode from closingStack. While this is technically not
					// entirely accurate (the current node is a new node that's a sibling of this
					// node), it's good enough for the purposes of this algorithm
					parentNode = closingStack.pop();
				} else {
					// This opens something new, put it on openingStack
					openingStack.push( element );
				}
				parentType = element.type;
			} else {
				// Closing
				// Make sure that this closing matches the currently opened node
				if ( openingStack.length > 0 ) {
					// The opening was on openingStack, so we're closing a node that was opened
					// within data. Don't track that on closingStack
					expectedType = openingStack.pop().type;
				} else {
					// openingStack is empty, so we're closing a node that was already in the
					// document. This means we have to reopen it later, so track this on
					// closingStack
					expectedType = parentNode.getType();
					closingStack.push( parentNode );
					parentNode = parentNode.getParent();
					if ( !parentNode ) {
						throw new Error( 'Inserted data is trying to close the root node ' +
							'(at index ' + index + ')' );
					}
					parentType = expectedType;

					// Validate
					// FIXME this breaks certain input, should fix it up, not scream and die
					// For now we fall back to inserting balanced data, but then we miss out on
					// a lot of the nice content adoption abilities of just fixing up the data in
					// the context of the insertion point - an example of how this will fail is if
					// you try to insert "b</p></li></ul><p>c" into "<p>a[cursor]d</p>"
					if (
						element.type !== '/' + expectedType &&
						(
							// Only throw an error if the content can't be adopted from one content
							// branch to another
							!ve.dm.nodeFactory.canNodeContainContent( element.type.substr( 1 ) ) ||
							!ve.dm.nodeFactory.canNodeContainContent( expectedType )
						)
					) {
						throw new Error( 'Cannot adopt content from ' + element.type +
							' nodes into ' + expectedType + ' nodes (at index ' + index + ')' );
					}
				}
			}
		}
		newData.push( element );
	}

	parentNode = this.getNodeFromOffset( offset );
	parentType = parentNode.getType();
	inTextNode = false;
	isFirstChild = doc.data.isOpenElementData( offset - 1 );

	for ( i = 0; i < data.length; i++ ) {
		if ( inTextNode && data[i].type !== undefined ) {
			parentType = openingStack.length > 0 ?
				openingStack[openingStack.length - 1].type : parentNode.getType();
		}
		if ( data[i].type === undefined || data[i].type.charAt( 0 ) !== '/' ) {
			childType = data[i].type || 'text';
			openings = [];
			closings = [];
			reopenElements = [];
			// Opening or content
			// Make sure that opening this element here does not violate the parent/children/content
			// rules. If it does, insert stuff to fix it

			// If this node is content, check that the containing node can contain content. If not,
			// wrap in a paragraph
			if ( ve.dm.nodeFactory.isNodeContent( childType ) &&
				!ve.dm.nodeFactory.canNodeContainContent( parentType )
			) {
				childType = 'paragraph';
				openings.unshift( ve.dm.nodeFactory.getDataElement( childType ) );
			}

			// Check that this node is allowed to have the containing node as its parent. If not,
			// wrap it until it's fixed
			do {
				allowedParents = ve.dm.nodeFactory.getParentNodeTypes( childType );
				parentsOK = allowedParents === null ||
					ve.indexOf( parentType, allowedParents ) !== -1;
				if ( !parentsOK ) {
					// We can't have this as the parent
					if ( allowedParents.length === 0 ) {
						throw new Error( 'Cannot insert ' + childType + ' because it ' +
							' cannot have a parent (at index ' + i + ')' );
					}
					// Open an allowed node around this node
					childType = allowedParents[0];
					openings.unshift( ve.dm.nodeFactory.getDataElement( childType ) );
				}
			} while ( !parentsOK );

			// Check that the containing node can have this node as its child. If not, close nodes
			// until it's fixed
			do {
				allowedChildren = ve.dm.nodeFactory.getChildNodeTypes( parentType );
				childrenOK = allowedChildren === null ||
					ve.indexOf( childType, allowedChildren ) !== -1;
				// Also check if we're trying to insert structure into a node that has to contain
				// content
				childrenOK = childrenOK && !(
					!ve.dm.nodeFactory.isNodeContent( childType ) &&
					ve.dm.nodeFactory.canNodeContainContent( parentType )
				);
				if ( !childrenOK ) {
					// We can't insert this into this parent
					if ( isFirstChild ) {
						// This element is the first child of its parent, so
						// abandon this fix up and try again one offset to the left
						return this.fixupInsertion( data, offset - 1 );
					}

					// Close the parent and try one level up
					closings.push( { 'type': '/' + parentType } );
					if ( openingStack.length > 0 ) {
						popped = openingStack.pop();
						parentType = popped.type;
						reopenElements.push( ve.copy( popped ) );
						// The opening was on openingStack, so we're closing a node that was opened
						// within data. Don't track that on closingStack
					} else {
						// openingStack is empty, so we're closing a node that was already in the
						// document. This means we have to reopen it later, so track this on
						// closingStack
						closingStack.push( parentNode );
						reopenElements.push( parentNode.getClonedElement() );
						parentNode = parentNode.getParent();
						if ( !parentNode ) {
							throw new Error( 'Cannot insert ' + childType + ' even ' +
								' after closing all containing nodes ' +
								'(at index ' + i + ')' );
						}
						parentType = parentNode.getType();
					}
				}
			} while ( !childrenOK );

			if (
				i === 0 &&
				childType === 'text' &&
				ve.isUnattachedCombiningMark( data[i] )
			) {
				// Note we only need to check data[0] as combining marks further
				// along should already have been merged
				if ( doc.data.isElementData( offset - 1 ) ) {
					// Inserting a unattached combining mark is generally pretty badly
					// supported (browser rendering bugs), so we'll just prevent it.
					continue;
				} else {
					offset--;
					remove++;
					insert = doc.data.getCharacterData( offset ) + data[i];
					annotations = doc.data.getAnnotationIndexesFromOffset( offset );
					if ( annotations.length ) {
						insert = [ insert, annotations ];
					}
					data[i] = insert;
				}
			}

			for ( j = 0; j < closings.length; j++ ) {
				// writeElement() would update openingStack/closingStack, but we've already done
				// that for closings
				newData.push( closings[j] );
			}
			for ( j = 0; j < openings.length; j++ ) {
				writeElement( openings[j], i );
			}
			writeElement( data[i], i );
			if ( data[i].type === undefined ) {
				// Special treatment for text nodes
				inTextNode = true;
				if ( openings.length > 0 ) {
					// We wrapped the text node, update parentType
					parentType = childType;
				}
				// If we didn't wrap the text node, then the node we're inserting into can have
				// content, so we couldn't have closed anything
			} else {
				parentType = data[i].type;
			}
		} else {
			// Closing
			writeElement( data[i], i );
			parentType = openingStack.length > 0 ?
				openingStack[openingStack.length - 1].type : parentNode.getType();
		}
	}

	if ( closingStack.length > 0 && doc.data.isCloseElementData( offset ) ) {
		// This element is the last child of its parent, so
		// abandon this fix up and try again one offset to the right
		return this.fixupInsertion( data, offset + 1 );
	}

	if ( inTextNode ) {
		parentType = openingStack.length > 0 ?
			openingStack[openingStack.length - 1].type : parentNode.getType();
	}

	// Close unclosed openings
	while ( openingStack.length > 0 ) {
		popped = openingStack[openingStack.length - 1];
		// writeElement() will perform the actual pop() that removes
		// popped from openingStack
		writeElement( { 'type': '/' + popped.type }, i );
	}
	// Re-open closed nodes
	while ( closingStack.length > 0 ) {
		popped = closingStack[closingStack.length - 1];
		// writeElement() will perform the actual pop() that removes
		// popped from closingStack
		writeElement( popped.getClonedElement(), i );
	}

	return {
		offset: offset,
		data: newData,
		remove: remove
	};
};

/**
 * Get the document data for a range.
 *
 * Data will be fixed up so that unopened closings and unclosed openings in the
 * linear data slice are balanced.
 *
 * @param {ve.Range} range Range to get contents of
 * @returns {ve.dm.ElementLinearDataSlice} Balanced slice of linear model data
 */
ve.dm.Document.prototype.getSlicedLinearData = function ( range ) {
	var first, last, firstNode, lastNode,
		node = this.getNodeFromOffset( range.start ),
		selection = this.selectNodes( range, 'siblings' ),
		addOpenings = [],
		addClosings = [];
	if ( selection.length === 0 ) {
		return new ve.dm.ElementLinearDataSlice( this.getStore(), [] );
	}
	if ( selection.length === 1 && selection[0].range && selection[0].range.equalsSelection( range ) ) {
		// Nothing to fix up
		return new ve.dm.ElementLinearDataSlice( this.getStore(), this.data.slice( range.start, range.end ) );
	}

	first = selection[0];
	last = selection[selection.length - 1];
	firstNode = first.node;
	lastNode = last.node;
	while ( !firstNode.isWrapped() ) {
		firstNode = firstNode.getParent();
	}
	while ( !lastNode.isWrapped() ) {
		lastNode = lastNode.getParent();
	}

	if ( first.range ) {
		while ( true ) {
			while ( !node.isWrapped() ) {
				node = node.getParent();
			}
			addOpenings.push( node.getClonedElement() );
			if ( node === firstNode ) {
				break;
			}
			node = node.getParent();
		}
	}

	node = this.getNodeFromOffset( range.end );
	if ( last !== first && last.range ) {
		while ( true ) {
			while ( !node.isWrapped() ) {
				node = node.getParent();
			}
			addClosings.push( { 'type': '/' + node.getType() } );
			if ( node === lastNode ) {
				break;
			}
			node = node.getParent();
		}
	}

	return new ve.dm.ElementLinearDataSlice(
		this.getStore(),
		addOpenings.reverse()
			.concat( this.data.slice( range.start, range.end ) )
			.concat( addClosings ),
		new ve.Range( addOpenings.length, addOpenings.length + range.getLength() )
	);
};

/**
 * Get the length of the complete history stack. This is also the current pointer.
 * @returns {number} Length of the complete history stack
 */
ve.dm.Document.prototype.getCompleteHistoryLength = function () {
	return this.completeHistory.length;
};

/**
 * Get all the items in the complete history stack since a specified pointer.
 * @param {number} pointer Pointer from where to start the slice
 * @returns {Array} Array of transaction objects with undo flag
 */
ve.dm.Document.prototype.getCompleteHistorySince = function ( pointer ) {
	return this.completeHistory.slice( pointer );
};
