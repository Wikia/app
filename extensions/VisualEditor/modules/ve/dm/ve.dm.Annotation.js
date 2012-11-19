/**
 * VisualEditor data model Annotation class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Generic data model annotation.
 *
 * This is an abstract class, annotations should extend this and call this constructor from their
 * constructor. You should not instantiate this class directly.
 *
 * Annotations in the linear model are instances of subclasses of this class. Subclasses are
 * required to have a constructor with the same signature.
 *
 * this.htmlTagName and this.htmlAttributes are private to the base class, subclasses must not
 * use them. Any information from the HTML element that is needed later should be extracted into
 * this.data by overriding getAnnotationData(). Subclasses can read from this.data but must not
 * write to it directly.
 *
 * TODO: Make this constructor optionally accept a data object instead of an element.
 *
 * @class
 * @abstract
 * @constructor
 *
 * @param {HTMLElement} [element] HTML element this annotation was converted from, if any
 */
ve.dm.Annotation = function VeDmAnnotation( element ) {
	this.name = this.constructor.static.name; // Needed for proper hashing
	this.data = {};
	if ( element ) {
		this.htmlTagName = element.nodeName.toLowerCase();
		this.htmlAttributes = ve.getDOMAttributes( element );
		this.data = this.getAnnotationData( element );
	}
};

/* Static properties */

/**
 * Object containing static properties. ve.inheritClass() contains special logic to make sure these
 * properties are inherited by subclasses.
 */
ve.dm.Annotation.static = {};

/**
 * Symbolic name for the annotation class. Must be set to a unique string by every subclass.
 */
ve.dm.Annotation.static.name = null;

/**
 * Array of HTML tag names that this annotation should be a match candidate for.
 * Empty array means none, null means any.
 * For more information about annotation matching, see ve.dm.AnnotationFactory.
 */
ve.dm.Annotation.static.matchTagNames = null;

/**
 * Array of RDFa types that this annotation should be a match candidate for.
 * Empty array means none, null means any.
 * For more information about annotation matching, see ve.dm.AnnotationFactory.
 */
ve.dm.Annotation.static.matchRdfaTypes = null;

/**
 * Optional function to determine whether this annotation should match a given element.
 * Takes an HTMLElement and returns true or false.
 * This function is only called if this annotation has a chance of "winning"; see
 * ve.dm.AnnotationFactory for more information about annotation matching.
 * If set to null, this property is ignored. Setting this to null is not the same as unconditionally
 * returning true, because the presence or absence of a matchFunction affects the annotation's
 * specificity.
 *
 * NOTE: This function is NOT a method, within this function "this" will not refer to an instance
 * of this class (or to anything reasonable, for that matter).
 */
ve.dm.Annotation.static.matchFunction = null;

/* Methods */

/**
 * Get annotation data for the linear model. Called when building a new annotation from an HTML
 * element.
 *
 * This annotation data object is completely free-form. It's stored in the linear model, it can be
 * manipulated by UI widgets, and you access it as this.data in toHTML() on the way out and in
 * renderHTML() for rendering. It is also the ONLY data you can reliably use in those contexts, so
 * any information from the HTML element that you'll need later should be extracted into the data
 * object here.
 *
 * @param {HTMLElement} element HTML element this annotation will represent
 * @returns {Object} Annotation data
 */
ve.dm.Annotation.prototype.getAnnotationData = function () {
	return {};
};

/**
 * Convert this annotation back to HTML for output purposes.
 *
 * You should only use this.data here, you cannot reliably use any of the other properties.
 * The default action is to restore the original HTML element's tag name and attributes (if this
 * annotation was created based on an element). If a subclass wants to do this too (this is common),
 * it should call its parent's implementation first, then manipulate the return value.
 *
 * @returns {Object} Object with 'tag' (tag name) and 'attributes' (object with attribute key/values)
 */
ve.dm.Annotation.prototype.toHTML = function () {
	return {
		'tag': this.htmlTagName || '',
		'attributes': this.htmlAttributes || {}
	};
};

/**
 * Convert this annotation to HTML for rendering purposes. By default, this just calls toHTML(),
 * but it may be customized if the rendering should be different from the output.
 *
 * @see ve.dm.Annotation.toHTML
 * @returns {Object} Object with 'tag' (tag name) and 'attributes' (object with attribute key/values)
 */
ve.dm.Annotation.prototype.renderHTML = function () {
	return this.toHTML();
};

/**
 * Custom hash function for ve.getHash(). Should not be overridden by subclasses.
 */
ve.dm.Annotation.prototype.getHash = function () {
	var keys = [ 'name', 'data' ], obj = {}, i;
	for ( i = 0; i < keys.length; i++ ) {
		if ( this[keys[i]] !== undefined ) {
			obj[keys[i]] = this[keys[i]];
		}
	}
	return ve.getHash( obj );
};
