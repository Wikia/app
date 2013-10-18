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

ve.ui.ToolFactory.prototype.getTools = function ( include, exclude, promote, demote ) {
	var i, len, included, promoted, demoted,
		auto = [],
		used = {};

	// Collect included and not excluded tools
	included = ve.simpleArrayDifference( this.extract( include ), this.extract( exclude ) );

	// Promotion
	promoted = this.extract( promote, used );
	demoted = this.extract( demote, used );

	// Auto
	for ( i = 0, len = included.length; i < len; i++ ) {
		if ( !used[included[i]] ) {
			auto.push( included[i] );
		}
	}

	return promoted.concat( auto ).concat( demoted );
};

/**
 * Get a flat list of names from a list of names or groups.
 *
 * Tools can be specified in the following ways:
 *  - A specific tool: `{ 'name': 'tool-name' }` or `'tool-name'`
 *  - All tools in a group: `{ 'group': 'group-name' }`
 *  - All tools: `'*'`
 *
 * @private
 * @param {Array|string} collection List of tools
 * @param {Object} [used] Object with names that should be skipped as properties; extracted
 *   names will be added as properties
 * @return {string[]} List of extracted names
 */
ve.ui.ToolFactory.prototype.extract = function ( collection, used ) {
	var i, len, item, name, tool,
		names = [];

	if ( collection === '*' ) {
		for ( name in this.registry ) {
			tool = this.registry[name];
			if (
				// Only add tools by group name when auto-add is enabled
				tool.static.autoAdd &&
				// Exclude already used tools
				( !used || !used[name] )
			) {
				names.push( name );
				if ( used ) {
					used[name] = true;
				}
			}
		}
	} else if ( ve.isArray( collection ) ) {
		for ( i = 0, len = collection.length; i < len; i++ ) {
			item = collection[i];
			// Allow plain strings as shorthand for named tools
			if ( typeof item === 'string' ) {
				item = { 'name': item };
			}
			if ( ve.isPlainObject( item ) ) {
				if ( item.group ) {
					for ( name in this.registry ) {
						tool = this.registry[name];
						if (
							// Include tools with matching group
							tool.static.group === item.group &&
							// Only add tools by group name when auto-add is enabled
							tool.static.autoAdd &&
							// Exclude already used tools
							( !used || !used[name] )
						) {
							names.push( name );
							if ( used ) {
								used[name] = true;
							}
						}
					}
				}
				// Include tools with matching name and exclude already used tools
				else if ( item.name && ( !used || !used[item.name] ) ) {
					names.push( item.name );
					if ( used ) {
						used[item.name] = true;
					}
				}
			}
		}
	}
	return names;
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
