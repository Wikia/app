/*!
 * VisualEditor UserInterface AnnotationAction class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Annotation action.
 *
 * @class
 * @extends ve.ui.Action
 * @constructor
 * @param {ve.ui.Surface} surface Surface to act on
 */
ve.ui.AnnotationAction = function VeUiAnnotationAction( surface ) {
	// Parent constructor
	ve.ui.Action.call( this, surface );
};

/* Inheritance */

OO.inheritClass( ve.ui.AnnotationAction, ve.ui.Action );

/* Static Properties */

ve.ui.AnnotationAction.static.name = 'annotation';

/**
 * List of allowed methods for the action.
 *
 * @static
 * @property
 */
ve.ui.AnnotationAction.static.methods = [ 'set', 'clear', 'toggle', 'clearAll' ];

/* Methods */

/**
 * Set an annotation.
 *
 * @method
 * @param {string} name Annotation name, for example: 'textStyle/bold'
 * @param {Object} [data] Additional annotation data
 */
ve.ui.AnnotationAction.prototype.set = function ( name, data ) {
	var i,
		fragment = this.surface.getModel().getFragment(),
		annotationClass = ve.dm.annotationFactory.lookup( name ),
		removes = annotationClass.static.removes;

	for ( i = removes.length - 1; i >= 0; i-- ) {
		fragment.annotateContent( 'clear', removes[i] );
	}
	fragment.annotateContent( 'set', name, data );
};

/**
 * Clear an annotation.
 *
 * @method
 * @param {string} name Annotation name, for example: 'textStyle/bold'
 * @param {Object} [data] Additional annotation data
 */
ve.ui.AnnotationAction.prototype.clear = function ( name, data ) {
	this.surface.getModel().getFragment().annotateContent( 'clear', name, data );
};

/**
 * Toggle an annotation.
 *
 * If the selected text is completely covered with the annotation already the annotation will be
 * cleared. Otherwise the annotation will be set.
 *
 * @method
 * @param {string} name Annotation name, for example: 'textStyle/bold'
 * @param {Object} [data] Additional annotation data
 */
ve.ui.AnnotationAction.prototype.toggle = function ( name, data ) {
	var i, existingAnnotations, insertionAnnotations, removesAnnotations,
		surfaceModel = this.surface.getModel(),
		fragment = surfaceModel.getFragment(),
		annotation = ve.dm.annotationFactory.create( name, data ),
		removes = annotation.constructor.static.removes;

	if ( !fragment.getRange().isCollapsed() ) {
		if ( !fragment.getAnnotations().containsComparable( annotation ) ) {
			for ( i = removes.length - 1; i >= 0; i-- ) {
				fragment.annotateContent( 'clear', removes[i] );
			}
			fragment.annotateContent( 'set', name, data );
		} else {
			fragment.annotateContent( 'clear', name );
		}
	} else {
		insertionAnnotations = surfaceModel.getInsertionAnnotations();
		existingAnnotations = insertionAnnotations.getAnnotationsByName( annotation.name );
		if ( existingAnnotations.isEmpty() ) {
			removesAnnotations = insertionAnnotations.filter( function ( annotation ) {
				return ve.indexOf( annotation.name, removes ) !== -1;
			} );
			surfaceModel.removeInsertionAnnotations( removesAnnotations );
			surfaceModel.addInsertionAnnotations( annotation );
		} else {
			surfaceModel.removeInsertionAnnotations( existingAnnotations );
		}
	}
};

/**
 * Clear all annotations.
 *
 * @method
 */
ve.ui.AnnotationAction.prototype.clearAll = function () {
	var i, len, arr,
		surfaceModel = this.surface.getModel(),
		fragment = surfaceModel.getFragment(),
		annotations = fragment.getAnnotations( true );

	arr = annotations.get();
	// TODO: Allow multiple annotations to be set or cleared by ve.dm.SurfaceFragment, probably
	// using an annotation set and ideally building a single transaction
	for ( i = 0, len = arr.length; i < len; i++ ) {
		fragment.annotateContent( 'clear', arr[i].name, arr[i].data );
	}
	surfaceModel.setInsertionAnnotations( null );
};

/* Registration */

ve.ui.actionFactory.register( ve.ui.AnnotationAction );
