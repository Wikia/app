/*!
 * VisualEditor ContentEditable MWReferenceNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki reference node.
 *
 * @class
 * @extends ve.ce.LeafNode
 * @mixins ve.ce.FocusableNode
 * @mixins ve.ce.ProtectedNode
 * @mixins ve.ce.RelocatableNode
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
	ve.ce.ProtectedNode.call( this );
	ve.ce.RelocatableNode.call( this );

	// DOM changes
	this.$link = $( '<a>' ).attr( 'href', '#' );
	this.$.addClass( 've-ce-mwReferenceNode', 'reference' ).append( this.$link );

	this.index = '';
	this.internalList = this.model.getDocument().internalList;

	// Events
	this.connect( this, { 'live': 'onLive' } );

	// Initialization
	this.update();
};

/* Inheritance */

ve.inheritClass( ve.ce.MWReferenceNode, ve.ce.LeafNode );

ve.mixinClass( ve.ce.MWReferenceNode, ve.ce.FocusableNode );
ve.mixinClass( ve.ce.MWReferenceNode, ve.ce.ProtectedNode );
ve.mixinClass( ve.ce.MWReferenceNode, ve.ce.RelocatableNode );

/* Static Properties */

ve.ce.MWReferenceNode.static.name = 'mwReference';

ve.ce.MWReferenceNode.static.tagName = 'sup';

/* Methods */

/**
 * Handle live events.
 * @method
 */
ve.ce.MWReferenceNode.prototype.onLive = function () {
	// As we are listening to the internal list, we need to make sure
	// we remove the listeners when this object is removed from the document
	if ( this.live ) {
		this.internalList.connect( this, { 'update': 'onInternalListUpdate' } );
	} else {
		this.internalList.disconnect( this );
	}
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
	var listIndex = this.model.getAttribute( 'listIndex' ),
		listGroup = this.model.getAttribute( 'listGroup' ),
		refGroup = this.model.getAttribute( 'refGroup' ),
		position = this.internalList.getIndexPosition( listGroup, listIndex );

	this.$link.text( '[' + ( refGroup ? refGroup + ' ' : '' ) + ( position + 1 ) + ']' );
};

/** */
ve.ce.MWReferenceNode.prototype.createPhantoms = function () {
	// Parent method
	ve.ce.ProtectedNode.prototype.createPhantoms.call( this );

	if ( !this.getModel().isInspectable() ) {
		// TODO: Move this into one of the classes mixin or inherit from
		// as any focusable node that isn't inspectable should have this
		// as it would be bad UX to have a focusable nodes where one of the
		// same type doesn't show an inspector.
		this.$phantoms
			.addClass( 've-ce-mwReferenceNode-missingref' )
			.attr( 'title', ve.msg( 'visualeditor-referencelist-missingref' ) );
	}
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWReferenceNode );
