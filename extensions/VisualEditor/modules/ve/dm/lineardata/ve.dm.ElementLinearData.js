/*!
 * VisualEditor ElementLinearData classes.
 *
 * Class containing element linear data and an index-value store.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Element linear data storage
 *
 * @class
 * @extends ve.dm.LinearData
 * @constructor
 * @param {ve.dm.IndexValueStore} store Index-value store
 * @param {Array} [data] Linear data
 */
ve.dm.ElementLinearData = function VeDmElementLinearData( store, data ) {
	ve.dm.LinearData.call( this, store, data );
};

/* Inheritance */

ve.inheritClass( ve.dm.ElementLinearData, ve.dm.LinearData );

/* Methods */

/**
 * Get the type of the element at a specified offset
 * @method
 * @param {number} offset Document offset
 * @returns {string} Type of the element
 */
ve.dm.ElementLinearData.prototype.getType = function ( offset ) {
	return ve.dm.LinearData.static.getType( this.getData( offset ) );
};

/**
 * Check if data at a given offset is an element.
 * @method
 * @param {number} offset Document offset
 * @returns {boolean} Data at offset is an element
 */
ve.dm.ElementLinearData.prototype.isElementData = function ( offset ) {
	return ve.dm.LinearData.static.isElementData( this.getData( offset ) );
};

/**
 * Checks if data at a given offset is an open element.
 * @method
 * @param {number} offset Document offset
 * @returns {boolean} Data at offset is an open element
 */
ve.dm.ElementLinearData.prototype.isOpenElementData = function ( offset ) {
	return ve.dm.LinearData.static.isOpenElementData( this.getData( offset ) );
};

/**
 * Checks if data at a given offset is a close element.
 * @method
 * @param {number} offset Document offset
 * @returns {boolean} Data at offset is a close element
 */
ve.dm.ElementLinearData.prototype.isCloseElementData = function ( offset ) {
	return ve.dm.LinearData.static.isCloseElementData( this.getData( offset ) );
};

/**
 * Check if content can be inserted at an offset in document data.
 *
 * This method assumes that any value that has a type property that's a string is an element object.
 *
 * Content offsets:
 *
 *      <heading> a </heading> <paragraph> b c <img> </img> </paragraph>
 *     .         ^ ^          .           ^ ^ ^     .      ^            .
 *
 * Content offsets:
 *
 *      <list> <listItem> </listItem> <list>
 *     .      .          .           .      .
 *
 * @method
 * @param {number} offset Document offset
 * @returns {boolean} Content can be inserted at offset
 */
ve.dm.ElementLinearData.prototype.isContentOffset = function ( offset ) {
	// Edges are never content
	if ( offset === 0 || offset === this.getLength() ) {
		return false;
	}
	var left = this.getData( offset - 1 ),
		right = this.getData( offset ),
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
 * Check if structure can be inserted at an offset in document data.
 *
 * If the {unrestricted} param is true than only offsets where any kind of element can be inserted
 * will return true. This can be used to detect the difference between a location that a paragraph
 * can be inserted, such as between two tables but not direclty inside a table.
 *
 * This method assumes that any value that has a type property that's a string is an element object.
 *
 * Structural offsets (unrestricted = false):
 *
 *      <heading> a </heading> <paragraph> b c <img> </img> </paragraph>
 *     ^         . .          ^           . . .     .      .            ^
 *
 * Structural offsets (unrestricted = true):
 *
 *      <heading> a </heading> <paragraph> b c <img> </img> </paragraph>
 *     ^         . .          ^           . . .     .      .            ^
 *
 * Structural offsets (unrestricted = false):
 *
 *      <list> <listItem> </listItem> <list>
 *     ^      ^          ^           ^      ^
 *
 * Content branch offsets (unrestricted = true):
 *
 *      <list> <listItem> </listItem> <list>
 *     ^      .          ^           .      ^
 *
 * @method
 * @param {number} offset Document offset
 * @param {boolean} [unrestricted] Only return true if any kind of element can be inserted at offset
 * @returns {boolean} Structure can be inserted at offset
 */
ve.dm.ElementLinearData.prototype.isStructuralOffset = function ( offset, unrestricted ) {
	// Edges are always structural
	if ( offset === 0 || offset === this.getLength() ) {
		return true;
	}
	// Offsets must be within range and both sides must be elements
	var left = this.getData( offset - 1 ),
		right = this.getData( offset ),
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
				factory.canNodeHaveChildrenNotContent( left.type ) &&
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
 * Check for elements in document data.
 *
 * This method assumes that any value that has a type property that's a string is an element object.
 * Elements are discovered by iterating through the entire data array (backwards).
 *
 * @method
 * @returns {boolean} At least one elements exists in data
 */
ve.dm.ElementLinearData.prototype.containsElementData = function () {
	var i = this.getLength();
	while ( i-- ) {
		if ( this.getData( i ).type !== undefined ) {
			return true;
		}
	}
	return false;
};

/**
 * Check for non-content elements in document data.
 *
 * This method assumes that any value that has a type property that's a string is an element object.
 * Elements are discovered by iterating through the entire data array.
 *
 * @method
 * @returns {boolean} True if all elements in data are content elements
 */
ve.dm.ElementLinearData.prototype.isContentData = function () {
	var item, i = this.getLength();
	while ( i-- ) {
		item = this.getData( i );
		if ( item.type !== undefined &&
			item.type.charAt( 0 ) !== '/' &&
			!ve.dm.nodeFactory.isNodeContent( item.type )
		) {
			return false;
		}
	}
	return true;
};

/**
 * Get annotations' store indexes covered by an offset.
 *
 * @method
 * @param {number} offset Offset to get annotations for
 * @returns {number[]} An array of annotation store indexes the offset is covered by
 * @throws {Error} offset out of bounds
 */
ve.dm.ElementLinearData.prototype.getAnnotationIndexesFromOffset = function ( offset ) {
	if ( offset < 0 || offset > this.getLength() ) {
		throw new Error( 'offset ' + offset + ' out of bounds' );
	}
	var element = this.getData( offset );
	// Since annotations are not stored on a closing leaf node,
	// rewind offset by 1 to return annotations for that structure
	if (
		ve.isPlainObject( element ) && // structural offset
		element.hasOwnProperty( 'type' ) && // just in case
		element.type.charAt( 0 ) === '/' && // closing offset
		ve.dm.nodeFactory.canNodeHaveChildren(
			element.type.substr( 1 )
		) === false // leaf node
	) {
		offset = this.getRelativeContentOffset( offset, -1 );
		element = this.getData( offset );
	}

	if ( element === undefined || typeof element === 'string' ) {
		return [];
	} else {
		return element.annotations || element[1] || [];
	}
};

/**
 * Get annotations covered by an offset.
 *
 * The returned AnnotationSet is a clone of the one in the document data.
 *
 * @method
 * @param {number} offset Offset to get annotations for
 * @returns {ve.dm.AnnotationSet} A set of all annotation objects offset is covered by
 * @throws {Error} offset out of bounds
 */
ve.dm.ElementLinearData.prototype.getAnnotationsFromOffset = function ( offset ) {
	return new ve.dm.AnnotationSet( this.getStore(), this.getAnnotationIndexesFromOffset( offset ) );
};

/**
 * Set annotations of data at a specified offset.
 *
 * Cleans up data structure if annotation set is empty.
 *
 * @method
 * @param {number} offset Offset to set annotations at
 * @param {ve.dm.AnnotationSet} annotations Annotations to set
 */
ve.dm.ElementLinearData.prototype.setAnnotationsAtOffset = function ( offset, annotations ) {
	var character, item = this.getData( offset ), isElement = this.isElementData( offset );
	if ( !annotations.isEmpty() ) {
		if ( isElement ) {
			// New element annotation
			item.annotations = this.getStore().indexes( annotations.get() );
		} else {
			// New character annotation
			character = this.getCharacterData( offset );
			this.setData( offset, [character, this.getStore().indexes( annotations.get() )] );
		}
	} else {
		if ( isElement ) {
			// Cleanup empty element annotation
			delete item.annotations;
		} else {
			// Cleanup empty character annotation
			character = this.getCharacterData( offset );
			this.setData( offset, character );
		}
	}
};

/** */
ve.dm.ElementLinearData.prototype.getCharacterData = function ( offset ) {
	var item = this.getData( offset );
	return ve.isArray( item ) ? item[0] : item;
};

/**
 * Gets the range of content surrounding a given offset that's covered by a given annotation.
 *
 * @method
 * @param {number} offset Offset to begin looking forward and backward from
 * @param {Object} annotation Annotation to test for coverage with
 * @returns {ve.Range|null} Range of content covered by annotation, or null if offset is not covered
 */
ve.dm.ElementLinearData.prototype.getAnnotatedRangeFromOffset = function ( offset, annotation ) {
	var start = offset,
		end = offset;
	if ( this.getAnnotationsFromOffset( offset ).contains( annotation ) === false ) {
		return null;
	}
	while ( start > 0 ) {
		start--;
		if ( this.getAnnotationsFromOffset( start ).contains( annotation ) === false ) {
			start++;
			break;
		}
	}
	while ( end < this.getLength() ) {
		if ( this.getAnnotationsFromOffset( end ).contains( annotation ) === false ) {
			break;
		}
		end++;
	}
	return new ve.Range( start, end );
};


/**
 * Get the range of an annotation found within a range.
 *
 * @method
 * @param {number} offset Offset to begin looking forward and backward from
 * @param {ve.dm.Annotation} annotation Annotation to test for coverage with
 * @returns {ve.Range|null} Range of content covered by annotation, or a copy of the range
 */
ve.dm.ElementLinearData.prototype.getAnnotatedRangeFromSelection = function ( range, annotation ) {
	var start = range.start,
		end = range.end;
	while ( start > 0 ) {
		start--;
		if ( this.getAnnotationsFromOffset( start ).contains( annotation ) === false ) {
			start++;
			break;
		}
	}
	while ( end < this.getLength() ) {
		if ( this.getAnnotationsFromOffset( end ).contains( annotation ) === false ) {
			break;
		}
		end++;
	}
	return new ve.Range( start, end );
};

/**
 * Get annotations common to all content in a range.
 *
 * @method
 * @param {ve.Range} range Range to get annotations for
 * @param {boolean} [all] Get all annotations found within the range, not just those that cover it
 * @returns {ve.dm.AnnotationSet} All annotation objects range is covered by
 */
ve.dm.ElementLinearData.prototype.getAnnotationsFromRange = function ( range, all ) {
	var i, left, right;
	// Look at left side of range for annotations
	left = this.getAnnotationsFromOffset( range.start );
	// Shortcut for single character and zero-length ranges
	if ( range.getLength() === 0 || range.getLength() === 1 ) {
		return left;
	}
	// Iterator over the range, looking for annotations, starting at the 2nd character
	for ( i = range.start + 1; i < range.end; i++ ) {
		// Skip non-content data
		if ( this.isElementData( i ) && !ve.dm.nodeFactory.isNodeContent( this.getType( i ) ) ) {
			continue;
		}
		// Current character annotations
		right = this.getAnnotationsFromOffset( i );
		if ( all && !right.isEmpty() ) {
			left.addSet( right );
		} else if ( !all ) {
			// A non annotated character indicates there's no full coverage
			if ( right.isEmpty() ) {
				return new ve.dm.AnnotationSet( this.getStore() );
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
 * Get a range without any whitespace content at the beginning and end.
 *
 * @method
 * @param {ve.Range} [range] Range of data to get, all data will be given by default
 * @returns {Object} A new range if modified, otherwise returns passed range
 */
ve.dm.ElementLinearData.prototype.trimOuterSpaceFromRange = function ( range ) {
	var start = range.start,
		end = range.end;
	while ( this.getCharacterData( end - 1 ) === ' ' ) {
		end--;
	}
	while ( start < end && this.getCharacterData( start ) === ' ' ) {
		start++;
	}
	return range.to < range.end ? new ve.Range( end, start ) : new ve.Range( start, end );
};

/**
 * Get an offset at a distance to an offset that passes a validity test.
 *
 * - If {offset} is not already valid, one step will be used to move it to a valid one.
 * - If {offset} is already valid and cannot be moved in the direction of {distance} and still be
 *   valid, it will be left where it is
 * - If {distance} is zero the result will either be {offset} if it's already valid or the
 *   nearest valid offset to the right if possible and to the left otherwise.
 * - If {offset} is after the last valid offset and {distance} is >= 1, or if {offset} if
 *   before the first valid offset and {distance} <= 1 than the result will be the nearest
 *   valid offset in the opposite direction.
 * - If the document does not contain a single valid offset the result will be -1
 *
 * @method
 * @param {number} offset Offset to start from
 * @param {number} distance Number of valid offsets to move
 * @param {Function} callback Function to call to check if an offset is valid which will be
 * given initial argument of offset
 * @param {Mixed...} [args] Additional arguments to pass to the callback
 * @returns {number} Relative valid offset or -1 if there are no valid offsets in document
 */
ve.dm.ElementLinearData.prototype.getRelativeOffset = function ( offset, distance, callback ) {
	var i, direction,
		args = Array.prototype.slice.call( arguments, 3 ),
		start = offset,
		steps = 0,
		turnedAround = false;
	// If offset is already a structural offset and distance is zero than no further work is needed,
	// otherwise distance should be 1 so that we can get out of the invalid starting offset
	if ( distance === 0 ) {
		if ( callback.apply( this, [offset].concat( args ) ) ) {
			return offset;
		} else {
			distance = 1;
		}
	}
	// Initial values
	direction = (
		offset <= 0 ? 1 : (
			offset >= this.getLength() ? -1 : (
				distance > 0 ? 1 : -1
			)
		)
	);
	distance = Math.abs( distance );
	i = start + direction;
	offset = -1;
	// Iteration
	while ( i >= 0 && i <= this.getLength() ) {
		if ( callback.apply( this, [i].concat( args ) ) ) {
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
			( ( direction < 0 && i === 0 ) || ( direction > 0 && i === this.getLength() ) )
		) {
			// Before we turn around, let's see if we are at a valid position
			if ( callback.apply( this, [start].concat( args ) ) ) {
				// Stay where we are
				return start;
			}
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
 * Get a content offset at a distance from an offset.
 *
 * This method is a wrapper around {getRelativeOffset}, using {ve.dm.Document.isContentOffset} as
 * the offset validation callback.
 *
 * @method
 * @param {number} offset Offset to start from
 * @param {number} distance Number of content offsets to move
 * @returns {number} Relative content offset or -1 if there are no valid offsets in document
 */
ve.dm.ElementLinearData.prototype.getRelativeContentOffset = function ( offset, distance ) {
	return this.getRelativeOffset( offset, distance, this.constructor.prototype.isContentOffset );
};

/**
 * Get the nearest content offset to an offset.
 *
 * If the offset is already a valid offset, it will be returned unchanged. This method differs from
 * calling {getRelativeContentOffset} with a zero length difference because the direction can be
 * controlled without necessarily moving the offset if it's already valid. Also, if the direction
 * is 0 or undefined than nearest offsets will be found to the left and right and the one with the
 * shortest distance will be used.
 *
 * This method is a wrapper around {getRelativeOffset}, using {this.isContentOffset} as
 * the offset validation callback.
 *
 * @method
 * @param {number} offset Offset to start from
 * @param {number} [direction] Direction to prefer matching offset in, -1 for left and 1 for right
 * @returns {number} Nearest content offset or -1 if there are no valid offsets in document
 */
ve.dm.ElementLinearData.prototype.getNearestContentOffset = function ( offset, direction ) {
	if ( this.isContentOffset( offset ) ) {
		return offset;
	}
	if ( direction === undefined ) {
		var left = this.getRelativeOffset( offset, -1, this.constructor.prototype.isContentOffset ),
			right = this.getRelativeOffset( offset, 1, this.constructor.prototype.isContentOffset );
		return offset - left < right - offset ? left : right;
	} else {
		return this.getRelativeOffset(
			offset, direction > 0 ? 1 : -1, this.constructor.prototype.isContentOffset
		);
	}
};

/**
 * Get a structural offset at a distance from an offset.
 *
 * This method is a wrapper around {getRelativeOffset}, using {this.isStructuralOffset} as
 * the offset validation callback.
 *
 * @method
 * @param {number} offset Offset to start from
 * @param {number} distance Number of structural offsets to move
 * @param {boolean} [unrestricted] Only consider offsets where any kind of element can be inserted
 * @returns {number} Relative structural offset
 */
ve.dm.ElementLinearData.prototype.getRelativeStructuralOffset = function ( offset, distance, unrestricted ) {
	// Optimization: start and end are always unrestricted structural offsets
	if ( distance === 0 && ( offset === 0 || offset === this.getLength() ) ) {
		return offset;
	}
	return this.getRelativeOffset(
		offset, distance, this.constructor.prototype.isStructuralOffset, unrestricted
	);
};

/**
 * Get the nearest structural offset to an offset.
 *
 * If the offset is already a valid offset, it will be returned unchanged. This method differs from
 * calling {getRelativeStructuralOffset} with a zero length difference because the direction can be
 * controlled without necessarily moving the offset if it's already valid. Also, if the direction
 * is 0 or undefined than nearest offsets will be found to the left and right and the one with the
 * shortest distance will be used.
 *
 * This method is a wrapper around {getRelativeOffset}, using {this.isStructuralOffset} as
 * the offset validation callback.
 *
 * @method
 * @param {number} offset Offset to start from
 * @param {number} [direction] Direction to prefer matching offset in, -1 for left and 1 for right
 * @param {boolean} [unrestricted] Only consider offsets where any kind of element can be inserted
 * @returns {number} Nearest structural offset
 */
ve.dm.ElementLinearData.prototype.getNearestStructuralOffset = function ( offset, direction, unrestricted ) {
	if ( this.isStructuralOffset( offset, unrestricted ) ) {
		return offset;
	}
	if ( !direction ) {
		var left = this.getRelativeOffset(
				offset, -1, this.constructor.prototype.isStructuralOffset, unrestricted
			),
			right = this.getRelativeOffset(
				offset, 1, this.constructor.prototype.isStructuralOffset, unrestricted
			);
		return offset - left < right - offset ? left : right;
	} else {
		return this.getRelativeOffset(
			offset, direction > 0 ? 1 : -1, this.constructor.prototype.isStructuralOffset, unrestricted
		);
	}
};

/**
 * Get the nearest word boundaries as a range.
 *
 * The offset will first be moved to the nearest content offset if it's not at one already.
 * Elements are always word boundaries.
 *
 * @method
 * @param {number} offset Offset to start from
 * @returns {ve.Range} Range around nearest word boundaries
 */
ve.dm.ElementLinearData.prototype.getNearestWordRange = function ( offset ) {
	var offsetLeft, offsetRight,
		dataString = new ve.dm.DataString( this.getData() );

	offset = this.getNearestContentOffset( offset );

	// If the cursor offset is a break (i.e. the start/end of word) we should
	// check one position either side to see if there is a non-break
	// and if so, move the offset accordingly
	if ( unicodeJS.wordbreak.isBreak( dataString, offset ) ) {
		if ( !unicodeJS.wordbreak.isBreak( dataString, offset + 1 ) ) {
			offset++;
		} else if ( !unicodeJS.wordbreak.isBreak( dataString, offset - 1 ) ) {
			offset--;
		} else {
			return new ve.Range( offset );
		}
	}

	offsetRight = unicodeJS.wordbreak.nextBreakOffset( dataString, offset );
	offsetLeft = unicodeJS.wordbreak.prevBreakOffset( dataString, offset );

	return new ve.Range( offsetLeft, offsetRight );
};

/**
 * Finds all instances of items being stored in the index-value store for this data store
 *
 * Currently this is just all annotations still in use.
 *
 * @method
 * @returns {Object} Object containing all store values, indexed by store index
 */
ve.dm.ElementLinearData.prototype.getUsedStoreValues = function () {
	var i, indexes, j, valueStore = {};
	i = this.getLength();
	while ( i-- ) {
		// Annotations
		indexes = this.getAnnotationIndexesFromOffset( i );
		j = indexes.length;
		while ( j-- ) {
			// Just flag item as in use for now - we will add its value
			// in a separate loop to avoid multiple store lookups
			valueStore[indexes[j]] = true;
		}
	}
	for ( i in valueStore ) {
		// Fill in actual store values
		valueStore[i] = this.getStore().value( i );
	}
	return valueStore;
};

/**
 * Remap the store indexes used in this linear data.
 *
 * Remaps annotations and calls remapStoreIndexes() on each node.
 *
 * @method
 * @param {Object} mapping Mapping from store indexes to store indexes
 */
ve.dm.ElementLinearData.prototype.remapStoreIndexes = function ( mapping ) {
	var i, ilen, j, jlen, indexes, nodeClass;
	for ( i = 0, ilen = this.data.length; i < ilen; i++ ) {
		indexes = this.getAnnotationIndexesFromOffset( i ); // returns by reference
		for ( j = 0, jlen = indexes.length; j < jlen; j++ ) {
			indexes[j] = mapping[indexes[j]];
		}
		if ( this.isOpenElementData( i ) ) {
			nodeClass = ve.dm.nodeFactory.lookup( this.getType( i ) );
			nodeClass.static.remapStoreIndexes( this.data[i], mapping );
		}
	}
};

/**
 * Remap the internal list indexes used in this linear data.
 *
 * Calls remapInternalListIndexes() for each node.
 *
 * @method
 * @param {Object} mapping Mapping from internal list indexes to internal list indexes
 */
ve.dm.ElementLinearData.prototype.remapInteralListIndexes = function ( mapping ) {
	var i, ilen, nodeClass;
	for ( i = 0, ilen = this.data.length; i < ilen; i++ ) {
		if ( this.isOpenElementData( i ) ) {
			nodeClass = ve.dm.nodeFactory.lookup( this.getType( i ) );
			nodeClass.static.remapInternalListIndexes( this.data[i], mapping );
		}
	}
};

/**
 * Sliced element linear data storage
 *
 * @class
 * @extends ve.dm.ElementLinearData
 * @mixins ve.dm.SlicedLinearData
 * @constructor
 * @param {ve.dm.IndexValueStore} store Index-value store
 * @param {Array} [data] Linear data
 * @param {ve.Range} [range] Original context within data
 */
ve.dm.ElementLinearDataSlice = function VeDmElementLinearDataSlice( store, data, range ) {
	ve.dm.ElementLinearData.call( this, store, data );

	// Mixins
	ve.dm.SlicedLinearData.call( this, range );
};

/* Inheritance */

ve.inheritClass( ve.dm.ElementLinearDataSlice, ve.dm.ElementLinearData );

ve.mixinClass( ve.dm.ElementLinearDataSlice, ve.dm.SlicedLinearData );
