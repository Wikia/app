/*!
 * VisualEditor ContentEditable Annotation class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
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
 * @param {Object} [config] Configuration options
 */
ve.ce.Annotation = function VeCeAnnotation( model, config ) {
	// Parent constructor
	ve.ce.View.call( this, model, config );
};

/* Inheritance */

ve.inheritClass( ve.ce.Annotation, ve.ce.View );

/* Static Properties */

ve.ce.Annotation.static.tagName = 'span';

/**
 * Whether this annotation's continuation (or lack thereof) needs to be forced.
 *
 * This should be set to true only for annotations that aren't continued by browsers but are in DM,
 * or the other way around, or those where behavior is inconsistent between browsers.
 *
 * @property static.forceContinuation
 * @static
 * @inheritable
 */
ve.ce.Annotation.static.forceContinuation = false;
