/*!
 * VisualEditor ModelRegistry class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */
( function ( ve ) {

/**
 * Registry for models.
 *
 * To register a new model type, call ve.dm.modelRegistry.register()
 *
 * @extends ve.Registry
 * @constructor
 */
ve.dm.ModelRegistry = function VeDmModelRegistry() {
	// Parent constructor
	ve.Registry.call( this );
	// Map of func presence and tag names to model names
	// [ { tagName: [modelNamesWithoutFunc] }, { tagName: [modelNamesWithFunc] } ]
	this.modelsByTag = [ {}, {} ];
	// Map of func presence and rdfaTypes to model names; only rdfaTypes specified as strings are in here
	// { matchFunctionPresence: { rdfaType: { tagName: [modelNames] } } }
	// [ { rdfaType: { tagName: [modelNamesWithoutFunc] } }, { rdfaType: { tagName: [modelNamesWithFunc] } ]
	this.modelsByTypeAndTag = [];
	// Map of func presence to array of model names with rdfaType regexps
	// [ [modelNamesWithoutFunc], [modelNamesWithFunc] ]
	this.modelsWithTypeRegExps = [ [], [] ];
	// Map tracking registration order
	// { nameA: 0, nameB: 1, ... }
	this.registrationOrder = {};
	this.nextNumber = 0;
	this.extSpecificTypes = [];
};

/* Inheritance */

ve.inheritClass( ve.dm.ModelRegistry, ve.Registry );

/* Private helper functions */

/**
 * Helper function for register(). Adds a value to the front of an array in a nested object.
 * Objects and arrays are created if needed. You can specify one or more keys and a value.
 *
 * Specifically:
 * addType( obj, keyA, value ) does obj[keyA].unshift( value );
 * addType( obj, keyA, keyB, value ) does obj[keyA][keyB].unshift( value );
 * etc.
 *
 * @param {Object} obj Object to add to
 */
function addType( obj /*, ...*/ ) {
	var i, len, o = obj;
	for ( i = 1, len = arguments.length - 2; i < len; i++ ) {
		if ( o[arguments[i]] === undefined ) {
			o[arguments[i]] = {};
		}
		o = o[arguments[i]];
	}
	if ( o[arguments[i]] === undefined ) {
		o[arguments[i]] = [];
	}
	o[arguments[i]].unshift( arguments[i + 1] );
}

/* Public methods */

/**
 * Register a model type.
 * @param {string} name Symbolic name for the model
 * @param {ve.dm.Model} constructor Subclass of ve.dm.Model
 * @throws Models must be subclasses of ve.dm.Model
 * @throws No factory associated with this ve.dm.Model subclass
 */
ve.dm.ModelRegistry.prototype.register = function ( constructor ) {
	var i, j, tags, types, name = constructor.static && constructor.static.name;
	if ( typeof name !== 'string' || name === '' ) {
		throw new Error( 'Model names must be strings and must not be empty' );
	}
	if ( !( constructor.prototype instanceof ve.dm.Model ) ) {
		throw new Error( 'Models must be subclasses of ve.dm.Model' );
	}

	// Register the model with the right factory
	if ( constructor.prototype instanceof ve.dm.Annotation ) {
		ve.dm.annotationFactory.register( constructor );
	} else if ( constructor.prototype instanceof ve.dm.Node ) {
		ve.dm.nodeFactory.register( constructor );
	} else if ( constructor.prototype instanceof ve.dm.MetaItem ) {
		ve.dm.metaItemFactory.register( constructor );
	} else {
		throw new Error( 'No factory associated with this ve.dm.Model subclass' );
	}
	// Parent method
	ve.Registry.prototype.register.call( this, name, constructor );

	tags = constructor.static.matchTagNames === null ?
		[ '' ] :
		constructor.static.matchTagNames;
	types = constructor.static.getMatchRdfaTypes() === null ?
		[ '' ] :
		constructor.static.getMatchRdfaTypes();

	for ( i = 0; i < tags.length; i++ ) {
		// +!!foo is a shorter equivalent of Number( Boolean( foo ) ) or foo ? 1 : 0
		addType( this.modelsByTag, +!!constructor.static.matchFunction,
			tags[i], name
		);
	}
	for ( i = 0; i < types.length; i++ ) {
		if ( types[i] instanceof RegExp ) {
			addType( this.modelsWithTypeRegExps, +!!constructor.static.matchFunction, name );
		} else {
			for ( j = 0; j < tags.length; j++ ) {
				addType( this.modelsByTypeAndTag,
					+!!constructor.static.matchFunction, types[i], tags[j], name
				);
			}
		}
	}

	this.registrationOrder[name] = this.nextNumber++;
};

/**
 * Register an extension-specific RDFa type or set of types. Unrecognized extension-specific types
 * skip non-type matches and are alienated.
 *
 * If a DOM node has RDFa types that are extension-specific, any matches that do not involve one of
 * those extension-specific types will be ignored. This means that if 'bar' is an
 * extension-specific type, and there are no models specifying 'bar' in their .matchRdfaTypes, then
 * `<foo typeof="bar baz">` will not match anything, not even a model with .matchTagNames=['foo']
 * or one with .matchRdfaTypes=['baz'] .
 *
 * @param {string|RegExp} type Type, or regex matching types, to designate as extension-specifics
 */
ve.dm.ModelRegistry.prototype.registerExtensionSpecificType = function ( type ) {
	this.extSpecificTypes.push( type );
};

/**
 * Checks whether a given type matches one of the registered extension-specific types.
 * @param {string} type Type to check
 * @returns {boolean} Whether type is extension-specific
 */
ve.dm.ModelRegistry.prototype.isExtensionSpecificType = function ( type ) {
	var i, len, t;
	for ( i = 0, len = this.extSpecificTypes.length; i < len; i++ ) {
		t = this.extSpecificTypes[i];
		if ( t === type || ( t instanceof RegExp && type.match( t ) ) ) {
			return true;
		}
	}
	return false;
};

/**
 * Determine which model best matches the given element
 *
 * Model matching works as follows:
 * Get all models whose tag and rdfaType rules match
 * Rank them in order of specificity:
 * * tag, rdfaType and func specified
 * * rdfaType and func specified
 * * tag and func specified
 * * func specified
 * * tag and rdfaType specified
 * * rdfaType specified
 * * tag specified
 * * nothing specified
 * If there are multiple candidates with the same specificity, they are ranked in reverse order of
 * registration (i.e. if A was registered before B, B will rank above A).
 * The highest-ranking model whose test function does not return false, wins.
 *
 * @param {HTMLElement} element Element to match
 * @param {boolean} [forceAboutGrouping] If true, only match models with about grouping enabled
 * @param {string[]} [excludeTypes] Model names to exclude when matching
 * @returns {string|null} Model type, or null if none found
 */
ve.dm.ModelRegistry.prototype.matchElement = function ( element, forceAboutGrouping, excludeTypes ) {
	var i, name, model, matches, winner, types, elementExtSpecificTypes, matchTypes,
		hasExtSpecificTypes,
		tag = element.nodeName.toLowerCase(),
		reg = this;

	function byRegistrationOrderDesc( a, b ) {
		return reg.registrationOrder[b] - reg.registrationOrder[a];
	}

	function matchTypeRegExps( type, tag, withFunc ) {
		var i, j, types, matches = [], models = reg.modelsWithTypeRegExps[+!!withFunc];
		for ( i = 0; i < models.length; i++ ) {
			if ( excludeTypes && ve.indexOf( models[i], excludeTypes ) !== -1 ) {
				continue;
			}
			types = reg.registry[models[i]].static.getMatchRdfaTypes();
			for ( j = 0; j < types.length; j++ ) {
				if (
					types[j] instanceof RegExp &&
					type.match( types[j] ) &&
					(
						( tag === '' && reg.registry[models[i]].static.matchTagNames === null ) ||
						ve.indexOf( tag, reg.registry[models[i]].static.matchTagNames ) !== -1
					)
				) {
					matches.push( models[i] );
				}
			}
		}
		return matches;
	}

	function matchesAllTypes( types, name ) {
		var i, j, haveMatch, matchTypes = reg.registry[name].static.getMatchRdfaTypes();
		for ( i = 0; i < types.length; i++ ) {
			haveMatch = false;
			for ( j = 0; j < matchTypes.length; j++ ) {
				if ( matchTypes[j] instanceof RegExp ) {
					if ( types[i].match( matchTypes[j] ) ) {
						haveMatch = true;
						break;
					}
				} else {
					if ( types[i] === matchTypes[j] ) {
						haveMatch = true;
						break;
					}
				}
			}
			if ( !haveMatch ) {
				return false;
			}
		}
		return true;
	}

	function matchWithFunc( types, tag, mustMatchAll ) {
		var i, queue = [], queue2 = [];
		for ( i = 0; i < types.length; i++ ) {
			// Queue string matches and regexp matches separately
			queue = queue.concat( ve.getProp( reg.modelsByTypeAndTag, 1, types[i], tag ) || [] );
			if ( excludeTypes ) {
				queue = ve.simpleArrayDifference( queue, excludeTypes );
			}
			queue2 = queue2.concat( matchTypeRegExps( types[i], tag, true ) );
		}
		if ( mustMatchAll ) {
			// Filter out matches that don't match all types
			queue = queue.filter( function ( name ) {
				return matchesAllTypes( types, name );
			} );
			queue2 = queue2.filter( function ( name ) {
				return matchesAllTypes( types, name );
			} );
		}
		if ( forceAboutGrouping ) {
			// Filter out matches that don't support about grouping
			queue = queue.filter( function ( name ) {
				return reg.registry[name].static.enableAboutGrouping;
			} );
			queue2 = queue2.filter( function ( name ) {
				return reg.registry[name].static.enableAboutGrouping;
			} );
		}
		// Try string matches first, then regexp matches
		queue.sort( byRegistrationOrderDesc );
		queue2.sort( byRegistrationOrderDesc );
		queue = queue.concat( queue2 );
		for ( i = 0; i < queue.length; i++ ) {
			if ( reg.registry[queue[i]].static.matchFunction( element ) ) {
				return queue[i];
			}
		}
		return null;
	}

	function matchWithoutFunc( types, tag, mustMatchAll ) {
		var i, queue = [], queue2 = [], winningName = null;
		for ( i = 0; i < types.length; i++ ) {
			// Queue string and regexp matches separately
			queue = queue.concat( ve.getProp( reg.modelsByTypeAndTag, 0, types[i], tag ) || [] );
			if ( excludeTypes ) {
				queue = ve.simpleArrayDifference( queue, excludeTypes );
			}
			queue2 = queue2.concat( matchTypeRegExps( types[i], tag, false ) );
		}
		if ( mustMatchAll ) {
			// Filter out matches that don't match all types
			queue = queue.filter( function ( name ) {
				return matchesAllTypes( types, name );
			} );
			queue2 = queue2.filter( function ( name ) {
				return matchesAllTypes( types, name );
			} );
		}
		if ( forceAboutGrouping ) {
			// Filter out matches that don't support about grouping
			queue = queue.filter( function ( name ) {
				return reg.registry[name].static.enableAboutGrouping;
			} );
			queue2 = queue2.filter( function ( name ) {
				return reg.registry[name].static.enableAboutGrouping;
			} );
		}
		// Only try regexp matches if there are no string matches
		queue = queue.length > 0 ? queue : queue2;
		for ( i = 0; i < queue.length; i++ ) {
			if (
				winningName === null ||
				reg.registrationOrder[winningName] < reg.registrationOrder[queue[i]]
			) {
				winningName = queue[i];
			}
		}
		return winningName;
	}

	types = [];
	if ( element.getAttribute( 'rel' ) ) {
		types = types.concat( element.getAttribute( 'rel' ).split( ' ' ) );
	}
	if ( element.getAttribute( 'typeof' ) ) {
		types = types.concat( element.getAttribute( 'typeof' ).split( ' ' ) );
	}
	if ( element.getAttribute( 'property' ) ) {
		types = types.concat( element.getAttribute( 'property' ).split( ' ' ) );
	}
	elementExtSpecificTypes = types.filter( ve.bind( this.isExtensionSpecificType, this ) );
	hasExtSpecificTypes = elementExtSpecificTypes.length !== 0;
	// If the element has extension-specific types, only use those for matching and ignore its
	// other types. If it has no extension-specific types, use all of its types.
	matchTypes = hasExtSpecificTypes ? elementExtSpecificTypes : types;
	if ( types.length ) {
		// func+tag+type match
		winner = matchWithFunc( matchTypes, tag, hasExtSpecificTypes );
		if ( winner !== null ) {
			return winner;
		}

		// func+type match
		// Only look at rules with no tag specified; if a rule does specify a tag, we've
		// either already processed it above, or the tag doesn't match
		winner = matchWithFunc( matchTypes, '', hasExtSpecificTypes );
		if ( winner !== null ) {
			return winner;
		}
	}

	// Do not check for type-less matches if the element has extension-specific types
	if ( !hasExtSpecificTypes ) {
		// func+tag match
		matches = ve.getProp( this.modelsByTag, 1, tag ) || [];
		// No need to sort because individual arrays in modelsByTag are already sorted
		// correctly
		for ( i = 0; i < matches.length; i++ ) {
			name = matches[i];
			model = this.registry[name];
			// Only process this one if it doesn't specify types
			// If it does specify types, then we've either already processed it in the
			// func+tag+type step above, or its type rule doesn't match
			if ( model.static.getMatchRdfaTypes() === null && model.static.matchFunction( element ) ) {
				return matches[i];
			}
		}

		// func only
		// We only need to get the [''][''] array because the other arrays were either
		// already processed during the steps above, or have a type or tag rule that doesn't
		// match this element.
		// No need to sort because individual arrays in modelsByTypeAndTag are already sorted
		// correctly
		matches = ve.getProp( this.modelsByTypeAndTag, 1, '', '' ) || [];
		for ( i = 0; i < matches.length; i++ ) {
			if ( this.registry[matches[i]].static.matchFunction( element ) ) {
				return matches[i];
			}
		}
	}

	// tag+type
	winner = matchWithoutFunc( matchTypes, tag, hasExtSpecificTypes );
	if ( winner !== null ) {
		return winner;
	}

	// type only
	// Only look at rules with no tag specified; if a rule does specify a tag, we've
	// either already processed it above, or the tag doesn't match
	winner = matchWithoutFunc( matchTypes, '', hasExtSpecificTypes );
	if ( winner !== null ) {
		return winner;
	}

	if ( elementExtSpecificTypes.length > 0 ) {
		// There are only type-less matches beyond this point, so if we have any
		// extension-specific types, we give up now.
		return null;
	}

	// tag only
	matches = ve.getProp( this.modelsByTag, 0, tag ) || [];
	// No need to track winningName because the individual arrays in modelsByTag are
	// already sorted correctly
	for ( i = 0; i < matches.length; i++ ) {
		name = matches[i];
		model = this.registry[name];
		// Only process this one if it doesn't specify types
		// If it does specify types, then we've either already processed it in the
		// tag+type step above, or its type rule doesn't match
		if ( model.static.getMatchRdfaTypes() === null ) {
			return matches[i];
		}
	}

	// Rules with no type or tag specified
	// These are the only rules that can still qualify at this point, the others we've either
	// already processed or have a type or tag rule that disqualifies them
	matches = ve.getProp( this.modelsByTypeAndTag, 0, '', '' ) || [];
	if ( matches.length > 0 ) {
		return matches[0];
	}

	// We didn't find anything, give up
	return null;
};

/* Initialization */

ve.dm.modelRegistry = new ve.dm.ModelRegistry();
ve.dm.modelRegistry.registerExtensionSpecificType( /^mw:/ );

} )( ve );
