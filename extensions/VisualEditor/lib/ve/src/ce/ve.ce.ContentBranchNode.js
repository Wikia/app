/*!
 * VisualEditor ContentEditable ContentBranchNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * ContentEditable content branch node.
 *
 * Content branch nodes can only have content nodes as children.
 *
 * @abstract
 * @extends ve.ce.BranchNode
 * @constructor
 * @param {ve.dm.BranchNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.ContentBranchNode = function VeCeContentBranchNode( model, config ) {
	// Parent constructor
	ve.ce.BranchNode.call( this, model, config );

	// Properties
	this.lastTransaction = null;
	this.unicornAnnotations = null;
	this.unicorns = null;

	// Events
	this.connect( this, { childUpdate: 'onChildUpdate' } );
};

/* Inheritance */

OO.inheritClass( ve.ce.ContentBranchNode, ve.ce.BranchNode );

/* Static Members */

/**
 * Whether Enter splits this node type. Must be true for ContentBranchNodes.
 *
 * Warning: overriding this to false in a subclass will cause crashes on Enter key handling.
 *
 * @static
 * @property
 * @inheritable
 */
ve.ce.ContentBranchNode.static.splitOnEnter = true;

/* Static Methods */

/**
 * Append the return value of #getRenderedContents to a DOM element.
 *
 * @param {HTMLElement} container DOM element
 * @param {HTMLElement} wrapper Wrapper returned by #getRenderedContents
 */
ve.ce.ContentBranchNode.static.appendRenderedContents = function ( container, wrapper ) {
	function resolveOriginals( domElement ) {
		var i, len, child;
		for ( i = 0, len = domElement.childNodes.length; i < len; i++ ) {
			child = domElement.childNodes[i];
			if ( child.veOrigNode ) {
				domElement.replaceChild( child.veOrigNode, child );
			} else if ( child.childNodes && child.childNodes.length ) {
				resolveOriginals( child );
			}
		}
	}

	/* Resolve references to the original nodes. */
	resolveOriginals( wrapper );
	while ( wrapper.firstChild ) {
		container.appendChild( wrapper.firstChild );
	}
};

/* Methods */

/**
 * Handle splice events.
 *
 * Rendering is only done once per transaction. If a paragraph has multiple nodes in it then it's
 * possible to receive multiple `childUpdate` events for a single transaction such as annotating
 * across them. State is tracked by storing and comparing the length of the surface model's complete
 * history.
 *
 * This is used to automatically render contents.
 * @see ve.ce.BranchNode#onSplice
 *
 * @method
 */
ve.ce.ContentBranchNode.prototype.onChildUpdate = function ( transaction ) {
	if ( transaction === null || transaction === this.lastTransaction ) {
		this.lastTransaction = transaction;
		return;
	}
	this.renderContents();
};

/**
 * Handle splice events.
 *
 * This is used to automatically render contents.
 * @see ve.ce.BranchNode#onSplice
 *
 * @method
 */
ve.ce.ContentBranchNode.prototype.onSplice = function ( index, howmany ) {
	// Parent method
	ve.ce.BranchNode.prototype.onSplice.apply( this, arguments );

	// HACK: adjust slugNodes indexes if isRenderingLocked. This should be sufficient to
	// keep this.slugNodes valid - only text changes can occur, which cannot create a
	// requirement for a new slug (it can make an existing slug redundant, but it is
	// harmless to leave it there).
	if (
		this.root instanceof ve.ce.DocumentNode &&
		this.root.getSurface().isRenderingLocked
	) {
		this.slugNodes.splice.apply( this.slugNodes, [ index, howmany ].concat( new Array( arguments.length - 2 ) ) );
	}

	// Rerender to make sure annotations are applied correctly
	this.renderContents();
};

/** @inheritdoc */
ve.ce.ContentBranchNode.prototype.setupSlugs = function () {
	// Respect render lock
	if (
		this.root instanceof ve.ce.DocumentNode &&
		this.root.getSurface().isRenderingLocked()
	) {
		return;
	}
	ve.ce.BranchNode.prototype.setupSlugs.apply( this, arguments );
};

/**
 * Get an HTML rendering of the contents.
 *
 * If you are actually going to append the result to a DOM, you need to
 * do this with #appendRenderedContents, which resolves the cloned
 * nodes returned by this function back to their originals.
 *
 * @method
 * @returns {HTMLElement} Wrapper containing rendered contents
 * @returns {Object} return.unicornInfo Unicorn information
 */
ve.ce.ContentBranchNode.prototype.getRenderedContents = function () {
	var i, ilen, j, jlen, item, itemAnnotations, ann, clone, dmSurface, dmSelection, relCursor,
		unicorn, img1, img2, annotationsChanged, childLength, offset, htmlItem, ceSurface,
		nextItemAnnotations, linkAnnotations,
		store = this.model.doc.getStore(),
		annotationStack = new ve.dm.AnnotationSet( store ),
		annotatedHtml = [],
		doc = this.getElementDocument(),
		wrapper = doc.createElement( 'div' ),
		current = wrapper,
		unicornInfo = {},
		buffer = '',
		node = this;

	function openAnnotation( annotation ) {
		annotationsChanged = true;
		if ( buffer !== '' ) {
			current.appendChild( doc.createTextNode( buffer ) );
			buffer = '';
		}
		// Create a new DOM node and descend into it
		ann = ve.ce.annotationFactory.create(
			annotation.getType(), annotation, node, { $: node.$ }
		).$element[0];
		current.appendChild( ann );
		current = ann;
	}

	function closeAnnotation() {
		annotationsChanged = true;
		if ( buffer !== '' ) {
			current.appendChild( doc.createTextNode( buffer ) );
			buffer = '';
		}
		// Traverse up
		current = current.parentNode;
	}

	// Gather annotated HTML from the child nodes
	for ( i = 0, ilen = this.children.length; i < ilen; i++ ) {
		annotatedHtml = annotatedHtml.concat( this.children[i].getAnnotatedHtml() );
	}

	// Set relCursor to collapsed selection offset, or -1 if none
	// (in which case we don't need to worry about preannotation)
	relCursor = -1;
	if ( this.getRoot() ) {
		ceSurface = this.getRoot().getSurface();
		dmSurface = ceSurface.getModel();
		dmSelection = dmSurface.getTranslatedSelection();
		if ( dmSelection instanceof ve.dm.LinearSelection && dmSelection.isCollapsed() ) {
			// subtract 1 for CBN opening tag
			relCursor = dmSelection.getRange().start - this.getOffset() - 1;
		}
	}

	// Set cursor status for renderContents. If hasCursor, splice unicorn marker at the
	// collapsed selection offset. It will be rendered later if it is needed, else ignored
	if ( relCursor < 0 || relCursor > this.getLength() ) {
		unicornInfo.hasCursor = false;
	} else {
		unicornInfo.hasCursor = true;
		offset = 0;
		for ( i = 0, ilen = annotatedHtml.length; i < ilen; i++ ) {
			htmlItem = annotatedHtml[i][0];
			childLength = ( typeof htmlItem === 'string' ) ? 1 : 2;
			if ( offset <= relCursor && relCursor < offset + childLength ) {
				unicorn = [
					{}, // unique object, for testing object equality later
					dmSurface.getInsertionAnnotations().storeIndexes
				];
				annotatedHtml.splice( i, 0, unicorn );
				break;
			}
			offset += childLength;
		}
		// Special case for final position
		if ( i === ilen && offset === relCursor ) {
			unicorn = [
				{}, // unique object, for testing object equality later
				dmSurface.getInsertionAnnotations().storeIndexes
			];
			annotatedHtml.push( unicorn );
		}
	}

	// Render HTML with annotations
	for ( i = 0, ilen = annotatedHtml.length; i < ilen; i++ ) {
		if ( Array.isArray( annotatedHtml[i] ) ) {
			item = annotatedHtml[i][0];
			itemAnnotations = new ve.dm.AnnotationSet( store, annotatedHtml[i][1] );
		} else {
			item = annotatedHtml[i];
			itemAnnotations = new ve.dm.AnnotationSet( store );
		}

		// Remove 'a' from the unicorn, if the following item has no 'a'
		if ( unicorn && item === unicorn[0] && i < ilen - 1 ) {
			linkAnnotations = itemAnnotations.getAnnotationsByName( 'link' );
			nextItemAnnotations = new ve.dm.AnnotationSet(
				store,
				Array.isArray( annotatedHtml[i + 1] ) ? annotatedHtml[i + 1][1] : undefined
			);
			if ( !nextItemAnnotations.containsAllOf( linkAnnotations ) ) {
				itemAnnotations.removeSet( linkAnnotations );
			}
		}

		// annotationsChanged gets set to true by openAnnotation and closeAnnotation
		annotationsChanged = false;
		ve.dm.Converter.openAndCloseAnnotations( annotationStack, itemAnnotations,
			openAnnotation, closeAnnotation
		);

		// Handle the actual item
		if ( typeof item === 'string' ) {
			buffer += item;
		} else if ( unicorn && item === unicorn[0] ) {
			if ( annotationsChanged ) {
				if ( buffer !== '' ) {
					current.appendChild( doc.createTextNode( buffer ) );
					buffer = '';
				}
				img1 = doc.createElement( 'img' );
				img2 = doc.createElement( 'img' );
				img1.className = 've-ce-unicorn ve-ce-pre-unicorn';
				img2.className = 've-ce-unicorn ve-ce-post-unicorn';
				$( img1 ).data( 'dmOffset', ( this.getOffset() + 1 + i ) );
				$( img2 ).data( 'dmOffset', ( this.getOffset() + 1 + i ) );
				if ( ve.inputDebug ) {
					img1.setAttribute( 'src', ve.ce.unicornImgDataUri );
					img2.setAttribute( 'src', ve.ce.unicornImgDataUri );
				} else {
					img1.setAttribute( 'src', ve.ce.minImgDataUri );
					img2.setAttribute( 'src', ve.ce.minImgDataUri );
					img1.style.width = '0px';
					img2.style.width = '0px';
					img1.style.height = '0px';
					img2.style.height = '0px';
				}
				current.appendChild( img1 );
				current.appendChild( img2 );
				unicornInfo.annotations = dmSurface.getInsertionAnnotations();
				unicornInfo.unicorns = [ img1, img2 ];
			} else {
				unicornInfo.unicornAnnotations = null;
				unicornInfo.unicorns = null;
			}
		} else {
			if ( buffer !== '' ) {
				current.appendChild( doc.createTextNode( buffer ) );
				buffer = '';
			}
			// DOM equivalent of $( current ).append( item.clone() );
			for ( j = 0, jlen = item.length; j < jlen; j++ ) {
				// Append a clone so as to not relocate the original node
				clone = item[j].cloneNode( true );
				// Store a reference to the original node in a property
				clone.veOrigNode = item[j];
				current.appendChild( clone );
			}
		}
	}
	if ( buffer !== '' ) {
		current.appendChild( doc.createTextNode( buffer ) );
		buffer = '';
	}
	wrapper.unicornInfo = unicornInfo;
	return wrapper;
};

/**
 * Render contents.
 *
 * @method
 * @return {boolean} Whether the contents have changed
 */
ve.ce.ContentBranchNode.prototype.renderContents = function () {
	var i, len, element, rendered, unicornInfo, oldWrapper, newWrapper,
		node = this;
	if (
		this.root instanceof ve.ce.DocumentNode &&
		this.root.getSurface().isRenderingLocked()
	) {
		return false;
	}

	if ( this.root instanceof ve.ce.DocumentNode ) {
		this.root.getSurface().setContentBranchNodeChanged();
	}

	rendered = this.getRenderedContents();
	unicornInfo = rendered.unicornInfo;
	delete rendered.unicornInfo;

	// Return if unchanged. Test by building the new version and checking DOM-equality.
	// However we have to normalize to cope with consecutive text nodes. We can't normalize
	// the attached version, because that would close IMEs.

	oldWrapper = this.$element[0].cloneNode( true );
	newWrapper = this.$element[0].cloneNode( false );
	while ( rendered.firstChild ) {
		newWrapper.appendChild( rendered.firstChild );
	}
	ve.normalizeNode( oldWrapper );
	ve.normalizeNode( newWrapper );
	if ( newWrapper.isEqualNode( oldWrapper ) ) {
		return false;
	}

	this.unicornAnnotations = unicornInfo.annotations || null;
	this.unicorns = unicornInfo.unicorns || null;

	// Detach all child nodes from this.$element
	for ( i = 0, len = this.$element.length; i < len; i++ ) {
		element = this.$element[i];
		while ( element.firstChild ) {
			element.removeChild( element.firstChild );
		}
	}

	// Reattach nodes
	this.constructor.static.appendRenderedContents( this.$element[0], newWrapper );

	// Set unicorning status
	if ( this.getRoot() ) {
		if ( !unicornInfo.hasCursor ) {
			this.getRoot().getSurface().setNotUnicorning( this );
		} else if ( this.unicorns ) {
			this.getRoot().getSurface().setUnicorning( this );
		} else {
			this.getRoot().getSurface().setNotUnicorningAll( this );
		}
	}
	this.hasCursor = null;

	// Add slugs
	this.setupSlugs();

	// Highlight the node in debug mode
	if ( ve.debug ) {
		this.$element.css( 'backgroundColor', '#eee' );
		setTimeout( function () {
			node.$element.css( 'backgroundColor', '' );
		}, 500 );
	}

	return true;
};

/**
 * Handle teardown event.
 *
 * @method
 */
ve.ce.ContentBranchNode.prototype.onTeardown = function () {
	var ceSurface = this.getRoot().getSurface();

	// Parent method
	ve.ce.BranchNode.prototype.onTeardown.call( this );

	ceSurface.setNotUnicorning( this );
};
