/*!
 * VisualEditor ContentEditable BranchNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
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

	// Properties
	this.tagName = this.$element.get( 0 ).nodeName.toLowerCase();
	this.slugNodes = [];

	// Events
	this.model.connect( this, { splice: 'onSplice' } );

	// Initialization
	this.onSplice.apply( this, [0, 0].concat( model.getChildren() ) );
};

/* Inheritance */

OO.inheritClass( ve.ce.BranchNode, ve.ce.Node );

OO.mixinClass( ve.ce.BranchNode, ve.BranchNode );

/* Events */

/**
 * @event rewrap
 * @param {jQuery} $old
 * @param {jQuery} $new
 */

/* Static Properties */

/**
 * Inline slug template.
 *
 * TODO: Make iframe safe
 *
 * @static
 * @property {HTMLElement}
 */
ve.ce.BranchNode.inlineSlugTemplate = $( '<span>' )
	.addClass( 've-ce-branchNode-slug ve-ce-branchNode-inlineSlug' )
	.append(
		$( '<img>' )
			.attr( 'src', ve.ce.minImgDataUri )
			.css( { width: '0', height: '0' } )
			.addClass( 've-ce-chimera' )
	)
	.get( 0 );

/**
 * Inline slug template for input debugging.
 *
 * TODO: Make iframe safe
 *
 * @static
 * @property {HTMLElement}
 */
ve.ce.BranchNode.inputDebugInlineSlugTemplate = $( '<span>' )
	.addClass( 've-ce-branchNode-slug ve-ce-branchNode-inlineSlug' )
	.append(
		$( '<img>' )
			.attr( 'src', ve.ce.chimeraImgDataUri )
			.addClass( 've-ce-chimera' )
	)
	.get( 0 );

/**
 * Block slug template.
 *
 * TODO: Make iframe safe
 *
 * @static
 * @property {HTMLElement}
 */
ve.ce.BranchNode.blockSlugTemplate = $( '<div>' )
	.addClass( 've-ce-branchNode-blockSlugWrapper ve-ce-branchNode-blockSlugWrapper-unfocused' )
	.append(
		$( '<p>' )
			// TODO: work around ce=false IE9 bug
			.prop( 'contentEditable', 'false' )
			.addClass( 've-ce-branchNode-slug ve-ce-branchNode-blockSlug' )
			.html( '&#xFEFF;' )
	)
	.get( 0 );

/* Methods */

/**
 * Handle setup event.
 *
 * @method
 */
ve.ce.BranchNode.prototype.onSetup = function () {
	ve.ce.Node.prototype.onSetup.call( this );
	this.$element.addClass( 've-ce-branchNode' );
};

/**
 * Handle teardown event.
 *
 * @method
 */
ve.ce.BranchNode.prototype.onTeardown = function () {
	ve.ce.Node.prototype.onTeardown.call( this );
	this.$element.removeClass( 've-ce-branchNode' );
};

/**
 * Update the DOM wrapper.
 *
 * WARNING: The contents, .data( 'view' ) and any classes the wrapper already has will be moved to
 * the new wrapper, but other attributes and any other information added using $.data() will be
 * lost upon updating the wrapper. To retain information added to the wrapper, subscribe to the
 * 'rewrap' event and copy information from the {$old} wrapper the {$new} wrapper.
 *
 * @method
 * @fires rewrap
 */
ve.ce.BranchNode.prototype.updateTagName = function () {
	var $wrapper,
		tagName = this.getTagName();

	if ( tagName !== this.tagName ) {
		this.emit( 'teardown' );
		$wrapper = this.$( this.$.context.createElement( tagName ) );
		// Move contents
		$wrapper.append( this.$element.contents() );
		// Swap elements
		this.$element.replaceWith( $wrapper );
		// Use new element from now on
		this.$element = $wrapper;
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
 * @param {ve.dm.BranchNode...} [nodes] Variadic list of nodes to insert
 */
ve.ce.BranchNode.prototype.onSplice = function ( index ) {
	var i, j,
		length,
		args = Array.prototype.slice.call( arguments ),
		$anchor,
		afterAnchor,
		node,
		parentNode,
		removals;
	// Convert models to views and attach them to this node
	if ( args.length >= 3 ) {
		for ( i = 2, length = args.length; i < length; i++ ) {
			args[i] = ve.ce.nodeFactory.create( args[i].getType(), args[i], { $: this.$ } );
			args[i].model.connect( this, { update: 'onModelUpdate' } );
		}
	}
	removals = this.children.splice.apply( this.children, args );
	for ( i = 0, length = removals.length; i < length; i++ ) {
		removals[i].model.disconnect( this, { update: 'onModelUpdate' } );
		removals[i].setLive( false );
		removals[i].detach();
		removals[i].$element.detach();
	}
	if ( args.length >= 3 ) {
		if ( index ) {
			// Get the element before the insertion point
			$anchor = this.children[ index - 1 ].$element.last();
		}
		for ( i = args.length - 1; i >= 2; i-- ) {
			args[i].attach( this );
			if ( !this.handlesOwnRendering() ) {
				if ( index ) {
					// DOM equivalent of $anchor.after( args[i].$element );
					afterAnchor = $anchor[0].nextSibling;
					parentNode = $anchor[0].parentNode;
					for ( j = 0, length = args[i].$element.length; j < length; j++ ) {
						parentNode.insertBefore( args[i].$element[j], afterAnchor );
					}
				} else {
					// DOM equivalent of this.$element.prepend( args[j].$element );
					node = this.$element[0];
					for ( j = args[i].$element.length - 1; j >= 0; j-- ) {
						node.insertBefore( args[i].$element[j], node.firstChild );
					}
				}
				if ( this.live !== args[i].isLive() ) {
					args[i].setLive( this.live );
				}
			}
		}
	}

	if ( !this.handlesOwnRendering() ) {
		this.setupSlugs();
	}
};

/**
 * Setup slugs where needed.
 *
 * Existing slugs will be removed before new ones are added.
 *
 * @method
 */
ve.ce.BranchNode.prototype.setupSlugs = function () {
	var i, slugTemplate, slugNode, child,
		isBlock = this.canHaveChildrenNotContent(),
		doc = this.getElementDocument();

	// Remove all slugs in this branch
	for ( i in this.slugNodes ) {
		if ( this.slugNodes[i] !== undefined && this.slugNodes[i].parentNode ) {
			this.slugNodes[i].parentNode.removeChild( this.slugNodes[i] );
		}
		delete this.slugNodes[i];
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
		if ( this.children[i] && this.children[i].$element[0] ) {
			child = this.children[i].$element[0];
			// child.parentNode might not be equal to this.$element[0]: e.g. annotated inline nodes
			child.parentNode.insertBefore( slugNode, child );
		} else {
			this.$element[0].appendChild( slugNode );
		}
		this.slugNodes[i] = slugNode;
	}
};

/**
 * Get a slug at an offset.
 *
 * @method
 * @param {number} offset Offset to get slug at
 * @returns {HTMLElement}
 */
ve.ce.BranchNode.prototype.getSlugAtOffset = function ( offset ) {
	var i,
		startOffset = this.model.getOffset() + ( this.isWrapped() ? 1 : 0 );

	if ( offset === startOffset ) {
		return this.slugNodes[0] || null;
	}
	for ( i = 0; i < this.children.length; i++ ) {
		startOffset += this.children[i].model.getOuterLength();
		if ( offset === startOffset ) {
			return this.slugNodes[i + 1] || null;
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
	ve.ce.Node.prototype.setLive.call( this, live );
	if ( !this.handlesOwnRendering() ) {
		for ( var i = 0; i < this.children.length; i++ ) {
			this.children[i].setLive( live );
		}
	}
};

/**
 * Release all memory.
 */
ve.ce.BranchNode.prototype.destroy = function () {
	var i, len;
	for ( i = 0, len = this.children.length; i < len; i++ ) {
		this.children[i].destroy();
	}

	ve.ce.Node.prototype.destroy.call( this );
};
