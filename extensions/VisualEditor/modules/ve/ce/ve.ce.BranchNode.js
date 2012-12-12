/**
 * VisualEditor content editable BranchNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable node that can have branch or leaf children.
 *
 * @class
 * @abstract
 * @constructor
 * @extends {ve.ce.Node}
 * @param {String} type Symbolic name of node type
 * @param {ve.dm.BranchNode} model Model to observe
 * @param {jQuery} [$element] Element to use as a container
 */
ve.ce.BranchNode = function VeCeBranchNode( type, model, $element ) {
	// Mixin constructor
	ve.BranchNode.call( this );

	// Parent constructor
	ve.ce.Node.call( this, type, model, $element );

	// Properties
	this.domWrapperElementType = this.$.get( 0 ).nodeName.toLowerCase();
	this.slugs = { };

	// Events
	this.model.addListenerMethod( this, 'splice', 'onSplice' );

	// DOM Changes
	this.$.addClass( 've-ce-branchNode' );

	// Initialization
	this.onSplice.apply( this, [0, 0].concat( model.getChildren() ) );
};

/* Inheritance */

ve.inheritClass( ve.ce.BranchNode, ve.ce.Node );

ve.mixinClass( ve.ce.BranchNode, ve.BranchNode );

/* Static Members */

// TODO: Consider using different (or additional) CSS classes for inline and block aliens

if ( $.browser.msie ) {
	ve.ce.BranchNode.$inlineSlugTemplate = $( '<span class="ve-ce-slug">&nbsp;</span>' );
} else {
	ve.ce.BranchNode.$inlineSlugTemplate = $( '<span class="ve-ce-slug">&#xFEFF;</span>' );
}

ve.ce.BranchNode.$blockSlugTemplate =
	ve.ce.BranchNode.$inlineSlugTemplate.clone().css( 'display', 'block' );

/* Static Methods */

/**
 * Gets the appropriate element type for the DOM wrapper of a node.
 *
 * This method reads the {key} attribute from a {model} and looks up a type in the node's statically
 * defined {domWrapperElementTypes} member, which is a mapping of possible values of that attribute
 * and DOM element types.
 *
 * @method
 * @param {ve.dm.BranchNode} model Model node is based on
 * @param {String} key Attribute name to read type value from
 * @returns {String} DOM element type for wrapper
 * @throws 'Undefined attribute' if attribute is not defined in the model
 * @throws 'Invalid attribute value' if attribute value is not a key in {domWrapperElementTypes}
 */
ve.ce.BranchNode.getDomWrapperType = function ( model, key ) {
	var types,
		value = model.getAttribute( key );
	if ( value === undefined ) {
		throw new Error( 'Undefined attribute: ' + key );
	}
	types = ve.ce.nodeFactory.lookup( model.getType() ).domWrapperElementTypes;
	if ( types[value] === undefined ) {
		throw new Error( 'Invalid attribute value: ' + value );
	}
	return types[value];
};

/**
 * Gets a jQuery selection of a new DOM wrapper for a node.
 *
 * This method uses {getDomWrapperType} to determine the proper element type to use.
 *
 * @method
 * @param {ve.dm.BranchNode} model Model node is based on
 * @param {String} key Attribute name to read type value from
 * @returns {jQuery} Selection of DOM wrapper
 */
ve.ce.BranchNode.getDomWrapper = function ( model, key ) {
	var type = ve.ce.BranchNode.getDomWrapperType( model, key );
	return $( document.createElement( type ) );
};

/* Methods */

/**
 * Updates the DOM wrapper of this node if needed.
 *
 * This method uses {getDomWrapperType} to determine the proper element type to use.
 *
 * WARNING: The contents, .data( 'node' ) and any classes the wrapper already has will be moved to
 * the new wrapper, but other attributes and any other information added using $.data() will be
 * lost upon updating the wrapper. To retain information added to the wrapper, subscribe to the
 * 'rewrap' event and copy information from the {$old} wrapper the {$new} wrapper.
 *
 * @method
 * @param {String} key Attribute name to read type value from
 * @emits rewrap ($old, $new)
 */
ve.ce.BranchNode.prototype.updateDomWrapper = function ( key ) {
	var $element,
		type = ve.ce.BranchNode.getDomWrapperType( this.model, key );

	if ( type !== this.domWrapperElementType ) {
		$element = $( document.createElement( type ) );
		// Copy classes
		$element.attr( 'class', this.$.attr( 'class' ) );
		// Copy .data( 'node' )
		$element.data( 'node', this.$.data( 'node' ) );
		// Move contents
		$element.append( this.$.contents() );
		// Emit an event that can be handled to copy other things over if needed
		this.emit( 'rewrap', this.$, $element );
		// Swap elements
		this.$.replaceWith( $element );
		// Use new element from now on
		this.$ = $element;
		// Remember which type we are using now
		this.domWrapperElementType = type;
	}
};

/**
 * Responds to splice events on a ve.dm.BranchNode.
 *
 * ve.ce.Node objects are generated from the inserted ve.dm.Node objects, producing a view that's a
 * mirror of its model.
 *
 * @method
 * @param {Number} index Index to remove and or insert nodes at
 * @param {Number} howmany Number of nodes to remove
 * @param {ve.dm.BranchNode} [...] Variadic list of nodes to insert
 */
ve.ce.BranchNode.prototype.onSplice = function ( index ) {
	var i,
		length,
		args = Array.prototype.slice.call( arguments ),
		$anchor,
		removals;
	// Convert models to views and attach them to this node
	if ( args.length >= 3 ) {
		for ( i = 2, length = args.length; i < length; i++ ) {
			args[i] = ve.ce.nodeFactory.create( args[i].getType(), args[i] );
		}
	}
	removals = this.children.splice.apply( this.children, args );
	for ( i = 0, length = removals.length; i < length; i++ ) {
		removals[i].detach();
		// Update DOM
		removals[i].$.detach();
		removals[i].setLive( false );
	}
	if ( args.length >= 3 ) {
		if ( index ) {
			// Get the element before the insertion point
			$anchor = this.children[ index - 1 ].$.last();
		}
		for ( i = args.length - 1; i >= 2; i-- ) {
			args[i].attach( this );
			if ( index ) {
				$anchor.after( args[i].$ );
			} else {
				this.$.prepend( args[i].$ );
			}
			if ( this.live !== args[i].isLive() ) {
				args[i].setLive( this.live );
			}
		}
	}

	this.setupSlugs();
};

ve.ce.BranchNode.prototype.setupSlugs = function () {
	var key, $slug, i;

	// Remove all slugs in this branch
	for( key in this.slugs ) {
		this.slugs[key].remove();
		delete this.slugs[key];
	}

	if ( this.canHaveGrandchildren() ) {
		$slug = ve.ce.BranchNode.$blockSlugTemplate.clone();
	} else {
		$slug = ve.ce.BranchNode.$inlineSlugTemplate.clone();
	}

	if ( this.getLength() === 0 ) {
		this.slugs[0] = $slug.clone().appendTo( this.$ );
	} else {
		// Iterate over all children of this branch and add slugs in appropriate places
		for ( i = 0; i < this.children.length; i++ ) {
			// First sluggable child (left side)
			if ( i === 0 && this.children[i].canHaveSlugBefore() ) {
				this.slugs[i] = $slug.clone().insertBefore( this.children[i].$.first() );
			}
			if ( this.children[i].canHaveSlugAfter() ) {
				if (
					// Last sluggable child (right side)
					i === this.children.length - 1 ||
					// Sluggable child followed by another sluggable child (in between)
					( this.children[i + 1] && this.children[i + 1].canHaveSlugBefore() )
				) {
					this.slugs[i + 1] = $slug.clone().insertAfter( this.children[i].$.last() );
				}
			}
		}
	}
};

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

ve.ce.BranchNode.prototype.clean = function () {
	// Detach all child nodes from this.$
	// We can't use this.$.empty() because that destroys .data() and event handlers
	this.$.contents().each( function () {
		$(this).detach();
	} );
	// Reattach the child nodes we're supposed to have
	for ( var i = 0; i < this.children.length; i++ ) {
		this.$.append( this.children[i].$ );
	}
	this.setupSlugs();
};

/**
 * @method
 */
ve.ce.BranchNode.prototype.setLive = function ( live ) {
	this.live = live;
	this.emit( 'live' );
	for ( var i = 0; i < this.children.length; i++ ) {
		this.children[i].setLive( live );
	}
};