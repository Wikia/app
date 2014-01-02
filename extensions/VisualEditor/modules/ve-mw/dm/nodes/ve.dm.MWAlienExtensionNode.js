/*!
 * VisualEditor DataModel MWAlienExtensionNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki math node.
 *
 * @class
 * @extends ve.dm.MWExtensionNode
 *
 * @constructor
 */
ve.dm.MWAlienExtensionNode = function VeDmMWAlienExtensionNode( length, element ) {
	// Parent constructor
	ve.dm.MWExtensionNode.call( this, 0, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.MWAlienExtensionNode, ve.dm.MWExtensionNode );

/* Static members */

ve.dm.MWAlienExtensionNode.static.name = 'mwAlienExtension';

ve.dm.MWAlienExtensionNode.static.getMatchRdfaTypes = function () {
	return [
		/^mw:Extension/
	];
};

ve.dm.MWAlienExtensionNode.static.tagName = 'div';

/** */
ve.dm.MWAlienExtensionNode.static.getExtensionName = function ( dataElement ) {
	return dataElement.attributes.mw.name;
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWAlienExtensionNode );
