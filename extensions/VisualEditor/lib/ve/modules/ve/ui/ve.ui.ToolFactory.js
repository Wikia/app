/*!
 * VisualEditor UserInterface ToolFactory class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Factory for tools.
 *
 * @class
 * @extends OO.ui.ToolFactory
 *
 * @constructor
 */
ve.ui.ToolFactory = function OoUiToolFactory() {
	// Parent constructor
	OO.ui.ToolFactory.call( this );
};

/* Inheritance */

OO.inheritClass( ve.ui.ToolFactory, OO.ui.ToolFactory );

/* Methods */

/**
 * Get a list of tools from a set of annotations.
 *
 * The lowest compatible item in each inheritance chain will be used.
 *
 * @method
 * @param {ve.dm.AnnotationSet} annotations Annotations to be inspected
 * @returns {string[]} Symbolic names of tools that can be used to inspect annotations
 */
ve.ui.ToolFactory.prototype.getToolsForAnnotations = function ( annotations ) {
	if ( annotations.isEmpty() ) {
		return [];
	}

	var i, len, name,
		arr = annotations.get(),
		tools = [],
		matches = [],
		names = {};

	for ( i = 0, len = arr.length; i < len; i++ ) {
		tools = tools.concat( this.collectCompatibleTools( arr[i] ) );
	}
	for ( i = 0, len = tools.length; i < len; i++ ) {
		name = tools[i].static.name;
		if ( !names[name] ) {
			matches.push( name);
		}
		names[name] = true;
	}

	return matches;
};

/**
 * Get a tool for a node.
 *
 * The lowest compatible item in each inheritance chain will be used.
 *
 * @method
 * @param {ve.dm.Node} node Node to be edited
 * @returns {string[]} Symbolic name of tool that can be used to edit node
 */
ve.ui.ToolFactory.prototype.getToolsForNode = function ( node ) {
	if ( !node.isInspectable() ) {
		return [];
	}

	var i, len, tools, primary,
		matches = [],
		primaryCommandName = ve.ce.nodeFactory.getNodePrimaryCommandName( node.getType() );

	tools = this.collectCompatibleTools( node );
	for ( i = 0, len = tools.length; i < len; i++ ) {
		if ( tools[i].static.getCommandName() === primaryCommandName ) {
			primary = tools[i].static.name;
		} else {
			matches.push( tools[i].static.name );
		}
	}
	if ( primary ) {
		matches.unshift( primary );
	}

	return matches;
};

/**
 * Collect the most specific compatible tools for an annotation or node.
 *
 * @param {ve.dm.Annotation|ve.dm.Node} subject Annotation or node
 * @returns {Function[]} List of compatible tools
 */
ve.ui.ToolFactory.prototype.collectCompatibleTools = function ( subject ) {
	var i, len, name, candidate, add,
		candidates = [];

	for ( name in this.registry ) {
		candidate = this.registry[name];
		if ( candidate.static.isCompatibleWith( subject ) ) {
			add = true;
			for ( i = 0, len = candidates.length; i < len; i++ ) {
				if ( candidate.prototype instanceof candidates[i] ) {
					candidates.splice( i, 1, candidate );
					add = false;
					break;
				} else if ( candidates[i].prototype instanceof candidate ) {
					add = false;
					break;
				}
			}
			if ( add ) {
				candidates.push( candidate );
			}
		}
	}

	return candidates;
};

/* Initialization */

ve.ui.toolFactory = new ve.ui.ToolFactory();

ve.ui.toolGroupFactory = new OO.ui.ToolGroupFactory();
