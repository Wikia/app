/*!
 * VisualEditor DataModel Fragment class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel surface fragment.
 *
 * @class
 *
 * @constructor
 * @param {ve.dm.Surface} surface Target surface
 * @param {ve.Range} [range] Range within target document, current selection used by default
 * @param {boolean} [noAutoSelect] Update the surface's selection when making changes
 * @param {boolean} [excludeInsertions] Exclude inserted content at the boundaries when updating range
 */
ve.dm.SurfaceFragment = function VeDmSurfaceFragment( surface, range, noAutoSelect, excludeInsertions ) {
	// Short-circuit for missing-surface null fragment
	if ( !surface ) {
		return this;
	}

	// Properties
	this.document = surface.getDocument();
	this.noAutoSelect = !!noAutoSelect;
	this.excludeInsertions = !!excludeInsertions;
	this.surface = surface;
	this.range = range && range instanceof ve.Range ? range : surface.getSelection();
	this.leafNodes = null;

	// Short-circuit for invalid range null fragment
	if ( !this.range ) {
		return this;
	}

	// Initialization
	var length = this.document.data.getLength();
	this.range = new ve.Range(
		// Clamp range to valid document offsets
		Math.min( Math.max( this.range.from, 0 ), length ),
		Math.min( Math.max( this.range.to, 0 ), length )
	);
	this.historyPointer = this.document.getCompleteHistoryLength();
};

/* Static Properties */

ve.dm.SurfaceFragment.static = {};

/* Methods */

/**
 * Translate the current range for one or more transactions, using this.excludeInsertions.
 *
 * @param {ve.dm.Transaction|ve.dm.Transaction[]} txs Transaction(s) to translate for
 * @param {boolean} [noUpdate] Use this.range directly rather than trying to update it first
 *  Only use this if calling this.update() will lead to problems (e.g. recursion)
 * @returns {ve.Range|null} Translated range
 */
ve.dm.SurfaceFragment.prototype.getTranslatedRange = function ( txs, noUpdate ) {
	// Handle null fragment
	if ( this.isNull() ) {
		return null;
	}

	var i, len, range;

	if ( !ve.isArray( txs ) ) {
		txs = [ txs ];
	}

	if ( !noUpdate ) {
		this.update();
	}
	range = this.range;
	for ( i = 0, len = txs.length; i < len; i++ ) {
		range = txs[i].translateRange( range, this.excludeInsertions );
	}

	return range;
};

/**
 * Get list of selected nodes and annotations.
 *
 * @param {boolean} [all] Include nodes and annotations which only cover some of the fragment
 * @return {ve.dm.Model[]} Selected models
 */
ve.dm.SurfaceFragment.prototype.getSelectedModels = function ( all ) {
	// Handle null fragment
	if ( this.isNull() ) {
		return [];
	}

	var i, len, nodes, selectedNode,
		annotations = this.getAnnotations( all );

	// Filter out nodes with collapsed ranges
	if ( all ) {
		nodes = this.getCoveredNodes();
		for ( i = 0, len = nodes.length; i < len; i++ ) {
			if ( nodes[i].range && nodes[i].range.isCollapsed() ) {
				nodes.splice( i, 1 );
				len--;
				i--;
			} else {
				nodes[i] = nodes[i].node;
			}
		}
	} else {
		nodes = [];
		selectedNode = this.getSelectedNode();
		if ( selectedNode ) {
			nodes.push( selectedNode );
		}
	}

	return nodes.concat( !annotations.isEmpty() ? annotations.get() : [] );
};

/**
 * Update range based on un-applied transactions in the surface.
 *
 * @method
 */
ve.dm.SurfaceFragment.prototype.update = function () {
	// Handle null fragment
	if ( this.isNull() ) {
		return;
	}

	var txs;
	// Small optimisation: check history pointer is in the past
	if ( this.historyPointer < this.document.getCompleteHistoryLength() ) {
		txs = this.document.getCompleteHistorySince( this.historyPointer );
		this.range = this.getTranslatedRange( txs, true );
		this.historyPointer += txs.length;
		this.leafNodes = null;
	}
};

/**
 * Process a set of transactions on the surface, and update the selection if the fragment
 * is auto-selecting.
 *
 * @param {ve.dm.Transaction|ve.dm.Transaction[]} txs Transaction(s) to process
 * @param {ve.Range} [range] Range to set, if different from translated range, required if the
 *   fragment is null
 * @throws {Error} If fragment is null and range is omitted
 */
ve.dm.SurfaceFragment.prototype.change = function ( txs, range ) {
	if ( !range && this.isNull() ) {
		throw new Error( 'Cannot change null fragment without range' );
	}

	this.surface.change( txs, !this.noAutoSelect && ( range || this.getTranslatedRange( txs ) ) );
	if ( range ) {
		// Let this.range auto-translate for what we just did
		this.update();
		// Overwrite it
		this.range = range;
	}
};

/**
 * Get the surface the fragment is a part of.
 *
 * @method
 * @returns {ve.dm.Surface|null} Surface of fragment
 */
ve.dm.SurfaceFragment.prototype.getSurface = function () {
	return this.surface;
};

/**
 * Get the document of the surface the fragment is a part of.
 *
 * @method
 * @returns {ve.dm.Document|null} Document of surface of fragment
 */
ve.dm.SurfaceFragment.prototype.getDocument = function () {
	return this.document;
};

/**
 * Get the range of the fragment within the surface.
 *
 * This method also calls update to make sure the range returned is current.
 *
 * @method
 * @param {boolean} noCopy Return the range by reference, not a copy
 * @returns {ve.Range|null} Surface range
 */
ve.dm.SurfaceFragment.prototype.getRange = function ( noCopy ) {
	this.update();
	return this.range && !noCopy ? this.range.clone() : this.range;
};

/**
 * Check if the fragment is null.
 *
 * @method
 * @returns {boolean} Fragment is a null fragment
 */
ve.dm.SurfaceFragment.prototype.isNull = function () {
	return !this.range;
};

/**
 * Check if the surface's selection will be updated automatically when changes are made.
 *
 * @method
 * @returns {boolean} Will automatically update surface selection
 */
ve.dm.SurfaceFragment.prototype.willAutoSelect = function () {
	return !this.noAutoSelect;
};

/**
 * Change whether to automatically update the surface selection when making changes.
 *
 * @method
 * @param {boolean} [autoSelect=true] Automatically update surface selection
 * @chainable
 */
ve.dm.SurfaceFragment.prototype.setAutoSelect = function ( autoSelect ) {
	this.noAutoSelect = !autoSelect;
	return this;
};

/**
 * Get a clone of this SurfaceFragment, optionally with a different range.
 *
 * @param {ve.Range} [range] If set, use this range rather than the old fragment's range
 * @returns {ve.dm.SurfaceFragment} Clone of this fragment
 */
ve.dm.SurfaceFragment.prototype.clone = function ( range ) {
	return new this.constructor(
		this.surface,
		range || this.getRange(),
		this.noAutoSelect,
		this.excludeInsertions
	);
};

/**
 * Check whether updates to this fragment's range will exclude content inserted at the boundaries.
 * @returns {boolean} Range updates will exclude insertions
 */
ve.dm.SurfaceFragment.prototype.willExcludeInsertions = function () {
	return this.excludeInsertions;
};

/**
 * Tell this fragment whether it should exclude insertions. If this option is enabled, updates to
 * this fragment's range in response to transactions will not include content inserted at the
 * boundaries of the range; if it is disabled, insertions will be included.
 *
 * @param {boolean} excludeInsertions Whether to exclude insertions
 */
ve.dm.SurfaceFragment.prototype.setExcludeInsertions = function ( excludeInsertions ) {
	excludeInsertions = !!excludeInsertions;
	if ( this.excludeInsertions !== excludeInsertions ) {
		// Process any deferred updates with the old value
		this.update();
		// Set the new value
		this.excludeInsertions = excludeInsertions;
	}
};

/**
 * Get a new fragment with an adjusted position
 *
 * @method
 * @param {number} [start] Adjustment for start position
 * @param {number} [end] Adjustment for end position
 * @returns {ve.dm.SurfaceFragment} Adjusted fragment
 */
ve.dm.SurfaceFragment.prototype.adjustRange = function ( start, end ) {
	var newRange, oldRange = this.getRange( true );
	newRange = oldRange && new ve.Range( oldRange.start + ( start || 0 ), oldRange.end + ( end || 0 ) );
	return this.clone( newRange );
};

/**
 * Get a new fragment with a truncated length.
 *
 * @method
 * @param {number} limit Maximum length of range (negative for left-side truncation)
 * @returns {ve.dm.SurfaceFragment} Truncated fragment
 */
ve.dm.SurfaceFragment.prototype.truncateRange = function ( limit ) {
	var range = this.getRange( true );
	return this.clone( range && range.truncate( limit ) );
};

/**
 * Get a new fragment with a zero-length selection at the start offset.
 *
 * @method
 * @returns {ve.dm.SurfaceFragment} Collapsed fragment
 */
ve.dm.SurfaceFragment.prototype.collapseRangeToStart = function () {
	var range = this.getRange( true );
	return this.clone( range && new ve.Range( range.start ) );
};

/**
 * Get a new fragment with a zero-length selection at the end offset.
 *
 * @method
 * @returns {ve.dm.SurfaceFragment} Collapsed fragment
 */
ve.dm.SurfaceFragment.prototype.collapseRangeToEnd = function () {
	var range = this.getRange( true );
	return this.clone( range && new ve.Range( range.end ) );
};

/**
 * Get a new fragment with a range that no longer includes leading and trailing whitespace.
 *
 * @method
 * @returns {ve.dm.SurfaceFragment} Trimmed fragment
 */
ve.dm.SurfaceFragment.prototype.trimRange = function () {
	var oldRange = this.getRange(),
		newRange = oldRange;

	if ( oldRange ) {
		if ( this.document.getText( oldRange ).trim().length === 0 ) {
			// oldRange is only whitespace
			newRange = new ve.Range( oldRange.start );
		} else {
			newRange = this.document.data.trimOuterSpaceFromRange( oldRange );
		}
	}

	return this.clone( newRange );
};

/**
 * Get a new fragment that covers an expanded range of the document.
 *
 * @method
 * @param {string} [scope='parent'] Method of expansion:
 *  - `word`: Expands to cover the nearest word by looking for word breaks (see UnicodeJS.wordbreak)
 *  - `annotation`: Expands to cover a given annotation (argument) within the current range
 *  - `root`: Expands to cover the entire document
 *  - `siblings`: Expands to cover all sibling nodes
 *  - `closest`: Expands to cover the closest common ancestor node of a give type (argument)
 *  - `parent`: Expands to cover the closest common parent node
 * @param {Mixed} [type] Parameter to use with scope method if needed
 * @returns {ve.dm.SurfaceFragment} Expanded fragment
 */
ve.dm.SurfaceFragment.prototype.expandRange = function ( scope, type ) {
	var node, nodes, parent, newRange,
		oldRange = this.getRange();

	// Handle null fragment
	if ( this.isNull() ) {
		return this.clone();
	}

	switch ( scope || 'parent' ) {
		case 'word':
			if ( oldRange.getLength() > 0 ) {
				newRange = ve.Range.newCoveringRange( [
					this.document.data.getNearestWordRange( this.getRange( true ).start ),
					this.document.data.getNearestWordRange( this.getRange( true ).end )
				] );
				if ( oldRange.isBackwards() ) {
					newRange = newRange.flip();
				}
			} else {
				// optimisation for zero-length ranges
				newRange = this.document.data.getNearestWordRange( oldRange.start );
			}
			break;
		case 'annotation':
			newRange = this.document.data.getAnnotatedRangeFromSelection( oldRange, type );
			// Adjust selection if it does not contain the annotated range
			if ( oldRange.start > newRange.start || oldRange.end < newRange.end ) {
				// Maintain range direction
				if ( oldRange.from > oldRange.to ) {
					newRange = newRange.flip();
				}
			} else {
				// Otherwise just keep the range as is
				newRange = oldRange;
			}
			break;
		case 'root':
			newRange = new ve.Range( 0, this.document.getData().length );
			break;
		case 'siblings':
			// Grow range to cover all siblings
			nodes = this.document.selectNodes( oldRange, 'siblings' );
			if ( nodes.length === 1 ) {
				newRange = nodes[0].node.getOuterRange();
			} else {
				newRange = new ve.Range(
					nodes[0].node.getOuterRange().start,
					nodes[nodes.length - 1].node.getOuterRange().end
				);
			}
			break;
		case 'closest':
			// Grow range to cover closest common ancestor node of given type
			node = this.document.selectNodes( oldRange, 'siblings' )[0].node;
			parent = node.getParent();
			while ( parent && parent.getType() !== type ) {
				node = parent;
				parent = parent.getParent();
			}
			if ( !parent ) {
				return new ve.dm.SurfaceFragment( null );
			}
			newRange = parent.getOuterRange();
			break;
		case 'parent':
			// Grow range to cover the closest common parent node
			node = this.document.selectNodes( oldRange, 'siblings' )[0].node;
			parent = node.getParent();
			if ( !parent ) {
				return new ve.dm.SurfaceFragment( null );
			}
			newRange = parent.getOuterRange();
			break;
		default:
			throw new Error( 'Invalid scope argument: ' + scope );
	}
	return this.clone( newRange );
};

/**
 * Get data for the fragment.
 *
 * @method
 * @param {boolean} [deep] Get a deep copy of the data
 * @returns {Array} Fragment data
 */
ve.dm.SurfaceFragment.prototype.getData = function ( deep ) {
	// Handle null fragment
	if ( this.isNull() ) {
		return [];
	}
	return this.document.getData( this.getRange(), deep );
};

/**
 * Get plain text for the fragment.
 *
 * @method
 * @returns {string} Fragment text
 */
ve.dm.SurfaceFragment.prototype.getText = function () {
	// Handle null fragment
	if ( this.isNull() ) {
		return '';
	}
	var i, length,
		text = '',
		data = this.document.getData( this.getRange() );
	for ( i = 0, length = data.length; i < length; i++ ) {
		if ( data[i].type === undefined ) {
			// Annotated characters have a string at index 0, plain characters are 1-char strings
			text += typeof data[i] === 'string' ? data[i] : data[i][0];
		}
	}
	return text;
};

/**
 * Get annotations in fragment.
 *
 * By default, this will only get annotations that completely cover the fragment. Use the {all}
 * argument to get all annotations that occur within the fragment.
 *
 * @method
 * @param {boolean} [all] Get annotations which only cover some of the fragment
 * @returns {ve.dm.AnnotationSet} All annotation objects range is covered by
 */
ve.dm.SurfaceFragment.prototype.getAnnotations = function ( all ) {
	// Handle null fragment
	if ( this.isNull() ) {
		return new ve.dm.AnnotationSet( this.getDocument().getStore() );
	}
	if ( this.getRange( true ).getLength() ) {
		return this.getDocument().data.getAnnotationsFromRange( this.getRange(), all );
	} else {
		return this.surface.getInsertionAnnotations();
	}
};

/**
 * Get all leaf nodes covered by the fragment.
 *
 * @see ve.Document#selectNodes Used to get the return value
 *
 * @method
 * @returns {Array} List of nodes and related information
 */
ve.dm.SurfaceFragment.prototype.getLeafNodes = function () {
	// Handle null fragment
	if ( this.isNull() ) {
		return [];
	}

	// Update in case the cache needs invalidating
	this.update();
	// Cache leafNodes because it's expensive to compute
	if ( !this.leafNodes ) {
		this.leafNodes = this.document.selectNodes( this.getRange( true ), 'leaves' );
	}
	return this.leafNodes;
};

/**
 * Get all leaf nodes excluding nodes where the selection is empty.
 *
 * @method
 * @returns {Array} List of nodes and related information
 */
ve.dm.SurfaceFragment.prototype.getSelectedLeafNodes = function () {
	// Handle null fragment
	if ( this.isNull() ) {
		return [];
	}

	var i, len, selectedLeafNodes = [], leafNodes = this.getLeafNodes();
	for ( i = 0, len = leafNodes.length; i < len; i++ ) {
		if ( len === 1 || !leafNodes[i].range || leafNodes[i].range.getLength() ) {
			selectedLeafNodes.push( leafNodes[i].node );
		}
	}
	return selectedLeafNodes;
};

/**
 * Get the node selected by a range, i.e. the range matches the node's range exactly.
 *
 * Note that this method operates on the fragment's range, not the document's current selection.
 * This fragment does not need to be selected for this method to work.
 *
 * @returns {ve.dm.Node|null} The node selected by the range, or null if a node is not selected
 */
ve.dm.SurfaceFragment.prototype.getSelectedNode = function () {
	// Handle null fragment
	if ( this.isNull() ) {
		return null;
	}

	var i, len, range = this.getRange(),
		nodes = this.document.selectNodes( range, 'covered' );

	for ( i = 0, len = nodes.length; i < len; i++ ) {
		if ( nodes[i].nodeOuterRange.equalsSelection( range ) ) {
			return nodes[i].node;
		}
	}
	return null;
};

/**
 * Get nodes covered by the fragment.
 *
 * Does not descend into nodes that are entirely covered by the range. The result is
 * similar to that of {ve.dm.SurfaceFragment.prototype.getLeafNodes} except that if a node is
 * entirely covered, its children aren't returned separately.
 *
 * @see ve.Document#selectNodes for more information about the return value
 *
 * @method
 * @returns {Array} List of nodes and related information
 */
ve.dm.SurfaceFragment.prototype.getCoveredNodes = function () {
	// Handle null fragment
	if ( this.isNull() ) {
		return [];
	}
	return this.document.selectNodes( this.getRange(), 'covered' );
};

/**
 * Get nodes covered by the fragment.
 *
 * Includes adjacent siblings covered by the range, descending if the range is in a single node.
 *
 * @see ve.Document#selectNodes for more information about the return value.
 *
 * @method
 * @returns {Array} List of nodes and related information
 */
ve.dm.SurfaceFragment.prototype.getSiblingNodes = function () {
	// Handle null fragment
	if ( this.isNull() ) {
		return [];
	}
	return this.document.selectNodes( this.getRange(), 'siblings' );
};

/**
 * Apply the fragment's range to the surface as a selection.
 *
 * @method
 * @chainable
 */
ve.dm.SurfaceFragment.prototype.select = function () {
	// Handle null fragment
	if ( this.isNull() ) {
		return this;
	}
	this.surface.setSelection( this.getRange() );
	return this;
};

/**
 * Change one or more attributes on covered nodes.
 *
 * @method
 * @param {Object} attr List of attributes to change, use undefined to remove an attribute
 * @param {string} [type] Node type to restrict changes to
 * @chainable
 */
ve.dm.SurfaceFragment.prototype.changeAttributes = function ( attr, type ) {
	// Handle null fragment
	if ( this.isNull() ) {
		return this;
	}

	var i, len, result,
		txs = [],
		covered = this.getCoveredNodes();

	for ( i = 0, len = covered.length; i < len; i++ ) {
		result = covered[i];
		if (
			// Non-wrapped nodes have no attributes
			!result.node.isWrapped() ||
			// Filtering by node type
			( type && result.node.getType() !== type ) ||
			// Ignore zero-length results
			( result.range && result.range.isCollapsed() )
		) {
			continue;
		}
		txs.push(
			ve.dm.Transaction.newFromAttributeChanges(
				this.document, result.nodeOuterRange.start, attr
			)
		);
	}
	if ( txs.length ) {
		this.change( txs );
	}
	return this;
};

/**
 * Apply an annotation to content in the fragment.
 *
 * To avoid problems identified in bug 33108, use the {ve.dm.SurfaceFragment.trimRange} method.
 *
 * TODO: Optionally take an annotation set instead of name and data arguments and set/clear multiple
 * annotations in a single transaction.
 *
 * @method
 * @param {string} method Mode of annotation, either 'set' or 'clear'
 * @param {string|ve.dm.Annotation} nameOrAnnotation Annotation name, for example: 'textStyle/bold' or
 * Annotation object
 * @param {Object} [data] Additional annotation data (not used if annotation object is given)
 * @chainable
 */
ve.dm.SurfaceFragment.prototype.annotateContent = function ( method, nameOrAnnotation, data ) {
	// Handle null fragment
	if ( this.isNull() ) {
		return this;
	}

	var annotation, annotations, i, ilen, tx,
		txs = [];

	if ( nameOrAnnotation instanceof ve.dm.Annotation ) {
		annotations = [ nameOrAnnotation ];
	} else {
		annotation = ve.dm.annotationFactory.create( nameOrAnnotation, data );
		if ( method === 'set' ) {
			annotations = [ annotation ];
		} else {
			annotations = this.document.data.getAnnotationsFromRange( this.getRange(), true )
				.getAnnotationsByName( annotation.name ).get();
		}
	}
	if ( this.getRange( true ).getLength() ) {
		// Apply to selection
		for ( i = 0, ilen = annotations.length; i < ilen; i++ ) {
			tx = ve.dm.Transaction.newFromAnnotation( this.document, this.getRange(), method, annotations[i] );
			txs.push( tx );
		}
		this.change( txs );
	} else {
		// Apply annotation to stack
		if ( method === 'set' ) {
			for ( i = 0, ilen = annotations.length; i < ilen; i++ ) {
				this.surface.addInsertionAnnotations( annotations[i] );
			}
		} else if ( method === 'clear' ) {
			for ( i = 0, ilen = annotations.length; i < ilen; i++ ) {
				this.surface.removeInsertionAnnotations( annotations[i] );
			}
		}
	}

	return this;
};

/**
 * Remove content in the fragment and insert content before it.
 *
 * This will move the fragment's range to cover the inserted content. Note that this may be
 * different from what a normal range translation would do: the insertion might occur
 * at a different offset if that is needed to make the document balanced.
 *
 * @method
 * @param {string|Array} content Content to insert, can be either a string or array of data
 * @param {boolean} annotate Content should be automatically annotated to match surrounding content
 * @chainable
 */
ve.dm.SurfaceFragment.prototype.insertContent = function ( content, annotate ) {
	// Handle null fragment
	if ( this.isNull() ) {
		return this;
	}

	var annotations, tx, newRange;

	if ( this.getRange( true ).getLength() ) {
		this.removeContent();
	}
	// Auto-convert content to array of plain text characters
	if ( typeof content === 'string' ) {
		content = ve.splitClusters( content );
	}
	if ( content.length ) {
		if ( annotate ) {
			// TODO: Don't reach into properties of document
			annotations = this.document.data
				.getAnnotationsFromOffset( this.getRange( true ).start - 1 );
			if ( annotations.getLength() > 0 ) {
				ve.dm.Document.static.addAnnotationsToData( content, annotations );
			}
		}
		tx = ve.dm.Transaction.newFromInsertion(
			this.document,
			this.getRange( true ).start,
			content
		);
		// Set the range to cover the inserted content; the offset translation will be wrong
		// if newFromInsertion() decided to move the insertion point
		newRange = tx.getModifiedRange();
		this.change( tx, newRange );
	}

	return this;
};

/**
 * Remove content in the fragment.
 *
 * @method
 * @chainable
 */
ve.dm.SurfaceFragment.prototype.removeContent = function () {
	// Handle null fragment
	if ( this.isNull() ) {
		return this;
	}

	if ( this.getRange( true ).getLength() ) {
		this.change( ve.dm.Transaction.newFromRemoval( this.document, this.getRange() ) );
	}

	return this;
};

/**
 * Convert each content branch in the fragment from one type to another.
 *
 * @method
 * @param {string} type Element type to convert to
 * @param {Object} [attr] Initial attributes for new element
 * @chainable
 */
ve.dm.SurfaceFragment.prototype.convertNodes = function ( type, attr ) {
	// Handle null fragment
	if ( this.isNull() ) {
		return this;
	}

	this.change( ve.dm.Transaction.newFromContentBranchConversion(
		this.document, this.getRange(), type, attr
	) );

	return this;
};

/**
 * Wrap each node in the fragment with one or more elements.
 *
 * A wrapper object is a linear model element; a plain object containing a type property and an
 * optional attributes property.
 *
 * Example:
 *     // fragment is a selection of: <p>a</p><p>b</p>
 *     fragment.wrapNodes(
 *         [{ 'type': 'list', 'attributes': { 'style': 'bullet' } }, { 'type': 'listItem' }]
 *     )
 *     // fragment is now a selection of: <ul><li><p>a</p></li></ul><ul><li><p>b</p></li></ul>
 *
 * @method
 * @param {Object|Object[]} wrapper Wrapper object, or array of wrapper objects (see above)
 * @param {string} wrapper.type Node type of wrapper
 * @param {Object} [wrapper.attributes] Attributes of wrapper
 * @chainable
 */
ve.dm.SurfaceFragment.prototype.wrapNodes = function ( wrapper ) {
	// Handle null fragment
	if ( this.isNull() ) {
		return this;
	}

	if ( !ve.isArray( wrapper ) ) {
		wrapper = [wrapper];
	}
	this.change(
		ve.dm.Transaction.newFromWrap( this.document, this.getRange(), [], [], [], wrapper )
	);

	return this;
};

/**
 * Unwrap nodes in the fragment out of one or more elements.
 *
 * Example:
 *     // fragment is a selection of: <ul>「<li><p>a</p></li><li><p>b</p></li>」</ul>
 *     fragment.unwrapNodes( 1, 1 )
 *     // fragment is now a selection of: 「<p>a</p><p>b</p>」
 *
 * @method
 * @param {number} outerDepth Number of nodes outside the selection to unwrap
 * @param {number} innerDepth Number of nodes inside the selection to unwrap
 * @chainable
 */
ve.dm.SurfaceFragment.prototype.unwrapNodes = function ( outerDepth, innerDepth ) {
	// Handle null fragment
	if ( this.isNull() ) {
		return this;
	}

	var i,
		innerUnwrapper = [],
		outerUnwrapper = [];

	if ( this.getRange( true ).end - this.getRange( true ).start < innerDepth * 2 ) {
		throw new Error( 'cannot unwrap by greater depth than maximum theoretical depth of selection' );
	}

	for ( i = 0; i < innerDepth; i++ ) {
		innerUnwrapper.push( this.surface.getDocument().data.getData( this.getRange( true ).start + i ) );
	}
	for ( i = outerDepth; i > 0; i-- ) {
		outerUnwrapper.push( this.surface.getDocument().data.getData( this.getRange( true ).start - i ) );
	}

	this.change( ve.dm.Transaction.newFromWrap(
		this.document, this.getRange(), outerUnwrapper, [], innerUnwrapper, []
	) );

	return this;
};

/**
 * Change the wrapping of each node in the fragment from one type to another.
 *
 * A wrapper object is a linear model element; a plain object containing a type property and an
 * optional attributes property.
 *
 * Example:
 *     // fragment is a selection of: <dl><dt><p>a</p></dt></dl><dl><dt><p>b</p></dt></dl>
 *     fragment.rewrapNodes(
 *         2,
 *         [{ 'type': 'list', 'attributes': { 'style': 'bullet' } }, { 'type': 'listItem' }]
 *     )
 *     // fragment is now a selection of: <ul><li><p>a</p></li></ul><ul><li><p>b</p></li></ul>
 *
 * @method
 * @param {number} depth Number of nodes to unwrap
 * @param {Object|Object[]} wrapper Wrapper object, or array of wrapper objects (see above)
 * @param {string} wrapper.type Node type of wrapper
 * @param {Object} [wrapper.attributes] Attributes of wrapper
 * @chainable
 */
ve.dm.SurfaceFragment.prototype.rewrapNodes = function ( depth, wrapper ) {
	// Handle null fragment
	if ( this.isNull() ) {
		return this;
	}

	var i,
		unwrapper = [];

	if ( !ve.isArray( wrapper ) ) {
		wrapper = [wrapper];
	}

	if ( this.getRange( true ).end - this.getRange( true ).start < depth * 2 ) {
		throw new Error( 'cannot unwrap by greater depth than maximum theoretical depth of selection' );
	}

	for ( i = 0; i < depth; i++ ) {
		unwrapper.push( this.surface.getDocument().data.getData( this.getRange( true ).start + i ) );
	}

	this.change(
		ve.dm.Transaction.newFromWrap( this.document, this.getRange(), [], [], unwrapper, wrapper )
	);

	return this;
};

/**
 * Wrap nodes in the fragment with one or more elements.
 *
 * A wrapper object is a linear model element; a plain object containing a type property and an
 * optional attributes property.
 *
 * Example:
 *     // fragment is a selection of: <p>a</p><p>b</p>
 *     fragment.wrapAllNodes(
 *         [{ 'type': 'list', 'attributes': { 'style': 'bullet' } }, { 'type': 'listItem' }]
 *     )
 *     // fragment is now a selection of: <ul><li><p>a</p><p>b</p></li></ul>
 *
 * @method
 * @param {Object|Object[]} wrapper Wrapper object, or array of wrapper objects (see above)
 * @param {string} wrapper.type Node type of wrapper
 * @param {Object} [wrapper.attributes] Attributes of wrapper
 * @chainable
 */
ve.dm.SurfaceFragment.prototype.wrapAllNodes = function ( wrapper ) {
	// Handle null fragment
	if ( this.isNull() ) {
		return this;
	}

	if ( !ve.isArray( wrapper ) ) {
		wrapper = [wrapper];
	}

	this.change(
		ve.dm.Transaction.newFromWrap( this.document, this.getRange(), [], wrapper, [], [] )
	);

	return this;
};

/**
 * Change the wrapping of nodes in the fragment from one type to another.
 *
 * A wrapper object is a linear model element; a plain object containing a type property and an
 * optional attributes property.
 *
 * Example:
 *     // fragment is a selection of: <h1><p>a</p><p>b</p></h1>
 *     fragment.rewrapAllNodes( 1, { 'type': 'heading', 'attributes': { 'level': 2 } } );
 *     // fragment is now a selection of: <h2><p>a</p><p>b</p></h2>
 *
 * @method
 * @param {number} depth Number of nodes to unwrap
 * @param {Object|Object[]} wrapper Wrapper object, or array of wrapper objects (see above)
 * @param {string} wrapper.type Node type of wrapper
 * @param {Object} [wrapper.attributes] Attributes of wrapper
 * @chainable
 */
ve.dm.SurfaceFragment.prototype.rewrapAllNodes = function ( depth, wrapper ) {
	// Handle null fragment
	if ( this.isNull() ) {
		return this;
	}

	var i, unwrapper = [],
		innerRange = new ve.Range(
			this.getRange( true ).start + depth,
			this.getRange( true ).end - depth
		);

	if ( !ve.isArray( wrapper ) ) {
		wrapper = [wrapper];
	}

	if ( this.getRange( true ).end - this.getRange( true ).start < depth * 2 ) {
		throw new Error( 'cannot unwrap by greater depth than maximum theoretical depth of selection' );
	}

	for ( i = 0; i < depth; i++ ) {
		unwrapper.push( this.surface.getDocument().data.getData( this.getRange( true ).start + i ) );
	}

	this.change(
		ve.dm.Transaction.newFromWrap( this.document, innerRange, unwrapper, wrapper, [], [] )
	);

	return this;
};

/**
 * Isolates the nodes in a fragment then unwraps them.
 *
 * The node selection is expanded to siblings. These are isolated such that they are the
 * sole children of the nearest parent element which can 'type' can exist in.
 *
 * The new isolated selection is then safely unwrapped.
 *
 * @method
 * @param {string} type Node type to isolate for
 * @chainable
 */
ve.dm.SurfaceFragment.prototype.isolateAndUnwrap = function ( isolateForType ) {
	// Handle null fragment
	if ( this.isNull() ) {
		return this;
	}

	var nodes, startSplitNode, endSplitNode,
		startOffset, endOffset, oldExclude,
		outerDepth = 0,
		factory = ve.dm.nodeFactory,
		allowedParents = factory.getSuggestedParentNodeTypes( isolateForType ),
		startSplitRequired = false,
		endSplitRequired = false,
		startSplitNodes = [],
		endSplitNodes = [],
		fragment = this;

	function createSplits( splitNodes, insertBefore ) {
		var i, length, tx,
			adjustment = 0, data = [];
		for ( i = 0, length = splitNodes.length; i < length; i++ ) {
			data.unshift( { 'type': '/' + splitNodes[i].type } );
			data.push( splitNodes[i].getClonedElement() );

			if ( insertBefore ) {
				adjustment += 2;
			}
		}

		tx = ve.dm.Transaction.newFromInsertion( fragment.getDocument(), insertBefore ? startOffset : endOffset, data );
		fragment.change( tx );

		startOffset += adjustment;
		endOffset += adjustment;
	}

	nodes = this.getDocument().selectNodes( this.getRange(), 'siblings' );

	// Find start split point, if required
	startSplitNode = nodes[0].node;
	startOffset = startSplitNode.getOuterRange().start;
	while ( allowedParents !== null && ve.indexOf( startSplitNode.getParent().type, allowedParents ) === -1 ) {
		if ( startSplitNode.getParent().indexOf( startSplitNode ) > 0 ) {
			startSplitRequired = true;
		}
		startSplitNode = startSplitNode.getParent();
		if ( startSplitRequired ) {
			startSplitNodes.unshift( startSplitNode );
		} else {
			startOffset = startSplitNode.getOuterRange().start;
		}
		outerDepth++;
	}

	// Find end split point, if required
	endSplitNode = nodes[nodes.length - 1].node;
	endOffset = endSplitNode.getOuterRange().end;
	while ( allowedParents !== null && ve.indexOf( endSplitNode.getParent().type, allowedParents ) === -1 ) {
		if ( endSplitNode.getParent().indexOf( endSplitNode ) < endSplitNode.getParent().getChildren().length - 1 ) {
			endSplitRequired = true;
		}
		endSplitNode = endSplitNode.getParent();
		if ( endSplitRequired ) {
			endSplitNodes.unshift( endSplitNode );
		} else {
			endOffset = endSplitNode.getOuterRange().end;
		}
	}

	// We have to exclude insertions while doing splits, because we want the range to be
	// exactly what we're isolating, we don't want it to grow to include the separators
	// we're inserting (which would happen if one of them is immediately adjacent to the range)
	oldExclude = this.willExcludeInsertions();
	this.setExcludeInsertions( true );

	if ( startSplitRequired ) {
		createSplits( startSplitNodes, true );
	}

	if ( endSplitRequired ) {
		createSplits( endSplitNodes, false );
	}

	this.setExcludeInsertions( oldExclude );

	this.unwrapNodes( outerDepth, 0 );

	return this;
};
