/**
 * VisualEditor AnnotationFactory class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */
( function ( ve ) {

/**
 * Factory for annotations.
 *
 * To register a new annotation type, call ve.dm.annotationFactory.register()
 *
 * @class
 * @abstract
 * @constructor
 * @extends {ve.EventEmitter}
 */
ve.dm.AnnotationFactory = function () {
	// Parent constructor
	ve.Factory.call( this );
	// [ { tagName: [annotationNamesWithoutFunc] }, { tagName: [annotationNamesWithFunc] } ]
	this.annotationsByTag = [ {}, {} ];
	// { matchFunctionPresence: { rdfaType: { tagName: [annotationNames] } } }
	// [ { rdfaType: { tagName: [annotationNamesWithoutFunc] } }, { rdfaType: { tagName: [annotationNamesWithFunc] } ]
	this.annotationsByTypeAndTag = [];
	// { nameA: 0, nameB: 1, ... }
	this.registrationOrder = {};
	this.nextNumber = 0;
};

/* Inheritance */

ve.inheritClass( ve.dm.AnnotationFactory, ve.Factory );

/* Private helper functions */

/**
 * Helper function for register(). Adds a value to the front of an array in a nested object.
 * Objects and arrays are created if needed. You can specify either two or three keys and a value.
 *
 * Specifically:
 * addType( obj, keyA, keyB, keyC, value ) does obj[keyA][keyB][keyC].unshift( value );
 * addType( obj, keyA, keyB, value ) does obj[keyA][keyB].unshift( value );
 *
 * @param {Object} obj Object to add to
 * @param {String} keyA Key into obj
 * @param {String} keyB Key into obj[keyA]
 * @param {String|any} keyC Key into obj[keyA][keyB], or value to add to array if value not set
 * @param {any} [value] Value to add to the array
 */
function addType( obj, keyA, keyB, keyC, value ) {
	if ( obj[keyA] === undefined ) {
		obj[keyA] = {};
	}
	if ( obj[keyA][keyB] === undefined ) {
		obj[keyA][keyB] = value === undefined ? [] : {};
	}
	if ( value !== undefined && obj[keyA][keyB][keyC] === undefined ) {
		obj[keyA][keyB][keyC] = [];
	}
	if ( value === undefined ) {
		obj[keyA][keyB].unshift( keyC );
	} else {
		obj[keyA][keyB][keyC].unshift( value );
	}
}

/* Public methods */

/**
 * Register an annotation type.
 * @param {String} name Symbolic name for the annotation
 * @param {ve.dm.Annotation} constructor Subclass of ve.dm.Annotation
 */
ve.dm.AnnotationFactory.prototype.register = function ( name, constructor ) {
	if ( typeof name !== 'string' || name === '' ) {
		throw new Error( 'Annotation names must be strings and must not be empty' );
	}
	// Call parent implementation
	ve.Factory.prototype.register.call( this, name, constructor );

	name = constructor.static.name;

	var i, j,
		tags = constructor.static.matchTagNames === null ?
			[ '' ] :
			constructor.static.matchTagNames,
		types = constructor.static.matchRdfaTypes === null ?
			[ '' ] :
			constructor.static.matchRdfaTypes;

	for ( i = 0; i < tags.length; i++ ) {
		// +!!foo is a shorter equivalent of Number( Boolean( foo ) ) or foo ? 1 ; 0
		addType( this.annotationsByTag, +!!constructor.static.matchFunction,
			tags[i], name
		);
	}
	for ( i = 0; i < types.length; i++ ) {
		for ( j = 0; j < tags.length; j++ ) {
			addType( this.annotationsByTypeAndTag,
				+!!constructor.static.matchFunction, types[i], tags[j], name
			);
		}
	}

	this.registrationOrder[name] = this.nextNumber++;
};

/**
 * Determine which annotation best matches the given element
 *
 * Annotation matching works as follows:
 * Get all annotations whose tag and rdfaType rules match
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
 * The highest-ranking annotation whose test function does not return false, wins.
 *
 * @param {HTMLElement} element Element to match
 * @returns {String|null} Annotation type, or null if none found
 */
ve.dm.AnnotationFactory.prototype.matchElement = function ( element ) {
	var i, name, ann, matches, winner, types,
		tag = element.nodeName.toLowerCase(),
		typeAttr = element.getAttribute( 'typeof' ) || element.getAttribute( 'rel' ),
		reg = this;

	function byRegistrationOrderDesc( a, b ) {
		return reg.registrationOrder[b] - reg.registrationOrder[a];
	}

	function matchWithFunc( types, tag ) {
		var i, j, matches, queue = [];
		for ( i = 0; i < types.length; i++ ) {
			matches = ve.getProp( reg.annotationsByTypeAndTag, 1, types[i], tag ) || [];
			for ( j = 0; j < matches.length; j++ ) {
				queue.push( matches[j] );
			}
		}
		queue.sort( byRegistrationOrderDesc );
		for ( i = 0; i < queue.length; i++ ) {
			if ( reg.registry[queue[i]].static.matchFunction( element ) ) {
				return queue[i];
			}
		}
		return null;
	}

	function matchWithoutFunc( types, tag ) {
		var i, j, matches, winningName = null;
		for ( i = 0; i < types.length; i++ ) {
			matches = ve.getProp( reg.annotationsByTypeAndTag, 0, types[i], tag ) || [];
			for ( j = 0; j < matches.length; j++ ) {
				if (
					winningName === null ||
					reg.registrationOrder[winningName] < reg.registrationOrder[matches[j]]
				) {
					winningName = matches[j];
				}
			}
		}
		return winningName;
	}

	types = typeAttr ? typeAttr.split( ' ' ) : [];
	if ( types.length ) {
		// func+tag+type match
		winner = matchWithFunc( types, tag );
		if ( winner !== null ) {
			return winner;
		}

		// func+type match
		// Only look at rules with no tag specified; if a rule does specify a tag, we've
		// either already processed it above, or the tag doesn't match
		winner = matchWithFunc( types, '' );
		if ( winner !== null ) {
			return winner;
		}
	}

	// func+tag match
	matches = ve.getProp( this.annotationsByTag, 1, tag ) || [];
	// No need to sort because individual arrays in annotadtionsByTag are already sorted
	// correctly
	for ( i = 0; i < matches.length; i++ ) {
		name = matches[i];
		ann = this.registry[name];
		// Only process this one if it doesn't specify types
		// If it does specify types, then we've either already processed it in the
		// func+tag+type step above, or its type rule doesn't match
		if ( ann.static.matchRdfaTypes === null && ann.static.matchFunction( element ) ) {
			return matches[i];
		}
	}

	// func only
	// We only need to get the [''][''] array because the other arrays were either
	// already processed during the steps above, or have a type or tag rule that doesn't
	// match this element.
	// No need to sort because individual arrays in annotationsByTypeAndTag are already sorted
	// correctly
	matches = ve.getProp( this.annotationsByTypeAndTag, 1, '', '' ) || [];
	for ( i = 0; i < matches.length; i++ ) {
		if ( this.registry[matches[i]].static.matchFunction( element ) ) {
			return matches[i];
		}
	}

	// tag+type
	winner = matchWithoutFunc( types, tag );
	if ( winner !== null ) {
		return winner;
	}

	// type only
	// Only look at rules with no tag specified; if a rule does specify a tag, we've
	// either already processed it above, or the tag doesn't match
	winner = matchWithoutFunc( types, '' );
	if ( winner !== null ) {
		return winner;
	}

	// tag only
	matches = ve.getProp( this.annotationsByTag, 0, tag ) || [];
	// No need to track winningName because the individual arrays in annotationsByTag are
	// already sorted correctly
	for ( i = 0; i < matches.length; i++ ) {
		name = matches[i];
		ann = this.registry[name];
		// Only process this one if it doesn't specify types
		// If it does specify types, then we've either already processed it in the
		// tag+type step above, or its type rule doesn't match
		if ( ann.static.matchRdfaTypes === null ) {
			return matches[i];
		}
	}

	// Rules with no type or tag specified
	// These are the only rules that can still qualify at this point, the others we've either
	// already processed or have a type or tag rule that disqualifies them
	matches = ve.getProp( this.annotationsByTypeAndTag, 0, '', '' ) || [];
	if ( matches.length > 0 ) {
		return matches[0];
	}

	// We didn't find anything, give up
	return null;
};

ve.dm.AnnotationFactory.prototype.createFromElement = function ( element ) {
	var name = this.matchElement( element );
	if ( name === null ) {
		return null;
	} else {
		return this.create( name, element );
	}
};

/* Initialization */

ve.dm.annotationFactory = new ve.dm.AnnotationFactory();

} )( ve );
