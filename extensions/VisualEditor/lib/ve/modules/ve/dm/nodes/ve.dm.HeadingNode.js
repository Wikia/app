/*!
 * VisualEditor DataModel HeadingNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel heading node.
 *
 * @class
 * @extends ve.dm.BranchNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.HeadingNode = function VeDmHeadingNode() {
	// Parent constructor
	ve.dm.BranchNode.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.HeadingNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.HeadingNode.static.name = 'heading';

ve.dm.HeadingNode.static.canContainContent = true;

ve.dm.HeadingNode.static.defaultAttributes = {
	'level': 1
};

ve.dm.HeadingNode.static.matchTagNames = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ];

ve.dm.HeadingNode.static.toDataElement = function ( domElements ) {
	var levels = {
			'h1': 1,
			'h2': 2,
			'h3': 3,
			'h4': 4,
			'h5': 5,
			'h6': 6
		},
		level = levels[domElements[0].nodeName.toLowerCase()];
	return { 'type': this.name, 'attributes': { 'level': level } };
};

ve.dm.HeadingNode.static.toDomElements = function ( dataElement, doc ) {
	var level = dataElement.attributes && dataElement.attributes.level || 1;
	return [ doc.createElement( 'h' + level ) ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.HeadingNode );
