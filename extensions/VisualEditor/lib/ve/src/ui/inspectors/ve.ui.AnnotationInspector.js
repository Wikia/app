/*!
 * VisualEditor UserInterface AnnotationInspector class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Inspector for working with content annotations.
 *
 * @class
 * @abstract
 * @extends ve.ui.FragmentInspector
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.AnnotationInspector = function VeUiAnnotationInspector( config ) {
	// Parent constructor
	ve.ui.FragmentInspector.call( this, config );

	// Properties
	this.previousSelection = null;
	this.initialSelection = null;
	this.initialAnnotation = null;
	this.initialAnnotationIsCovering = false;
};

/* Inheritance */

OO.inheritClass( ve.ui.AnnotationInspector, ve.ui.FragmentInspector );

/**
 * Annotation models this inspector can edit.
 *
 * @static
 * @inheritable
 * @property {Function[]}
 */
ve.ui.AnnotationInspector.static.modelClasses = [];

ve.ui.AnnotationInspector.static.actions = [
	{
		action: 'remove',
		label: OO.ui.deferMsg( 'visualeditor-inspector-remove-tooltip' ),
		flags: 'destructive'
	}
].concat( ve.ui.FragmentInspector.static.actions );

/* Methods */

/**
 * Check if form is empty, which if saved should result in removing the annotation.
 *
 * Only override this if the form provides the user a way to blank out primary information, allowing
 * them to remove the annotation by clearing the form.
 *
 * @returns {boolean} Form is empty
 */
ve.ui.AnnotationInspector.prototype.shouldRemoveAnnotation = function () {
	return false;
};

/**
 * Get data to insert if nothing was selected when the inspector opened.
 *
 * Defaults to using #getInsertionText.
 *
 * @returns {Array} Linear model content to insert
 */
ve.ui.AnnotationInspector.prototype.getInsertionData = function () {
	return this.getInsertionText().split( '' );
};

/**
 * Get text to insert if nothing was selected when the inspector opened.
 *
 * @returns {string} Text to insert
 */
ve.ui.AnnotationInspector.prototype.getInsertionText = function () {
	return '';
};

/**
 * Get the annotation object to apply.
 *
 * This method is called when the inspector is closing, and should return the annotation to apply
 * to the text. If this method returns a falsey value like null, no annotation will be applied,
 * but existing annotations won't be removed either.
 *
 * @abstract
 * @returns {ve.dm.Annotation} Annotation to apply
 * @throws {Error} If not overridden in subclass
 */
ve.ui.AnnotationInspector.prototype.getAnnotation = function () {
	throw new Error(
		've.ui.AnnotationInspector.getAnnotation not implemented in subclass'
	);
};

/**
 * Get an annotation object from a fragment.
 *
 * @abstract
 * @param {ve.dm.SurfaceFragment} fragment Surface fragment
 * @returns {ve.dm.Annotation} Annotation
 * @throws {Error} If not overridden in a subclass
 */
ve.ui.AnnotationInspector.prototype.getAnnotationFromFragment = function () {
	throw new Error(
		've.ui.AnnotationInspector.getAnnotationFromFragment not implemented in subclass'
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

	return fragment.getAnnotations( all ).filter( function ( annotation ) {
		return ve.isInstanceOfAny( annotation, modelClasses );
	} );
};

/**
 * @inheritdoc
 */
ve.ui.AnnotationInspector.prototype.getActionProcess = function ( action ) {
	if ( action === 'remove' ) {
		return new OO.ui.Process( function () {
			this.close( { action: 'remove' } );
		}, this );
	}
	return ve.ui.AnnotationInspector.super.prototype.getActionProcess.call( this, action );
};

/**
 * Handle the inspector being setup.
 *
 * There are 4 scenarios:
 *
 * - Zero-length selection not near a word -> no change, text will be inserted on close
 * - Zero-length selection inside or adjacent to a word -> expand selection to cover word
 * - Selection covering non-annotated text -> trim selection to remove leading/trailing whitespace
 * - Selection covering annotated text -> expand selection to cover annotation
 *
 * @method
 * @param {Object} [data] Inspector opening data
 */
ve.ui.AnnotationInspector.prototype.getSetupProcess = function ( data ) {
	return ve.ui.AnnotationInspector.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			var expandedFragment, trimmedFragment, initialCoveringAnnotation,
				fragment = this.getFragment(),
				surfaceModel = fragment.getSurface(),
				annotation = this.getMatchingAnnotations( fragment, true ).get( 0 );

			this.previousSelection = fragment.getSelection();
			surfaceModel.pushStaging();

			// Initialize range
			if ( this.previousSelection instanceof ve.dm.LinearSelection && !annotation ) {
				if (
					fragment.getSelection().isCollapsed() &&
					fragment.getDocument().data.isContentOffset( fragment.getSelection().getRange().start )
				) {
					// Expand to nearest word
					expandedFragment = fragment.expandLinearSelection( 'word' );
					fragment = expandedFragment;
				} else {
					// Trim whitespace
					trimmedFragment = fragment.trimLinearSelection();
					fragment = trimmedFragment;
				}
				if ( !fragment.getSelection().isCollapsed() ) {
					// Create annotation from selection
					annotation = this.getAnnotationFromFragment( fragment );
					if ( annotation ) {
						fragment.annotateContent( 'set', annotation );
					}
				}
			} else {
				// Expand range to cover annotation
				expandedFragment = fragment.expandLinearSelection( 'annotation', annotation );
				fragment = expandedFragment;
			}

			// Update selection
			fragment.select();
			this.initialSelection = fragment.getSelection();

			// The initial annotation is the first matching annotation in the fragment
			this.initialAnnotation = this.getMatchingAnnotations( fragment, true ).get( 0 );
			initialCoveringAnnotation = this.getMatchingAnnotations( fragment ).get( 0 );
			// Fallback to a default annotation
			if ( !this.initialAnnotation ) {
				this.initialAnnotation = this.getAnnotationFromFragment( fragment );
			} else if (
				initialCoveringAnnotation &&
				initialCoveringAnnotation.compareTo( this.initialAnnotation )
			) {
				// If the initial annotation doesn't cover the fragment, record this as we'll need
				// to forcefully apply it to the rest of the fragment later
				this.initialAnnotationIsCovering = true;
			}
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.AnnotationInspector.prototype.getTeardownProcess = function ( data ) {
	data = data || {};
	return ve.ui.AnnotationInspector.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			var i, len, annotations, insertion,
				insertionAnnotation = false,
				insertText = false,
				replace = false,
				annotation = this.getAnnotation(),
				remove = this.shouldRemoveAnnotation() || data.action === 'remove',
				surfaceModel = this.getFragment().getSurface(),
				fragment = surfaceModel.getFragment( this.initialSelection, false ),
				selection = this.getFragment().getSelection();

			if ( !( selection instanceof ve.dm.LinearSelection ) ) {
				return;
			}

			if ( !remove ) {
				if ( this.initialSelection.isCollapsed() ) {
					insertText = true;
				}
				if ( annotation ) {
					// Check if the initial annotation has changed, or didn't cover the whole fragment
					// to begin with
					if (
						!this.initialAnnotationIsCovering ||
						!this.initialAnnotation ||
						!this.initialAnnotation.compareTo( annotation )
					) {
						replace = true;
					}
				}
			}
			// If we are setting a new annotation, clear any annotations the inspector may have
			// applied up to this point. Otherwise keep them.
			if ( replace ) {
				surfaceModel.popStaging();
			} else {
				surfaceModel.applyStaging();
			}
			if ( insertText ) {
				insertion = this.getInsertionData();
				if ( insertion.length ) {
					fragment.insertContent( insertion, true );
					// Move cursor to the end of the inserted content, even if back button is used
					fragment.adjustLinearSelection( -insertion.length, 0 );
					this.previousSelection = new ve.dm.LinearSelection( fragment.getDocument(), new ve.Range(
						this.initialSelection.getRange().start + insertion.length
					) );
				}
			}
			if ( remove || replace ) {
				// Clear all existing annotations
				annotations = this.getMatchingAnnotations( fragment, true ).get();
				for ( i = 0, len = annotations.length; i < len; i++ ) {
					fragment.annotateContent( 'clear', annotations[i] );
				}
			}
			if ( replace ) {
				// Apply new annotation
				if ( fragment.getSelection().isCollapsed() ) {
					insertionAnnotation = true;
				} else {
					fragment.annotateContent( 'set', annotation );
				}
			}
			if ( !data.action || insertText ) {
				// Restore selection to what it was before we expanded it
				selection = this.previousSelection;
			}
			if ( data.action ) {
				surfaceModel.setSelection( selection );
			}

			if ( insertionAnnotation ) {
				surfaceModel.addInsertionAnnotations( annotation );
			}
		}, this )
		.next( function () {
			// Reset state
			this.previousSelection = null;
			this.initialSelection = null;
			this.initialAnnotation = null;
			this.initialAnnotationIsCovering = false;
		}, this );
};
