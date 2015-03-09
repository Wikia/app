/*!
 * VisualEditor ContentEditable Annotation class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Generic ContentEditable annotation.
 *
 * This is an abstract class, annotations should extend this and call this constructor from their
 * constructor. You should not instantiate this class directly.
 *
 * Subclasses of ve.dm.Annotation should have a corresponding subclass here that controls rendering.
 *
 * @abstract
 * @extends ve.ce.View
 *
 * @constructor
 * @param {ve.dm.Annotation} model Model to observe
 * @param {ve.ce.ContentBranchNode} [parentNode] Node rendering this annotation
 * @param {Object} [config] Configuration options
 */
ve.ce.Annotation = function VeCeAnnotation( model, parentNode, config ) {
	// Parent constructor
	ve.ce.View.call( this, model, config );

	// Properties
	this.parentNode = parentNode || null;
};

/* Inheritance */

OO.inheritClass( ve.ce.Annotation, ve.ce.View );

/* Static Properties */

ve.ce.Annotation.static.tagName = 'span';

/**
 * Whether this annotation's continuation (or lack thereof) needs to be forced.
 *
 * This should be set to true only for annotations that aren't continued by browsers but are in DM,
 * or the other way around, or those where behavior is inconsistent between browsers.
 *
 * @static
 * @property
 * @inheritable
 */
ve.ce.Annotation.static.forceContinuation = false;

/* Static Methods */

/**
 * Get a plain text description.
 *
 * @static
 * @inheritable
 * @param {ve.dm.Annotation} annotation Annotation model
 * @returns {string} Description of annotation
 */
ve.ce.Annotation.static.getDescription = function () {
	return '';
};

/* Methods */

/**
 * Get the content branch node this annotation is rendered in, if any.
 * @returns {ve.ce.ContentBranchNode|null} Content branch node or null if none
 */
ve.ce.Annotation.prototype.getParentNode = function () {
	return this.parentNode;
};

/** */
ve.ce.Annotation.prototype.getModelHtmlDocument = function () {
	return this.parentNode && this.parentNode.getModelHtmlDocument();
};
