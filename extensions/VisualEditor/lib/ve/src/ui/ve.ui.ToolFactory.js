/*!
 * VisualEditor UserInterface ToolFactory class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
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
 * Get a list of tools for a fragment.
 *
 * The lowest compatible item in each inheritance chain will be used.
 *
 * @method
 * @param {ve.dm.SurfaceFragment} fragment Fragment to find compatible tools for
 * @returns {Object[]} List of objects containing `tool` and `model` properties, representing each
 *   compatible tool and the node or annotation it is compatible with
 */
ve.ui.ToolFactory.prototype.getToolsForFragment = function ( fragment ) {
	var i, iLen, j, jLen, name, tools, model,
		models = fragment.getSelectedModels(),
		names = {},
		matches = [];

	// Collect tool/model pairs, unique by tool name
	for ( i = 0, iLen = models.length; i < iLen; i++ ) {
		model = models[i];
		tools = this.collectCompatibleTools( model );
		for ( j = 0, jLen = tools.length; j < jLen; j++ ) {
			name = tools[j].static.name;
			if ( !names[name] ) {
				matches.push( { tool: tools[j], model: model } );
			}
			names[name] = true;
		}
	}

	return matches;
};

/**
 * Collect the most specific compatible tools for an annotation or node.
 *
 * @param {ve.dm.Annotation|ve.dm.Node} model Annotation or node
 * @returns {Function[]} List of compatible tools
 */
ve.ui.ToolFactory.prototype.collectCompatibleTools = function ( model ) {
	var i, len, name, candidate, add,
		candidates = [];

	for ( name in this.registry ) {
		candidate = this.registry[name];
		if ( candidate.static.isCompatibleWith( model ) ) {
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
