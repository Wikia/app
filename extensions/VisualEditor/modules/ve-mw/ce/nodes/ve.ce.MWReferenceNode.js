/*!
 * VisualEditor ContentEditable MWReferenceNode class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki reference node.
 *
 * @class
 * @extends ve.ce.LeafNode
 * @mixins ve.ce.FocusableNode
 *
 * @constructor
 * @param {ve.dm.MWReferenceNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWReferenceNode = function VeCeMWReferenceNode( model, config ) {
	// Parent constructor
	ve.ce.LeafNode.call( this, model, config );

	// Mixin constructors
	ve.ce.FocusableNode.call( this );

	// DOM changes
	this.$link = $( '<a>' ).attr( 'href', '#' );
	this.$element.addClass( 've-ce-mwReferenceNode mw-ref' ).append( this.$link )
		// In case we have received a version with old-style Cite HTML, remove the
		// old reference class
		.removeClass( 'reference' );
	// Add a backwards-compatible text for browsers that don't support counters
	this.$text = $( '<span>' ).addClass( 'mw-reflink-text' );
	this.$link.append( this.$text );

	this.index = '';
	this.internalList = this.model.getDocument().internalList;

	// Events
	this.connect( this, { setup: 'onSetup' } );
	this.connect( this, { teardown: 'onTeardown' } );

	// Initialization
	this.update();
};

/* Inheritance */

OO.inheritClass( ve.ce.MWReferenceNode, ve.ce.LeafNode );

OO.mixinClass( ve.ce.MWReferenceNode, ve.ce.FocusableNode );

/* Static Properties */

ve.ce.MWReferenceNode.static.name = 'mwReference';

ve.ce.MWReferenceNode.static.tagName = 'span';

ve.ce.MWReferenceNode.static.primaryCommandName = 'reference';

/* Methods */

/**
 * Handle setup event.
 *
 * @method
 */
ve.ce.MWReferenceNode.prototype.onSetup = function () {
	ve.ce.MWReferenceNode.super.prototype.onSetup.call( this );
	this.internalList.connect( this, { update: 'onInternalListUpdate' } );
};

/**
 * Handle teardown event.
 *
 * @method
 */
ve.ce.MWReferenceNode.prototype.onTeardown = function () {
	// As we are listening to the internal list, we need to make sure
	// we remove the listeners when this object is removed from the document
	this.internalList.disconnect( this );

	ve.ce.MWReferenceNode.super.prototype.onTeardown.call( this );
};

/**
 * Handle the updating of the InternalList object.
 *
 * This will occur after a document transaction.
 *
 * @method
 * @param {string[]} groupsChanged A list of groups which have changed in this transaction
 */
ve.ce.MWReferenceNode.prototype.onInternalListUpdate = function ( groupsChanged ) {
	// Only update if this group has been changed
	if ( groupsChanged.indexOf( this.model.getAttribute( 'listGroup' ) ) !== -1 ) {
		this.update();
	}
};

/**
 * Handle update events.
 *
 * @method
 */
ve.ce.MWReferenceNode.prototype.update = function () {
	var group = this.model.getGroup();
	this.$text.text( this.model.getIndexLabel() );
	this.$link.css( 'counterReset', 'mw-Ref ' + this.model.getIndex() );
	if ( group ) {
		this.$link.attr( 'data-mw-group', group );
	} else {
		this.$link.removeAttr( 'data-mw-group' );
	}
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWReferenceNode );
