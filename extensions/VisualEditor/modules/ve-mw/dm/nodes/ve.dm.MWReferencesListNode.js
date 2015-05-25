/*!
 * VisualEditor DataModel MWReferencesListNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
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

ve.dm.MWReferencesListNode.static.matchTagNames = null;

ve.dm.MWReferencesListNode.static.matchRdfaTypes = [ 'mw:Extension/references' ];

ve.dm.MWReferencesListNode.static.storeHtmlAttributes = false;

ve.dm.MWReferencesListNode.static.toDataElement = function ( domElements, converter ) {
	var referencesListData, $contents, contentsData,
		mwDataJSON = domElements[0].getAttribute( 'data-mw' ),
		mwData = mwDataJSON ? JSON.parse( mwDataJSON ) : {},
		refGroup = mwData.attrs && mwData.attrs.group || '',
		listGroup = 'mwReference/' + refGroup;

	referencesListData = {
		type: this.name,
		attributes: {
			mw: mwData,
			originalMw: mwDataJSON,
			domElements: ve.copy( domElements ),
			refGroup: refGroup,
			listGroup: listGroup
		}
	};
	if ( mwData.body && mwData.body.html ) {
		$contents = $( '<div>', domElements[0].ownerDocument ).append( mwData.body.html );
		contentsData = converter.getDataFromDomClean( $contents[0] );
		return [ referencesListData ].
			concat( contentsData ).
			concat( [ { type: '/' + this.name } ] );
	} else {
		return referencesListData;
	}

};

ve.dm.MWReferencesListNode.static.toDomElements = function ( data, doc, converter ) {
	var el, els, mwData, originalMw, wrapper, contentsHtml, originalHtml,
		dataElement = data[0],
		attribs = dataElement.attributes,
		contentsData = data.slice( 1, -1 );

	if ( attribs.domElements ) {
		// If there's more than 1 element, preserve entire array, not just first element
		els = ve.copyDomElements( attribs.domElements, doc );
		el = els[0];
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
		wrapper = doc.createElement( 'div' );
		converter.getDomSubtreeFromData( data.slice( 1, -1 ), wrapper );
		contentsHtml = $( wrapper ).html(); // Returns '' if wrapper is empty
		originalHtml = ve.getProp( mwData, 'body', 'html' ) || '';
		// Only set body.html if contentsHtml and originalHtml are actually different
		if ( !$( '<div>' ).html( originalHtml ).get( 0 ).isEqualNode( wrapper ) ) {
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
