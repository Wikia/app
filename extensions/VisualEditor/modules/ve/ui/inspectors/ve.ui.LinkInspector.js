/*global mw */

/**
 * VisualEditor user interface LinkInspector class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.LinkInspector object.
 *
 * @class
 * @constructor
 * @extends {ve.ui.Inspector}
 * @param context
 */
ve.ui.LinkInspector = function VeUiLinkInspector( context ) {
	var inspector = this;

	// Parent constructor
	ve.ui.Inspector.call( this, context );

	// Properties
	this.context = context;
	this.initialValue = null;
	this.$clearButton = $(
		'<div class="ve-ui-inspector-button ve-ui-inspector-clearButton ve-ui-icon-clear"></div>',
		context.frameView.doc
	);
	this.$title = $( '<div class="ve-ui-inspector-title"></div>', context.frameView.doc )
		.text( ve.msg( 'visualeditor-linkinspector-title' ) );
	this.$locationInput = $(
		'<input type="text" class="ve-ui-linkInspector-location" />',
		context.frameView.doc
	);

	// Events
	this.$clearButton.click( function () {
		if ( $( this ).hasClass( 've-ui-inspector-disabled' ) ) {
			context.closeInspector( false );
			return;
		}
		var i,
			surfaceModel = inspector.context.getSurface().getModel(),
			annotations = inspector.getAllLinkAnnotationsFromSelection();
		// Clear all link annotations.
		for ( i = 0; i < annotations.length; i++ ) {
			surfaceModel.annotate( 'clear', annotations[i] );
		}
		inspector.$locationInput.val( '' );
		inspector.context.closeInspector();
	} );
	this.$locationInput.on( 'change mousedown keydown cut paste', function () {
		var $input = $( this );
		setTimeout( function () {
			// Toggle disabled class
			if (
				$input.val() !== '' &&
				$input.data( 'status' ) !== 'invalid'
			) {
				inspector.$.removeClass( 've-ui-inspector-disabled' );
			} else {
				inspector.$.addClass( 've-ui-inspector-disabled' );
			}

		}, 0 );
	} );

	// DOM Changes
	this.$.prepend( this.$title, this.$clearButton );
	this.$form.append( this.$locationInput );

	// FIXME: MediaWiki-specific
	if ( 'mw' in window ) {
		this.initMultiSuggest();
	}
};

/* Inheritance */

ve.inheritClass( ve.ui.LinkInspector, ve.ui.Inspector );

/* Static properties */

ve.ui.LinkInspector.static.icon = 'link';

ve.ui.LinkInspector.static.typePattern = /^link\/MW(in|ex)ternal$/;

/* Methods */

ve.ui.LinkInspector.prototype.getAllLinkAnnotationsFromSelection = function () {
	var surfaceView = this.context.getSurface().getView(),
		surfaceModel = surfaceView.getModel(),
		documentModel = surfaceModel.getDocument();
	return documentModel
		.getAnnotationsFromRange( surfaceModel.getSelection() )
		.getAnnotationsByName( this.constructor.static.typePattern )
		.get();
};

/**
 * Gets the first link annotation within the selection.
 *
 * @method
 * @returns {ve.Annotation|null} First link annotation object or null if none is found
 */
ve.ui.LinkInspector.prototype.getFirstLinkAnnotation = function () {
	var i, len,
		annotations = this.getAllLinkAnnotationsFromSelection();
	for ( i = 0, len = annotations.length; i < len; i++ ) {
		// Use the first one with a recognized type (there should only be one, this is just in case)
		if (
			annotations[i] instanceof ve.dm.MWInternalLinkAnnotation ||
			annotations[i] instanceof ve.dm.MWExternalLinkAnnotation
		) {
			return annotations[i];
		}
	}
	return null;
};

/*
 * Method called prior to opening inspector which fixes up
 * selection to contain the complete annotated link range
 * OR unwrap outer whitespace from selection.
 */
ve.ui.LinkInspector.prototype.prepareOpen = function () {
	var surfaceView = this.context.getSurface().getView(),
		surfaceModel = surfaceView.getModel(),
		doc = surfaceModel.getDocument(),
		annotation = this.getFirstLinkAnnotation(),
		selection = surfaceModel.getSelection(),
		annotatedRange,
		newSelection;

	// Trim outer space from range if any.
	newSelection = doc.trimOuterSpaceFromRange( selection );

	if ( annotation !== null ) {
		annotatedRange = doc.getAnnotatedRangeFromSelection( newSelection, annotation );
		// Adjust selection if it does not contain the annotated range
		if ( selection.start > annotatedRange.start ||
			 selection.end < annotatedRange.end
		) {
			newSelection = annotatedRange;
			// if selected from right to left
			if ( selection.from > selection.start ) {
				newSelection.flip();
			}
		}
	}
	surfaceModel.change( null, newSelection );
};

ve.ui.LinkInspector.prototype.onOpen = function () {
	var annotation = this.getFirstLinkAnnotation(),
		surfaceModel = this.context.getSurface().getModel(),
		documentModel = surfaceModel.getDocument(),
		selection = surfaceModel.getSelection().truncate( 255 ),
		initialValue = documentModel.getText( selection );

	if ( annotation === null ) {
		this.$locationInput.val( initialValue );
		this.$clearButton.addClass( 've-ui-inspector-disabled' );
	} else if ( annotation instanceof ve.dm.MWInternalLinkAnnotation ) {
		// Internal link
		initialValue = annotation.data.title || '';
		this.$locationInput.val( initialValue );
		this.$clearButton.removeClass( 've-ui-inspector-disabled' );
	} else {
		// External link
		initialValue = annotation.data.href || '';
		this.$locationInput.val( initialValue );
		this.$clearButton.removeClass( 've-ui-inspector-disabled' );
	}
	this.initialValue = initialValue;
	if ( this.$locationInput.val().length === 0 ) {
		this.$.addClass( 've-ui-inspector-disabled' );
	} else {
		this.$.removeClass( 've-ui-inspector-disabled' );
	}

	setTimeout( ve.bind( function () {
		this.$locationInput.focus().select();
	}, this ), 0 );
};

ve.ui.LinkInspector.prototype.onClose = function ( accept ) {
	var surfaceView = this.context.getSurface().getView(),
		surfaceModel = surfaceView.getModel(),
		linkAnnotations = this.getAllLinkAnnotationsFromSelection(),
		target = this.$locationInput.val(),
		i;
	if ( accept ) {
		if ( !target ) {
			return;
		}
		// Clear link annotation if it exists
		for ( i = 0; i < linkAnnotations.length; i++ ) {
			surfaceModel.annotate( 'clear', linkAnnotations[i] );
		}
		surfaceModel.annotate( 'set', ve.ui.LinkInspector.getAnnotationForTarget( target ) );

	}
	// Restore focus
	surfaceView.getDocument().getDocumentNode().$.focus();
};

ve.ui.LinkInspector.getAnnotationForTarget = function ( target ) {
	var title, annotation;
	// Figure out if this is an internal or external link
	if ( target.match( /^(https?:)?\/\// ) ) {
		// External link
		annotation = new ve.dm.MWExternalLinkAnnotation();
		annotation.data.href = target;
	} else {
		// Internal link
		// TODO: In the longer term we'll want to have autocompletion and existence
		// and validity checks using AJAX
		try {
			// FIXME: MediaWiki-specific
			title = new mw.Title( target );
			if ( title.getNamespaceId() === 6 || title.getNamespaceId() === 14 ) {
				// File: or Category: link
				// We have to prepend a colon so this is interpreted as a link
				// rather than an image inclusion or categorization
				target = ':' + target;
			}
		} catch ( e ) { }

		annotation = new ve.dm.MWInternalLinkAnnotation();
		annotation.data.title = target;
	}
	return annotation;
};

ve.ui.LinkInspector.prototype.initMultiSuggest = function () {
	var options,
		inspector = this,
		context = inspector.context,
		$overlay = context.$overlay,
		suggestionCache = {},
		pageStatusCache = {},
		api = new mw.Api();
	function updateLocationStatus( status ) {
		if ( status !== 'invalid' ) {
			inspector.$.removeClass( 've-ui-inspector-disabled' );
		} else {
			inspector.$.addClass( 've-ui-inspector-disabled' );
		}
		inspector.$locationInput.data( 'status', status );
	}

	// Multi Suggest configuration.
	options = {
		'parent': $overlay,
		'prefix': 've-ui',
		// Disable CSS Ellipsis.
		// Using MediaWiki jQuery.autoEllipsis() for center ellipsis.
		'cssEllipsis': false,
		// Build suggestion groups in order.
		'suggestions': function ( params ) {
			var groups = {},
				results = params.results,
				query = params.query,
				modifiedQuery,
				title,
				prot;

			// Add existing pages.
			if ( results.length > 0 ) {
				groups.existingPage = {
					'label': ve.msg( 'visualeditor-linkinspector-suggest-existing-page' ),
					'items': results,
					'itemClass': 've-ui-suggest-item-existingPage'
				};
			}
			// Run the query through the mw.Title object to handle correct capitalization,
			// whitespace and and namespace alias/localization resolution.
			try {
				title = new mw.Title( query );
				modifiedQuery = title.getPrefixedText();
				// If page doesn't exist, add New Page group.
				if ( ve.indexOf( modifiedQuery, results ) === -1 ) {
					groups.newPage = {
						'label': ve.msg( 'visualeditor-linkinspector-suggest-new-page' ),
						'items': [modifiedQuery],
						'itemClass': 've-ui-suggest-item-newPage'
					};
				}
			} catch ( e ) {
				// invalid input
				ve.log( e );
			}
			// Add external
			groups.externalLink = {
				'label': ve.msg( 'visualeditor-linkinspector-suggest-external-link' ),
				'items': [],
				'itemClass': 've-ui-suggest-item-externalLink'
			};
			// Find a protocol and suggest an external link.
			prot = query.match(
				ve.init.platform.getExternalLinkUrlProtocolsRegExp()
			);
			if ( prot ) {
				groups.externalLink.items = [query];
			// No protocol, default to http
			} else {
				groups.externalLink.items = ['http://' + query];
			}
			return groups;
		},
		// Called on succesfull input.
		'input': function ( callback ) {
			var $input = $( this ),
				query = $input.val(),
				cKey = query.toLowerCase();

			// Query page and set status data on the location input.
			if ( pageStatusCache[query] !== undefined ) {
				updateLocationStatus( pageStatusCache[query] );
			} else {
				api.get( {
					'action': 'query',
					'indexpageids': '',
					'titles': query,
					'converttitles': ''
				} )
				.done( function ( data ) {
					var status, page;
					if ( data.query ) {
						page = data.query.pages[data.query.pageids[0]];
						status = 'exists';
						if ( page.missing !== undefined ) {
							status = 'notexists';
						} else if ( page.invalid !== undefined ) {
							status = 'invalid';
						}
					}
					// Cache the status of the link query.
					pageStatusCache[query] = status;
					updateLocationStatus( status );
				} );
			}

			// Set overlay position.
			options.position();
			// Build from cache.
			if ( suggestionCache[cKey] !== undefined ) {
				callback( {
					'query': query,
					'results': suggestionCache[cKey]
				} );
			} else {
				// No cache, build fresh api request.
				api.get( {
					'action': 'opensearch',
					'search': query
				} )
				.done( function ( data ) {
					suggestionCache[cKey] = data[1];
					// Build
					callback( {
						'query': query,
						'results': data[1]
					} );
				} );
			}
		},
		// Called when multiSuggest dropdown is updated.
		'update': function () {
			// Ellipsis
			$( '.ve-ui-suggest-item' )
				.autoEllipsis( {
					'hasSpan': true,
					'tooltip': true
				} );
		},
		// Position the iframe overlay below the input.
		'position': function () {
			context.setOverlayPosition( {
				'overlay': $overlay,
				'el': inspector.$locationInput
			} );
		},
		// Fired when a suggestion is selected.
		'select': function () {
			// Assume page suggestion is valid.
			updateLocationStatus( 'valid' );
		}
	};
	// Setup Multi Suggest
	this.$locationInput.multiSuggest( options );
};

/* Registration */

ve.ui.inspectorFactory.register( 'link', ve.ui.LinkInspector );
