/*!
 * VisualEditor DataModel WikiaBlockVideoNode class.
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel Wikia video node.
 *
 * @class
 * @extends ve.dm.WikiaBlockMediaNode
 * @constructor
 * @param {number} [length] Length of content data in document
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.WikiaBlockVideoNode = function VeDmWikiaBlockVideoNode( length, element ) {
	ve.dm.WikiaBlockMediaNode.call( this, 0, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.WikiaBlockVideoNode, ve.dm.WikiaBlockMediaNode );

/* Static Properties */

ve.dm.WikiaBlockVideoNode.static.name = 'wikiaBlockVideo';

ve.dm.WikiaBlockVideoNode.static.rdfaToType = {
	'mw:Video/Thumb': 'thumb',
	'mw:Video/Frame': 'frame',
	'mw:Video/Frameless': 'frameless',
	'mw:Video': 'none'
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaBlockVideoNode );
