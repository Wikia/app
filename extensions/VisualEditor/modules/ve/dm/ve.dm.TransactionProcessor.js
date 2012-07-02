/**
 * Creates an ve.dm.TransactionProcessor object.
 * 
 * @class
 * @constructor
 */
ve.dm.TransactionProcessor = function( model, transaction ) {
	this.model = model;
	this.transaction = transaction;
	this.cursor = 0;
	this.set = [];
	this.clear = [];
};

/* Static Members */

ve.dm.TransactionProcessor.operationMap = {
	// Retain
	'retain': {
		'commit': function( op ) {
			this.retain( op );
		},
		'rollback': function( op ) {
			this.retain( op );
		}
	},
	// Insert
	'insert': {
		'commit': function( op ) {
			this.insert( op );
		},
		'rollback': function( op ) {
			this.remove( op );
		}
	},
	// Remove
	'remove': {
		'commit': function( op ) {
			this.remove( op );
		},
		'rollback': function( op ) {
			this.insert( op );
		}
	},
	// Change element attributes
	'attribute': {
		'commit': function( op ) {
			this.attribute( op, false );
		},
		'rollback': function( op ) {
			this.attribute( op, true );
		}
	},
	// Change content annotations
	'annotate': {
		'commit': function( op ) {
			this.mark( op, false );
		},
		'rollback': function( op ) {
			this.mark( op, true );
		}
	}
};

/* Static Methods */

ve.dm.TransactionProcessor.commit = function( doc, transaction ) {
	var tp = new ve.dm.TransactionProcessor( doc, transaction );
	tp.process( 'commit' );
};

ve.dm.TransactionProcessor.rollback = function( doc, transaction ) {
	var tp = new ve.dm.TransactionProcessor( doc, transaction );
	tp.process( 'rollback' );
};

/* Methods */

ve.dm.TransactionProcessor.prototype.process = function( method ) {
	var operations = this.transaction.getOperations();
	for ( var i = 0, length = operations.length; i < length; i++ ) {
		var operation = operations[i];
		if ( operation.type in ve.dm.TransactionProcessor.operationMap ) {
			ve.dm.TransactionProcessor.operationMap[operation.type][method].call( this, operation );
		} else {
			throw 'Invalid operation error. Operation type is not supported: ' + operation.type;
		}
	}
};

// TODO: document this. Various arguments are optional or nonoptional in different cases, that's
// confusing so it needs to be documented well.
ve.dm.TransactionProcessor.prototype.rebuildNodes = function( newData, oldNodes, parent, index ) {
	var newNodes = ve.dm.DocumentNode.createNodesFromData( newData ),
		remove = 0;
	if ( oldNodes ) {
		// Determine parent and index if not given
		if ( oldNodes[0] === oldNodes[0].getRoot() ) {
			// We know the values for parent and index in this case
			// and don't have to compute them. Override any parent
			// or index parameter passed.
			parent = oldNodes[0];
			index = 0;
			remove = parent.getChildren().length;
		} else {
			parent = parent || oldNodes[0].getParent();
			index = index || parent.indexOf( oldNodes[0] );
			remove = oldNodes.length;
		}
		// Try to preserve the first node
		if (
			// There must be an old and new node to preserve
			newNodes.length &&
			oldNodes.length &&
			// Node types need to match
			newNodes[0].type === oldNodes[0].type &&
			// Only for leaf nodes
			!newNodes[0].hasChildren()
		) {
			var newNode = newNodes.shift(),
				oldNode = oldNodes.shift();
			// Let's just leave this first node in place and adjust it's length
			var newAttributes = newNode.getElement().attributes,
				oldAttributes = oldNode.getElement().attributes;
			if ( oldAttributes || newAttributes ) {
				oldNode.getElement().attributes = newAttributes;
			}
			oldNode.adjustContentLength( newNode.getContentLength() - oldNode.getContentLength() );
			index++;
			remove--;
		}
	}
	// Try to perform this in a single operation if possible, this reduces the number of UI updates
	// TODO: Introduce a global for max argument length - 1024 is also assumed in ve.insertIntoArray
	if ( newNodes.length < 1024 ) {
		parent.splice.apply( parent, [index, remove].concat( newNodes ) );
	} else if ( newNodes.length ) {
		parent.splice.apply( parent, [index, remove] );
		// Safe to call with arbitrary length of newNodes
		ve.insertIntoArray( parent, index, newNodes );
	}
};

/**
 * Get the parent node that would be affected by inserting given data into it's child.
 * 
 * This is used when inserting data that closes and reopens one or more parent nodes into a child
 * node, which requires rebuilding at a higher level.
 * 
 * @method
 * @param {ve.Node} node Child node to start from
 * @param {Array} data Data to inspect for closings
 * @returns {ve.Node} Lowest level parent node being affected
 */
ve.dm.TransactionProcessor.prototype.getScope = function( node, data ) {
	var i,
		length,
		level = 0,
		max = 0;
	for ( i = 0, length = data.length; i < length; i++ ) {
		if ( typeof data[i].type === 'string' ) {
			level += data[i].type.charAt( 0 ) === '/' ? 1 : -1;
			max = Math.max( max, level );
		}
	}
	if ( max > 0 ) {
		for ( i = 0; i < max; i++ ) {
			node = node.getParent() || node;
		}
	}
	return node;
};

ve.dm.TransactionProcessor.prototype.applyAnnotations = function( to, update ) {
	var i,
		j,
		k,
		length,
		annotation,
		changes = 0,
		index;
	// Handle annotations
	if ( this.set.length ) {
		for ( i = 0, length = this.set.length; i < length; i++ ) {
			annotation = this.set[i];
			// Auto-build annotation hash
			if ( annotation.hash === undefined ) {
				annotation.hash = ve.dm.DocumentNode.getHash( annotation );
			}
			for ( j = this.cursor; j < to; j++ ) {
				// Auto-convert to array
				if ( ve.isArray( this.model.data[j] ) ) {
					this.model.data[j].push( annotation );
				} else {
					this.model.data[j] = [this.model.data[j], annotation];
				}
			}
		}
		changes++;
	}
	if ( this.clear.length ) {
		for ( i = 0, length = this.clear.length; i < length; i++ ) {
			annotation = this.clear[i];
			if ( annotation instanceof RegExp ) {
				for ( j = this.cursor; j < to; j++ ) {
					var matches = ve.dm.DocumentNode.getMatchingAnnotations(
						this.model.data[j], annotation
					);
					for ( k = 0; k < matches.length; k++ ) {
						index = this.model.data[j].indexOf( matches[k] );
						if ( index !== -1 ) {
							this.model.data[j].splice( index, 1 );
						}
					}
					// Auto-convert to string
					if ( this.model.data[j].length === 1 ) {
						this.model.data[j] = this.model.data[j][0];
					}
				}
			} else {
				// Auto-build annotation hash
				if ( annotation.hash === undefined ) {
					annotation.hash = ve.dm.DocumentNode.getHash( annotation );
				}
				for ( j = this.cursor; j < to; j++ ) {
					index = ve.dm.DocumentNode.getIndexOfAnnotation(
						this.model.data[j], annotation
					);
					if ( index !== -1 ) {
						this.model.data[j].splice( index, 1 );
					}
					// Auto-convert to string
					if ( this.model.data[j].length === 1 ) {
						this.model.data[j] = this.model.data[j][0];
					}
				}
			}
		}
		changes++;
	}
	if ( update && changes ) {
		var fromNode = this.model.getNodeFromOffset( this.cursor ),
			toNode = this.model.getNodeFromOffset( to );
		this.model.traverseLeafNodes( function( node ) {
			node.emit( 'update' );
			if ( node === toNode ) {
				return false;
			}
		}, fromNode );
	}
};

ve.dm.TransactionProcessor.prototype.retain = function( op ) {
	this.applyAnnotations( this.cursor + op.length, true );
	this.cursor += op.length;
};

ve.dm.TransactionProcessor.prototype.insert = function( op ) {
	var node,
		index,
		offset,
		scope;

	node = this.model.getNodeFromOffset( this.cursor );
	
	// Shortcut 1: we're inserting content. We don't need to bother with any structural stuff
	if ( !ve.dm.DocumentNode.containsElementData( op.data ) ) {
		// TODO should we check whether we're at a structural offset, and throw an exception
		// if that's the case? Or can we assume that the transaction is valid at this point?
		
		// Insert data into linear model
		ve.insertIntoArray( this.model.data, this.cursor, op.data );
		this.applyAnnotations( this.cursor + op.data.length );
		// Update the length of the containing node
		node.adjustContentLength( op.data.length, true );
		node.emit( 'update', this.cursor - offset );
		// Move the cursor
		this.cursor += op.data.length;
		// All done
		return;
	}
	
	// Determine the scope of the inserted data. If the data is an enclosed piece of structure,
	// this will return node. Otherwise, the data closes one or more nodes, and this will return
	// the first ancestor of node that isn't closed, which is the node that will contain the
	// inserted data entirely.
	scope = this.getScope( node, op.data );
	
	// Shortcut 2: we're inserting an enclosed piece of structural data at a structural offset
	// that isn't the end of the document.
	if (
		ve.dm.DocumentNode.isStructuralOffset( this.model.data, this.cursor ) &&
		this.cursor != this.model.data.length &&
		scope == node
	) {
		// We're inserting an enclosed element into something else, so we don't have to rebuild
		// the parent node. Just build a node from the inserted data and stick it in
		ve.insertIntoArray( this.model.data, this.cursor, op.data );
		this.applyAnnotations( this.cursor + op.data.length );
		offset = this.model.getOffsetFromNode( node );
		index = node.getIndexFromOffset( this.cursor - offset );
		this.rebuildNodes( op.data, null, node, index );
	} else {
		// This is the non-shortcut case
		
		// Rebuild scope, which is the node that encloses everything we might have to rebuild
		node = scope;
		offset = this.model.getOffsetFromNode( node );
		if ( offset === -1 ) {
			throw 'Invalid offset error. Node is not in model tree';
		}
		// Perform insert on linear data model
		ve.insertIntoArray( this.model.data, this.cursor, op.data );
		this.applyAnnotations( this.cursor + op.data.length );
		// Synchronize model tree
		this.rebuildNodes(
			this.model.data.slice( offset, offset + node.getElementLength() + op.data.length ),
			[node]
		);
	}
	this.cursor += op.data.length;
};

ve.dm.TransactionProcessor.prototype.remove = function( op ) {
	if ( ve.dm.DocumentNode.containsElementData( op.data ) ) {
		// Figure out which nodes are covered by the removal
		var ranges = this.model.selectNodes(
			new ve.Range( this.cursor, this.cursor + op.data.length )
		);
		
		// Build the list of nodes to rebuild and the data to keep
		var oldNodes = [],
			newData = [],
			parent = null,
			index = null,
			firstKeptNode,
			lastKeptNode,
			i;
		for ( i = 0; i < ranges.length; i++ ) {
			oldNodes.push( ranges[i].node );
			if ( ranges[i].range !== undefined ) {
				// We have to keep part of this node
				if ( firstKeptNode === undefined ) {
					// This is the first node we're keeping
					firstKeptNode = ranges[i].node;
				}
				// Compute the start and end offset of this node
				// We could do that with getOffsetFromNode() but
				// we already have all the numbers we need so why would we
				var	startOffset = ranges[i].globalRange.start - ranges[i].range.start,
					endOffset = startOffset + ranges[i].node.getContentLength(),
					// Get this node's data
					nodeData = this.model.data.slice( startOffset, endOffset );
				// Remove data covered by the range from nodeData
				nodeData.splice(
					ranges[i].range.start, ranges[i].range.end - ranges[i].range.start
				);
				// What remains in nodeData is the data we need to keep
				// Append it to newData
				newData = newData.concat( nodeData );
				
				lastKeptNode = ranges[i].node;
			}
		}
		
		// Surround newData with the right openings and closings if needed
		if ( firstKeptNode !== undefined ) {
			// There are a number of conceptually different cases here,
			// but the algorithm for dealing with them is the same.
			// 1. Removal within one node: firstKeptNode === lastKeptNode
			// 2. Merge of siblings: firstKeptNode.getParent() === lastKeptNode.getParent()
			// 3. Merge of arbitrary depth: firstKeptNode and lastKeptNode have a common ancestor
			// Because #1 and #2 are special cases of #3 (merges with depth=0 and depth=1,
			// respectively), the code below that deals with the general case (#3) and automatically
			// covers #1 and #2 that way as well.
			
			// Simultaneously traverse upwards from firstKeptNode and lastKeptNode
			// to find the common ancestor. On our way up, keep the element of each
			// node we visit and verify that the transaction is a valid merge (i.e. it satisfies
			// the merge criteria in prepareRemoval()'s canMerge()).
			// FIXME: The code is essentially the same as canMerge(), merge these algorithms
			var	openings = [],
				closings = [],
				paths = ve.Node.getCommonAncestorPaths( firstKeptNode, lastKeptNode ),
				prevN1,
				prevN2;
			
			if ( !paths ) {
				throw 'Removal is not a valid merge: ' +
					'nodes do not have a common ancestor or are not at the same depth';
			}
			for ( i = 0; i < paths.node1Path.length; i++ ) { 
				// Verify the element types are equal
				if ( paths.node1Path[i].getElementType() !== paths.node2Path[i].getElementType() ) {
					throw 'Removal is not a valid merge: ' +
						'corresponding parents have different types ( ' +
						paths.node1Path[i].getElementType() + ' vs ' +
						paths.node2Path[i].getElementType() + ' )';
				}
				// Record the opening of n1 and the closing of n2
				openings.push( paths.node1Path[i].getElement() );
				closings.push( { 'type': '/' + paths.node2Path[i].getElementType() } );
			}
			
			// Surround newData with the openings and closings
			newData = openings.reverse().concat( newData, closings );
			
			// Rebuild oldNodes if needed
			// This only happens for merges with depth > 1
			prevN1 = paths.node1Path.length ? paths.node1Path[paths.node1Path.length - 1] : null;
			prevN2 = paths.node2Path.length ? paths.node2Path[paths.node2Path.length - 1] : null;
			if ( prevN1 && prevN1 !== oldNodes[0] ) {
				oldNodes = [ prevN1 ];
				parent = paths.commonAncestor;
				index = parent.indexOf( prevN1 ); // Pass to rebuildNodes() so it's not recomputed
				if ( index === -1 ) {
					throw "Tree corruption detected: node isn't in its parent's children array";
				}
				var foundPrevN2 = false;
				for ( var j = index + 1; !foundPrevN2 && j < parent.getChildren().length; j++ ) {
					oldNodes.push( parent.getChildren()[j] );
					foundPrevN2 = parent.getChildren()[j] === prevN2;
				}
				if ( !foundPrevN2 ) {
					throw "Tree corruption detected: node isn't in its parent's children array";
				}
			}
		}
		
		// Update the linear model
		this.model.data.splice( this.cursor, op.data.length );
		// Perform the rebuild. This updates the model tree
		this.rebuildNodes( newData, oldNodes, parent, index );
	} else {
		// We're removing content only. Take a shortcut
		// Get the node we are removing content from
		var node = this.model.getNodeFromOffset( this.cursor );
		// Update model tree
		node.adjustContentLength( -op.data.length, true );
		// Update the linear model
		this.model.data.splice( this.cursor, op.data.length );
		// Emit an update so things sync up
		var offset = this.model.getOffsetFromNode( node );
		node.emit( 'update', this.cursor - offset );
	}
};

ve.dm.TransactionProcessor.prototype.attribute = function( op, invert ) {
	var element = this.model.data[this.cursor];
	if ( element.type === undefined ) {
		throw 'Invalid element error. Can not set attributes on non-element data.';
	}
	if ( ( op.method === 'set' && !invert ) || ( op.method === 'clear' && invert ) ) {
		// Automatically initialize attributes object
		if ( !element.attributes ) {
			element.attributes = {};
		}
		element.attributes[op.key] = op.value;
	} else if ( ( op.method === 'clear' && !invert ) || ( op.method === 'set' && invert ) ) {
		if ( element.attributes ) {
			delete element.attributes[op.key];
		}
		// Automatically clean up attributes object
		var empty = true;
		for ( var key in element.attributes ) {
			empty = false;
			break;
		}
		if ( empty ) {
			delete element.attributes;
		}
	} else {
		throw 'Invalid method error. Can not operate attributes this way: ' + method;
	}
	var node = this.model.getNodeFromOffset( this.cursor + 1 );
	if ( node.hasChildren() ) {
		node.traverseLeafNodes( function( leafNode ) {
			leafNode.emit( 'update' );
		} );
	} else {
		node.emit( 'update' );
	}
};

ve.dm.TransactionProcessor.prototype.mark = function( op, invert ) {
	var target;
	if ( ( op.method === 'set' && !invert ) || ( op.method === 'clear' && invert ) ) {
		target = this.set;
	} else if ( ( op.method === 'clear' && !invert ) || ( op.method === 'set' && invert ) ) {
		target = this.clear;
	} else {
		throw 'Invalid method error. Can not operate attributes this way: ' + method;
	}
	if ( op.bias === 'start' ) {
		target.push( op.annotation );
	} else if ( op.bias === 'stop' ) {
		var index;
		if ( op.annotation instanceof RegExp ) {
			index = target.indexOf( op.annotation );
		} else {
			index = ve.dm.DocumentNode.getIndexOfAnnotation( target, op.annotation );
		}
		if ( index === -1 ) {
			throw 'Annotation stack error. Annotation is missing.';
		}
		target.splice( index, 1 );
	}
};
