/*!
 * VisualEditor DataModel MWAlienExtensionNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki alien extension node.
 *
 * @class
 * @extends ve.dm.MWBlockExtensionNode
 *
 * @constructor
 */
ve.dm.MWAlienExtensionNode = function VeDmMWAlienExtensionNode() {
	// Parent constructor
	ve.dm.MWBlockExtensionNode.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWAlienExtensionNode, ve.dm.MWBlockExtensionNode );

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
