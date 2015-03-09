/*!
 * VisualEditor DataModel Document class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
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
 * @param {Array|ve.dm.ElementLinearData|ve.dm.FlatLinearData} data Raw linear model data,
 *  ElementLinearData or FlatLinearData to be split
 * @param {HTMLDocument} [htmlDocument] HTML document the data was converted from, if any.
 *  If omitted, a new document will be created. If data is an HTMLDocument, this parameter is
 *  ignored.
 * @param {ve.dm.Document} [parentDocument] Document to use as root for created nodes
 * @param {ve.dm.InternalList} [internalList] Internal list to clone; passed when creating a document slice
 * @param {Array} [innerWhitespace] Inner whitespace to clone; passed when creating a document slice
 * @param {string} [lang] Language code
 * @param {string} [dir='ltr'] Directionality (ltr/rtl)
 */
ve.dm.Document = function VeDmDocument( data, htmlDocument, parentDocument, internalList, innerWhitespace, lang, dir ) {
	// Parent constructor
	ve.Document.call( this, new ve.dm.DocumentNode() );

	// Initialization
	var fullData, result,
		split = true,
		doc = parentDocument || this,
		root = this.documentNode;

	this.lang = lang;
	this.dir = dir || 'ltr';

	this.documentNode.setRoot( root );
	this.documentNode.setDocument( doc );
	this.internalList = internalList ? internalList.clone( this ) : new ve.dm.InternalList( this );
	this.innerWhitespace = innerWhitespace ? ve.copy( innerWhitespace ) : new Array( 2 );

	// Properties
	this.parentDocument = parentDocument;
	this.completeHistory = [];

	if ( data instanceof ve.dm.ElementLinearData ) {
		// Pre-split ElementLinearData
		split = false;
		fullData = data;
	} else if ( data instanceof ve.dm.FlatLinearData ) {
		// Element + Meta linear data
		fullData = data;
	} else {
		// Raw linear model data
		fullData = new ve.dm.FlatLinearData(
			new ve.dm.IndexValueStore(),
			ve.isArray( data ) ? data : []
		);
	}
	this.store = fullData.getStore();
	this.htmlDocument = htmlDocument || ve.createDocumentFromHtml( '' );

	if ( split ) {
		result = this.constructor.static.splitData( fullData );
		this.data = result.elementData;
		this.metadata = result.metaData;
	} else {
		this.data = fullData;
		this.metadata = new ve.dm.MetaLinearData( this.data.getStore(), new Array( 1 + this.data.getLength() ) );
	}
};

/* Inheritance */

OO.inheritClass( ve.dm.Document, ve.Document );

/* Events */

/**
 * @event transact
 * @param {ve.dm.Transaction} tx Transaction that was just processed
 */

/* Static methods */

ve.dm.Document.static = {};

/**
 * Split data into element data and meta data.
 *
 * @param {ve.dm.FlatLinearData} fullData Full data from converter
 * @returns {Object} Object containing element linear data and meta linear data (if processed)
 */
ve.dm.Document.static.splitData = function ( fullData ) {
	var i, len, offset, meta, elementData, metaData;

	elementData = new ve.dm.ElementLinearData( fullData.getStore() );
	// Sparse array containing the metadata for each offset
	// Each element is either undefined, or an array of metadata elements
	// Because the indexes in the metadata array represent offsets in the data array, the
	// metadata array has one element more than the data array.
	metaData = new ve.dm.MetaLinearData( fullData.getStore() );

	// Separate element data and metadata and build node tree
	for ( i = 0, len = fullData.getLength(); i < len; i++ ) {
		if ( !fullData.isElementData( i ) ) {
			// Add to element linear data
			elementData.push( fullData.getData( i ) );
		} else {
			// Element data
			if ( fullData.isOpenElementData( i ) &&
				ve.dm.metaItemFactory.lookup( fullData.getType( i ) )
			) {
				// Metadata
				meta = fullData.getData( i );
				offset = elementData.getLength();
				// Put the meta data in the meta-linmod
				if ( !metaData.getData( offset ) ) {
					metaData.setData( offset, [] );
				}
				metaData.getData( offset ).push( meta );
				// Skip close element
				i++;
				continue;
			}
			// Add to element linear data
			elementData.push( fullData.getData( i ) );
		}
	}
	// Pad out the metadata length to element data length + 1
	if ( metaData.getLength() < elementData.getLength() + 1 ) {
		metaData.data = metaData.data.concat(
			new Array( 1 + elementData.getLength() - metaData.getLength() )
		);
	}

	return {
		'elementData': elementData,
		'metaData': metaData
	};
};

/**
 * Apply annotations to content data.
 *
 * This method modifies data in place.
 *
 * @method
 * @param {Array} data Data to apply annotations to
 * @param {ve.dm.AnnotationSet} annotationSet Annotations to apply
 */
