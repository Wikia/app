/*!
 * VisualEditor ContentEditable MWHeadingNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MW heading node.
 *
 * @class
 * @extends ve.ce.HeadingNode
 * @constructor
 * @param {ve.dm.MWHeadingNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWHeadingNode = function VeCeMWHeadingNode( model, config ) {
	// Parent constructor
	ve.ce.HeadingNode.call( this, model, config );
};

/* Inheritance */

ve.inheritClass( ve.ce.MWHeadingNode, ve.ce.HeadingNode );

/* Static Properties */

ve.ce.MWHeadingNode.static.name = 'mwHeading';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWHeadingNode );
