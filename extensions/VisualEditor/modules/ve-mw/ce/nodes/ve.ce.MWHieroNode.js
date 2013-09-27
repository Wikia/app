/*!
 * VisualEditor ContentEditable MWHieroNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki hieroglyphics node.
 *
 * @class
 * @extends ve.ce.MWExtensionNode
 *
 * @constructor
 * @param {ve.dm.MWHieroNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWHieroNode = function VeCeMWHieroNode( model, config ) {
	// Parent constructor
	ve.ce.MWExtensionNode.call( this, model, config );

	// DOM changes
	this.$.addClass( 've-ce-mwHieroNode' );
};

/* Inheritance */

ve.inheritClass( ve.ce.MWHieroNode, ve.ce.MWExtensionNode );

/* Static Properties */

ve.ce.MWHieroNode.static.name = 'mwHiero';

ve.ce.MWHieroNode.static.tagName = 'div';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWHieroNode );
