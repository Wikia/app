/*!
 * VisualEditor UserInterface FindAndReplaceDialog class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Find and replace dialog.
 *
 * @class
 * @extends ve.ui.ToolbarDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.FindAndReplaceDialog = function VeUiFindAndReplaceDialog( config ) {
	// Parent constructor
	ve.ui.FindAndReplaceDialog.super.call( this, config );

	// Pre-initialization
	this.$element.addClass( 've-ui-findAndReplaceDialog' );
};

/* Inheritance */

OO.inheritClass( ve.ui.FindAndReplaceDialog, ve.ui.ToolbarDialog );

ve.ui.FindAndReplaceDialog.static.name = 'findAndReplace';

ve.ui.FindAndReplaceDialog.static.title = OO.ui.deferMsg( 'visualeditor-find-and-replace-title' );

/**
 * Maximum number of results to render
 *
 * @property {number}
 */
ve.ui.FindAndReplaceDialog.static.maxRenderedResults = 100;

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.FindAndReplaceDialog.prototype.initialize = function () {
	var optionsGroup, navigateGroup, replaceGroup, doneButton, $findRow, $replaceRow;

	// Parent method
	ve.ui.FindAndReplaceDialog.super.prototype.initialize.call( this );

	// Properties
	this.surface = null;
	this.invalidRegex = false;
	this.$findResults = $( '<div>' ).addClass( 've-ui-findAndReplaceDialog-findResults' );
	this.initialFragment = null;
	this.fragments = [];
	this.results = 0;
	// Range over the list of fragments indicating which ones where rendered,
	// e.g. [1,3] means fragments 1 & 2 were rendered
	this.renderedFragments = new ve.Range();
	this.replacing = false;
	this.focusedIndex = 0;
	this.query = null;
	this.findText = new OO.ui.TextInputWidget( {
		placeholder: ve.msg( 'visualeditor-find-and-replace-find-text' ),
		validate: ( function ( dialog ) {
			return function () {
				return !dialog.invalidRegex;
			};
		} )( this )
	} );
	this.matchCaseToggle = new OO.ui.ToggleButtonWidget( {
		icon: 'searchCaseSensitive',
		iconTitle: ve.msg( 'visualeditor-find-and-replace-match-case' ),
		value: ve.userConfig( 'visualeditor-findAndReplace-matchCase' )
	} );
	this.regexToggle = new OO.ui.ToggleButtonWidget( {
		icon: 'searchRegularExpression',
		iconTitle: ve.msg( 'visualeditor-find-and-replace-regular-expression' ),
		value: ve.userConfig( 'visualeditor-findAndReplace-regex' )
	} );

	this.previousButton = new OO.ui.ButtonWidget( {
		icon: 'previous',
		iconTitle: ve.msg( 'visualeditor-find-and-replace-previous-button' ) + ' ' +
			ve.ui.triggerRegistry.getMessages( 'findPrevious' ).join( ', ' )
	} );
	this.nextButton = new OO.ui.ButtonWidget( {
		icon: 'next',
		iconTitle: ve.msg( 'visualeditor-find-and-replace-next-button' ) + ' ' +
			ve.ui.triggerRegistry.getMessages( 'findNext' ).join( ', ' )
	} );
	this.replaceText = new OO.ui.TextInputWidget( {
		placeholder: ve.msg( 'visualeditor-find-and-replace-replace-text' )
	} );
	this.replaceButton = new OO.ui.ButtonWidget( {
		label: ve.msg( 'visualeditor-find-and-replace-replace-button' )
	} );
	this.replaceAllButton = new OO.ui.ButtonWidget( {
		label: ve.msg( 'visualeditor-find-and-replace-replace-all-button' )
	} );

	optionsGroup = new OO.ui.ButtonGroupWidget( {
			classes: [ 've-ui-findAndReplaceDialog-cell' ],
			items: [
				this.matchCaseToggle,
				this.regexToggle
			]
		} );
	navigateGroup = new OO.ui.ButtonGroupWidget( {
		classes: [ 've-ui-findAndReplaceDialog-cell' ],
		items: [
			this.previousButton,
			this.nextButton
		]
	} );
	replaceGroup = new OO.ui.ButtonGroupWidget( {
		classes: [ 've-ui-findAndReplaceDialog-cell' ],
		items: [
			this.replaceButton,
			this.replaceAllButton
		]
	} );
	doneButton = new OO.ui.ButtonWidget( {
		classes: [ 've-ui-findAndReplaceDialog-cell' ],
		label: ve.msg( 'visualeditor-find-and-replace-done' )
	} );
	$findRow = $( '<div>' ).addClass( 've-ui-findAndReplaceDialog-row' );
	$replaceRow = $( '<div>' ).addClass( 've-ui-findAndReplaceDialog-row' );

	// Events
	this.onWindowScrollDebounced = ve.debounce( this.onWindowScroll.bind( this ), 250 );
	this.updateFragmentsDebounced = ve.debounce( this.updateFragments.bind( this ) );
	this.renderFragmentsDebounced = ve.debounce( this.renderFragments.bind( this ) );
	this.findText.connect( this, {
		change: 'onFindChange',
		enter: 'onFindTextEnter'
	} );
	this.matchCaseToggle.connect( this, { change: 'onFindChange' } );
	this.regexToggle.connect( this, { change: 'onFindChange' } );
	this.nextButton.connect( this, { click: 'findNext' } );
	this.previousButton.connect( this, { click: 'findPrevious' } );
	this.replaceButton.connect( this, { click: 'onReplaceButtonClick' } );
	this.replaceAllButton.connect( this, { click: 'onReplaceAllButtonClick' } );
	doneButton.connect( this, { click: 'close' } );

	// Initialization
	this.findText.$input.prop( 'tabIndex', 1 );
	this.replaceText.$input.prop( 'tabIndex', 2 );
	this.$content.addClass( 've-ui-findAndReplaceDialog-content' );
	this.$body
		.append(
			$findRow.append(
				$( '<div>' ).addClass( 've-ui-findAndReplaceDialog-cell ve-ui-findAndReplaceDialog-cell-input' ).append(
					this.findText.$element
				),
				navigateGroup.$element,
				optionsGroup.$element
			),
			$replaceRow.append(
				$( '<div>' ).addClass( 've-ui-findAndReplaceDialog-cell ve-ui-findAndReplaceDialog-cell-input' ).append(
					this.replaceText.$element
				),
				replaceGroup.$element,
				doneButton.$element
			)
		);
};

/**
 * @inheritdoc
 */
ve.ui.FindAndReplaceDialog.prototype.getSetupProcess = function ( data ) {
	data = data || {};
	return ve.ui.FindAndReplaceDialog.super.prototype.getSetupProcess.call( this, data )
		.first( function () {
			var text, fragment = data.fragment;

			this.surface = data.surface;
			this.surface.$selections.append( this.$findResults );

			// Events
			this.surface.getModel().connect( this, { documentUpdate: this.updateFragmentsDebounced } );
			this.surface.getView().connect( this, { position: this.renderFragmentsDebounced } );
			this.surface.getView().$window.on( 'scroll', this.onWindowScrollDebounced );

			text = fragment.getText();
			if ( text && text !== this.findText.getValue() ) {
				this.findText.setValue( text );
			} else {
				this.onFindChange();
			}

			this.initialFragment = fragment;
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.FindAndReplaceDialog.prototype.getReadyProcess = function ( data ) {
	return ve.ui.FindAndReplaceDialog.super.prototype.getReadyProcess.call( this, data )
		.next( function () {
			this.findText.focus().select();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.FindAndReplaceDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.FindAndReplaceDialog.super.prototype.getTeardownProcess.call( this, data )
		.next( function () {
			var selection,
				surfaceView = this.surface.getView(),
				surfaceModel = this.surface.getModel();

			// Events
			this.surface.getModel().disconnect( this );
			surfaceView.disconnect( this );
			this.surface.getView().$window.off( 'scroll', this.onWindowScrollDebounced );

			// If the surface isn't selected, put the selection back in a sensible place
			if ( surfaceModel.getSelection() instanceof ve.dm.NullSelection ) {
				if ( this.fragments.length ) {
					// Either the active search result...
					selection = this.fragments[ this.focusedIndex ].getSelection();
				} else if ( !( this.initialFragment.getSelection() instanceof ve.dm.NullSelection ) ) {
					// ... or the initial selection
					selection = this.initialFragment.getSelection();
				}
			}
			if ( selection ) {
				surfaceModel.setSelection( selection );
			} else {
				// If the selection wasn't changed, focus anyway
				surfaceView.focus();
			}
			this.$findResults.empty().detach();
			this.fragments = [];
			this.surface = null;
		}, this );
};

/**
 * Handle window scroll events
 */
ve.ui.FindAndReplaceDialog.prototype.onWindowScroll = function () {
	if ( this.renderedFragments.getLength() < this.results ) {
		// If viewport clipping is being used, reposition results based on the current viewport
		this.renderFragments();
	}
};

/**
 * Handle change events to the find inputs (text or match case)
 */
ve.ui.FindAndReplaceDialog.prototype.onFindChange = function () {
	this.updateFragments();
	this.renderFragments();
	this.highlightFocused( true );
	ve.userConfig( {
		'visualeditor-findAndReplace-matchCase': this.matchCaseToggle.getValue(),
		'visualeditor-findAndReplace-regex': this.regexToggle.getValue()
	} );
};

/**
 * Handle enter events on the find text input
 *
 * @param {jQuery.Event} e
 */
ve.ui.FindAndReplaceDialog.prototype.onFindTextEnter = function ( e ) {
	if ( !this.results ) {
		return;
	}
	if ( e.shiftKey ) {
		this.findPrevious();
	} else {
		this.findNext();
	}
};

/**
 * Update search result fragments
 */
ve.ui.FindAndReplaceDialog.prototype.updateFragments = function () {
	var i, l,
		surfaceModel = this.surface.getModel(),
		documentModel = surfaceModel.getDocument(),
		ranges = [],
		matchCase = this.matchCaseToggle.getValue(),
		isRegex = this.regexToggle.getValue(),
		find = this.findText.getValue();

	this.invalidRegex = false;

	if ( isRegex && find ) {
		try {
			this.query = new RegExp( find );
		} catch ( e ) {
			this.invalidRegex = true;
			this.query = '';
		}
	} else {
		this.query = find;
	}
	this.findText.setValidityFlag();

	this.fragments = [];
	if ( this.query ) {
		ranges = documentModel.findText( this.query, matchCase, true );
		for ( i = 0, l = ranges.length; i < l; i++ ) {
			this.fragments.push( surfaceModel.getLinearFragment( ranges[ i ], true, true ) );
		}
	}
	this.results = this.fragments.length;
	this.focusedIndex = Math.min( this.focusedIndex, this.results ? this.results - 1 : 0 );
	this.nextButton.setDisabled( !this.results );
	this.previousButton.setDisabled( !this.results );
	this.replaceButton.setDisabled( !this.results );
	this.replaceAllButton.setDisabled( !this.results );
};

/**
 * Position results markers
 */
ve.ui.FindAndReplaceDialog.prototype.renderFragments = function () {
	var i, selection, viewportRange, start, end;

	if (
		this.replacing ||
		// Check the surface isn't hidden, such as during deactivation
		!this.surface.getView().$element.is( ':visible' )
	) {
		return;
	}

	start = 0;
	end = this.results;

	// When there are a large number of results, calculate the viewport range for clipping
	if ( this.results > 50 ) {
		viewportRange = this.surface.getView().getViewportRange();
		for ( i = 0; i < this.results; i++ ) {
			selection = this.fragments[ i ].getSelection();
			if ( viewportRange && selection.getRange().start < viewportRange.start ) {
				start = i + 1;
				continue;
			}
			if ( viewportRange && selection.getRange().end > viewportRange.end ) {
				end = i;
				break;
			}
		}
	}

	// When there are too many results to render, just render the current one
	if ( end - start <= this.constructor.static.maxRenderedResults ) {
		this.renderRangeOfFragments( new ve.Range( start, end ) );
	} else {
		this.renderRangeOfFragments( new ve.Range( this.focusedIndex, this.focusedIndex + 1 ) );
	}
};

/**
 * Render subset of search result fragments
 *
 * @param {ve.Range} range Range of fragments to render
 */
ve.ui.FindAndReplaceDialog.prototype.renderRangeOfFragments = function ( range ) {
	var i, j, jlen, rects, $result, top;
	this.$findResults.empty();
	for ( i = range.start; i < range.end; i++ ) {
		rects = this.surface.getView().getSelectionRects( this.fragments[ i ].getSelection() );
		$result = $( '<div>' ).addClass( 've-ui-findAndReplaceDialog-findResult' );
		top = Infinity;
		for ( j = 0, jlen = rects.length; j < jlen; j++ ) {
			top = Math.min( top, rects[ j ].top );
			$result.append( $( '<div>' ).css( {
				top: rects[ j ].top,
				left: rects[ j ].left,
				width: rects[ j ].width,
				height: rects[ j ].height
			} ) );
		}
		$result.data( 'top', top );
		this.$findResults.append( $result );
	}
	this.renderedFragments = range;
	this.highlightFocused();
};

/**
 * Highlight the focused result marker
 *
 * @param {boolean} scrollIntoView Scroll the marker into view
 */
ve.ui.FindAndReplaceDialog.prototype.highlightFocused = function ( scrollIntoView ) {
	var $result, rect, top,
		offset, windowScrollTop, windowScrollHeight,
		surfaceView = this.surface.getView();

	if ( this.results ) {
		this.findText.setLabel(
			ve.msg( 'visualeditor-find-and-replace-results', this.focusedIndex + 1, this.results )
		);
	} else {
		this.findText.setLabel(
			this.invalidRegex ? ve.msg( 'visualeditor-find-and-replace-invalid-regex' ) : ''
		);
		return;
	}

	this.$findResults
		.find( '.ve-ui-findAndReplaceDialog-findResult-focused' )
		.removeClass( 've-ui-findAndReplaceDialog-findResult-focused' );

	if ( this.renderedFragments.containsOffset( this.focusedIndex ) ) {
		$result = this.$findResults.children().eq( this.focusedIndex - this.renderedFragments.start )
			.addClass( 've-ui-findAndReplaceDialog-findResult-focused' );

		top = $result.data( 'top' );
	} else if ( scrollIntoView ) {
		// If we're about to scroll into view and the result isn't rendered, compute the offset manually.
		rect = surfaceView.getSelectionBoundingRect( this.fragments[ this.focusedIndex ].getSelection() );
		top = rect.top;
	}

	if ( scrollIntoView ) {
		surfaceView = this.surface.getView();
		offset = top + surfaceView.$element.offset().top;
		windowScrollTop = surfaceView.$window.scrollTop() + this.surface.toolbarHeight;
		windowScrollHeight = surfaceView.$window.height() - this.surface.toolbarHeight;

		if ( offset < windowScrollTop || offset > windowScrollTop + windowScrollHeight ) {
			$( 'body, html' ).animate( { scrollTop: offset - ( windowScrollHeight / 2  ) }, 'fast' );
		}
	}
};

/**
 * Find the next result
 */
ve.ui.FindAndReplaceDialog.prototype.findNext = function () {
	this.focusedIndex = ( this.focusedIndex + 1 ) % this.results;
	this.highlightFocused( true );
};

/**
 * Find the previous result
 */
ve.ui.FindAndReplaceDialog.prototype.findPrevious = function () {
	this.focusedIndex = ( this.focusedIndex + this.results - 1 ) % this.results;
	this.highlightFocused( true );
};

/**
 * Handle click events on the replace button
 */
ve.ui.FindAndReplaceDialog.prototype.onReplaceButtonClick = function () {
	var end;

	if ( !this.results ) {
		return;
	}

	this.replace( this.focusedIndex );

	// Find the next fragment after this one ends. Ensures that if we replace
	// 'foo' with 'foofoo' we don't select the just-inserted text.
	end = this.fragments[ this.focusedIndex ].getSelection().getRange().end;
	// updateFragmentsDebounced is triggered by insertContent, but call it immediately
	// so we can find the next fragment to select.
	this.updateFragments();
	if ( !this.results ) {
		this.focusedIndex = 0;
		return;
	}
	while ( this.fragments[ this.focusedIndex ] && this.fragments[ this.focusedIndex ].getSelection().getRange().end <= end ) {
		this.focusedIndex++;
	}
	// We may have iterated off the end
	this.focusedIndex = this.focusedIndex % this.results;
};

/**
 * Handle click events on the previous all button
 */
ve.ui.FindAndReplaceDialog.prototype.onReplaceAllButtonClick = function () {
	var i, l;

	for ( i = 0, l = this.results; i < l; i++ ) {
		this.replace( i );
	}
};

/**
 * Replace the result at a specified index
 *
 * @param {number} index Index to replace
 */
ve.ui.FindAndReplaceDialog.prototype.replace = function ( index ) {
	var replace = this.replaceText.getValue();

	if ( this.query instanceof RegExp ) {
		this.fragments[ index ].insertContent(
			this.fragments[ index ].getText().replace( this.query, replace ),
			true
		);
	} else {
		this.fragments[ index ].insertContent( replace, true );
	}
};

/**
 * @inheritdoc
 */
ve.ui.FindAndReplaceDialog.prototype.getActionProcess = function ( action ) {
	if ( action === 'findNext' || action === 'findPrevious' ) {
		return new OO.ui.Process( this[ action ], this );
	}
	return ve.ui.FindAndReplaceDialog.super.prototype.getActionProcess.call( this, action );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.FindAndReplaceDialog );
