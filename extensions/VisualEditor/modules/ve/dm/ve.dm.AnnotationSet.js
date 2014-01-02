/*!
 * VisualEditor DataModel AnnotationSet class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Annotation set.
 *
 * @constructor
 * @param {ve.dm.IndexValueStore} store Index-value store
 * @param {number[]} [indexes] Array of store indexes
 */
ve.dm.AnnotationSet = function VeDmAnnotationSet( store, storeIndexes ) {
	// Parent constructor
	this.store = store;
	this.storeIndexes = storeIndexes || [];
};

/* Methods */

/**
 * Get the index-value store.
 *
 * @method
 * @returns {ve.dm.IndexValueStore} Index-value store
 */
ve.dm.AnnotationSet.prototype.getStore = function () {
	return this.store;
};

/**
 * Get a clone.
 *
 * @method
 * @returns {ve.dm.AnnotationSet} Copy of annotation set
 */
ve.dm.AnnotationSet.prototype.clone = function () {
	return new ve.dm.AnnotationSet( this.getStore(), this.storeIndexes.slice( 0 ) );
};

/**
 * Get an annotation set containing only annotations within the set with a specific name.
 *
 * @method
 * @param {string} name Type name
 * @returns {ve.dm.AnnotationSet} Copy of annotation set
 */
ve.dm.AnnotationSet.prototype.getAnnotationsByName = function ( name ) {
	return this.filter( function ( annotation ) { return annotation.name === name; } );
};

/**
 * Get an annotation set containing only annotations within the set which are comparable
 * to a specific annotation.
 *
 * @method
 * @param {ve.dm.Annotation} annotation Annotation to compare to
 * @returns {ve.dm.AnnotationSet} Copy of annotation set
 */
ve.dm.AnnotationSet.prototype.getComparableAnnotations = function ( annotation ) {
	return this.filter( function ( a ) {
		return ve.compare(
			annotation.getComparableObject(),
			a.getComparableObject()
		);
	} );
};

/**
 * Check if any annotations in the set have a specific name.
 *
 * @method
 * @param {string} name Type name
 * @returns {boolean} Annotation of given type exists in the set
 */
ve.dm.AnnotationSet.prototype.hasAnnotationWithName = function ( name ) {
	return this.containsMatching( function ( annotation ) { return annotation.name === name; } );
};

/**
 * Get an annotation or all annotations from the set.
 *
 * set.get( 5 ) returns the annotation at offset 5, set.get() returns an array with all annotations
 * in the entire set.
 *
 * @method
 * @param {number} [offset] If set, only get the annotation at the offset
 * @returns {ve.dm.Annotation[]|ve.dm.Annotation|undefined} The annotation at offset, or an array of all
 *  annotations in the set
 */
ve.dm.AnnotationSet.prototype.get = function ( offset ) {
	if ( offset !== undefined ) {
		return this.getStore().value( this.getIndex( offset ) );
	} else {
		return this.getStore().values( this.getIndexes() );
	}
};

/**
 * Get store index from offset within annotation set.
 * @param {number} offset Offset within annotation set
 * @returns {number} Store index at specified offset
 */
ve.dm.AnnotationSet.prototype.getIndex = function ( offset ) {
	return this.storeIndexes[offset];
};

/**
 * Get all store indexes.
 * @returns {Array} Store indexes
 */
ve.dm.AnnotationSet.prototype.getIndexes = function () {
	return this.storeIndexes;
};

/**
 * Get the length of the set.
 *
 * @method
 * @returns {number} The number of annotations in the set
 */
ve.dm.AnnotationSet.prototype.getLength = function () {
	return this.storeIndexes.length;
};

/**
 * Check if the set is empty.
 *
 * @method
 * @returns {boolean} The set is empty
 */
ve.dm.AnnotationSet.prototype.isEmpty = function () {
	return this.getLength() === 0;
};

/**
 * Check whether a given annotation occurs in the set.
 *
 * Annotations are compared by store index.
 *
 * @method
 * @param {ve.dm.Annotation} annotation Annotation
 * @returns {boolean} There is an annotation in the set with the same hash as annotation
 */
ve.dm.AnnotationSet.prototype.contains = function ( annotation ) {
	return this.offsetOf( annotation ) !== -1;
};

/**
 * Check whether a given store index occurs in the set.
 *
 * @method
 * @param {number} storeIndex Store index of annotation
 * @returns {boolean} There is an annotation in the set with this store index
 */
ve.dm.AnnotationSet.prototype.containsIndex = function ( storeIndex ) {
	return ve.indexOf( storeIndex, this.getIndexes() ) !== -1;
};

/**
 * Check whether the set contains any of the annotations in another set.
 *
 * @method
 * @param {ve.dm.AnnotationSet} set Set to compare the set with
 * @returns {boolean} There is at least one annotation in set that is also in the set
 */
ve.dm.AnnotationSet.prototype.containsAnyOf = function ( set ) {
	var i, length, setIndexes = set.getIndexes(), thisIndexes = this.getIndexes();
	for ( i = 0, length = setIndexes.length; i < length; i++ ) {
		if ( ve.indexOf( setIndexes[i], thisIndexes ) !== -1 ) {
			return true;
		}
	}
	return false;
};

/**
 * Check whether the set contains all of the annotations in another set.
 *
 * @method
 * @param {ve.dm.AnnotationSet} set Set to compare the set with
 * @returns {boolean} All annotations in set are also in the set
 */
ve.dm.AnnotationSet.prototype.containsAllOf = function ( set ) {
	var i, length, setIndexes = set.getIndexes(), thisIndexes = this.getIndexes();
	for ( i = 0, length = setIndexes.length; i < length; i++ ) {
		if ( ve.indexOf( setIndexes[i], thisIndexes ) === -1 ) {
			return false;
		}
	}
	return true;
};

/**
 * Get the offset of a given annotation in the set.
 *
 * @method
 * @param {ve.dm.Annotation} annotation Annotation to search for
 * @returns {number} Offset of annotation in the set, or -1 if annotation is not in the set.
 */
ve.dm.AnnotationSet.prototype.offsetOf = function ( annotation ) {
	return this.offsetOfIndex( this.store.indexOfHash( ve.getHash( annotation ) ) );
};

/**
 * Get the offset of a given annotation in the set by store index.
 *
 * @method
 * @param {number} storeIndex Store index of annotation to search for
 * @returns {number} Offset of annotation in the set, or -1 if annotation is not in the set.
 */
ve.dm.AnnotationSet.prototype.offsetOfIndex = function ( storeIndex ) {
	return ve.indexOf( storeIndex, this.getIndexes() );
};

/**
 * Filter the set by an item property.
 *
 * This returns a new set with all annotations in the set for which the callback returned true for.
 *
 * @method
 * @param {Function} callback Function that takes an annotation and returns boolean true to include
 * @param {boolean} [returnBool] For internal use only
 * @returns {ve.dm.AnnotationSet} New set containing only the matching annotations
 */
ve.dm.AnnotationSet.prototype.filter = function ( callback, returnBool ) {
	var i, length, result, storeIndex, annotation;

	if ( !returnBool ) {
		result = this.clone();
		// TODO: Should we be returning this on all methods that modify the original? Might help
		// with chainability, but perhaps it's also confusing because most chainable methods return
		// a new hash set.
		result.removeAll();
	}
	for ( i = 0, length = this.getLength(); i < length; i++ ) {
		storeIndex = this.getIndex( i );
		annotation = this.getStore().value( storeIndex );
		if ( callback( annotation ) ) {
			if ( returnBool ) {
				return true;
			} else {
				result.storeIndexes.push( storeIndex );
			}
		}
	}
	return returnBool ? false : result;
};

/**
 * Check if the set contains an annotation comparable to the specified one.
 *
 * getComparableObject is used to compare the annotations, and should return
 * true if an annotation is found which is mergeable with the specified one.
 *
 * @param {ve.dm.Annotation} annotation Annotation to compare to
 * @returns {boolean} At least one comprable annotation found
 */
ve.dm.AnnotationSet.prototype.containsComparable = function ( annotation ) {
	return this.filter( function ( a ) {
		return ve.compare(
			annotation.getComparableObject(),
			a.getComparableObject()
		);
	}, true );
};

/**
 * HACK: Check if the set contains an annotation comparable to the specified one
 * for the purposes of serialization.
 *
 * This method uses getComparableObjectForSerialization which also includes
 * HTML attributes.
 *
 * @param {ve.dm.Annotation} annotation Annotation to compare to
 * @returns {boolean} At least one comprable annotation found
 */
ve.dm.AnnotationSet.prototype.containsComparableForSerialization = function ( annotation ) {
	return this.filter( function ( a ) {
		return annotation.compareToForSerialization( a );
	}, true );
};

/**
 * Check if the set contains at least one annotation where a given property matches a given filter.
 *
 * This is equivalent to (but more efficient than) `!this.filter( .. ).isEmpty()`.
 *
 * @see ve.dm.AnnotationSet#filter
 *
 * @method
 * @param {Function} callback Function that takes an annotation and returns boolean true to include
 * @returns {boolean} At least one matching annotation found
 */
ve.dm.AnnotationSet.prototype.containsMatching = function ( callback ) {
	return this.filter( callback, true );
};

/**
 * Check if the set contains the same annotations as another set.
 *
 * Compares annotations by their comparable object value.
 *
 * @method
 * @param {ve.dm.AnnotationSet} annotationSet The annotationSet to compare this one to
 * @returns {boolean} The annotations are the same
 */
ve.dm.AnnotationSet.prototype.compareTo = function ( annotationSet ) {
	var i, length = this.getIndexes().length;

	if ( length === annotationSet.getLength() ) {
		for ( i = 0; i < length; i++ ) {
			if ( !annotationSet.containsComparable( this.get( i ) ) ) {
				return false;
			}
		}
	} else {
		return false;
	}
	return true;
};

/**
 * Add an annotation to the set.
 *
 * If the annotation is already present in the set, nothing happens.
 *
 * The annotation will be inserted before the annotation that is currently at the given offset. If offset is
 * negative, it will be counted from the end (i.e. offset -1 is the last item, -2 the second-to-last,
 * etc.). If offset is out of bounds, the annotation will be added to the end of the set.
 *
 * @method
 * @param {ve.dm.Annotation} annotation Annotation to add
 * @param {number} offset Offset to add the annotation at
 */
ve.dm.AnnotationSet.prototype.add = function ( annotation, offset ) {
	var storeIndex = this.getStore().index( annotation );
	// negative offset
	if ( offset < 0 ) {
		offset = this.getLength() + offset;
	}
	// greater than length, add to end
	if ( offset >= this.getLength() ) {
		this.push( annotation );
		return;
	}
	// if not in set already, splice in place
	if ( !this.containsIndex( storeIndex ) ) {
		this.storeIndexes.splice( offset, 0, storeIndex );
	}
};

/**
 * Add all annotations in the given set to the end of the set.
 *
 * Annotations from the other set that are already in the set will not be added again.
 *
 * @method
 * @param {ve.dm.AnnotationSet} set Set to add to the set
 */
ve.dm.AnnotationSet.prototype.addSet = function ( set ) {
	this.storeIndexes = ve.simpleArrayUnion( this.getIndexes(), set.getIndexes() );
};

/**
 * Add an annotation at the end of the set.
 *
 * @method
 * @param {ve.dm.Annotation} annotation Annotation to add
 */
ve.dm.AnnotationSet.prototype.push = function ( annotation ) {
	this.pushIndex( this.getStore().index( annotation ) );
};

/**
 * Add an annotation at the end of the set by store index.
 *
 * @method
 * @param {number} storeIndex Store index of annotation to add
 */
ve.dm.AnnotationSet.prototype.pushIndex = function ( storeIndex ) {
	this.storeIndexes.push( storeIndex );
};

/**
 * Remove the annotation at a given offset.
 *
 * @method
 * @param {number} offset Offset to remove item at. If negative, the counts from the end, see add()
 * @throws {Error} Offset out of bounds.
 */
ve.dm.AnnotationSet.prototype.removeAt = function ( offset ) {
	if ( offset < 0 ) {
		offset = this.getLength() + offset;
	}
	if ( offset >= this.getLength() ) {
		throw new Error( 'Offset out of bounds' );
	}
	this.storeIndexes.splice( offset, 1 );
};

/**
 * Remove a given annotation from the set by store index.
 *
 * If the annotation isn't in the set, nothing happens.
 *
 * @method
 * @param {number} storeIndex Store index of annotation to remove
 */
ve.dm.AnnotationSet.prototype.removeIndex = function ( storeIndex ) {
	var offset = this.offsetOfIndex( storeIndex );
	if ( offset !== -1 ) {
		this.storeIndexes.splice( offset, 1 );
	}
};

/**
 * Remove a given annotation from the set.
 *
 * If the annotation isn't in the set, nothing happens.
 *
 * @method
 * @param {ve.dm.Annotation} annotation Annotation to remove
 */
ve.dm.AnnotationSet.prototype.remove = function ( annotation ) {
	var offset = this.offsetOf( annotation );
	if ( offset !== -1 ) {
		this.storeIndexes.splice( offset, 1 );
	}
};

/**
 * Remove all annotations.
 *
 * @method
 */
ve.dm.AnnotationSet.prototype.removeAll = function () {
	this.storeIndexes = [];
};

/**
 * Remove all annotations in a given set from the set.
 *
 * Annotations that aren't in the set are ignored.
 *
 * @method
 * @param {ve.dm.AnnotationSet} set Set to remove from the set
 */
ve.dm.AnnotationSet.prototype.removeSet = function ( set ) {
	this.storeIndexes = ve.simpleArrayDifference( this.getIndexes(), set.getIndexes() );
};

/**
 * Remove all annotations that are not also in a given other set from the set.
 *
 * @method
 * @param {ve.dm.AnnotationSet} set Set to intersect with the set
 */
ve.dm.AnnotationSet.prototype.removeNotInSet = function ( set ) {
	this.storeIndexes = ve.simpleArrayIntersection( this.getIndexes(), set.getIndexes() );
};

/**
 * Reverse the set.
 *
 * This returns a copy, the original set is not modified.
 *
 * @method
 * @returns {ve.dm.AnnotationSet} Copy of the set with the order reversed.
 */
ve.dm.AnnotationSet.prototype.reversed = function () {
	var newSet = this.clone();
	newSet.storeIndexes.reverse();
	return newSet;
};

/**
 * Merge another set into the set.
 *
 * This returns a copy, the original set is not modified.
 *
 * @method
 * @param {ve.dm.AnnotationSet} set Other set
 * @returns {ve.dm.AnnotationSet} Set containing all annotations in the set as well as all annotations in set
 */
ve.dm.AnnotationSet.prototype.mergeWith = function ( set ) {
	var newSet = this.clone();
	newSet.addSet( set );
	return newSet;
};

/**
 * Get the difference between the set and another set.
 *
 * @method
 * @param {ve.dm.AnnotationSet} set Other set
 * @returns {ve.dm.AnnotationSet} New set containing all annotations that are in the set but not in set
 */
ve.dm.AnnotationSet.prototype.diffWith = function ( set ) {
	var newSet = this.clone();
	newSet.removeSet( set );
	return newSet;
};

/**
 * Get the intersection of the set with another set.
 *
 * @method
 * @param {ve.dm.AnnotationSet} set Other set
 * @returns {ve.dm.AnnotationSet} New set containing all annotations that are both in the set and in set
 */
ve.dm.AnnotationSet.prototype.intersectWith = function ( set ) {
	var newSet = this.clone();
	newSet.removeNotInSet( set );
	return newSet;
};
