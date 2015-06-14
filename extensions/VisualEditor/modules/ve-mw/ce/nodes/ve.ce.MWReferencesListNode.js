/*!
 * VisualEditor ContentEditable MWReferencesListNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki references list node.
 *
 * @class
 * @extends ve.ce.LeafNode
 * @mixins ve.ce.FocusableNode
 *
 * @constructor
 * @param {ve.dm.MWReferencesListNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWReferencesListNode = function VeCeMWReferencesListNode( model, config ) {
	// Parent constructor
	ve.ce.LeafNode.call( this, model, config );

	// Mixin constructors
	ve.ce.FocusableNode.call( this );

	// Properties
	this.internalList = null;
	this.listNode = null;

	// DOM changes
	this.$element.addClass( 've-ce-mwReferencesListNode references' );
	this.$reflist = this.$( '<ol class="references"></ol>' );
	this.$refmsg = this.$( '<p>' )
		.addClass( 've-ce-mwReferencesListNode-muted' );

	// Events
	this.model.connect( this, { attributeChange: 'onAttributeChange' } );

	// Initialization
	this.update();
};

/* Inheritance */

OO.inheritClass( ve.ce.MWReferencesListNode, ve.ce.LeafNode );

OO.mixinClass( ve.ce.MWReferencesListNode, ve.ce.FocusableNode );

/* Static Properties */

ve.ce.MWReferencesListNode.static.name = 'mwReferencesList';

ve.ce.MWReferencesListNode.static.tagName = 'div';

ve.ce.MWReferencesListNode.static.primaryCommandName = 'referencesList';

/* Static Methods */

/**
 * @inheritdoc
 */
ve.ce.MWReferencesListNode.static.getDescription = function ( model ) {
	return model.getAttribute( 'refGroup' );
};

/* Methods */

/**
 * Handle setup events.
 *
 * @method
 */
ve.ce.MWReferencesListNode.prototype.onSetup = function () {
	this.internalList = this.model.getDocument().getInternalList();
	this.listNode = this.internalList.getListNode();

	this.internalList.connect( this, { update: 'onInternalListUpdate' } );
	this.listNode.connect( this, { update: 'onListNodeUpdate' } );

	// Parent method
	ve.ce.LeafNode.prototype.onSetup.call( this );
};

/**
 * Handle teardown events.
 *
 * @method
 */
ve.ce.MWReferencesListNode.prototype.onTeardown = function () {
	this.internalList.disconnect( this, { update: 'onInternalListUpdate' } );
	this.listNode.disconnect( this, { update: 'onListNodeUpdate' } );

	this.internalList = null;
	this.listNode = null;

	// Parent method
	ve.ce.LeafNode.prototype.onTeardown.call( this );
};

/**
 * Handle the updating of the InternalList object.
 *
 * This will occur after a document transaction.
 *
 * @method
 * @param {string[]} groupsChanged A list of groups which have changed in this transaction
 */
ve.ce.MWReferencesListNode.prototype.onInternalListUpdate = function ( groupsChanged ) {
	// Only update if this group has been changed
	if ( ve.indexOf( this.model.getAttribute( 'listGroup' ), groupsChanged ) !== -1 ) {
		this.update();
	}
};

/**
 * Rerender when the 'listGroup' attribute changes in the model.
 *
 * @param {string} key Attribute key
 * @param {string} from Old value
 * @param {string} to New value
 */
ve.ce.MWReferencesListNode.prototype.onAttributeChange = function ( key ) {
	if ( key === 'listGroup' ) {
		this.update();
	}
};

/**
 * Handle the updating of the InternalListNode.
 *
 * This will occur after changes to any InternalItemNode.
 *
 * @method
 */
ve.ce.MWReferencesListNode.prototype.onListNodeUpdate = function () {
	// When the list node updates we're not sure which list group the item
	// belonged to so we always update
	// TODO: Only re-render the reference which has been edited
	this.update();
};

/**
 * Update the references list.
 */
ve.ce.MWReferencesListNode.prototype.update = function () {
	var i, j, iLen, jLen, index, firstNode, key, keyedNodes, $li, modelNode, viewNode,
		internalList = this.model.getDocument().internalList,
		refGroup = this.model.getAttribute( 'refGroup' ),
		listGroup = this.model.getAttribute( 'listGroup' ),
		nodes = internalList.getNodeGroup( listGroup );

	this.$reflist.detach().empty();
	this.$refmsg.detach();

	if ( !nodes || !nodes.indexOrder.length ) {
		if ( refGroup !== '' ) {
			this.$refmsg.text( ve.msg( 'visualeditor-referenceslist-isempty', refGroup ) );
		} else {
			this.$refmsg.text( ve.msg( 'visualeditor-referenceslist-isempty-default' ) );
		}
		this.$element.append( this.$refmsg );
	} else {
		for ( i = 0, iLen = nodes.indexOrder.length; i < iLen; i++ ) {
			index = nodes.indexOrder[i];
			firstNode = nodes.firstNodes[index];

			key = internalList.keys[index];
			keyedNodes = nodes.keyedNodes[key];
			// Exclude references defined inside the references list node
			/*jshint loopfunc:true */
			keyedNodes = keyedNodes.filter( function ( node ) {
				while ( ( node = node.parent ) && node !== null ) {
					if ( node instanceof ve.dm.MWReferencesListNode ) {
						return false;
					}
				}
				return true;
			} );

			if ( !keyedNodes.length ) {
				continue;
			}

			$li = this.$( '<li>' );

			if ( keyedNodes.length > 1 ) {
				for ( j = 0, jLen = keyedNodes.length; j < jLen; j++ ) {
					$li.append(
						this.$( '<sup>' ).append(
							this.$( '<a>' ).text( ( i + 1 ) + '.' + j )
						)
					).append( ' ' );
				}
			}

			// Generate reference HTML from first item in key
			modelNode = internalList.getItemNode( firstNode.getAttribute( 'listIndex' ) );
			if ( modelNode && modelNode.length ) {
				viewNode = new ve.ce.InternalItemNode( modelNode );
				// HACK: PHP parser doesn't wrap single lines in a paragraph
				if (
					viewNode.$element.children().length === 1 &&
					viewNode.$element.children( 'p' ).length === 1
				) {
					// unwrap inner
					viewNode.$element.children().replaceWith(
						viewNode.$element.children().contents()
					);
				}
				$li.append(
					this.$( '<span>' )
						.addClass( 'reference-text' )
						.append( viewNode.$element.show() )
				);
				// HACK: See bug 62682 - We happen to know that destroy doesn't abort async
				// rendering for generated content nodes, but we really can't gaurantee that in the
				// future - if you are here, debugging, because something isn't rendering properly,
				// it's likely that something has changed and these assumptions are no longer valid
				viewNode.destroy();
			} else {
				$li.append(
					this.$( '<span>' )
						.addClass( 've-ce-mwReferencesListNode-muted' )
						.text( ve.msg( 'visualeditor-referenceslist-missingref' ) )
				);
			}

			this.$reflist.append( $li );
		}
		this.$element.append( this.$reflist );
	}
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWReferencesListNode );
