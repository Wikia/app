/*!
 * VisualEditor DataModel TableSelectionNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel table section node.
 *
 * @class
 * @extends ve.dm.BranchNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.TableSectionNode = function VeDmTableSectionNode() {
	// Parent constructor
	ve.dm.BranchNode.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.TableSectionNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.TableSectionNode.static.name = 'tableSection';

ve.dm.TableSectionNode.static.childNodeTypes = [ 'tableRow' ];

ve.dm.TableSectionNode.static.parentNodeTypes = [ 'table' ];

ve.dm.TableSectionNode.static.defaultAttributes = {
	'style': 'body'
};

ve.dm.TableSectionNode.static.matchTagNames = [ 'thead', 'tbody', 'tfoot' ];

ve.dm.TableSectionNode.static.toDataElement = function ( domElements ) {
	var styles = {
			'thead': 'header',
			'tbody': 'body',
			'tfoot': 'footer'
		},
		style = styles[domElements[0].nodeName.toLowerCase()] || 'body';
	return { 'type': this.name, 'attributes': { 'style': style } };
};

ve.dm.TableSectionNode.static.toDomElements = function ( dataElement, doc ) {
	var tags = {
			'header': 'thead',
			'body': 'tbody',
			'footer': 'tfoot'
		},
		tag = tags[dataElement.attributes && dataElement.attributes.style || 'body'];
	return [ doc.createElement( tag ) ];
};
/* Registration */

ve.dm.modelRegistry.register( ve.dm.TableSectionNode );
