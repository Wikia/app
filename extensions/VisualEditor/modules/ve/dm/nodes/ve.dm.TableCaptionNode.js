/*!
 * VisualEditor DataModel TableCaptionNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel table caption node.
 *
 * @class
 * @extends ve.dm.BranchNode
 * @constructor
 * @param {ve.dm.BranchNode[]} [children] Child nodes to attach
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.TableCaptionNode = function VeDmTableCaptionNode( children, element ) {
	// Parent constructor
	ve.dm.BranchNode.call( this, children, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.TableCaptionNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.TableCaptionNode.static.name = 'tableCaption';

ve.dm.TableCaptionNode.static.parentNodeTypes = [ 'table' ];

ve.dm.TableCaptionNode.static.matchTagNames = [ 'caption' ];

ve.dm.TableCaptionNode.static.toDataElement = function () {
	return { 'type': 'tableCaption' };
};

ve.dm.TableCaptionNode.static.toDomElements = function ( dataElement, doc ) {
	return [ doc.createElement( 'caption' ) ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.TableCaptionNode );
