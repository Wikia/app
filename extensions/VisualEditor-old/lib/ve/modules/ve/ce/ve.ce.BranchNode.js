/*!
 * VisualEditor ContentEditable BranchNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
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
	this.slugs = {};

	// Events
	this.model.connect( this, { 'splice': 'onSplice' } );

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
 * @property {jQuery}
 */
ve.ce.BranchNode.$inlineSlugTemplate = $( '<span>' )
	.addClass( 've-ce-branchNode-slug ve-ce-branchNode-inlineSlug' )
	.html( '&#xFEFF;' );

/**
 * Block slug template.
 *
 * TODO: Make iframe safe
 *
 * @static
 * @property {jQuery}
 */
ve.ce.BranchNode.$blockSlugTemplate = $( '<div>' )
	.addClass( 've-ce-branchNode-blockSlugWrapper ve-ce-branchNode-blockSlugWrapper-unfocused' )
	.append(
		$( '<p>' )
			.addClass( 've-ce-branchNode-slug ve-ce-branchNode-blockSlug' )
			.html( '&#xFEFF;' )
	);

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
		firstChild,
		removals;
	// Convert models to views and attach them to this node
	if ( args.length >= 3 ) {
		for ( i = 2, length = args.length; i < length; i++ ) {
			args[i] = ve.ce.nodeFactory.create( args[i].getType(), args[i], { '$': this.$ } );
			args[i].model.connect( this, { 'update': 'onModelUpdate' } );
		}
	}
	removals = this.children.splice.apply( this.children, args );
	for ( i = 0, length = removals.length; i < length; i++ ) {
		removals[i].model.disconnect( this, { 'update': 'onModelUpdate' } );
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
					firstChild = node.firstChild;
					for ( j = args[i].$element.length - 1; j >= 0; j-- ) {
						node.insertBefore( args[i].$element[j], firstChild );
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
	var key, slug, i, len, first, last, childTypes,
		doc = this.getElementDocument(),
		canHaveChildrenNotContent = this.canHaveChildrenNotContent(),
		slugRequired = false;

	// Remove all slugs in this branch
	for ( key in this.slugs ) {
		if ( this.slugs[key].parentNode ) {
			this.slugs[key].parentNode.removeChild( this.slugs[key] );
		}
		delete this.slugs[key];
	}

	if ( canHaveChildrenNotContent ) {
		slug = ve.ce.BranchNode.$blockSlugTemplate[0];
	} else {
		slug = ve.ce.BranchNode.$inlineSlugTemplate[0];
	}

	// If this content branch no longer has any rendered children, insert a slug to keep the node
	// from becoming invisible/unfocusable. In Firefox, backspace after Ctrl-A leaves the document
	// completely empty, so this ensures DocumentNode gets a slug.
	// Can't use this.getLength() because the internal list adds to the length but doesn't render.
	if ( this.$element.contents().length === 0 ) {
		childTypes = this.getChildNodeTypes();
		// Only insert a slug where paragraphs are allowed
		if ( childTypes === null || ve.indexOf( 'paragraph', childTypes ) !== -1 ) {
			this.slugs[0] = doc.importNode( slug, true );
			this.$element[0].appendChild( this.slugs[0] );
		}
	} else {
		// In case of document node (which is a block node) we do require slug if there are no
		// children that can contain content (such as paragraph). For instance: article with
		// just an image will get a block slug so more content can be added to it.
		if ( this.type === 'document' ) {
			slugRequired = true;
			for ( i = 0, len = this.children.length; i < len; i++ ) {
				if ( this.children[i].canContainContent() ) {
					slugRequired = false;
					break;
				}
			}
		}

		// Iterate over all children of this branch and add slugs in appropriate places
		for ( i = 0, len = this.children.length; i < len; i++ ) {
			// Don't put slugs after internal nodes.
			if ( ve.dm.nodeFactory.isNodeInternal( this.children[i].model.type ) ) {
				continue;
			}

			if ( !canHaveChildrenNotContent || slugRequired )  {
				// First sluggable child (left side)
				if ( i === 0 && this.children[i].canHaveSlugBefore() ) {
					this.slugs[i] = doc.importNode( slug, true );
					first = this.children[i].$element[0];
					first.parentNode.insertBefore( this.slugs[i], first );
				}
			}

			if ( !canHaveChildrenNotContent && this.children[i].canHaveSlugAfter() ) {
				if (
					// Last sluggable child (right side)
					i === this.children.length - 1 ||
					// Sluggable child followed by another sluggable child (in between)
					( this.children[i + 1] && this.children[i + 1].canHaveSlugBefore() )
				) {
					this.slugs[i + 1] = doc.importNode( slug, true );
					last = this.children[i].$element[this.children[i].$element.length - 1];
					last.parentNode.insertBefore( this.slugs[i + 1], last.nextSibling );
				}
			}
		}
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
		return this.slugs[0] || null;
	}
	for ( i = 0; i < this.children.length; i++ ) {
		startOffset += this.children[i].model.getOuterLength();
		if ( offset === startOffset ) {
			return this.slugs[i + 1] || null;
		}
	}
};

/**
 * Set live state on child nodes.
 *
 * @method
 * @param {boolean} live New live state
 * @fires live
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
