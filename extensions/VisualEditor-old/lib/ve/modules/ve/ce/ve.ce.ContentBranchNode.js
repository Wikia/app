/*!
 * VisualEditor ContentEditable ContentBranchNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
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

	// Events
	this.connect( this, { 'childUpdate': 'onChildUpdate' } );
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
ve.ce.ContentBranchNode.prototype.onSplice = function () {
	// Parent method
	ve.ce.BranchNode.prototype.onSplice.apply( this, arguments );

	// Rerender to make sure annotations are applied correctly
	this.renderContents();
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
 */
ve.ce.ContentBranchNode.prototype.getRenderedContents = function () {
	var i, ilen, j, jlen, item, itemAnnotations, ann, clone,
		store = this.model.doc.getStore(),
		annotationStack = new ve.dm.AnnotationSet( store ),
		annotatedHtml = [],
		doc = this.getElementDocument(),
		wrapper = doc.createElement( 'div' ),
		current = wrapper,
		buffer = '',
		node = this;

	function openAnnotation( annotation ) {
		if ( buffer !== '' ) {
			current.appendChild( doc.createTextNode( buffer ) );
			buffer = '';
		}
		// Create a new DOM node and descend into it
		ann = ve.ce.annotationFactory.create(
			annotation.getType(), annotation, node, { '$': node.$ }
		).$element[0];
		current.appendChild( ann );
		current = ann;
	}

	function closeAnnotation() {
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

	// Render HTML with annotations
	for ( i = 0, ilen = annotatedHtml.length; i < ilen; i++ ) {
		if ( ve.isArray( annotatedHtml[i] ) ) {
			item = annotatedHtml[i][0];
			itemAnnotations = new ve.dm.AnnotationSet( store, annotatedHtml[i][1] );
		} else {
			item = annotatedHtml[i];
			itemAnnotations = new ve.dm.AnnotationSet( store );
		}

		ve.dm.Converter.openAndCloseAnnotations( annotationStack, itemAnnotations,
			openAnnotation, closeAnnotation
		);

		// Handle the actual item
		if ( typeof item === 'string' ) {
			buffer += item;
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
	return wrapper;

};

/**
 * Render contents.
 *
 * @method
 */
ve.ce.ContentBranchNode.prototype.renderContents = function () {
	var i, len, node, rendered, oldWrapper, newWrapper;
	if (
		this.root instanceof ve.ce.DocumentNode &&
		this.root.getSurface().isRenderingLocked()
	) {
		return;
	}

	if ( this.root instanceof ve.ce.DocumentNode ) {
		this.root.getSurface().setContentBranchNodeChanged( true );
	}

	rendered = this.getRenderedContents();

	// Return if unchanged. Test by building the new version and checking DOM-equality.
	// However we have to normalize to cope with consecutive text nodes. We can't normalize
	// the attached version, because that would close IMEs.

	oldWrapper = this.$element[0].cloneNode( true );
	newWrapper = this.$element[0].cloneNode( false );
	while ( rendered.firstChild ) {
		newWrapper.appendChild( rendered.firstChild );
	}
	oldWrapper.normalize();
	newWrapper.normalize();
	if ( newWrapper.isEqualNode( oldWrapper ) ) {
		return;
	}

	// Detach all child nodes from this.$element
	for ( i = 0, len = this.$element.length; i < len; i++ ) {
		node = this.$element[i];
		while ( node.firstChild ) {
			node.removeChild( node.firstChild );
		}
	}

	// Reattach nodes
	this.constructor.static.appendRenderedContents( this.$element[0], newWrapper );

	// Add slugs
	this.setupSlugs();

	// Highlight the node in debug mode
	if ( ve.debug ) {
		this.$element.css( 'backgroundColor', '#F6F6F6' );
		setTimeout( ve.bind( function () {
			this.$element.css( 'backgroundColor', '' );
		}, this ), 350 );
	}
};
