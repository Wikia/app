/*!
 * VisualEditor ContentEditable BranchNode class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * ContentEditable branch node.
 *
 * Branch nodes can have branch or leaf nodes as children.
 *
 * @class
 * @abstract
 * @extends ve.ce.Node
 * @mixins ve.BranchNode
 * @constructor
 * @param {ve.dm.BranchNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.BranchNode = function VeCeBranchNode( model, config ) {
	// Mixin constructor
	ve.BranchNode.call( this );

	// Parent constructor
	ve.ce.Node.call( this, model, config );

	// DOM changes (keep in sync with #onSetup)
	this.$element.addClass( 've-ce-branchNode' );

	// Properties
	this.tagName = this.$element.get( 0 ).nodeName.toLowerCase();
	this.slugNodes = [];

	// Events
	this.model.connect( this, { splice: 'onSplice' } );

	// Initialization
	this.onSplice.apply( this, [ 0, 0 ].concat( model.getChildren() ) );
};

/* Inheritance */

OO.inheritClass( ve.ce.BranchNode, ve.ce.Node );

OO.mixinClass( ve.ce.BranchNode, ve.BranchNode );

/* Static Properties */

/**
 * Inline slug template.
 *
 * @static
 * @property {HTMLElement}
 */
ve.ce.BranchNode.inlineSlugTemplate = ( function () {
	var layout = $.client.profile().layout,
		$img = $( '<img>' )
			.addClass( 've-ce-chimera ve-ce-chimera-' + layout ),
		$span = $( '<span>' )
			.addClass( 've-ce-branchNode-slug ve-ce-branchNode-inlineSlug' )
			.append( $img );

	// Firefox misbehaves if we don't set an src: https://bugzilla.mozilla.org/show_bug.cgi?id=989012
	// But setting an src in Chrome is very slow, so only set it in Firefox
	if ( layout === 'gecko' ) {
		$img.prop( 'src', ve.ce.minImgDataUri );
	}
	return $span.get( 0 );
}() );

/**
 * Inline slug template for input debugging.
 *
 * @static
 * @property {HTMLElement}
 */
ve.ce.BranchNode.inputDebugInlineSlugTemplate = $( '<span>' )
	.addClass( 've-ce-branchNode-slug ve-ce-branchNode-inlineSlug' )
	.append(
		$( '<img>' )
			.prop( 'src', ve.ce.chimeraImgDataUri )
			.addClass( 've-ce-chimera ve-ce-chimera-debug' )
	)
	.get( 0 );

/**
 * Block slug template.
 *
 * @static
 * @property {HTMLElement}
 */
ve.ce.BranchNode.blockSlugTemplate = $( '<div>' )
	.addClass( 've-ce-branchNode-slug ve-ce-branchNode-blockSlug' )
	.get( 0 );

/* Methods */

/**
 * @inheritdoc
 */
ve.ce.BranchNode.prototype.onSetup = function () {
	// Parent method
	ve.ce.Node.prototype.onSetup.call( this );

	// DOM changes (duplicated from constructor in case this.$element is replaced)
	this.$element.addClass( 've-ce-branchNode' );
};

/**
 * Update the DOM wrapper.
 *
 * WARNING: The contents, .data( 'view' ), the contentEditable property and any classes the wrapper
 * already has will be moved to  the new wrapper, but other attributes and any other information
 * added using $.data() will be lost upon updating the wrapper. To retain information added to the
 * wrapper, subscribe to the 'teardown' and 'setup' events.
 *
 * @method
 * @fires teardown
 * @fires setup
 */
ve.ce.BranchNode.prototype.updateTagName = function () {
	var wrapper,
		tagName = this.getTagName();

	if ( tagName !== this.tagName ) {
		this.emit( 'teardown' );
		wrapper = document.createElement( tagName );
		// Copy classes
		wrapper.className = this.$element[ 0 ].className;
		// Copy contentEditable
		wrapper.contentEditable = this.$element[ 0 ].contentEditable;
		// Move contents
		while ( this.$element[ 0 ].firstChild ) {
			wrapper.appendChild( this.$element[ 0 ].firstChild );
		}
		// Swap elements
		if ( this.$element[ 0 ].parentNode ) {
			this.$element[ 0 ].parentNode.replaceChild( wrapper, this.$element[ 0 ] );
		}
		// Use new element from now on
		this.$element = $( wrapper );
		this.emit( 'setup' );
		// Remember which tag name we are using now
		this.tagName = tagName;
	}
};

/**
 * Handles model update events.
 *
 * @param {ve.dm.Transaction} transaction
 */
ve.ce.BranchNode.prototype.onModelUpdate = function ( transaction ) {
	this.emit( 'childUpdate', transaction );
};

/**
 * Handle splice events.
 *
 * ve.ce.Node objects are generated from the inserted ve.dm.Node objects, producing a view that's a
 * mirror of its model.
 *
 * @method
 * @param {number} index Index to remove and or insert nodes at
 * @param {number} howmany Number of nodes to remove
 * @param {...ve.dm.BranchNode} [nodes] Variadic list of nodes to insert
 */
ve.ce.BranchNode.prototype.onSplice = function ( index ) {
	var i, j,
		length,
		args = [],
		$anchor,
		afterAnchor,
		node,
		parentNode,
		removals;

	for ( i = 0, length = arguments.length; i < length; i++ ) {
		args.push( arguments[ i ] );
	}
	// Convert models to views and attach them to this node
	if ( args.length >= 3 ) {
		for ( i = 2, length = args.length; i < length; i++ ) {
			args[ i ] = ve.ce.nodeFactory.create( args[ i ].getType(), args[ i ] );
			args[ i ].model.connect( this, { update: 'onModelUpdate' } );
		}
	}
	removals = this.children.splice.apply( this.children, args );
	for ( i = 0, length = removals.length; i < length; i++ ) {
		removals[ i ].model.disconnect( this, { update: 'onModelUpdate' } );
		removals[ i ].setLive( false );
		removals[ i ].detach();
		removals[ i ].$element.detach();
	}
	if ( args.length >= 3 ) {
		if ( index ) {
			// Get the element before the insertion point
			$anchor = this.children[ index - 1 ].$element.last();
		}
		for ( i = args.length - 1; i >= 2; i-- ) {
			args[ i ].attach( this );
			if ( index ) {
				// DOM equivalent of $anchor.after( args[i].$element );
				afterAnchor = $anchor[ 0 ].nextSibling;
				parentNode = $anchor[ 0 ].parentNode;
				for ( j = 0, length = args[ i ].$element.length; j < length; j++ ) {
					parentNode.insertBefore( args[ i ].$element[ j ], afterAnchor );
				}
			} else {
				// DOM equivalent of this.$element.prepend( args[j].$element );
				node = this.$element[ 0 ];
				for ( j = args[ i ].$element.length - 1; j >= 0; j-- ) {
					node.insertBefore( args[ i ].$element[ j ], node.firstChild );
				}
			}
			if ( this.live !== args[ i ].isLive() ) {
				args[ i ].setLive( this.live );
			}
		}
	}

	this.setupBlockSlugs();
};

/**
 * Setup block slugs
 */
ve.ce.BranchNode.prototype.setupBlockSlugs = function () {
	// Only proceed if we are in a non-content node
	if ( this.canHaveChildrenNotContent() ) {
		this.setupSlugs( true );
	}
};

/**
 * Setup inline slugs
 */
ve.ce.BranchNode.prototype.setupInlineSlugs = function () {
	// Only proceed if we are in a content node
	if ( !this.canHaveChildrenNotContent() ) {
		this.setupSlugs( false );
	}
};

/**
 * Setup slugs where needed.
 *
 * Existing slugs will be removed before new ones are added.
 *
 * @param {boolean} isBlock Set up block slugs, otherwise setup inline slugs
 */
ve.ce.BranchNode.prototype.setupSlugs = function ( isBlock ) {
	var i, slugTemplate, slugNode, child, slugButton,
		doc = this.getElementDocument();

	// Remove all slugs in this branch
	for ( i in this.slugNodes ) {
		if ( this.slugNodes[ i ] !== undefined && this.slugNodes[ i ].parentNode ) {
			this.slugNodes[ i ].parentNode.removeChild( this.slugNodes[ i ] );
		}
		delete this.slugNodes[ i ];
	}

	if ( isBlock ) {
		slugTemplate = ve.ce.BranchNode.blockSlugTemplate;
	} else if ( ve.inputDebug ) {
		slugTemplate = ve.ce.BranchNode.inputDebugInlineSlugTemplate;
	} else {
		slugTemplate = ve.ce.BranchNode.inlineSlugTemplate;
	}

	for ( i in this.getModel().slugPositions ) {
		slugNode = doc.importNode( slugTemplate, true );
		// FIXME: InternalListNode has an empty $element, so we assume that the slug goes at the
		// end instead. This is a hack and the internal list needs to die in a fire.
		if ( this.children[ i ] && this.children[ i ].$element[ 0 ] ) {
			child = this.children[ i ].$element[ 0 ];
			// child.parentNode might not be equal to this.$element[0]: e.g. annotated inline nodes
			child.parentNode.insertBefore( slugNode, child );
		} else {
			this.$element[ 0 ].appendChild( slugNode );
		}
		this.slugNodes[ i ] = slugNode;
		if ( isBlock ) {
			slugButton = new OO.ui.ButtonWidget( {
				label: ve.msg( 'visualeditor-slug-insert' ),
				icon: 'add',
				framed: false
			} ).on( 'click', this.onSlugClick.bind( this, slugNode ) );
			$( slugNode ).append( slugButton.$element );
		}
	}
};

/**
 * Handle slug click events
 *
 * @param {HTMLElement} slugNode Slug node clicked
 */
ve.ce.BranchNode.prototype.onSlugClick = function ( slugNode ) {
	this.getRoot().getSurface().createSlug( slugNode );
};

/**
 * Get a slug at an offset.
 *
 * @method
 * @param {number} offset Offset to get slug at
 * @return {HTMLElement|null}
 */
ve.ce.BranchNode.prototype.getSlugAtOffset = function ( offset ) {
	var i,
		startOffset = this.model.getOffset() + ( this.isWrapped() ? 1 : 0 );

	if ( offset === startOffset ) {
		return this.slugNodes[ 0 ] || null;
	}
	for ( i = 0; i < this.children.length; i++ ) {
		startOffset += this.children[ i ].model.getOuterLength();
		if ( offset === startOffset ) {
			return this.slugNodes[ i + 1 ] || null;
		}
	}
};

/**
 * Set live state on child nodes.
 *
 * @method
 * @param {boolean} live New live state
 */
ve.ce.BranchNode.prototype.setLive = function ( live ) {
	var i;
	ve.ce.Node.prototype.setLive.call( this, live );
	for ( i = 0; i < this.children.length; i++ ) {
		this.children[ i ].setLive( live );
	}
};

/**
 * Release all memory.
 */
ve.ce.BranchNode.prototype.destroy = function () {
	var i, len;
	for ( i = 0, len = this.children.length; i < len; i++ ) {
		this.children[ i ].destroy();
	}

	ve.ce.Node.prototype.destroy.call( this );
};
