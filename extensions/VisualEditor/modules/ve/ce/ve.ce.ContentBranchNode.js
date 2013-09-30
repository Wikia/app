/*!
 * VisualEditor ContentEditable ContentBranchNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
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
	this.surfaceModelState = null;

	// Events
	this.connect( this, { 'childUpdate': 'onChildUpdate' } );
};

/* Inheritance */

ve.inheritClass( ve.ce.ContentBranchNode, ve.ce.BranchNode );

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
	var surfaceModel = this.getRoot().getSurface().getModel(),
		surfaceModelState = surfaceModel.getDocument().getCompleteHistoryLength();

	if ( transaction instanceof ve.dm.Transaction ) {
		if ( surfaceModelState === this.surfaceModelState ) {
			return;
		}
		this.surfaceModelState = surfaceModelState;
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
 * @method
 * @returns {HTMLElement[]}
 */
ve.ce.ContentBranchNode.prototype.getRenderedContents = function () {
	var i, ilen, j, jlen, item, itemAnnotations, ann,
		store = this.model.doc.getStore(),
		annotationStack = new ve.dm.AnnotationSet( store ),
		annotatedHtml = [],
		wrapper = document.createElement( 'div' ),
		current = wrapper,
		buffer = '';

	function openAnnotation( annotation ) {
		if ( buffer !== '' ) {
			current.appendChild( document.createTextNode( buffer ) );
			buffer = '';
		}
		// Create a new DOM node and descend into it
		ann = ve.ce.annotationFactory.create( annotation.getType(), annotation ).$[0];
		current.appendChild( ann );
		current = ann;
	}

	function closeAnnotation() {
		if ( buffer !== '' ) {
			current.appendChild( document.createTextNode( buffer ) );
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
				current.appendChild( document.createTextNode( buffer ) );
				buffer = '';
			}
			// DOM equivalent of $( current ).append( itemHtml );
			for ( j = 0, jlen = item.length; j < jlen; j++ ) {
				current.appendChild( item[j] );
			}
		}
	}
	if ( buffer !== '' ) {
		current.appendChild( document.createTextNode( buffer ) );
		buffer = '';
	}
	return Array.prototype.slice.apply( wrapper.childNodes );

};

/**
 * Render contents.
 *
 * @method
 */
ve.ce.ContentBranchNode.prototype.renderContents = function () {
	var i, len, node, rendered;
	if (
		this.root instanceof ve.ce.DocumentNode &&
		this.root.getSurface().isRenderingLocked()
	) {
		return;
	}

	// Detach all child nodes from this.$
	for ( i = 0, len = this.$.length; i < len; i++ ) {
		node = this.$[i];
		while ( node.firstChild ) {
			node.removeChild( node.firstChild );
		}
	}

	// Reattach child nodes with the right annotations
	rendered = this.getRenderedContents();
	for ( i = 0, len = rendered.length; i < len; i++ ) {
		this.$[0].appendChild( rendered[i] );
	}

	// Add slugs
	this.setupSlugs();

	// Highlight the node in debug mode
	if ( ve.debug ) {
		this.$.css( 'backgroundColor', '#F6F6F6' );
		setTimeout( ve.bind( function () {
			this.$.css( 'backgroundColor', '' );
		}, this ), 350 );
	}
};
