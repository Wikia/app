/*!
 * VisualEditor UserInterface AnnotationInspector class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Annotation inspector.
 *
 * @class
 * @abstract
 * @extends ve.ui.Inspector
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 */
ve.ui.AnnotationInspector = function VeUiAnnotationInspector( surface, config ) {
	// Parent constructor
	ve.ui.Inspector.call( this, surface, config );

	// Properties
	this.initialAnnotation = null;
	this.initialAnnotationHash = null;
	this.initialText = null;
	this.isNewAnnotation = false;
};

/* Inheritance */

ve.inheritClass( ve.ui.AnnotationInspector, ve.ui.Inspector );

/**
 * Annotation models this inspector can edit.
 *
 * @static
 * @inheritable
 * @property {Function[]}
 */
ve.ui.AnnotationInspector.static.modelClasses = [];

/* Methods */

/**
 * Handle the inspector being setup.
 *
 * There are 4 scenarios:
 * - Zero-length selection not near a word -> no change, text will be inserted on close
 * - Zero-length selection inside or adjacent to a word -> expand selection to cover word
 * - Selection covering non-annotated text -> trim selection to remove leading/trailing whitespace
 * - Selection covering annotated text -> expand selection to cover annotation
 *
 * @method
 */
ve.ui.AnnotationInspector.prototype.onSetup = function () {
	var expandedFragment, trimmedFragment, truncatedFragment,
		fragment = this.surface.getModel().getFragment( null, true ),
		annotation = this.getMatchingAnnotations( fragment, true ).get( 0 );

	// Parent method
	ve.ui.Inspector.prototype.onSetup.call( this );
	// Initialize range
	if ( !annotation ) {
		if ( fragment.getRange().isCollapsed() && !this.surface.view.hasSlugAtOffset( fragment.getRange().start ) ) {
			// Expand to nearest word
			expandedFragment = fragment.expandRange( 'word' );
			fragment = expandedFragment;
		} else {
			// Trim whitespace
			trimmedFragment = fragment.trimRange();
			fragment = trimmedFragment;
		}
		if ( !fragment.getRange().isCollapsed() ) {
			// Create annotation from selection
			truncatedFragment = fragment.truncateRange( 255 );
			fragment = truncatedFragment;
			this.initialText = fragment.getText();
			annotation = this.getAnnotationFromText( this.initialText );
			if ( annotation ) {
				fragment.annotateContent( 'set', annotation );
			}
			this.isNewAnnotation = true;
		}
	} else {
		// Expand range to cover annotation
		expandedFragment = fragment.expandRange( 'annotation', annotation );
		fragment = expandedFragment;
	}

	// Update selection
	fragment.select();
};

/**
 * Handle the inspector being opened.
 */
ve.ui.AnnotationInspector.prototype.onOpen = function () {
	var fragment = this.surface.getModel().getFragment( null, true ),
		// Note that we don't set the 'all' flag here so that any
		// non-annotated content is annotated on close
		initialAnnotation = this.getMatchingAnnotations( fragment ).get( 0 );

	// Parent method
	ve.ui.Inspector.prototype.onOpen.call( this );

	// Initialization
	this.initialAnnotation = initialAnnotation;
	this.initialAnnotationHash = initialAnnotation ? ve.getHash( initialAnnotation ) : null;
};

/**
 * Handle the inspector being closed.
 *
 * @param {string} action Action that caused the window to be closed
 */
ve.ui.AnnotationInspector.prototype.onClose = function ( action ) {
	// Parent method
	ve.ui.Inspector.prototype.onClose.call( this, action );

	var i, len, annotations,
		insert = false,
		undo = false,
		clear = false,
		set = false,
		target = this.targetInput.getValue(),
		annotation = this.getAnnotation(),
		remove = target === '' || ( action === 'remove' && !!annotation ),
		surfaceModel = this.surface.getModel(),
		fragment = surfaceModel.getFragment( this.initialSelection, false ),
		selection = surfaceModel.getSelection();

	if ( remove ) {
		clear = true;
	} else if ( annotation ) {
		if ( this.initialSelection.isCollapsed() ) {
			insert = true;
		}
		if ( ve.getHash( annotation ) !== this.initialAnnotationHash ) {
			if ( this.isNewAnnotation ) {
				undo = true;
			} else {
				clear = true;
			}
			set = true;
		}
	}
	if ( insert ) {
		fragment.insertContent( target, false );

		// Move cursor to the end of the inserted content, even if back button is used
		this.previousSelection = new ve.Range( this.initialSelection.start + target.length );
	}
	if ( undo ) {
		// Go back to before we added an annotation
		this.surface.execute( 'history', 'undo' );
	}
	if ( clear ) {
		// Clear all existing annotations
		annotations = this.getMatchingAnnotations( fragment, true ).get();
		for ( i = 0, len = annotations.length; i < len; i++ ) {
			fragment.annotateContent( 'clear', annotations[i] );
		}
	}
	if ( set && annotation ) {
		// Apply new annotation
		fragment.annotateContent( 'set', annotation );
	}
	if ( action === 'back' || insert ) {
		// Restore selection to what it was before we expanded it
		selection = this.previousSelection;
	}
	this.surface.execute( 'content', 'select', selection );
	// Reset state
	this.isNewAnnotation = false;
};

/**
 * Get an annotation object from text.
 *
 * @method
 * @abstract
 * @param {string} text Content text
 * @returns {ve.dm.Annotation}
 * @throws {Error} If not overriden in a subclass
 */
ve.ui.AnnotationInspector.prototype.getAnnotationFromText = function () {
	throw new Error(
		've.ui.AnnotationInspector.getAnnotationFromText not implemented in subclass'
	);
};

/**
 * Get matching annotations within a fragment.
 *
 * @method
 * @param {ve.dm.SurfaceFragment} fragment Fragment to get matching annotations within
 * @param {boolean} [all] Get annotations which only cover some of the fragment
 * @returns {ve.dm.AnnotationSet} Matching annotations
 */
ve.ui.AnnotationInspector.prototype.getMatchingAnnotations = function ( fragment, all ) {
	var modelClasses = this.constructor.static.modelClasses;

	return fragment.getAnnotations( all ).filter( function ( annnotation ) {
		return ve.isInstanceOfAny( annnotation, modelClasses );
	} );
};