ve.dm.Document.static.addAnnotationsToData = function ( data, annotationSet ) {
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
 * @inheritdoc
 */
ve.dm.Document.prototype.getDocumentNode = function () {
	if ( !this.documentNode.length && !this.documentNode.getDocument().buildingNodeTree ) {
		this.buildNodeTree();
	}
	return this.documentNode;
};

/**
 * Build the node tree.
 */
ve.dm.Document.prototype.buildNodeTree = function () {
	var i, len, node, children,
		currentStack, parentStack, nodeStack, currentNode, doc,
		textLength = 0,
		inTextNode = false;

	// Build a tree of nodes and nodes that will be added to them after a full scan is complete,
	// then from the bottom up add nodes to their potential parents. This avoids massive length
	// updates being broadcast upstream constantly while building is underway.
	currentStack = [];
	parentStack = [this.documentNode];
	// Stack of stacks
	nodeStack = [parentStack, currentStack];
	currentNode = this.documentNode;
	doc = this.documentNode.getDocument();

	// Separate element data and metadata and build node tree
	for ( i = 0, len = this.data.getLength(); i < len; i++ ) {
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
			if ( this.data.isOpenElementData( i ) ) {
				// Branch or leaf node opening
				// Create a childless node
				node = ve.dm.nodeFactory.create(
					this.data.getType( i ), this.data.getData( i )
				);
				node.setDocument( doc );
				// Put the childless node on the current inner stack
				currentStack.push( node );
				if ( ve.dm.nodeFactory.canNodeHaveChildren( node.getType() ) ) {
					// Create a new inner stack for this node
					parentStack = currentStack;
					currentStack = [];
					nodeStack.push( currentStack );
				}
				currentNode = node;
			} else {
				// Branch or leaf node closing
				if ( ve.dm.nodeFactory.canNodeHaveChildren( currentNode.getType() ) ) {
					// Pop this node's inner stack from the outer stack. It'll have all of the
					// node's child nodes fully constructed
					children = nodeStack.pop();
					currentStack = parentStack;
					parentStack = nodeStack[nodeStack.length - 2];
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

	if ( inTextNode ) {
		// Text node ended by end-of-input rather than by an element
		currentNode.setLength( textLength );
		// Don't bother updating currentNode et al, we don't use them below
	}

	// State variable that allows nodes to know that they are being
	// appended in order. Used by ve.dm.InternalList.
	doc.buildingNodeTree = true;

	// The end state is stack = [ [this.documentNode] [ array, of, its, children ] ]
	// so attach all nodes in stack[1] to the root node
	ve.batchSplice( this.documentNode, 0, 0, currentStack );

	doc.buildingNodeTree = false;
};

/**
 * Apply a transaction's effects on the content data.
 *
 * @method
 * @param {ve.dm.Transaction} transaction Transaction to apply
 * @fires transact
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
 * Get the HTMLDocument associated with this document.
 *
 * @method
 * @returns {HTMLDocument} Associated document
 */
ve.dm.Document.prototype.getHtmlDocument = function () {
	return this.htmlDocument;
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
 * Get the document's inner whitespace
 * @returns {Array} The document's inner whitespace
 */
ve.dm.Document.prototype.getInnerWhitespace = function () {
	return this.innerWhitespace;
};

/**
 * Clone a sub-document from a data slice of this document.
 *
 * The new document's internal list will be only contain references to data within the slice.
 *
 * @param {ve.Range} range Range of data to slice
 * @returns {ve.dm.DocumentSlice} New document
 */
ve.dm.Document.prototype.cloneSliceFromRange = function ( range ) {
	var i, first, last, firstNode, lastNode,
		data, slice, originalRange, balancedRange,
		balancedNodes, needsContext,
		startNode = this.getNodeFromOffset( range.start ),
		endNode = this.getNodeFromOffset( range.end ),
		selection = this.selectNodes( range, 'siblings' ),
		balanceOpenings = [],
		balanceClosings = [],
		contextOpenings = [],
		contextClosings = [];

	// Fix up selection to remove empty items in unwrapped nodes
	// TODO: fix this is selectNodes
	while ( selection[0] && selection[0].range && selection[0].range.isCollapsed() && !selection[0].node.isWrapped() ) {
		selection.shift();
	}

	i = selection.length - 1;
	while ( selection[i] && selection[i].range && selection[i].range.isCollapsed() && !selection[i].node.isWrapped() ) {
		selection.pop();
		i--;
	}

	if ( selection.length === 0 ) {
		// Nothing selected
		data = new ve.dm.ElementLinearData( this.getStore(), [] );
		originalRange = balancedRange = new ve.Range( 0 );
	} else if ( startNode === endNode ) {
		// Nothing to balance
		balancedNodes = selection;
	} else {
		// Selection is not balanced
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
				while ( !startNode.isWrapped() ) {
					startNode = startNode.getParent();
				}
				balanceOpenings.push( startNode.getClonedElement() );
				if ( startNode === firstNode ) {
					break;
				}
				startNode = startNode.getParent();
			}
		}

		if ( last !== first && last.range ) {
			while ( true ) {
				while ( !endNode.isWrapped() ) {
					endNode = endNode.getParent();
				}
				balanceClosings.push( { 'type': '/' + endNode.getType() } );
				if ( endNode === lastNode ) {
					break;
				}
				endNode = endNode.getParent();
			}
		}

		balancedNodes = this.selectNodes(
			new ve.Range( firstNode.getOuterRange().start, lastNode.getOuterRange().end ),
			'covered'
		);
	}

	if ( !balancedRange ) {
		// Check if any of the balanced siblings need more context for insertion anywhere
		needsContext = false;
		for ( i = balancedNodes.length - 1; i >= 0; i-- ) {
			if ( balancedNodes[i].node.getParentNodeTypes() !== null ) {
				needsContext = true;
				break;
			}
		}

		if ( needsContext ) {
			startNode = balancedNodes[0].node;
			// Keep wrapping until the outer node can be inserted anywhere
			while ( startNode.getParent() && startNode.getParentNodeTypes() !== null ) {
				startNode = startNode.getParent();
				contextOpenings.push( startNode.getClonedElement() );
				contextClosings.push( { 'type': '/' + startNode.getType() } );
			}
		}

		// Final data:
		//  contextOpenings + balanceOpenings + data slice + balanceClosings + contextClosings
		data = new ve.dm.ElementLinearData(
			this.getStore(),
			contextOpenings.reverse()
				.concat( balanceOpenings.reverse() )
				.concat( this.data.slice( range.start, range.end ) )
				.concat( balanceClosings )
				.concat( contextClosings )
		);
		originalRange = new ve.Range(
			contextOpenings.length + balanceOpenings.length,
			contextOpenings.length + balanceOpenings.length + range.getLength()
		);
		balancedRange = new ve.Range(
			contextOpenings.length,
			contextOpenings.length + balanceOpenings.length + range.getLength() + balanceClosings.length
		);
	}

	// Copy over the internal list
	ve.batchSplice(
		data.data, data.getLength(), 0,
		this.getData( this.getInternalList().getListNode().getOuterRange(), true )
	);

	// The internalList is rebuilt by the document constructor
	slice = new ve.dm.DocumentSlice(
		data, undefined, undefined, this.getInternalList().clone(), originalRange, balancedRange
	);
	return slice;
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
		store = this.getStore().clone(),
		listRange = this.getInternalList().getListNode().getOuterRange();

	data = ve.copy( this.getFullData( range, true ) );
	if ( range.start > listRange.start || range.end < listRange.end ) {
		// The range does not include the entire internal list, so add it
		data = data.concat( this.getFullData( listRange ) );
	}
	newDoc = new this.constructor(
		new ve.dm.FlatLinearData( store, data ),
		this.getHtmlDocument(), undefined, this.getInternalList(), undefined,
		this.getLang(), this.getDir()
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
 * @returns {ve.dm.Node} Node at offset
 */
ve.dm.Document.prototype.getNodeFromOffset = function ( offset ) {
	// FIXME duplicated from ve.ce.Document
	if ( offset < 0 || offset > this.data.getLength() ) {
		throw new Error( 've.dm.Document.getNodeFromOffset(): offset ' + offset + ' is out of bounds' );
	}
	var node = this.getDocumentNode().getNodeFromOffset( offset );
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
		fragment = new this.constructor( data, this.htmlDocument, this ),
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
 * @returns {Object} A (possibly modified) copy of data, a (possibly modified) offset,
 * and a number of elements to remove and the position of the original data in the new data
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

		// Track the position of the orignal data in the fixed up data for range adjustments
		insertedDataOffset = 0,
		insertedDataLength = data.length,

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
				if ( i === 0 ) {
					insertedDataOffset++;
				} else {
					insertedDataLength++;
				}
				newData.push( closings[j] );
			}
			for ( j = 0; j < openings.length; j++ ) {
				if ( i === 0 ) {
					insertedDataOffset++;
				} else {
					insertedDataLength++;
				}
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
		'offset': offset,
		'data': newData,
		'remove': remove,
		'insertedDataOffset': insertedDataOffset,
		'insertedDataLength': insertedDataLength
	};
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

/**
 * Get the content language
 * @returns {string} Language code
 */
ve.dm.Document.prototype.getLang = function () {
	return this.lang;
};

/**
 * Get the content directionality
 * @returns {string} Directionality (ltr/rtl)
 */
ve.dm.Document.prototype.getDir = function () {
	return this.dir;
};
