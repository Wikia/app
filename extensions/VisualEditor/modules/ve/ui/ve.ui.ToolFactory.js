/*!
 * VisualEditor UserInterface ToolFactory class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface tool factory.
 *
 * @class
 * @extends ve.Factory
 * @constructor
 */
ve.ui.ToolFactory = function VeUiToolFactory() {
	// Parent constructor
	ve.Factory.call( this );
};

/* Inheritance */

ve.inheritClass( ve.ui.ToolFactory, ve.Factory );

/* Methods */

/**
 * Get a list of tools from a set of annotations.
 *
 * The most specific tool will be chosen based on inheritance - mostly. The order of being added
 * also matters if the candidate classes aren't all in the same inheritance chain, and since object
 * properties aren't necessarily ordered it's not predictable what the effect of ordering will be.
 *
 * TODO: Add tracking of order of registration using an array and prioritize the most recently
 * registered candidate.
 *
 * @method
 * @param {ve.dm.AnnotationSet} annotations Annotations to be inspected
 * @returns {string[]} Symbolic names of tools that can be used to inspect annotations
 */
ve.ui.ToolFactory.prototype.getToolsForAnnotations = function ( annotations ) {
	if ( annotations.isEmpty() ) {
		return [];
	}

	var i, len, annotation, name, tool, candidateTool, candidateToolName,
		arr = annotations.get(),
		matches = [];

	for ( i = 0, len = arr.length; i < len; i++ ) {
		annotation = arr[i];
		candidateTool = null;
		for ( name in this.registry ) {
			tool = this.registry[name];
			if ( tool.static.canEditModel( annotation ) ) {
				if ( !candidateTool || tool.prototype instanceof candidateTool ) {
					candidateTool = tool;
					candidateToolName = name;
				}
			}
		}
		if ( candidateTool ) {
			matches.push( candidateToolName );
		}
	}
	return matches;
};

/**
 * Get a tool for a node.
 *
 * The most specific tool will be chosen based on inheritance - mostly. The order of being added
 * also matters if the candidate classes aren't all in the same inheritance chain, and since object
 * properties aren't necessarily ordered it's not predictable what the effect of ordering will be.
 *
 * TODO: Add tracking of order of registration using an array and prioritize the most recently
 * registered candidate.
 *
 * @method
 * @param {ve.dm.Node} node Node to be edited
 * @returns {string|undefined} Symbolic name of tool that can be used to edit node
 */
ve.ui.ToolFactory.prototype.getToolForNode = function ( node ) {
	var name, tool, candidateTool, candidateToolName;

	if ( !node.isInspectable() ) {
		return undefined;
	}

	for ( name in this.registry ) {
		tool = this.registry[name];
		if ( tool.static.canEditModel( node ) ) {
			if ( !candidateTool || tool.prototype instanceof candidateTool ) {
				candidateTool = tool;
				candidateToolName = name;
			}
		}
	}
	return candidateToolName;
};

/* Initialization */

ve.ui.toolFactory = new ve.ui.ToolFactory();
