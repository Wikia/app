/*!
 * VisualEditor ContentEditable MWReferenceListNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki reference list node.
 *
 * @class
 * @extends ve.ce.LeafNode
 * @mixins ve.ce.ProtectedNode
 *
 * @constructor
 * @param {ve.dm.MWReferenceListNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWReferenceListNode = function VeCeMWReferenceListNode( model, config ) {
	// Parent constructor
	ve.ce.LeafNode.call( this, model, config );

	// Mixin constructors
	ve.ce.ProtectedNode.call( this );
	ve.ce.FocusableNode.call( this );

	// Properties
	this.internalList = null;
	this.listNode = null;

	// DOM changes
	this.$.addClass( 've-ce-mwReferenceListNode', 'reference' );
	this.$reflist = $( '<ol class="references"></ol>' );
	this.$refmsg = $( '<p>' )
		.addClass( 've-ce-mwReferenceListNode-muted' );

	// Initialization
	this.update();
};

/* Inheritance */

ve.inheritClass( ve.ce.MWReferenceListNode, ve.ce.LeafNode );

ve.mixinClass( ve.ce.MWReferenceListNode, ve.ce.ProtectedNode );

ve.mixinClass( ve.ce.MWReferenceListNode, ve.ce.FocusableNode );

/* Static Properties */

ve.ce.MWReferenceListNode.static.name = 'mwReferenceList';

ve.ce.MWReferenceListNode.static.tagName = 'div';

/* Methods */

/**
 * Handle setup events.
 *
 * @method
 */
ve.ce.MWReferenceListNode.prototype.onSetup = function () {
	this.internalList = this.model.getDocument().getInternalList();
	this.listNode = this.internalList.getListNode();

	this.internalList.connect( this, { 'update': 'onInternalListUpdate' } );
	this.listNode.connect( this, { 'update': 'onListNodeUpdate' } );

	// Parent method
	ve.ce.LeafNode.prototype.onSetup.call( this );
};

/**
 * Handle teardown events.
 *
 * @method
 */
ve.ce.MWReferenceListNode.prototype.onTeardown = function () {
	this.internalList.disconnect( this, { 'update': 'onInternalListUpdate' } );
	this.listNode.disconnect( this, { 'update': 'onListNodeUpdate' } );

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
ve.ce.MWReferenceListNode.prototype.onInternalListUpdate = function ( groupsChanged ) {
	// Only update if this group has been changed
	if ( ve.indexOf( this.model.getAttribute( 'listGroup' ), groupsChanged ) !== -1 ) {
		this.update();
	}
};

/**
 * Handle attribute change events.
 *
 * @param {string} key Attribute key
 * @param {string} from Old value
 * @param {string} to New value
 */
ve.ce.MWReferenceListNode.prototype.onAttributeChange = function ( key ) {
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
ve.ce.MWReferenceListNode.prototype.onListNodeUpdate = function () {
	// When the list node updates we're not sure which list group the item
	// belonged to so we always update
	// TODO: Only re-render the reference which has been edited
	this.update();
};

/**
 * Update the reference list.
 */
ve.ce.MWReferenceListNode.prototype.update = function () {
	var i, j, iLen, jLen, index, firstNode, key, keyedNodes, $li, modelNode, viewNode,
		internalList = this.model.getDocument().internalList,
		refGroup = this.model.getAttribute( 'refGroup' ),
		listGroup = this.model.getAttribute( 'listGroup' ),
		nodes = internalList.getNodeGroup( listGroup );

	this.$reflist.detach().empty();
	this.$refmsg.detach();

	if ( !nodes || !nodes.indexOrder.length ) {
		if ( refGroup !== '' ) {
			this.$refmsg.text( ve.msg( 'visualeditor-referencelist-isempty', refGroup ) );
		} else {
			this.$refmsg.text( ve.msg( 'visualeditor-referencelist-isempty-default' ) );
		}
		this.$.append( this.$refmsg );
	} else {
		for ( i = 0, iLen = nodes.indexOrder.length; i < iLen; i++ ) {
			index = nodes.indexOrder[i];
			firstNode = nodes.firstNodes[index];

			key = internalList.keys[index];
			keyedNodes = nodes.keyedNodes[key];
			// Exclude references defined inside the reference list node
			/*jshint loopfunc:true */
			keyedNodes = keyedNodes.filter( function ( node ) {
				while ( ( node = node.parent ) && node !== null ) {
					if ( node instanceof ve.dm.MWReferenceListNode ) {
						return false;
					}
				}
				return true;
			} );

			if ( !keyedNodes.length ) {
				continue;
			}

			$li = $( '<li>' );

			if ( keyedNodes.length > 1 ) {
				for ( j = 0, jLen = keyedNodes.length; j < jLen; j++ ) {
					$li.append(
						$( '<sup>' ).append(
							$( '<a>' ).text( ( i + 1 ) + '.' + j )
						)
					).append( ' ' );
				}
			}

			// Generate reference HTML from first item in key
			modelNode = internalList.getItemNode( firstNode.getAttribute( 'listIndex' ) );
			if ( modelNode.length ) {
				viewNode = new ve.ce.InternalItemNode( modelNode );
				// HACK: PHP parser doesn't wrap single lines in a paragraph
				if ( viewNode.$.children().length === 1 && viewNode.$.children( 'p' ).length === 1 ) {
					// unwrap inner
					viewNode.$.children().replaceWith( viewNode.$.children().contents() );
				}
				$li.append(
					$( '<span>' )
						.addClass( 'reference-text' )
						.append( viewNode.$.clone().show() )
				);
				viewNode.destroy();
			} else {
				$li.append(
					$( '<span>' )
						.addClass( 've-ce-mwReferenceListNode-muted' )
						.text( ve.msg( 'visualeditor-referencelist-missingref' ) )
				);
			}

			this.$reflist.append( $li );
		}
		this.$.append( this.$reflist );
	}
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWReferenceListNode );
