/*!
 * VisualEditor DataModel MWReferenceNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki reference node.
 *
 * @class
 * @extends ve.dm.LeafNode
 * @mixins ve.dm.FocusableNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.MWReferenceNode = function VeDmMWReferenceNode() {
	// Parent constructor
	ve.dm.LeafNode.apply( this, arguments );

	// Mixin constructors
	ve.dm.FocusableNode.call( this );

	// Event handlers
	this.connect( this, {
		root: 'onRoot',
		unroot: 'onUnroot'
	} );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWReferenceNode, ve.dm.LeafNode );

OO.mixinClass( ve.dm.MWReferenceNode, ve.dm.FocusableNode );

/* Static members */

ve.dm.MWReferenceNode.static.name = 'mwReference';

ve.dm.MWReferenceNode.static.matchTagNames = null;

ve.dm.MWReferenceNode.static.matchRdfaTypes = [ 'mw:Extension/ref' ];

ve.dm.MWReferenceNode.static.isContent = true;

ve.dm.MWReferenceNode.static.blacklistedAnnotationTypes = [ 'link' ];

/**
 * Regular expression for parsing the listKey attribute
 * @static
 * @property {RegExp}
 * @inheritable
 */
ve.dm.MWReferenceNode.static.listKeyRegex = /^(auto|literal)\/(.*)$/;

ve.dm.MWReferenceNode.static.toDataElement = function ( domElements, converter ) {
	var dataElement,
		mwDataJSON = domElements[0].getAttribute( 'data-mw' ),
		mwData = mwDataJSON ? JSON.parse( mwDataJSON ) : {},
		body = mwData.body ? mwData.body.html : '',
		refGroup = mwData.attrs && mwData.attrs.group || '',
		listGroup = this.name + '/' + refGroup,
		autoKeyed = !mwData.attrs || mwData.attrs.name === undefined,
		listKey = autoKeyed ? 'auto/' + converter.internalList.getNextUniqueNumber() : 'literal/' + mwData.attrs.name,
		queueResult = converter.internalList.queueItemHtml( listGroup, listKey, body ),
		listIndex = queueResult.index,
		contentsUsed = ( body !== '' && queueResult.isNew );

	dataElement = {
		type: this.name,
		attributes: {
			mw: mwData,
			originalMw: mwDataJSON,
			childDomElements: ve.copy( Array.prototype.slice.apply( domElements[0].childNodes ) ),
			listIndex: listIndex,
			listGroup: listGroup,
			listKey: listKey,
			refGroup: refGroup,
			contentsUsed: contentsUsed
		}
	};
	return dataElement;
};

ve.dm.MWReferenceNode.static.toDomElements = function ( dataElement, doc, converter ) {
	var itemNodeHtml, originalHtml, mwData, i, iLen, keyedNodes, setContents, contentsAlreadySet,
		originalMw, childDomElements, listKeyParts, name,
		el = doc.createElement( 'span' ),
		itemNodeWrapper = doc.createElement( 'div' ),
		itemNode = converter.internalList.getItemNode( dataElement.attributes.listIndex ),
		itemNodeRange = itemNode.getRange();

	el.setAttribute( 'typeof', 'mw:Extension/ref' );

	mwData = dataElement.attributes.mw ? ve.copy( dataElement.attributes.mw ) : {};
	mwData.name = 'ref';

	setContents = dataElement.attributes.contentsUsed;

	keyedNodes = converter.internalList
		.getNodeGroup( dataElement.attributes.listGroup )
		.keyedNodes[dataElement.attributes.listKey];

	if ( setContents ) {
		// Check if a previous node has already set the content. If so, we don't overwrite this
		// node's contents.
		contentsAlreadySet = false;
		if ( keyedNodes ) {
			for ( i = 0, iLen = keyedNodes.length; i < iLen; i++ ) {
				if ( keyedNodes[i].element === dataElement ) {
					break;
				}
				if ( keyedNodes[i].element.attributes.contentsUsed ) {
					contentsAlreadySet = true;
					break;
				}
			}
		}
	} else {
		// Check if any other nodes with this key provided content. If not
		// then we attach the contents to the first reference with this key

		// Check that this is the first reference with its key
		if ( keyedNodes && dataElement === keyedNodes[0].element ) {
			setContents = true;
			// Check no other reference originally defined the contents
			// As this is keyedNodes[0] we can start at 1
			for ( i = 1, iLen = keyedNodes.length; i < iLen; i++ ) {
				if ( keyedNodes[i].element.attributes.contentsUsed ) {
					setContents = false;
					break;
				}
			}
		}
	}

	if ( setContents && !contentsAlreadySet ) {
		converter.getDomSubtreeFromData(
			itemNode.getDocument().getFullData( itemNodeRange, true ),
			itemNodeWrapper
		);
		itemNodeHtml = $( itemNodeWrapper ).html(); // Returns '' if itemNodeWrapper is empty
		originalHtml = ve.getProp( mwData, 'body', 'html' ) || '';
		// Only set body.html if itemNodeHtml and originalHtml are actually different
		if ( !$( '<div>' ).html( originalHtml ).get( 0 ).isEqualNode( itemNodeWrapper ) ) {
			ve.setProp( mwData, 'body', 'html', itemNodeHtml );
		}
	}

	// Generate name
	listKeyParts = dataElement.attributes.listKey.match( this.listKeyRegex );
	if ( listKeyParts[1] === 'auto' ) {
		// Only render a name if this key was reused
		if ( keyedNodes.length > 1 ) {
			// Allocate a unique list key, then strip the 'literal/'' prefix
			name = converter.internalList.getUniqueListKey(
				dataElement.attributes.listGroup,
				dataElement.attributes.listKey,
				// Generate a name starting with ':' to distinguish it from normal names
				'literal/:'
			).slice( 'literal/'.length );
		} else {
			name = undefined;
		}
	} else {
		// Use literal name
		name = listKeyParts[2];
	}
	// Set name
	if ( name !== undefined ) {
		ve.setProp( mwData, 'attrs', 'name', name );
	}

	// Set or clear group
	if ( dataElement.attributes.refGroup !== '' ) {
		ve.setProp( mwData, 'attrs', 'group', dataElement.attributes.refGroup );
	} else if ( mwData.attrs ) {
		delete mwData.attrs.refGroup;
	}

	// If mwAttr and originalMw are the same, use originalMw to prevent reserialization.
	// Reserialization has the potential to reorder keys and so change the DOM unnecessarily
	originalMw = dataElement.attributes.originalMw;
	if ( originalMw && ve.compare( mwData, JSON.parse( originalMw ) ) ) {
		el.setAttribute( 'data-mw', originalMw );

		// Restore the span's childNodes to prevent unnecessary DOM diffs
		childDomElements = ve.copyDomElements( dataElement.attributes.childDomElements, doc );
		for ( i = 0, iLen = childDomElements.length; i < iLen; i++ ) {
			el.appendChild( childDomElements[i] );
		}
	} else {
		el.setAttribute( 'data-mw', JSON.stringify( mwData ) );
		// HTML for the external clipboard, it will be ignored by the converter
		$( el ).append(
			$( '<sup>', doc ).text( this.getIndexLabel( dataElement, converter.internalList ) )
		);
	}

	return [ el ];
};

ve.dm.MWReferenceNode.static.remapInternalListIndexes = function ( dataElement, mapping, internalList ) {
	var listKeyParts;
	// Remap listIndex
	dataElement.attributes.listIndex = mapping[dataElement.attributes.listIndex];

	// Remap listKey if it was automatically generated
	listKeyParts = dataElement.attributes.listKey.match( this.listKeyRegex );
	if ( listKeyParts[1] === 'auto' ) {
		dataElement.attributes.listKey = 'auto/' + internalList.getNextUniqueNumber();
	}
};

ve.dm.MWReferenceNode.static.remapInternalListKeys = function ( dataElement, internalList ) {
	var suffix = '';
	// Try name, name2, name3, ... until unique
	while ( ve.indexOf( dataElement.attributes.listKey + suffix, internalList.keys ) !== -1 ) {
		suffix = suffix ? suffix + 1 : 2;
	}
	if ( suffix ) {
		dataElement.attributes.listKey = dataElement.attributes.listKey + suffix;
	}
};

/**
 * Gets the index label for the reference
 * @static
 * @param {Object} dataElement Element data
 * @param {ve.dm.InternalList} internalList Internal list
 * @returns {string} Reference label
 */
ve.dm.MWReferenceNode.static.getIndexLabel = function ( dataElement, internalList ) {
	var listIndex = dataElement.attributes.listIndex,
		listGroup = dataElement.attributes.listGroup,
		refGroup = dataElement.attributes.refGroup,
		position = internalList.getIndexPosition( listGroup, listIndex );

	return '[' + ( refGroup ? refGroup + ' ' : '' ) + ( position + 1 ) + ']';
};

/* Methods */

/**
 * Don't allow reference nodes to be inspected if we can't find their contents.
 *
 * @inheritdoc
 */
ve.dm.MWReferenceNode.prototype.isInspectable = function () {
	var internalItem = this.getInternalItem();
	return internalItem && internalItem.getLength() > 0;
};

/**
 * Gets the internal item node associated with this node
 * @method
 * @returns {ve.dm.InternalItemNode} Item node
 */
ve.dm.MWReferenceNode.prototype.getInternalItem = function () {
	return this.getDocument().getInternalList().getItemNode( this.getAttribute( 'listIndex' ) );
};

/**
 * Gets the index label for the reference
 * @method
 * @returns {string} Reference label
 */
ve.dm.MWReferenceNode.prototype.getIndexLabel = function () {
	return this.constructor.static.getIndexLabel( this.element, this.getDocument().getInternalList() );
};

/**
 * Handle the node being attached to the root
 * @method
 */
ve.dm.MWReferenceNode.prototype.onRoot = function () {
	this.addToInternalList();
};

/**
 * Handle the node being detatched from the root
 * @method
 */
ve.dm.MWReferenceNode.prototype.onUnroot = function () {
	this.removeFromInternalList();
};

/**
 * Register the node with the internal list
 * @method
 */
ve.dm.MWReferenceNode.prototype.addToInternalList = function () {
	if ( this.getRoot() === this.getDocument().getDocumentNode() ) {
		this.getDocument().getInternalList().addNode(
			this.element.attributes.listGroup,
			this.element.attributes.listKey,
			this.element.attributes.listIndex,
			this
		);
	}
};

/**
 * Unregister the node from the internal list
 * @method
 */
ve.dm.MWReferenceNode.prototype.removeFromInternalList = function () {
	this.getDocument().getInternalList().removeNode(
		this.element.attributes.listGroup,
		this.element.attributes.listKey,
		this.element.attributes.listIndex,
		this
	);
};

/** */
ve.dm.MWReferenceNode.prototype.getClonedElement = function () {
	var clone = ve.dm.LeafNode.prototype.getClonedElement.call( this );
	delete clone.attributes.contentsUsed;
	delete clone.attributes.mw;
	delete clone.attributes.originalMw;
	return clone;
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWReferenceNode );
