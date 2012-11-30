/**
 * VisualEditor AnnotationSet class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Ordered set of annotations.
 *
 * @constructor
 * @extends {ve.OrderedHashSet}
 * @param {Object[]} annotations Array of annotation objects
 */
ve.AnnotationSet = function VeAnnotationSet( annotations ) {
	// Parent constructor
	ve.OrderedHashSet.call( this, ve.getHash, annotations );
};

/* Inheritance */

ve.inheritClass( ve.AnnotationSet, ve.OrderedHashSet );

/* Methods */

/**
 * Gets a clone.
 *
 * @method
 * @returns {ve.AnnotationSet} Copy of annotation set
 */
ve.AnnotationSet.prototype.clone = function () {
	return new ve.AnnotationSet( this );
};

/**
 * Gets an annotation set containing only annotations within this set with a given name.
 *
 * @method
 * @param {String|RegExp} name Regular expression or string to compare types with
 * @returns {ve.AnnotationSet} Copy of annotation set
 */
ve.AnnotationSet.prototype.getAnnotationsByName = function ( name ) {
	return this.filter( 'name', name );
};

/**
 * Checks if any annotations in this set have a given name
 *
 * @method
 * @param {String|RegExp} name Regular expression or string to compare names with
 * @returns {Boolean} Annotation of given type exists in this set
 */
ve.AnnotationSet.prototype.hasAnnotationWithName = function ( name ) {
	return this.containsMatching( 'name', name );
};
