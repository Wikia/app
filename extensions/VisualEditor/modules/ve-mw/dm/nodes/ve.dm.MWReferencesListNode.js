/*!
 * VisualEditor DataModel MWReferencesListNode class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki references list node.
 *
 * @class
 * @extends ve.dm.BranchNode
 * @mixins ve.dm.FocusableNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.MWReferencesListNode = function VeDmMWReferencesListNode() {
	// Parent constructor
	ve.dm.BranchNode.apply( this, arguments );

	// Mixin constructors
	ve.dm.FocusableNode.call( this );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWReferencesListNode, ve.dm.BranchNode );

OO.mixinClass( ve.dm.MWReferencesListNode, ve.dm.FocusableNode );

/* Static members */

ve.dm.MWReferencesListNode.static.name = 'mwReferencesList';

ve.dm.MWReferencesListNode.static.handlesOwnChildren = true;

ve.dm.MWReferencesListNode.static.ignoreChildren = true;

ve.dm.MWReferencesListNode.static.matchTagNames = null;

ve.dm.MWReferencesListNode.static.matchRdfaTypes = [ 'mw:Extension/references' ];

ve.dm.MWReferencesListNode.static.preserveHtmlAttributes = false;

ve.dm.MWReferencesListNode.static.toDataElement = function ( domElements, converter ) {
	var referencesListData, contentsDiv, contentsData,
		mwDataJSON = domElements[ 0 ].getAttribute( 'data-mw' ),
		mwData = mwDataJSON ? JSON.parse( mwDataJSON ) : {},
		refGroup = mwData.attrs && mwData.attrs.group || '',
		listGroup = 'mwReference/' + refGroup;

	referencesListData = {
		type: this.name,
		attributes: {
			mw: mwData,
			originalMw: mwDataJSON,
			refGroup: refGroup,
			listGroup: listGroup
		}
	};
	if ( mwData.body && mwData.body.html ) {
		// Process the nodes in .body.html as if they were this node's children
		contentsDiv = domElements[ 0 ].ownerDocument.createElement( 'div' );
		contentsDiv.innerHTML = mwData.body.html;
		contentsData = converter.getDataFromDomClean( contentsDiv );
		referencesListData = [ referencesListData ]
			.concat( contentsData )
			.concat( [ { type: '/' + this.name } ] );
	}
	return referencesListData;
};

ve.dm.MWReferencesListNode.static.toDomElements = function ( data, doc, converter ) {
	var el, els, mwData, originalMw, contentsHtml, originalHtml,
		wrapper = doc.createElement( 'div' ),
		originalHtmlWrapper = doc.createElement( 'div' ),
		dataElement = data[ 0 ],
		attribs = dataElement.attributes,
		contentsData = data.slice( 1, -1 );

	if ( dataElement.originalDomElements ) {
		// If there's more than 1 element, preserve entire array, not just first element
		els = ve.copyDomElements( dataElement.originalDomElements, doc );
		el = els[ 0 ];
	} else {
		el = doc.createElement( 'div' );
		els = [ el ];
	}

	mwData = attribs.mw ? ve.copy( attribs.mw ) : {};

	mwData.name = 'references';

	if ( attribs.refGroup ) {
		ve.setProp( mwData, 'attrs', 'group', attribs.refGroup );
	} else if ( mwData.attrs ) {
		delete mwData.attrs.refGroup;
	}

	el.setAttribute( 'typeof', 'mw:Extension/references' );

	if ( contentsData.length > 2 ) {
		converter.getDomSubtreeFromData( data.slice( 1, -1 ), wrapper );
		contentsHtml = wrapper.innerHTML; // Returns '' if wrapper is empty
		originalHtml = ve.getProp( mwData, 'body', 'html' ) || '';
		originalHtmlWrapper.innerHTML = originalHtml;
		// Only set body.html if contentsHtml and originalHtml are actually different
		if ( !originalHtmlWrapper.isEqualNode( wrapper ) ) {
			ve.setProp( mwData, 'body', 'html', contentsHtml );
		}
	}

	// If mwData and originalMw are the same, use originalMw to prevent reserialization.
	// Reserialization has the potential to reorder keys and so change the DOM unnecessarily
	originalMw = attribs.originalMw;
	if ( originalMw && ve.compare( mwData, JSON.parse( originalMw ) ) ) {
		el.setAttribute( 'data-mw', originalMw );
	} else {
		el.setAttribute( 'data-mw', JSON.stringify( mwData ) );
	}

	return els;
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWReferencesListNode );
