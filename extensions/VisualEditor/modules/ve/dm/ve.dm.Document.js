/**
 * VisualEditor data model Document class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel document.
 *
 * WARNING: The data parameter is passed by reference. Do not modify a data array after passing
 * it to this constructor, and do not construct multiple Documents with the same data array. If you
 * need to do these things, make a deep copy (ve.copyArray()) of the data array and operate on the
 * copy.
 *
 * @class
 * @constructor
 * @extends {ve.Document}
 * @param {Array} data Linear model data to start with
 * @param {ve.dm.Document} [parentDocument] Document to use as root for created nodes
 */
ve.dm.Document = function VeDmDocument( data, parentDocument ) {
	// Parent constructor
	ve.Document.call( this, new ve.dm.DocumentNode() );

	// Properties
	this.parentDocument = parentDocument;
	this.data = ve.isArray( data ) ? data : [];
	// Sparse array containing the metadata for each offset
	// Each element is either undefined, or an array of metadata elements
	// Because the indexes in the metadata array represent offsets in the data array, the
	// metadata array has one element more than the data array.
	this.metadata = new Array( this.data.length + 1 );

	// Initialization
	/*
	 * Build a tree of nodes and nodes that will be added to them after a full scan is complete,
	 * then from the bottom up add nodes to their potential parents. This avoids massive length
	 * updates being broadcast upstream constantly while building is underway.
	 */
	var i, node, children, meta,
		doc = parentDocument || this,
		root = doc.getDocumentNode(),
		textLength = 0,
		inTextNode = false,
		// Stack of stacks, each containing a
		stack = [[this.documentNode], []],
		currentStack = stack[1],
		parentStack = stack[0],
		currentNode = this.documentNode;
	this.insertAnnotations = new ve.AnnotationSet();
	this.documentNode.setDocument( doc );
	this.documentNode.setRoot( root );
	for ( i = 0; i < this.data.length; i++ ) {
		// Infer that if an item in the linear model has a type attribute than it must be an element
		if ( this.data[i].type === undefined ) {
			// Text node opening
			if ( !inTextNode ) {
				// Create a lengthless text node
				node = new ve.dm.TextNode();
				// Set the root pointer now, to prevent cascading updates
				node.setRoot( root );
				// Put the node on the current inner stack
				currentStack.push( node );
				currentNode = node;
				// Set a flag saying we're inside a text node
				inTextNode = true;
			}
			// Track the length
			textLength++;
		} else {
			if ( this.data[i].type === 'metaInline' || this.data[i].type === 'metaBlock' ) {
				// Metadata
				// Splice the meta element and its closing out of the linmod
				meta = this.data[i];
				this.spliceData( i, 2 );
				// Put the metadata in the meta-linmod
				if ( !this.metadata[i] ) {
					this.metadata[i] = [];
				}
				this.metadata[i].push( meta );
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
			if ( this.data[i].type.charAt( 0 ) !== '/' ) {
				// Branch or leaf node opening
				// Create a childless node
				node = ve.dm.nodeFactory.create( this.data[i].type, [],
					this.data[i].attributes
				);
				// Set the root pointer now, to prevent cascading updates
				node.setRoot( root );
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

					if ( children.length === 0 &&
						ve.dm.nodeFactory.canNodeContainContent(
							currentNode.getType()
						)
					) {
						// Content nodes cannot be childless, add a zero-length text node
						children.push( new ve.dm.TextNode( 0 ) );
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
	// The end state is stack = [ [this.documentNode] [ array, of, its, children ] ]
	// so attach all nodes in stack[1] to the root node
	ve.batchSplice( this.documentNode, 0, 0, stack[1] );
};

/* Inheritance */

ve.inheritClass( ve.dm.Document, ve.Document );

/* Static methods */

/**
 * Applies annotations to content data.
 *
 * This method modifies data in place.
 *
 * @method
 * @param {Array} data Data to remove annotations from
 * @param {ve.AnnotationSet} annotationSet Annotations to apply
 */
ve.dm.Document.addAnnotationsToData = function ( data, annotationSet ) {
	// Apply annotations to data
	for ( var i = 0; i < data.length; i++ ) {
		if ( !ve.isArray( data[i] ) ) {
			data[i] = [data[i], new ve.AnnotationSet()];
		}
		data[i][1].addSet( annotationSet );
	}
};

/**
 * Checks if content can be inserted at an offset in document data.
 *
 * This method assumes that any value that has a type property that's a string is an element object.
 *
 * @example Content offsets:
 *      <heading> a </heading> <paragraph> b c <img> </img> </paragraph>
 *     .         ^ ^          .           ^ ^ ^     .      ^            .
 *
 * @example Content offsets:
 *      <list> <listItem> </listItem> <list>
 *     .      .          .           .      .
 *
 * @static
 * @method
 * @param {Array} data Document data
 * @param {Number} offset Document offset
 * @returns {Boolean} Content can be inserted at offset
 */
ve.dm.Document.isContentOffset = function ( data, offset ) {
	// Edges are never content
	if ( offset === 0 || offset === data.length ) {
		return false;
	}
	var left = data[offset - 1],
		right = data[offset],
		factory = ve.dm.nodeFactory;
	return (
		// Data exists at offsets
		( left !== undefined && right !== undefined ) &&
		(
			// If there's content on the left or the right of the offset than we are good
			// <paragraph>|a|</paragraph>
			( typeof left === 'string' || typeof right === 'string' ) ||
			// Same checks but for annotated characters - isArray is slower, try it next
			( ve.isArray( left ) || ve.isArray( right ) ) ||
			// The most expensive test are last, these deal with elements
			(
				// Right of a leaf
				// <paragraph><image></image>|</paragraph>
				(
					// Is an element
					typeof left.type === 'string' &&
					// Is a closing
					left.type.charAt( 0 ) === '/' &&
					// Is a leaf
					factory.isNodeContent( left.type.substr( 1 ) )
				) ||
				// Left of a leaf
				// <paragraph>|<image></image></paragraph>
				(
					// Is an element
					typeof right.type === 'string' &&
					// Is not a closing
					right.type.charAt( 0 ) !== '/' &&
					// Is a leaf
					factory.isNodeContent( right.type )
				) ||
				// Inside empty content branch
				// <paragraph>|</paragraph>
				(
					// Inside empty element
					'/' + left.type === right.type &&
					// Both are content branches (right is the same type)
					factory.canNodeContainContent( left.type )
				)
			)
		)
	);
};

/**
 * Checks if structure can be inserted at an offset in document data.
 *
 * If the {unrestricted} param is true than only offsets where any kind of element can be inserted
 * will return true. This can be used to detect the difference between a location that a paragraph
 * can be inserted, such as between two tables but not direclty inside a table.
 *
 * This method assumes that any value that has a type property that's a string is an element object.
 *
 * @example Structural offsets (unrestricted = false):
 *      <heading> a </heading> <paragraph> b c <img> </img> </paragraph>
 *     ^         . .          ^           . . .     .      .            ^
 *
 * @example Structural offsets (unrestricted = true):
 *      <heading> a </heading> <paragraph> b c <img> </img> </paragraph>
 *     ^         . .          ^           . . .     .      .            ^
 *
 * @example Structural offsets (unrestricted = false):
 *      <list> <listItem> </listItem> <list>
 *     ^      ^          ^           ^      ^
 *
 * @example Content branch offsets (unrestricted = true):
 *      <list> <listItem> </listItem> <list>
 *     ^      .          ^           .      ^
 *
 * @static
 * @method
 * @param {Array} data Document data
 * @param {Number} offset Document offset
 * @param {Boolean} [unrestricted] Only return true if any kind of element can be inserted at offset
 * @returns {Boolean} Structure can be inserted at offset
 */
ve.dm.Document.isStructuralOffset = function ( data, offset, unrestricted ) {
	// Edges are always structural
	if ( offset === 0 || offset === data.length ) {
		return true;
	}
	// Offsets must be within range and both sides must be elements
	var left = data[offset - 1],
		right = data[offset],
		factory = ve.dm.nodeFactory;
	return (
		(
			left !== undefined &&
			right !== undefined &&
			typeof left.type === 'string' &&
			typeof right.type === 'string'
		) &&
		(
			// Right of a branch
			// <list><listItem><paragraph>a</paragraph>|</listItem>|</list>|
			(
				// Is a closing
				left.type.charAt( 0 ) === '/' &&
				// Is a branch or non-content leaf
				(
					factory.canNodeHaveChildren( left.type.substr( 1 ) ) ||
					!factory.isNodeContent( left.type.substr( 1 ) )
				) &&
				(
					// Only apply this rule in unrestricted mode
					!unrestricted ||
					// Right of an unrestricted branch
					// <list><listItem><paragraph>a</paragraph>|</listItem></list>|
					// Both are non-content branches that can have any kind of child
					factory.getParentNodeTypes( left.type.substr( 1 ) ) === null
				)
			) ||
			// Left of a branch
			// |<list>|<listItem>|<paragraph>a</paragraph></listItem></list>
			(
				// Is not a closing
				right.type.charAt( 0 ) !== '/' &&
				// Is a branch or non-content leaf
				(
					factory.canNodeHaveChildren( right.type ) ||
					!factory.isNodeContent( right.type )
				) &&
				(
					// Only apply this rule in unrestricted mode
					!unrestricted ||
					// Left of an unrestricted branch
					// |<list><listItem>|<paragraph>a</paragraph></listItem></list>
					// Both are non-content branches that can have any kind of child
					factory.getParentNodeTypes( right.type ) === null
				)
			) ||
			// Inside empty non-content branch
			// <list>|</list> or <list><listItem>|</listItem></list>
			(
				// Inside empty element
				'/' + left.type === right.type &&
				// Both are non-content branches (right is the same type)
				factory.canNodeHaveGrandchildren( left.type ) &&
				(
					// Only apply this rule in unrestricted mode
					!unrestricted ||
					// Both are non-content branches that can have any kind of child
					factory.getChildNodeTypes( left.type ) === null
				)
			)
		)
	);
};

/**
 * Checks if a data at a given offset is an element.
 *
 * This method assumes that any value that has a type property that's a string is an element object.
 *
 * @example Element data:
 *      <heading> a </heading> <paragraph> b c <img></img> </paragraph>
 *     ^         . ^          ^           . . ^     ^     ^            .
 *
 * @static
 * @method
 * @param {Array} data Document data
 * @param {Number} offset Document offset
 * @returns {Boolean} Data at offset is an element
 */
ve.dm.Document.isElementData = function ( data, offset ) {
	// Data exists at offset and appears to be an element
	return data[offset] !== undefined && typeof data[offset].type === 'string';
};

/**
 * Checks for elements in document data.
 *
 * This method assumes that any value that has a type property that's a string is an element object.
 * Elements are discovered by iterating through the entire data array (backwards).
 *
 * @static
 * @method
 * @param {Array} data Document data
 * @returns {Boolean} At least one elements exists in data
 */
ve.dm.Document.containsElementData = function ( data ) {
	var i = data.length;
	while ( i-- ) {
		if ( data[i].type !== undefined ) {
			return true;
		}
	}
	return false;
};

/**
 * Checks for non-content elements in document data.
 *
 * This method assumes that any value that has a type property that's a string is an element object.
 * Elements are discovered by iterating through the entire data array.
 *
 * @static
 * @method
 * @param {Array} data Document data
 * @returns {Boolean} True if all elements in data are content elements
 */
ve.dm.Document.isContentData = function ( data ) {
	for ( var i = 0, len = data.length; i < len; i++ ) {
		if ( data[i].type !== undefined &&
			data[i].type.charAt( 0 ) !== '/' &&
			!ve.dm.nodeFactory.isNodeContent( data[i].type )
		) {
			return false;
		}
	}
	return true;
};

/* Methods */

/**
 * Reverses a transaction's effects on the content data.
 *
 * @method
 * @param {ve.dm.Transaction}
 */
ve.dm.Document.prototype.rollback = function ( transaction ) {
	ve.dm.TransactionProcessor.rollback( this, transaction );
};

/**
 * Commits a transaction's effects on the content data.
 *
 * @method
 * @param {ve.dm.Transaction}
 */
ve.dm.Document.prototype.commit = function ( transaction ) {
	ve.dm.TransactionProcessor.commit( this, transaction );
};

/**
 * Gets slice or copy of the document data.
 *
 * @method
 * @param {ve.Range} [range] Range of data to get, all data will be given by default
 * @param {Boolean} [deep=false] Whether to return a deep copy (WARNING! This may be very slow)
 * @returns {Array} Slice or copy of document data
 */
ve.dm.Document.prototype.getData = function ( range, deep ) {
	var end, data,
		start = 0;
	if ( range !== undefined ) {
		range.normalize();
		start = Math.max( 0, Math.min( this.data.length, range.start ) );
		end = Math.max( 0, Math.min( this.data.length, range.end ) );
	}
	// IE work-around: arr.slice( 0, undefined ) returns [] while arr.slice( 0 ) behaves correctly
	data = end === undefined ? this.data.slice( start ) : this.data.slice( start, end );
	// Return either the slice or a deep copy of the slice
	return deep ? ve.copyArray( data ) : data;
};

/**
 * Gets the length of the document.
 *
 * @method
 * @returns {Number} Document data length
 */
ve.dm.Document.prototype.getLength = function () {
	return this.data.length;
};

/**
 * Splice data into or out of the linear model and update this.metadata accordingly.
 *
 * Always use this function, never use this.data.splice() directly, otherwise the linear model
 * (this.data) and the meta-linmod (this.metadata) can get out of sync. The semantics of the
 * parameters are identical to those of ve.batchSplice()
 *
 * @method
 * @see {ve.batchSplice}
 */
ve.dm.Document.prototype.spliceData = function ( offset, remove, insert ) {
	var spliced, reaped, reapedFlat, i;
	insert = insert || [];
	spliced = ve.batchSplice( this.data, offset, remove, insert );
	reaped = ve.batchSplice( this.metadata, offset, remove, new Array( insert.length ) );
	// reaped will be an array of arrays, flatten it
	reapedFlat = [];
	for ( i = 0; i < reaped.length; i++ ) {
		if ( reaped[i] !== undefined ) {
			reapedFlat = reapedFlat.concat( reaped[i] );
		}
	}
	// Add reaped metadata to the metadata that is now at offset (and used to be immediately
	// after the removed data). Add it to the front, because it came from something that was
	// before it.
	if ( reapedFlat.length > 0 ) {
		this.metadata[offset] = reapedFlat.concat( this.metadata[offset] || [] );
	}
	return spliced;
};

/**
 * Get the full data, with the metadata spliced back in.
 * @returns {Array} Data with metadata interleaved
 */
ve.dm.Document.prototype.getFullData = function () {
	var result = [], i, j, len = this.data.length;
	for ( i = 0; i <= len; i++ ) {
		if ( this.metadata[i] ) {
			for ( j = 0; j < this.metadata[i].length; j++ ) {
				result.push( this.metadata[i][j] );
				result.push( { 'type': '/' + this.metadata[i][j].type } );
			}
		}
		if ( i < len ) {
			result.push( this.data[i] );
		}
	}
	return result;
};

ve.dm.Document.prototype.getNodeFromOffset = function ( offset ) {
	// FIXME duplicated from ve.ce.Document
	if ( offset < 0 || offset > this.data.length ) {
		throw new Error( 've.dm.Document.getNodeFromOffset(): offset ' + offset + ' is out of bounds' );
	}
	var node = this.documentNode.getNodeFromOffset( offset );
	if ( !node.canHaveChildren() ) {
		node = node.getParent();
	}
	return node;
};

/**
 * Gets the content data of a node.
 *
 * @method
 * @param {ve.dm.Node} node Node to get content data for
 * @returns {Array|null} List of content and elements inside node or null if node is not found
 */
ve.dm.Document.prototype.getDataFromNode = function ( node ) {
	var length = node.getLength(),
		offset = this.documentNode.getOffsetFromNode( node );
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
 * Returns plain text from a selected range.
 *
 * @method
 * @param {ve.Range} [range] Range of data to get the text of.
 * @returns {String|''} Selected text or an empty string.
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
 * Gets a list of annotations that a given offset is covered by.
 *
 * This method returns a clone of the AnnotationSet in the linear model.
 *
 * @method
 * @param {Number} offset Offset to get annotations for
 * @returns {ve.AnnotationSet} A set of all annotation objects offset is covered by
 */
ve.dm.Document.prototype.getAnnotationsFromOffset = function ( offset ) {
	if ( offset < 0 || offset > this.data.length ) {
		throw new Error( 've.dm.Document.getAnnotationsFromOffset: offset ' + offset + ' out of bounds' );
	}
	// Since annotations are not stored on a closing leaf node,
	// rewind offset by 1 to return annotations for that structure
	var set;
	if (
		ve.isPlainObject( this.data[offset] ) && // structural offset
		this.data[offset].hasOwnProperty( 'type' ) && // just in case
		this.data[offset].type.charAt( 0 ) === '/' && // closing offset
		ve.dm.nodeFactory.canNodeHaveChildren(
			this.data[offset].type.substr( 1 )
		) === false // leaf node
	) {
		offset = this.getRelativeContentOffset( offset, -1 );
	}

	set = this.data[offset].annotations || this.data[offset][1];
	return set ? set.clone() : new ve.AnnotationSet();
};

/**
 * Does this offset contain the specified annotation
 *
 * @method
 * @param {Number} offset Offset to look at
 * @param {Object} annotation Object to look for
 * @returns {Boolean} Whether an offset contains the specified annotation
 */
ve.dm.Document.prototype.offsetContainsAnnotation = function ( offset, annotation ) {
	// TODO inline this
	return this.getAnnotationsFromOffset( offset ).contains( annotation );
};

/**
 * Gets the range of content surrounding a given offset that's covered by a given annotation.
 *
 * @param {Number} offset Offset to begin looking forward and backward from
 * @param {Object} annotation Annotation to test for coverage with
 * @returns {ve.Range|null} Range of content covered by annotation, or null if offset is not covered
 */
ve.dm.Document.prototype.getAnnotatedRangeFromOffset = function ( offset, annotation ) {
	var start = offset,
		end = offset;
	if ( this.offsetContainsAnnotation( offset, annotation ) === false ) {
		return null;
	}
	while ( start > 0 ) {
		start--;
		if ( this.offsetContainsAnnotation( start, annotation ) === false ) {
			start++;
			break;
		}
	}
	while ( end < this.data.length ) {
		if ( this.offsetContainsAnnotation( end, annotation ) === false ) {
			break;
		}
		end++;
	}
	return new ve.Range( start, end );
};

/**
 * Gets the range of an annotation found in the selection range.
 *
 * @param {Number} offset Offset to begin looking forward and backward from
 * @param {Object} annotation Annotation to test for coverage with
 * @returns {ve.Range|null} Range of content covered by annotation, or a copy of the range.
 */
ve.dm.Document.prototype.getAnnotatedRangeFromSelection = function ( range, annotation ) {
	var start = range.start,
		end = range.end;
	while ( start > 0 ) {
		start--;
		if ( this.offsetContainsAnnotation( start, annotation ) === false ) {
			start++;
			break;
		}
	}
	while ( end < this.data.length ) {
		if ( this.offsetContainsAnnotation( end, annotation ) === false ) {
			break;
		}
		end++;
	}
	return new ve.Range( start, end );
};

/**
 * Gets an array of common annotations across a range.
 *
 * @method
 * @param {ve.Range} range Range to get annotations for
 * @param {Boolean} [all] Get all annotations found within the range, not just those that cover it
 * @returns {ve.AnnotationSet} All annotation objects range is covered by
 */
ve.dm.Document.prototype.getAnnotationsFromRange = function ( range, all ) {
	var i,
		left,
		right;
	range.normalize();
	// Look at left side of range for annotations
	left = this.getAnnotationsFromOffset( range.start );
	// Shortcut for single character and zero-length ranges
	if ( range.getLength() === 0 || range.getLength() === 1 ) {
		return left;
	}
	// Iterator over the range, looking for annotations, starting at the 2nd character
	for ( i = range.start + 1; i < range.end; i++ ) {
		// Skip non character data
		if ( ve.dm.Document.isElementData( this.data, i ) ) {
			continue;
		}
		// Current character annotations
		right = this.getAnnotationsFromOffset( i );
		if ( all && !right.isEmpty() ) {
			left.addSet( right );
		} else if ( !all ) {
			// A non annotated character indicates there's no full coverage
			if ( right.isEmpty() ) {
				return new ve.AnnotationSet();
			}
			// Exclude annotations that are in left but not right
			left.removeNotInSet( right );
			// If we've reduced left down to nothing, just stop looking
			if ( left.isEmpty() ) {
				break;
			}
		}
	}
	return left;
};

/**
 * Returns ve.Range free of outer whitespace.
 *
 * @method
 * @param {ve.Range} [range] Range of data to get, all data will be given by default
 * @returns {Object} A new range if modified, otherwise returns passed range.
 */
ve.dm.Document.prototype.trimOuterSpaceFromRange = function ( range ) {
	range.normalize();
	var start = range.start,
		end = range.end;
	while ( this.data[start] === ' ' ) {
		start++;
	}
	while ( this.data[end - 1] === ' ' ) {
		end--;
	}
	return range.to < range.end ? new ve.Range( end, start ) : new ve.Range( start, end );
};

/**
 * Rebuild one or more nodes following a change in linear model data.
 *
 * The data provided to this method may contain either one node or multiple sibling nodes, but it
 * must be balanced and valid. Data provided to this method also may not contain any content at the
 * top level. The tree is updated during this operation.
 *
 * Process:
 *  1. Nodes between {index} and {index} + {numNodes} in {parent} will be removed
 *  2. Data will be retrieved from this.data using {offset} and {newLength}
 *  3. A document fragment will be generated from the retrieved data
 *  4. The document fragment's nodes will be inserted into {parent} at {index}
 *
 * Use cases:
 *  1. Rebuild old nodes and offset data after a change to the linear model.
 *  2. Insert new nodes and offset data after a insertion in the linear model.
 *
 * @param {ve.dm.Node} parent Parent of the node(s) being rebuilt
 * @param {Number} index Index within parent to rebuild or insert nodes
 *  - If {numNodes} == 0: Index to insert nodes at
 *  - If {numNodes} >= 1: Index of first node to rebuild
 * @param {Number} numNodes Total number of nodes to rebuild
 *  - If {numNodes} == 0: Nothing will be rebuilt, but the node(s) built from data will be
 *    inserted before {index}. To insert nodes at the end, use number of children in 'parent'
 *  - If {numNodes} == 1: Only the node at {index} will be rebuilt
 *  - If {numNodes} > 1: The node at {index} and the next {numNodes-1} nodes will be rebuilt
 * @param {Number} offset Linear model offset to rebuild from
 * @param {Number} newLength Length of data in linear model to rebuild or insert nodes for
 * @returns {ve.dm.Node[]} Array containing the rebuilt/inserted nodes
 */
ve.dm.Document.prototype.rebuildNodes = function ( parent, index, numNodes, offset, newLength ) {
	var // Get a slice of the document where it's been changed
		data = this.data.slice( offset, offset + newLength ),
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
 * Gets an offset a given distance from another using a callback to check if offsets are valid.
 *
 * - If {offset} is not already valid, one step will be used to move it to an valid one.
 * - If {distance} is zero the result will either be {offset} if it's already valid or the
 *   nearest valid offset to the right if possible and to the left otherwise.
 * - If {offset} is after the last valid offset and {distance} is >= 1, or if {offset} if
 *   before the first valid offset and {distance} <= 1 than the result will be the nearest
 *   valid offset in the opposite direction.
 * - If the document does not contain a single valid offset the result will be -1
 *
 * @method
 * @param {Number} offset Offset to start from
 * @param {Number} distance Number of valid offsets to move
 * @param {Function} callback Function to call to check if an offset is valid which will be
 * given two intital arguments of data and offset
 * @param {Mixed} [...] Additional arguments to pass to the callback
 * @returns {Number} Relative valid offset or -1 if there are no valid offsets in document
 */
ve.dm.Document.prototype.getRelativeOffset = function ( offset, distance, callback ) {
	var i, direction,
		args = Array.prototype.slice.call( arguments, 3 ),
		start = offset,
		steps = 0,
		turnedAround = false;
	// If offset is already a structural offset and distance is zero than no further work is needed,
	// otherwise distance should be 1 so that we can get out of the invalid starting offset
	if ( distance === 0 ) {
		if ( callback.apply( window, [this.data, offset].concat( args ) ) ) {
			return offset;
		} else {
			distance = 1;
		}
	}
	// Initial values
	direction = (
		offset <= 0 ? 1 : (
			offset >= this.data.length ? -1 : (
				distance > 0 ? 1 : -1
			)
		)
	);
	distance = Math.abs( distance );
	i = start + direction;
	offset = -1;
	// Iteration
	while ( i >= 0 && i <= this.data.length ) {
		if ( callback.apply( window, [this.data, i].concat( args ) ) ) {
			steps++;
			offset = i;
			if ( distance === steps ) {
				return offset;
			}
		} else if (
			// Don't keep turning around over and over
			!turnedAround &&
			// Only turn around if not a single step could be taken
			steps === 0 &&
			// Only turn around if we're about to reach the edge
			( ( direction < 0 && i === 0 ) || ( direction > 0 && i === this.data.length ) )
		) {
			// Start over going in the opposite direction
			direction *= -1;
			i = start;
			distance = 1;
			turnedAround = true;
		}
		i += direction;
	}
	return offset;
};

/**
 * Gets a content offset a given distance forwards or backwards from another.
 *
 * This method is a wrapper around {getRelativeOffset}, using {ve.dm.Document.isContentOffset} as
 * the offset validation callback.
 *
 * @method
 * @param {Number} offset Offset to start from
 * @param {Number} distance Number of content offsets to move
 * @returns {Number} Relative content offset or -1 if there are no valid offsets in document
 */
ve.dm.Document.prototype.getRelativeContentOffset = function ( offset, distance ) {
	return this.getRelativeOffset( offset, distance, ve.dm.Document.isContentOffset );
};

/**
 * Gets the nearest content offset to a given offset.
 *
 * If the offset is already a valid offset, it will be returned unchanged. This method differs from
 * calling {getRelativeContentOffset} with a zero length differece because the direction can be
 * controlled without nessecarily moving the offset if it's already valid. Also, if the direction
 * is 0 or undefined than nearest offsets will be found to the left and right and the one with the
 * shortest distance will be used.
 *
 * This method is a wrapper around {getRelativeOffset}, using {ve.dm.Document.isContentOffset} as
 * the offset validation callback.
 *
 * @method
 * @param {Number} offset Offset to start from
 * @param {Number} [direction] Direction to prefer matching offset in, -1 for left and 1 for right
 * @returns {Number} Nearest content offset or -1 if there are no valid offsets in document
 */
ve.dm.Document.prototype.getNearestContentOffset = function ( offset, direction ) {
	if ( ve.dm.Document.isContentOffset( this.data, offset ) ) {
		return offset;
	}
	if ( direction === undefined ) {
		var left = this.getRelativeOffset( offset, -1, ve.dm.Document.isContentOffset ),
			right = this.getRelativeOffset( offset, 1, ve.dm.Document.isContentOffset );
		return offset - left < right - offset ? left : right;
	} else {
		return this.getRelativeOffset(
			offset, direction > 0 ? 1 : -1, ve.dm.Document.isContentOffset
		);
	}
};

/**
 * Gets a structural offset a given distance forwards or backwards from another.
 *
 * This method is a wrapper around {getRelativeOffset}, using {ve.dm.Document.isStructuralOffset} as
 * the offset validation callback.
 *
 * @method
 * @param {Number} offset Offset to start from
 * @param {Number} distance Number of structural offsets to move
 * @param {Boolean} [unrestricted] Only return true if any kind of element can be inserted at offset
 * @returns {Number} Relative structural offset
 */
ve.dm.Document.prototype.getRelativeStructuralOffset = function ( offset, distance, unrestricted ) {
	// Optimization: start and end are always unrestricted structural offsets
	if ( distance === 0 && ( offset === 0 || offset === this.data.length ) ) {
		return offset;
	}
	return this.getRelativeOffset(
		offset, distance, ve.dm.Document.isStructuralOffset, unrestricted
	);
};

/**
 * Gets the nearest structural offset to a given offset.
 *
 * If the offset is already a valid offset, it will be returned unchanged. This method differs from
 * calling {getRelativeStructuralOffset} with a zero length differece because the direction can be
 * controlled without nessecarily moving the offset if it's already valid. Also, if the direction
 * is 0 or undefined than nearest offsets will be found to the left and right and the one with the
 * shortest distance will be used.
 *
 * This method is a wrapper around {getRelativeOffset}, using {ve.dm.Document.isStructuralOffset} as
 * the offset validation callback.
 *
 * @method
 * @param {Number} offset Offset to start from
 * @param {Number} [direction] Direction to prefer matching offset in, -1 for left and 1 for right
 * @param {Boolean} [unrestricted] Only return true if any kind of element can be inserted at offset
 * @returns {Number} Nearest structural offset
 */
ve.dm.Document.prototype.getNearestStructuralOffset = function ( offset, direction, unrestricted ) {
	if ( ve.dm.Document.isStructuralOffset( this.data, offset, unrestricted ) ) {
		return offset;
	}
	if ( !direction ) {
		var left = this.getRelativeOffset(
				offset, -1, ve.dm.Document.isStructuralOffset, unrestricted
			),
			right = this.getRelativeOffset(
				offset, 1, ve.dm.Document.isStructuralOffset, unrestricted
			);
		return offset - left < right - offset ? left : right;
	} else {
		return this.getRelativeOffset(
			offset, direction > 0 ? 1 : -1, ve.dm.Document.isStructuralOffset, unrestricted
		);
	}
};

// TODO this function needs more work but it seems to work, mostly
/**
 * Fix up data so it can safely be inserted into the linear model at offset.
 * @param {Array} data Snippet of linear model data to insert
 * @param {Number} offset Offset in the linear model where the caller wants to insert data
 * @returns {Array} A (possibly modified) copy of data
 */
ve.dm.Document.prototype.fixupInsertion = function ( data, offset ) {
	var
		// Array where we build the return value
		newData = [],

		// *** Stacks ***
		// Array of element openings (object). Openings in data are pushed onto this stack
		// when they are encountered and popped off when they are closed
		openingStack = [],
		// Array of node objects. Closings in data that close nodes that were
		// not opened in data (i.e. were already in the document) are pushed onto this stack
		// and popped off when balanced out by an opening in data
		closingStack = [],
		// Array of objects describing wrappers that need to be fixed up when a given
		// element is closed.
		//     'expectedType': closing type that triggers this fixup. Includes initial '/'
		//     'openings': array of opening elements that should be closed (in reverse order)
		//     'reopenElements': array of opening elements to insert (in reverse order)
		fixupStack = [],

		// *** State persisting across iterations of the outer loop ***
		// The node (from the document) we're currently in. When in a node that was opened
		// in data, this is set to its first ancestor that is already in the document
		parentNode,
		// The type of the node we're currently in, even if that node was opened within data
		parentType,
		// Whether we are currently in a text node
		inTextNode,

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
	 * @param {Object|Array|String} element Linear model element
	 * @param {Number} index Index in data that this element came from (for error reporting only)
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
					if ( element.type !== '/' + expectedType ) {
						throw new Error( 'Type mismatch, expected /' + expectedType +
							' but got ' + element.type + ' (at index ' + index + ')' );
					}
				}
			}
		}
		newData.push( element );
	}

	parentNode = this.getNodeFromOffset( offset );
	parentType = parentNode.getType();
	inTextNode = false;
	for ( i = 0; i < data.length; i++ ) {
		if ( inTextNode && data[i].type !== undefined ) {
			// We're leaving a text node, process fixupStack if needed
			// TODO duplicated code
			if (
				fixupStack.length > 0 &&
				fixupStack[fixupStack.length - 1].expectedType === '/text'
			) {
				popped = fixupStack.pop();
				// Go through these in reverse!
				for ( j = popped.openings.length - 1; j >= 0; j-- ) {
					writeElement( { 'type': '/' + popped.openings[j].type }, i );
				}
				for ( j = popped.reopenElements.length - 1; j >= 0; j-- ) {
					writeElement( popped.reopenElements[j], i );
				}
			}
			parentType = openingStack.length > 0 ?
				openingStack[openingStack.length - 1] : parentNode.getType();
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
				openings.unshift ( { 'type': 'paragraph' } );
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
					openings.unshift( { 'type': childType } );
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
					// Close the parent and try one level up
					closings.push( { 'type': '/' + parentType } );
					if ( openingStack.length > 0 ) {
						popped = openingStack.pop();
						parentType = popped.type;
						reopenElements.push( ve.copyObject( popped ) );
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
					fixupStack.push( {
						'expectedType': '/text',
						'openings': openings,
						'reopenElements': reopenElements
					} );
				}
				// If we didn't wrap the text node, then the node we're inserting into can have
				// content, so we couldn't have closed anything
			} else {
				fixupStack.push( {
					'expectedType': '/' + data[i].type,
					'openings': openings,
					'reopenElements': reopenElements
				} );
				parentType = data[i].type;
			}
		} else {
			// Closing
			writeElement( data[i], i );
			// TODO don't close fixup stuff if the next thing immediately needs to be fixed up as
			// well; instead, merge the two wrappers
			if (
				fixupStack.length > 0 &&
				fixupStack[fixupStack.length - 1].expectedType === data[i].type
			) {
				popped = fixupStack.pop();
				// Go through these in reverse!
				for ( j = popped.openings.length - 1; j >= 0; j-- ) {
					writeElement( { 'type': '/' + popped.openings[j].type }, i );
				}
				for ( j = popped.reopenElements.length - 1; j >= 0; j-- ) {
					writeElement( popped.reopenElements[j], i );
				}
			}
			parentType = openingStack.length > 0 ?
				openingStack[openingStack.length - 1] : parentNode.getType();
		}
	}

	if ( inTextNode ) {
		// We're leaving a text node, process fixupStack if needed
		// TODO duplicated code
		if (
			fixupStack.length > 0 &&
			fixupStack[fixupStack.length - 1].expectedType === '/text'
		) {
			popped = fixupStack.pop();
			// Go through these in reverse!
			for ( j = popped.openings.length - 1; j >= 0; j-- ) {
				writeElement( { 'type': '/' + popped.openings[j].type }, i );
			}
			for ( j = popped.reopenElements.length - 1; j >= 0; j-- ) {
				writeElement( popped.reopenElements[j], i );
			}
		}
		parentType = openingStack.length > 0 ?
			openingStack[openingStack.length - 1] : parentNode.getType();
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
		writeElement( { 'type': popped.getType() }, i );
	}

	return newData;
};

/**
 * Get the linear model data for the given range, but fix up unopened closings and unclosed openings
 * in the data snippet such that the returned snippet is balanced.
 *
 * @returns {Array} Balanced snippet of linear model data
 */
ve.dm.Document.prototype.getBalancedData = function ( range ) {
	var first, last, firstNode, lastNode,
		node = this.getNodeFromOffset( range.start ),
		selection = this.selectNodes( range, 'siblings' ),
		addOpenings = [],
		addClosings = [];
	if ( selection.length === 0 ) {
		return [];
	}
	if ( selection.length === 1 && selection[0].range.equals( range ) ) {
		// Nothing to fix up
		return this.data.slice( range.start, range.end );
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

	return addOpenings.reverse()
		.concat( this.data.slice( range.start, range.end ) )
		.concat( addClosings );
};
