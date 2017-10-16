/*!
 * VisualEditor ContentEditable MWReferenceNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
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
	this.$link = this.$( '<a>' ).attr( 'href', '#' );
	this.$element.addClass( 've-ce-mwReferenceNode reference' ).append( this.$link );

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
 * @method
 */
ve.ce.MWReferenceNode.prototype.onSetup = function () {
	ve.ce.MWReferenceNode.super.prototype.onSetup.call( this );
	this.internalList.connect( this, { update: 'onInternalListUpdate' } );
};

/**
 * Handle teardown event.
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
	if ( ve.indexOf( this.model.getAttribute( 'listGroup' ), groupsChanged ) !== -1 ) {
		this.update();
	}
};

/**
 * Handle update events.
 *
 * @method
 */
ve.ce.MWReferenceNode.prototype.update = function () {
	this.$link.text( this.model.getIndexLabel() );
};

/** */
ve.ce.MWReferenceNode.prototype.createHighlights = function () {
	// Mixin method
	ve.ce.FocusableNode.prototype.createHighlights.call( this );

	if ( !this.getModel().isInspectable() ) {
		// TODO: Move this into one of the classes mixin or inherit from
		// as any focusable node that isn't inspectable should have this
		// as it would be bad UX to have a focusable nodes where one of the
		// same type doesn't show an inspector.
		this.$highlights
			.addClass( 've-ce-mwReferenceNode-missingref' )
			.attr( 'title', ve.msg( 'visualeditor-referenceslist-missingref' ) );
	}
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWReferenceNode );
