/*!
 * VisualEditor DataModel MWSyntaxHighlightNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki syntaxhighlight node.
 *
 * @class
 * @extends ve.dm.LeafNode
 * @constructor
 * @param {number} [length] Length of content data in document; ignored and overridden to 0
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.MWSyntaxHighlightNode = function VeDmMWSyntaxHighlightNode( length, element ) {
	// Parent constructor
	ve.dm.LeafNode.call( this, 0, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.MWSyntaxHighlightNode, ve.dm.LeafNode );

/* Static members */

ve.dm.MWSyntaxHighlightNode.static.name = 'mwSyntaxHighlight';

ve.dm.MWSyntaxHighlightNode.static.matchTagNames = null;

ve.dm.MWSyntaxHighlightNode.static.matchRdfaTypes = [ 'mw:Extension/syntaxhighlight' ];

ve.dm.MWSyntaxHighlightNode.static.isContent = true;

ve.dm.MWSyntaxHighlightNode.static.enableAboutGrouping = true;

/* Methods */

/**
 * DOM to model
 *
 * @method
 * @param {Array} domElements DOM elements
 * @returns {Object} Data model
 */

ve.dm.MWSyntaxHighlightNode.static.toDataElement = function ( domElements ) {
	var mw = JSON.parse( domElements[0].getAttribute( 'data-mw' ) || '{}' ),
		lang = mw.attrs.lang,
		body = mw.body ? mw.body.extsrc : '',
		dataElement = {
			'type': this.name,
			'attributes': {
				'mw': mw,
				'lang' : lang,
				'body' : body
			},
			// DOM cache for clean round-tripping
			'span': domElements[1],
			'div': domElements[0]
		};
	return dataElement;
};

/**
 * Model to DOM
 *
 * @method
 * @param {Object} dataElement Data model
 * @returns {Array} DOM elements
 */

ve.dm.MWSyntaxHighlightNode.static.toDomElements = function ( dataElement ) {
	var mwAttr,
		div = dataElement.div,
		span = dataElement.span;
	mwAttr = ( dataElement.attributes && dataElement.attributes.mw ) || {};
	// Update node content
	ve.setProp( mwAttr, 'body', 'extsrc', dataElement.attributes.body );
	ve.setProp( mwAttr, 'attrs', 'lang', dataElement.attributes.lang );
	div.setAttribute( 'data-mw', JSON.stringify( mwAttr ) );
	return [ div, span ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWSyntaxHighlightNode );
