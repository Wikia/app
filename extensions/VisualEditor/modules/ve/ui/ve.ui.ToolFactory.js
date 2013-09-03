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

	// Properties
	this.tools = {};
};

/* Inheritance */

ve.inheritClass( ve.ui.ToolFactory, ve.Factory );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.ToolFactory.prototype.register = function ( name, constructor ) {
	var parts = name.split( '/' ),
		baseName = parts.slice( 0, 2 ).join( '/' );

	if (
		// First entry
		!this.tools[baseName] ||
		// Overriding entry
		constructor.prototype instanceof this.registry[this.tools[baseName].name]
	) {
		this.tools[baseName] = {
			'name': name,
			'type': parts[0],
			'id': parts[1],
			'ext': parts[2]
		};
	}

	ve.Factory.prototype.register.call( this, name, constructor );
};

ve.ui.ToolFactory.prototype.getTools = function ( include, exclude, promote, demote ) {
	var i, len, tool, parts, baseName,
		tools = {},
		promoted = [],
		demoted = [],
		auto = [];

	// Collect included tools
	for ( i = 0, len = include.length; i < len; i++ ) {
		parts = include[i].split( '/' );
		for ( baseName in this.tools ) {
			tool = this.tools[baseName];
			if (
				// Types match
				parts[0] === tool.type &&
				// Either no ID was specified and tool can be automatically added or IDs match
				( ( !parts[1] && this.registry[tool.name].static.autoAdd ) || parts[1] === tool.id )
			) {
				tools[baseName] = tool;
			}

		}
	}

	// Remove excluded tools
	for ( i = 0, len = exclude.length; i < len; i++ ) {
		parts = exclude[i].split( '/' );
		for ( baseName in tools ) {
			tool = tools[baseName];
			if (
				// Types match
				parts[0] === tool.type &&
				// Either no ID was specified or IDs match
				( !parts[1] || parts[1] === tool.id )
			) {
				delete tools[baseName];
			}
		}
	}

	// Promotion
	for ( i = 0, len = promote.length; i < len; i++ ) {
		parts = promote[i].split( '/' );
		for ( baseName in tools ) {
			tool = tools[baseName];
			if (
				// Types match
				parts[0] === tool.type &&
				// Either no ID was specified or IDs match
				( !parts[1] || parts[1] === tool.id )
			) {
				promoted.push( tool.name );
				delete tools[baseName];
			}
		}
	}

	// Demotion
	for ( i = 0, len = demote.length; i < len; i++ ) {
		parts = demote[i].split( '/' );
		for ( baseName in tools ) {
			tool = tools[baseName];
			if (
				// Types match
				parts[0] === tool.type &&
				// Either no ID was specified or IDs match
				( !parts[1] || parts[1] === tool.id )
			) {
				demoted.push( tool.name );
				delete tools[baseName];
			}
		}
	}

	for ( baseName in tools ) {
		auto.push( tools[baseName].name );
	}

	return promoted.concat( auto.sort() ).concat( demoted );
};

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
