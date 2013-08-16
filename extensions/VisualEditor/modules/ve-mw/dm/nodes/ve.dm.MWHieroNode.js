/*!
 * VisualEditor DataModel MWHieroNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki hieroglyphics node.
 *
 * @class
 * @extends ve.dm.MWExtensionNode
 *
 * @constructor
 */
ve.dm.MWHieroNode = function VeDmMWHieroNode( length, element ) {
	// Parent constructor
	ve.dm.MWExtensionNode.call( this, 0, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.MWHieroNode, ve.dm.MWExtensionNode );

/* Static members */

ve.dm.MWHieroNode.static.name = 'mwHiero';

ve.dm.MWHieroNode.static.tagName = 'table';

ve.dm.MWHieroNode.static.extensionName = 'hiero';

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWHieroNode );
