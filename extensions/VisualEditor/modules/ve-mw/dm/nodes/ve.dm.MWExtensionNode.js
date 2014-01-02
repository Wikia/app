/*!
 * VisualEditor DataModel MWExtensionNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki Extension node.
 *
 * @class
 * @extends ve.dm.LeafNode
 * @mixins ve.dm.GeneratedContentNode
 *
 * @constructor
 */
ve.dm.MWExtensionNode = function VeDmMWExtensionNode( length, element ) {
	// Parent constructor
	ve.dm.LeafNode.call( this, 0, element );

	// Mixin constructors
	ve.dm.GeneratedContentNode.call( this );
};

/* Inheritance */

ve.inheritClass( ve.dm.MWExtensionNode, ve.dm.LeafNode );

ve.mixinClass( ve.dm.MWExtensionNode, ve.dm.GeneratedContentNode );

/* Static members */

ve.dm.MWExtensionNode.static.enableAboutGrouping = true;

ve.dm.MWExtensionNode.static.matchTagNames = null;

ve.dm.MWExtensionNode.static.isContent = true;

ve.dm.MWExtensionNode.static.tagName = null;

/**
 * Name of the extension and the parser tag name.
 * @static
 * @property {string} static.extensionName
 * @inheritable
 */
ve.dm.MWExtensionNode.static.extensionName = null;

ve.dm.MWExtensionNode.static.getMatchRdfaTypes = function () {
	return [ 'mw:Extension/' + this.extensionName ];
};

ve.dm.MWExtensionNode.static.toDataElement = function ( domElements, converter ) {
	var dataElement, index,
		mwDataJSON = domElements[0].getAttribute( 'data-mw' ),
		mwData = mwDataJSON ? JSON.parse( mwDataJSON ) : {};

	dataElement = {
		'type': this.name,
		'attributes': {
			'mw': mwData,
			'originalDomElements': ve.copy( domElements ),
			'originalMw': mwDataJSON
		}
	};

	index = this.storeDomElements( dataElement, domElements, converter.getStore() );
	dataElement.attributes.originalIndex = index;

	return dataElement;
};

ve.dm.MWExtensionNode.static.toDomElements = function ( dataElement, doc, converter ) {
	var el,
		index = converter.getStore().indexOfHash( ve.getHash( this.getHashObject( dataElement ) ) ),
		originalMw = dataElement.attributes.originalMw;

	// If the transclusion is unchanged just send back the
	// original DOM elements so selser can skip over it
	if (
		index === dataElement.attributes.originalIndex ||
		( originalMw && ve.compare( dataElement.attributes.mw, JSON.parse( originalMw ) ) )
	) {
		// The object in the store is also used for CE rendering so return a copy
		return ve.copyDomElements( dataElement.attributes.originalDomElements, doc );
	} else {
		el = doc.createElement( this.tagName );
		el.setAttribute( 'typeof', 'mw:Extension/' + this.getExtensionName( dataElement ) );
		el.setAttribute( 'data-mw', JSON.stringify( dataElement.attributes.mw ) );
		return [ el ];
	}
};

ve.dm.MWExtensionNode.static.getHashObject = function ( dataElement ) {
	return {
		type: dataElement.type,
		mw: dataElement.attributes.mw
	};
};

/**
 * Get the extension's name
 *
 * Static version for toDomElements
 *
 * @static
 * @param {Object} dataElement Data element
 * @returns {string} Extension name
 */
ve.dm.MWExtensionNode.static.getExtensionName = function () {
	return this.extensionName;
};

/* Methods */

/**
 * Get the extension's name
 * @method
 * @returns {string} Extension name
 */
ve.dm.MWExtensionNode.prototype.getExtensionName = function () {
	return this.constructor.static.getExtensionName( this.element );
};
