/*!
 * VisualEditor DataModel Fragment class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
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
 */
ve.dm.SurfaceFragment = function VeDmSurfaceFragment( surface, range, noAutoSelect ) {
	// Short-circuit for missing-surface null fragment
	if ( !surface ) {
		return this;
	}

	// Properties
	this.surface = surface;
	this.range = range && range instanceof ve.Range ? range : surface.getSelection();
	// Short-circuit for invalid range null fragment
	if ( !this.range ) {
		return this;
	}
	this.document = surface.getDocument();
	this.noAutoSelect = !!noAutoSelect;

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

/**
 * @static
 * @property
 * @inheritable
 */
ve.dm.SurfaceFragment.static = {};

/* Methods */

/**
 * Update range based on un-applied transactions in the surface.
 *
 * @method
 */
ve.dm.SurfaceFragment.prototype.update = function () {
	var i, length, txs;
	// Small optimisation: check history pointer is in the past
	if ( this.historyPointer < this.document.getCompleteHistoryLength() ) {
		txs = this.document.getCompleteHistorySince( this.historyPointer );
		for ( i = 0, length = txs.length; i < length; i++ ) {
			this.range = txs[i].translateRange( this.range );
			this.historyPointer++;
		}
	}
};

/**
 * Get the surface the fragment is a part of.
 *
 * @method
 * @returns {ve.dm.Surface} Surface of fragment
 */
ve.dm.SurfaceFragment.prototype.getSurface = function () {
	return this.surface;
};

/**
 * Get the document of the surface the fragment is a part of.
 *
 * @method
 * @returns {ve.dm.Document} Document of surface of fragment
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
 * @returns {ve.Range} Surface range
 */
ve.dm.SurfaceFragment.prototype.getRange = function ( noCopy ) {
	this.update();
	return noCopy ? this.range : this.range.clone();
};

/**
 * Check if the fragment is null.
 *
 * @method
 * @returns {boolean} Fragment is a null fragment
 */
ve.dm.SurfaceFragment.prototype.isNull = function () {
	return this.surface === undefined;
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
	// Handle null fragment
	if ( !this.surface ) {
		return this;
	}
	return new ve.dm.SurfaceFragment(
		this.surface,
		new ve.Range( this.getRange( true ).start + ( start || 0 ), this.getRange( true ).end + ( end || 0 ) ),
		this.noAutoSelect
	);
};

/**
 * Get a new fragment with a truncated length.
 *
 * @method
 * @param {number} limit Maximum length of range (negative for left-side truncation)
 * @returns {ve.dm.SurfaceFragment} Truncated fragment
 */
ve.dm.SurfaceFragment.prototype.truncateRange = function ( limit ) {
	// Handle null fragment
	if ( !this.surface ) {
		return this;
	}
	return new ve.dm.SurfaceFragment(
		this.surface,
		this.getRange().truncate( limit ),
		this.noAutoSelect
	);
};

/**
 * Get a new fragment with a zero-length selection at the start offset.
 *
 * @method
 * @returns {ve.dm.SurfaceFragment} Collapsed fragment
 */
ve.dm.SurfaceFragment.prototype.collapseRangeToStart = function () {
	// Handle null fragment
	if ( !this.surface ) {
		return this;
	}
	return new ve.dm.SurfaceFragment(
		this.surface, new ve.Range( this.getRange( true ).start ), this.noAutoSelect
	);
};

/**
 * Get a new fragment with a zero-length selection at the end offset.
 *
 * @method
 * @returns {ve.dm.SurfaceFragment} Collapsed fragment
 */
ve.dm.SurfaceFragment.prototype.collapseRangeToEnd = function () {
	// Handle null fragment
	if ( !this.surface ) {
		return this;
	}
	return new ve.dm.SurfaceFragment(
		this.surface, new ve.Range( this.getRange( true ).end ), this.noAutoSelect
	);
};

/**
 * Get a new fragment with a range that no longer includes leading and trailing whitespace.
 *
 * @method
 * @returns {ve.dm.SurfaceFragment} Trimmed fragment
 */
ve.dm.SurfaceFragment.prototype.trimRange = function () {
	// Handle null fragment
	if ( !this.surface ) {
		return this;
	}
	// If range is only whitespace
	if ( this.document.getText( this.getRange() ).trim().length === 0 ) {
		// Collapse range
		return new ve.dm.SurfaceFragment(
			this.surface, new ve.Range( this.getRange( true ).start ), this.noAutoSelect
		);
	}
	return new ve.dm.SurfaceFragment(
		this.surface, this.document.data.trimOuterSpaceFromRange( this.getRange() ), this.noAutoSelect
	);
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
	// Handle null fragment
	if ( !this.surface ) {
		return this;
	}
	var range, node, nodes, parent;
	switch ( scope || 'parent' ) {
		case 'word':
			if ( this.getRange( true ).getLength() > 0 ) {
				range = ve.Range.newCoveringRange( [
					this.document.data.getNearestWordRange( this.getRange( true ).start ),
					this.document.data.getNearestWordRange( this.getRange( true ).end )
				] );
				if ( this.getRange( true ).isBackwards() ) {
					range = range.flip();
				}
			} else {
				// optimisation for zero-length ranges
				range = this.document.data.getNearestWordRange( this.getRange( true ).start );
			}
			break;
		case 'annotation':
			range = this.document.data.getAnnotatedRangeFromSelection( this.getRange(), type );
			// Adjust selection if it does not contain the annotated range
			if ( this.getRange( true ).start > range.start || this.getRange( true ).end < range.end ) {
				// Maintain range direction
				if ( this.getRange( true ).from > this.getRange( true ).to ) {
					range = range.flip();
				}
			} else {
				// Otherwise just keep the range as is
				range = this.getRange();
			}
			break;
		case 'root':
			range = new ve.Range( 0, this.document.getData().length );
			break;
		case 'siblings':
			// Grow range to cover all siblings
			nodes = this.document.selectNodes( this.getRange(), 'siblings' );
			if ( nodes.length === 1 ) {
				range = nodes[0].node.getOuterRange();
			} else {
				range = new ve.Range(
					nodes[0].node.getOuterRange().start,
					nodes[nodes.length - 1].node.getOuterRange().end
				);
			}
			break;
		case 'closest':
			// Grow range to cover closest common ancestor node of given type
			node = this.document.selectNodes( this.getRange(), 'siblings' )[0].node;
			parent = node.getParent();
			while ( parent && parent.getType() !== type ) {
				node = parent;
				parent = parent.getParent();
			}
			if ( !parent ) {
				return new ve.dm.SurfaceFragment( null );
			}
			range = parent.getOuterRange();
			break;
		case 'parent':
			// Grow range to cover the closest common parent node
			node = this.document.selectNodes( this.getRange(), 'siblings' )[0].node;
			parent = node.getParent();
			if ( !parent ) {
				return new ve.dm.SurfaceFragment( null );
			}
			range = parent.getOuterRange();
			break;
		default:
			throw new Error( 'Invalid scope argument: ' + scope );
	}
	return new ve.dm.SurfaceFragment( this.surface, range, this.noAutoSelect );
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
 * Get data for the fragment.
 *
 * @method
 * @param {boolean} [deep] Get a deep copy of the data
 * @returns {Array} Fragment data
 */
ve.dm.SurfaceFragment.prototype.getData = function ( deep ) {
	// Handle null fragment
	if ( !this.surface ) {
		return [];
	}
	return this.document.getData( this.getRange(), deep );
};

/**
 * Get plain text for the fragment.
 *
 * @method
 * @returns {Array} Fragment text
 */
ve.dm.SurfaceFragment.prototype.getText = function () {
	// Handle null fragment
	if ( !this.surface ) {
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
	if ( !this.surface ) {
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
	if ( !this.surface ) {
		return [];
	}
	return this.document.selectNodes( this.getRange(), 'leaves' );
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
	if ( !this.surface ) {
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
	if ( !this.surface ) {
		return [];
	}
	return this.document.selectNodes( this.getRange(), 'siblings' );
};

/**
 * Change whether to automatically update the surface selection when making changes.
 *
 * @method
 * @param {boolean} [value=true] Automatically update surface selection
 * @chainable
 */
ve.dm.SurfaceFragment.prototype.setAutoSelect = function ( value ) {
	this.noAutoSelect = !value;
	return this;
};

/**
 * Apply the fragment's range to the surface as a selection.
 *
 * @method
 * @chainable
 */
ve.dm.SurfaceFragment.prototype.select = function () {
	// Handle null fragment
	if ( !this.surface ) {
		return this;
	}
	this.surface.change( null, this.getRange() );
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
	if ( !this.surface ) {
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
		this.surface.change( txs );
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
	if ( !this.surface ) {
		return this;
	}
	var annotation, annotations, i, ilen, tx, txs = [], newRange = this.getRange();
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
			newRange = tx.translateRange( newRange );

		}
		this.surface.change( txs, !this.noAutoSelect && newRange );
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
 * This will move the fragment's range to the end of the insertion and make it zero-length.
 *
 * @method
 * @param {string|Array} content Content to insert, can be either a string or array of data
 * @param {boolean} annotate Content should be automatically annotated to match surrounding content
 * @chainable
 */
ve.dm.SurfaceFragment.prototype.insertContent = function ( content, annotate ) {
	// Handle null fragment
	if ( !this.surface ) {
		return this;
	}
	var tx, annotations;
	if ( this.getRange( true ).getLength() ) {
		this.removeContent();
	}
	// Auto-convert content to array of plain text characters
	if ( typeof content === 'string' ) {
		content = ve.splitClusters( content );
	}
	if ( content.length ) {
		if ( annotate ) {
			annotations = this.document.data.getAnnotationsFromOffset( this.getRange( true ).start - 1 );
			if ( annotations.getLength() > 0 ) {
				ve.dm.Document.addAnnotationsToData( content, annotations );
			}
		}
		tx = ve.dm.Transaction.newFromInsertion( this.document, this.getRange( true ).start, content );
		this.surface.change( tx, !this.noAutoSelect && tx.translateRange( this.getRange() ) );
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
	if ( !this.surface ) {
		return this;
	}
	var tx;
	if ( this.getRange( true ).getLength() ) {
		tx = ve.dm.Transaction.newFromRemoval( this.document, this.getRange() );
		this.surface.change( tx, !this.noAutoSelect && tx.translateRange( this.getRange() ) );
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
	if ( !this.surface ) {
		return this;
	}
	var tx = ve.dm.Transaction.newFromContentBranchConversion(
		this.document, this.getRange(), type, attr
	);
	this.surface.change( tx, !this.noAutoSelect && tx.translateRange( this.getRange() ) );
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
	if ( !this.surface ) {
		return this;
	}
	if ( !ve.isArray( wrapper ) ) {
		wrapper = [wrapper];
	}
	var tx = ve.dm.Transaction.newFromWrap( this.document, this.getRange(), [], [], [], wrapper );
	this.surface.change( tx, !this.noAutoSelect && tx.translateRange( this.getRange() ) );
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
	if ( !this.surface ) {
		return this;
	}
	var i, tx, innerUnwrapper = [], outerUnwrapper = [];

	if ( this.getRange( true ).end - this.getRange( true ).start < innerDepth * 2 ) {
		throw new Error( 'cannot unwrap by greater depth than maximum theoretical depth of selection' );
	}

	for ( i = 0; i < innerDepth; i++ ) {
		innerUnwrapper.push( this.surface.getDocument().data.getData( this.getRange( true ).start + i ) );
	}
	for ( i = outerDepth; i > 0; i-- ) {
		outerUnwrapper.push( this.surface.getDocument().data.getData( this.getRange( true ).start - i ) );
	}

	tx = ve.dm.Transaction.newFromWrap( this.document, this.getRange(), outerUnwrapper, [], innerUnwrapper, [] );
	this.surface.change( tx, !this.noAutoSelect && tx.translateRange( this.getRange() ) );

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
	if ( !this.surface ) {
		return this;
	}
	var i, tx, unwrapper = [];

	if ( !ve.isArray( wrapper ) ) {
		wrapper = [wrapper];
	}

	if ( this.getRange( true ).end - this.getRange( true ).start < depth * 2 ) {
		throw new Error( 'cannot unwrap by greater depth than maximum theoretical depth of selection' );
	}

	for ( i = 0; i < depth; i++ ) {
		unwrapper.push( this.surface.getDocument().data.getData( this.getRange( true ).start + i ) );
	}

	tx = ve.dm.Transaction.newFromWrap( this.document, this.getRange(), [], [], unwrapper, wrapper );
	this.surface.change( tx, !this.noAutoSelect && tx.translateRange( this.getRange() ) );

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
	if ( !this.surface ) {
		return this;
	}

	var tx;

	if ( !ve.isArray( wrapper ) ) {
		wrapper = [wrapper];
	}

	tx = ve.dm.Transaction.newFromWrap( this.document, this.getRange(), [], wrapper, [], [] );
	this.surface.change( tx, !this.noAutoSelect && tx.translateRange( this.getRange() ) );

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
 *     fragment.rewrapAllNodes( 1, { 'type': 'heading', 'attributes' : { 'level' : 2 } } );
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
	if ( !this.surface ) {
		return this;
	}
	var i, tx, unwrapper = [],
		innerRange = new ve.Range( this.getRange( true ).start + depth, this.getRange( true ).end - depth );

	if ( !ve.isArray( wrapper ) ) {
		wrapper = [wrapper];
	}

	if ( this.getRange( true ).end - this.getRange( true ).start < depth * 2 ) {
		throw new Error( 'cannot unwrap by greater depth than maximum theoretical depth of selection' );
	}

	for ( i = 0; i < depth; i++ ) {
		unwrapper.push( this.surface.getDocument().data.getData( this.getRange( true ).start + i ) );
	}

	tx = ve.dm.Transaction.newFromWrap( this.document, innerRange, unwrapper, wrapper, [], [] );
	this.surface.change( tx, !this.noAutoSelect && tx.translateRange( this.getRange() ) );

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
	if ( !this.surface ) {
		return this;
	}
	var nodes, startSplitNode, endSplitNode, tx,
		startOffset, endOffset,
		outerDepth = 0,
		factory = ve.dm.nodeFactory,
		allowedParents = factory.getSuggestedParentNodeTypes( isolateForType ),
		startSplitRequired = false,
		endSplitRequired = false,
		startSplitNodes = [],
		endSplitNodes = [],
		fragment = this;

	function createSplits( splitNodes, insertBefore ) {
		var i, length,
			startOffsetChange = 0, endOffsetChange = 0, data = [];
		for ( i = 0, length = splitNodes.length; i < length; i++ ) {
			data.unshift( { 'type': '/' + splitNodes[i].type } );
			data.push( splitNodes[i].getClonedElement() );

			if ( insertBefore ) {
				startOffsetChange += 2;
				endOffsetChange += 2;
			}
		}

		tx = ve.dm.Transaction.newFromInsertion( fragment.getDocument(), insertBefore ? startOffset : endOffset, data );
		fragment.surface.change( tx, !fragment.noAutoSelect && tx.translateRange( fragment.getRange() ) );

		startOffset += startOffsetChange;
		endOffset += endOffsetChange;
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

	if ( startSplitRequired ) {
		createSplits( startSplitNodes, true );
	}

	if ( endSplitRequired ) {
		createSplits( endSplitNodes, false );
	}

	this.unwrapNodes( outerDepth, 0 );

	return this;
};
